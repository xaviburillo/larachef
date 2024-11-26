<?php

namespace App\Providers;

use App\Events\RecetaPublicada;
use App\Events\RecetaRechazada;
use App\Listeners\SendRecetaPublicadaEmail;
use App\Listeners\SendRecetaRechazadaEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RecetaPublicada::class => [
            SendRecetaPublicadaEmail::class,
        ],
        RecetaRechazada::class => [
            SendRecetaRechazadaEmail::class,
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
