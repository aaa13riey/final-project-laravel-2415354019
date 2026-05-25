<?php

use Illuminate\Support\Facades\Route;

// Redirect halaman utama langsung ke customers
Route::get('/', function () {
    return redirect('/customers');
});

// Route untuk merender Tampilan (Blade)
Route::get('/customers', function () {
    return view('customers.index');
});

Route::get('/services', function () {
    return view('services.index');
});

Route::get('/subscriptions', function () {
    return view('subscriptions.index');
});