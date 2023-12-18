<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $recentUrls = $request->user()->urls->take(5);
        $latestClicks = $request->user()->latestClicks();
        $mostActiveUrls = $request->user()->mostActiveUrls();

        return view('dashboard')
            ->with('recentUrls', $recentUrls)
            ->with('latestClicks', $latestClicks)
            ->with('mostActiveUrls', $mostActiveUrls);
    }
}
