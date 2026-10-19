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
        Schema::create('localidades', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',100);
            $table->foreignId('provincia_id')->constrained('provincias');
            $table->timestamps();
        });
    }
    /*
    foreignId('provincia_id') crea la columna provincia_id, de tipo BIGINT sin signo. 
    Tiene que ser del mismo tipo que el id al que apunta, y por eso Laravel lo hace así.
    constrained('provincias') agrega el FOREIGN KEY ... REFERENCES provincias(id).
    */

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('localidades');
    }
};
