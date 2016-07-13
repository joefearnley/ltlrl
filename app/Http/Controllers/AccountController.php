<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('account.index');
    }

    public function urls()
    {
        $response = [
            'urls' => Auth::user()->urls
        ];

        return response()->json($response);
    }
}
