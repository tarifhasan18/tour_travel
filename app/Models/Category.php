<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_name'
    ];
    // public function products()
    // {
    //    return $this->hasMany('App\Models\Products', 'category_id','id');
    //    //return $this->hasMany(Products::class);
    // }

    public function products()
    {
        return $this->hasMany(Products::class, 'category_id', 'id');
    }
}
