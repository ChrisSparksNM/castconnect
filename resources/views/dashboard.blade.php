<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    Welcome back, {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-lg text-gray-600">
                    Ready to discover and share TV actor social media profiles?
                </p>
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

            <!-- Quick Actions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <!-- Submit Actor Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 p-6">
                        <div class="flex items-center">
                            <div class="bg-white/20 rounded-lg p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-white">Submit Actor</h3>
                                <p class="text-blue-100 text-sm">Add new actors</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            Add your favorite TV show actors and their social media handles to our community database.
                        </p>
                        <a href="{{ route('actor-submissions.create') }}" 
                           class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            Get Started
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Submit TV Show Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 p-6">
                        <div class="flex items-center">
                            <div class="bg-white/20 rounded-lg p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6H3a1 1 0 110-2h4zM6 6v12h12V6H6zm3 3a1 1 0 112 0v6a1 1 0 11-2 0V9zm4 0a1 1 0 112 0v6a1 1 0 11-2 0V9z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-white">Submit Show</h3>
                                <p class="text-orange-100 text-sm">Add new shows</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            Submit TV shows that aren't in our database yet so users can add actors for them.
                        </p>
                        <a href="{{ route('tv-show-submissions.create') }}" 
                           class="inline-flex items-center bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            Submit Show
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- My Submissions Card -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 p-6">
                        <div class="flex items-center">
                            <div class="bg-white/20 rounded-lg p-3">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-white">My Submissions</h3>
                                <p class="text-green-100 text-sm">Track your progress</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <p class="text-gray-600 mb-4">
                            View the status of your submitted actors and track their approval progress.
                        </p>
                        <a href="{{ route('actor-submissions.index') }}" 
                           class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                            View Status
                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Admin Panel Card (if admin) -->
                @if(auth()->user()->is_admin)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 p-6">
                            <div class="flex items-center">
                                <div class="bg-white/20 rounded-lg p-3">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-white">Admin Panel</h3>
                                    <p class="text-purple-100 text-sm">Manage submissions</p>
                                </div>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-600 mb-4">
                                Review and approve actor submissions from the community.
                            </p>
                            <a href="{{ route('admin.submissions') }}" 
                               class="inline-flex items-center bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors">
                                Manage
                                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Recent Activity Section -->
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900">Quick Stats</h2>
                    <div class="text-sm text-gray-500">
                        Updated just now
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-6 bg-blue-50 rounded-lg">
                        <div class="text-3xl font-bold text-blue-600 mb-2">
                            {{ \App\Models\ActorSubmission::where('user_id', auth()->id())->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Your Submissions</div>
                    </div>

                    <div class="text-center p-6 bg-green-50 rounded-lg">
                        <div class="text-3xl font-bold text-green-600 mb-2">
                            {{ \App\Models\ActorSubmission::where('user_id', auth()->id())->where('status', 'approved')->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Approved</div>
                    </div>

                    <div class="text-center p-6 bg-yellow-50 rounded-lg">
                        <div class="text-3xl font-bold text-yellow-600 mb-2">
                            {{ \App\Models\ActorSubmission::where('user_id', auth()->id())->where('status', 'pending')->count() }}
                        </div>
                        <div class="text-sm text-gray-600">Pending Review</div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-gradient-to-r from-gray-50 to-blue-50 rounded-xl p-8 border border-gray-100">
                <div class="text-center">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Need Help Getting Started?</h3>
                    <p class="text-gray-600 mb-4">
                        Check out our guide on how to submit actors and find social media profiles.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('actor-submissions.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition-colors">
                            Submit Your First Actor
                        </a>
                        <a href="/" 
                           class="bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2 px-6 rounded-lg border border-gray-300 transition-colors">
                            Learn More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
