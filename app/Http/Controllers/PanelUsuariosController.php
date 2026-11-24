<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use App\Models\Rol;
use App\Models\TipoDocumento;
use App\Models\TipoPersona;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class PanelUsuariosController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->string('q')->trim()->value();
        $rolId = $request->integer('rol_id') ?: null;

        $usuarios = User::with(['roles', 'contacto'])
            ->when($q, function ($query, $term) {
                $query->where(function ($sub) use ($term) {
                    $sub->where('name', 'like', "%{$term}%")
                        ->orWhere('email', 'like', "%{$term}%")
                        ->orWhereHas('contacto', function ($c) use ($term) {
                            $c->where('nombre', 'like', "%{$term}%")
                              ->orWhere('apellido', 'like', "%{$term}%");
                        });
                });
            })
            ->when($rolId, function ($query, $id) {
                $query->whereHas('roles', fn ($r) => $r->where('roles.id', $id));
            })
            ->orderBy('id', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('vistas_admin.panel_usuarios_admin', [
            'usuarios' => $usuarios,
            'roles' => Rol::orderBy('nivel_permiso', 'desc')->get(),
            'filtros' => [
                'q' => $q,
                'rol_id' => $rolId,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:50', 'unique:users,name'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::defaults()],
            'rol_id' => ['required', 'exists:roles,id'],
            'nombre' => ['nullable', 'string', 'max:60'],
            'apellido' => ['nullable', 'string', 'max:60'],
        ], [], [
            'name' => 'nombre de usuario',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
            'rol_id' => 'rol asignado',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $contactoId = null;
            if (!empty($validated['nombre']) || !empty($validated['apellido'])) {
                $contacto = Contacto::create([
                    'nombre' => $validated['nombre'] ?? $validated['name'],
                    'apellido' => $validated['apellido'] ?? '',
                    'tipo_persona_id' => TipoPersona::query()->value('id') ?? 1,
                    'tipo_documento_id' => TipoDocumento::query()->value('id') ?? 1,
                    'numero_documento' => '00' . rand(100000, 999999),
                    'email_contacto' => $validated['email'],
                ]);
                $contactoId = $contacto->id;
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'activo' => true,
                'contacto_id' => $contactoId,
            ]);

            $user->roles()->attach($validated['rol_id'], [
                'fecha_asig' => now(),
            ]);
        });

        return redirect()->route('panel_usuarios_admin')->with('success', 'Usuario creado correctamente.');
    }

    public function cambiarRol(User $user, Request $request)
    {
        $validated = $request->validate([
            'rol_id' => ['required', 'exists:roles,id'],
        ], [], [
            'rol_id' => 'rol',
        ]);

        if ($user->id === $request->user()->id && $user->tieneNivel(100)) {
            $nuevoRol = Rol::find($validated['rol_id']);
            if ($nuevoRol && $nuevoRol->nivel_permiso < 100) {
                return redirect()->route('panel_usuarios_admin')->with('error', 'No podés quitarte el rol de Administrador a vos mismo.');
            }
        }

        $user->roles()->sync([$validated['rol_id'] => ['fecha_asig' => now()]]);

        return redirect()->route('panel_usuarios_admin')->with('success', 'Rol de usuario actualizado.');
    }

    public function toggleActivo(User $user, Request $request)
    {
        if ($user->id === $request->user()->id) {
            return redirect()->route('panel_usuarios_admin')->with('error', 'No podés desactivar tu propia cuenta.');
        }

        $user->update(['activo' => ! $user->activo]);

        $estado = $user->activo ? 'activado' : 'desactivado';

        return redirect()->route('panel_usuarios_admin')->with('success', "Usuario {$estado} correctamente.");
    }
}
