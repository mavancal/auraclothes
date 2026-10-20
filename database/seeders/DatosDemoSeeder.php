<?php

namespace Database\Seeders;

use App\Models\CategoriaProducto;
use App\Models\Coleccion;
use App\Models\Contacto;
use App\Models\EstadoPedido;
use App\Models\Localidad;
use App\Models\MetodoPago;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\Models\TipoPersona;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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

        // Dos productos
        $verano = Coleccion::where('nombre_coleccion', 'Verano 2026')->first();
        $remeras = CategoriaProducto::where('nombre_categoria', 'Remeras')->first();
        $accesorios = CategoriaProducto::where('nombre_categoria', 'Accesorios')->first();

        $remera = $verano->productos()->create([
            'sku' => 'REM-001',
            'nombre' => 'Remera básica',
            'descripcion' => 'Remera de algodón',
            'precio' => 8500,
            'stock' => 20,
        ]);
        $remera->categorias()->attach($remeras->id);

        $gorra = $verano->productos()->create([
            'sku' => 'ACC-001',
            'nombre' => 'Gorra negra',
            'precio' => 5000,
            'stock' => 10,
        ]);
        $gorra->categorias()->attach($accesorios->id);

        // Un pedido con dos líneas de detalle
        $pedido = $usuario->pedidos()->create([
            'estado_pedido_id' => EstadoPedido::where('descripcion', 'Pendiente')->first()->id,
            'metodo_pago_id' => MetodoPago::where('metodo', 'Transferencia')->first()->id,
            'direccion_envio_id' => $direccion->id,
            'costo_envio' => 1500,
        ]);

        $pedido->detalles()->create([
            'producto_id' => $remera->id,
            'cantidad' => 2,
            'precio_unitario' => $remera->precio,
        ]);

        $pedido->detalles()->create([
            'producto_id' => $gorra->id,
            'cantidad' => 1,
            'precio_unitario' => $gorra->precio,
        ]);
    }
}