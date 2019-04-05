<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function send(Request $request)
    {
        // echo '<pre>';
        // var_dump($request->all());
        // die();

        $this->validate($request, [
            'phone' => 'required'
        ]);

    }
}
