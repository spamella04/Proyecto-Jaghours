<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;

class SemesterCompletedPDF extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $hourRecords;
    public $semester;
    public $degree;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Student $student
     * @param \Illuminate\Support\Collection $hourRecords
     * @param \App\Models\Semester $semester
     */
    public function __construct(Student $student, $hourRecords, $semester)
    {
        $this->student = $student;
        $this->degree = $student->degree;
        $this->hourRecords = $hourRecords;
        $this->semester = $semester;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Generate the PDF from the view
        $pdf = Pdf::loadView('pdf.semesterhourscompleted', [
            'student' => $this->student,
            'degree' => $this->degree,
            'hourRecords' => $this->hourRecords,
            'semester' => $this->semester,
        ]);

        // Send the email with the PDF attachment
        return $this->subject('Has completado tus horas del semestre!')  // Email subject
                    ->view('emails.semestercompleted')  // Email body view
                    ->attachData($pdf->output(), 'horas_trabajadas_'. $this->student->cif .'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
