<?php

namespace App\Listeners;

use App\Events\RecetaPublicada;
use App\Mail\RecetaPublicada as MailRecetaPublicada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRecetaPublicadaEmail {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\RecetaPublicada  $event
     * @return void
     */
    public function handle(RecetaPublicada $event) {
        Mail::to($event->user->email)->send(
            new MailRecetaPublicada($event->receta, $event->user->recetas()->count())
        );
    }
}
