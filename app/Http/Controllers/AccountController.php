<?php

namespace App\Http\Controllers;

use App\Libraries\AccountTotals;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class AccountController extends Controller
{
    /**
     * Create a new account controller instance.
     *
     * AccountController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the main account area.
     *
     * @return mixed
     */
    public function index()
    {
        $accountTotals = new AccountTotals(Auth::user());
        $accountTotals->calculate();

        return view('account.index')
            ->with('accountTotals', $accountTotals);
    }

    /**
     * Get the urls of the authenticated account.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function urls()
    {
        $response = [
            'urls' => Auth::user()->urls
        ];

        return response()->json($response);
    }

    /**
     * Get the url list view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function urlList()
    {
        return view('account.urlList');
    }

    /**
     * Show the account settings page.
     *
     * @return $this
     */
    public function settings()
    {
        return view('account.settings')->with('user', Auth::user());
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

        $user = User::find($request->input('id'));

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
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

        $user = User::find($request->input('id'));
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
