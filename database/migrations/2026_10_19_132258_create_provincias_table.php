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
        Schema::create('provincias', function (Blueprint $table) { // CREATE TABLE provincias
            $table->id(); //id AUTO_INCREMENT PRIMARY KEY
            $table->string('descripcion', 100); // descripcion VARCHAR(100) NOT NULL
            $table->timestamps(); // crea columnas created_at y updated_at que laravel completa solo, reemplazan a la fecha_creacion.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provincias');
    }
};
