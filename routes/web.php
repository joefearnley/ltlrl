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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
