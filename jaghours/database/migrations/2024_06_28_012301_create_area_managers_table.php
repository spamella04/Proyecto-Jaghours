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
        Schema::create('area_managers', function (Blueprint $table) {
            $table->string('area_manager_cif')->primary();
            $table->string('area_code');
            $table->foreign('area_manager_cif')->references('cif')->on('users');
            $table->foreign('area_code')->references('code')->on('areas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_managers');
    }
};
