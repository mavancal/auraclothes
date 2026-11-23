<?php

/*
 * Configuración propia de la tienda AURA CLOTHES.
 * Para cambiar un monto, se cambia acá (o en el .env) y listo.
 */
return [

    'envio' => [
        // Costo fijo del envío, en pesos
        'costo' => (float) env('ENVIO_COSTO', 5000),

        // Desde este subtotal (en pesos) el envío es gratis
        'gratis_desde' => (float) env('ENVIO_GRATIS_DESDE', 100000),
    ],

];