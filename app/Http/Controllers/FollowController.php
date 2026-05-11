<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\UserFollowedNotification;

class FollowController extends Controller
{
    /**
     * Toggle follow/unfollow for a user.
     */
    public function toggle(User $user)
    {
        $currentUser = auth()->user();

        if ($currentUser->id === $user->id) {
            return response()->json(['message' => 'You cannot follow yourself.'], 400);
        }

        // Use toggle to avoid duplicates and handle logic cleanly
        $result = $currentUser->following()->toggle($user->id);
        
        $isFollowing = count($result['attached']) > 0;
        $action = $isFollowing ? 'followed' : 'unfollowed';

        if ($isFollowing) {
            event(new \App\Events\UserFollowed($currentUser, $user));
            // Send Notification
            $user->notify(new UserFollowedNotification($currentUser));
        } else {
            event(new \App\Events\UserUnfollowed($currentUser, $user));
        }

        return response()->json([
            'status' => 'success',
            'action' => $action,
            'is_following' => $isFollowing,
            'followers_count' => $user->followers()->count(),
            'following_count' => $user->following()->count(),
            'message' => "Successfully {$action} {$user->name}"
        ]);
    }
}
