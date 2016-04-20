<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Url;

class UrlController extends Controller
{
    public function create(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = URL::create([
            'url' => $request->get('url'),
            'key' => '123414124124124',
            'user_id' => Auth::check() ? Auth::id() : null
        ]);

        return redirect('/')->with('url',  $url->link());
    }
}
