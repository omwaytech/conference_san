<?php

namespace App\Providers;

use App\Models\{Committee, NamePrefix, Workshop, Conference, Download, Content};
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        View::composer('*', function ($view) {
            $prefixesAll = NamePrefix::where('status', 1)->get();
            $view->with('prefixesAll', $prefixesAll);
        });

        View::composer('*', function ($view) {
            $committeesAll = Committee::where('status', 1)->get();
            $view->with('committeesAll', $committeesAll);
        });

        View::composer('*', function ($view) {
            $workshopsAll = [];
            $latestConference = Conference::latestConference();
            if (!empty($latestConference)) {
                $workshopsAll = Workshop::where(['conference_id' => $latestConference->id, 'status' => 1])->get();
            }
            $view->with('workshopsAll', $workshopsAll);
        });

        View::composer('*', function ($view) {
            $downloadsAll = [];
            $latestConference = Conference::latestConference();
            if (!empty($latestConference)) {
                $downloadsAll = Download::where(['conference_id' => $latestConference->id, 'is_featured' => 1, 'status' => 1])->get();
            }
            $view->with('downloadsAll', $downloadsAll);
        });
    }
}
