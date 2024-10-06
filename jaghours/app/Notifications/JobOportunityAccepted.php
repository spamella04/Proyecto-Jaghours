<?php

namespace App\Notifications;

use App\Models\JobOportunity;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobOportunityAccepted extends Notification
{

    protected $jobOportunity;

    /**
     * Create a new notification instance.
     *
     * @param JobOportunity $jobOportunity
     */
    public function __construct(JobOportunity $jobOportunity)
    {
        $this->jobOportunity = $jobOportunity;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('¡Hola!')
                    ->subject('Oportunidad de trabajo aceptada')
                    ->line('Su oportunidad de trabajo "' . $this->jobOportunity->title . '" ha sido aceptada.')
                    //->action('Ver Oportunidad', url('/job-opportunities/' . $this->jobOportunity->id))
                    ->line('Buen dia!')
                    ->salutation('Saludos, Jaghours');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->jobOportunity->title,
            'id' => $this->jobOportunity->id,
        ];
    }
}
