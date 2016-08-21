<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'key', 'user_id',
    ];

    /**
     * The attributes that are appended to the model.
     *
     * @var array
     */
    protected $appends = ['link', 'formatted_date', 'click_count'];

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
}
