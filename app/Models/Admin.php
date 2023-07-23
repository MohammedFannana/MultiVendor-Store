<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

// change extends Model to User 
class Admin extends User
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'phone_number', 'super_admin', 'status',
    ];
}
