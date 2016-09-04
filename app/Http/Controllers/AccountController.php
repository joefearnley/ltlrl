<?php

namespace App\Http\Controllers;

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
        $this->user = Auth::user();
    }

    /**
     * Show the main account area.
     *
     * @return mixed
     */
    public function index()
    {
        return view('account.index')
            ->with('user', $this->user);
    }

    /**
     * Get the urls of the authenticated account.
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
        return view('account.settings')->with('user', $this->user);
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

        $user = $this->user->find($request->input('id'));

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

        $user = $this->user->find($request->input('id'));
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return response()->json([
            'success' => true,
            'user' => $user
        ]);
    }
}
