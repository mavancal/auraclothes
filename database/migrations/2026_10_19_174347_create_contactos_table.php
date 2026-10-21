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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 50);
            $table->string('nombre2', 50)->nullable();
            $table->string('apellido', 80);
            $table->string('numero_documento', 20);
            $table->string('cuit', 11)->nullable()->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email_contacto', 120);
            $table->foreignId('tipo_documento_id')->constrained('tipos_documento');
            $table->foreignId('tipo_persona_id')->constrained('tipos_persona');
            $table->timestamps();

            $table->unique(['tipo_documento_id', 'numero_documento']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contactos');
    }
};
