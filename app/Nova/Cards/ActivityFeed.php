<?php

namespace App\Nova\Cards;

use Laravel\Nova\Card;
use Illuminate\Support\Facades\DB;

class ActivityFeed extends Card
{
    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = 'full';

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'activity-feed';
    }

    /**
     * Prepare the element for JSON serialization.
     *
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        $activities = $this->getRecentActivities();

        return array_merge(parent::jsonSerialize(), [
            'activities' => $activities,
        ]);
    }

    /**
     * Get recent activities from the database.
     *
     * @return array
     */
    protected function getRecentActivities(): array
    {
        $activities = [];

        // Recent notes
        $recentNotes = DB::table('notes')
            ->join('users', 'notes.user_id', '=', 'users.id')
            ->select('notes.title', 'notes.created_at', 'users.name as user_name')
            ->where('notes.created_at', '>=', now()->subHours(24))
            ->orderBy('notes.created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($note) {
                return [
                    'type' => 'note_created',
                    'title' => 'New note created',
                    'description' => "\"{$note->title}\" by {$note->user_name}",
                    'timestamp' => $note->created_at,
                    'icon' => 'document-text',
                    'color' => 'blue',
                ];
            });

        // Recent users
        $recentUsers = DB::table('users')
            ->select('name', 'created_at')
            ->where('created_at', '>=', now()->subHours(24))
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($user) {
                return [
                    'type' => 'user_joined',
                    'title' => 'New user joined',
                    'description' => "{$user->name} joined ShareNote",
                    'timestamp' => $user->created_at,
                    'icon' => 'user-plus',
                    'color' => 'green',
                ];
            });

        // Recent downloads
        $recentDownloads = DB::table('downloads')
            ->join('notes', 'downloads.note_id', '=', 'notes.id')
            ->join('users', 'downloads.user_id', '=', 'users.id')
            ->select('notes.title', 'users.name as user_name', 'downloads.created_at')
            ->where('downloads.created_at', '>=', now()->subHours(24))
            ->orderBy('downloads.created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($download) {
                return [
                    'type' => 'note_downloaded',
                    'title' => 'Note downloaded',
                    'description' => "{$download->user_name} downloaded \"{$download->title}\"",
                    'timestamp' => $download->created_at,
                    'icon' => 'download',
                    'color' => 'purple',
                ];
            });

        // Combine and sort all activities
        $activities = collect()
            ->merge($recentNotes)
            ->merge($recentUsers)
            ->merge($recentDownloads)
            ->sortByDesc('timestamp')
            ->take(10)
            ->values()
            ->all();

        return $activities;
    }
}