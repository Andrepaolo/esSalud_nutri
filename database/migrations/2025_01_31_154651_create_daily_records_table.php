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
        Schema::create('daily_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bed_id')->constrained()->onDelete('cascade'); // Relación con cama
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null'); // Relación con paciente
            $table->date('fecha_registro')->default(now());
            $table->string('desayuno')->nullable();
            $table->string('am10')->nullable();
            $table->string('almuerzo')->nullable();
            $table->string('pm4')->nullable();
            $table->string('cena')->nullable();
            $table->text('indicaciones')->nullable();
            $table->text('diagnostico')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_records');
    }
};
