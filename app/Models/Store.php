<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory, Notifiable;

    // protected $table = 'stores';
    // protected $connection = 'mysql'; //مشروح اخر الفيديو 5 
    // protected $primaryKey = 'id';
    // protected $KeyType = 'int';
    //public $incrementing = true;
    //public $timestamp = true;

    //relation with products

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id', 'id');
    }
}
