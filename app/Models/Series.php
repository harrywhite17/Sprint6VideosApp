<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_name',
        'user_photo_url',
        'published_at',
        'user_id',
    ];
    protected $casts = [
        'published_at' => 'datetime',
    ];
    public function videos()
    {
        return $this->belongsToMany(Video::class, 'series_video', 'series_id', 'video_id');
    }

    public function testedBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedCreatedAtAttribute()
    {
        return $this->created_at->format('d-m-Y H:i:s');
    }

    public function getFormattedForHumansCreatedAtAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtTimestampAttribute()
    {
        return $this->created_at->timestamp;
    }
}