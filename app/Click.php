<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{

    protected $fillable = [
        'url_id',
    ];

    protected $appends = ['formatted_date'];

    public function url()
    {
        return $this->belongsTo('App\Url');
    }

    public function getFormattedDateAttribute()
    {
        return $this->attributes['formatted_date'] = $this->created_at->format('m/d/Y');
    }
}
