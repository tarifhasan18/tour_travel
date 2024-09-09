<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\CartReturnInfo;
use App\Models\CartItemReturn;
use App\Models\ConsumerLogin;
use App\Models\CustomerPayment;
use App\Models\CartInformtion;
use App\Models\CartItem;
use App\Models\BackofficeLogin;
use App\Models\FinalStockTable;
use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\TemporaryDamageReturnItem;
use App\Models\DamageReturnItem;
use App\Models\TemporaryCustomerDue;
use App\Models\salaryInfo;
use App\Models\SalaryDetails;
use App\Models\DailyTransactionInformation;
use App\Models\SiteSettings;
use App\Models\ExpenseDetail;
class ReturnController extends Controller
{
    public function index()
    {
        $site_settings = SiteSettings::first();
        $CartItemReturn = CartInformtion::select('cart_id', 'delivery_man.full_name', 'cart_date', 'final_total_amount','paid_amount' ,'due_amount')
                        ->join('backoffice_login as delivery_man', 'cart_informtion.waiter_id', '=', 'delivery_man.login_id')
                        ->where('is_closed', 0)
                        ->get();
        return view('dashboard.return.allReturn', compact(['CartItemReturn','site_settings']));
    }

    public function getAjaxProducts()
    {
        $products = Product::select('product_id','product_name')->get();
        return response()->json($products);
    }

    public function getAjaxAllCustomer()
    {
        $customer = ConsumerLogin::select('login_id','consumer_name')->get();
        return response()->json($customer);
    }

    public function getAjaxDamageItems($deliveryManId,$cartID)
    {
        $received_by_id = session()->get('LoggedUser');
        $damagedItems = TemporaryDamageReturnItem::select(
                'temporary_damage_return_items.damage_item_id',
                'products.product_name',
                'temporary_damage_return_items.quantity',
                'temporary_damage_return_items.rate',
                'temporary_damage_return_items.total'
            )
            ->join('products', 'temporary_damage_return_items.product_id', '=', 'products.product_id')
            ->where('temporary_damage_return_items.received_by_id', $received_by_id)
            ->where('temporary_damage_return_items.delivered_by_id', $deliveryManId)
            ->where('temporary_damage_return_items.cart_id', $cartID)
            ->get();
        return response()->json($damagedItems);
    }

    public function create()
    {
        // $ConsumerLogin = ConsumerLogin::all();
        $site_settings = SiteSettings::first();
        $ConsumerLogin = BackofficeLogin::where('role_id','=',6)->get();
        return view('dashboard.return.createReturn', compact(['ConsumerLogin','site_settings']));
    }

