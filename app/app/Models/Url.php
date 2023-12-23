<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

class Url extends Model
{
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
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
        'little_url',
        // 'click_count'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
        ];
    }

    /**
     * Create the url's little url version
     */
    protected function littleUrl(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => config('app.url') . '/' . $attributes['key'],
        );
    }

    /**
     * An url belongs to a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user's Urls'
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function urls(): HasMany
    {
        return $this->hasMany(Url::class);
    }

    /**
     * Get the url's Clicks
     *
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clicks(): HasMany
    {
        return $this->hasMany(Click::class);
    }

    /**
     * Get the url's Clicks for the last week
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function clicksThisWeek(): Collection
    {
        $date = Carbon::now()->subDays(7)->startOfDay();

        return $this->clicks
            ->where('created_at', '>=', $date);
    }

    /**
     * Get the url's Clicks for the last month
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function clicksThisMonth(): Collection
    {
        $date = Carbon::now()->subMonths(1)->startOfDay();

        return $this->clicks
            ->where('created_at', '>=', $date);
    }

    /**
     * Get the url's Clicks for the last year
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function clicksThisYear(): Collection
    {
        $date = Carbon::now()->subYears(1)->startOfDay();

        return $this->clicks
            ->where('created_at', '>=', $date);
    }
}
