<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

Route::get('/setup-data', function () {
    if (Category::count() == 0) {
        // 'title' ki jagah 'name' use karein
        Category::create(['name' => 'Technology', 'slug' => 'technology']);
        Category::create(['name' => 'Lifestyle', 'slug' => 'lifestyle']);
        Category::create(['name' => 'AI', 'slug' => 'ai']);
    }
    return "Categories created successfully with correct field names!";
});

Route::get('/', function () {
    return view('welcome');
});
