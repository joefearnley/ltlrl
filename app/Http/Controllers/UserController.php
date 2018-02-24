<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * User instance.
     *
     * @var
     */
    private $user;

    /**
     * Create a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
    }

    /**
     * Get the urls of user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function urls()
    {
        return response()->json([
            'urls' => $this->user->urls
        ]);
    }
}
