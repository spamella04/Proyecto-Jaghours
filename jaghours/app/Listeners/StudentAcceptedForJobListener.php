<?php
namespace App\Listeners;

use App\Events\StudentAcceptedForJob;
use App\Mail\JobAcceptanceNotification;
use Illuminate\Support\Facades\Mail;

class StudentAcceptedForJobListener
{
    public function handle(StudentAcceptedForJob $event)
    {
        // Accede a la oportunidad laboral y al estudiante
        $jobOportunity = $event->jobOportunity;
        $studentId = $event->studentId;

        // Obtener el estudiante utilizando el ID
        $student = \App\Models\Student::find($studentId);
        
        if ($student) {
            // Enviar el correo al estudiante
            Mail::to($student->user->email)->send(new JobAcceptanceNotification($student, $jobOportunity));
        }
    }
}
