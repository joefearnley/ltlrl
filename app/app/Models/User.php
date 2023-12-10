<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get the user's Urls
     */
    public function urls(): HasMany
    {
        return $this->hasMany(Url::class)
            ->with('clicks')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Get the user's most active Urls
     */
    public function mostActiveUrls()
    {
        return $this->urls->filter(function($url) {
            return $url->clicks->count() > 0;
        })->sortByDesc(function($url) {
            return $url->clicks->count();
        })->take(10);
    }

    /**
     * Get the user's latest active Urls
     */
    public function latestClicks()
    {
        $urlIds = $this->urls->pluck('id')->toArray();

        return Click::whereIn('url_id', $urlIds)
            ->distinct('url_id')
            ->orderBy('created_at')
            ->limit(5)
            ->get();
    }
}
