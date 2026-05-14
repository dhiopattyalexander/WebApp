<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaffController;

Route::get('/', function () {
    return view('layouts/home');
});

Route::get('/home', function () {
    return view('layouts/home');
});

Route::get('/about', function () {
    return view('layouts/about');
});

Route::get('/contact', function () {
    return view('layouts/about');
});

Route::get('/staff',[StaffController::class, 'index']
);