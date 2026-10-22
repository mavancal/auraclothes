<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;

Route::view('/','inicio')->name('inicio');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos');

Route::view('/nuevo','nuevo')->name('nuevo');

Route::view('/contacto','contacto')->name('contacto');

Route::view('/quienes-somos','quienes-somos')->name('quienes-somos');


Route::view('/cuenta','cuenta')->name('cuenta');

Route::view('/panel_productos_admin','vistas_admin.panel_productos_admin')->name('panel_productos_admin');
