<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('social_media_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('actor_id')->constrained()->onDelete('cascade');
            $table->enum('platform', ['instagram', 'x']);
            $table->string('post_id')->unique(); // Platform-specific post ID
            $table->text('content')->nullable();
            $table->string('image_url')->nullable();
            $table->string('post_url');
            $table->timestamp('posted_at');
            $table->integer('likes_count')->default(0);
            $table->integer('comments_count')->default(0);
            $table->json('raw_data')->nullable(); // Store full API response
            $table->timestamps();
            
            $table->index(['actor_id', 'platform', 'posted_at']);
            $table->index(['posted_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_posts');
    }
};
