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
        $tvShow->load(['actors.socialMediaPosts' => function($query) {
            $query->orderBy('posted_at', 'desc')->limit(3);
        }]);
        
        // Get recent social media feed for this show
        $recentPosts = $tvShow->recentFeed(20)->get();
        
        return view('tv-shows.show', compact('tvShow', 'recentPosts'));
    }

    public function feed(TvShow $tvShow)
    {
        $recentPosts = $tvShow->recentFeed(50)->get();
        
        return view('tv-shows.feed', compact('tvShow', 'recentPosts'));
    }
}
