<?php

namespace App\Observers;

use App\Models\HourRecord;
use App\Models\Student;
use App\Mail\SemesterCompletedPDF;
use Illuminate\Support\Facades\Mail;
use App\Models\Semester;

class HourRecordObserver
{
    /**
     * Handle the HourRecord "created" event.
     */
    public function created(HourRecord $hourRecord): void
{
    // Get the Student associated with the Job related to this HourRecord
    $student = $hourRecord->job->student; // Access the student via the job

    // Get the associated semester for the HourRecord
    $semester = $hourRecord->semester; // Access the semester directly

    // Sum all hours worked by the student across all jobs in the current semester
    $hourRecords = HourRecord::whereHas('job', function ($query) use ($student) {
        $query->where('student_id', $student->id);  // Filter jobs for the student
    })
    ->where('semester_id', $hourRecord->semester_id)  // Make sure to sum hours for the correct semester
    ->get(); // Get the collection of hour records

    // Sum all hours worked by the student across all jobs in the current semester
    $totalHours = $hourRecords->sum('hours_worked');

    // If the student has completed 25 or more hours, send the email
    if ($totalHours == 25) {
        Mail::to($student->user->email)
            ->send(new SemesterCompletedPDF($student, $hourRecords, $semester)); // Pass the semester directly
    }
}

    /**
     * Handle the HourRecord "updated" event.
     */
    public function updated(HourRecord $hourRecord): void
    {
        
    }

    /**
     * Handle the HourRecord "deleted" event.
     */
    public function deleted(HourRecord $hourRecord): void
    {
        //
    }

    /**
     * Handle the HourRecord "restored" event.
     */
    public function restored(HourRecord $hourRecord): void
    {
        //
    }

    /**
     * Handle the HourRecord "force deleted" event.
     */
    public function forceDeleted(HourRecord $hourRecord): void
    {
        //
    }

    
}
