<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegresarSolicitud extends Mailable{
    use Queueable, SerializesModels;
    public $subject = "Solicitud Rechazada";
    public $observacion;
    public $solicitud;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($observacion,$solicitud){
        $this->observacion=$observacion;
        $this->solicitud=$solicitud;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('Correos.regresarSolicitud');
    }
}
