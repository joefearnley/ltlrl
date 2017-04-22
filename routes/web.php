<?php
    use Hashids\Hashids;

Route::get('temp', function() {


    $hashids = new Hashids('safwfwfe', 6);

    echo '<pre>';
    var_dump($hashids->encode(1));
    var_dump($hashids->encode(2));
    var_dump($hashids->encode(3));
    die();
});

Route::auth();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('account', 'AccountController@index');
Route::get('account/urls', 'AccountController@urlList');
Route::get('account/settings', 'AccountController@settings');

Route::get('/', 'HomeController@index');
Route::get('/{key}', 'HomeController@redirect');

Route::get('url/{id}', 'UrlController@show');
Route::post('url/create', 'UrlController@create');
Route::post('url/update', 'UrlController@update');
Route::post('url/delete/{id}', 'UrlController@delete');
Route::get('url/stats/{id}', 'UrlController@clickStats');

Route::get('/api/account/urls', 'AccountController@urls');
Route::get('/api/account/info', 'AccountController@info');
Route::post('/api/account/update-personal-info', 'AccountController@updatePersonalInfo');
Route::post('/api/account/update-password', 'AccountController@updatePassword');
