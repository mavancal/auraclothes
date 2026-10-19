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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('estado_pedido_id')->constrained('estados_pedido');
            $table->dateTime('fecha_ped')->useCurrent();
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('costo_envio', 10, 2)->default(0);
            $table->foreignId('metodo_pago_id')->constrained('metodos_pago');
            $table->foreignId('direccion_envio_id')->constrained('direcciones');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
