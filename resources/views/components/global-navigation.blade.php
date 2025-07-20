<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="{{ auth()->check() ? route('dashboard') : '/' }}">
                    <h1 class="text-xl font-bold text-gray-900">📺 TV & Actors</h1>
                </a>
            </div>

            <!-- User Info (for authenticated users) -->
            @auth
                <div class="flex items-center space-x-3">
                    <div class="hidden sm:block text-right">
                        <div class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500">{{ Auth::user()->points ?? 0 }} points</div>
                    </div>
                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </div>
            @endauth

            <!-- Hamburger menu button (always visible) -->
            <div class="flex items-center">
                <button @click="open = !open" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="h-6 w-6" :class="{'hidden': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg class="h-6 w-6" :class="{'hidden': !open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Navigation Menu (always hamburger) -->
    <div x-show="open" x-transition class="bg-white border-t border-gray-200 shadow-lg">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Public Links -->
            <a href="{{ route('tv-shows.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('tv-shows.index') || request()->routeIs('tv-shows.show') ? 'text-blue-600 bg-blue-50' : '' }}">
                Browse Shows
            </a>
            <a href="{{ route('tv-shows.global-feed') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('tv-shows.global-feed') ? 'text-blue-600 bg-blue-50' : '' }}">
                🐦 Twitter Feed
            </a>
            <a href="{{ route('leaderboard.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('leaderboard.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                🏆 Leaderboard
            </a>
            
            @auth
                <!-- Authenticated Links -->
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('actor-submissions.create') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('actor-submissions.create') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Submit Actor
                </a>
                <a href="{{ route('tv-show-submissions.create') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('tv-show-submissions.create') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Submit Show
                </a>
                <a href="{{ route('actor-submissions.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('actor-submissions.index') ? 'text-blue-600 bg-blue-50' : '' }}">
                    My Submissions
                </a>
                <a href="{{ route('tv-show-submissions.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('tv-show-submissions.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                    My Show Submissions
                </a>
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.submissions') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('admin.submissions') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Admin Panel
                    </a>
                @endif
            @else
                <!-- Guest Links -->
                <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors">
                    Log in
                </a>
                <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded-md transition-colors">
                    Sign up
                </a>
            @endauth
        </div>
        
        @auth
            <!-- Mobile User Info -->
            <div class="pt-4 pb-3 border-t border-gray-200">
                <div class="px-4">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                        Profile Settings
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-red-50 transition-colors">
                            Sign Out
                        </button>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>