<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    protected $fillable = [
        'url', 'key', 'user_id',
    ];

    public function link()
    {
        return config('app.url') . '/' . $this->key;
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
