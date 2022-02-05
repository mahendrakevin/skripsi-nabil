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

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\AdminController'], function () {
    Route::get('/', 'AdminDashboardController@index')->name('admin.dashboard.index')->middleware('admin');
});

Route::group(['prefix' => 'kepsek', 'namespace' => 'App\Http\Controllers\KepsekController'], function () {
    Route::get('/', 'KepsekDashboardController@index')->name('kepsek.dashboard.index')->middleware('kepsek');
});

Route::group(['prefix' => 'bendahara', 'namespace' => 'App\Http\Controllers\BendaharaController'], function () {
    Route::get('/', 'BendaharaDashboardController@index')->name('bendahara.dashboard.index')->middleware('bendahara');
});
