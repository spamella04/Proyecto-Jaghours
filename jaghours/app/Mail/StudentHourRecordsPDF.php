<?php

namespace App\Mail;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentHourRecordsPDF extends Mailable
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
     */
    public function __construct(Student $student, $hourRecords,$semester)
    {
        $this->student = $student;
        $this->degree=$student->degree;
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
        
        $pdf = Pdf::loadView('pdf.hourrecordsstudent', [
            'student' => $this->student,
            'degree' => $this->degree,
            'hourRecords' => $this->hourRecords,
            'semester' => $this->semester,
        ]);

        return $this->subject('Reporte de Horas Trabajadas')
                    ->view('emails.studenthourrecordspdf')
                    ->attachData($pdf->output(), 'horas_trabajadas_'. $this->student->cif .'pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
