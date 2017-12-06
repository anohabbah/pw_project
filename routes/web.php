<?php

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

Route::redirect('/', '/dashboard', 302)->name('dashboard');

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::resource('categories', 'CategoryController');
Route::get('/producteurs/fetch', 'ProducteurController@fetch')->name('producteurs.fetch');
Route::resource('producteurs', 'ProducteurController');
Route::post('/upload/profile/pic', 'MediaController@store')->name('media.store');
Route::post('/profile/{producteur}/avatar', 'MediaController@update')->name('media.update');
Route::put('/address/{producteur}/visibility', 'AddressController@update')->name('address.update');
Route::put('/account/{producteur}/status', 'AccountController@update')->name('status.update');
