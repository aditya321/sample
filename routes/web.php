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
Route::group(["middleware"=>['auth']], function (){
    Route::get('/home', 'HomeController@home')->name('home');
    Route::get('/', 'HomeController@home');
    Route::get('/home1', 'HomeController@index')->name('home1');
    Route::get('/form', function () {
        return view('form');
    });
    Route::post('/submitForm', 'HomeController@submitForm');
    Route::get('/getFormData', 'HomeController@getFormData')->name('sample.index');
    Route::post('addNote', 'HomeController@addNote');
});

Auth::routes();
