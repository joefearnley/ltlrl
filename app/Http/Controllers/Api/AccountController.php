<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * User instance.
     *
     * @var
     */
    private $user;



    /**
     * Create a new account controller instance.
     *
     * AccountController constructor.
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
     * Get the account's user's urls.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function urls()
    {
        return response()->json([
            'urls' => $this->user->urls
        ]);
    }

    /**
     * Get User information associated with account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function info()
    {
        return response()->json($this->user);
    }

    /**
     * Update a users personal account information.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePersonalInfo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $this->user->name = $request->input('name');
        $this->user->email = $request->input('email');
        $this->user->save();

        return response()->json([
            'success' => true,
            'user' => $this->user
        ]);
    }

    /**
     * Update the account's password.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6|confirmed',
        ]);

        $this->user->password = bcrypt($request->input('password'));
        $this->user->save();

        return response()->json([
            'success' => true,
            'user' => $this->user
        ]);
    }
}
