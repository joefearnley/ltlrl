<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUrlRequest;
use App\Http\Requests\UpdateUrlRequest;
use App\Models\Url;
use Hashids\Hashids;

class UrlController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth')
            ->except(['redirect']);

        $this->authorizeResource(Url::class, 'url');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $urls = $request->user()->urls;

        return view('urls.url-list')->with('urls', $urls);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('urls.create-url');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUrlRequest $request)
    {
        $url = Url::create([
            'title' => $request->title,
            'url' => $request->url,
            'user_id' => $request->user()->id,
        ]);

        $hashids = new Hashids('', 6);
        $url->key = $hashids->encode($url->id);
        $url->save();

        return redirect()->route('urls.index')
            ->with('message', 'Url has been created.')
            ->with('littleUrl', $url->little_url);
    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url)
    {
        return view('urls.show-url')->with('url', $url);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Url $url)
    {
        return view('urls.edit-url')->with('url', $url);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUrlRequest $request, Url $url)
    {
        $url->title = $request->title;
        $url->url = $request->url;
        $url->save();

        return redirect()->route('urls.index')
            ->with('message', 'Url has been updated.')
            ->with('urlTitle', $url->title)
            ->with('littleUrl', $url->little_url);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Url $url)
    {
        $url->delete();

        return redirect()->route('urls.index')
            ->with('message', 'Url has been deleted.')
            ->with('urlTitle', $url->title)
            ->with('littleUrl', $url->little_url);
    }
}
