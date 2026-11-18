<?php

namespace Database\Seeders;

use App\Models\Contacto;
use App\Models\Localidad;
use App\Models\MetodoPago;
use App\Models\Producto;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\Models\TipoPersona;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Services\PedidoService;

class DatosDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Un contacto con su dirección
        $contacto = Contacto::create([
            'nombre' => 'Juan',
            'apellido' => 'Pérez',
            'tipo_documento_id' => TipoDocumento::where('descripcion', 'DNI')->first()->id,
            'numero_documento' => '30111222',
            'tipo_persona_id' => TipoPersona::where('descripcion', 'Física')->first()->id,
            'email_contacto' => 'juan@mail.com',
        ]);

        $direccion = $contacto->direcciones()->create([
            'calle' => 'Av. Mitre',
            'numero' => '1234',
            'es_principal' => true,
            'localidad_id' => Localidad::where('descripcion', 'Posadas')->first()->id,
        ]);

        // Su usuario, con el rol Cliente
        $usuario = User::create([
            'name' => 'juanperez',
            'email' => 'juan@mail.com',
            'password' => Hash::make('12345678'),
            'contacto_id' => $contacto->id,
        ]);

        $usuario->roles()->attach(Rol::where('nombre_rol', 'Cliente')->first()->id);

        // Un pedido de ejemplo, creado con PedidoService:
        // descuenta el stock y guarda el precio vigente, igual que una compra real
        app(PedidoService::class)->crear(
            $usuario,
            [
                ['producto_id' => Producto::where('sku', 'REM-001')->value('id'), 'cantidad' => 2],
                ['producto_id' => Producto::where('sku', 'HW-001')->value('id'), 'cantidad' => 1],
            ],
            $direccion->id,
            MetodoPago::where('metodo', 'Transferencia')->value('id'),
            costoEnvio: 1500,
        );

        // Un administrador para probar el panel de productos
        $contactoAdmin = Contacto::create([
            'nombre' => 'Admin',
            'apellido' => 'Aura',
            'tipo_documento_id' => TipoDocumento::where('descripcion', 'DNI')->first()->id,
            'numero_documento' => '20000000',
            'tipo_persona_id' => TipoPersona::where('descripcion', 'Física')->first()->id,
            'email_contacto' => 'admin@auraclothes.com',
        ]);

        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@auraclothes.com',
            'password' => 'admin1234',
            'contacto_id' => $contactoAdmin->id,
        ]);

        $admin->roles()->attach(Rol::where('nombre_rol', 'Administrador')->first()->id);
    }
}