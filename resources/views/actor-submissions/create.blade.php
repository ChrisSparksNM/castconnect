<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Submit Actor') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('actor-submissions.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="tv_show_id" class="block text-sm font-medium text-gray-700">TV Show</label>
                            <select id="tv_show_id" name="tv_show_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
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

                        <div class="mb-4">
                            <label for="actor_name" class="block text-sm font-medium text-gray-700">Actor Name</label>
                            <input type="text" id="actor_name" name="actor_name" value="{{ old('actor_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            @error('actor_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="character_name" class="block text-sm font-medium text-gray-700">Character Name (Optional)</label>
                            <input type="text" id="character_name" name="character_name" value="{{ old('character_name') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('character_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="instagram_handle" class="block text-sm font-medium text-gray-700">Instagram Handle (Optional)</label>
                            <input type="text" id="instagram_handle" name="instagram_handle" value="{{ old('instagram_handle') }}" placeholder="@username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('instagram_handle')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="x_handle" class="block text-sm font-medium text-gray-700">X (Twitter) Handle (Optional)</label>
                            <input type="text" id="x_handle" name="x_handle" value="{{ old('x_handle') }}" placeholder="@username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('x_handle')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Submit for Review
                            </button>
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-800">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>