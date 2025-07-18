<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule social media posts fetching
Schedule::command('social:fetch-posts')->hourly();

// Clean up old posts weekly
Schedule::call(function () {
    $service = app(\App\Services\SocialMediaService::class);
    $service->cleanupOldPosts(90); // Keep posts for 90 days
})->weekly();
