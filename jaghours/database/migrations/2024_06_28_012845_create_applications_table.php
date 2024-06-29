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
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('job_opportunity_id');
            $table->enum('status',['Pendiente','Aceptado','No Aceptado'])->default('Pendiente');
            $table->foreign('student_id')->references('student_id')->on('students');
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
