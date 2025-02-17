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
        Schema::create('daily_record_diet_option', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_record_id')->constrained()->onDelete('cascade');
            $table->foreignId('diet_id')->constrained()->onDelete('cascade');
            $table->string('meal'); // Para identificar la comida (desayuno, almuerzo, cena)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_record_diet_option');
    }
};
