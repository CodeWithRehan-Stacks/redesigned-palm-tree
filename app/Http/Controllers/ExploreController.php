<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class ExploreController extends Controller
{
    /**
     * Display the explore page with trending, topics, and featured users.
     */
    public function index()
    {
        // 1. Trending Notes (weighted score logic or simple counts)
        $trendingNotes = Note::with(['user', 'category'])
            ->where('visibility', 'public')
            ->orderBy('likes_count', 'desc')
            ->take(6)
            ->get();

        // 2. Top Topics (Categories with most notes)
        $topTopics = Category::withCount('notes')
            ->orderBy('notes_count', 'desc')
            ->take(10)
            ->get();

        // 3. Suggested Users (Most followed)
        $suggestedUsers = User::withCount('followers')
            ->where('id', '!=', auth()->id())
            ->orderBy('followers_count', 'desc')
            ->take(6)
            ->get();

        // 4. All public notes for the general feed
        $notes = Note::with(['user', 'category'])
            ->where('visibility', 'public')
            ->latest()
            ->paginate(15);

        return view('explore.index', compact('trendingNotes', 'topTopics', 'suggestedUsers', 'notes'));
    }
}
