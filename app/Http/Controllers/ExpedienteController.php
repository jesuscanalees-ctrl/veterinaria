<?php

namespace App\Http\Controllers;

use App\Models\Mascota;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (empty($query)) {
            return response()->json([]);
        }

        $mascotas = Mascota::with('dueno')
            ->where(function ($q) use ($query) {
                $q->where('nombre', 'like', "%{$query}%")
                  ->orWhere('id', $query);
            })
            ->orWhereHas('dueno', function ($q) use ($query) {
                $q->where('nombre_completo', 'like', "%{$query}%");
            })
            ->with('dueno')
            ->take(10)
            ->get()
            ->map(function ($mascota) {
                return [
                    'id'          => $mascota->id,
                    'nombre'      => $mascota->nombre,
                    'especie'     => $mascota->especie,
                    'dueno_nombre' => $mascota->dueno ? $mascota->dueno->nombre_completo : 'Sin dueño',
                ];
            });

        return response()->json($mascotas);
    }

    public function consultasMascota(Mascota $mascota)
    {
        $mascota->load(['dueno', 'consultas.veterinario']);

        return view('modules.dashboard.consultas_mascota', compact('mascota'));
    }
}
