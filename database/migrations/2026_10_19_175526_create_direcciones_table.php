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
        Schema::create('direcciones', function (Blueprint $table) {
            $table->id();
            $table->string('calle', 120);
            $table->string('numero', 10);
            $table->string('piso', 10)->nullable();
            $table->string('departamento', 10)->nullable();
            $table->string('cod_postal', 10)->nullable();
            $table->boolean('es_principal')->default(false);
            $table->string('referencia', 255)->nullable();
            $table->foreignId('localidad_id')->constrained('localidades');
            $table->foreignId('contacto_id')->constrained('contactos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('direcciones');
    }
};
