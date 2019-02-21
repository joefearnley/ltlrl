<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function send(Request $request)
    {
        $this->validate($request, [
            'phone' => 'The :attribute field contains an invalid number.',
        ]);
    }
}