<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    /**
     * A user has many urls.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urls()
    {
        return $this->hasMany('App\Url');
    }

    /**
     * Determine the number of days the user's had an account.
     *
     * @return mixed
     */
    public function daysMakingUrlsLittle()
    {
        return Carbon::now()->diffInDays($this->created_at);
    }

    /**
     * Calculate the number of urls the user has made.
     *
     * @return int
     */
    public function urlsMade()
    {
        return $this->urls->count();
    }

    /**
     * Calculate the number of user's url that were clicked on.
     *
     * @return int
     */
    public function urlsClickedOn()
    {
        return $this->urls->map(function($url) {
            return $url->clicks->count();
        })->sum();
    }
}
