<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>TV Shows & Actors Directory</title>
    
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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                    TV Shows & Actor Directory
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Discover your favorite TV show actors and follow them on social media. 
                    Find Instagram and X (Twitter) profiles for stars from popular series.
                </p>
            </div>

            @if($tvShows->count() > 0)
                <!-- TV Shows Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($tvShows as $show)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Show Header -->
                            <div class="relative h-48 overflow-hidden group">
                                @if($show->image_url)
                                    <!-- Show Image Background -->
                                    <img src="{{ $show->image_url }}" 
                                         alt="{{ $show->name }}" 
                                         class="w-full h-full object-cover">
                                    <!-- Dark Overlay for Text Readability -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                                @else
                                    <!-- Fallback Gradient -->
                                    <div class="w-full h-full bg-gradient-to-r from-blue-500 to-purple-600"></div>
                                @endif

                                <!-- Admin Photo Upload Button -->
                                @auth
                                    @if(auth()->user()->is_admin)
                                        <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button onclick="openShowPhotoModal({{ $show->id }}, '{{ $show->name }}')" 
                                                    class="bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-colors"
                                                    title="Upload show photo">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endauth
                                
                                <!-- Text Content -->
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h2 class="text-xl font-bold text-white mb-2">{{ $show->name }}</h2>
                                    <div class="flex items-center text-white/90 text-sm">
                                        <span class="mr-4">{{ $show->genre ?? 'TV Series' }}</span>
                                        @if($show->year_started)
                                            <span>{{ $show->year_started }}{{ $show->year_ended ? ' - ' . $show->year_ended : ' - Present' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Show Content -->
                            <div class="p-6">
                                @if($show->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $show->description }}</p>
                                @endif

                                <!-- Actors Count -->
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center text-sm text-gray-500">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        {{ $show->actors->count() }} {{ Str::plural('actor', $show->actors->count()) }}
                                    </div>
                                </div>

                                <!-- Actors Preview -->
                                @if($show->actors->count() > 0)
                                    <div class="space-y-3 mb-4">
                                        @foreach($show->actors->take(3) as $actor)
                                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                                <div class="flex items-center space-x-3">
                                                    <!-- Actor Photo -->
                                                    @if($actor->photo_url)
                                                        <img src="{{ $actor->photo_url }}" 
                                                             alt="{{ $actor->name }}" 
                                                             class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                                                    @else
                                                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                                            {{ substr($actor->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Actor Info -->
                                                    <div>
                                                        <div class="font-medium text-gray-900">{{ $actor->name }}</div>
                                                        @if($actor->character_name)
                                                            <div class="text-sm text-gray-500">as {{ $actor->character_name }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex space-x-2">
                                                    @if($actor->instagram_handle)
                                                        <div class="relative instagram-hover-container">
                                                            <a href="https://instagram.com/{{ ltrim($actor->instagram_handle, '@') }}" 
                                                               target="_blank" 
                                                               class="text-pink-600 hover:text-pink-800 transition-colors instagram-link"
                                                               data-instagram-handle="{{ ltrim($actor->instagram_handle, '@') }}"
                                                               title="Instagram">
                                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.40s-.644-1.44-1.439-1.44z"/>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                    @endif
                                                    @if($actor->x_handle)
                                                        <a href="https://x.com/{{ ltrim($actor->x_handle, '@') }}" 
                                                           target="_blank" 
                                                           class="text-gray-900 hover:text-gray-700 transition-colors"
                                                           title="X (Twitter)">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                                            </svg>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                        
                                        @if($show->actors->count() > 3)
                                            <div class="text-center">
                                                <a href="{{ route('tv-shows.show', $show) }}" 
                                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    View all {{ $show->actors->count() }} actors →
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <p class="text-sm">No actors added yet</p>
                                        @auth
                                            <a href="{{ route('actor-submissions.create') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Be the first to add one!
                                            </a>
                                        @endauth
                                    </div>
                                @endif

                                <!-- View Details Button -->
                                <div class="pt-4 border-t border-gray-100">
                                    <a href="{{ route('tv-shows.show', $show) }}" 
                                       class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors text-center block">
                                        View All Actors
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto mb-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4zM6 6v12h12V6H6zm3 3a1 1 0 112 0v6a1 1 0 11-2 0V9zm4 0a1 1 0 112 0v6a1 1 0 11-2 0V9z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">No TV Shows Yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        There are no TV shows in our database yet. Be the first to contribute!
                    </p>
                    @auth
                        <a href="{{ route('actor-submissions.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Submit First Actor
                        </a>
                    @else
                        <a href="{{ route('register') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                            Join to Contribute
                        </a>
                    @endauth
                </div>
            @endif

            <!-- Call to Action -->
            @if($tvShows->count() > 0)
                <div class="mt-16 bg-gradient-to-r from-blue-600 to-purple-600 rounded-xl p-8 text-center">
                    <h3 class="text-2xl font-bold text-white mb-4">Want to Add More Actors?</h3>
                    <p class="text-blue-100 mb-6 max-w-2xl mx-auto">
                        Help us build the most comprehensive TV actor social media directory. 
                        Submit your favorite actors and their social profiles!
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
            @endif
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

    <!-- Admin Show Photo Upload Modal -->
    @auth
        @if(auth()->user()->is_admin)
            <div id="showPhotoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
                <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                    <div class="mt-3">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Upload Show Photo</h3>
                        <p class="text-sm text-gray-600 mb-4">
                            Upload a photo for "<span id="showName"></span>"
                        </p>
                        
                        <form id="showPhotoForm" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <label for="show_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                    Choose Photo
                                </label>
                                <input type="file" 
                                       id="show_photo" 
                                       name="photo" 
                                       accept="image/*"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <!-- Photo Preview -->
                            <div id="show-photo-preview" class="hidden mb-4">
                                <img id="show-preview-img" src="" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                            </div>
                            
                            <div class="flex justify-end space-x-3">
                                <button type="button" 
                                        onclick="closeShowPhotoModal()"
                                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded transition-colors">
                                    Upload Photo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endauth

    <!-- Instagram Profile Embed Popup -->
    <div id="instagramEmbed" class="fixed z-50 hidden pointer-events-auto">
        <div class="bg-white rounded-lg shadow-xl border border-gray-200 overflow-hidden" style="width: 400px; max-height: 500px;">
            <!-- Loading State -->
            <div id="embedLoading" class="flex items-center justify-center p-8">
                <div class="flex flex-col items-center space-y-3">
                    <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-pink-600"></div>
                    <p class="text-sm text-gray-600">Loading Instagram profile...</p>
                </div>
            </div>
            
            <!-- Error State -->
            <div id="embedError" class="hidden p-6 text-center">
                <div class="flex flex-col items-center space-y-3">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Unable to load Instagram embed</p>
                        <p class="text-xs text-gray-600 mt-1">Click below to view profile directly</p>
                    </div>
                    <a id="errorInstagramLink" href="#" target="_blank" class="inline-flex items-center px-4 py-2 bg-pink-600 text-white text-sm font-medium rounded-lg hover:bg-pink-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        View on Instagram
                    </a>
                </div>
            </div>
            
            <!-- Embed Container -->
            <div id="embedContainer" class="hidden"></div>
        </div>
    </div>

    <script>
        let hoverTimeout;
        let embedTimeout;
        const instagramEmbed = document.getElementById('instagramEmbed');
        const embedLoading = document.getElementById('embedLoading');
        const embedError = document.getElementById('embedError');
        const embedContainer = document.getElementById('embedContainer');
        const errorInstagramLink = document.getElementById('errorInstagramLink');
        let instagramScriptLoaded = false;

        function loadInstagramScript() {
            return new Promise((resolve, reject) => {
                if (instagramScriptLoaded) {
                    resolve();
                    return;
                }

                const existingScript = document.querySelector('script[src*="instagram.com/embed.js"]');
                if (existingScript) {
                    existingScript.remove();
                }

                const script = document.createElement('script');
                script.src = 'https://www.instagram.com/embed.js';
                script.async = true;
                script.onload = () => {
                    instagramScriptLoaded = true;
                    resolve();
                };
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }

        function showInstagramEmbed(event, handle) {
            clearTimeout(hoverTimeout);
            clearTimeout(embedTimeout);
            
            const rect = event.target.closest('.instagram-hover-container').getBoundingClientRect();
            
            let left = rect.right + 10;
            let top = rect.top;
            
            const embedWidth = 400;
            if (left + embedWidth > window.innerWidth) {
                left = rect.left - embedWidth - 10;
            }
            
            if (top + 500 > window.innerHeight) {
                top = window.innerHeight - 520;
            }
            if (top < 10) {
                top = 10;
            }
            
            instagramEmbed.style.left = left + 'px';
            instagramEmbed.style.top = top + 'px';
            
            hoverTimeout = setTimeout(() => {
                embedLoading.classList.remove('hidden');
                embedError.classList.add('hidden');
                embedContainer.classList.add('hidden');
                embedContainer.innerHTML = '';
                
                instagramEmbed.classList.remove('hidden');
                errorInstagramLink.href = `https://instagram.com/${handle}`;
                
                embedTimeout = setTimeout(() => {
                    createInstagramEmbed(handle);
                }, 300);
                
            }, 500);
        }

        function createInstagramEmbed(handle) {
            const embedHtml = `
                <blockquote class="instagram-media" 
                    data-instgrm-permalink="https://www.instagram.com/${handle}/" 
                    data-instgrm-version="14"
                    style="background:#FFF; border:0; border-radius:3px; box-shadow:0 0 1px 0 rgba(0,0,0,0.5),0 1px 10px 0 rgba(0,0,0,0.15); margin: 1px; max-width:400px; min-width:326px; padding:0; width:99.375%; width:-webkit-calc(100% - 2px); width:calc(100% - 2px);">
                    <div style="padding:16px;">
                        <div style="display: flex; flex-direction: row; align-items: center;">
                            <div style="background-color: #F4F4F4; border-radius: 50%; flex-grow: 0; height: 40px; margin-right: 14px; width: 40px;"></div>
                            <div style="display: flex; flex-direction: column; flex-grow: 1; justify-content: center;">
                                <div style="background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; margin-bottom: 6px; width: 100px;"></div>
                                <div style="background-color: #F4F4F4; border-radius: 4px; flex-grow: 0; height: 14px; width: 60px;"></div>
                            </div>
                        </div>
                        <div style="padding: 19% 0;"></div>
                        <div style="display:block; height:50px; margin:0 auto 12px; width:50px;">
                            <svg width="50px" height="50px" viewBox="0 0 60 60" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g transform="translate(-511.000000, -20.000000)" fill="#000000">
                                        <g>
                                            <path d="M556.869,30.41 C554.814,30.41 553.148,32.076 553.148,34.131 C553.148,36.186 554.814,37.852 556.869,37.852 C558.924,37.852 560.59,36.186 560.59,34.131 C560.59,32.076 558.924,30.41 556.869,30.41 M541,60.657 C535.114,60.657 530.342,55.887 530.342,50 C530.342,44.114 535.114,39.342 541,39.342 C546.887,39.342 551.658,44.114 551.658,50 C551.658,55.887 546.887,60.657 541,60.657 M541,33.886 C532.1,33.886 524.886,41.1 524.886,50 C524.886,58.899 532.1,66.113 541,66.113 C549.9,66.113 557.115,58.899 557.115,50 C557.115,41.1 549.9,33.886 541,33.886 M565.378,62.101 C565.244,65.022 564.756,66.606 564.346,67.663 C563.803,69.06 563.154,70.057 562.106,71.106 C561.058,72.155 560.06,72.803 558.662,73.347 C557.607,73.757 556.021,74.244 553.102,74.378 C549.944,74.521 548.997,74.552 541,74.552 C533.003,74.552 532.056,74.521 528.898,74.378 C525.979,74.244 524.393,73.757 523.338,73.347 C521.94,72.803 520.942,72.155 519.894,71.106 C518.846,70.057 518.197,69.06 517.654,67.663 C517.244,66.606 516.755,65.022 516.623,62.101 C516.479,58.943 516.448,57.996 516.448,50 C516.448,42.003 516.479,41.056 516.623,37.899 C516.755,34.978 517.244,33.391 517.654,32.338 C518.197,30.938 518.846,29.942 519.894,28.894 C520.942,27.846 521.94,27.196 523.338,26.654 C524.393,26.244 525.979,25.756 528.898,25.623 C532.057,25.479 533.004,25.448 541,25.448 C548.997,25.448 549.943,25.479 553.102,25.623 C556.021,25.756 557.607,26.244 558.662,26.654 C560.06,27.196 561.058,27.846 562.106,28.894 C563.154,29.942 563.803,30.938 564.346,32.338 C564.756,33.391 565.244,34.978 565.378,37.899 C565.522,41.056 565.552,42.003 565.552,50 C565.552,57.996 565.522,58.943 565.378,62.101 M570.82,37.631 C570.674,34.438 570.167,32.258 569.425,30.349 C568.659,28.377 567.633,26.702 565.965,25.035 C564.297,23.368 562.623,22.342 560.652,21.575 C558.743,20.834 556.562,20.326 553.369,20.18 C550.169,20.033 549.148,20 541,20 C532.853,20 531.831,20.033 528.631,20.18 C525.438,20.326 523.257,20.834 521.349,21.575 C519.376,22.342 517.703,23.368 516.035,25.035 C514.368,26.702 513.342,28.377 512.574,30.349 C511.834,32.258 511.326,34.438 511.181,37.631 C511.035,40.831 511,41.851 511,50 C511,58.147 511.035,59.17 511.181,62.369 C511.326,65.562 511.834,67.743 512.574,69.651 C513.342,71.625 514.368,73.296 516.035,74.965 C517.703,76.634 519.376,77.658 521.349,78.425 C523.257,79.167 525.438,79.673 528.631,79.82 C531.831,79.965 532.853,80.001 541,80.001 C549.148,80.001 550.169,79.965 553.369,79.82 C556.562,79.673 558.743,79.167 560.652,78.425 C562.623,77.658 564.297,76.634 565.965,74.965 C567.633,73.296 568.659,71.625 569.425,69.651 C570.167,67.743 570.674,65.562 570.82,62.369 C570.966,59.17 571,58.147 571,50 C571,41.851 570.966,40.831 570.82,37.631"></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                        </div>
                        <div style="padding-top: 8px;">
                            <div style="color:#3897f0; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:550; line-height:18px;">View this profile on Instagram</div>
                        </div>
                    </div>
                </blockquote>
            `;
            
            embedContainer.innerHTML = embedHtml;
            
            loadInstagramScript()
                .then(() => {
                    embedLoading.classList.add('hidden');
                    embedContainer.classList.remove('hidden');
                    
                    if (window.instgrm && window.instgrm.Embeds) {
                        window.instgrm.Embeds.process();
                    }
                })
                .catch(() => {
                    embedLoading.classList.add('hidden');
                    embedError.classList.remove('hidden');
                });
        }

        function hideInstagramEmbed() {
            clearTimeout(hoverTimeout);
            clearTimeout(embedTimeout);
            
            hoverTimeout = setTimeout(() => {
                instagramEmbed.classList.add('hidden');
                embedContainer.innerHTML = '';
            }, 100);
        }

        // Add hover listeners to Instagram links
        document.addEventListener('DOMContentLoaded', function() {
            const instagramLinks = document.querySelectorAll('.instagram-link');
            
            instagramLinks.forEach(link => {
                link.addEventListener('mouseenter', function(e) {
                    const handle = this.getAttribute('data-instagram-handle');
                    showInstagramEmbed(e, handle);
                });

                link.addEventListener('mouseleave', function() {
                    hideInstagramEmbed();
                });
            });

            // Hide embed when clicking outside
            document.addEventListener('click', function(e) {
                if (!instagramEmbed.contains(e.target) && !e.target.closest('.instagram-link')) {
                    hideInstagramEmbed();
                }
            });
        });
    </script>
</body>
</html>