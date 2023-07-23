<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

    // Use library of tag this library name is tagify 
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'slug'
    ];

    public function products()
    {
        //you can write only this if you 
        return $this->belongsToMany(Product::class);
    }
}
