<?php

use Illuminate\Support\Facades\Route;

Route::view('/','inicio')->name('inicio');

<<<<<<< Updated upstream
Route::view('/productos','productos')->name('productos');
=======
Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
>>>>>>> Stashed changes

Route::view('/nuevo','nuevo')->name('nuevo');

Route::view('/contacto','contacto')->name('contacto');

Route::view('/quienes-somos','quienes-somos')->name('quienes-somos');

Route::view('/cuenta','cuenta')->name('cuenta');

Route::view('/panel_productos_admin','vistas_admin.panel_productos_admin')->name('panel_productos_admin');