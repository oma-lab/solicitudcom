<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RestablecerContrasenaUsuario extends Notification
{
    use Queueable;

    protected $token;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        //
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Restablecer Contraseña')
                    ->greeting('HOLA')
                    ->line('Ha recibido este correo electrónico para restablecer su contraseña para su cuenta de Comité Académico.')
                    ->action('Restablecer contraseña', url('/password/reset/'.$this->token))
                    ->line('Este enlace para el restablecimiento de su contraseña caducará en 60 minutos.')
                    ->line('Si no ha solicitado restablecer su contraseña, haz caso omiso a este correo.')
                    ->salutation('Gracias');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
