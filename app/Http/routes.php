<?php

Route::auth();

Route::get('/', 'HomeController@index');
Route::get('/{key}', 'HomeController@redirect');
Route::post('url/create', 'UrlController@create');
Route::post('url/update', 'UrlController@update');

Route::get('/account/dashboard', 'AccountController@index');

Route::get('/api/account/urls', 'AccountController@urls');
