<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SocialMediaPost extends Model
{
    protected $fillable = [
        'actor_id',
        'platform',
        'post_id',
        'content',
        'image_url',
        'post_url',
        'posted_at',
        'likes_count',
        'comments_count',
        'raw_data'
    ];

    protected $casts = [
        'posted_at' => 'datetime',
        'raw_data' => 'array',
        'likes_count' => 'integer',
        'comments_count' => 'integer'
    ];

    public function actor()
    {
        return $this->belongsTo(Actor::class);
    }

    public function tvShow()
    {
        return $this->hasOneThrough(TvShow::class, Actor::class, 'id', 'id', 'actor_id', 'tv_show_id');
    }

    public function scopeRecent($query, $days = 30)
    {
        return $query->where('posted_at', '>=', Carbon::now()->subDays($days));
    }

    public function scopeByPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    public function getTimeAgoAttribute()
    {
        return $this->posted_at->diffForHumans();
    }

    public function getPlatformIconAttribute()
    {
        return $this->platform === 'instagram' ? '📸' : '𝕏';
    }

    public function getPlatformColorAttribute()
    {
        return $this->platform === 'instagram' ? 'pink' : 'gray';
    }
}