    public function store(Request $request)
    {
        // dd($request);
        DB::beginTransaction();

        try {
            // Handle return process
            $cart_info = CartInformtion::where('cart_id', $request->cart_id)->first();
            $is_closed = 0;
            $is_salary = $request->isSalaryAdjustable !== null ? 1 : 0;

            // Calculate due amounts
            $payable_amount = floatval($request->refundReceivableInput);
            $invoiceDueAmount = floatval($request->cart_invoice_due_input);
            $paid_amount = floatval($request->cashReceivableInput);
            $formInputDue = floatval($request->customerTotalDueInput) + floatval($request->totalDeliveryManDueInput);
            if($request->flag == 0)
            {
                $due = $payable_amount - $paid_amount;
                $final_paid_amount = $cart_info->paid_amount + $paid_amount;

                if ($formInputDue !== $due) {
                    //dd("payable amount:$payable_amount","paid amount:$paid_amount","inpt due sum:$formInputDue","calc due:$due");
                    return redirect()->route('create-return')->with('fail', 'Something went wrong, Due amounts does not match. failed to update.');
                }
            }

            if($request->flag == 1)
            {
                $due = $invoiceDueAmount - $paid_amount;
                $final_paid_amount = $cart_info->paid_amount + $paid_amount;
                $delivryManDue = floatval($request->totalDeliveryManDueInput);

                if ($delivryManDue !== $paid_amount) {
                    dd("deliv due:$request->totalDeliveryManDueInput","paid amount:$paid_amount");
                    return redirect()->route('create-return')->with('fail', 'Something went wrong, Due amounts does not match. failed to update.');
                }
            }



            if ($due == 0) {
                $is_closed = 1;
            }

            if($request->customerTotalDueInput > 0)
            {
                $is_closed = 2;
            }

            if ($request->flag == 1) {
                $cart_info->paid_amount = $final_paid_amount;
                $cart_info->due_amount = $due;
                $cart_info->is_closed = $is_closed;
                $update_status = $cart_info->update();

                $updateDeliveManDue = CartReturnInfo::where('cart_id', $request->cart_id)->first();
                $updateDeliveManDue->delivery_man_due = $updateDeliveManDue->delivery_man_due - $paid_amount;
                $update_status = $updateDeliveManDue->update();

                //Record transaction
                $transaction = new DailyTransactionInformation();
                $transaction->ref_id = $request->consumer_id;
                $transaction->daily_trx_type_id = 3;
                $transaction->income_amount = $final_paid_amount;
                $transaction->create_date = now();
                $update_status = $transaction->save();

                if ($update_status) {
                    DB::commit();
                    return redirect()->route('create-return')->with('success', 'Return Confirmed');
                } else {
                    throw new Exception('Failed to update cart info.');
                }
            }


            // Insert into cart return info table
            $received_by_id = session()->get('LoggedUser');
            //Insert into cart return info table
            $cart_return_info = new CartReturnInfo();
            $cart_return_info->login_id = $request->consumer_id;
            $cart_return_info->cart_id = $request->cart_id;
            $cart_return_info->cart_total_amount = $request->cart_invoice_amount_input;
            $cart_return_info->cart_total_item_quantity = $request->cart_invoice_qunatity_input;
            $cart_return_info->received_by_id = $received_by_id;
            $cart_return_info->total_return_qunatity = $request->returnCountInput;
            $cart_return_info->damage_return_quantity = $request->totalReturnedDamagedQuantityInput;
            $cart_return_info->new_total_amount = $request->refundReceivableInput;
            $cart_return_info->refund_amount = $request->returnAmountInput;
            $cart_return_info->damage_return_amount = $request->totalReturnedDamagedAmountInput;
            $cart_return_info->total_customer_due=$request->customerTotalDueInput;
            $cart_return_info->delivery_man_due=$request->totalDeliveryManDueInput;
            $cart_return_info->return_date = now();
            $save = $cart_return_info->save();

            if (!$save) {
                throw new Exception('Failed to save cart return info.');
            }

            $cart_return_id = $cart_return_info->cart_return_id;

            // Update cart info table
            $cart_info->total_cart_amount = $payable_amount;
            $cart_info->total_payable_amount = $payable_amount;
            $cart_info->final_total_amount = $payable_amount;
            $cart_info->paid_amount = $final_paid_amount;
            $cart_info->due_amount = $due;
            $cart_info->is_closed = $is_closed;
            $update_status = $cart_info->update();

            if (!$update_status) {
                throw new Exception('Failed to update cart info.');
            }

            //Record transaction
            $transaction = new DailyTransactionInformation();
            $transaction->ref_id = $request->cart_id;
            $transaction->daily_trx_type_id = 1;
            $transaction->income_amount = $final_paid_amount;
            $transaction->create_date = now();
            $update_status = $transaction->save();

            if (!$update_status) {
                throw new Exception('Failed to record transaction.');
            }

            // Iterate over the arrays and insert values into the database
            $profit = 0;
            $total_profit = 0;

            if (isset($request->cart_item_id) && is_array($request->cart_item_id)) {
                foreach ($request->cart_item_id as $key => $cartItemId) {
                    $return_quantity = $request->return_quantity[$key];
                    if ($return_quantity > 0) {
                        // Calculate the figures
                        $stock_id = $request->item_stock_id[$key];
                        $new_item_quantity = $request->sales_quantity[$key] - $return_quantity;
                        $old_invoice_total_amount = $request->sales_quantity[$key] * $request->item_sales_price[$key];
                        $return_items_value = $return_quantity * $request->item_sales_price[$key];
                        $new_invoice_amount = $new_item_quantity * $request->item_sales_price[$key];

                        $cartItemReturn = new CartItemReturn();
                        $cartItemReturn->cart_return_id = $cart_return_id;
                        $cartItemReturn->product_id = $request->item_product_id[$key];
                        $cartItemReturn->stock_id = $stock_id;
                        $cartItemReturn->cart_item_id = $cartItemId;
                        $cartItemReturn->invoice_quantity = $request->sales_quantity[$key];
                        $cartItemReturn->return_quantity = $return_quantity;
                        $cartItemReturn->new_invoice_quantity = $new_item_quantity;
                        $cartItemReturn->unit_sales_cost = $request->item_sales_price[$key];
                        $cartItemReturn->invoice_toatl_amount = $old_invoice_total_amount;
                        $cartItemReturn->total_return_amount = $return_items_value;
                        $cartItemReturn->new_invoice_amount = $new_invoice_amount;
                        $cartItemReturn->cerate_date=now();
                        $update_status = $cartItemReturn->save();

                        if (!$update_status) {
                            throw new Exception('Failed to save return item.');
                        }

                        // Update cart items
                        $cart_items = CartItem::where('cart_item_id', $cartItemId)->first();
                        $cart_items->quantity = $new_item_quantity;
                        $cart_items->total_price = $new_invoice_amount;
                        $cart_items->net_amount = $new_invoice_amount;
                        $cartItemUpdate = $cart_items->update();

                        if (!$cartItemUpdate) {
                            throw new Exception('Failed to update invoice item information.');
                        }

                        // Calculate profit
                        $purchase_price = $cart_items->unit_purchase_cost;
                        $sales_price = $cart_items->unit_sales_cost;
                        $profit_margin = $sales_price - $purchase_price;
                        $profit = $profit_margin * $new_item_quantity;
                        $total_profit += $profit;

                        // Update purchase details and final stock table to update stock
                        $stockDetails = FinalStockTable::where('stock_id', $stock_id)->first();
                        $stockDetails->total_sold_quantity -= $return_quantity;
                        $stockDetails->temp_quantity += $return_quantity;
                        $stockDetails->final_quantity += $return_quantity;
                        $update_status = $stockDetails->update();

                        if (!$update_status) {
                            throw new Exception('Failed to update stock information.');
                        }
                    }
                }
            }

            // Update cart information with profit calculation
            $cart_info->gross_profit -= $total_profit;
            $cart_info->net_profit -= $total_profit;
            $update_status = $cart_info->update();

            if (!$update_status) {
                throw new Exception('Failed to update cart profit.');
            }

            // Handle damage items entry
            $damaged = TemporaryDamageReturnItem::where('received_by_id', $received_by_id)
                ->where('delivered_by_id', $request->consumer_id)
                ->where('cart_id', $request->cart_id)
                ->get();

            foreach ($damaged as $item) {
                $DamagedItems = new DamageReturnItem();
                $DamagedItems->cart_return_id = $cart_return_id;
                $DamagedItems->cart_id = $item->cart_id ;
                $DamagedItems->product_id= $item->product_id ;
                $DamagedItems->quantity= $item->quantity ;
                $DamagedItems->rate= $item->rate ;
                $DamagedItems->total= $item->total ;
                $DamagedItems->received_by_id= $item->received_by_id ;
                $DamagedItems->delivered_by_id= $item->delivered_by_id ;
                $DamagedItems->create_date= now() ;
                $save_status = $DamagedItems->save();

                if(!$save_status)
                {
                    return redirect()->route('all-return')->with('fail', 'Something went wrong, failed to save DAMAGE ITEM RETURN.');
                }
            }


            TemporaryDamageReturnItem::where('received_by_id', $received_by_id)
                ->where('delivered_by_id', $request->consumer_id)
                ->where('cart_id', $request->cart_id)
                ->delete();

            // Update customer due information
            $customerDues = TemporaryCustomerDue::where('cart_id', $request->cart_id)
                ->where('delivery_man_id', $request->consumer_id)
                ->where('received_by_id', $received_by_id)
                ->get();

            if ($customerDues) {
                foreach ($customerDues as $dues) {
                    $customer = ConsumerLogin::where('login_id', $dues->customer_id)->first();
                    $previousDue = $customer->customer_due;
                    $customer->customer_due = $previousDue + $dues->amount;
                    $customer->final_receivable = $customer->customer_due - $customer->total_collection;
                    $status = $customer->update();

                    if (!$status) {
                        throw new Exception('Failed to update customer due.');
                    }

                    $customer_payment = new CustomerPayment();
                    $customer_payment->customer_id = $dues->customer_id;
                    $customer_payment->cart_id = $request->cart_id;
                    $customer_payment->due_amount = $dues->amount;
                    $customer_payment->paid_amount = 0;
                    $customer_payment->balance = $dues->amount;
                    $status = $customer_payment->save();

                    if (!$status) {
                        throw new Exception('Failed to save customer payment.');
                    }
                }

                TemporaryCustomerDue::where('cart_id', $request->cart_id)
                    ->where('delivery_man_id', $request->consumer_id)
                    ->where('received_by_id', $received_by_id)
                    ->delete();
            }

            // Update salary and add expense
            if ($is_salary)
            {
                $salaryInfo = salaryInfo::where('back_office_login_id', $request->consumer_id)->first();
                $salaryInfo->paid += $request->deliveryManDueAmount;
                if ($salaryInfo->due > 0) {
                    $salaryInfo->due -= $request->deliveryManDueAmount;
                }
                $salaryInfo->update();

                $postSalaryDetails = new SalaryDetails([
                    'salary_info_id' => $salaryInfo->salary_info_id,
                    'pay_date' => now(),
                    'paid_for_month' => "Salary adjusted from Invoice no- " . $request->cart_id,
                    'description' => "Salary adjusted from Invoice no- " . $request->cart_id,
                    'paid_amount' => $request->deliveryManDueAmount,
                ]);
                $postSalaryDetails->save();

                $get_details = new ExpenseDetail;
                $get_details->expense_cat_id = 3;
                $get_details->amount = $request->deliveryManDueAmount;
                $get_details->notes = "Salary adjusted from Invoice no- " . $request->cart_id;
                $get_details->created_by = $received_by_id;
                $get_details->save();

                //Record transaction
                $transaction = new DailyTransactionInformation();
                $transaction->ref_id = $request->consumer_id;
                $transaction->daily_trx_type_id = 6;
                $transaction->expense_amount = $request->deliveryManDueAmount;
                $transaction->create_date = now();
                $update_status = $transaction->save();

                if (!$update_status) {
                    throw new Exception('Failed to record transaction.');
                }
            }
            DB::commit();
            return redirect()->route('create-return')->with('success', 'Return Confirmed');
        }
        catch (\Exception $e)
        {
            DB::rollBack();
            return redirect()->route('create-return')->with('fail', 'Something went wrong, failed to register. Error: ' . $e->getMessage());
        }
    }

