<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/minitest', function () {
    $bill = [
        'customer' => 'Seif Mohamed',
        'date' => date('Y-m-d'),
        'items' => [
            ['name' => 'Milk', 'qty' => 2, 'price' => 25],
            ['name' => 'Bread', 'qty' => 1, 'price' => 15],
            ['name' => 'Eggs', 'qty' => 1, 'price' => 30],
            ['name' => 'Butter', 'qty' => 1, 'price' => 40],
        ],
    ];

    return view('minitest', ['bill' => $bill]);
});

Route::get('/transcript', function () {
    $transcript = [
        'student' => 'Seif Mohamed',
        'id' => '230100575',
        'program' => 'BSc Computer Science',
        'courses' => [
            ['code' => 'CS101', 'name' => 'Introduction to Programming', 'grade' => 'A'],
            ['code' => 'CS102', 'name' => 'Data Structures', 'grade' => 'B+'],
            ['code' => 'CS103', 'name' => 'Database Systems', 'grade' => 'A-'],
            ['code' => 'CS104', 'name' => 'Computer Networks', 'grade' => 'B'],
            ['code' => 'CS105', 'name' => 'Web Security', 'grade' => 'A'],
        ]
    ];

    return view('transcript', ['transcript' => $transcript]);
});

Route::get('/products', function () {
    $products = [
        [
            'name' => 'Honey Jar',
            'image' => 'honey.jpg',
            'price' => 45,
            'description' => 'Pure natural honey from local farms.'
        ],
        [
            'name' => 'Olive Oil',
            'image' => 'olive_oil.jpg',
            'price' => 60,
            'description' => 'Extra virgin olive oil, 100% organic.'
        ],
        [
            'name' => 'Almonds Pack',
            'image' => 'almonds.jpg',
            'price' => 80,
            'description' => 'Crunchy and fresh almonds pack (250g).'
        ],
    ];

    return view('products', ['products' => $products]);
});


Route::get('/calculator', function () {
    return view('calculator');
});


Route::get('/gpa', function () {
    $courses = [
        ['code' => 'CS101', 'title' => 'Programming Fundamentals', 'credits' => 3],
        ['code' => 'CS102', 'title' => 'Data Structures', 'credits' => 4],
        ['code' => 'CS103', 'title' => 'Database Systems', 'credits' => 3],
        ['code' => 'CS104', 'title' => 'Networks', 'credits' => 3],
        ['code' => 'CS105', 'title' => 'Operating Systems', 'credits' => 4],
    ];
    return view('gpa', ['courses' => $courses]);
});



use App\Http\Controllers\UserController;

Route::resource('users', UserController::class);

use App\Http\Controllers\GradeController;

Route::resource('grades', GradeController::class);



use App\Http\Controllers\QuestionController;

// CRUD
Route::resource('questions', QuestionController::class);

// Exam
Route::get('exam/start', [QuestionController::class, 'startExam'])->name('questions.start');
Route::post('exam/submit', [QuestionController::class, 'submitExam'])->name('questions.submit');
Route::get('/questions/start', [QuestionController::class, 'startExam'])->name('questions.startExam');


