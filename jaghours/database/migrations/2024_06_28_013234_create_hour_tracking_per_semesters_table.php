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
        Schema::create('hour_tracking_per_semesters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semester_id');
            $table->string('student_cif');
            $table->string('hours_per_semester');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreign('student_cif')->references('student_cif')->on('students');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hour_tracking_per_semesters');
    }
};
