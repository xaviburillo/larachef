<?php

namespace App\Listeners;

use App\Events\RecetaRechazada;
use App\Mail\RecetaRechazada as MailRecetaRechazada;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRecetaRechazadaEmail {
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
     * @param  \App\Events\RecetaRechazada  $event
     * @return void
     */
    public function handle(RecetaRechazada $event) {
        Mail::to($event->user->email)->send(new MailRecetaRechazada($event->receta));
    }
}
