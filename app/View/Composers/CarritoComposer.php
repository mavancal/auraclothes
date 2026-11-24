<?php

namespace App\View\Composers;

use App\Services\CarritoService;
use Illuminate\View\View;

class CarritoComposer
{
    public function __construct(private CarritoService $carrito)
    {
    }

    public function compose(View $view): void
    {
        $view->with('carritoCantidadTotal', $this->carrito->cantidadTotal());
    }
}
