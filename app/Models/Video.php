<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'user_id',
        'description',
        'url',
        'published_at',
        'previous_id',
        'next_id',
        'series_id',
        'is_default',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    protected $casts = [
        'published_at' => 'datetime',
        'is_default' => 'boolean',
    ];

    public function getFormattedPublishedAtAttribute()
    {
        if ($this->published_at) {
            return $this->published_at->format('d \d\e F \d\e Y');
        }
        return null;
    }

    public function getFormattedForHumansPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->diffForHumans() : null;
    }

    public function getPublishedAtTimestampAttribute()
    {
        return $this->published_at ? $this->published_at->timestamp : null;
    }
}