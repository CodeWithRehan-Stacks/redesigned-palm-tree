<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return view('search.results', ['notes' => collect(), 'users' => collect(), 'query' => '']);
        }

        $notes = \App\Models\Note::where('visibility', 'public')
            ->where(function($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                  ->orWhere('content', 'LIKE', "%{$query}%");
            })
            ->with(['user', 'category'])
            ->latest()
            ->paginate(12, ['*'], 'notes_page');

        $users = \App\Models\User::where('name', 'LIKE', "%{$query}%")
            ->orWhere('username', 'LIKE', "%{$query}%")
            ->withCount('followers')
            ->take(10)
            ->get();

        return view('search.results', compact('notes', 'users', 'query'));
    }
}
