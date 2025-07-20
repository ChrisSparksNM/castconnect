<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        My TV Show Submissions
                    </h1>
                    <p class="text-lg text-gray-600">
                        Track the status of your submitted TV shows
                    </p>
                </div>
                <a href="{{ route('tv-show-submissions.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                    Submit New Show
                </a>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-8 bg-green-50 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if($submissions->count() > 0)
                <!-- Submissions Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($submissions as $submission)
                        <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                            <!-- Show Header -->
                            <div class="relative h-48 overflow-hidden">
                                @if($submission->image_path)
                                    <!-- Show Image Background -->
                                    <img src="{{ asset('storage/' . $submission->image_path) }}" 
                                         alt="{{ $submission->name }}" 
                                         class="w-full h-full object-cover">
                                    <!-- Dark Overlay for Text Readability -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                                @else
                                    <!-- Fallback Gradient -->
                                    <div class="w-full h-full bg-gradient-to-r from-gray-500 to-gray-600"></div>
                                @endif
                                
                                <!-- Status Badge -->
                                <div class="absolute top-4 right-4">
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
                                
                                <!-- Text Content -->
                                <div class="absolute bottom-0 left-0 right-0 p-6">
                                    <h2 class="text-xl font-bold text-white mb-2">{{ $submission->name }}</h2>
                                    <div class="flex items-center text-white/90 text-sm">
                                        <span class="mr-4">{{ $submission->genre ?? 'TV Series' }}</span>
                                        @if($submission->year_started)
                                            <span>{{ $submission->year_started }}{{ $submission->year_ended ? ' - ' . $submission->year_ended : ' - Present' }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Show Content -->
                            <div class="p-6">
                                @if($submission->description)
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $submission->description }}</p>
                                @endif

                                <!-- Submission Info -->
                                <div class="space-y-2 text-sm text-gray-500 mb-4">
                                    <div class="flex items-center justify-between">
                                        <span>Submitted:</span>
                                        <span>{{ $submission->created_at->format('M j, Y') }}</span>
                                    </div>
                                    @if($submission->approved_at)
                                        <div class="flex items-center justify-between">
                                            <span>{{ $submission->status === 'approved' ? 'Approved:' : 'Reviewed:' }}</span>
                                            <span>{{ $submission->approved_at->format('M j, Y') }}</span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Admin Notes -->
                                @if($submission->admin_notes && $submission->status === 'rejected')
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                                        <h4 class="text-sm font-medium text-red-800 mb-1">Admin Notes:</h4>
                                        <p class="text-sm text-red-700">{{ $submission->admin_notes }}</p>
                                    </div>
                                @endif

                                <!-- Status-specific content -->
                                @if($submission->status === 'approved')
                                    <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                        <p class="text-sm text-green-700">
                                            🎉 Your show has been approved and added to the database! Users can now submit actors for this show.
                                        </p>
                                    </div>
                                @elseif($submission->status === 'pending')
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
                                        <p class="text-sm text-yellow-700">
                                            ⏳ Your submission is being reviewed by our admin team. This usually takes 1-2 business days.
                                        </p>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4zM6 6v12h12V6H6zm3 3a1 1 0 112 0v6a1 1 0 11-2 0V9zm4 0a1 1 0 112 0v6a1 1 0 11-2 0V9z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">No TV Show Submissions Yet</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        You haven't submitted any TV shows yet. Help expand our database by submitting your favorite shows!
                    </p>
                    <a href="{{ route('tv-show-submissions.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors">
                        Submit Your First Show
                    </a>
                </div>
            @endif

            <!-- Info Section -->
            <div class="mt-12 bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-blue-800 mb-1">How TV Show Submissions Work</h3>
                        <ul class="text-sm text-blue-700 space-y-1">
                            <li>• Submit TV shows that aren't yet in our database</li>
                            <li>• Admin team reviews submissions for accuracy and quality</li>
                            <li>• Approved shows become available for actor submissions</li>
                            <li>• You earn points for each approved TV show submission</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>