<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TvShow extends Model
{
    protected $fillable = [
        'name',
        'description',
        'year_started',
        'year_ended',
        'genre'
    ];

    public function actors()
    {
        return $this->hasMany(Actor::class);
    }

    public function submissions()
    {
        return $this->hasMany(ActorSubmission::class);
    }

    public function socialMediaPosts()
    {
        return $this->hasManyThrough(SocialMediaPost::class, Actor::class);
    }

    public function recentFeed($limit = 20, $days = 30)
    {
        return $this->socialMediaPosts()
            ->with(['actor'])
            ->recent($days)
            ->orderBy('posted_at', 'desc')
            ->limit($limit);
    }

    public function getActorsWithSocialMediaAttribute()
    {
        return $this->actors()
            ->where(function($query) {
                $query->whereNotNull('instagram_handle')
                      ->orWhereNotNull('x_handle');
            })
            ->get();
    }
}
