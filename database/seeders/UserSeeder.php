<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'osama',
            'email' => 'osama@gmail.com',
            'password' => Hash::make('password'),
            'phone' => '1234567891',
            'first_name' => 'osama',
            'last_name' => 'safi',
            'bio' => 'osama safi 25 ago',
            'birthday' => '2001-11-18',
            'city' => 'غزة',
            'area' => 'الرمال',
            'user_img' => '***********',
        ]);
    }
}
