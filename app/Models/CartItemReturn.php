<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CartItemReturn
 *
 * @property int $cart_item_return_id
 * @property int|null $consumer_id
 * @property int|null $cart_id
 * @property int $cart_item_id
 * @property int|null $received_by_id
 * @property string|null $reason_of_return
 * @property string|null $total_amount
 * @property string|null $non_refundable_vat
 * @property string|null $refund_amount
 * @property string|null $return_date
 * @property int|null $authorized_by
 * @property string|null $authorize_date
 * @property string|null $return_status
 *
 * @property CartInformtion|null $cart_informtion
 * @property ConsumerInformation|null $consumer_information
 * @property CartItem $cart_item
 * @property BackofficeLogin|null $backoffice_login
 *
 * @package App\Models
 * cart_return_info
 */
class CartItemReturn extends Model
{
	protected $table = 'cart_item_return';
	protected $primaryKey = 'cart_item_return_id';
	public $timestamps = false;

	protected $fillable = [
        'cart_return_id',
    ];

	public function cart_return_informtion()
	{
		return $this->belongsTo(CartReturnInfo::class, 'cart_return_id');
	}

	public function product()
	{
		return $this->belongsTo(Product::class,'product_id');
	}

	public function purchaseDetail()
    {
        return $this->belongsTo(PurchaseDetail::class, 'stock_id', 'purchase_details_id');
    }

	public function cart_item()
	{
		return $this->belongsTo(CartItem::class,'cart_item_id');
	}
}
