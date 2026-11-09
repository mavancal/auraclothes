<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Localidad;
use App\Models\Provincia;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\Models\TipoPersona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegistroController extends Controller
{
    public function create()
    {
        return view('registro', [
            'provincias' => Provincia::orderBy('descripcion')->get(),
            'localidades' => Localidad::orderBy('descripcion')->get(),
            'tiposPersona' => TipoPersona::orderBy('descripcion')->get(),
            'tiposDocumento' => TipoDocumento::orderBy('descripcion')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users,name'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'nombre' => ['required', 'string', 'max:50'],
            'nombre2' => ['nullable', 'string', 'max:50'],
            'apellido' => ['required', 'string', 'max:80'],
            'fecha_nacimiento' => ['required', 'date'],
            'tipo_persona_id' => ['required', 'exists:tipos_persona,id'],
            'cuit' => ['nullable', 'string'],
            'tipo_documento_id' => ['required', 'exists:tipos_documento,id'],
            'numero_documento' => [
                'required', 'string', 'max:20',
                Rule::unique('contactos', 'numero_documento')
                    ->where('tipo_documento_id', $request->input('tipo_documento_id')),
            ],
            'telefono' => ['required', 'string', 'max:20'],
            'email_contacto' => ['required', 'email', 'max:120'],
            'calle' => ['required', 'string', 'max:120'],
            'numero' => ['required', 'string', 'max:10'],
            'piso' => ['nullable', 'string', 'max:10'],
            'departamento' => ['nullable', 'string', 'max:10'],
            'cod_postal' => ['nullable', 'string', 'max:10'],
            'provincia_id' => ['required', 'exists:provincias,id'],
            'localidad_id' => ['required', 'exists:localidades,id'],
            'referencia' => ['nullable', 'string', 'max:255'],
        ]);

        // Limpieza del CUIT: se guardan solo los 11 dígitos.
        $cuit = isset($validated['cuit']) ? preg_replace('/\D/', '', $validated['cuit']) : null;
        if ($cuit === '') {
            $cuit = null;
        }
        if ($cuit !== null && strlen($cuit) !== 11) {
            return back()->withErrors(['cuit' => 'El CUIT debe tener 11 dígitos.'])->withInput();
        }

        // La localidad debe pertenecer a la provincia elegida.
        $localidad = Localidad::findOrFail($validated['localidad_id']);
        if ((int) $localidad->provincia_id !== (int) $validated['provincia_id']) {
            return back()->withErrors(['localidad_id' => 'La localidad no pertenece a la provincia seleccionada.'])->withInput();
        }

        DB::transaction(function () use ($validated, $cuit) {
            $contacto = Contacto::create([
                'nombre' => $validated['nombre'],
                'nombre2' => $validated['nombre2'] ?? null,
                'apellido' => $validated['apellido'],
                'tipo_documento_id' => $validated['tipo_documento_id'],
                'numero_documento' => $validated['numero_documento'],
                'cuit' => $cuit,
                'fecha_nacimiento' => $validated['fecha_nacimiento'],
                'telefono' => $validated['telefono'],
                'email_contacto' => $validated['email_contacto'],
                'tipo_persona_id' => $validated['tipo_persona_id'],
            ]);

            $contacto->direcciones()->create([
                'calle' => $validated['calle'],
                'numero' => $validated['numero'],
                'piso' => $validated['piso'] ?? null,
                'departamento' => $validated['departamento'] ?? null,
                'cod_postal' => $validated['cod_postal'] ?? null,
                'es_principal' => true,
                'referencia' => $validated['referencia'] ?? null,
                'localidad_id' => $validated['localidad_id'],
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'contacto_id' => $contacto->id,
                'activo' => true,
            ]);

            $rolCliente = Rol::where('nombre_rol', 'Cliente')->first();
            if ($rolCliente) {
                $user->roles()->attach($rolCliente->id);
            }
        });

        return redirect()->route('registro')->with('success', 'Cuenta creada correctamente.');
    }
}