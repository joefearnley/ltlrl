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

    public function show($id)
    {
        $url = Url::find($id);

        return response()->json($url);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = URL::create([
            'url' => $request->input('url'),
            'key' => $this->randomLibGenerator->generateString(6, $this->characters),
            'user_id' => Auth::check() ? Auth::id() : null
        ]);

        return response()->json([
            'success' => true,
            'url' => $url
        ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = Url::find($request->input('id'));
        $url->url = $request->input('url');
        $url->save();

        return response()->json([
            'success' => true,
            'url' => $url
        ]);
    }

    public function delete($id)
    {
        Url::destroy($id);

        return response()->json([
            'success' => true
        ]);
    }
}
