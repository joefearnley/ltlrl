<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $recentUrls = $request->user()->urls->take(5);
        $mostActiveUrls = $request->user()->mostActiveUrls();
        $latestClicks = $request->user()->latestClicks();

        return view('dashboard')
            ->with('recentUrls', $recentUrls)
            ->with('mostActiveUrls', $mostActiveUrls)
            ->with('latestClicks', $latestClicks);
    }
}
