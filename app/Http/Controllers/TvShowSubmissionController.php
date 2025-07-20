<?php

namespace App\Http\Controllers;

use App\Models\TvShowSubmission;
use App\Models\TvShow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TvShowSubmissionController extends Controller
{
    public function index()
    {
        $submissions = auth()->user()->tvShowSubmissions()
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tv-show-submissions.index', compact('submissions'));
    }

    public function create()
    {
        return view('tv-show-submissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'year_started' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'year_ended' => 'nullable|integer|min:1900|max:' . (date('Y') + 5),
            'genre' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'description', 'year_started', 'year_ended', 'genre']);
        $data['user_id'] = auth()->id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('tv-show-submissions', 'public');
            $data['image_path'] = $imagePath;
        }

        TvShowSubmission::create($data);

        return redirect()->route('tv-show-submissions.index')
            ->with('success', 'TV show submitted successfully! It will be reviewed by our admin team.');
    }

    public function show(TvShowSubmission $tvShowSubmission)
    {
        // Ensure user can only view their own submissions
        if ($tvShowSubmission->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        return view('tv-show-submissions.show', compact('tvShowSubmission'));
    }

    // Admin methods
    public function adminIndex()
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $submissions = TvShowSubmission::with(['user', 'approvedBy'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.tv-show-submissions', compact('submissions'));
    }

    public function approve(TvShowSubmission $submission)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        // Create the actual TV show
        $tvShow = TvShow::create([
            'name' => $submission->name,
            'description' => $submission->description,
            'year_started' => $submission->year_started,
            'year_ended' => $submission->year_ended,
            'genre' => $submission->genre,
            'image_url' => $submission->image_path ? asset('storage/' . $submission->image_path) : null,
        ]);

        // Update submission status
        $submission->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', "TV show '{$submission->name}' has been approved and added to the database!");
    }

    public function reject(Request $request, TvShowSubmission $submission)
    {
        if (!auth()->user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $submission->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->back()
            ->with('success', "TV show submission '{$submission->name}' has been rejected.");
    }
}