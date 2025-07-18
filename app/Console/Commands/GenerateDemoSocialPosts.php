<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateDemoSocialPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:generate-social-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate demo social media posts for all actors';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $socialMediaService = app(\App\Services\SocialMediaService::class);
        
        $this->info("🚀 Generating demo social media posts...");
        
        $actors = \App\Models\Actor::whereNotNull('instagram_handle')
            ->orWhereNotNull('x_handle')
            ->get();
            
        if ($actors->isEmpty()) {
            $this->warn("No actors with social media handles found.");
            return 1;
        }
        
        $this->info("Found {$actors->count()} actors with social media handles.");
        
        $progressBar = $this->output->createProgressBar($actors->count());
        $progressBar->start();
        
        foreach ($actors as $actor) {
            $socialMediaService->fetchActorPosts($actor);
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        
        $totalPosts = \App\Models\SocialMediaPost::count();
        $this->info("✅ Demo posts generated successfully!");
        $this->info("📊 Total posts in database: {$totalPosts}");
        
        return 0;
    }
}
