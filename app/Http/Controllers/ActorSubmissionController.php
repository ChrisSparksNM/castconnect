<?php

namespace App\Http\Controllers;

use App\Models\ActorSubmission;
use App\Models\TvShow;
use Illuminate\Http\Request;

class ActorSubmissionController extends Controller
{


    public function create()
    {
        $tvShows = TvShow::orderBy('name')->get();
        return view('actor-submissions.create', compact('tvShows'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tv_show_id' => 'required|exists:tv_shows,id',
            'actor_name' => 'required|string|max:255',
            'character_name' => 'nullable|string|max:255',
            'instagram_handle' => 'nullable|string|max:255',
            'x_handle' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'user_id' => auth()->id(),
            'tv_show_id' => $request->tv_show_id,
            'actor_name' => $request->actor_name,
            'character_name' => $request->character_name,
            'instagram_handle' => $request->instagram_handle,
            'x_handle' => $request->x_handle,
        ];

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('actor-photos', 'public');
            $data['photo_path'] = $photoPath;
        }

        ActorSubmission::create($data);

        return redirect()->route('dashboard')->with('success', 'Actor submission sent for admin approval!');
    }

    public function index()
    {
        $submissions = ActorSubmission::with(['tvShow', 'user'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('actor-submissions.index', compact('submissions'));
    }
}
