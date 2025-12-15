<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\LearnerProgressController@index');
Route::get('/learner-progress', 'App\Http\Controllers\LearnerProgressController@index');

