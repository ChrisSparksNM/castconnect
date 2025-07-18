<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    protected $fillable = [
        'tv_show_id',
        'name',
        'character_name',
        'instagram_handle',
        'x_handle'
    ];

    public function tvShow()
    {
        return $this->belongsTo(TvShow::class);
    }

    public function socialMediaPosts()
    {
        return $this->hasMany(SocialMediaPost::class);
    }

    public function recentPosts($days = 30)
    {
        return $this->socialMediaPosts()
            ->recent($days)
            ->orderBy('posted_at', 'desc');
    }

    public function instagramPosts()
    {
        return $this->socialMediaPosts()->byPlatform('instagram');
    }

    public function xPosts()
    {
        return $this->socialMediaPosts()->byPlatform('x');
    }

    public function hasInstagram()
    {
        return !empty($this->instagram_handle);
    }

    public function hasX()
    {
        return !empty($this->x_handle);
    }

    public function getInstagramUrlAttribute()
    {
        return $this->instagram_handle ? 'https://instagram.com/' . ltrim($this->instagram_handle, '@') : null;
    }

    public function getXUrlAttribute()
    {
        return $this->x_handle ? 'https://x.com/' . ltrim($this->x_handle, '@') : null;
    }
}
