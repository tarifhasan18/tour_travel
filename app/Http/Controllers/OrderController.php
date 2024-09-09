<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BannerInformation;
use App\Models\CartInformtion;
use App\Models\CartItem;
use App\Models\CartTemporary;
use App\Models\ConsumerLogin;
use App\Models\ProductCategory;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function suspendedOrders()
    {
        $site_settings = SiteSettings::first();
        $CartTemporary = CartTemporary::join('backoffice_login as usr', 'usr.login_id', '=', 'cart_temporary.created_by')->join('backoffice_login as wtr', 'wtr.login_id', '=', 'cart_temporary.waiter_id')
            ->where('is_suspended', 1)
            ->select('cart_temporary.*', 'usr.full_name as created_by_name', 'wtr.full_name as waiter_name')
            ->get();
        return view('sales.suspendedOrder', compact(['CartTemporary','site_settings']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailySalesReport()
    {
        $site_settings = SiteSettings::first();
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        //  if($user_data->role_id==4){
            if(0){
            $current_date = Carbon::now()->format('Y-m-d');
        $CartInfo = CartInformtion::join('users as usr', 'usr.id', '=', 'cart_informtion.created_by') //->join('backoffice_login as wtr', 'wtr.login_id', '=', 'cart_informtion.waiter_id')
            ->where('cart_informtion.cart_date', 'like', '%' . $current_date . '%')
            ->where('cart_informtion.is_vat_show',1)
            ->select('cart_informtion.*', 'usr.name as created_by_name') //, 'wtr.full_name as waiter_name')
            ->get();

        return view('sales.dailySalesReport', compact(['CartInfo','site_settings']));
         }
         else{
            $current_date = Carbon::now()->format('Y-m-d');
            $CartInfo = CartInformtion::join('users as usr', 'usr.id', '=', 'cart_informtion.created_by') //->join('backoffice_login as wtr', 'wtr.login_id', '=', 'cart_informtion.waiter_id')
                ->where('cart_informtion.cart_date', 'like', '%' . $current_date . '%')
                ->select('cart_informtion.*', 'usr.name as created_by_name') //, 'wtr.full_name as waiter_name')
                // ->toSql();
                ->get();
                // dd($CartInfo);

            return view('sales.dailySalesReport', compact(['CartInfo','site_settings']));
         }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function allSalesReport()
    {
        $site_settings = SiteSettings::first();
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
        //  if($user_data->role_id==4){
            if(0){
            $CartInfo = CartInformtion::join('backoffice_login as usr', 'usr.login_id', '=', 'cart_informtion.created_by') //->join('backoffice_login as wtr', 'wtr.login_id', '=', 'cart_informtion.waiter_id')
            ->where('cart_informtion.is_vat_show',1)
            ->select('cart_informtion.*', 'usr.full_name as created_by_name') //, 'wtr.full_name as waiter_name')
            ->get();
        $consumer = ConsumerLogin::all();
        return view('sales.allSalesReport', compact(['CartInfo', 'consumer','site_settings']));
         }
         else{
            $CartInfo = CartInformtion::join('backoffice_login as usr', 'usr.login_id', '=', 'cart_informtion.created_by') //->join('backoffice_login as wtr', 'wtr.login_id', '=', 'cart_informtion.waiter_id')
            ->select('cart_informtion.*', 'usr.full_name as created_by_name') //, 'wtr.full_name as waiter_name')
            ->get();
        $consumer = ConsumerLogin::all();
        return view('sales.allSalesReport', compact(['CartInfo', 'consumer','site_settings']));
         }

    }

    public function monthSalesReport()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;
        $user_id = session()->get('LoggedUser');
        $user_data = \App\Models\BackofficeLogin::join('backoffice_role', 'backoffice_role.role_id', '=', 'backoffice_login.role_id')
            ->where('login_id', $user_id)
            ->first();
         if($user_data->role_id==4){
            $CartInfo = CartInformtion::join('backoffice_login as usr', 'usr.login_id', '=', 'cart_informtion.created_by')
            ->where('cart_informtion.is_vat_show',1)
            ->whereYear('cart_date', $currentYear)
            ->whereMonth('cart_date', $currentMonth)
            ->select('cart_informtion.*', 'usr.full_name as created_by_name')
            ->get();

            $consumer = ConsumerLogin::all();

            return view('sales.monthSalesReport', compact(['CartInfo', 'consumer']));
        }
        else
        {
            $CartInfo = CartInformtion::join('backoffice_login as usr', 'usr.login_id', '=', 'cart_informtion.created_by')
            ->whereYear('cart_date', $currentYear)
            ->whereMonth('cart_date', $currentMonth)
            ->select('cart_informtion.*', 'usr.full_name as created_by_name')
            ->get();
            $consumer = ConsumerLogin::all();
            return view('sales.monthSalesReport', compact(['CartInfo', 'consumer']));
        }

    }

    public function allSalesReportShowVatAdmin(Request $request){
        $getAllId = $request->selectedRowIds;
        $CartInfo = CartInformtion::whereIn('cart_id',$getAllId)->get();
        foreach($CartInfo as $CartInfo){
            $CartInfo->is_vat_show = 1;
            $CartInfo->save();
        }
        return response()->json([
            'status'=> 200,
            'success'=>'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function aboutRestaurant()
    {
        $bannerInfo = BannerInformation::first();
        return view('sales.aboutRestaurant', compact(['bannerInfo']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function printInvoice($id)
    {
        $CartInformtionForPrint = CartInformtion::join('cart_items', 'cart_items.cart_id', '=', 'cart_informtion.cart_id')
            ->join('products', 'products.product_id', '=', 'cart_items.product_id')
            ->where('cart_informtion.cart_id', $id)
            ->select('cart_informtion.*', 'cart_items.*', 'products.product_name', 'products.cost_price', 'products.sales_price', 'products.bulk_price')
            ->get();

        $CartInformtion = CartInformtion::find($id);

           //I have added to Convert cart_date to Carbon instance
        $CartInformtion->cart_date = \Carbon\Carbon::parse($CartInformtion->cart_date);

        return view('sales/print/printInvoice', compact(['CartInformtion', 'CartInformtionForPrint']));
    }

    public function CatWiseSell($consumer_id)
    {
        $sells = CartInformtion::join('backoffice_login as usr', 'usr.login_id', '=', 'cart_informtion.created_by') //->join('backoffice_login as wtr', 'wtr.login_id', '=', 'cart_informtion.waiter_id')
            ->where('cart_informtion.consumer_id', $consumer_id)
            ->select('cart_informtion.*', 'usr.full_name as created_by_name') //, 'wtr.full_name as waiter_name')
            ->get();

        return response()->json($sells);
    }
    public function productNameQuantity($cart_id)
    {
        $cart_item_data = CartItem::join('products', 'products.product_id', '=', 'cart_items.product_id')
            ->where('cart_items.cart_id', $cart_id)
            ->select('cart_items.quantity', 'products.product_name')
            ->get();

        return response()->json($cart_item_data);
    }

    // public function CatWiseSell($category_id)
    // {
    //     $CartInfo = CartInformtion::join('backoffice_login as usr', 'usr.login_id', '=', 'cart_informtion.created_by') //->join('backoffice_login as wtr', 'wtr.login_id', '=', 'cart_informtion.waiter_id')
    //         ->select('cart_informtion.*', 'usr.full_name as created_by_name') //, 'wtr.full_name as waiter_name')
    //         ->get();
    //     $product_cat = ProductCategory::all();
    //     return view('sales.allSalesReport', compact(['CartInfo', 'product_cat']));
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
