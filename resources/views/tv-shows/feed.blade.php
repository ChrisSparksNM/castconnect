<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tvShow->name }} Social Feed - TV Shows & Actors</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 min-h-screen font-['Inter']">
    <!-- Navigation -->
    @include('components.global-navigation')

    <!-- Main Content -->
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('tv-shows.index') }}" class="hover:text-gray-700">TV Shows</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li><a href="{{ route('tv-shows.show', $tvShow) }}" class="hover:text-gray-700">{{ $tvShow->name }}</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900 font-medium">Social Feed</li>
                </ol>
            </nav>

            <!-- Feed Header -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h1 class="text-2xl font-bold text-white mb-2">{{ $tvShow->name }} Social Feed</h1>
                            <p class="text-blue-100">Latest posts from the cast</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl mb-2">📱</div>
                            <div class="text-blue-100 text-sm">{{ $recentPosts->count() }} recent posts</div>
                        </div>
                    </div>
                </div>
            </div>

            @if($recentPosts->count() > 0)
                <!-- Social Media Feed -->
                <div class="space-y-6">
                    @foreach($recentPosts as $post)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Post Header -->
                            <div class="p-4 border-b border-gray-100">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <!-- Actor Avatar -->
                                        <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($post->actor->name, 0, 1) }}
                                        </div>
                                        
                                        <!-- Actor Info -->
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $post->actor->name }}</div>
                                            @if($post->actor->character_name)
                                                <div class="text-sm text-gray-500">{{ $post->actor->character_name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- Platform & Time -->
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center space-x-1 px-2 py-1 rounded-full text-xs font-medium
                                            {{ $post->platform === 'instagram' ? 'bg-pink-100 text-pink-700' : 'bg-gray-100 text-gray-700' }}">
                                            <span>{{ $post->platform_icon }}</span>
                                            <span>{{ ucfirst($post->platform) }}</span>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $post->time_ago }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Post Content -->
                            <div class="p-6">
                                @if($post->content)
                                    <p class="text-gray-800 mb-4 leading-relaxed">{{ $post->content }}</p>
                                @endif
                                
                                @if($post->image_url)
                                    <div class="mb-4">
                                        <img src="{{ $post->image_url }}" 
                                             alt="Post image" 
                                             class="w-full max-w-md mx-auto rounded-lg shadow-md">
                                    </div>
                                @endif
                                
                                <!-- Post Stats -->
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
                                    </div>
                                    
                                    <a href="{{ $post->post_url }}" 
                                       target="_blank" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center space-x-1">
                                        <span>View on {{ ucfirst($post->platform) }}</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="text-6xl mb-6">📱</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Recent Posts</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        We haven't fetched any recent social media posts for {{ $tvShow->name }} cast members yet.
                    </p>
                    <div class="space-y-4">
                        <p class="text-sm text-gray-500">
                            Posts are automatically fetched from actors' Instagram and X accounts.
                        </p>
                        <a href="{{ route('tv-shows.show', $tvShow) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Back to {{ $tvShow->name }}
                        </a>
                    </div>
                </div>
            @endif

            <!-- Back to Show -->
            <div class="mt-12 text-center">
                <a href="{{ route('tv-shows.show', $tvShow) }}" 
                   class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to {{ $tvShow->name }}
                </a>
            </div>
        </div>
    </div>

    <!-- Points Display -->
    @include('components.points-display')
</body>
</html>