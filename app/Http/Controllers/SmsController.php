<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sendTextMessage(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required|phone',
            'phone' => 'The :attribute field contains an invalid number.',
        ]);
    }
}
