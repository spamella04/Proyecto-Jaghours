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
        Schema::create('job_oportunities', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->enum('status', [
                JobOpportunityStatus::Draft,
                JobOpportunityStatus::Pending,
                JobOpportunityStatus::Published,
                JobOpportunityStatus::Closed,
                JobOpportunityStatus::Cancelled
            ])->default(JobOpportunityStatus::Draft);
            $table->date('start_date');
            $table->unsignedInteger('hours_validated');
            $table->unsignedInteger('number_applicants');
            $table->unsignedInteger('number_vacancies');
            $table->string('requirements');
            $table->string('area_manager_cif');
            $table->foreign('area_manager_cif')->references('are_manager_cif')->on('area_managers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_oportunities');
    }
};
