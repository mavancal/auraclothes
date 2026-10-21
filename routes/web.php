<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;

Route::view('/','inicio')->name('inicio');

<<<<<<< HEAD
<<<<<<< Updated upstream
Route::view('/productos','productos')->name('productos');
=======
Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
>>>>>>> Stashed changes
=======
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
>>>>>>> 2242a65f095b9bbf69fcb8f8bfcd60462ab57958

Route::view('/nuevo','nuevo')->name('nuevo');

Route::view('/contacto','contacto')->name('contacto');

Route::view('/quienes-somos','quienes-somos')->name('quienes-somos');
<<<<<<< HEAD

Route::view('/cuenta','cuenta')->name('cuenta');

Route::view('/panel_productos_admin','vistas_admin.panel_productos_admin')->name('panel_productos_admin');
=======
>>>>>>> 2242a65f095b9bbf69fcb8f8bfcd60462ab57958