    public function storeDamage($cart_id,$product_id,$quantity,$rate,$deliveryManId)
    {
        $received_by_id = session()->get('LoggedUser');

        $temporaryReturnItem = new TemporaryDamageReturnItem();
        $temporaryReturnItem->cart_id = $cart_id;
        $temporaryReturnItem->product_id = $product_id;
        $temporaryReturnItem->quantity = $quantity;
        $temporaryReturnItem->rate = $rate;
        $temporaryReturnItem->total = $quantity*$rate;
        $temporaryReturnItem->received_by_id = $received_by_id;
        $temporaryReturnItem->delivered_by_id = $deliveryManId;
        $save_status = $temporaryReturnItem->save();

        if ($save_status) {
            return response()->json([
                'status' => true,
                'new_id'=>$temporaryReturnItem->damage_item_id,
                'message' => 'Data saved.'
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Data not saved.'
            ]);
        }
    }

    public function storeCustomerDue($cart_id,$customer_id,$amount,$deliveryManID)
    {
        $received_by_id = session()->get('LoggedUser');

        $temporaryReturnItem = new TemporaryCustomerDue;
        $temporaryReturnItem->cart_id = $cart_id;
        $temporaryReturnItem->delivery_man_id = $deliveryManID;
        $temporaryReturnItem->customer_id = $customer_id;
        $temporaryReturnItem->amount = $amount;
        $temporaryReturnItem->received_by_id = $received_by_id;
        $save_status = $temporaryReturnItem->save();

        if ($save_status) {
            return response()->json([
                'status' => true,
                'message' => 'Data saved.'
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Data not saved.'
            ]);
        }
    }

