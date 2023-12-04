<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $urls = $request->user()->urls->take(5);

        return view('dashboard')->with('urls', $urls);
    }
}
