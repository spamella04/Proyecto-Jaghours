<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\HourRecord;
use App\Observers\HourRecordObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
       
        'App\Events\StudentAcceptedForJob' => [
            'App\Listeners\StudentAcceptedForJobListener',
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
        HourRecord::observe(HourRecordObserver::class);
       
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }


 }

