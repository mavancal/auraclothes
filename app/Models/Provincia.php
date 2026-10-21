<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = ['descripcion'];

    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }
}
