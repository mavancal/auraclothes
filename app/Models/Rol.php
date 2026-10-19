<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $guarded = [];
    public function users() {
        return $this->belongsToMany(User::class, 'rol_user')->withPivot('fecha_asig');
    }
}
