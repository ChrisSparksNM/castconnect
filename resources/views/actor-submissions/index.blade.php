<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        My Actor Submissions
                    </h1>
                    <p class="text-lg text-gray-600">
                        Track the status of your submitted actors
                    </p>
                </div>
                <a href="{{ route('actor-submissions.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    Submit New Actor
                </a>
            </div>

            @if($submissions->count() > 0)
                <!-- Submissions Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($submissions as $submission)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Submission Header -->
                            <div class="p-6">
                                <div class="flex items-center space-x-4 mb-4">
                                    <!-- Actor Photo -->
                                    @if($submission->photo_path)
                                        <img src="{{ asset('storage/' . $submission->photo_path) }}" 
                                             alt="{{ $submission->actor_name }}" 
                                             class="w-16 h-16 rounded-full object-cover border-2 border-gray-200 shadow-sm">
                                    @else
                                        <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($submission->actor_name, 0, 1) }}
                                        </div>
                                    @endif
                                    
                                    <!-- Actor Info -->
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 text-lg">{{ $submission->actor_name }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $submission->tvShow->name }}</p>
                                        @if($submission->character_name)
                                            <p class="text-gray-500 text-xs">as {{ $submission->character_name }}</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Status Badge -->
                                    <div>
                                        @if($submission->status === 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                Pending Review
                                            </span>
                                        @elseif($submission->status === 'approved')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                Approved
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                                Rejected
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Social Media Info -->
                                <div class="space-y-2 mb-4">
                                    @if($submission->instagram_handle)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                            </svg>
                                            Instagram: {{ $submission->instagram_handle }}
                                        </div>
                                    @endif
                                    @if($submission->x_handle)
                                        <div class="flex items-center text-sm text-gray-600">
                                            <svg class="w-4 h-4 mr-2 text-gray-900" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                            </svg>
                                            X: {{ $submission->x_handle }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Submission Date -->
                                <div class="text-xs text-gray-500 border-t border-gray-100 pt-3">
                                    Submitted {{ $submission->created_at->format('M j, Y') }}
                                    @if($submission->reviewed_at)
                                        • Reviewed {{ $submission->reviewed_at->format('M j, Y') }}
                                    @endif
                                </div>

                                <!-- Admin Notes for Rejected Submissions -->
                                @if($submission->status === 'rejected' && $submission->admin_notes)
                                    <div class="mt-3 bg-red-50 border border-red-200 rounded-lg p-3">
                                        <h4 class="text-sm font-medium text-red-800 mb-1">Admin Notes:</h4>
                                        <p class="text-sm text-red-700">{{ $submission->admin_notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto mb-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">No Actor Submissions Yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        You haven't submitted any actors yet. Help expand our database by submitting your favorite TV show actors!
                    </p>
                    <a href="{{ route('actor-submissions.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        Submit Your First Actor
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>