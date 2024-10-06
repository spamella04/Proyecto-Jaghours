<?php

namespace App\Notifications;

use App\Models\JobOportunity;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JobOportunityRequested extends Notification
{
    protected $jobOportunity; // Cambié el nombre a minúsculas para seguir las convenciones de PHP

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
            ->subject('Nueva solicitud de Oportunidad de Trabajo')
            ->line('Tiene una nueva solicitud de oportunidad de trabajo: "' . $this->jobOportunity->title . '" ')
            //->action('Ver Oportunidad', url('/job-opportunities/' . $this->jobOportunity->id))
            ->line('Solicitada por ' . $this->jobOportunity->area_managers->users->name . ' del area de' . $this->jobOportunity->area_managers->areas->name)
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
