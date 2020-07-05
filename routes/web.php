<?php

use Illuminate\Support\Facades\Auth;
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
Route::get('/getData', 'CategoryController@getData');
Route::post('/saveTree', 'CategoryController@saveTree');

Route::get('', 'CategoryController@index');
Route::post('', 'CategoryController@store');
Route::put('', 'CategoryController@update');
