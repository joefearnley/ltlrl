<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display the home/welcome page
     *
     *   @param Illuminate\Http\Request
     */
    public function index()
    {
        return view('welcome');
    }


    /**
     * Create a new Url in storage.
     */
    public function creteUrl(StoreUrlRequest $request)
    {
        $hashids = new Hashids('', 6);

        $url = Url::create([
            'title' => $request->title,
            'url' => $request->url,
            'user_id' => !is_null($request->user()) ? $request->user()->id : null,
        ]);

        $url->key = $hashids->encode($url->id);
        $url->save();

        return redirect('home')->with('url', $url);
    }
}
