<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DictamenPorEntregar extends Mailable{
    use Queueable, SerializesModels;
    public $subject = "Dictamenes pendientes por entregar";

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(){
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->view('Correos.dictamenPorEntregar');
    }
}
