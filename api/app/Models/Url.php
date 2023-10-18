<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Url extends Model
{
    use HasFactory;

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
        // 'formatted_date',
        // 'click_count'
    ];

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
}
