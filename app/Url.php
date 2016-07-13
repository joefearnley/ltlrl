<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{

    protected $fillable = [
        'url', 'key', 'user_id',
    ];

    protected $appends = ['link', 'formatted_date'];

    public function link()
    {
        return config('app.url') . '/' . $this->key;
    }

    public function getLinkAttribute()
    {
        return $this->attributes['link'] = $this->link();
    }

    public function getFormattedDateAttribute()
    {
        return $this->attributes['formatted_date'] = $this->created_at->format('m/d/Y');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
