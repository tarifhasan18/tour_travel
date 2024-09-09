<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailNotification;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'bookings';
    protected $fillable = [
        'customer_name', 'email', 'phone', 'address','no_of_travellers', 'allergy', 'package_id', 'status','package_price','total_payable','discount','final_payable','paid_amount','due','is_paid'
    ];
    public function Packages()
    {
        //return $this->hasOne('App\Models\Packages','id','package_id');
        return $this->belongsTo('App\Models\Packages', 'package_id', 'id');

    }
    // Listen for saved event to update package availability
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($booking) {
            // Update package availability when a booking status is approved
            if ($booking->status === 'Approved') {
                $booking->Packages->refreshAvailability();
            }
        });
    }
}
