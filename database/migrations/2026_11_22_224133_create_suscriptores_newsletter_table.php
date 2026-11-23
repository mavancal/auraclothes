<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suscriptores_newsletter', function (Blueprint $table) {
            $table->id();
            $table->string('email', 120)->unique();
            $table->timestamps(); // created_at = fecha de suscripción
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suscriptores_newsletter');
    }
};