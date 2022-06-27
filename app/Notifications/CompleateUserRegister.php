<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class CompleateUserRegister extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $route = $this->verificationUrl($notifiable);
        return (new MailMessage)
            ->subject('Confirmación de cuenta')
            ->greeting('Hola')
            ->line('Bienvenido')
            ->line('Has sido registrado en Hidrosoft')
            ->line('El siguiente paso será confirmar tu correo con el botón inmediato')
            ->line('Después deberás actualizar tu contraseña e ingresarás al sistema')
            ->action('Actualizar Contraseña', $route)
            ->line('¡Gracias por formar parte del equipo de Hidrosoft!');
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

        /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    public function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'confirmPassword',
            Carbon::now()->addMinutes(7200),
            ['id' => $notifiable->getKey()]
        );
    }
}
