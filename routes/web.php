<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/setup-admin', function () {
    $user = User::create([
        'name' => 'Admin User',
        'email' => 'admin@test.com', // 👈 Apna email yahan likhein
        'password' => Hash::make('password123'), // 👈 Apna password yahan likhein
    ]);
    return "Admin created successfully!";
});

Route::get('/', function () {
    return view('welcome');
});
