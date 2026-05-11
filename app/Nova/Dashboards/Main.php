<?php

namespace App\Nova\Dashboards;

use App\Nova\Cards\ActivityFeed;
use App\Nova\Metrics\ActiveUsersNow;
use App\Nova\Metrics\CategoryDistribution;
use App\Nova\Metrics\NewNotes;
use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\PendingApprovals;
use App\Nova\Metrics\RevenueTrend;
use App\Nova\Metrics\TotalDownloads;
use App\Nova\Metrics\TotalRevenue;
use App\Nova\Metrics\TrendingTopics;
use Laravel\Nova\Card;
use Laravel\Nova\Cards\Help;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    /**
     * Get the cards for the dashboard.
     *
     * @return array<int, Card>
     */
    public function cards(): array
    {
        return [
            // Top Row - Key Metrics
            (new TotalRevenue)->width('1/3'),
            (new TotalDownloads)->width('1/3'),
            (new ActiveUsersNow)->width('1/3'),
            (new PendingApprovals)->width('1/3'),

            // Second Row - Trends and Analytics
            (new RevenueTrend)->width('1/3'),
            (new TrendingTopics)->width('1/3'),

            // Third Row - Distribution and Insights
            (new CategoryDistribution)->width('1/3'),
            (new NewNotes)->width('1/3'),
            (new NewUsers)->width('1/3'),

            // Activity Feed
            (new ActivityFeed)->width('full'),

            // Help and Information
            new Help,
        ];
    }
}
