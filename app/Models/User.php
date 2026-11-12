<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function contacto() { 
        return $this->belongsTo(Contacto::class); 
    }
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_user')->withPivot('fecha_asig');
    }
    public function pedidos() { 
        return $this->hasMany(Pedido::class); 
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contacto_id',
        'activo',
        'ultimo_acceso'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'ultimo_acceso' => 'datetime',
            'activo' => 'boolean'
        ];
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
    /**
     * El nivel mas alto entre los roles del usuario (0 si no tiene roles).
     */
    public function nivelPermiso(): int
    {
        return (int) $this->roles->max('nivel_permiso');
    }

    /**
     * ¿Tiene un rol con este nivel o mas?
     */
    public function tieneNivel(int $minimo): bool
    {
        return $this->nivelPermiso() >= $minimo;
    }
}
