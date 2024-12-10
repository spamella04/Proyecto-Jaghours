<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\JobOpportunityStatus;

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
            $table->enum('status',['Borrador','Solicitud','Publicado','Cerrado','Rechazada', 'Asignacion Directa', 'Inactivo'])->default('Solicitud');   
            $table->date('start_date');
            $table->unsignedInteger('hours_validated');
            $table->unsignedInteger('number_applicants');
            $table->unsignedInteger('number_vacancies');
            $table->string('requirements');
            $table->boolean('match')->default(false);
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('area_manager_id');
            $table->foreign('area_manager_id')->references('id')->on('area_managers');
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
