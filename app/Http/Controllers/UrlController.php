<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Url;
use Carbon\Carbon;

class UrlController extends Controller
{
    /**
     * Random string generator.
     *
     * @var \RandomLib\Generator
     */
    private $randomLibGenerator;

    /**
     * The characters to be used to generate the random characters.
     *
     * @var string
     */
    private $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /**
     * Url model instance
     *
     * @var Url
     */
    private $url;

    /**
     *  Create an instance of the url controller class.
     *
     *
     * @param Url $url
     * @param \RandomLib\Factory $factory
     */
    public function __construct(Url $url, \RandomLib\Factory $factory)
    {
        $this->url = $url;
        $this->randomLibGenerator = $factory->getMediumStrengthGenerator();
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
            'key' => $this->randomLibGenerator->generateString(6, $this->characters),
            'user_id' => Auth::check() ? Auth::id() : null
        ]);

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
