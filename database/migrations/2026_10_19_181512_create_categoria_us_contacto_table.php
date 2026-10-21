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
        Schema::create('categoria_us_contacto', function (Blueprint $table) {
            $table->foreignId('categoria_us_id')->constrained('categorias_us');
            $table->foreignId('contacto_id')->constrained('contactos');
            $table->timestamp('fecha_asig')->useCurrent();
            $table->primary(['categoria_us_id', 'contacto_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categoria_us_contacto');
    }
};
