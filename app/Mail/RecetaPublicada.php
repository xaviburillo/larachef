<?php

namespace App\Mail;

use App\Models\Receta;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RecetaPublicada extends Mailable {
    use Queueable, SerializesModels;

    public $receta;
    public $count;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Receta $receta, int $count) {
        $this->receta = $receta;
        $this->count = $count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from('no-reply@larachef.com')
                    ->subject('Receta publicada!')
                    ->view('emails.recetas.publicada');
    }
}
