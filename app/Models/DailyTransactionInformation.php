<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DailyTransactionInformation extends Model
{
	protected $table = 'daily_transaction_information';
	protected $primaryKey = 'payment_id';
	public $timestamps = false;
}
