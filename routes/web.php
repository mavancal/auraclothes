<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PanelProductosController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\RegistroController;

Route::view('/','inicio')->name('inicio');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos');


Route::view('/nuevo','nuevo')->name('nuevo');

Route::view('/contacto','contacto')->name('contacto');

Route::view('/quienes-somos','quienes-somos')->name('quienes-somos');


Route::view('/cuenta','cuenta')->name('cuenta');

Route::get('/registro', [RegistroController::class, 'create'])->name('registro');
Route::post('/registro', [RegistroController::class, 'store'])->name('registro.store');

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
