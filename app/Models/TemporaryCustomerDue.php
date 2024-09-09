<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TemporaryCustomerDue extends Model
{
	protected $table = 'temporary_customer_due';
	protected $primaryKey = 'due_id';
	public $timestamps = false;

	protected $fillable = [
        'cart_id',
        'delivery_man_id',
        'customer_id',
        'amount'
    ];

// 	public function cart_return_informtion()
// 	{
// 		return $this->belongsTo(CartReturnInfo::class, 'cart_return_id');
// 	}

// 	public function product()
// 	{
// 		return $this->belongsTo(Product::class,'product_id');
// 	}

// 	public function purchaseDetail()
//     {
//         return $this->belongsTo(PurchaseDetail::class, 'stock_id', 'purchase_details_id');
//     }

// 	public function cart_item()
// 	{
// 		return $this->belongsTo(CartItem::class,'cart_item_id');
// 	}
}
