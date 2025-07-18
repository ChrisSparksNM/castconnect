<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActorSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'tv_show_id',
        'actor_name',
        'character_name',
        'instagram_handle',
        'x_handle',
        'status',
        'admin_notes',
        'reviewed_at',
        'reviewed_by'
    ];

    protected $casts = [
        'reviewed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tvShow()
    {
        return $this->belongsTo(TvShow::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
