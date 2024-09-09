<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CartInformtion;
use App\Models\ConsumerLogin;
use App\Models\CustomerPayment;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\PurchaseInfo;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\BackofficeLogin;
use App\Models\SiteSettings;

use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function salesReport()
    {
        $site_settings = SiteSettings::first();
        $delivery_man = BackofficeLogin::where('role_id','=','6')->select('login_id','full_name')->get();

        return view('dashboard.reports.salesReport',compact(['delivery_man','site_settings']));
    }
    public function purchaseReport()
    {
        $site_settings = SiteSettings::first();
        return view('dashboard.reports.purchaseReport',compact('site_settings'));
    }
    public function expenseReport()
    {
        $site_settings = SiteSettings::first();
        $getExpenseCategory = ExpenseCategory::all();
        return view('dashboard.reports.expenseReport',['getExpenseCategory'=>$getExpenseCategory,'site_settings'=>$site_settings]);
    }
    public function SupplierBalance()
    {
        $site_settings = SiteSettings::first();
        return view('dashboard.reports.SupplierBalance',compact('site_settings'));
    }
    public function CustomerBalance()
    {
        return view('possie.reports.CustomerBalance');
    }
    public function ajaxGetCustomer()
    {
        $consumer = ConsumerLogin::all();

        return response()->json($consumer);
    }
    public function ajaxGetSupplier()
    {
        $consumer = Supplier::all();

        return response()->json($consumer);
    }
    public function ajaxGetCustomerDetails($id)
    {
        $consumer = ConsumerLogin::select('login_id', 'consumer_name', 'mobile_no','consumer_address','customer_due', 'total_collection', 'final_receivable')
                    ->where('login_id','=', $id)
                    ->first();

        $payments = CustomerPayment::select('due_amount', 'paid_amount', 'balance', 'created_at')
                    ->where('customer_id','=', $id)
                    ->get();

        return response()->json([
            'consumer' => $consumer,
            'payments' => $payments
        ]);
    }

    public function generatePdf($id)
    {
        $consumer = ConsumerLogin::select('login_id', 'consumer_name', 'mobile_no','consumer_address','customer_due', 'total_collection', 'final_receivable')
                    ->where('login_id','=', $id)
                    ->first();

        $payments = CustomerPayment::select('due_amount', 'paid_amount', 'balance', 'created_at')
                    ->where('customer_id','=', $id)
                    ->get();

        $pdf = PDF::loadView('possie.reports.printCustomerLedger', compact('consumer','payments'));
        return $pdf->stream('invoice.pdf');
    }


    public function generateSupPdf($id)
    {
        $supplier = Supplier::select('supplier_name', 'supplier_contact_no','supplier_address','supplier_contact_person',
                                'total_invoiced', 'total_payment', 'final_balance')
                                ->where('supplier_id','=', $id)
                                ->first();

        $payments = SupplierPayment::select('purchase_id','payable_amount', 'paid_amount', 'revised_due','created_at')
                    ->where('supplier_id','=', $id)
                    ->get();

        $pdf = PDF::loadView('possie.reports.printSupplierLedger', compact('supplier','payments'));
        return $pdf->stream('invoice.pdf');
    }


    public function ajaxGetSupplierDetails($id)
    {
        $supplier = Supplier::select('supplier_id','supplier_name', 'supplier_contact_no','supplier_address','supplier_contact_person',
                                'total_invoiced', 'total_payment', 'final_balance')
                                ->where('supplier_id','=', $id)
                                ->first();

        $payments = SupplierPayment::select('purchase_id','payable_amount', 'paid_amount', 'revised_due','created_at')
                    ->where('supplier_id','=', $id)
                    ->get();

        return response()->json([
            'supplier' => $supplier,
            'payments' => $payments
        ]);
        // $cart = PurchaseInfo::join('supplier_payments', 'supplier_payments.purchase_id', '=', 'purchase_info.purchase_id')
        //     ->where('supplier_payments.supplier_id', $id)
        //     ->select('purchase_info.*', 'supplier_payments.supplier_id')
        //     ->get();
        // $total_sales = $cart->sum("total_payable");
        // $paid_amount = $cart->sum("paid_amount");
        // $due_amount = $cart->sum("due_amount");

        // $cp = SupplierPayment::where('supplier_id', $id)
        //     ->where('purchase_id', null)
        //     ->get();
        // $customer_payment = $cp->sum("paid_amount");

        // $balance = $customer_payment + $paid_amount - $total_sales;

        // $summary = array(
        //     'total_sales' => $total_sales,
        //     'paid_amount' => $paid_amount,
        //     'due_amount' => $due_amount,
        //     'customer_payment' => $customer_payment,
        //     'balance' => $balance
        // );

        // return response()->json($summary);
    }
    public function singleDateSales($id)
    {
        // dd($id);
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
        if($user_data->role_id==4){
            $singleDateSales = CartInformtion::join('backoffice_login', 'backoffice_login.login_id', '=', 'cart_informtion.waiter_id')
            ->where('cart_informtion.cart_date', 'like', '%' . $id . '%')
            ->where('cart_informtion.is_vat_show',1)
            ->select('cart_informtion.*', 'backoffice_login.full_namey')
            ->get();
        $total_orders = $singleDateSales->count();
        $invoice_amount = $singleDateSales->sum('total_cart_amount');
        $discount = $singleDateSales->sum('total_discount');
        $vat = $singleDateSales->sum('vat_amount');
        $payable = $singleDateSales->sum('total_payable_amount');
        $paid = $singleDateSales->sum('paid_amount');
        $due = $singleDateSales->sum('due_amount');

        $summary = array(
            'total_orders' => $total_orders,
            'discount' => $discount,
            'invoice_amount' => $invoice_amount,
            'vat' => $vat,
            'payable' => $payable,
            'paid' => $paid,
            'due' => $due,
        );

        return response()->json([
            'summary' => $summary,
            'singleDateSales' => $singleDateSales
        ]);
        }
        else{
            $singleDateSales = CartInformtion::join('backoffice_login', 'backoffice_login.login_id', '=', 'cart_informtion.waiter_id')
                ->where('cart_informtion.cart_date', 'like', '%' . $id . '%')
                ->select('cart_informtion.*', 'backoffice_login.full_name')
                ->get();
            $total_orders = $singleDateSales->count();
            $invoice_amount = $singleDateSales->sum('total_cart_amount');
            $discount = $singleDateSales->sum('total_discount');
            $vat = $singleDateSales->sum('vat_amount');
            $payable = $singleDateSales->sum('total_payable_amount');
            $paid = $singleDateSales->sum('paid_amount');
            $due = $singleDateSales->sum('due_amount');

            $summary = array(
                'total_orders' => $total_orders,
                'discount' => $discount,
                'invoice_amount' => $invoice_amount,
                'vat' => $vat,
                'payable' => $payable,
                'paid' => $paid,
                'due' => $due,
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
    }

    public function customerMobile($id)
    {
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
        if($user_data->role_id==4){
            $singleDateSales = CartInformtion::join('backoffice_login', 'backoffice_login.login_id', '=', 'cart_informtion.waiter_id')
            ->where('cart_informtion.waiter_id', '=', $id)
            ->where('cart_informtion.is_vat_show',1)
            ->select('cart_informtion.*', 'backoffice_login.full_name')
            ->get();
        $total_orders = $singleDateSales->count();
        $invoice_amount = $singleDateSales->sum('total_cart_amount');
        $discount = $singleDateSales->sum('total_discount');
        $vat = $singleDateSales->sum('vat_amount');
        $payable = $singleDateSales->sum('total_payable_amount');
        $paid = $singleDateSales->sum('paid_amount');
        $due = $singleDateSales->sum('due_amount');

        $summary = array(
            'total_orders' => $total_orders,
            'discount' => $discount,
            'invoice_amount' => $invoice_amount,
            'vat' => $vat,
            'payable' => $payable,
            'paid' => $paid,
            'due' => $due,
        );

        return response()->json([
            'summary' => $summary,
            'singleDateSales' => $singleDateSales
        ]);
        }
        else{
            $singleDateSales = CartInformtion::join('backoffice_login', 'backoffice_login.login_id', '=', 'cart_informtion.waiter_id')
                ->where('cart_informtion.waiter_id', '=',  $id)
                ->select('cart_informtion.*', 'backoffice_login.full_name')
                ->get();
            $total_orders = $singleDateSales->count();
            $invoice_amount = $singleDateSales->sum('total_cart_amount');
            $discount = $singleDateSales->sum('total_discount');
            $vat = $singleDateSales->sum('vat_amount');
            $payable = $singleDateSales->sum('total_payable_amount');
            $paid = $singleDateSales->sum('paid_amount');
            $due = $singleDateSales->sum('due_amount');

            $summary = array(
                'total_orders' => $total_orders,
                'discount' => $discount,
                'invoice_amount' => $invoice_amount,
                'vat' => $vat,
                'payable' => $payable,
                'paid' => $paid,
                'due' => $due,
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
    }

    public function dueList($id)
    {
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
        if($user_data->role_id==4){
            $singleDateSales = CartInformtion::join('backoffice_login', 'backoffice_login.login_id', '=', 'cart_informtion.waiter_id')
            ->where('cart_informtion.due_amount', 'like', '%' . $id . '%')
            ->where('cart_informtion.is_vat_show',1)
            ->select('cart_informtion.*', 'backoffice_login.full_name')
            ->get();
        $total_orders = $singleDateSales->count();
        $invoice_amount = $singleDateSales->sum('total_cart_amount');
        $discount = $singleDateSales->sum('total_discount');
        $vat = $singleDateSales->sum('vat_amount');
        $payable = $singleDateSales->sum('total_payable_amount');
        $paid = $singleDateSales->sum('paid_amount');
        $due = $singleDateSales->sum('due_amount');

        $summary = array(
            'total_orders' => $total_orders,
            'discount' => $discount,
            'invoice_amount' => $invoice_amount,
            'vat' => $vat,
            'payable' => $payable,
            'paid' => $paid,
            'due' => $due,
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
        else{
            $singleDateSales = CartInformtion::join('backoffice_login', 'backoffice_login.login_id', '=', 'cart_informtion.waiter_id')
            ->where('cart_informtion.due_amount', 'like', '%' . $id . '%')
            ->select('cart_informtion.*', 'backoffice_login.full_name')
            ->get();
        $total_orders = $singleDateSales->count();
        $invoice_amount = $singleDateSales->sum('total_cart_amount');
        $discount = $singleDateSales->sum('total_discount');
        $vat = $singleDateSales->sum('vat_amount');
        $payable = $singleDateSales->sum('total_payable_amount');
        $paid = $singleDateSales->sum('paid_amount');
        $due = $singleDateSales->sum('due_amount');

        $summary = array(
            'total_orders' => $total_orders,
            'discount' => $discount,
            'invoice_amount' => $invoice_amount,
            'vat' => $vat,
            'payable' => $payable,
            'paid' => $paid,
            'due' => $due,
        );

        return response()->json([
            'summary' => $summary,
            'singleDateSales' => $singleDateSales
        ]);
     }
    }

    public function multiDateSales($from, $to)
    {
        $user_id = session()->get('LoggedUser');
        $startDate = Carbon::parse($from)->startOfDay();
        $endDate = Carbon::parse($to)->endOfDay();
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
        if(0){
                $singleDateSales = CartInformtion::join('backoffice_login', 'backoffice_login.login_id', '=', 'cart_informtion.waiter_id')
                ->whereBetween('cart_informtion.cart_date', [$startDate, $endDate])
                ->where('cart_informtion.is_vat_show',1)
                ->select('cart_informtion.*', 'backoffice_login.full_name')
                ->get();
            $total_orders = $singleDateSales->count();
            $invoice_amount = $singleDateSales->sum('total_cart_amount');
            $discount = $singleDateSales->sum('total_discount');
            $vat = $singleDateSales->sum('vat_amount');
            $payable = $singleDateSales->sum('total_payable_amount');
            $paid = $singleDateSales->sum('paid_amount');
            $due = $singleDateSales->sum('due_amount');

            $summary = array(
                'total_orders' => $total_orders,
                'discount' => $discount,
                'invoice_amount' => $invoice_amount,
                'vat' => $vat,
                'payable' => $payable,
                'paid' => $paid,
                'due' => $due,
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
        else{
            $singleDateSales = CartInformtion::join('backoffice_login', 'backoffice_login.login_id', '=', 'cart_informtion.waiter_id')
                ->whereBetween('cart_informtion.cart_date', [$startDate, $endDate])
                ->select('cart_informtion.*', 'backoffice_login.full_name')
                ->get();
            $total_orders = $singleDateSales->count();
            $invoice_amount = $singleDateSales->sum('total_cart_amount');
            $discount = $singleDateSales->sum('total_discount');
            $vat = $singleDateSales->sum('vat_amount');
            $payable = $singleDateSales->sum('total_payable_amount');
            $paid = $singleDateSales->sum('paid_amount');
            $due = $singleDateSales->sum('due_amount');

            $summary = array(
                'total_orders' => $total_orders,
                'discount' => $discount,
                'invoice_amount' => $invoice_amount,
                'vat' => $vat,
                'payable' => $payable,
                'paid' => $paid,
                'due' => $due,
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
    }

    public function singleDatePurchase($id)
    {
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
        if(0){
            $singleDateSales = PurchaseInfo::where('pur_date', 'like', '%' . $id . '%')
            ->where('is_vat_show',1)
            ->get();

            $total_orders = $singleDateSales->count();
            $invoice_amount = $singleDateSales->sum('total_item_price');
            $discount = $singleDateSales->sum('discount');
            $vat = $singleDateSales->sum('total_vat');
            $payable = $singleDateSales->sum('total_payable');
            $paid = $singleDateSales->sum('paid_amount');
            $due = $singleDateSales->sum('due_amount');

            $summary = array(
                'total_orders' => $total_orders,
                'discount' => $discount,
                'invoice_amount' => $invoice_amount,
                'vat' => $vat,
                'payable' => $payable,
                'paid' => $paid,
                'due' => $due,
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
        else{
            $singleDateSales = PurchaseInfo::where('pur_date', 'like', '%' . $id . '%')->get();

            $total_orders = $singleDateSales->count();
            $invoice_amount = $singleDateSales->sum('total_item_price');
            $discount = $singleDateSales->sum('discount');
            $vat = $singleDateSales->sum('total_vat');
            $payable = $singleDateSales->sum('total_payable');
            $paid = $singleDateSales->sum('paid_amount');
            $due = $singleDateSales->sum('due_amount');

            $summary = array(
                'total_orders' => $total_orders,
                'discount' => $discount,
                'invoice_amount' => $invoice_amount,
                'vat' => $vat,
                'payable' => $payable,
                'paid' => $paid,
                'due' => $due,
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
    }

    public function multiDatePurchase($from, $to)
    {
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
        if($user_data->role_id==4){
            $singleDateSales = PurchaseInfo::whereBetween('pur_date', [$from, $to])
            ->where('is_vat_show',1)
            ->get();

            $total_orders = $singleDateSales->count();
            $invoice_amount = $singleDateSales->sum('total_item_price');
            $discount = $singleDateSales->sum('discount');
            $vat = $singleDateSales->sum('total_vat');
            $payable = $singleDateSales->sum('total_payable');
            $paid = $singleDateSales->sum('paid_amount');
            $due = $singleDateSales->sum('due_amount');

            $summary = array(
                'total_orders' => $total_orders,
                'discount' => $discount,
                'invoice_amount' => $invoice_amount,
                'vat' => $vat,
                'payable' => $payable,
                'paid' => $paid,
                'due' => $due,
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
        else{
            $singleDateSales = PurchaseInfo::whereBetween('pur_date', [$from, $to])->get();

        $total_orders = $singleDateSales->count();
        $invoice_amount = $singleDateSales->sum('total_item_price');
        $discount = $singleDateSales->sum('discount');
        $vat = $singleDateSales->sum('total_vat');
        $payable = $singleDateSales->sum('total_payable');
        $paid = $singleDateSales->sum('paid_amount');
        $due = $singleDateSales->sum('due_amount');

        $summary = array(
            'total_orders' => $total_orders,
            'discount' => $discount,
            'invoice_amount' => $invoice_amount,
            'vat' => $vat,
            'payable' => $payable,
            'paid' => $paid,
            'due' => $due,
        );

        return response()->json([
            'summary' => $summary,
            'singleDateSales' => $singleDateSales
        ]);
        }
    }

    public function singleDateExpense($id)
    {
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
        if($user_data->role_id==4){
            $singleDateSales = Expense::join('expense_details', 'expense_details.expense_id', '=', 'expenses.expense_id')
            ->leftJoin('expense_categories', 'expense_categories.expense_category_id', '=', 'expenses.expense_category_id')
            ->where('date', 'like', '%' . $id . '%')
            ->where('expense_details.is_vat_show',1)
            ->select('expenses.*', 'expense_categories.*', 'expense_details.*')
            ->get();

            $total_orders = $singleDateSales->count();
            $amount = $singleDateSales->sum('amount');

            $summary = array(
                'total_orders' => $total_orders,
                'amount' => $amount
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
        else{
            $singleDateSales = Expense::join('expense_details', 'expense_details.expense_id', '=', 'expenses.expense_id')
            ->leftJoin('expense_categories', 'expense_categories.expense_category_id', '=', 'expenses.expense_category_id')
            ->where('date', 'like', '%' . $id . '%')
            ->select('expenses.*', 'expense_categories.*', 'expense_details.*')
            ->get();

            $total_orders = $singleDateSales->count();
            $amount = $singleDateSales->sum('amount');

            $summary = array(
                'total_orders' => $total_orders,
                'amount' => $amount
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
    }
    public function singleExpenseCategory($id)
    {
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
            if($user_data->role_id==4){
                $singleDateSales = Expense::join('expense_details', 'expense_details.expense_id', '=', 'expenses.expense_id')
                ->leftJoin('expense_categories', 'expense_categories.expense_category_id', '=', 'expenses.expense_category_id')
                ->where('expense_categories.expense_category_name', 'like', '%' . $id . '%')
                ->where('expense_details.is_vat_show',1)
                ->select('expenses.*', 'expense_categories.*', 'expense_details.*')
                ->get();

            $total_orders = $singleDateSales->count();
            $amount = $singleDateSales->sum('amount');

            $summary = array(
                'total_orders' => $total_orders,
                'amount' => $amount
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
        else{
            $singleDateSales = Expense::join('expense_details', 'expense_details.expense_id', '=', 'expenses.expense_id')
            ->leftJoin('expense_categories', 'expense_categories.expense_category_id', '=', 'expenses.expense_category_id')
            ->where('expense_categories.expense_category_name', 'like', '%' . $id . '%')
            ->select('expenses.*', 'expense_categories.*', 'expense_details.*')
            ->get();

        $total_orders = $singleDateSales->count();
        $amount = $singleDateSales->sum('amount');

        $summary = array(
            'total_orders' => $total_orders,
            'amount' => $amount
        );

        return response()->json([
            'summary' => $summary,
            'singleDateSales' => $singleDateSales
        ]);
      }
    }

    public function multiDateExpense($from, $to)
    {
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        $banner_Information= \App\Models\BannerInformation::first();
            if($user_data->role_id==4){
                $singleDateSales = Expense::join('expense_details', 'expense_details.expense_id', '=', 'expenses.expense_id')
                ->leftJoin('expense_categories', 'expense_categories.expense_category_id', '=', 'expenses.expense_category_id')
                ->whereBetween('date', [$from, $to])
                ->where('expense_details.is_vat_show',1)
                ->select('expenses.*', 'expense_categories.*', 'expense_details.*')
                ->get();

            $total_orders = $singleDateSales->count();
            $amount = $singleDateSales->sum('amount');

            $summary = array(
                'total_orders' => $total_orders,
                'amount' => $amount
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
        else{
            $singleDateSales = Expense::join('expense_details', 'expense_details.expense_id', '=', 'expenses.expense_id')
                ->leftJoin('expense_categories', 'expense_categories.expense_category_id', '=', 'expenses.expense_category_id')
                ->whereBetween('date', [$from, $to])
                ->select('expenses.*', 'expense_categories.*', 'expense_details.*')
                ->get();

            $total_orders = $singleDateSales->count();
            $amount = $singleDateSales->sum('amount');

            $summary = array(
                'total_orders' => $total_orders,
                'amount' => $amount
            );

            return response()->json([
                'summary' => $summary,
                'singleDateSales' => $singleDateSales
            ]);
        }
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
