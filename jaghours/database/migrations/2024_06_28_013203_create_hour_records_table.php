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
            $table->unsignedBigInteger('job_opportunity_id');
            $table->string('student_cif');
            $table->string('area_manager_cif');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('job_opportunity_id')->references('id')->on('job_oportunities');
            $table->foreign('student_cif')->references('student_cif')->on('students');
            $table->foreign('area_manager_cif')->references('area_manager_cif')->on('area_managers');
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
