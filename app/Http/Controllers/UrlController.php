<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Url;

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
     * Create an instance of the url controller class.
     *
     * @param \RandomLib\Factory $factory
     */
    public function __construct(\RandomLib\Factory $factory)
    {
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
        $url = Url::find($id);

        return response()->json($url->clicksGroupedByDate());
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

        $url = URL::create([
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

        $url = Url::find($request->input('id'));
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
        Url::destroy($id);

        return response()->json([
            'success' => true
        ]);
    }
}
