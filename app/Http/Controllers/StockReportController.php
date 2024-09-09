<?php

namespace App\Http\Controllers;


use App\Models\FinalStockTable;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Session;

class StockReportController extends Controller
{
    public function PWS($product_id)
    {
        $locations = FinalStockTable::join('stores', 'stores.store_id', '=', 'final_stock_table.store_id')
            ->where('final_stock_table.product_id', '=', $product_id)
            ->where('final_stock_table.final_quantity', '>', 0)
            ->select('stores.*', 'final_stock_table.final_quantity')
            ->get();

        return response()->json($locations);
    }
    public function CatWiseStock($category_id)
    {
        $locations = FinalStockTable::join('products', 'products.product_id', '=', 'final_stock_table.product_id')
                    ->join('stores', 'stores.store_id', '=', 'final_stock_table.store_id')
                    ->select('final_stock_table.*', 'stores.store_name', 'products.unit_type', 'products.product_name')
                    ->whereIn('products.sc_one_id', function($query) use ($category_id) {
                        $query->select('sub_category_one.sc_one_id')
                              ->from('sub_category_one')
                              ->where('sub_category_one.category_id', $category_id);
                    })
                    ->get();

        return response()->json($locations);
    }
    public function PWAQ($product_id)
    {
        $stock = FinalStockTable::join('stores', 'stores.store_id', '=', 'final_stock_table.store_id')
            ->where('final_stock_table.product_id', '=', $product_id)
            ->select('stores.*', 'final_stock_table.final_quantity')
            ->get();

        return response()->json($stock);
    }
    public function PWR($product_id)
    {
        $locations = Store::select('stores.*')
            ->get();

        return response()->json($locations);
    }
    public function PWSD($store_id, $product_id)
    {
        $qty = FinalStockTable::where('final_stock_table.product_id', '=', $product_id)
            ->where('final_stock_table.store_id', '=', $store_id)
            ->select('final_stock_table.final_quantity')
            ->first();

        // return ($qty);
        return response()->json($qty);
    }
    public function PWSQ($store_id, $product_id)
    {
        $qty = FinalStockTable::where('final_stock_table.product_id', '=', $product_id)
            ->where('final_stock_table.store_id', '=', $store_id)
            ->select('final_stock_table.final_quantity')
            ->first();

        // return ($qty);
        return response()->json($qty);
    }
    public function stock_report()
    {
        $site_settings = SiteSettings::first();
        $stock_report = FinalStockTable::join('products', 'products.product_id', '=', 'final_stock_table.product_id')
            ->leftJoin('unit_definition', 'unit_definition.unit_id', '=', 'products.unit_type')
            ->join('stores', 'stores.store_id', '=', 'final_stock_table.store_id')
            ->select(
                'final_stock_table.*',
                'products.category_id',
                'products.product_name',
                'products.unit_type',
                'products.image_path',
                'products.product_image',
                'products.is_active',
                'products.cost_price',
                'products.sales_price',
                'products.bulk_price',
                'products.barcode',
                'unit_definition.unit_name',
                'unit_definition.unit_symbol',
                'stores.store_name'
            )
            ->get();

        // $store_stock_report = FinalStockTable::join('products', 'products.product_id', '=', 'final_stock_table.product_id')
        //     ->join('unit_definition', 'unit_definition.unit_id', '=', 'products.unit_type')
        //     ->join('stores', 'stores.store_id', '=', 'final_stock_table.store_id')
        //     ->select(
        //         'final_stock_table.*',
        //         'products.product_name',
        //         'products.unit_type',
        //         'unit_definition.unit_symbol',
        //         'stores.store_name'
        //     )
        //     ->get();
        $product_cat = ProductCategory::all();
        // return view('dashboard.stock.stockReport', compact(['stock_report', 'store_stock_report', 'product_cat']));
        return view('dashboard.stock.stockReport', compact(['stock_report',  'product_cat','site_settings']));
    }

    public function store_stock_report()
    {


        $store_stock_report = FinalStockTable::join('products', 'products.product_id', '=', 'final_stock_table.product_id')
            ->join('unit_definition', 'unit_definition.unit_id', '=', 'products.unit_type')->join('stores', 'stores.store_id', '=', 'final_stock_table.store_id')
            ->select(
                'final_stock_table.*',
                'products.product_name',
                'products.unit_type',
                'unit_definition.unit_symbol',
                'stores.store_name'
            )
            ->get();

        // return $store_stock_report;
        return view('dashboard.stock.storeStockReport', compact(['store_stock_report']));
    }


    public function stock_transfer()
    {
        $site_settings = SiteSettings::first();
        $products = Product::select('products.*')
            ->get();
        $stores = Store::select('stores.*')
            ->get();
        // return $products;
        return view('dashboard.stock.stockTransfer', compact(['products', 'stores','site_settings']));
    }

    public function store_stock_transfer(Request $request)
    {

        $from_store_product = FinalStockTable::where('store_id', '=', $request->from_store)->where('product_id', '=', $request->product_id)
            ->select('final_stock_table.*')
            ->first();
        $from_store_product_exist = FinalStockTable::where('store_id', '=', $request->from_store)->where('product_id', '=', $request->product_id)
            ->select('final_stock_table.*')
            ->exists();

        if (!$from_store_product_exist) {

            return redirect()->back()->with('error', 'This Product not available');
        }
        if ($from_store_product->final_quantity < $request->transfer_quantity) {

            return redirect()->back()->with('error', 'Transfer quantity can not exceed the stock quantity');
        }
        if ($request->transfer_quantity < 0) {

            return redirect()->back()->with('error', 'You cannot transfer Negative Quantity ');
        }
        if ($request->from_store == $request->to_store) {

            return redirect()->back()->with('error', 'You cannot transfer in same store ');
        }

        $to_store_product = FinalStockTable::where('store_id', '=', $request->to_store)->where('product_id', '=', $request->product_id)
            ->select('final_stock_table.*')
            ->first();

        $to_store_product_exist = FinalStockTable::where('store_id', '=', $request->to_store)->where('product_id', '=', $request->product_id)
            ->select('final_stock_table.*')
            ->exists();


        // check to location have same product or not
        if ($to_store_product_exist) {
            $to_store_product->final_quantity =  $to_store_product->final_quantity + $request->transfer_quantity;
            $from_store_product->final_quantity =  $from_store_product->final_quantity - $request->transfer_quantity;
        } else {

            $to_store_product = new FinalStockTable();
            $from_store_product->final_quantity =  $from_store_product->final_quantity - $request->transfer_quantity;
            $to_store_product->product_id = $from_store_product->product_id;
            $to_store_product->final_quantity = $request->transfer_quantity;
            $to_store_product->store_id = $request->to_store;
        }

        $to_store_product->save();
        $from_store_product->save();




        return redirect(Route('backoffice.store-stock-report'));
    }
}
