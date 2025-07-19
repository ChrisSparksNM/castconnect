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
            $query->where('posted_at', '>=', now()->subYears(5))
                  ->orderBy('posted_at', 'desc')->limit(3);
        }]);
        
        // Get social media feed for this show (expanded time range for historical data)
        $recentPosts = $tvShow->recentFeed(20, 1825)->get(); // 5 years = ~1825 days
        
        return view('tv-shows.show', compact('tvShow', 'recentPosts'));
    }

    public function feed(TvShow $tvShow)
    {
        // Expanded time range to show historical posts (5 years)
        $recentPosts = $tvShow->recentFeed(50, 1825)->get(); // 5 years = ~1825 days
        
        return view('tv-shows.feed', compact('tvShow', 'recentPosts'));
    }

    public function globalFeed()
    {
        // Get Twitter posts from all shows, mixed together
        // Expanded time range to show historical posts since scraped data may be older
        $recentPosts = \App\Models\SocialMediaPost::with(['actor.tvShow'])
            ->where('platform', 'x') // Only Twitter/X posts
            ->where('posted_at', '>=', now()->subYears(5)) // Last 5 years to include historical posts
            ->orderBy('posted_at', 'desc')
            ->limit(100)
            ->get();

        return view('tv-shows.global-feed', compact('recentPosts'));
    }
}
