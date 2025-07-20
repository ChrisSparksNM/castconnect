<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Submit an Actor
                </h1>
                <p class="text-lg text-gray-600">
                    Add a TV show actor and their social media profiles to our database.
                </p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('actor-submissions.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- TV Show Selection -->
                        <div>
                            <label for="tv_show_id" class="block text-sm font-medium text-gray-700 mb-2">
                                TV Show <span class="text-red-500">*</span>
                            </label>
                            <select id="tv_show_id" 
                                    name="tv_show_id" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                <option value="">Select a TV Show</option>
                                @foreach($tvShows as $show)
                                    <option value="{{ $show->id }}" {{ old('tv_show_id') == $show->id ? 'selected' : '' }}>
                                        {{ $show->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tv_show_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actor Name -->
                        <div>
                            <label for="actor_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Actor Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="actor_name" 
                                   name="actor_name" 
                                   value="{{ old('actor_name') }}" 
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="e.g., Bryan Cranston">
                            @error('actor_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Character Name -->
                        <div>
                            <label for="character_name" class="block text-sm font-medium text-gray-700 mb-2">
                                Character Name
                            </label>
                            <input type="text" 
                                   id="character_name" 
                                   name="character_name" 
                                   value="{{ old('character_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   placeholder="e.g., Walter White">
                            @error('character_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Actor Photo -->
                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Actor Photo
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload a photo</span>
                                            <input id="photo" name="photo" type="file" accept="image/*" class="sr-only">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                </div>
                            </div>
                            @error('photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Photo Preview -->
                        <div id="photo-preview" class="hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                            <div class="relative inline-block">
                                <img id="preview-img" src="" alt="Preview" class="h-32 w-32 rounded-full object-cover shadow-md">
                                <button type="button" id="remove-photo" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
                                    ×
                                </button>
                            </div>
                        </div>

                        <!-- Social Media Handles -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="instagram_handle" class="block text-sm font-medium text-gray-700 mb-2">
                                    Instagram Handle
                                </label>
                                <input type="text" 
                                       id="instagram_handle" 
                                       name="instagram_handle" 
                                       value="{{ old('instagram_handle') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="@username">
                                @error('instagram_handle')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="x_handle" class="block text-sm font-medium text-gray-700 mb-2">
                                    X (Twitter) Handle
                                </label>
                                <input type="text" 
                                       id="x_handle" 
                                       name="x_handle" 
                                       value="{{ old('x_handle') }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       placeholder="@username">
                                @error('x_handle')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <a href="{{ route('actor-submissions.index') }}" 
                                   class="text-gray-600 hover:text-gray-800 font-medium">
                                    ← Back to My Submissions
                                </a>
                                <button type="submit" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Submit Actor
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Box -->
            <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 mb-1">Submission Guidelines</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Make sure the actor isn't already in our database</li>
                            <li>• Provide accurate social media handles (without the @ symbol)</li>
                            <li>• Upload a clear, recent photo of the actor if available</li>
                            <li>• Your submission will be reviewed by our admin team</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Photo preview functionality
        document.getElementById('photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-img').src = e.target.result;
                    document.getElementById('photo-preview').classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('remove-photo').addEventListener('click', function() {
            document.getElementById('photo').value = '';
            document.getElementById('photo-preview').classList.add('hidden');
        });
    </script>
</x-app-layout>