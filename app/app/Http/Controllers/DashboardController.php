<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $urls = $request->user()->urls->take(5);

        $mostActiveUrls = $urls->filter(function($url) {
                return $url->clicks->count() > 0;
            })->sortBy(function($url) {
                return $url->clicks->count();
            })->take(10);

        $latestClicks = $request->user()->latestClicks();

        return view('dashboard')
            ->with('urls', $urls)
            ->with('mostActiveUrls', $mostActiveUrls)
            ->with('latestClicks', $latestClicks);
    }
}
