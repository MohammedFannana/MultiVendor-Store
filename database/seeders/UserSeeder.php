<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Mohammed Fannana',
            'email'=>'mohamed.fannana10@gmail.com',
            'password'=>Hash::make('123456789'),
            'phone_number'=>'9702235635232',
        ]);
    }
}
