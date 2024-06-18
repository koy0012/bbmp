<?php

namespace App\Providers;

use App\Models\Barangay;
use App\Models\Group;
use App\Models\Municipal;
use App\Models\Province;
use App\Models\Region;
use App\Models\User;
use App\Models\UserInfo;
use App\Observers\BarangayObserver;
use App\Observers\GroupObserver;
use App\Observers\MunicipalObserver;
use App\Observers\ProvinceObserver;
use App\Observers\RegionObserver;
use App\Observers\UserInfoObserver;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Group::observe(GroupObserver::class);
        User::observe(UserObserver::class);
        UserInfo::observe(UserInfoObserver::class);
        Region::observe(RegionObserver::class); 
        Province::observe(ProvinceObserver::class);
        Municipal::observe(MunicipalObserver::class);
        Barangay::observe(BarangayObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
