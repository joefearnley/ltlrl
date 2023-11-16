<?php

namespace App\Http\Services;
use App\Models\Url;


class UrlService
{

    public function store(array $userData): Url
    {
        $hashids = new Hashids('', 6);

        $url = Url::create([
            'title' => $request->title,
            'url' => $request->url,
            'user_id' => !is_null($request->user()) ? $request->user()->id : null,
        ]);

        $url->key = $hashids->encode($url->id);
        $url->save();

        return $url;
    }
}
