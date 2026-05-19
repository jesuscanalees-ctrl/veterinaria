<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return response()->json([]);
        }

        $mascotas = \App\Models\Mascota::search($query)
            ->query(function ($builder) use ($query) {
                $builder->join('duenos', 'mascotas.dueno_id', '=', 'duenos.id')
                        ->orWhere('duenos.nombre_completo', 'like', "%{$query}%")
                        ->select('mascotas.*')
                        ->with('dueno');
            })
            ->take(10)
            ->get();

        return response()->json($mascotas);
    }
}
