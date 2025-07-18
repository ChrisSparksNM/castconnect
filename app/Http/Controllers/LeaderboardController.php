<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $topUsers = User::where('points', '>', 0)
            ->orderBy('points', 'desc')
            ->take(50)
            ->get();

        $userRank = null;
        if (auth()->check()) {
            $userRank = User::where('points', '>', auth()->user()->points)->count() + 1;
        }

        return view('leaderboard.index', compact('topUsers', 'userRank'));
    }
}
