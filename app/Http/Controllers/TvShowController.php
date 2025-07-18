<?php

namespace App\Http\Controllers;

use App\Models\TvShow;
use App\Models\Actor;
use Illuminate\Http\Request;

class TvShowController extends Controller
{
    public function index()
    {
        $tvShows = TvShow::with('actors')->orderBy('name')->get();
        return view('tv-shows.index', compact('tvShows'));
    }

    public function show(TvShow $tvShow)
    {
        $tvShow->load('actors');
        return view('tv-shows.show', compact('tvShow'));
    }
}
