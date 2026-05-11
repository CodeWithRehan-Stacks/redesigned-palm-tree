<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show(Request $request, $username)
    {
        $user = User::where('username', $username)
            ->withCount(['followers', 'following', 'notes'])
            ->firstOrFail();
        
        $tab = $request->get('tab', 'notes');
        
        $notes = match($tab) {
            'liked' => $user->likedNotes()->with(['user', 'category'])->latest()->paginate(12),
            'saved' => $user->savedNotes()->with(['user', 'category'])->latest()->paginate(12),
            // 'reposts' => $user->reposts()->with(['user', 'category'])->latest()->paginate(12),
            default => $user->notes()->where('visibility', 'public')->with(['category'])->latest()->paginate(12),
        };

        if ($request->ajax()) {
            return response()->json([
                'html' => view('profile.partials.notes_list', compact('user', 'notes'))->render(),
                'hasMore' => $notes->hasMorePages()
            ]);
        }

        return view('profile.show', compact('user', 'notes', 'tab'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'university' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profiles/pictures', 'public');
        }

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('profiles/banners', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user->username)->with('success', 'Profile updated successfully.');
    }

    public function followers(User $user)
    {
        $followers = $user->followers()->withCount('followers')->paginate(20);
        return response()->json($followers);
    }

    public function following(User $user)
    {
        $following = $user->following()->withCount('followers')->paginate(20);
        return response()->json($following);
    }
}
