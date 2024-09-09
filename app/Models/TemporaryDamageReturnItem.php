<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TemporaryDamageReturnItem extends Model
{
	protected $table = 'temporary_damage_return_items';
	protected $primaryKey = 'damage_item_id';
	public $timestamps = false;

	protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
        'rate',
        'total',
        'received_by_id',
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
