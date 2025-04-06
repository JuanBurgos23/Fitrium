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
        Schema::create('recibo', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recibo');
            $table->string('recibido_de');
            $table->string('concepto');
            $table->float('a_cuenta');
            $table->float('saldo');
            $table->float('total');
            $table->string('forma_pago');
            $table->date('fecha_pago');
            $table->string('estado');
            $table->unsignedBigInteger('id_inscripcion')->nullable();
            $table->foreign('id_inscripcion')->references('id')->on('inscripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recibo');
    }
};
