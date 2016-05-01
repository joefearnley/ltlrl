<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Url;

class HomeController extends Controller
{
    /**
     * Show the main page with form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }

    public function redirect($key)
    {
        $url = Url::where('key', $key)->firstOrFail();

        $url->clicks++;
        $url->save();

        return redirect()->away($url->url);
    }
}
