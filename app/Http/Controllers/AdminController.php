<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\ActorSubmission;
use Illuminate\Http\Request;

class AdminController extends Controller
{


    public function submissions()
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        $submissions = ActorSubmission::with(['tvShow', 'user', 'reviewer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.submissions', compact('submissions'));
    }

    public function approveSubmission(ActorSubmission $submission)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        // Create the actor from the submission
        Actor::create([
            'tv_show_id' => $submission->tv_show_id,
            'name' => $submission->actor_name,
            'character_name' => $submission->character_name,
            'instagram_handle' => $submission->instagram_handle,
            'x_handle' => $submission->x_handle,
        ]);

        // Update submission status
        $submission->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Submission approved and actor added!');
    }

    public function rejectSubmission(Request $request, ActorSubmission $submission)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $submission->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Submission rejected.');
    }
}
