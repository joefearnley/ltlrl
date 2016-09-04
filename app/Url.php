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
        return Click::select(DB::raw('count(*) as clicks, DATE(created_at) as date, created_at'))
            ->where('url_id', $this->id)
            ->where('created_at', '>', Carbon::now()->subWeeks(2))
            ->groupBy('date')
            ->get();
    }

    /**
     * Get the number of clicks per day over the last two weeks.
     *
     * @return \Illuminate\Support\Collection
     */
    public function latestStats()
    {
        $clickData = $this->clicksByDate();
        $latestStats = collect([]);

        // Starting two weeks ago from today, loop over each day.
        for ($i = 13; $i >= 0; $i--) {
            // set date to day, clicks to 0
            $data = [
                'date' => Carbon::now()->subDays($i)->format('m/d'),
                'clicks' => 0
            ];

            foreach ($clickData as $cd) {
                // if the day exists in $clickData, add set click count for that day
                if ($data['date'] === $cd->created_at->format('m/d')) {
                    $data['clicks'] = (int) $cd->clicks;
                }
            }

            $latestStats->push($data);
        }

        return $latestStats;
    }
}
