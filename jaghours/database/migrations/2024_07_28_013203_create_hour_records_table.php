<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hour_records', function (Blueprint $table) {
            $table->id();
            $table->date('work_date');
            $table->unsignedBigInteger('hours_worked');
            $table->unsignedBigInteger('semester_id');
            $table->unsignedBigInteger('job_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('area_manager_id');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('area_manager_id')->references('area_manager_id')->on('area_managers');
            $table->timestamps();

        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hour_records');
    }
};
