<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{

    protected $fillable = [
        'url', 'key', 'user_id',
    ];

    protected $appends = ['link'];

    public function link()
    {
        return config('app.url') . '/' . $this->key;
    }

    public function getLinkAttribute()
    {
        return $this->attributes['link'] = $this->link();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
