<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;
use Hashids\Hashids;

class WelcomeController extends Controller
{
    /**
     * Display the home/welcome page
     *
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Create an url.
     *
     *   @param Illuminate\Http\Request
     */
    public function createUrl(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = Url::create([
            'url' => $request->url,
        ]);

        $hashids = new Hashids('', 6);
        $url->key = $hashids->encode($url->id);
        $url->save();

        return redirect()->back()
            ->with('message', 'Url has been created.')
            ->with('littleUrl', $url->little_url);
    }
}
