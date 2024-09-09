<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DamageReturnItem extends Model
{
    protected $table = 'damage_return_items';
    protected $primaryKey = 'damage_item_id';
    public $timestamps = false;
    public $incrementing = true;

    protected $fillable = [
        'cart_return_id',
    ];


}
