<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Admin Navigation -->
            <div class="mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.submissions') }}" 
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                            Actor Submissions
                        </a>
                        <a href="{{ route('admin.tv-show-submissions') }}" 
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                            TV Show Submissions
                        </a>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    TV Show Submissions
                </h1>
                <p class="text-lg text-gray-600">
                    Review and manage TV show submissions from users
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

            <!-- Error Message -->
            @if(session('error'))
                <div class="mb-8 bg-red-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="bg-yellow-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Pending Review</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $submissions->where('status', 'pending')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="bg-green-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Approved</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $submissions->where('status', 'approved')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="bg-red-100 p-3 rounded-lg">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Rejected</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $submissions->where('status', 'rejected')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($submissions->count() > 0)
                <!-- Submissions List -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">All Submissions</h3>
                    </div>
                    
                    <div class="divide-y divide-gray-200">
                        @foreach($submissions as $submission)
                            <div class="p-6 hover:bg-gray-50 transition-colors">
                                <div class="flex items-start justify-between">
                                    <!-- Submission Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4 mb-3">
                                            <!-- Show Image -->
                                            @if($submission->image_path)
                                                <img src="{{ asset('storage/' . $submission->image_path) }}" 
                                                     alt="{{ $submission->name }}" 
                                                     class="w-16 h-20 object-cover rounded-lg shadow-sm">
                                            @else
                                                <div class="w-16 h-20 bg-gradient-to-r from-gray-400 to-gray-500 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            
                                            <!-- Show Details -->
                                            <div class="flex-1">
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $submission->name }}</h4>
                                                <div class="flex items-center space-x-4 text-sm text-gray-500 mb-2">
                                                    @if($submission->genre)
                                                        <span class="bg-gray-100 px-2 py-1 rounded">{{ $submission->genre }}</span>
                                                    @endif
                                                    @if($submission->year_started)
                                                        <span>{{ $submission->year_started }}{{ $submission->year_ended ? ' - ' . $submission->year_ended : ' - Present' }}</span>
                                                    @endif
                                                </div>
                                                @if($submission->description)
                                                    <p class="text-gray-600 text-sm line-clamp-2">{{ $submission->description }}</p>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Submission Meta -->
                                        <div class="flex items-center space-x-6 text-sm text-gray-500">
                                            <span>Submitted by: <strong>{{ $submission->user->name }}</strong></span>
                                            <span>{{ $submission->created_at->format('M j, Y g:i A') }}</span>
                                            @if($submission->approved_at)
                                                <span>Reviewed: {{ $submission->approved_at->format('M j, Y') }}</span>
                                            @endif
                                        </div>

                                        <!-- Admin Notes -->
                                        @if($submission->admin_notes)
                                            <div class="mt-3 bg-gray-100 rounded-lg p-3">
                                                <p class="text-sm text-gray-700"><strong>Admin Notes:</strong> {{ $submission->admin_notes }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Status & Actions -->
                                    <div class="ml-6 flex flex-col items-end space-y-3">
                                        <!-- Status Badge -->
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

                                        <!-- Action Buttons -->
                                        @if($submission->status === 'pending')
                                            <div class="flex space-x-2">
                                                <!-- Approve Button -->
                                                <form method="POST" action="{{ route('admin.tv-show-submissions.approve', $submission) }}" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium py-1 px-3 rounded transition-colors"
                                                            onclick="return confirm('Are you sure you want to approve this TV show submission?')">
                                                        Approve
                                                    </button>
                                                </form>

                                                <!-- Reject Button -->
                                                <button type="button" 
                                                        class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium py-1 px-3 rounded transition-colors"
                                                        onclick="openRejectModal({{ $submission->id }}, '{{ $submission->name }}')">
                                                    Reject
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <svg class="w-24 h-24 mx-auto mb-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-gray-900 mb-4">No TV Show Submissions</h3>
                    <p class="text-gray-600">
                        No TV show submissions have been made yet.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Reject TV Show Submission</h3>
                <p class="text-sm text-gray-600 mb-4">
                    Are you sure you want to reject "<span id="rejectShowName"></span>"?
                </p>
                
                <form id="rejectForm" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Reason for rejection (optional)
                        </label>
                        <textarea id="admin_notes" 
                                  name="admin_notes" 
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                  placeholder="Provide feedback to the user..."></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                onclick="closeRejectModal()"
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium py-2 px-4 rounded transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded transition-colors">
                            Reject Submission
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRejectModal(submissionId, showName) {
            document.getElementById('rejectShowName').textContent = showName;
            document.getElementById('rejectForm').action = `/admin/tv-show-submissions/${submissionId}/reject`;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function closeRejectModal() {
            document.getElementById('rejectModal').classList.add('hidden');
            document.getElementById('admin_notes').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    </script>
</x-app-layout>