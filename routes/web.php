<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Models\Category;

Route::get('/setup-data', function () {
    // 1. Pehle check karein agar category pehle se nahi hai
    if (Category::count() == 0) {
        Category::create(['title' => 'Technology', 'slug' => 'technology']);
        Category::create(['title' => 'Lifestyle', 'slug' => 'lifestyle']);
        Category::create(['title' => 'AI', 'slug' => 'ai']);
    }
    return "Categories created successfully!";
});

Route::get('/', function () {
    return view('welcome');
});
