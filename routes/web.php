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

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/uploads', 'HomeController@store')->name('store');

Route::post('/home/upload', 'InterviewController@store')->name('interview.store');

Route::get('interview/{id}', 'InterviewController@show')->name('interview.show');
Route::get('/interview',function(){
    return view('interview.index');
});

Route::post('/videostore', 'InterviewController@add')->name('videos.store');
