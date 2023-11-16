<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Display the home/welcome page
     *
     *   @param Illuminate\Http\Request
     */
    public function index()
    {
        return view('welcome');
    }
}
