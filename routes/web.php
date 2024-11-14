<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ViewController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [ViewController::class, 'index'])->name('login');
Route::get('/register', [ViewController::class,'register'])->name('showRegisterForm');
Route::get('/dashboard', [ViewController::class, 'dashboard'])->name('dashboard');
Route::get('/addProduct', [ViewController::class, 'addProduct'])->name('addProduct');
Route::get('/viewProduct', [ViewController::class, 'viewProduct'])->name('viewProduct');
