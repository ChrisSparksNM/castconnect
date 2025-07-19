<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TV Actor Twitter Feed - TV Shows & Actors</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen font-['Inter']">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-gray-900">📺 TV & Actors</h1>
                    </a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('tv-shows.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                        Browse Shows
                    </a>
                    <a href="{{ route('tv-shows.global-feed') }}" class="text-blue-600 bg-blue-50 px-3 py-2 rounded-md text-sm font-medium">
                        🐦 Twitter Feed
                    </a>
                    <a href="{{ route('leaderboard.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                        🏆 Leaderboard
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            Sign up
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Feed Header -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-gray-900 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-2">🐦 TV Actor Twitter Feed</h1>
                            <p class="text-blue-100">Tweets from your favorite TV show actors</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl mb-2">𝕏</div>
                            <div class="text-blue-100 text-sm">{{ $recentPosts->count() }} tweets</div>
                        </div>
                    </div>
                </div>
            </div>

            @if($recentPosts->count() > 0)
                <!-- Twitter Feed -->
                <div class="space-y-6">
                    @foreach($recentPosts as $post)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Tweet Header -->
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <!-- Actor Avatar -->
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-gray-900 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($post->actor->name, 0, 1) }}
                                        </div>
                                        
                                        <!-- Actor & Show Info -->
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $post->actor->name }}</div>
                                            <div class="text-sm text-gray-500">
                                                @if($post->actor->character_name)
                                                    {{ $post->actor->character_name }} • 
                                                @endif
                                                {{ $post->actor->tvShow->name }}
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Platform & Time -->
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center space-x-1 px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            <span>𝕏</span>
                                            <span>Twitter</span>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $post->posted_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tweet Content -->
                            <div class="p-6">
                                @if($post->content)
                                    <p class="text-gray-800 mb-4 leading-relaxed text-lg">{{ $post->content }}</p>
                                @endif
                                
                                @if($post->image_url)
                                    <div class="mb-4">
                                        <img src="{{ $post->image_url }}" 
                                             alt="Tweet image" 
                                             class="w-full max-w-md mx-auto rounded-lg shadow-md">
                                    </div>
                                @endif
                                
                                <!-- Tweet Stats -->
                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <div class="flex items-center space-x-6 text-sm text-gray-500">
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"/>
                                            </svg>
                                            <span>{{ number_format($post->likes_count) }}</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                            </svg>
                                            <span>{{ number_format($post->comments_count) }}</span>
                                        </div>
                                        @if(isset($post->raw_data['retweets_count']))
                                            <div class="flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                <span>{{ number_format($post->raw_data['retweets_count'] ?? 0) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex items-center space-x-3">
                                        <!-- Show Badge -->
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full">
                                            {{ $post->actor->tvShow->name }}
                                        </span>
                                        
                                        <!-- View on Twitter -->
                                        <a href="{{ $post->post_url }}" 
                                           target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center space-x-1">
                                            <span>View on 𝕏</span>
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Load More Section -->
                <div class="mt-12 text-center">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Want to see more?</h3>
                        <p class="text-gray-600 mb-4">
                            This feed shows {{ $recentPosts->count() }} tweets from TV show actors across all shows.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('tv-shows.index') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                Browse TV Shows
                            </a>
                            @auth
                                <a href="{{ route('actor-submissions.create') }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                    Add More Actors
                                </a>
                            @else
                                <a href="{{ route('register') }}" 
                                   class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                    Join to Contribute
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="text-6xl mb-6">🐦</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Recent Tweets</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        We haven't found any recent Twitter posts from TV show actors in the last 30 days.
                    </p>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500">
                            Tweets are automatically collected from actors' Twitter accounts.
                        </p>
                        <a href="{{ route('tv-shows.index') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Browse TV Shows
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Points Display -->
    @include('components.points-display')
</body>
</html>