<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/minitest', function () {
    $bill = [
        'customer' => 'John Doe',
        'date' => '2025-10-22',
        'items' => [
            ['name' => 'Apples', 'qty' => 2, 'price' => 3.50],
            ['name' => 'Bread', 'qty' => 1, 'price' => 2.00],
            ['name' => 'Milk', 'qty' => 1, 'price' => 1.75],
            ['name' => 'Rice (1kg)', 'qty' => 2, 'price' => 5.00],
        ],
    ];

    return view('minitest', compact('bill'));
});
