<?php
namespace App\Helpers;
// SalesForm Data Helper

use App\Models\CartTemporary;


class Helper{
    public function SalesFormDataHelper($id)
    {
        
        $cart_temporary_data = CartTemporary::join('cart_temporary_items', 'cart_temporary_items.temp_cart_id', '=', 'cart_temporary.temp_cart_id')
            ->join('products', 'products.product_id', '=', 'cart_temporary_items.product_id')
            ->join('final_stock_table', 'final_stock_table.stock_id', '=', 'cart_temporary_items.stock_id')
            ->where('cart_temporary.temp_cart_id', '=', $id)
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

        return $cart_temporary_data;
    }
}

?>