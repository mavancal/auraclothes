<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localidad extends Model
{
    protected $table = 'localidades';
    protected $guarded = [];

    public function provincia()
    {
        return $this->belongsTo(Provincia::class);
    }

    public function direcciones()
    {
        return $this->hasMany(Direccion::class);
    }
}
