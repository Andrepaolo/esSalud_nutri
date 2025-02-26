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
            $table->index('fecha_registro'); // Índice en la columna fecha_registro
            $table->index('bed_id');         // Índice en la columna bed_id
            $table->index('patient_id');     // Índice en la columna patient_id (si se utiliza para búsquedas)
            $table->index(['fecha_registro', 'bed_id']); // Índice compuesto: fecha_registro y bed_id (útil para filtros combinados)
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
