<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Leaderboard - TV Shows & Actors</title>
    
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
                    <a href="{{ route('leaderboard.index') }}" class="text-blue-600 bg-blue-50 px-3 py-2 rounded-md text-sm font-medium">
                        Leaderboard
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
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    🏆 Leaderboard
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Top contributors to our TV actor social media directory. Earn points by submitting actors with social media profiles!
                </p>
            </div>

            <!-- Points System Info -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">How to Earn Points</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-blue-50 rounded-lg">
                        <div class="text-3xl mb-3">✅</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Actor Approved</h3>
                        <div class="text-2xl font-bold text-blue-600 mb-2">10 Points</div>
                        <p class="text-sm text-gray-600">When your submitted actor gets approved by admins</p>
                    </div>
                    
                    <div class="text-center p-6 bg-pink-50 rounded-lg">
                        <div class="text-3xl mb-3">📸</div>
                        <h3 class="font-semibold text-gray-900 mb-2">Instagram Handle</h3>
                        <div class="text-2xl font-bold text-pink-600 mb-2">+10 Points</div>
                        <p class="text-sm text-gray-600">Bonus for including Instagram profile</p>
                    </div>
                    
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="text-3xl mb-3">𝕏</div>
                        <h3 class="font-semibold text-gray-900 mb-2">X (Twitter) Handle</h3>
                        <div class="text-2xl font-bold text-gray-900 mb-2">+10 Points</div>
                        <p class="text-sm text-gray-600">Bonus for including X/Twitter profile</p>
                    </div>
                </div>
                <div class="text-center mt-6">
                    <p class="text-gray-600 mb-4">
                        <strong>Maximum per submission:</strong> 30 points (actor + Instagram + X)
                    </p>
                    @auth
                        <a href="{{ route('actor-submissions.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Start Earning Points
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Join to Earn Points
                        </a>
                    @endauth
                </div>
            </div>

            @if(auth()->check())
                <!-- User's Current Rank -->
                <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-6 mb-8 text-white">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold mb-1">Your Stats</h3>
                            <p class="text-blue-100">Keep climbing the leaderboard!</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold">{{ auth()->user()->points }}</div>
                            <div class="text-blue-100">Points</div>
                            <div class="text-sm text-blue-200">Rank #{{ $userRank }}</div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Leaderboard -->
            @if($topUsers->count() > 0)
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-2xl font-bold text-gray-900">Top Contributors</h2>
                    </div>
                    
                    <div class="divide-y divide-gray-100">
                        @foreach($topUsers as $index => $user)
                            <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition-colors
                                {{ $index === 0 ? 'bg-gradient-to-r from-yellow-50 to-orange-50' : '' }}
                                {{ $index === 1 ? 'bg-gradient-to-r from-gray-50 to-slate-50' : '' }}
                                {{ $index === 2 ? 'bg-gradient-to-r from-orange-50 to-amber-50' : '' }}">
                                
                                <div class="flex items-center space-x-4">
                                    <!-- Rank -->
                                    <div class="flex-shrink-0 w-12 h-12 rounded-full flex items-center justify-center font-bold text-lg
                                        {{ $index === 0 ? 'bg-yellow-500 text-white' : '' }}
                                        {{ $index === 1 ? 'bg-gray-400 text-white' : '' }}
                                        {{ $index === 2 ? 'bg-orange-500 text-white' : '' }}
                                        {{ $index > 2 ? 'bg-blue-100 text-blue-600' : '' }}">
                                        @if($index === 0)
                                            🥇
                                        @elseif($index === 1)
                                            🥈
                                        @elseif($index === 2)
                                            🥉
                                        @else
                                            {{ $index + 1 }}
                                        @endif
                                    </div>
                                    
                                    <!-- User Info -->
                                    <div>
                                        <div class="font-semibold text-gray-900 text-lg">
                                            {{ $user->name }}
                                            @if(auth()->check() && $user->id === auth()->id())
                                                <span class="text-blue-600 text-sm font-normal">(You)</span>
                                            @endif
                                        </div>
                                        <div class="text-gray-500 text-sm">
                                            {{ $user->submissions()->where('status', 'approved')->count() }} approved submissions
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Points -->
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-gray-900">{{ number_format($user->points) }}</div>
                                    <div class="text-gray-500 text-sm">points</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-12 text-center">
                    <div class="text-6xl mb-6">🏆</div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Rankings Yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Be the first to earn points by submitting TV actors and their social media profiles!
                    </p>
                    @auth
                        <a href="{{ route('actor-submissions.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Submit First Actor
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Join to Compete
                        </a>
                    @endauth
                </div>
            @endif

            <!-- Call to Action -->
            <div class="mt-12 bg-gradient-to-r from-green-600 to-blue-600 rounded-xl p-8 text-center">
                <h3 class="text-2xl font-bold text-white mb-4">Ready to Climb the Leaderboard?</h3>
                <p class="text-green-100 mb-6 max-w-2xl mx-auto">
                    Submit actors with complete social media profiles to earn maximum points and compete with other contributors!
                </p>
                @auth
                    <a href="{{ route('actor-submissions.create') }}" 
                       class="bg-white hover:bg-gray-100 text-green-600 font-semibold py-3 px-6 rounded-lg transition-colors">
                        Submit an Actor
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="bg-white hover:bg-gray-100 text-green-600 font-semibold py-3 px-6 rounded-lg transition-colors">
                       Join the Competition
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
                    <a href="{{ route('leaderboard.index') }}" class="text-gray-400 hover:text-white">Leaderboard</a>
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
</body>
</html>