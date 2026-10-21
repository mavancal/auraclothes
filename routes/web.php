<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductoController;

Route::view('/','inicio')->name('inicio');

Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');


Route::view('/nuevo','nuevo')->name('nuevo');

Route::view('/ofertas','ofertas')->name('ofertas');

Route::view('/contacto','contacto')->name('contacto');

Route::view('/quienes-somos','quienes-somos')->name('quienes-somos');
