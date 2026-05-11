<?php

namespace App\Nova\Metrics;

use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Value;
use Laravel\Nova\Metrics\Metricable;
use Illuminate\Support\Facades\DB;

class ActiveUsersNow extends Value
{
    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        // Consider users active if they were active in the last 5 minutes
        $count = DB::table('users')
            ->where('last_active_at', '>=', now()->subMinutes(5))
            ->count();

        return $this->result($count)
            ->format('0,0')
            ->suffix('online now');
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            'NOW' => 'Currently Online',
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|null
     */
    public function cacheFor()
    {
        return now()->addSeconds(30); // Update every 30 seconds for real-time feel
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'active-users-now';
    }
}