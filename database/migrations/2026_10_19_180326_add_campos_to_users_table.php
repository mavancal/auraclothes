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
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('ultimo_acceso')->nullable();
            $table->boolean('activo')->default(true);
            $table->foreignId('contacto_id')->unique()->constrained('contactos');
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['contacto_id']);
            $table->dropUnique(['name']);
            $table->dropColumn(['ultimo_acceso', 'activo', 'contacto_id']);
        });
    }
};
