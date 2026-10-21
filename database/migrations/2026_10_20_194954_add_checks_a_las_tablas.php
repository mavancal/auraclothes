<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE productos ADD CONSTRAINT chk_productos_precio CHECK (precio >= 0)');
        DB::statement('ALTER TABLE pedidos ADD CONSTRAINT chk_pedidos_descuento CHECK (descuento >= 0)');
        DB::statement('ALTER TABLE pedidos ADD CONSTRAINT chk_pedidos_envio CHECK (costo_envio >= 0)');
        DB::statement('ALTER TABLE detalle_pedidos ADD CONSTRAINT chk_detalle_cantidad CHECK (cantidad > 0)');
        DB::statement('ALTER TABLE detalle_pedidos ADD CONSTRAINT chk_detalle_precio CHECK (precio_unitario >= 0)');
        DB::statement("ALTER TABLE contactos ADD CONSTRAINT chk_contactos_cuit CHECK (cuit IS NULL OR cuit REGEXP '^[0-9]{11}$')");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE productos DROP CHECK chk_productos_precio');
        DB::statement('ALTER TABLE pedidos DROP CHECK chk_pedidos_descuento');
        DB::statement('ALTER TABLE pedidos DROP CHECK chk_pedidos_envio');
        DB::statement('ALTER TABLE detalle_pedidos DROP CHECK chk_detalle_cantidad');
        DB::statement('ALTER TABLE detalle_pedidos DROP CHECK chk_detalle_precio');
        DB::statement('ALTER TABLE contactos DROP CHECK chk_contactos_cuit');
    }
};
