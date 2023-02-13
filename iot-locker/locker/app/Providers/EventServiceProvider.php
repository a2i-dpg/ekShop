<?php

namespace App\Providers;

use App\Events\BoxBookingEvent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use App\Events\BoxInsertEvent;
use App\Events\SmsEvent;
use App\Events\SynchronizeDataEvent;
use App\Listeners\BoxBookingSyncWithCloudListener;
use App\Listeners\BoxSyncWithCloudListener;
use App\Listeners\SmsShootingListener;
use App\Listeners\syncAssetsCloud2LocalListener;
use App\Listeners\SyncBookingDataListener;
use App\Listeners\syncBookingLocal2CloudListener;
use App\Listeners\SyncBoxDataListener;
use App\Listeners\syncBoxesCloud2LocalListener;
use App\Listeners\syncBoxLocal2CloudListener;
use App\Listeners\syncCompanyCloud2LocalListener;
use App\Listeners\SyncCompanyDataListener;
use App\Listeners\syncEventLogLocal2CloudListener;
use App\Listeners\syncMessageLocal2CloudListener;
use App\Listeners\SyncMessageLogListener;
use App\Listeners\syncReturnBookingCloud2LocalListener;
use App\Listeners\SyncReturnBookingDataCloud2LocalListener;
use App\Listeners\syncUserCloud2LocalListener;
use App\Listeners\SyncUserDataListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SmsEvent::class => [
            SmsShootingListener::class,
        ],
        BoxInsertEvent::class => [
            BoxSyncWithCloudListener::class,
        ],
        BoxBookingEvent::class => [
            BoxBookingSyncWithCloudListener::class,
        ],
        SynchronizeDataEvent::class => [
            // syncAssetsCloud2LocalListener::class,
            syncCompanyCloud2LocalListener::class,
            syncUserCloud2LocalListener::class,
            syncMessageLocal2CloudListener::class,
            syncBoxLocal2CloudListener::class,
            syncBookingLocal2CloudListener::class,
            syncBoxesCloud2LocalListener::class,
            syncReturnBookingCloud2LocalListener::class,
            syncEventLogLocal2CloudListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
