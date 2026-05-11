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
            (new \App\Nova\Metrics\TotalRevenue)->width('1/4'),
            (new \App\Nova\Metrics\TotalDownloads)->width('1/4'),
            (new \App\Nova\Metrics\ActiveUsersToday)->width('1/4'),
            (new \App\Nova\Metrics\PendingApprovals)->width('1/4'),

            (new \App\Nova\Metrics\RevenueTrend)->width('2/3'),
            (new \App\Nova\Metrics\CategoryDistribution)->width('1/3'),
            
            new \Laravel\Nova\Cards\Help,
        ];
    }
}
