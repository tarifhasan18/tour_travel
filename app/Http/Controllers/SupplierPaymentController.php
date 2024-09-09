<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PurchaseInfo;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\Bank;
use App\Models\BankTransaction;
use App\Models\DailyTransactionInformation;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierPaymentController extends Controller
{
    public function index()
    {
        $site_settings = SiteSettings::first();
        $supplier = Supplier::where('final_balance','>',0)->get();
        $payment_method = DB::table('transaction_mode')
              ->where('is_active', 1)
              ->get();
        return view('purchase.supplierPayment', compact(['supplier','payment_method','site_settings']));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'amount' => 'required|numeric',
            'supplier_id' => 'required|numeric',
            'payment_method_id' => 'required|numeric'
        ]);
        $selected_supplier = $request->supplier_id;
        $selected_payment_method = $request->payment_method_id;
        $paid_amount = $request->amount;

        //Record transaction
        $transaction = new DailyTransactionInformation();
        $transaction->ref_id = $selected_supplier;
        $transaction->daily_trx_type_id = 5;
        $transaction->expense_amount = $paid_amount;
        $transaction->create_date = now();
        $transaction->save();

        //Step 1: Purchase Info and Supplier transaction update. (both has purchase invoice no)
        if($request->purchase_id)
        {
            $purchase_info = PurchaseInfo::where('supplier_id','=', $selected_supplier)
                ->where('purchase_id', $request->purchase_id)
                ->first();
            if ($paid_amount > $purchase_info->due_amount)
            {
                return redirect()->back()->with('fail', 'Amount exceeds due amount');
            }
            $purchase_info->paid_amount += $paid_amount;
            $purchase_info->due_amount -= $paid_amount;
            if ($purchase_info->due_amoun <= 0) {
                $purchase_info->paid_status = 2;
            }
            $qeury_status = $purchase_info->update();

            $supplier_payment = SupplierPayment::where('supplier_id','=', $selected_supplier)
                ->where('purchase_id', $request->purchase_id)
                ->first();
            $supplier_payment->paid_amount += $paid_amount;
            $supplier_payment->revised_due -= $paid_amount;
            $supplier_payment->payment_method = $selected_payment_method;
            if ($selected_payment_method == 2)
            {
                $supplier_payment->bank_id = $request->bank_id;
                $supplier_payment->cheque_no = $request->cheque_no;
            }
            if ($selected_payment_method > 2)
            {
                $supplier_payment->cheque_no = $request->cheque_no;
            }
            $qeury_status = $supplier_payment->update();
        }
        else
        {
            $purchase_info = PurchaseInfo::where('supplier_id', $selected_supplier)
                ->where('due_amount', '>', 0)
                ->orderBy('purchase_id', 'ASC')
                ->get();

            if ($purchase_info)
            {
                foreach ($purchase_info as $purchase)
                {
                    if($paid_amount>0)
                    {
                        $supplier_payment = SupplierPayment::where('purchase_id', $purchase->purchase_id)
                        ->where('revised_due', '>', 0)
                        ->first();

                        if($purchase->due_amount >= $paid_amount)
                        {
                            $purchase->paid_amount += $paid_amount;
                            $purchase->due_amount -= $paid_amount;

                            if ($purchase->due_amount <= 0) {
                                $purchase->paid_status = 2;
                            }
                            $qeury_status = $purchase->update();

                            $supplier_payment->paid_amount += $paid_amount;
                            $supplier_payment->revised_due -= $paid_amount;
                            $supplier_payment->payment_method = $selected_payment_method;
                            if ($selected_payment_method == 2)
                            {
                                $supplier_payment->bank_id = $request->bank_id;
                                $supplier_payment->cheque_no = $request->cheque_no;
                            }
                            if ($selected_payment_method > 2)
                            {
                                $supplier_payment->cheque_no = $request->cheque_no;
                            }
                            $qeury_status = $supplier_payment->update();
                            $paid_amount = 0;
                        }
                        else
                        {
                            $paid_amount -= $purchase->due_amount;
                            $purchase->paid_amount += $purchase->due_amount;
                            $purchase->due_amount = 0;
                            $purchase->paid_status = 2;
                            $qeury_status = $purchase->update();

                            $supplier_payment->paid_amount += $supplier_payment->revised_due;
                            $supplier_payment->revised_due = 0;
                            $supplier_payment->payment_method = $selected_payment_method;
                            if ($selected_payment_method == 2)
                            {
                                $supplier_payment->bank_id = $request->bank_id;
                                $supplier_payment->cheque_no = $request->cheque_no;
                            }
                            if ($selected_payment_method > 2)
                            {
                                $supplier_payment->cheque_no = $request->cheque_no;
                            }
                            $qeury_status = $supplier_payment->update();
                        }
                    }
                }
            }
        }

        $paid_amount = $request->amount;

        //Step 2: Adjust Supplier due. (This is applicable for all conditions and cases.)
        $supplier_info = Supplier::where('supplier_id','=', $selected_supplier)->first();

        if ($paid_amount > $supplier_info->final_balance)
        {
            return redirect()->back()->with('fail', 'Paid Amount exceeds due amount');
        }
        $supplier_info->total_payment +=  $paid_amount;
        $supplier_info->final_balance -=  $paid_amount;
        $qeury_status = $supplier_info->update();

        //Step 3: Bank transaction input
        if($selected_payment_method == 2)
        {
            $Bank = Bank::where('bank_id', $request->bank_id)->first();

            $BankTransaction = new BankTransaction();
            $BankTransaction->bank_id = $request->bank_id;
            $BankTransaction->date = date('Y-m-d');
            $BankTransaction->trx_type = 3; //Type 3 is for Payment
            $BankTransaction->trx_mode = $selected_payment_method; //Type 2 for cheque
            $BankTransaction->cheque_no = $request->cheque_no;
            $BankTransaction->supplier_id = $selected_supplier;
            $BankTransaction->prev_balance = $Bank->balance;
            $BankTransaction->amount = $paid_amount;
            $BankTransaction->current_balance = $Bank->balance - $paid_amount;
            $qeury_status = $BankTransaction->save();

            $Bank->balance = $BankTransaction->current_balance;
            $qeury_status = $Bank->update();
        }

        if ($selected_payment_method > 2) {
            $BankTransaction = new BankTransaction();
            $BankTransaction->date = date('Y-m-d');
            $BankTransaction->trx_type = 3; //Type 3 is for Payment
            $BankTransaction->trx_mode = $selected_payment_method;
            $BankTransaction->cheque_no = $request->cheque_no;
            $BankTransaction->supplier_id = $selected_supplier;
            $BankTransaction->amount = $paid_amount;
            $qeury_status = $BankTransaction->save();
        }


        return redirect()->back()->with('success', 'Congratulations !! Payment Done Successfully');
    }

    public function ajaxGetSupInvoice($id)
    {
        $pur = PurchaseInfo::where('supplier_id', $id)->where('due_amount', '>', 0)->get();
        return response()->json($pur);
    }

    public function ajaxGetPurData($id)
    {
        $pur = PurchaseInfo::where('purchase_id', $id)->first();
        return response()->json($pur);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
