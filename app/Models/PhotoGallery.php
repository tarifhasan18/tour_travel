<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhotoGallery extends Model
{
    use HasFactory;
        // Specify the table name
        protected $table = 'photo_gallery';

        // If your table doesn't have timestamps columns, you can disable them
        public $timestamps = false;

           // If your primary key is not 'id', you can specify it like this
        protected $primaryKey = 'id';
}
