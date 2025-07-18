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
}
