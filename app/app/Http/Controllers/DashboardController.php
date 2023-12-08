<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $userUrls = $request->user()->urls;

        $recentUrls = $userUrls->take(5);

        $mostActiveUrls = $userUrls->filter(function($url) {
                return $url->clicks->count() > 0;
            })->sortByDesc(function($url) {
                return $url->clicks->count();
            })->take(10);

        $latestClicks = $request->user()->latestClicks();

        return view('dashboard')
            ->with('recentUrls', $recentUrls)
            ->with('mostActiveUrls', $mostActiveUrls)
            ->with('latestClicks', $latestClicks);
    }
}
