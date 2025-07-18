<?php

namespace App\Services;

use App\Models\Actor;
use App\Models\SocialMediaPost;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SocialMediaService
{
    /**
     * Fetch and store recent posts for all actors
     */
    public function fetchAllActorPosts()
    {
        $actors = Actor::whereNotNull('instagram_handle')
            ->orWhereNotNull('x_handle')
            ->get();

        foreach ($actors as $actor) {
            $this->fetchActorPosts($actor);
        }
    }

    /**
     * Fetch posts for a specific actor
     */
    public function fetchActorPosts(Actor $actor)
    {
        if ($actor->hasInstagram()) {
            $this->fetchInstagramPosts($actor);
        }

        if ($actor->hasX()) {
            $this->fetchXPosts($actor);
        }
    }

    /**
     * Fetch Instagram posts (using mock data for demo)
     * In production, you'd use Instagram Basic Display API
     */
    private function fetchInstagramPosts(Actor $actor)
    {
        try {
            // For demo purposes, we'll create mock posts
            // In production, replace with actual Instagram API calls
            $this->createMockInstagramPosts($actor);
            
            Log::info("Fetched Instagram posts for {$actor->name}");
        } catch (\Exception $e) {
            Log::error("Failed to fetch Instagram posts for {$actor->name}: " . $e->getMessage());
        }
    }

    /**
     * Fetch X/Twitter posts (using mock data for demo)
     * In production, you'd use Twitter API v2
     */
    private function fetchXPosts(Actor $actor)
    {
        try {
            // For demo purposes, we'll create mock posts
            // In production, replace with actual Twitter API calls
            $this->createMockXPosts($actor);
            
            Log::info("Fetched X posts for {$actor->name}");
        } catch (\Exception $e) {
            Log::error("Failed to fetch X posts for {$actor->name}: " . $e->getMessage());
        }
    }

    /**
     * Create mock Instagram posts for demonstration
     */
    private function createMockInstagramPosts(Actor $actor)
    {
        $mockPosts = [
            [
                'content' => "Behind the scenes from today's shoot! 🎬 #acting #setlife",
                'image_url' => 'https://picsum.photos/400/400?random=' . rand(1, 1000),
                'likes_count' => rand(1000, 50000),
                'comments_count' => rand(50, 500),
                'posted_at' => Carbon::now()->subHours(rand(1, 72))
            ],
            [
                'content' => "Grateful for all the love and support from fans! ❤️ #grateful #fans",
                'image_url' => 'https://picsum.photos/400/400?random=' . rand(1, 1000),
                'likes_count' => rand(1000, 50000),
                'comments_count' => rand(50, 500),
                'posted_at' => Carbon::now()->subDays(rand(1, 7))
            ],
            [
                'content' => "New project announcement coming soon... 👀 #excited #newproject",
                'image_url' => null,
                'likes_count' => rand(1000, 50000),
                'comments_count' => rand(50, 500),
                'posted_at' => Carbon::now()->subDays(rand(1, 14))
            ]
        ];

        foreach ($mockPosts as $index => $postData) {
            $postId = 'ig_' . $actor->id . '_' . time() . '_' . $index;
            
            SocialMediaPost::updateOrCreate(
                [
                    'actor_id' => $actor->id,
                    'platform' => 'instagram',
                    'post_id' => $postId
                ],
                [
                    'content' => $postData['content'],
                    'image_url' => $postData['image_url'],
                    'post_url' => "https://instagram.com/p/{$postId}",
                    'posted_at' => $postData['posted_at'],
                    'likes_count' => $postData['likes_count'],
                    'comments_count' => $postData['comments_count'],
                    'raw_data' => $postData
                ]
            );
        }
    }

    /**
     * Create mock X/Twitter posts for demonstration
     */
    private function createMockXPosts(Actor $actor)
    {
        $mockPosts = [
            [
                'content' => "Just wrapped filming for the day. What an incredible cast and crew to work with! 🎭",
                'likes_count' => rand(500, 10000),
                'comments_count' => rand(20, 200),
                'posted_at' => Carbon::now()->subHours(rand(1, 48))
            ],
            [
                'content' => "Thank you to everyone who watched last night's episode. Your reactions mean everything! 📺✨",
                'likes_count' => rand(500, 10000),
                'comments_count' => rand(20, 200),
                'posted_at' => Carbon::now()->subDays(rand(1, 5))
            ],
            [
                'content' => "Coffee and script reading. Perfect way to start the morning ☕📖 #actorlife",
                'likes_count' => rand(500, 10000),
                'comments_count' => rand(20, 200),
                'posted_at' => Carbon::now()->subDays(rand(1, 10))
            ]
        ];

        foreach ($mockPosts as $index => $postData) {
            $postId = 'x_' . $actor->id . '_' . time() . '_' . $index;
            
            SocialMediaPost::updateOrCreate(
                [
                    'actor_id' => $actor->id,
                    'platform' => 'x',
                    'post_id' => $postId
                ],
                [
                    'content' => $postData['content'],
                    'image_url' => null,
                    'post_url' => "https://x.com/{$actor->x_handle}/status/{$postId}",
                    'posted_at' => $postData['posted_at'],
                    'likes_count' => $postData['likes_count'],
                    'comments_count' => $postData['comments_count'],
                    'raw_data' => $postData
                ]
            );
        }
    }

    /**
     * Clean up old posts (older than specified days)
     */
    public function cleanupOldPosts($days = 90)
    {
        $cutoffDate = Carbon::now()->subDays($days);
        
        $deletedCount = SocialMediaPost::where('posted_at', '<', $cutoffDate)->delete();
        
        Log::info("Cleaned up {$deletedCount} old social media posts");
        
        return $deletedCount;
    }
}