<?php

Route::group(['middleware' => 'web'], function () {
    Route::get('/', 'HomeController@index');
    Route::post('url/create', 'UrlController@create');
});