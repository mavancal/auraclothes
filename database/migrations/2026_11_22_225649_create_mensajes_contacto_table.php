<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mensajes_contacto', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('email', 120);
            $table->string('asunto', 150);
            $table->text('mensaje');
            $table->boolean('leido')->default(false);
            $table->timestamps(); // created_at = fecha en que se envió
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes_contacto');
    }
};