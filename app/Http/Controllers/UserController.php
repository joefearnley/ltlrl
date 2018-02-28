<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    /**
     * Get the urls of user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function urls()
    {
        if (Auth::check()) {
            return response()->json([
                'urls' => Auth::user()->urls
            ]);
        }

        return response()->json([
            'message' => 'Unauthenticated.'
        ], 401);
    }
}
