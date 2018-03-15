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

        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            return $next($request);
        });
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
     * Get the url list view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function urls()
    {
        return view('account.urls');
    }

    /**
     * Show the account settings page.
     *
     * @return $this
     */
    public function settings()
    {
        return view('account.settings')
            ->with('user', $this->user);
    }
}
