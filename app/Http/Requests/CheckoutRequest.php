<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya exige haber iniciado sesión (middleware auth)
    }

    public function rules(): array
    {
        return [
            // Que la dirección sea DEL USUARIO lo controla PedidoService
            'direccion_id'   => ['required', 'integer'],
            'metodo_pago_id' => ['required', 'integer', 'exists:metodos_pago,id'],
        ];
    }

    public function attributes(): array
    {
        return [
            'direccion_id'   => 'dirección de envío',
            'metodo_pago_id' => 'método de pago',
        ];
    }
}