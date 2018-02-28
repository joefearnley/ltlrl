<?php

Auth::routes();

Route::get('logout','LogoutController@logout');

Route::get('/', 'HomeController@index');
Route::get('/{key}', 'HomeController@redirect');

Route::get('url/{id}', 'UrlController@show');
Route::post('url/create', 'UrlController@create');
Route::post('url/update', 'UrlController@update');
Route::post('url/delete/{id}', 'UrlController@delete');
Route::get('url/stats/{id}', 'UrlController@clickStats');

Route::get('/user/urls', 'UserController@urls');

Route::get('account', 'AccountController@index');
Route::get('account/urls', 'AccountController@urls');
Route::get('account/settings', 'AccountController@settings');
Route::get('/api/account/info', 'AccountController@info');
//Route::post('/api/account/update-personal-info', 'AccountController@updatePersonalInfo');
//Route::post('/api/account/update-password', 'AccountController@updatePassword');
