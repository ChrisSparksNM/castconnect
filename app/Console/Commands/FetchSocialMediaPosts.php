<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchSocialMediaPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'social:fetch-posts {--actor= : Fetch posts for specific actor ID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest social media posts from actors Instagram and X accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $socialMediaService = app(\App\Services\SocialMediaService::class);
        
        $actorId = $this->option('actor');
        
        if ($actorId) {
            $actor = \App\Models\Actor::find($actorId);
            if (!$actor) {
                $this->error("Actor with ID {$actorId} not found.");
                return 1;
            }
            
            $this->info("Fetching posts for {$actor->name}...");
            $socialMediaService->fetchActorPosts($actor);
            $this->info("✅ Completed fetching posts for {$actor->name}");
        } else {
            $this->info("Fetching posts for all actors...");
            $socialMediaService->fetchAllActorPosts();
            $this->info("✅ Completed fetching posts for all actors");
        }
        
        return 0;
    }
}
