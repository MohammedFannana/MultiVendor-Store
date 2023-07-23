<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Cart extends Model
{
    use HasFactory;

    //because the id is not increment
    public $incrementing = false;

    protected $fillable = [
        'cookie_id', 'user_id', 'product_id', 'quantity', 'options',
    ];

    //Events (observers)
    //creating, created, updating,updated ,saving,saved
    //deleting,deleted ,restoring,restored

    //use event and lisener to create uuid before insert in product in database
    protected static function booted()
    {
        // Cart Model
        static::creating(function (Cart $cart) {
            $cart->id = Str::uuid();
        });
    }

    //build relation between carts and user
    //use withDefault([]) to prevent error because the user can be nullable
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Anonymous'
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
