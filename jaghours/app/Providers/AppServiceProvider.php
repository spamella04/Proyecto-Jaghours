<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\JobOportunity;
use App\Models\JobOportunityObserver;
use App\Models\HourRecord;
use App\Observers\HourRecordObserver;
use Illuminate\Pagination\Paginator;

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
        //
        JobOportunity::observe(JobOportunityObserver::class);
        Paginator::useBootstrapFour();
        
    }
}
