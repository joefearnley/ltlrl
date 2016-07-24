<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $daysMakingUrlsLittle = Carbon::now()->diffInDays(Auth::user()->created_at);

        $urlsMadeLittle = Auth::user()->urls->count();

        $urlsClickedOn = Auth::user()->urls->map(function($url) {
            return $url->clicks->count();
        })->sum();

        return view('account.index')
            ->with('daysMakingUrlsLittle', $daysMakingUrlsLittle)
            ->with('urlsMadeLittle', $urlsMadeLittle)
            ->with('urlsClickedOn', $urlsClickedOn);
    }

    public function urls()
    {
        $response = [
            'urls' => Auth::user()->urls
        ];

        return response()->json($response);
    }

    public function urlList()
    {
        return view('account.urlList');
    }

    public function settings()
    {
        return view('account.settings')->with('user', Auth::user());
    }

    public function updatePersonalInfo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::find($request->input('id'));

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::find($request->input('id'));
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
