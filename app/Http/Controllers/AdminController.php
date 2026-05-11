<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Note;
use App\Models\Report;
use App\Models\Raise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    /**
     * Admin dashboard with stats, reports, and error monitoring.
     */
    public function index()
    {
        // Core Stats
        $stats = [
            'total_users' => User::count(),
            'total_notes' => Note::count(),
            'total_raises' => Raise::count(),
            'pending_reports' => Report::where('status', 'pending')->count(),
        ];

        // Recent Users
        $recentUsers = User::latest()->take(5)->get();

        // Active Reports
        $activeReports = Report::with(['user'])->latest()->take(10)->get();

        // Error Monitoring (Last 10 Errors from Laravel Log)
        $errors = $this->getLastErrors();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'activeReports', 'errors'));
    }

    /**
     * Get the last 10 errors from the Laravel log file.
     */
    private function getLastErrors()
    {
        $logPath = storage_path('logs/laravel.log');
        $errors = [];

        if (File::exists($logPath)) {
            $content = File::get($logPath);
            // Match error patterns in Laravel logs [DATE] environment.ERROR: message
            preg_match_all('/\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\].*?\.ERROR:.*?(?=\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\]|$)/s', $content, $matches);
            
            if (!empty($matches[0])) {
                $errors = array_slice(array_reverse($matches[0]), 0, 10);
            }
        }

        return $errors;
    }
}
