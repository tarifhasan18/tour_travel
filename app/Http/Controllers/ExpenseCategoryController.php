<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function expense_category_list()
    {
        $site_settings = SiteSettings::first();
        $all_expense_category_datas = ExpenseCategory::all();
        return view('Expense Category.expenseCategoryList', ['all_expense_category_datas' => $all_expense_category_datas,'site_settings'=>$site_settings]);
    }
    public function add_expense_category()
    {
        $site_settings = SiteSettings::first();
        return view('Expense Category.addExpenseCategory',compact('site_settings'));
    }

    public function insert_expense_category(Request $request)
    {
        //Validate Inputs
        $request->validate([
            'expense_category_name' => 'required'
        ]);

        $insert_datas = new ExpenseCategory;

        $insert_datas->expense_category_name = $request->expense_category_name;
        $insert_datas->is_default = 0;
        $insert_datas->is_active = 1;
        $save =   $insert_datas->save();
        if ($save) {
            return redirect()->to('expense-category-list')->with('success', 'Expense Category Add SuccessFully');
        } else {
            return redirect()->back()->with('fail', 'Something went wrong, Please Try Again');
        }
    }

    public function edit_expense_category($id)
    {
        $site_settings = SiteSettings::first();
        $getdata = ExpenseCategory::find($id);

        return view('Expense Category.editExpenseCategory', ['getdatas' => $getdata,'site_settings'=>$site_settings]);
    }

    public function update_expense_category(Request $request, $id)
    {
        //Validate Inputs
        $request->validate([
            'expense_category_name' => 'required',
            'is_active' => 'required',
        ]);


        $update_data = ExpenseCategory::find($id);
        $update_data->expense_category_name =  $request->expense_category_name;
        $update_data->is_active =  $request->is_active;
        $save =  $update_data->save();
        if ($save) {
            return redirect()->to('expense-category-list')->with('update', 'Expense Category Update SuccessFully');
        } else {
            return redirect()->back()->with('updatefail', 'Something went wrong, Please Try Again');
        }
    }
}
