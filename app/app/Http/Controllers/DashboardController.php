<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $urls = $request->user()->urls->take(5);

        // $mostActiveUrls = $request->user()->mostActiveUrls();

        // $mostActiveUrls = Url::

        $mostActiveUrls = DB::table('urls')
                ->select('urls.*', DB::raw('count(clicks.id) as click_count'))
                ->leftJoin('clicks', 'urls.id', '=', 'clicks.url_id')
                ->groupBy('urls.id')
                ->havingRaw('click_count > 0')
                ->orderBy('click_count', 'desc')
                ->get();

        dd($mostActiveUrls->toArray());

        return view('dashboard')
            ->with('urls', $urls)
            ->with('mostActiveUrls', $mostActiveUrls);
    }
}
