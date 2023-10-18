<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUrlRequest;
use App\Http\Requests\UpdateUrlRequest;
use App\Models\Url;
use App\Http\Resources\UrlResource;
use Hashids\Hashids;

class UrlController extends Controller
{
    /**
     * Instantiate a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('store');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Illuminate\Http\Request
     */
    public function index(Request $request)
    {
        $urls = $request->user()->urls;

        return UrlResource::collection($urls);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param App\Http\Requests\StoreUrlRequest
     * @return App\Http\Resources\UrlResource
     */
    public function store(StoreUrlRequest $request)
    {
        $hashids = new Hashids('', 6);

        $url = Url::create([
            'title' => $request->title,
            'url' => $request->url,
            'user_id' => $request->user_id,
        ]);

        $url->key = $hashids->encode($url->id);
        $url->save();

        return new UrlResource($url);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUrlRequest $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
