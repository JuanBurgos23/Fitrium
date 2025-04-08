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
        Schema::create('asistencia', function (Blueprint $table) {
            $table->id();

            $table->date('fecha_ingreso');
            $table->time('hora_entrada');
            $table->time('hora_salida')->nullable();
            $table->string('estado');
            $table->foreignId('id_inscripcion')->references('id')->on('inscripcion');
            $table->foreignId('id_casillero')->references('id')->on('casillero');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencia');
    }
};
