<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Laravel\Fortify\Features;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;
use Laravel\Nova\Menu\Menu;
use Laravel\Nova\Menu\MenuItem;
use Laravel\Nova\Menu\MenuSection;
use Illuminate\Http\Request;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        parent::boot();

        Nova::footer(function ($request) {
            return '<div>&copy; ' . date('Y') . ' ShareNote. All rights reserved.</div>';
        });

        Nova::style('custom-nova', public_path('css/custom-nova.css'));

        Nova::mainMenu(function (Request $request) {
            return [
                MenuSection::dashboard(\App\Nova\Dashboards\Main::class)->icon('chart-bar'),

                MenuSection::make('Analytics & Insights', [
                    MenuItem::resource(\App\Nova\Download::class),
                    MenuItem::resource(\App\Nova\Report::class),
                ])->icon('chart-bar')->collapsable(),

                MenuSection::make('Content Management', [
                    MenuItem::resource(\App\Nova\Note::class),
                    MenuItem::resource(\App\Nova\Category::class),
                    MenuItem::resource(\App\Nova\Subject::class),
                    MenuItem::resource(\App\Nova\University::class),
                    MenuItem::resource(\App\Nova\Tag::class),
                ])->icon('document-text')->collapsable(),

                MenuSection::make('Users & Community', [
                    MenuItem::resource(\App\Nova\User::class),
                    MenuItem::resource(\App\Nova\PayoutRequest::class),
                ])->icon('users')->collapsable(),

                MenuSection::make('Monetization', [
                    MenuItem::resource(\App\Nova\Plan::class),
                    MenuItem::resource(\App\Nova\Transaction::class),
                ])->icon('cash')->collapsable(),

                MenuSection::make('Community Features', [
                    MenuItem::resource(\App\Nova\Raise::class),
                ])->icon('sparkles')->collapsable(),
            ];
        });
    }

    /**
     * Register the configurations for Laravel Fortify.
     */
    protected function fortify(): void
    {
        Nova::fortify()
            ->features([
                Features::updatePasswords(),
                // Features::emailVerification(),
                // Features::twoFactorAuthentication(['confirm' => true, 'confirmPassword' => true]),
            ])
            ->register();
    }

    /**
     * Register the Nova routes.
     */
    protected function routes(): void
    {
        Nova::routes()
            ->withAuthenticationRoutes(default: true)
            ->withPasswordResetRoutes()
            ->withoutEmailVerificationRoutes()
            ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewNova', function (User $user) {
            return in_array($user->email, [
                'Khaled@albalooshi.me',
            ]);
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Dashboard>
     */
    protected function dashboards(): array
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array<int, \Laravel\Nova\Tool>
     */
    public function tools(): array
    {
        return [];
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        parent::register();

        //
    }
}
