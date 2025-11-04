<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isEmployee()) {
            return redirect()->route('employee.dashboard');
        } else {
            return redirect()->route('products.index');
        }
    }
    return view('welcome');
})->name('home');

// Test route
Route::get('/test-auth', function() {
    return response()->json([
        'users_count' => \App\Models\User::count(),
        'roles_count' => \App\Models\Role::count(),
        'sample_user' => \App\Models\User::first(['email', 'name']),
    ]);
});

// Test products without auth
Route::get('/test-products', function() {
    $count = \App\Models\Product::count();
    $products = \App\Models\Product::with('category')->limit(3)->get();
    return response()->json([
        'products_count' => $count,
        'sample_products' => $products,
        'auth_check' => auth()->check(),
        'user' => auth()->user() ? auth()->user()->email : 'not logged in'
    ]);
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

// Product Routes
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    
    // Customer product purchase routes
    Route::middleware('role:Customer')->group(function () {
        Route::post('/products/{product}/buy', [ProductController::class, 'buy'])->name('products.buy');
        Route::get('/products/insufficient-credit', [ProductController::class, 'insufficientCredit'])->name('products.insufficient-credit');
        Route::get('/my-purchases', [ProductController::class, 'myPurchases'])->name('products.my-purchases');
    });
});

// Admin Routes
Route::middleware(['auth', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Employee Management
    Route::get('/employees', [AdminController::class, 'employees'])->name('employees');
    Route::get('/employees/create', [AdminController::class, 'createEmployee'])->name('employees.create');
    Route::post('/employees', [AdminController::class, 'storeEmployee'])->name('employees.store');
    Route::get('/employees/{employee}/edit', [AdminController::class, 'editEmployee'])->name('employees.edit');
    Route::put('/employees/{employee}', [AdminController::class, 'updateEmployee'])->name('employees.update');
    Route::delete('/employees/{employee}', [AdminController::class, 'destroyEmployee'])->name('employees.destroy');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    
    // Roles Management
    Route::get('/roles', [AdminController::class, 'roles'])->name('roles');
});

// Employee Routes
Route::middleware(['auth', 'role:Employee'])->prefix('employee')->name('employee.')->group(function () {
    Route::get('/dashboard', [EmployeeController::class, 'index'])->name('dashboard');
    
    // Customer Management
    Route::get('/customers', [EmployeeController::class, 'customers'])->name('customers');
    Route::get('/customers/{customer}/charge-credit', [EmployeeController::class, 'showChargeCredit'])->name('customers.charge-credit');
    Route::post('/customers/{customer}/charge-credit', [EmployeeController::class, 'chargeCredit'])->name('customers.charge-credit.store');
    
    // Product Management
    Route::get('/products', [EmployeeController::class, 'products'])->name('products');
    Route::get('/products/create', [EmployeeController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [EmployeeController::class, 'storeProduct'])->name('products.store');
    Route::get('/products/{product}/edit', [EmployeeController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [EmployeeController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [EmployeeController::class, 'destroyProduct'])->name('products.destroy');
    Route::post('/products/{product}/stock', [EmployeeController::class, 'updateStock'])->name('products.update-stock');
});
