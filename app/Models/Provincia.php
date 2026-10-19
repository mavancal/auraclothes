<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $guarded = [];

    public function localidades()
    {
        return $this->hasMany(Localidad::class);
    }
}
