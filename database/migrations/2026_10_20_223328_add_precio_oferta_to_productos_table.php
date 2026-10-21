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
        Schema::table('productos', function (Blueprint $table) {
            $table->decimal('precio_oferta', 10, 2)->nullable()->after('precio');
        });
        DB::statement('ALTER TABLE productos ADD CONSTRAINT chk_productos_oferta CHECK (precio_oferta IS NULL OR precio_oferta <= precio)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE productos DROP CHECK chk_productos_oferta');

        Schema::table('productos', function (Blueprint $table) {
            $table->dropColumn('precio_oferta');
        });
    }
};
