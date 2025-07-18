<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin - Actor Submissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($submissions->count() > 0)
                        <div class="space-y-6">
                            @foreach($submissions as $submission)
                                <div class="border rounded-lg p-6 @if($submission->status === 'pending') bg-yellow-50 @elseif($submission->status === 'approved') bg-green-50 @else bg-red-50 @endif">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h3 class="text-lg font-semibold">{{ $submission->actor_name }}</h3>
                                            <p class="text-gray-600">{{ $submission->tvShow->name }}</p>
                                            @if($submission->character_name)
                                                <p class="text-sm text-gray-500">Character: {{ $submission->character_name }}</p>
                                            @endif
                                        </div>
                                        <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                            @if($submission->status === 'pending') bg-yellow-200 text-yellow-800
                                            @elseif($submission->status === 'approved') bg-green-200 text-green-800
                                            @else bg-red-200 text-red-800 @endif">
                                            {{ ucfirst($submission->status) }}
                                        </span>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <strong>Instagram:</strong> {{ $submission->instagram_handle ?? 'Not provided' }}
                                        </div>
                                        <div>
                                            <strong>X (Twitter):</strong> {{ $submission->x_handle ?? 'Not provided' }}
                                        </div>
                                    </div>

                                    <div class="text-sm text-gray-500 mb-4">
                                        <p><strong>Submitted by:</strong> {{ $submission->user->name }} ({{ $submission->user->email }})</p>
                                        <p><strong>Submitted on:</strong> {{ $submission->created_at->format('M j, Y g:i A') }}</p>
                                        @if($submission->reviewed_at)
                                            <p><strong>Reviewed on:</strong> {{ $submission->reviewed_at->format('M j, Y g:i A') }} by {{ $submission->reviewer->name }}</p>
                                        @endif
                                    </div>

                                    @if($submission->admin_notes)
                                        <div class="bg-gray-100 p-3 rounded mb-4">
                                            <strong>Admin Notes:</strong> {{ $submission->admin_notes }}
                                        </div>
                                    @endif

                                    @if($submission->status === 'pending')
                                        <div class="flex space-x-4">
                                            <form method="POST" action="{{ route('admin.submissions.approve', $submission) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                                    Approve
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.submissions.reject', $submission) }}" class="inline">
                                                @csrf
                                                <div class="flex items-center space-x-2">
                                                    <input type="text" name="admin_notes" placeholder="Rejection reason (optional)" class="rounded border-gray-300 text-sm">
                                                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                                        Reject
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">No submissions found.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>