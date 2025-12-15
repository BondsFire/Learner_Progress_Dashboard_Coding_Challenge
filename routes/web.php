<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/hello', 'App\Http\Controllers\HelloController@index');
Route::get('/learner-progress', 'App\Http\Controllers\LearnerProgressController@index');

