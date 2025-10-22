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


Route::get('/transcript', function () {
    $student = [
        'name' => 'Seif Badreldin',
        'id' => '230100575',
        'program' => 'Network & Cyber Security',
        'courses' => [
            ['name' => 'Network Fundamentals', 'grade' => 'A'],
            ['name' => 'Operating Systems', 'grade' => 'B+'],
            ['name' => 'Cybersecurity Basics', 'grade' => 'A-'],
            ['name' => 'Web Security', 'grade' => 'A'],
        ],
    ];
    return view('transcript', compact('student'));
});


Route::get('/products', function () {
    $products = [
        [
            'name' => 'Wireless Mouse',
            'image' => 'https://via.placeholder.com/150',
            'price' => 25.99,
            'description' => 'A smooth and responsive wireless mouse for everyday use.'
        ],
        [
            'name' => 'Mechanical Keyboard',
            'image' => 'https://via.placeholder.com/150',
            'price' => 89.99,
            'description' => 'RGB backlit mechanical keyboard with blue switches.'
        ],
        [
            'name' => 'USB-C Hub',
            'image' => 'https://via.placeholder.com/150',
            'price' => 49.99,
            'description' => 'Connect multiple devices with this 6-in-1 USB-C hub.'
        ],
        [
            'name' => 'Noise Cancelling Headphones',
            'image' => 'https://via.placeholder.com/150',
            'price' => 129.99,
            'description' => 'Enjoy high-quality sound with active noise cancellation.'
        ],
    ];

    return view('products', compact('products'));
});


Route::get('/calculator', function () {
    return view('calculator');
});
