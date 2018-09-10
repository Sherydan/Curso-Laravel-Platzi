<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use App\User;

class UserFollowed extends Notification
{
    use Queueable;

    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        # las notificaciones se envian al mail y se guardan en la bde
        return ['mail', 'database', 'broadcast'];
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
                    ->subject('Tienes un nuevo seguidor!')
                    ->greeting('Hola '. $notifiable->name)
                    ->line('El usuario '. $this->user->username . ' te ha seguido')
                    ->action('Ver perfil de @'. $this->user->username, url('/users/'.$this->user->username))
                    ->salutation('Saludos');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        # arreglo con datos del usuario que se guarda en la db
        return [
            'follower' => $this->user,
        ];
    }

    public function toBroadcast($notifiable){
        return new BroadcastMessage([
            'data' => $this->user,
        ]);
    }
}
