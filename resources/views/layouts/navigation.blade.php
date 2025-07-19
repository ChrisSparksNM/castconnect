<nav x-data="{ open: false }" class="bg-white/80 backdrop-blur-md border-b border-gray-200 sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <h1 class="text-xl font-bold text-gray-900">📺 TV & Actors</h1>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:ml-10 sm:flex">
                    <a href="{{ route('tv-shows.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('tv-shows.index') || request()->routeIs('tv-shows.show') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Browse Shows
                    </a>
                    <a href="{{ route('tv-shows.global-feed') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('tv-shows.global-feed') ? 'text-blue-600 bg-blue-50' : '' }}">
                        🐦 Twitter Feed
                    </a>
                    <a href="{{ route('leaderboard.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('leaderboard.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                        🏆 Leaderboard
                    </a>
                    <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('actor-submissions.create') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('actor-submissions.create') ? 'text-blue-600 bg-blue-50' : '' }}">
                        Submit Actor
                    </a>
                    <a href="{{ route('actor-submissions.index') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('actor-submissions.index') ? 'text-blue-600 bg-blue-50' : '' }}">
                        My Submissions
                    </a>
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.submissions') }}" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium transition-colors {{ request()->routeIs('admin.submissions') ? 'text-blue-600 bg-blue-50' : '' }}">
                            Admin Panel
                        </a>
                    @endif
                </div>
            </div>

            <!-- User Menu -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none focus:text-gray-900 transition-colors">
                        <span class="mr-2">{{ Auth::user()->name }}</span>
                        <svg class="h-4 w-4" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                            Profile Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="text-gray-600 hover:text-gray-900 focus:outline-none focus:text-gray-900 p-2">
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

    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-transition class="sm:hidden bg-white border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('tv-shows.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('tv-shows.index') || request()->routeIs('tv-shows.show') ? 'text-blue-600 bg-blue-50' : '' }}">
                Browse Shows
            </a>
            <a href="{{ route('tv-shows.global-feed') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('tv-shows.global-feed') ? 'text-blue-600 bg-blue-50' : '' }}">
                🐦 Twitter Feed
            </a>
            <a href="{{ route('leaderboard.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('leaderboard.*') ? 'text-blue-600 bg-blue-50' : '' }}">
                🏆 Leaderboard
            </a>
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('dashboard') ? 'text-blue-600 bg-blue-50' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('actor-submissions.create') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('actor-submissions.create') ? 'text-blue-600 bg-blue-50' : '' }}">
                Submit Actor
            </a>
            <a href="{{ route('actor-submissions.index') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('actor-submissions.index') ? 'text-blue-600 bg-blue-50' : '' }}">
                My Submissions
            </a>
            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.submissions') }}" class="block px-3 py-2 text-base font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 rounded-md transition-colors {{ request()->routeIs('admin.submissions') ? 'text-blue-600 bg-blue-50' : '' }}">
                    Admin Panel
                </a>
            @endif
        </div>
        
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
    </div>
</nav>
