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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('student_cif');
            $table->unsignedBigInteger('job_opportunity_id');
            $table->enum('status', [
                ApplicationStatus::Pending,
                ApplicationStatus::Accepted,
                ApplicationStatus::Rejected
            ])->default(ApplicationStatus::Pending);
            $table->foreign('student_cif')->references('student_cif')->on('students');
            $table->foreign('job_opportunity_id')->references('id')->on('job_oportunities');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