    public function getAjaxDueItems($deliveryManId,$cartID)
    {
        $received_by_id = session()->get('LoggedUser');
        $tempCusDue = TemporaryCustomerDue::join('consumer_login', 'consumer_login.login_id', '=', 'temporary_customer_due.customer_id')
                ->select('due_id','consumer_login.consumer_name','temporary_customer_due.amount')
                ->where('temporary_customer_due.cart_id','=',$cartID)
                ->where('temporary_customer_due.delivery_man_id','=',$deliveryManId)
                ->where('temporary_customer_due.received_by_id','=',$received_by_id)
                ->get();
        return response()->json($tempCusDue);
    }

    public function deleteTempDamageReturnItem($temp_item_id)
    {
        $deleteStatus = TemporaryDamageReturnItem::where('damage_item_id', $temp_item_id)->delete();
        if ($deleteStatus) {
            return response()->json([
                'status' => true,
                'message' => 'Data removed.'
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Data remove failed.'
            ]);
        }
    }

    public function deleteTempDueItem($temp_item_id)
    {
        $deleteStatus = TemporaryCustomerDue::where('due_id', $temp_item_id)->delete();
        if ($deleteStatus) {
            return response()->json([
                'status' => true,
                'message' => 'Data removed.'
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Data remove failed.'
            ]);
        }
    }

