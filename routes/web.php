<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PanelProductosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MisPedidosController;

Route::view('/','inicio')->name('inicio');

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
});

Route::view('/nuevo','nuevo')->name('nuevo');

Route::view('/contacto','contacto')->name('contacto');

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
});
