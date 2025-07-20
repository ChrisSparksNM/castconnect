<?php

namespace App\Http\Controllers;

use App\Models\Actor;
use App\Models\ActorSubmission;
use App\Models\TvShow;
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
            'photo_url' => $submission->photo_path ? asset('storage/' . $submission->photo_path) : null,
        ]);

        // Calculate points for the user
        $points = 10; // Base points for approval
        if ($submission->instagram_handle) {
            $points += 10; // Instagram bonus
        }
        if ($submission->x_handle) {
            $points += 10; // X/Twitter bonus
        }

        // Award points to the user
        $submission->user->addPoints($points);

        // Update submission status
        $submission->update([
            'status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', "Submission approved! User awarded {$points} points.");
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

    public function uploadActorPhoto(Request $request, Actor $actor)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Delete old photo if exists
            if ($actor->photo_url) {
                $oldPath = str_replace(asset('storage/'), '', $actor->photo_url);
                \Storage::disk('public')->delete($oldPath);
            }

            // Store new photo
            $photoPath = $request->file('photo')->store('actor-photos', 'public');
            
            // Update actor with new photo URL
            $actor->update([
                'photo_url' => asset('storage/' . $photoPath)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully!',
                'photo_url' => $actor->photo_url
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading photo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadShowPhoto(Request $request, TvShow $tvShow)
    {
        if (!auth()->user()->is_admin) {
            abort(403, 'Access denied. Admin privileges required.');
        }

        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            // Delete old photo if exists
            if ($tvShow->image_url && str_contains($tvShow->image_url, 'storage/')) {
                $oldPath = str_replace(asset('storage/'), '', $tvShow->image_url);
                \Storage::disk('public')->delete($oldPath);
            }

            // Store new photo
            $photoPath = $request->file('photo')->store('tv-show-photos', 'public');
            
            // Update TV show with new photo URL
            $tvShow->update([
                'image_url' => asset('storage/' . $photoPath)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Photo uploaded successfully!',
                'photo_url' => $tvShow->image_url
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error uploading photo: ' . $e->getMessage()
            ], 500);
        }
    }
}