    public function view($id)
    {
        $cart_item_return_id = Crypt::decryptString($id);

        $CartItemReturn = CartItemReturn::join('consumer_login', 'consumer_login.login_id', '=', 'cart_item_return.login_id')
            ->where('cart_item_return.cart_item_return_id', $cart_item_return_id)
            ->select('cart_item_return.*', 'consumer_login.mobile_no')
            ->get();

        foreach ($CartItemReturn as $Item) {
            $items = explode(',', $Item->cart_item_id);
        }

        $size = sizeof($items);

        for ($i = 0; $i < $size; $i = $i + 1) {
            $CartItems[$i] = CartItem::join('products', 'products.product_id', '=', 'cart_items.product_id')
                ->where('cart_item_id', $items[$i])
                ->select('cart_items.*', 'products.*')
                ->get();
        }

        $login_id = session()->get('LoggedUser');
        $backofficeLogin = BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('backoffice_login.login_id', $login_id)
            ->select('backoffice_login.*', 'backoffice_role.*')
            ->get();

        return view('dashboard.return.viewReturn', compact(['CartItemReturn', 'backofficeLogin', 'CartItems']));
    }

    public function completedReturns()
    {
        $site_settings = SiteSettings::first();
        $CartItemReturn = CartReturnInfo::select('cart_id', 'delivery_man.full_name', DB::raw("DATE_FORMAT(return_date, '%d/%m/%Y') AS return_date"),
                            'cart_total_item_quantity', 'cart_total_amount', 'total_return_qunatity', 'refund_amount', 'new_total_amount')
                        ->join('backoffice_login as delivery_man', 'cart_return_info.login_id', '=', 'delivery_man.login_id')
                        ->orderBy('cart_return_id', 'DESC')
                        ->get();
        return view('dashboard.return.completedReturn', compact(['CartItemReturn','site_settings']));
    }

    public function Authorization($id, $authorize_status)
    {
        $cart_item_return_id = Crypt::decryptString($id);
        $login_id = session()->get('LoggedUser');

        $CartItemReturn = CartItemReturn::where('cart_item_return_id', $cart_item_return_id)->first();
        $CartItemReturn->return_status = $authorize_status;
        $CartItemReturn->authorized_by = $login_id;
        $CartItemReturn->authorize_date = Carbon::now();
        $CartItemReturn->save();

        $CartItemReturnNew = CartItemReturn::join('cart_informtion', 'cart_informtion.cart_id', '=', 'cart_item_return.cart_id')
            ->join('cart_items', 'cart_items.cart_id', '=', 'cart_informtion.cart_id')
            ->where('cart_item_return_id', $cart_item_return_id)
            ->select('cart_items.quantity', 'cart_items.stock_id', 'cart_items.cart_item_id', 'cart_items.product_id')
            ->get();

        foreach ($CartItemReturnNew as $ItemReturn) {
            $updateQuantity = FinalStockTable::where('product_id', $ItemReturn->product_id)
                ->where('stock_id', $ItemReturn->stock_id)
                ->first();
            $updateQuantity->total_sold_quantity = $updateQuantity->total_sold_quantity - $ItemReturn->quantity;
            $updateQuantity->temp_quantity = $updateQuantity->temp_quantity + $ItemReturn->quantity;
            $updateQuantity->final_quantity = $updateQuantity->final_quantity + $ItemReturn->quantity;
            $updateQuantity->save();
        }

        return redirect()->back()->with('success', 'Authorized Successfully !!');
    }

