<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Packages extends Model
{
    use HasFactory;
    protected $table = 'packages';
	protected $primaryKey = 'id';
    protected $fillable=[
        'name',
        'location',
        'description',
        'price_dollar',
        'price_taka',
        'startdate',
        'enddate',
        'capacity',
        'available',
        'image',
        'special_instruction'


    ];
     // Define the relationship with the Booking model (optional if needed)
     public function bookings()
     {
        //  return $this->hasMany(Booking::class);
        return $this->hasMany('App\Models\Booking', 'package_id','id');
     }
     // Define an accessor to get availability dynamically
    // public function getAvailabilityAttribute()
    // {
    //     return $this->capacity - $this->available;
    // }

    // Method to refresh availability based on approved bookings
   // Method to refresh availability based on approved bookings
   public function refreshAvailability()
   {
       $approvedTravellers = $this->bookings()
           ->where('status', 'approved')
           ->sum('no_of_travellers');

       $this->available = $this->capacity - $approvedTravellers;
       $this->save();
   }

}
