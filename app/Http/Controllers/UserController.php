<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
//use Auth;

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
        $this->user = \Auth::user();
    }

    /**
     * Get the urls of user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function urls()
    {

        echo '<pre>';
        var_dump($this->user());
        die();

        return response()->json([
            'urls' => $urls
        ]);
    }
}
