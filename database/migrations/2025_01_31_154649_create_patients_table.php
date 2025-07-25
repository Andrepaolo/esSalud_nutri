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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->date('fecha_nacimiento')->nullable();
            $table->string('dni');
            $table->decimal('peso', 5, 2)->nullable();  // Peso del paciente, decimal, puede ser nulo
            $table->decimal('talla', 5, 2)->nullable(); // Talla del paciente, decimal, puede ser nula
            $table->decimal('imc', 5, 2)->nullable();   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
