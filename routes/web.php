<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;

Route::view('/','inicio')->name('inicio');

Route::view('/productos','productos')->name('productos');

Route::view('/nuevo','nuevo')->name('nuevo');

Route::view('/ofertas','ofertas')->name('ofertas');

Route::view('/contacto','contacto')->name('contacto');

Route::view('/quienes-somos','quienes-somos')->name('quienes-somos');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');