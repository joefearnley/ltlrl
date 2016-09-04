<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;
use App\Click;

class Url extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'key',
        'user_id'
    ];

    /**
     * The attributes that are appended to the model.
     *
     * @var array
     */
    protected $appends = [
        'link',
        'formatted_date',
        'click_count'
    ];

    /**
     * Link of the url.
     *
     * @return string
     */
    public function link()
    {
        return config('app.url') . '/' . $this->key;
    }

    /**
     * Set the link model attribute.
     *
     * @return string
     */
    public function getLinkAttribute()
    {
        return $this->attributes['link'] = $this->link();
    }

    /**
     * Set the formatted date model attribute.
     *
     * @return mixed
     */
    public function getFormattedDateAttribute()
    {
        return $this->attributes['formatted_date'] = $this->created_at->format('m/d/Y');
    }

    /**
     * Set the click count model attribute.
     *
     * @return mixed
     */
    public function getClickCountAttribute()
    {
        return $this->attributes['click_count'] = $this->clicks->count();
    }

    /**
     * An url belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * An url has many clicks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clicks()
    {
        return $this->hasMany('App\Click');
    }

    /**
     * Query scope to get click count by date.
     *
     * @return mixed
     */
    public function clicksByDate()
    {
//        return $this->clicks->filter(function($url) {
//            return $url->created_at->gt(Carbon::now()->subWeeks(2));
//        })->groupBy('formatted_date');

        return Click::select(DB::raw('count(*) as clicks, DATE(created_at) as date, created_at'))
            ->where('url_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subWeeks(2))
            ->groupBy('date')
            ->get();
    }
}
