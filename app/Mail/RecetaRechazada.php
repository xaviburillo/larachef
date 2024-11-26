<?php

namespace App\Mail;

use App\Models\Receta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecetaRechazada extends Mailable {
    use Queueable, SerializesModels;

    public $receta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Receta $receta) {
        $this->receta = $receta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from('no-reply@larachef.com')
                    ->subject('¡Receta rechazada!')
                    ->view('emails.recetas.rechazada');
    }
}
