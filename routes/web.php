<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ReportController;

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

// Route::resource('product', ProductController::class);
Route::get('/product', [ProductController::class,'index']);
Route::get('/product/{id}',[ProductController::class,'show']);
Route::post('product/{id}',[ProductController::class,'insertData'])->name('insertData');
Route::get('about', [ProductController::class, 'about']);
Route::get('contact', [ProductController::class, 'contact']);

Route::resource('admin', AdminController::class);
Route::get('admin/{id}/report', [HistoryController::class,'report']);

Route::resource('report', ReportController::class);

Route::get('pesan/{id}', [PesanController::class, 'index']);
Route::post('pesan/{id}', [PesanController::class, 'pesan']);
Route::get('checkout', [PesanController::class, 'checkout']);
Route::delete('checkout/{id}', [PesanController::class, 'delete']);

Route::get('konfirmasi-checkout', [PesanController::class, 'konfirmasi']);

Route::get('profile', [ProfileController::class, 'index']);
Route::post('profile', [ProfileController::class, 'update']);

Route::get('history', [HistoryController::class, 'index']);
Route::get('history/{id}', [HistoryController::class, 'detail']);
Route::get('history/{id}/report', [HistoryController::class,'report']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
