<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Click extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url_id',
        'ip',
    ];

    /**
     * A click belongs to an url.
     *
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Url::class);
    }
}
