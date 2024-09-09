<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseDetail;
use App\Models\BackofficeLogin;
use App\Models\DailyTransactionInformation;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    //

    // public function purchase_view()
    // {
    //     $searchdate1 = request()->query('search_date');
    //     $searchdate2 = request()->query('search_date1');
    //     if ($searchdate1 or $searchdate2) {
    //         $search_query = sales::whereBetween('created_at', [$searchdate1, $searchdate2])->get();
    //     } else {
    //         $search_query = sales::all();
    //     }
    //     $getdatas = $search_query;
    //     return view('purchase.purchaseReport', ['getdatas' => $getdatas]);
    // }

    // public function excel_export()
    // {
    //     return Excel::download(new ReportsExport, 'report.xlsx');
    // }

    // public function csv_export()
    // {
    //     return Excel::download(new ReportsExport, 'report.csv');
    // }


    //payment field

    public function payment_field()
    {

        return view('purchase.paymentField');
    }
    public function allExpenses()
    {
        $site_settings = SiteSettings::first();
        $user_id = session()->get('LoggedUser');
        $user_data = BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
                        ->where('login_id', $user_id)
                        ->first();
        if(0){
            $expense = ExpenseDetail::join('expense_categories', 'expense_details.expense_category_id', '=', 'expense_categories.expense_category_id')
                        ->where('expense_details.is_vat_show',1)
                        ->select('expense_categories.*', 'expense_details.*')
                        ->get();
            return view('expense.allExpenses', compact(['expense','site_settings']));
        }
        else{
            $expense = ExpenseDetail::join('expense_categories', 'expense_details.expense_category_id', '=', 'expense_categories.expense_category_id')
                        ->select('expense_categories.*', 'expense_details.*')
                        ->get();
            return view('expense.allExpenses', compact(['expense','site_settings']));
        }
    }

    public function allExpensesVatSHow(Request $request){
        $getAllId = $request->selectedRowIds;
        $Expense = ExpenseDetail::whereIn('expense_details_id',$getAllId)->get();
        foreach($Expense as $Expense){
            $Expense->is_vat_show = 1;
            $Expense->save();
        }
        return response()->json([
            'status'=> 200,
            'success'=>'success'
        ]);
    }

    //expense

    public function expense()
    {
        $site_settings = SiteSettings::first();
        $getdata = ExpenseCategory::all();

        return view('purchase.expense', ['expenseCategory' => $getdata,'site_settings'=>$site_settings]);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'required',
            'expense_category_id' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        if ($request->amount < 0) {
            return response()->json([
                'status' => 400,
                'errors' => 'Amount Section must be positive'
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Please Fill All Section'
            ]);
        }
        else
        {
            $get_details = new ExpenseDetail;

            $get_details->expense_category_id = $request->expense_category_id;
            $get_details->amount = $request->amount;
            $get_details->notes = $request->notes;
            $get_details->created_by = session()->get('LoggedUser');
            $get_details->save();

            //Record transaction
            $transaction = new DailyTransactionInformation();
            $transaction->ref_id = $request->expense_category_id;
            $transaction->daily_trx_type_id = 7;
            $transaction->expense_amount = $request->amount;
            $transaction->create_date = now();
            $transaction->save();

            return response()->json([
                'status' => 200,
                'success' => 'Add Successfully'
            ]);
        }
    }

    public function getdata()
    {
        $getdata = ExpenseDetail::join('expense_categories', 'expense_details.expense_category_id', '=', 'expense_categories.expense_category_id')
                    ->whereDate('expense_details.created_at', '=', date("Y-m-d"))
                    ->select('expense_details.expense_details_id',  'expense_details.amount', 'expense_details.notes', 'expense_categories.expense_category_name')
                    ->get();

        return response()->json([
            'expense' => $getdata,
        ]);
    }

    public function edit_expense($id)
    {
        $getExpenseDetails = ExpenseDetail::find($id);
        $getExpense = Expense::find($getExpenseDetails->expense_id);

        $getExpenseCategory = ExpenseCategory::find($getExpense->expense_category_id);

        return response()->json([
            'status' => 200,
            'expenseDetails' => $getExpenseDetails,
            'expense' => $getExpense,
            'expenseCategory' => $getExpenseCategory
        ]);
    }

    public function update_expense(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [

            'expense' => 'required',
            'notes' => 'required',
            'amount' => 'required|numeric|min:0',
            'edit_expense_category'=>'required'

        ]);

        if ($request->amount < 0) {
            return response()->json([
                'status' => 400,
                'errors' => 'Amount Section must be positive'
            ]);
        }

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => 'Update Fail Fill All Section'
            ]);
        } else {
            $getExpenseDetails = ExpenseDetail::find($id);

            $getExpenseData = Expense::find($getExpenseDetails->expense_id);
            $getExpenseData->expense_category_id = $request->edit_expense_category;

            $getExpenseData->expense_name = $request->expense;
            $getExpenseData->save();

            $getExpenseDetails->amount = $request->amount;
            $getExpenseDetails->notes = $request->notes;

            $getExpenseDetails->save();

            return response()->json([
                'status' => 200,
                'success' => 'Expense Update Successfully'
            ]);
        }
    }
    public function delete_expense($id)
    {
        $getExpenseDetails = ExpenseDetail::find($id);



        $getExpense = Expense::find($getExpenseDetails->expense_id);

        $getExpense->delete();

        $getExpenseDetails->delete();

        return response()->json([
            'status' => 200,
            'delete' => 'Expense Delete Successfully'
        ]);
    }
}
