<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;

Route::get('/', function () {
    return view('welcome');
});

// Route to display the list of customers with pagination
Route::resource('customers', CustomerController::class);