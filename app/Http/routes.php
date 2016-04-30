<?php

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/{key}', 'HomeController@redirect');
Route::post('url/create', 'UrlController@create');

Route::get('/account/dashboard', 'AccountController@index');