<?php

namespace Database\Seeders;

use App\Models\CategoriaProducto;
use App\Models\CategoriaUs;
use App\Models\CategoriaUsuario;
use App\Models\Coleccion;
use App\Models\EstadoPedido;
use App\Models\Localidad;
use App\Models\MetodoPago;
use App\Models\Provincia;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\Models\TipoPersona;
use Illuminate\Database\Seeder;

class CatalogosSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['DNI', 'Pasaporte', 'LC', 'LE', 'CI'] as $nombre) {
            TipoDocumento::create(['descripcion' => $nombre]);
        }

        foreach (['Física', 'Jurídica'] as $nombre) {
            TipoPersona::create(['descripcion' => $nombre]);
        }

        foreach (['Pendiente', 'Pagado', 'En preparación', 'Enviado', 'Entregado', 'Cancelado'] as $nombre) {
            EstadoPedido::create(['descripcion' => $nombre]);
        }

        foreach (['Efectivo', 'Transferencia', 'Tarjeta de débito', 'Tarjeta de crédito', 'Mercado Pago'] as $nombre) {
            MetodoPago::create(['metodo' => $nombre]);
        }

        Rol::create(['nombre_rol' => 'Administrador', 'nivel_permiso' => 100, 'descripcion' => 'Acceso total al sistema']);
        Rol::create(['nombre_rol' => 'Empleado', 'nivel_permiso' => 50, 'descripcion' => 'Gestión de productos y pedidos']);
        Rol::create(['nombre_rol' => 'Cliente', 'nivel_permiso' => 10, 'descripcion' => 'Usuario comprador']);

        $provincias = [
            'Buenos Aires', 'Ciudad Autónoma de Buenos Aires', 'Catamarca', 'Chaco',
            'Chubut', 'Córdoba', 'Corrientes', 'Entre Ríos', 'Formosa', 'Jujuy',
            'La Pampa', 'La Rioja', 'Mendoza', 'Misiones', 'Neuquén', 'Río Negro',
            'Salta', 'San Juan', 'San Luis', 'Santa Cruz', 'Santa Fe',
            'Santiago del Estero', 'Tierra del Fuego', 'Tucumán',
        ];
        foreach ($provincias as $nombre) {
            Provincia::create(['descripcion' => $nombre]);
        }

        $misiones = Provincia::where('descripcion', 'Misiones')->first();
        foreach (['Posadas', 'Oberá', 'Eldorado', 'Garupá'] as $nombre) {
            $misiones->localidades()->create(['descripcion' => $nombre]);
        }

        Coleccion::create(['nombre_coleccion' => 'Verano 2026']);
        Coleccion::create(['nombre_coleccion' => 'Invierno 2026']);

        foreach (['Remeras', 'Pantalones', 'Camperas', 'Accesorios'] as $nombre) {
            CategoriaProducto::create(['nombre_categoria' => $nombre]);
        }

        CategoriaUsuario::create(['nombre_categoria' => 'Minorista', 'descripcion' => 'Cliente final']);
        CategoriaUsuario::create(['nombre_categoria' => 'Mayorista', 'descripcion' => 'Compra por volumen']);
    }
}