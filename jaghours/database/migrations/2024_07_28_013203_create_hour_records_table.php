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
            $table->unsignedBigInteger('semester_id')->nullable();
            $table->unsignedBigInteger('job_id')->nullable();
            $table->unsignedBigInteger('area_manager_id')->nullable();
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
            $table->foreign('job_id')->references('id')->on('jobs')->onDelete('set null');
            $table->foreign('area_manager_id')->references('id')->on('area_managers')->onDelete('set null');
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
