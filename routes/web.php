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
//Home



Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/produto/{product}', 'HomeController@show')->name('product.show');
Route::get('/shopcart', 'ShopcartController@index')->name('shopcart.index');

Route::post('/shopcart/add/','ShopcartController@add' )->name('shopcart.add');
Route::delete('/shopcart/remover', 'shopcartController@remover')->name('shopcart.remover');
Route::post('/shopcart/concluir', 'shopcartController@concluir')->name('shopcart.concluir');
Route::get('/shopcart/compras', 'shopcartController@compras')->name('shopcart.compras');
Route::post('/shopcart/cancelar', 'shopcartController@cancelar')->name('shopcart.cancelar');

Route::get('usuario/create', 'UserController@create')->name('user.create');
Route::post('usuario', 'UserController@store')->name('user.store');
Route::get('usuario/{user}', 'UserController@show')->name('user.show');

//Route::resource('produto','ProductController')->names('product')->parameters(['produto' => 'product']);

