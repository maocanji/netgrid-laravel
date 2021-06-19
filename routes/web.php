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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin_user', 'HomeController@admin_user')->name('admin_user');
Route::get('/todos_user', 'HomeController@todos_user')->name('todos_user');
Route::get('/comentarios', 'HomeController@comentarios')->name('comentarios');
Route::post('traer_servicios', 'HomeController@traer_servicios')->name('traer_servicios');
Route::get('modal_detalle_servicios', 'HomeController@modal_detalle_servicios')->name('modal_detalle_servicios');

Route::post('update_usuario', 'HomeController@update_usuario')->name('update_usuario');
Route::post('eliminar_usuario', 'HomeController@eliminar_usuario')->name('eliminar_usuario');
