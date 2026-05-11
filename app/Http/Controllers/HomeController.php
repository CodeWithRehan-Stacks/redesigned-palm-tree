<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $feed = $request->get('feed', 'trending');
        $currentUser = auth()->user();
        $followingIds = $currentUser->following()->pluck('following_id')->toArray();

        $query = Note::with(['user', 'category'])->withCount(['likes', 'comments', 'saves']);

        if ($feed === 'following') {
            $query->whereIn('user_id', $followingIds)
                  ->where('visibility', '!=', 'private')
                  ->latest('created_at');
        } elseif ($feed === 'latest') {
            $query->where('visibility', 'public')
                  ->latest('created_at');
        } else {
            $query->where('visibility', 'public')
                  ->orderByDesc('trending_score');
        }

        $notes = $query->paginate(10)->withQueryString();

        $suggestedUsers = User::where('id', '!=', $currentUser->id)
            ->whereNotIn('id', $followingIds)
            ->withCount('followers')
            ->orderByDesc('followers_count')
            ->take(3)
            ->get();

        $trendingCategories = Category::withCount('notes')
            ->orderByDesc('notes_count')
            ->take(5)
            ->get();

        return view('home', compact('notes', 'feed', 'suggestedUsers', 'trendingCategories'));
    }

    public function feed(Request $request)
    {
        $feed = $request->get('feed', 'trending');
        $currentUser = auth()->user();
        $followingIds = $currentUser->following()->pluck('following_id')->toArray();

        $query = Note::with(['user', 'category'])->withCount(['likes', 'comments', 'saves']);

        if ($feed === 'following') {
            $query->whereIn('user_id', $followingIds)
                  ->where('visibility', '!=', 'private')
                  ->latest('created_at');
        } elseif ($feed === 'latest') {
            $query->where('visibility', 'public')
                  ->latest('created_at');
        } else {
            $query->where('visibility', 'public')
                  ->orderByDesc('trending_score');
        }

        $notes = $query->paginate(10)->withQueryString();

        return response()->json([
            'html' => view('home.partials.notes_feed', compact('notes'))->render(),
            'hasMore' => $notes->hasMorePages(),
            'nextPage' => $notes->nextPageUrl(),
        ]);
    }

    public function markNotificationsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
