<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Url;
// use App\Models\Click;

class RedirectUrlController extends Controller
{
    /**
     * Redirect to intended url.
     */
    public function redirect(Request $request, $key)
    {
        $url = Url::where('key', $key)->firstOrFail();

        // Click::create([
        //     'url_id' => $url->id,
        //     'ip' => $request->ip()
        // ]);

        return redirect()->away($url->url);
    }
}
