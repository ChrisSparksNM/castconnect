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
                                                        <a href="https://instagram.com/{{ ltrim($actor->instagram_handle, '@') }}" 
                                                           target="_blank" 
                                                           class="text-pink-600 hover:text-pink-800 transition-colors"
                                                           title="Instagram">
                                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                                            </svg>
                                                        </a>
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

    <script>
        let currentShowId = null;

        function openShowPhotoModal(showId, showName) {
            currentShowId = showId;
            document.getElementById('showName').textContent = showName;
            document.getElementById('showPhotoModal').classList.remove('hidden');
        }

        function closeShowPhotoModal() {
            document.getElementById('showPhotoModal').classList.add('hidden');
            document.getElementById('showPhotoForm').reset();
            document.getElementById('show-photo-preview').classList.add('hidden');
            currentShowId = null;
        }

        // Photo preview functionality
        document.getElementById('show_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('show-preview-img').src = e.target.result;
                    document.getElementById('show-photo-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        // Form submission
        document.getElementById('showPhotoForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!currentShowId) return;
            
            const formData = new FormData(this);
            const submitButton = this.querySelector('button[type="submit"]');
            
            submitButton.disabled = true;
            submitButton.textContent = 'Uploading...';
            
            fetch(`/admin/tv-shows/${currentShowId}/upload-photo`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show the new photo
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while uploading the photo.');
            })
            .finally(() => {
                submitButton.disabled = false;
                submitButton.textContent = 'Upload Photo';
                closeShowPhotoModal();
            });
        });

        // Close modal when clicking outside
        document.getElementById('showPhotoModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeShowPhotoModal();
            }
        });
    </script>
</body>
</html>