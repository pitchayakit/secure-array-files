<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'MovexUkraine\SecureArrayFiles\FieldController@index');
Route::post('/upload', 'MovexUkraine\SecureArrayFiles\FieldController@upload');
Route::get('/download/{storage}/{path}/{image}', 'MovexUkraine\SecureArrayFiles\FieldController@download');
Route::delete('/delete/{image}', 'MovexUkraine\SecureArrayFiles\FieldController@delete');
Route::delete('/delete/{path}/{image}', 'MovexUkraine\SecureArrayFiles\FieldController@deleteWithPath');
