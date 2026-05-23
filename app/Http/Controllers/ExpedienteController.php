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

    public function tratamiento(Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $mascota->load('dueno');
        $consulta->load('veterinario');

        return view('modules.dashboard.tratamiento', compact('mascota', 'consulta'));
    }

    public function guardarTratamiento(Request $request, Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $request->validate([
            'tratamiento' => 'nullable|string|max:65535',
        ], [
            'tratamiento.max' => 'El tratamiento es demasiado largo.',
        ]);

        // Verificamos si ya existía un tratamiento no vacío (removiendo tags HTML que pudiera dejar CKEditor)
        $tratamientoLimpio = trim(strip_tags($consulta->tratamiento));
        $yaExiste = !empty($tratamientoLimpio);

        $consulta->update(['tratamiento' => $request->tratamiento]);

        $mensaje = $yaExiste ? 'se actualizo con exito' : 'se inserto con exito';

        return redirect()
            ->route('mascotas.consultas.tratamiento', [$mascota->id, $consulta->id])
            ->with('success', $mensaje);
    }

    public function alergias(Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $mascota->load('dueno');
        $consulta->load('veterinario');

        return view('modules.dashboard.alergias', compact('mascota', 'consulta'));
    }

    public function guardarAlergias(Request $request, Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $request->validate([
            'alergias' => 'nullable|string|max:65535',
        ], [
            'alergias.max' => 'El texto de alergias es demasiado largo.',
        ]);

        // Verificamos si ya existían alergias no vacías (removiendo tags HTML que pudiera dejar CKEditor)
        $alergiasLimpio = trim(strip_tags($mascota->alergias));
        $yaExiste = !empty($alergiasLimpio);

        $mascota->update(['alergias' => $request->alergias]);

        $mensaje = $yaExiste ? 'se actualizo con exito' : 'se inserto con exito';

        return redirect()
            ->route('mascotas.consultas.alergias', [$mascota->id, $consulta->id])
            ->with('success', $mensaje);
    }

    public function lesiones(Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $mascota->load('dueno');
        $consulta->load('veterinario');

        return view('modules.dashboard.lesiones', compact('mascota', 'consulta'));
    }

    public function guardarLesiones(Request $request, Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $request->validate([
            'lesiones' => 'nullable|string|max:65535',
        ], [
            'lesiones.max' => 'El texto de lesiones es demasiado largo.',
        ]);

        // Verificamos si ya existían lesiones no vacías (removiendo tags HTML que pudiera dejar CKEditor)
        $lesionesLimpio = trim(strip_tags($mascota->lesiones));
        $yaExiste = !empty($lesionesLimpio);

        $mascota->update(['lesiones' => $request->lesiones]);

        $mensaje = $yaExiste ? 'se actualizo con exito' : 'se inserto con exito';

        return redirect()
            ->route('mascotas.consultas.lesiones', [$mascota->id, $consulta->id])
            ->with('success', $mensaje);
    }
}
