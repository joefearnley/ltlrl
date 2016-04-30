<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Url;

class UrlController extends Controller
{
    private $randomLibGenerator;
    private $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function __construct(\RandomLib\Factory $factory)
    {
        $this->randomLibGenerator = $factory->getMediumStrengthGenerator();
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = URL::create([
            'url' => $request->get('url'),
            'key' => $this->randomLibGenerator->generateString(6, $this->characters),
            'user_id' => Auth::check() ? Auth::id() : null
        ]);

        return redirect('/')->with('newUrl',  $url->link());
    }
}
