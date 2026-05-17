<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Veterinario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = User::paginate(5);
        return view('modules.usuarios.index', compact('usuarios'));
    }

    public function create()
    {
        return view('modules.usuarios.create');
    }

    public function store(StoreUserRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'rol' => $request->rol,
            ]);

            if ($request->rol === 'veterinario') {
                Veterinario::create([
                    'usuario_id' => $user->id,
                    'nombre_completo' => $request->name,
                    'especialidad' => $request->especialidad,
                    'cedula_profesional' => $request->cedula_profesional,
                    'foto_firma' => '',
                ]);
            }
        });

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $usuario)
    {
        $usuario->load('veterinario');
        return view('modules.usuarios.edit', compact('usuario'));
    }

    public function update(UpdateUserRequest $request, User $usuario)
    {
        DB::transaction(function () use ($request, $usuario) {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'rol' => $request->rol,
            ];

            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $usuario->update($data);

            if ($request->rol === 'veterinario') {
                Veterinario::updateOrCreate(
                    ['usuario_id' => $usuario->id],
                    [
                        'nombre_completo' => $request->name,
                        'especialidad' => $request->especialidad,
                        'cedula_profesional' => $request->cedula_profesional,
                        'foto_firma' => '',
                    ]
                );
            } else {
                // If it's an administrator, make sure to delete any existing veterinario record
                if ($usuario->veterinario) {
                    $usuario->veterinario()->delete();
                }
            }
        });

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    public function show(User $usuario)
    {
        $usuario->load('veterinario');
        return view('modules.usuarios.show', compact('usuario'));
    }

    public function destroy(User $usuario)
    {
        try {
            $usuario->delete();
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            // Error 23000 es violación de integridad (llave foránea)
            if ($e->getCode() == 23000) {
                return redirect()->route('usuarios.index')->with('error', 'No se puede eliminar este usuario porque tiene registros asociados en el sistema.');
            }
            throw $e;
        }
    }
}
