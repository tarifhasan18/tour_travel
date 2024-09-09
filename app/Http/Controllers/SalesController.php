<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BackofficeLogin;
use App\Models\Bank;
use App\Models\BankTransaction;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Models\ConsumerLogin;
use App\Models\Product;
use App\Models\CartTemporary;
use App\Models\CartTemporaryItem;
use App\Models\CartTemporaryPayment;
use App\Models\CartInformtion;
use App\Models\CartItem;
use App\Models\CustomerPayment;
use App\Models\FinalStockTable;
use App\Models\PurchaseDetail;
use App\Models\PurchaseInfo;
use App\Models\SiteSettings;
use App\Models\SubCategoryOne;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class SalesController extends Controller
{
    //--------- Fetch Sales Form ----------
    public function index()
    {
        $site_settings = SiteSettings::first();
        return view('sales/salesForm',compact('site_settings'));
    }

    //-------- Fetch All categery with Ajax---------
    public function getAjaxCategory()
    {
        $ProductCategory = ProductCategory::where('is_active', 1)->get();
        return response()->json($ProductCategory);
    }

    //-------- Fetch All delivery man with Ajax---------
    public function getAjaxDelivery()
    {
        $delivery_man = BackofficeLogin::where('role_id', 6)->get();
        return response()->json($delivery_man);
    }

    //--------Fetch Category Wise Items With Ajax ----------
    public function salesCategoryWiseItems($id)
    {
        $SalesProducts = SubCategoryOne::join('products', 'products.sc_one_id', '=', 'sub_category_one.sc_one_id')
            ->Join('purchase_details', 'purchase_details.product_id', '=', 'products.product_id')
            ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'purchase_details.stock_id')
            ->leftJoin('stores', 'stores.store_id', '=', 'final_stock_table.store_id')
            ->where('products.sc_one_id', '=', $id)
            ->where('products.is_active', 1)
            ->where('final_stock_table.final_quantity', '>', 0)
            ->select(
                'products.product_name',
                'purchase_details.purchase_id',
                'purchase_details.purchase_details_id',
                'products.product_id',
                'final_stock_table.final_quantity',
                'final_stock_table.stock_id',
                'stores.store_name',
                'purchase_details.sales_price',
                'purchase_details.wholesale_price'
            )
            ->get();
        return response()->json($SalesProducts);
    }

    public function salesBarcodeWiseItems($id)

    {
        $SalesProducts = SubCategoryOne::join('products', 'products.sc_one_id', '=', 'sub_category_one.sc_one_id')
            ->Join('purchase_details', 'purchase_details.product_id', '=', 'products.product_id')
            ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'purchase_details.stock_id')
            ->leftJoin('stores', 'stores.store_id', '=', 'final_stock_table.store_id')
            ->where('products.barcode', '=', $id)
            ->where('products.is_active', 1)
            ->where('final_stock_table.final_quantity', '>', 0)
            ->select(
                'products.product_name',
                'purchase_details.purchase_id',
                'purchase_details.purchase_details_id',
                'products.product_id',
                'final_stock_table.final_quantity',
                'final_stock_table.stock_id',
                'stores.store_name',
                'purchase_details.sales_price',
                'purchase_details.wholesale_price'
            )
            ->get();
        return response()->json($SalesProducts);
    }

    //-------- Insert Data To temp Cart ------------
    public function addSalesItemToTempCart(Request $request)
    {
        $purchase_details_id = $request->purchase_details_id;
        $sales_type = $request->sales_type;
        $stock_id = $request->stock_id;
        $product_id = $request->product_id;
        $msg = $request->msg;
        $purchase_details_id = $request->purchase_details_id;
        $temp_cart_id = $request->temp_cart_id;

        $products = PurchaseDetail::join('final_stock_table', 'final_stock_table.stock_id', '=', 'purchase_details.stock_id')
            ->where('purchase_details.purchase_details_id', $purchase_details_id)
            ->where('final_stock_table.stock_id', $stock_id)
            ->select('purchase_details.*', 'final_stock_table.final_quantity')
            ->first();

        if ($products->final_quantity <= 0) {
            return response()->json(
                [
                    'stock_error' => true,
                    'message' => 'Product is not in stock !!',
                    'in_stock' => $products->final_quantity,
                ],
                200
            );
        }

        if ($msg == "false") {

            if (!$request->session()->has("Temp_Consumer_ID")) {
                $request->session()->put('Temp_Consumer_ID', $this->random_strings(5));
            }
            if (!$request->session()->has("From_Ip")) {
                $request->session()->put('From_Ip', $request->ip());
            }

            $created_by = Auth::id();
            $from_ip = $request->session()->get('From_Ip');
            $temporary_consumer_id = $request->session()->get('Temp_Consumer_ID');
            $temp_cart_date = Carbon::now();

            $cart_temporary = new CartTemporary();
            $cart_temporary->temporary_consumer_id = $temporary_consumer_id;
            $cart_temporary->create_date = $temp_cart_date;
            $cart_temporary->from_ip = $from_ip;
            $cart_temporary->created_by = $created_by;
            $cart_temporary->is_suspended = 0;
            $cart_temporary->save();

            $cart_temporary_items = new CartTemporaryItem();
            $cart_temporary_items->temp_cart_id = $cart_temporary->temp_cart_id;
            $cart_temporary_items->product_id = $products->product_id;
            $cart_temporary_items->stock_id = $products->stock_id;
            $cart_temporary_items->quantity = 1;
            $cart_temporary_items->vat = (($products->vat) / ($products->quantity)) * ($cart_temporary_items->quantity);
            $cart_temporary_items->total_discount = 0;
            if ($sales_type == 1) {
                $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->sales_price));
            } else if ($sales_type == 2) {
                $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->wholesale_price));
            }

            $cart_temporary_items->save();
           

            $cart_temporary_data = SalesFormDataHelper($cart_temporary->temp_cart_id);
            $transaction_data = SalesFormTransactionHelper($cart_temporary_data);
            return response()->json([
                'status' => true,
                'success' => 'Product Added to Cart',
                'transaction_data' => $transaction_data,
                'cart_temporary_data' => $cart_temporary_data,
                'sales_type' => $sales_type
            ], 200);
        } else {
            $temp_cart_check = CartTemporary::join('cart_temporary_items', 'cart_temporary_items.temp_cart_id', '=', 'cart_temporary.temp_cart_id')
                ->join('products', 'products.product_id', '=', 'cart_temporary_items.product_id')
                ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_temporary_items.stock_id')
                ->where('cart_temporary.temp_cart_id', '=', $msg)
                ->where('cart_temporary_items.product_id', '=', $product_id)
                ->where('final_stock_table.stock_id', '=', $stock_id)
                ->exists();
            if ($temp_cart_check) {
                $cart_temporary_items = CartTemporaryItem::join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_temporary_items.stock_id')
                    ->where('cart_temporary_items.temp_cart_id', '=', $msg)
                    ->where('cart_temporary_items.product_id', '=', $product_id)
                    ->where('cart_temporary_items.stock_id', '=', $stock_id)
                    ->select('cart_temporary_items.*')
                    ->first();

                $cart_temporary_items->quantity = ($cart_temporary_items->quantity) + 1;
                $cart_temporary_items->vat = (($products->vat) / ($products->quantity)) * ($cart_temporary_items->quantity);
                if ($sales_type == 1) {
                    $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->sales_price));
                } else if ($sales_type == 2) {
                    $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->wholesale_price));
                }
                $cart_temporary_items->update();

                $cart_temporary_data = SalesFormDataHelper($msg);
                $transaction_data = SalesFormTransactionHelper($cart_temporary_data);

                return response()->json([
                    'status' => true,
                    'success' => 'Product Added to Cart',
                    'transaction_data' => $transaction_data,
                    'cart_temporary_data' => $cart_temporary_data,
                    'sales_type' => $sales_type
                ], 200);
            } else {

                $cart_temporary_items = new CartTemporaryItem();
                $cart_temporary_items->temp_cart_id = $msg;
                $cart_temporary_items->product_id = $products->product_id;
                $cart_temporary_items->stock_id = $products->stock_id;
                $cart_temporary_items->quantity = 1;
                $cart_temporary_items->vat = (($products->vat) / ($products->quantity)) * ($cart_temporary_items->quantity);
                $cart_temporary_items->total_discount = 0;
                if ($sales_type == 1) {
                    $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->sales_price));
                } else if ($sales_type == 2) {
                    $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->wholesale_price));
                }
                $cart_temporary_items->save();

                $cart_temporary_data = SalesFormDataHelper($msg);
                $transaction_data = SalesFormTransactionHelper($cart_temporary_data);

                return response()->json([
                    'status' => true,
                    'success' => 'Product Added to Cart',
                    'transaction_data' => $transaction_data,
                    'cart_temporary_data' => $cart_temporary_data,
                    'sales_type' => $sales_type
                ], 200);
            }
        }
    }

    //-------- Insert Data To temp Cart With barcode------------
    public function addSalesItemsWithBarcode(Request $request, $barcode, $msg, $sales_type)
    {
        $barcode = $barcode;
        $products = PurchaseDetail::join('products', 'products.product_id', '=', 'purchase_details.product_id')
            ->where('purchase_details.barcode', $barcode)
            ->select(
                'products.product_id',
                'purchase_details.purchase_id',
                'purchase_details.purchase_details_id',
                'purchase_details.vat',
                'purchase_details.sales_price',
                'purchase_details.wholesale_price',
                'purchase_details.quantity',
                'purchase_details.stock_id'
            )
            ->first();

        if (!$products) {
            return response()->json(
                [
                    "barcode_error" => true,
                    "message" => "Barcode Not Found",
                ],
                200
            );
        }

        $purchase_id = $products->purchase_id;

        if ($msg == "false") {

            if (!$request->session()->has("Temp_Consumer_ID")) {
                $request->session()->put('Temp_Consumer_ID', $this->random_strings(5));
            }
            if (!$request->session()->has("From_Ip")) {
                $request->session()->put('From_Ip', $request->ip());
            }

            // return $request->session()->pull('Temp_Consumer_ID');

            $created_by = session()->get('LoggedUser');
            $from_ip = $request->session()->get('From_Ip');
            $temporary_consumer_id = $request->session()->get('Temp_Consumer_ID');
            $temp_cart_date = Carbon::now();

            $cart_temporary = new CartTemporary();
            $cart_temporary->temporary_consumer_id = $temporary_consumer_id;
            $cart_temporary->create_date = $temp_cart_date;
            $cart_temporary->from_ip = $from_ip;
            $cart_temporary->created_by = $created_by;
            $cart_temporary->is_suspended = 0;
            $cart_temporary->save();

            $cart_temporary_items = new CartTemporaryItem();
            $cart_temporary_items->temp_cart_id = $cart_temporary->temp_cart_id;
            $cart_temporary_items->product_id = $products->product_id;
            $cart_temporary_items->stock_id = $products->stock_id;
            $cart_temporary_items->quantity = 1;
            $cart_temporary_items->vat = (($products->vat) / ($products->quantity)) * ($cart_temporary_items->quantity);
            $cart_temporary_items->total_discount = 0;
            if ($sales_type == 1) {
                $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->sales_price));
            } else if ($sales_type == 2) {
                $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->wholesale_price));
            }

            $cart_temporary_items->save();

            $cart_temporary_data = SalesFormDataHelper($cart_temporary->temp_cart_id);
            $transaction_data = SalesFormTransactionHelper($cart_temporary_data);

            return response()->json([
                'status' => true,
                'success' => 'Product Added to Cart',
                'transaction_data' => $transaction_data,
                'cart_temporary_data' => $cart_temporary_data,
                'sales_type' => $sales_type
            ], 200);
            return response()->json("false");
        } else {
            $temp_cart_check = CartTemporary::join('cart_temporary_items', 'cart_temporary_items.temp_cart_id', '=', 'cart_temporary.temp_cart_id')
                ->join('products', 'products.product_id', '=', 'cart_temporary_items.product_id')
                ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_temporary_items.stock_id')
                ->where('cart_temporary.temp_cart_id', '=', $msg)
                ->where('cart_temporary_items.product_id', '=', $products->product_id)
                ->where('cart_temporary_items.stock_id', '=', $products->stock_id)
                ->exists();

            if ($temp_cart_check) {

                $cart_temporary_items = CartTemporaryItem::join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_temporary_items.stock_id')
                    ->where('cart_temporary_items.temp_cart_id', '=', $msg)
                    ->where('cart_temporary_items.product_id', '=', $products->product_id)
                    ->where('cart_temporary_items.stock_id', '=', $products->stock_id)
                    ->select('cart_temporary_items.*')
                    ->first();


                $cart_temporary_items->quantity = ($cart_temporary_items->quantity) + 1;
                $cart_temporary_items->vat = (($products->vat) / ($products->quantity)) * ($cart_temporary_items->quantity);
                if ($sales_type == 1) {
                    $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->sales_price));
                } else if ($sales_type == 2) {
                    $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->wholesale_price));
                }
                $cart_temporary_items->update();

                $cart_temporary_data = SalesFormDataHelper($msg);
                $transaction_data = SalesFormTransactionHelper($cart_temporary_data);

                return response()->json([
                    'status' => true,
                    'success' => 'Product Added to Cart',
                    'transaction_data' => $transaction_data,
                    'cart_temporary_data' => $cart_temporary_data,
                    'sales_type' => $sales_type
                ], 200);
            } else {

                $cart_temporary_items = new CartTemporaryItem();
                $cart_temporary_items->temp_cart_id = $msg;
                $cart_temporary_items->product_id = $products->product_id;
                $cart_temporary_items->stock_id = $products->stock_id;
                $cart_temporary_items->quantity = 1;
                $cart_temporary_items->vat = (($products->vat) / ($products->quantity)) * ($cart_temporary_items->quantity);
                $cart_temporary_items->total_discount = 0;
                if ($sales_type == 1) {
                    $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->sales_price));
                } else if ($sales_type == 2) {
                    $cart_temporary_items->temp_net_amount = (($cart_temporary_items->quantity) * ($products->wholesale_price));
                }
                $cart_temporary_items->save();

                $cart_temporary_data = SalesFormDataHelper($msg);
                $transaction_data = SalesFormTransactionHelper($cart_temporary_data);

                return response()->json([
                    'status' => true,
                    'success' => 'Product Added to Cart',
                    'transaction_data' => $transaction_data,
                    'cart_temporary_data' => $cart_temporary_data,
                    'sales_type' => $sales_type
                ], 200);
            }
        }
    }

    //-------- Fetch Temp Cart Data On Reload---------
    public function salesTempCartData($id, $sales_type)
    {
        $login_id = $id;
        $cart_temporary_data = CartTemporary::join('cart_temporary_items', 'cart_temporary_items.temp_cart_id', '=', 'cart_temporary.temp_cart_id')
            ->join('products', 'products.product_id', '=', 'cart_temporary_items.product_id')
            ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_temporary_items.stock_id')
            ->where('cart_temporary.created_by', '=', $login_id)
            ->where('cart_temporary.is_suspended','=',0)
            ->select(
                'cart_temporary_items.*',
                'cart_temporary.*',
                'products.product_id',
                'products.sc_one_id',
                'products.product_name',
                'final_stock_table.sales_price',
                'final_stock_table.wholesale_price',
                'final_stock_table.purchase_id',
                'final_stock_table.temp_quantity',
                'products.unit_type',
                'products.image_path',
                'products.product_image',
                'products.sku_no',
                'products.is_active'
            )
            ->get();
        $items = $cart_temporary_data->count();
        $total = 0;
        $temp_cart_id = $cart_temporary_data[0]->temp_cart_id;
        $total_temp_net_amount = $cart_temporary_data->sum('temp_net_amount');
        $total_total_discount = $cart_temporary_data->sum('total_discount');
        $total_quantity = $cart_temporary_data->sum('quantity');
        $total_vat = $cart_temporary_data->sum('vat');
        $total = $total_temp_net_amount - $total_total_discount + $total_vat;
        $paid_amount = 0;
        $due_amount = $total;

        $transaction_data = array('temp_cart_id' => $temp_cart_id, 'quantity' => $total_quantity, 'items' => $items, 'subtotal' => $total_temp_net_amount,'total_payable' => $total,
                                   'discount_amount' => $total_total_discount,  'paid_amount' => $paid_amount,'due_amount' => $due_amount, 'vat' => $total_vat);


        $IsPaymentExists = CartTemporaryPayment::where('cart_temporary_id', $temp_cart_id)->exists();
        $TempPaymentdata = CartTemporaryPayment::where('cart_temporary_id', $temp_cart_id)->first();

        return response()->json([
            'status' => true,
            'success' => 'Product Added to Cart',
            'transaction_data' => $transaction_data,
            'cart_temporary_data' => $cart_temporary_data,
            'IsPaymentExists' => $IsPaymentExists,
            'TempPaymentdata' => $TempPaymentdata,
            'sales_type' => $sales_type
        ], 200);
    }

    //-------- Adjust Price On Sales Type Change---------
    public function salesTypeWisePrice($id, $msg)
    {
        $temp_cart = CartTemporaryItem::where('temp_cart_id', $msg)->get();

        if ($id == 1) {
            foreach ($temp_cart as $data) {
                $purchase = PurchaseDetail::where('stock_id', $data->stock_id)->first();
                $data->temp_net_amount = ($data->quantity) * ($purchase->sales_price);
                $data->vat = ($data->quantity) * (($purchase->vat) / ($purchase->quantity));
                $data->update();
            }
        } elseif ($id == 2) {
            foreach ($temp_cart as $data) {
                $purchase = PurchaseDetail::where('stock_id', $data->stock_id)->first();
                $data->temp_net_amount = ($data->quantity) * ($purchase->wholesale_price);
                $data->vat = ($data->quantity) * (($purchase->vat) / ($purchase->quantity));
                $data->update();
            }
        }

        $cart_temporary_data = SalesFormDataHelper($msg);
        $transaction_data = SalesFormTransactionHelper($cart_temporary_data);

        return response()->json(
            [
                'status' => true,
                'transaction_data' => $transaction_data,
                'cart_temporary_data' => $cart_temporary_data,
                'sales_type' => $id,
            ],
            200
        );
    }

    //-------- Adjust Price On Sales Quantity Change---------
    public function priceCalculation($id, $qty, $sales_price, $sales_type)
    {
        $temp_cart_item_id = $id;
        $CartTemporaryItem = CartTemporaryItem::where('temp_cart_item_id', $temp_cart_item_id)->first();

        $productData = PurchaseDetail::where('stock_id', $CartTemporaryItem->stock_id)->first();

        $CartTemporaryItem->quantity = $qty;
        $CartTemporaryItem->vat = (($productData->vat) / ($productData->quantity)) * $qty;
        $CartTemporaryItem->temp_net_amount = $sales_price * $qty;
        $CartTemporaryItem->update();

        $cart_temporary_data = SalesFormDataHelper($CartTemporaryItem->temp_cart_id);
        $transaction_data = SalesFormTransactionHelper($cart_temporary_data);

        return response()->json([
            'status' => true,
            'success' => 'Product Added to Cart',
            'transaction_data' => $transaction_data,
            'cart_temporary_data' => $cart_temporary_data,
            'sales_type' => $sales_type,
            'cart_temporary_item' => $CartTemporaryItem
        ], 200);
    }

    //-------- Delete Temp Cart ---------
    public function destroyTempCart($id, $sales_type)
    {
        $CartTemporaryItem = CartTemporaryItem::where('temp_cart_item_id', $id)->first();
        $CartTemporaryItem->delete();

        $cart_temporary_data = SalesFormDataHelper($CartTemporaryItem->temp_cart_id);

        $transaction_data = SalesFormTransactionHelper($cart_temporary_data);

        return response()->json([
            'status' => true,
            'success' => 'Cart Item Deleted Successfully',
            'transaction_data' => $transaction_data,
            'cart_temporary_data' => $cart_temporary_data,
            'sales_type' => $sales_type
        ], 200);
    }

    //-------- Fetch Suspended Items ---------
    public function getSuspendedItems()
    {
        $suspended = CartTemporary::where('is_suspended', 1)->get();

        return response()->json([
            'status' => true,
            'suspend_data' => $suspended
        ], 200);
    }

    //-------- Fetch Suspended Item Wise Data ---------
    public function getSuspendedData($id)
    {
        $cart_temporary_data = SalesFormDataHelper($id);

        $items = $cart_temporary_data->count();
        $subtotal = 0;
        $quantity = 0;
        $total_discount = 0;
        $total = 0;
        $table_no = 0;
        $vat = 0;
        foreach ($cart_temporary_data as $data) {
            $subtotal += $data->temp_net_amount;
            $total_discount += $data->total_discount;
            $quantity += $data->quantity;
            $temp_cart_id = $data->temp_cart_id;
            $table_no = $data->table_no;
            $vat += $data->vat;
            $sales_type = $data->sales_type;
        }
        $total = $subtotal - $total_discount + $vat;;
        $paid_amount = 0;
        $due_amount = $total;
        $transaction_data = array('temp_cart_id' => $temp_cart_id, 'quantity' => $quantity, 'items' => $items, 'subtotal' => $subtotal, 'total_discount' => $total_discount, 'total_payable' => $total, 'total' => $total, 'paid_amount' => $paid_amount, 'due_amount' => $due_amount, 'vat' => $vat);

        $IsPaymentExists = CartTemporaryPayment::where('cart_temporary_id', $temp_cart_id)->exists();
        $TempPaymentdata = CartTemporaryPayment::where('cart_temporary_id', $temp_cart_id)->first();

        return response()->json([
            'status' => true,
            'transaction_data' => $transaction_data,
            'cart_temporary_data' => $cart_temporary_data,
            'IsPaymentExists' => $IsPaymentExists,
            'TempPaymentdata' => $TempPaymentdata,
            'table_no' => $table_no,
            'sales_type' => $sales_type
        ], 200);
    }

    //------- Function To generate Random String ------
    public function random_strings($length_of_string)
    {

        // String of all alphanumeric character
        $str_result = '0123456789';

        // Shuffle the $str_result and returns substring
        // of specified length
        return substr(
            str_shuffle($str_result),
            0,
            $length_of_string
        );
    }

    //------- Function to destroy Temp cart -----------
    public function destroy(Request $request)
    {
        if ($request->session()->get('LoggedUser')) {

            $login_id = $request->session()->get('LoggedUser');
            $cart_temporary = CartTemporary::where('cart_temporary.created_by', '=', $login_id)
                ->where('cart_temporary.is_suspended', '=', 0)->first();

            if (!$cart_temporary) {
                return redirect()->back()->with(['success' => 'No Data Available To Cart']);
            } else {
                $CartTemporaryItem = CartTemporaryItem::where('temp_cart_id', $cart_temporary->temp_cart_id)->get();
                foreach ($CartTemporaryItem as $tempItem) {
                    $tempItem->delete();
                }

                $cart_temporary->delete();
                $request->session()->pull('From_Ip');
                $request->session()->pull('Temp_Consumer_ID');

                return redirect()->back()->with(['success' => 'Cart Cleared Successfully']);
            }
        } else {
            return redirect()->back()->with(['success' => 'No Data Available To Cart']);
        }
    }

    //-------- Suspend a cart ---------
    public function addSuspense($id, $waiter_id, $table_no)
    {
        // return $table_no;

        $temp_cart_id = $id;
        $tempcart = CartTemporary::find($temp_cart_id);
        $tempcart->waiter_id = $waiter_id;
        $tempcart->table_no = $table_no;
        $tempcart->is_suspended = 1;
        $tempcart->update();

        return response()->json([
            'status' => true,
            'success' => 'Product Suspended',
            'tempcart' => $tempcart
        ], 200);
    }

    public function salesTempPayment(Request $request)
    {
        $tempcart = CartTemporary::join('cart_temporary_items', 'cart_temporary_items.temp_cart_id', '=', 'cart_temporary.temp_cart_id')
            ->join('products', 'products.product_id', '=', 'cart_temporary_items.product_id')
            ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_temporary_items.stock_id')
            ->where('cart_temporary.temp_cart_id', $request->temp_cart_id)
            ->select('cart_temporary_items.*', 'cart_temporary.*', 'final_stock_table.sales_price', 'final_stock_table.wholesale_price')
            ->get();
        $IsPaymentExists = CartTemporaryPayment::where('cart_temporary_id', $request->temp_cart_id)->exists();

        if (!$IsPaymentExists) {

            $temp_net_amount = 0;
            $vat = 0;
            $temp_net_amount_new = 0;

            foreach ($tempcart as $data) {

                $temp_net_amount += $data->temp_net_amount;
                $vat += $data->vat;
                $temp_net_amount_new += ($data->wholesale_price * $data->quantity);
            }

            $TempPaymentdata = new CartTemporaryPayment();
            $TempPaymentdata->cart_temporary_id = $request->temp_cart_id;
            if ($request->sales_type == 1) {
                $TempPaymentdata->cart_temporary_total = $temp_net_amount;
            } else if ($request->sales_type == 2) {
                $TempPaymentdata->cart_temporary_total = $temp_net_amount_new;
            }
            $TempPaymentdata->vat = $vat;
            $TempPaymentdata->discount_amount = $request->discount;
            $TempPaymentdata->payment_method_id = $request->payment_type_id;
            $TempPaymentdata->total_payable = ($TempPaymentdata->cart_temporary_total) - ($TempPaymentdata->discount_amount) + ($vat);
            $TempPaymentdata->paid_amount = $request->paid_amount;
            if (($TempPaymentdata->total_payable) - ($TempPaymentdata->paid_amount) < 0) {
                $TempPaymentdata->due_amount = 0;
            } else {
                $TempPaymentdata->due_amount = ($TempPaymentdata->total_payable) - ($TempPaymentdata->paid_amount);
            }

            $TempPaymentdata->change_amount = ($TempPaymentdata->paid_amount) - ($TempPaymentdata->total_payable);
            $TempPaymentdata->save();

            return response()->json(['TempPaymentdata' => $TempPaymentdata, 'is_payment_exists' => $IsPaymentExists]);
        } else {
            $TempPaymentdata = CartTemporaryPayment::where('cart_temporary_id', $request->temp_cart_id)->first();
            return response()->json(['is_payment_exists' => $IsPaymentExists, 'TempPaymentdata' => $TempPaymentdata]);
        }
    }

    public function destroyTemporaryPayment(Request $request, $id)
    {
        $cart_temporary_payment_id = $id;
        $TempPaymentdelete = CartTemporaryPayment::where('cart_temporary_payment_id', $cart_temporary_payment_id)->first();

        $temp_cart_id = $TempPaymentdelete->cart_temporary_id;

        $TempPaymentdelete->delete();

        $cart_temporary_data = SalesFormDataHelper($temp_cart_id);
        $TempPaymentdata = SalesFormTransactionHelper($cart_temporary_data);

        return response()->json(['deleted' => true, 'TempPaymentdata' => $TempPaymentdata]);
    }


    public function storeSales(Request $request)
    {
        // dd($request);
        $temp_cart_data = CartTemporary::join('cart_temporary_items', 'cart_temporary_items.temp_cart_id', '=', 'cart_temporary.temp_cart_id')
            ->join('products', 'products.product_id', '=', 'cart_temporary_items.product_id')
            ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_temporary_items.stock_id')
            ->where('cart_temporary.temp_cart_id', $request->temp_cart_id)
            ->select(
                'cart_temporary_items.*',
                'cart_temporary.temp_cart_id',
                'cart_temporary_items.quantity',
                'cart_temporary_items.stock_id',
                'products.product_name',
                'cart_temporary_items.product_id',
                'products.product_image',
                'final_stock_table.sales_price',
                'cart_temporary_items.vat',
                'final_stock_table.purchase_price',
                'products.unit_type',
                'final_stock_table.wholesale_price'
            )
            ->get();

        $cart_date = Carbon::now();

        // Add to Cart Informations table
        $CartInformtion = new CartInformtion();
        // $CartInformtion->consumer_id = $newConsumer->login_id;
        $CartInformtion->cart_date = $cart_date;
        $CartInformtion->sales_type = $request->sales_type;
        $CartInformtion->created_by = Auth::id();
        $CartInformtion->payment_method_id = $request->payment_method_id;
        $CartInformtion->waiter_id = $request->delivery_man;
        $CartInformtion->save();
        $TempPayment = CartTemporaryPayment::where('cart_temporary_id', $request->temp_cart_id)->first();


        foreach ($temp_cart_data as $item_data) {

            $CartItem = new CartItem();
            $CartItem->cart_id = $CartInformtion->cart_id;
            $CartItem->product_id = $item_data->product_id;
            $CartItem->unit_id = $item_data->unit_type;
            $CartItem->stock_id = $item_data->stock_id;
            $CartItem->unit_purchase_cost = $item_data->purchase_price;
            $CartItem->quantity = $item_data->quantity;
            if ($request->sales_type == 2) {
                $CartItem->unit_sales_cost = $item_data->wholesale_price;
            }
            else{
                $CartItem->unit_sales_cost = $item_data->sales_price;
            }

            if ($request->sales_type == 2) {
                $CartItem->total_price = ($item_data->wholesale_price) * ($item_data->quantity);
            } else {
                $CartItem->total_price = ($item_data->sales_price) * ($item_data->quantity);
            }
            $CartItem->vat = ($item_data->vat);
            $CartItem->net_amount = $CartItem->total_price + $CartItem->vat;
            $CartItem->is_confirmed = 1;
            $save = $CartItem->save();

            if (FinalStockTable::where('stock_id', $CartItem->stock_id)->exists()) {
                $final_stock_table = FinalStockTable::where('stock_id', $CartItem->stock_id)->first();
                $final_stock_table->total_sold_quantity += $CartItem->quantity;
                $final_stock_table->temp_quantity -= $CartItem->quantity;
                $final_stock_table->final_quantity -= $CartItem->quantity;
                $final_stock_table->update();
            }
        }

        $NewCartItem = CartItem::where('cart_id', $CartItem->cart_id)->get();
        $purchQty = CartItem::where('cart_id', $CartItem->cart_id)->sum(DB::raw('unit_purchase_cost * quantity'));

        $CartInformtion_Update = CartInformtion::where('cart_id', '=', $CartItem->cart_id)->first();

        $CartInformtion_Update->total_cart_amount = $NewCartItem->sum('total_price');
        $CartInformtion_Update->vat_amount = $NewCartItem->sum('vat');

        if(strpos($request->discount, '%') !== false){
            $getDiscountValue = floatval(substr($request->discount, 0, -1))/100;
            $dis = $NewCartItem->sum('total_price')*$getDiscountValue;
            $CartInformtion_Update->total_discount = $dis;
        }
        else{
            $CartInformtion_Update->total_discount = $request->discount;
        }

        $CartInformtion_Update->total_payable_amount = ($CartInformtion_Update->total_cart_amount) + ($CartInformtion_Update->vat_amount) - ($CartInformtion_Update->total_discount);
        $CartInformtion_Update->final_total_amount = $CartInformtion_Update->total_payable_amount;

        if ($request->paid_amount > $CartInformtion_Update->total_payable_amount) {
            $CartInformtion_Update->paid_amount = $CartInformtion_Update->total_payable_amount;
        } else {
            $CartInformtion_Update->paid_amount = $request->paid_amount;
        }


        if (($CartInformtion_Update->total_payable_amount - $CartInformtion_Update->paid_amount) >= 0) {
            $CartInformtion_Update->due_amount = ($CartInformtion_Update->total_payable_amount - $CartInformtion_Update->paid_amount);
        } else {
            $CartInformtion_Update->due_amount = 0;
        }
        $CartInformtion_Update->gross_profit = $CartInformtion_Update->total_payable_amount - $purchQty;
        $CartInformtion_Update->net_profit = $CartInformtion_Update->gross_profit;
        if ($CartInformtion_Update->due_amount <= 0) {
            $CartInformtion_Update->cart_status = 2;
            $CartInformtion_Update->is_closed = 1;
        } elseif ($CartInformtion_Update->total_payable_amount == $CartInformtion_Update->due_amount) {
            $CartInformtion_Update->cart_status = 0;
            $CartInformtion_Update->is_closed = 0;
        } else {
            $CartInformtion_Update->cart_status = 1;
            $CartInformtion_Update->is_closed = 1;
        }
        $save = $CartInformtion_Update->save();

        // $customer_payment = new CustomerPayment();
        // $customer_payment->date = $cart_date;;
        // $customer_payment->customer_id = $newConsumer->login_id;
        // $customer_payment->sales_info_id = $CartInformtion_Update->cart_id;
        // $customer_payment->payable_amount = $CartInformtion_Update->total_payable_amount;
        // $customer_payment->paid_amount = $CartInformtion_Update->paid_amount;
        // $customer_payment->revised_due = $CartInformtion_Update->due_amount;
        // $customer_payment->payment_method = $request->payment_method_id;
        // $customer_payment->save();

        if ($request->payment_method_id == 2) {
            $Bank = Bank::where('is_default', 1)->first();

            $BankTransaction = new BankTransaction();
            $BankTransaction->date = date('Y-m-d');
            $BankTransaction->trx_type = 1;
            $BankTransaction->trx_mode = 2;
            $BankTransaction->bank_id = $Bank->bank_id;
            $BankTransaction->bank_name = $request->bank_name;
            $BankTransaction->cheque_no = $request->cheque_no;
            $BankTransaction->prev_balance = $Bank->balance;
            $BankTransaction->amount = $CartInformtion_Update->paid_amount;
            $BankTransaction->current_balance = $BankTransaction->prev_balance + $BankTransaction->amount;
            $BankTransaction->transaction_no = $request->transaction_no;
            $BankTransaction->save();

            $Bank->balance = $BankTransaction->current_balance;
            $Bank->save();
        }


        $CartTemporaryItem = CartTemporaryItem::where('temp_cart_id', '=', $request->temp_cart_id)->get();
        foreach ($CartTemporaryItem as $del) {
            $del->delete();
        }

        $CartTemporary = CartTemporary::where('temp_cart_id', '=', $request->temp_cart_id)->get();
        foreach ($CartTemporary as $delet) {
            $delet->delete();
        }

        $CartTemporaryPayment = CartTemporaryPayment::where('cart_temporary_id', '=', $request->temp_cart_id)->get();
        foreach ($CartTemporaryPayment as $delet) {
            $delet->delete();
        }

        $CartInformtionForPrint = CartInformtion::join('cart_items', 'cart_items.cart_id', '=', 'cart_informtion.cart_id')
            ->join('products', 'products.product_id', '=', 'cart_items.product_id')
            ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_items.stock_id')
            ->where('cart_informtion.cart_id', $CartInformtion_Update->cart_id)
            ->select('cart_informtion.*', 'cart_items.*', 'products.product_name', 'final_stock_table.purchase_price', 'final_stock_table.sales_price', 'final_stock_table.wholesale_price')
            ->get();

        if ($save) {
            return view('sales/print/printInvoice', compact(['CartInformtion', 'CartInformtionForPrint']));
        } else {
            return redirect()->back()->with('fail', 'Something went wrong, failed to Add');
        }
    }

    public function getWaiter()
    {
        $waiter_data = BackofficeLogin::where('role_id', 6)->get();

        return response()->json([
            'status' => true,
            'waiter_data' => $waiter_data
        ], 200);
    }

    public function salesSubCategory($id)
    {
        $category_id = $id;
        $SalesSubCat = ProductCategory::join('sub_category_one', 'sub_category_one.category_id', '=', 'product_category.category_id')
            ->where('product_category.category_id', '=', $category_id)
            ->select('sub_category_one.*')
            ->get();
        return response()->json($SalesSubCat);
    }

    // bar code function
    public function get_all_barcode()
    {
        // return response()->json('this is controller');
        $barcodes = PurchaseDetail::join('final_stock_table', 'final_stock_table.stock_id', '=', 'purchase_details.stock_id')
            ->join('products', 'products.product_id', '=', 'final_stock_table.product_id')
            ->where('final_stock_table.final_quantity', '>', '0' )
            ->whereNotNull('products.barcode')
            ->select('products.barcode')
            ->orderBy('final_stock_table.stock_id', 'desc')
            ->get();

            return response()->json($barcodes);

        // return response()->json($barcodes);
    }
}
