<?php

Route::auth();

Route::get('account', 'AccountController@index');
Route::get('account/urls', 'AccountController@urlList');
Route::get('account/settings', 'AccountController@settings');

Route::get('/', 'HomeController@index');
Route::get('/{key}', 'HomeController@redirect');

Route::get('url/{id}', 'UrlController@show');
Route::post('url/create', 'UrlController@create');
Route::post('url/update', 'UrlController@update');
Route::post('url/delete/{id}', 'UrlController@delete');
Route::get('url/stats/{id}', 'UrlController@stats');

Route::get('/api/account/urls', 'AccountController@urls');
Route::post('/api/account/update-personal-info', 'AccountController@updatePersonalInfo');
Route::post('/api/account/update-password', 'AccountController@updatePassword');
