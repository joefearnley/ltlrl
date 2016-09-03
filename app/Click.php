<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url_id',
    ];

    /**
     * The attributes that are appended to the model.
     *
     * @var array
     */
    protected $appends = ['formatted_date'];

    /**
     * An url belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function url()
    {
        return $this->belongsTo('App\Url');
    }

    /**
     * Get the date attribute with a custom format.
     *
     * @return mixed
     */
    public function getFormattedDateAttribute()
    {
        return $this->attributes['formatted_date'] = $this->created_at->format('m/d/Y');
    }

    public function scopeForUrlGroupedByDate($query, $urlId)
    {
        return $this->select(\DB:raw('count(*) as clicks, data(created_at) as date, created_at'))
            ->where('url_id', $urlId)
            ->groupBy('date');
    }
}
