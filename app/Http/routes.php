<?php

Route::auth();

Route::get('/temp', function() {

    echo '<pre>';
    var_dump(env('APP_ENV'));
    die();
});

Route::get('/', 'HomeController@index');
Route::get('/{key}', 'HomeController@redirect');
Route::post('url/create', 'UrlController@create');

Route::get('/account/dashboard', 'AccountController@index');

Route::get('/api/account/urls', 'AccountController@urls');
