<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Url;
use App\Click;

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

    /**
     * Redirect to intended url.
     *
     * @param $key
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirect(Request $request, $key)
    {
        $url = Url::where('key', $key)->firstOrFail();

        Click::create([
            'url_id' => $url->id,
            'ip' => $request->ip()
        ]);

        return redirect()->away($url->url);
    }
}
