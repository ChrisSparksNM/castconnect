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
}
