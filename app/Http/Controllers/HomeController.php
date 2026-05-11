<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Raise;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $feed = $request->get('feed', 'trending');
        $currentUser = auth()->user();

        $query = Note::query()->with(['user', 'category'])->withCount(['likes', 'comments', 'saves']);

        if ($feed === 'following') {
            $query->whereIn('user_id', $currentUser->following()->pluck('following_id'))
                  ->where('visibility', '!=', 'private')
                  ->latest();
        } else {
            // Trending feed
            $query->where('visibility', 'public')
                  ->orderByDesc('trending_score');
        }

        $notes = $query->paginate(10)->withQueryString();

        // Get suggested users (who I'm not following)
        $suggestedUsers = \App\Models\User::where('id', '!=', $currentUser->id)
            ->whereNotIn('id', $currentUser->following()->pluck('following_id'))
            ->withCount('followers')
            ->orderByDesc('followers_count')
            ->take(3)
            ->get();

        // Get trending tags or categories
        $trendingCategories = \App\Models\Category::take(5)->get();
        
        return view('home', compact('notes', 'feed', 'suggestedUsers', 'trendingCategories'));
    }

    public function markNotificationsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
