<?php

Route::auth();

Route::get('/', 'HomeController@index');
Route::post('url/create', 'UrlController@create');

Route::get('/account', 'AccountController@index');