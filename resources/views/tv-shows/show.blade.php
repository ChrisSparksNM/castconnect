<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tvShow->name }} - TV Shows & Actors</title>
    
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="{{ route('tv-shows.index') }}" class="hover:text-gray-700">TV Shows</a></li>
                    <li><span class="mx-2">/</span></li>
                    <li class="text-gray-900 font-medium">{{ $tvShow->name }}</li>
                </ol>
            </nav>

            <!-- Show Header -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden mb-8">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-8">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-3xl font-bold text-white mb-2">{{ $tvShow->name }}</h1>
                            <div class="flex flex-wrap items-center text-blue-100 text-sm space-x-4">
                                @if($tvShow->genre)
                                    <span class="bg-white/20 px-3 py-1 rounded-full">{{ $tvShow->genre }}</span>
                                @endif
                                @if($tvShow->year_started)
                                    <span>{{ $tvShow->year_started }}{{ $tvShow->year_ended ? ' - ' . $tvShow->year_ended : ' - Present' }}</span>
                                @endif
                                <span>{{ $tvShow->actors->count() }} {{ Str::plural('Actor', $tvShow->actors->count()) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if($tvShow->description)
                    <div class="p-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-3">About the Show</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $tvShow->description }}</p>
                    </div>
                @endif
            </div>

            <!-- Actors Section -->
            @if($tvShow->actors->count() > 0)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Cast & Social Media</h2>
                        <div class="text-sm text-gray-500">
                            {{ $tvShow->actors->count() }} {{ Str::plural('actor', $tvShow->actors->count()) }}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($tvShow->actors as $actor)
                            <div class="bg-gray-50 rounded-lg p-6 hover:bg-gray-100 transition-colors">
                                <div class="flex items-start justify-between mb-4">
                                    <div>
                                        <h3 class="font-semibold text-gray-900 text-lg">{{ $actor->name }}</h3>
                                        @if($actor->character_name)
                                            <p class="text-gray-600 text-sm">as {{ $actor->character_name }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Social Media Links -->
                                <div class="space-y-3">
                                    @if($actor->instagram_handle)
                                        <a href="https://instagram.com/{{ ltrim($actor->instagram_handle, '@') }}" 
                                           target="_blank" 
                                           class="flex items-center p-3 bg-white rounded-lg hover:bg-pink-50 transition-colors group">
                                            <div class="bg-pink-100 p-2 rounded-lg mr-3 group-hover:bg-pink-200 transition-colors">
                                                <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">Instagram</div>
                                                <div class="text-sm text-gray-600">{{ $actor->instagram_handle }}</div>
                                            </div>
                                            <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-pink-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @endif

                                    @if($actor->x_handle)
                                        <a href="https://x.com/{{ ltrim($actor->x_handle, '@') }}" 
                                           target="_blank" 
                                           class="flex items-center p-3 bg-white rounded-lg hover:bg-gray-50 transition-colors group">
                                            <div class="bg-gray-100 p-2 rounded-lg mr-3 group-hover:bg-gray-200 transition-colors">
                                                <svg class="w-5 h-5 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">X (Twitter)</div>
                                                <div class="text-sm text-gray-600">{{ $actor->x_handle }}</div>
                                            </div>
                                            <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    @endif

                                    @if(!$actor->instagram_handle && !$actor->x_handle)
                                        <div class="text-center py-4 text-gray-500">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                            </svg>
                                            <p class="text-sm">No social media links available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- No Actors State -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">No Actors Added Yet</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Be the first to add actors from {{ $tvShow->name }} to our database!
                    </p>
                    @auth
                        <a href="{{ route('actor-submissions.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Add First Actor
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Join to Contribute
                        </a>
                    @endauth
                </div>
            @endif

            <!-- Social Media Feed Preview -->
            @if($recentPosts->count() > 0)
                <div class="mt-12 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex items-center justify-between">
                            <h2 class="text-2xl font-bold text-gray-900">Latest from the Cast</h2>
                            <a href="{{ route('tv-shows.feed', $tvShow) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium flex items-center space-x-1">
                                <span>View Full Feed</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($recentPosts->take(6) as $post)
                                <div class="bg-gray-50 rounded-lg p-4 hover:bg-gray-100 transition-colors">
                                    <!-- Post Header -->
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-2">
                                            <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                {{ substr($post->actor->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900 text-sm">{{ $post->actor->name }}</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-1 text-xs
                                            {{ $post->platform === 'instagram' ? 'text-pink-600' : 'text-gray-600' }}">
                                            <span>{{ $post->platform_icon }}</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Post Content -->
                                    @if($post->image_url)
                                        <div class="mb-3">
                                            <img src="{{ $post->image_url }}" 
                                                 alt="Post image" 
                                                 class="w-full h-32 object-cover rounded-md">
                                        </div>
                                    @endif
                                    
                                    @if($post->content)
                                        <p class="text-gray-700 text-sm mb-3 line-clamp-3">{{ $post->content }}</p>
                                    @endif
                                    
                                    <!-- Post Stats -->
                                    <div class="flex items-center justify-between text-xs text-gray-500">
                                        <div class="flex items-center space-x-3">
                                            <span>❤️ {{ number_format($post->likes_count) }}</span>
                                            <span>💬 {{ number_format($post->comments_count) }}</span>
                                        </div>
                                        <span>{{ $post->time_ago }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        @if($recentPosts->count() > 6)
                            <div class="text-center mt-6">
                                <a href="{{ route('tv-shows.feed', $tvShow) }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                                    View All {{ $recentPosts->count() }} Posts
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @elseif($tvShow->actors->count() > 0)
                <!-- No Posts Yet -->
                <div class="mt-12 bg-white rounded-xl shadow-lg border border-gray-100 p-8 text-center">
                    <div class="text-4xl mb-4">📱</div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Social Feed Coming Soon</h3>
                    <p class="text-gray-600 mb-4">
                        We're working on fetching the latest posts from {{ $tvShow->name }} cast members.
                    </p>
                    <p class="text-sm text-gray-500">
                        Posts from Instagram and X accounts will appear here automatically.
                    </p>
                </div>
            @endif

            <!-- Call to Action -->
            <div class="mt-12 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-8 text-center">
                <h3 class="text-2xl font-bold text-white mb-4">Know More Actors from {{ $tvShow->name }}?</h3>
                <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                    Help us complete the cast list! Submit actors and their social media profiles.
                </p>
                @auth
                    <a href="{{ route('actor-submissions.create') }}" 
                       class="bg-white hover:bg-gray-100 text-blue-600 font-semibold py-3 px-6 rounded-lg transition-colors">
                        Submit an Actor
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="bg-white hover:bg-gray-100 text-blue-600 font-semibold py-3 px-6 rounded-lg transition-colors">
                       Join Our Community
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">📺 TV Shows & Actors</h3>
                <p class="text-gray-400 mb-4">
                    Your go-to directory for finding TV actors on social media.
                </p>
                <div class="flex justify-center space-x-6">
                    <a href="/" class="text-gray-400 hover:text-white">Home</a>
                    <a href="{{ route('tv-shows.index') }}" class="text-gray-400 hover:text-white">Browse Shows</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-400 hover:text-white">Login</a>
                        <a href="{{ route('register') }}" class="text-gray-400 hover:text-white">Register</a>
                    @endauth
                </div>
                <div class="mt-8 pt-8 border-t border-gray-800">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} TV Shows & Actors. Built with Laravel.
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Points Display -->
    @include('components.points-display')
</body>
</html>