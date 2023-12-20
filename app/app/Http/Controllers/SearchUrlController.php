<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Url;

class SearchUrlController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->s;

        $urls = Url::search($searchTerm)
            ->where('user_id', $request->user()->id)
            ->get();

            return view('urls.url-list')
                ->with('urls', $urls)
                ->with('searchTerm', $searchTerm);
    }
}
