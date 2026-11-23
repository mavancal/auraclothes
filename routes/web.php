<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PanelProductosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MisPedidosController;
use App\Http\Controllers\PanelPedidosController;
use App\Http\Controllers\MisDireccionesController;
use App\Http\Controllers\MiCuentaController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\PanelMensajesController;
use App\Http\Controllers\PaginaController;

Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito');
Route::post('/carrito', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::patch('/carrito/{productoId}', [CarritoController::class, 'actualizar'])->whereNumber('productoId')->name('carrito.actualizar');
Route::delete('/carrito/{productoId}', [CarritoController::class, 'quitar'])->whereNumber('productoId')->name('carrito.quitar');
Route::delete('/carrito', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'create'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.confirmar');
    Route::get('/mis-pedidos', [MisPedidosController::class, 'index'])->name('mis-pedidos');
    Route::get('/mis-pedidos/{pedido}', [MisPedidosController::class, 'show'])->name('mis-pedidos.show');
    Route::post('/mis-pedidos/{pedido}/cancelar', [MisPedidosController::class, 'cancelar'])->name('mis-pedidos.cancelar');
    Route::get('/mis-direcciones', [MisDireccionesController::class, 'index'])->name('mis-direcciones');
    Route::post('/mis-direcciones', [MisDireccionesController::class, 'store'])->name('mis-direcciones.store');
    Route::patch('/mis-direcciones/{direccionId}/principal', [MisDireccionesController::class, 'marcarPrincipal'])->whereNumber('direccionId')->name('mis-direcciones.principal');
    Route::get('/mis-direcciones/{direccionId}/editar', [MisDireccionesController::class, 'edit'])->whereNumber('direccionId')->name('mis-direcciones.edit');
    Route::put('/mis-direcciones/{direccionId}', [MisDireccionesController::class, 'update'])->whereNumber('direccionId')->name('mis-direcciones.update');
    Route::get('/mi-cuenta', [MiCuentaController::class, 'show'])->name('mi-cuenta');
    Route::patch('/mi-cuenta/datos', [MiCuentaController::class, 'actualizarDatos'])->name('mi-cuenta.datos');
    Route::put('/mi-cuenta/password', [MiCuentaController::class, 'cambiarPassword'])->name('mi-cuenta.password');
});

Route::get('/nuevo', [PaginaController::class, 'nuevo'])->name('nuevo');

Route::view('/contacto','contacto')->name('contacto');
Route::post('/contacto', [ContactoController::class, 'store'])->middleware('throttle:5,1')->name('contacto.enviar');

Route::post('/newsletter', [NewsletterController::class, 'store'])->middleware('throttle:10,1')->name('newsletter.suscribir');

Route::view('/quienes-somos','quienes-somos')->name('quienes-somos');


Route::get('/cuenta', [SesionController::class, 'create'])->middleware('guest')->name('cuenta');
Route::post('/login', [SesionController::class, 'store'])->middleware(['guest','throttle:5,1'])->name('sesion.iniciar');
Route::post('/logout', [SesionController::class, 'destroy'])->middleware('auth')->name('sesion.cerrar');

Route::get('/registro', [RegistroController::class, 'create'])->name('registro');
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');

Route::middleware(['auth', 'nivel:50'])->group(function (){
    Route::get('/panel_productos_admin', [PanelProductosController::class, 'index'])->name('panel_productos_admin');
    Route::post('/panel_productos_admin/productos', [PanelProductosController::class, 'storeProducto'])->name('panel_productos_admin.productos.store');
    Route::get('/panel_productos_admin/productos/{producto}/editar', [PanelProductosController::class, 'editProducto'])->name('panel_productos_admin.productos.edit');
    Route::put('/panel_productos_admin/productos/{producto}', [PanelProductosController::class, 'updateProducto'])->name('panel_productos_admin.productos.update');
    Route::delete('/panel_productos_admin/productos/{producto}', [PanelProductosController::class, 'destroyProducto'])->name('panel_productos_admin.productos.destroy');
    Route::post('/panel_productos_admin/colecciones', [PanelProductosController::class, 'storeColeccion'])->name('panel_productos_admin.colecciones.store');
    Route::put('/panel_productos_admin/colecciones/{coleccion}', [PanelProductosController::class, 'updateColeccion'])->name('panel_productos_admin.colecciones.update');
    Route::delete('/panel_productos_admin/colecciones/{coleccion}', [PanelProductosController::class, 'destroyColeccion'])->name('panel_productos_admin.colecciones.destroy');
    Route::post('/panel_productos_admin/categorias', [PanelProductosController::class, 'storeCategoria'])->name('panel_productos_admin.categorias.store');
    Route::put('/panel_productos_admin/categorias/{categoriaProducto}', [PanelProductosController::class, 'updateCategoria'])->name('panel_productos_admin.categorias.update');
    Route::delete('/panel_productos_admin/categorias/{categoriaProducto}', [PanelProductosController::class, 'destroyCategoria'])->name('panel_productos_admin.categorias.destroy');
    Route::get('/panel_pedidos_admin', [PanelPedidosController::class, 'index'])->name('panel_pedidos_admin');
    Route::get('/panel_pedidos_admin/{pedido}', [PanelPedidosController::class, 'show'])->name('panel_pedidos_admin.show');
    Route::patch('/panel_pedidos_admin/{pedido}/estado', [PanelPedidosController::class, 'cambiarEstado'])->name('panel_pedidos_admin.estado');
    Route::get('/panel_mensajes_admin', [PanelMensajesController::class, 'index'])->name('panel_mensajes_admin');
    Route::patch('/panel_mensajes_admin/{mensaje}/leido', [PanelMensajesController::class, 'marcarLeido'])->name('panel_mensajes_admin.leido');
});
