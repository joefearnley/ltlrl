<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Url;
use Carbon\Carbon;
use Hashids\Hashids;

class UrlController extends Controller
{
    /**
     * Url model instance
     *
     * @var Url
     */
    private $url;

    /**
     *  Create an instance of the url controller class.
     *
     * @param Url $url
     */
    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    /**
     * Get a specific url instance.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $url = $this->url->find($id);

        return response()->json($url);
    }

    /**
     * Create an url instance.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = $this->url->create([
            'url' => $request->input('url'),
            'user_id' => Auth::check() ? Auth::id() : null
        ]);

        $hashids = new Hashids('', 6);
        $url->key = $hashids->encode($url->id);
        $url->save();

        return response()->json([
            'success' => true,
            'url' => $url
        ]);
    }

    /**
     * Update an url instance.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'url' => 'required|url'
        ]);

        $url = $this->url->find($request->input('id'));
        $url->url = $request->input('url');
        $url->save();

        return response()->json([
            'success' => true,
            'url' => $url
        ]);
    }

    /**
     * Delete an url instance.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->url->destroy($id);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Get the clicks stats for a given url.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function clickStats($id)
    {
        $latestStats = $this->url->find($id)->latestStats();

        return response()->json($latestStats);
    }
}
