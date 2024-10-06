<?php

namespace App\Mail;

use App\Models\Student;
use App\Models\JobOportunity; // Cambiado a JobOportunity
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JobAcceptanceNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $jobOportunity;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Student $student, JobOportunity $jobOportunity) // Cambiado a JobOportunity
    {
        $this->student = $student;
        $this->jobOportunity = $jobOportunity;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('¡Felicidades, has sido aceptado!')
                    ->view('emails.students.job_acceptance_notification')
                    ->with([
                        'studentName' => $this->student->user->name,
                        'jobTitle' => $this->jobOportunity->title,
                        'startDate' => $this->jobOportunity->start_date,
                    ]);
    }
}
