<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array<int, \Laravel\Nova\Card>
     */
    public function cards(): array
    {
        return [
            // Top Row - Key Metrics
            (new \App\Nova\Metrics\TotalRevenue)->width('1/4'),
            (new \App\Nova\Metrics\TotalDownloads)->width('1/4'),
            (new \App\Nova\Metrics\ActiveUsersNow)->width('1/4'),
            (new \App\Nova\Metrics\PendingApprovals)->width('1/4'),

            // Second Row - Trends and Analytics
            (new \App\Nova\Metrics\RevenueTrend)->width('1/2'),
            (new \App\Nova\Metrics\TrendingTopics)->width('1/2'),

            // Third Row - Distribution and Insights
            (new \App\Nova\Metrics\CategoryDistribution)->width('1/3'),
            (new \App\Nova\Metrics\NewNotes)->width('1/3'),
            (new \App\Nova\Metrics\NewUsers)->width('1/3'),

            // Activity Feed
            (new \App\Nova\Cards\ActivityFeed)->width('full'),

            // Help and Information
            new \Laravel\Nova\Cards\Help,
        ];
    }
}
