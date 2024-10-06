<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\JobOportunity;
use App\Models\JobOportunityObserver;

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
    }
}
