<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
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

    public function detalleConsulta(Mascota $mascota, Consulta $consulta)
    {
        // Verificar que la consulta pertenece a la mascota
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $mascota->load('dueno');
        $consulta->load('veterinario');

        // Antecedentes: todas las consultas anteriores a la actual
        $antecedentes = Consulta::where('mascota_id', $mascota->id)
            ->where('id', '!=', $consulta->id)
            ->with('veterinario')
            ->orderByDesc('fecha_consulta')
            ->get();

        return view('modules.dashboard.detalle_consulta', compact('mascota', 'consulta', 'antecedentes'));
    }

    public function diagnostico(Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $mascota->load('dueno');
        $consulta->load('veterinario');

        return view('modules.dashboard.diagnostico', compact('mascota', 'consulta'));
    }

    public function guardarDiagnostico(Request $request, Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $request->validate([
            'diagnostico' => 'nullable|string|max:65535',
        ], [
            'diagnostico.max' => 'El diagnóstico es demasiado largo.',
        ]);

        // Verificamos si ya existía un diagnóstico no vacío (removiendo tags HTML que pudiera dejar CKEditor)
        $diagnosticoLimpio = trim(strip_tags($consulta->diagnostico));
        $yaExiste = !empty($diagnosticoLimpio);

        $consulta->update(['diagnostico' => $request->diagnostico]);

        $mensaje = $yaExiste ? 'se actualizo con exito' : 'se guardo la nueva informacion';

        return redirect()
            ->route('mascotas.consultas.diagnostico', [$mascota->id, $consulta->id])
            ->with('success', $mensaje);
    }
}
