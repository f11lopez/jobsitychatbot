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

// Site root route displaying the chatbot & all available currencies
Route::get('/', [App\Http\Controllers\CurrencyController::class, 'showAvailableCurrencies']);

// Home route
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth route
Auth::routes();

// Botman route
Route::match(['get', 'post'], '/botman', 'Chatbot\ChatbotController@handle');