<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarCitatorio extends Mailable{
    use Queueable, SerializesModels;
    public $subject = "Citatorio de Reunión Comité Académico";
    public $citatorio;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($citatorio){
        $this->citatorio=$citatorio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('Correos.enviarCitatorio');
    }
}
