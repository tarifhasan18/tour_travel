<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;
    protected $table = 'payment_details';
	protected $primaryKey = 'id';
    protected $fillable=[
        'booking_id',
        'date',
        'payment_type_id',
        'paid_amount',
        'reference',
        'payment_slip',
        'is_verified',
        'approved_by',
    ];

}
