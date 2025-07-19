<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TV Shows & Actors - Social Media Directory</title>
    
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
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-gray-900">📺 TV & Actors</h1>
                    </div>
                </div>
                
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                    <a href="{{ route('tv-shows.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                        Browse Shows
                    </a>
                    <a href="{{ route('tv-shows.global-feed') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                        🐦 Twitter Feed
                    </a>
                    <a href="{{ route('leaderboard.index') }}" class="text-gray-600 hover:text-gray-900 font-medium">
                        🏆 Leaderboard
                    </a>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-gray-900 font-medium">
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
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                    Sign up
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
                    Find Your Favorite
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600">
                        TV Actors
                    </span>
                    on Social Media
                </h1>
                <p class="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                    Discover Instagram and X (Twitter) profiles of actors from your favorite TV shows. 
                    From Dexter to Breaking Bad, find and follow the stars you love.
                </p>
                
                @auth
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('actor-submissions.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                            Submit an Actor
                        </a>
                        <a href="{{ route('actor-submissions.index') }}" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-3 rounded-lg font-semibold text-lg border border-gray-300 transition-colors">
                            My Submissions
                        </a>
                    </div>
                @else
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" class="bg-white hover:bg-gray-50 text-gray-900 px-8 py-3 rounded-lg font-semibold text-lg border border-gray-300 transition-colors">
                            Sign In
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-white py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-lg text-gray-600">Simple steps to discover and share actor social media profiles</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Submit Actors</h3>
                    <p class="text-gray-600">Add your favorite TV show actors and their social media handles to our community database.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Admin Review</h3>
                    <p class="text-gray-600">All submissions go through our admin approval process to ensure accuracy and quality.</p>
                </div>
                
                <div class="text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Discover & Follow</h3>
                    <p class="text-gray-600">Browse approved actors by TV show and easily find their Instagram and X profiles.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Shows Section -->
    <div class="bg-gray-50 py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular TV Shows</h2>
                <p class="text-lg text-gray-600">Discover actors from these fan-favorite series</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-5 gap-6">
                <div class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-2">🔪</div>
                    <h3 class="font-semibold text-gray-900">Dexter</h3>
                    <p class="text-sm text-gray-600">Crime Drama</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-2">⚗️</div>
                    <h3 class="font-semibold text-gray-900">Breaking Bad</h3>
                    <p class="text-sm text-gray-600">Crime Drama</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-2">🏢</div>
                    <h3 class="font-semibold text-gray-900">The Office</h3>
                    <p class="text-sm text-gray-600">Comedy</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-2">👾</div>
                    <h3 class="font-semibold text-gray-900">Stranger Things</h3>
                    <p class="text-sm text-gray-600">Sci-Fi Horror</p>
                </div>
                
                <div class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition-shadow">
                    <div class="text-2xl mb-2">🐉</div>
                    <h3 class="font-semibold text-gray-900">Game of Thrones</h3>
                    <p class="text-sm text-gray-600">Fantasy Drama</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-blue-600 py-16">
        <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-white mb-4">Ready to Get Started?</h2>
            <p class="text-xl text-blue-100 mb-8">
                Join our community and help build the ultimate TV actor social media directory.
            </p>
            
            @auth
                <a href="{{ route('actor-submissions.create') }}" class="bg-white hover:bg-gray-100 text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                    Submit Your First Actor
                </a>
            @else
                <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-blue-600 px-8 py-3 rounded-lg font-semibold text-lg transition-colors">
                    Create Your Account
                </a>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h3 class="text-lg font-semibold mb-4">📺 TV Shows & Actors</h3>
                <p class="text-gray-400 mb-4">
                    Your go-to directory for finding TV actors on social media.
                </p>
                <div class="flex justify-center space-x-6">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-400 hover:text-white">Dashboard</a>
                            <a href="{{ route('actor-submissions.create') }}" class="text-gray-400 hover:text-white">Submit Actor</a>
                            <a href="{{ route('actor-submissions.index') }}" class="text-gray-400 hover:text-white">My Submissions</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-400 hover:text-white">Login</a>
                            <a href="{{ route('register') }}" class="text-gray-400 hover:text-white">Register</a>
                        @endauth
                    @endif
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