    public function getReturnCart($id)
    {
        $consumer_id = $id;

        $CartInformation = CartInformtion::select('cart_id', DB::raw("DATE(cart_date) as cart_date"))
                    ->where('waiter_id', $consumer_id)
                    ->whereIn('is_closed', ['0', '2'])
                    ->get();

        return response()->json($CartInformation);
    }

    public function getReturnItem($id)
    {
        $login_id = session()->get('LoggedUser');
        $cart_id = $id;
        $CartItem = CartItem::join('products', 'products.product_id', '=', 'cart_items.product_id')
            ->where('cart_items.cart_id', $cart_id)
            ->select('cart_items.*', 'products.product_name')
            ->get();
        $cartInfo = CartInformtion::where('cart_id', $id)->first();
        // $cartReturnInfo = CartReturnInfo::where('cart_id','=',$cart_id)->select('cart_total_amount','cart_total_item_quantity','total_return_qunatity',
        // 'damage_return_quantity','refund_amount','damage_return_amount','total_customer_due','delivery_man_due')->first();
        $cartReturnInfo = CartReturnInfo::where('cart_id','=',$cart_id)->first();
        // $tempCustDue = TemporaryCustomerDue::where('cart_id', $cart_id)->where('received_by_id','=',$login_id)->selectRaw('SUM(amount) as total_amount')->first();
        // $totalAmount = $tempCustDue->total_amount;

        // $tempDamReturn = TemporaryDamageReturnItem::where('cart_id', $cart_id)->where('received_by_id','=',$login_id)->selectRaw('SUM(total) as total_sum')->selectRaw('SUM(quantity) as total_qty')->first();
        // $totalSum = $tempDamReturn->total_sum;
        // $totalDQty = $tempDamReturn->total_qty;


        return response()->json(
            [
                "cartInfo" => $cartInfo,
                "CartItem" => $CartItem,
                "CartReturnInfo" => $cartReturnInfo,
                // "totalAmount"=>$totalAmount,
                // "totalSum" => $totalSum,
                // "totalDQty" => $totalDQty
            ]
        );
    }

    // public function recivedToWarehouse($id)
    // {
    //     $cart_item_return_id = Crypt::decryptString($id);

    //     $CartItemReturn = CartItemReturn::join('cart_informtion', 'cart_informtion.cart_id', '=', 'cart_item_return.cart_id')
    //         ->join('cart_items', 'cart_items.cart_id', '=', 'cart_informtion.cart_id')
    //         ->where('cart_item_return_id', $cart_item_return_id)
    //         ->select('cart_items.quantity', 'cart_items.stock_id', 'cart_items.product_id')
    //         ->get();

    //     foreach ($CartItemReturn as $ItemReturn) {
    //         $updateQuantity = FinalStockTable::where('product_id', $ItemReturn->product_id)->first();
    //         $updateQuantity->total_sold_quantity = $updateQuantity->total_sold_quantity - $ItemReturn->quantity;
    //         $updateQuantity->temp_quantity = $updateQuantity->temp_quantity + $ItemReturn->quantity;
    //         $updateQuantity->final_quantity = $updateQuantity->final_quantity + $ItemReturn->quantity;
    //         $updateQuantity->save();
    //     }

    //     $CartItemReturnStatus = CartItemReturn::where('cart_item_return_id', $cart_item_return_id)->first();
    //     $CartItemReturnStatus->return_status = 4;
    //     $CartItemReturnStatus->save();

    //     return redirect()->back()->with('success', 'Received Successfully !!');
    // }

    public function destroy($id)
    {
        //
    }
}
