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

    public function patologicos(Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $mascota->load(['dueno', 'historialPatologico.consulta.veterinario']);
        $consulta->load('veterinario');

        // Obtener historial cronológico de patologías
        $historial = $mascota->historialPatologico;

        return view('modules.dashboard.patologicos', compact('mascota', 'consulta', 'historial'));
    }

    public function guardarPatologicos(Request $request, Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $request->validate([
            'categoria' => 'required|string|max:100',
            'descripcion' => 'required|string|max:65535',
            'medicamentos' => 'nullable|string|max:255',
        ], [
            'categoria.required' => 'La categoría del antecedente es obligatoria.',
            'descripcion.required' => 'La descripción clínica es obligatoria.',
            'descripcion.max' => 'La descripción es demasiado larga.',
            'medicamentos.max' => 'La lista de medicamentos relacionados es demasiado larga.',
        ]);

        // Registrar en el historial relacional
        \App\Models\HistorialPatologico::create([
            'mascota_id' => $mascota->id,
            'consulta_id' => $consulta->id,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'medicamentos' => $request->medicamentos,
        ]);

        // Compilar resumen HTML ordenado cronológicamente para retrocompatibilidad
        $todos = $mascota->historialPatologico()->get();
        $resumenHtml = '';
        foreach ($todos as $item) {
            $fecha = $item->created_at ? $item->created_at->format('d/m/Y') : '';
            $medsStr = !empty($item->medicamentos) ? " <span class='text-muted' style='font-size: 0.85em;'>(Medicamentos: <em>{$item->medicamentos}</em>)</span>" : "";
            $resumenHtml .= "<div style='margin-bottom: 12px; padding-bottom: 8px; border-bottom: 1px solid #f0f0f0;'>"
                         . "<span class='badge' style='background-color:#eaecf4; color:#4e73df; font-size:0.75em; padding:3px 6px; margin-right:6px;'>{$item->categoria}</span>"
                         . "<span class='text-xs text-muted' style='float:right;'>{$fecha}</span>"
                         . "<div style='margin-top:6px; font-size:0.95em;'>{$item->descripcion}</div>"
                         . $medsStr
                         . "</div>";
        }

        $mascota->update(['patologicos' => $resumenHtml]);

        return redirect()
            ->route('mascotas.consultas.patologicos', [$mascota->id, $consulta->id])
            ->with('success', 'se guardo el antecedente patologico con exito');
    }

    public function alimentacion(Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $mascota->load(['dueno', 'historialAlimentacion.consulta.veterinario']);
        $consulta->load('veterinario');

        // Obtener historial completo de dietas
        $historial = $mascota->historialAlimentacion;

        // Obtener la dieta más reciente para pre-cargar el formulario
        $dietaActual = $historial->first();

        return view('modules.dashboard.alimentacion', compact('mascota', 'consulta', 'historial', 'dietaActual'));
    }

    public function guardarAlimentacion(Request $request, Mascota $mascota, Consulta $consulta)
    {
        abort_if($consulta->mascota_id !== $mascota->id, 404);

        $request->validate([
            'tipo_comida' => 'required|string|max:100',
            'frecuencia' => 'nullable|array',
            'detalles' => 'nullable|string|max:65535',
            'condicion' => 'required|string|max:100',
            'recomendacion' => 'nullable|string|max:65535',
        ], [
            'tipo_comida.required' => 'El tipo de comida es obligatorio.',
            'condicion.required' => 'La condición de salud/dieta es obligatoria.',
            'detalles.max' => 'Los detalles son demasiado largos.',
            'recomendacion.max' => 'La recomendación es demasiado larga.',
        ]);

        $frecuencia = $request->input('frecuencia', []);

        // Guardar registro en el historial relacional
        \App\Models\HistorialAlimentacion::create([
            'mascota_id' => $mascota->id,
            'consulta_id' => $consulta->id,
            'tipo_comida' => $request->tipo_comida,
            'frecuencia' => $frecuencia,
            'detalles' => $request->detalles,
            'condicion' => $request->condicion,
            'recomendacion' => $request->recomendacion,
        ]);

        // Guardar un resumen en el campo plano de la mascota para retrocompatibilidad
        $frecuenciaTexto = !empty($frecuencia) ? implode(', ', $frecuencia) : 'No especificada';
        $resumenHtml = "<strong>Tipo de Comida:</strong> {$request->tipo_comida}<br>"
                     . "<strong>Horarios:</strong> {$frecuenciaTexto}<br>"
                     . "<strong>Condición:</strong> {$request->condicion}<br>";

        if (!empty($request->recomendacion)) {
            $resumenHtml .= "<strong>Recomendación Clínica:</strong> {$request->recomendacion}<br>";
        }
        if (!empty($request->detalles)) {
            $resumenHtml .= "<strong>Detalles Adicionales:</strong> {$request->detalles}";
        }

        $mascota->update(['alimentacion' => $resumenHtml]);

        return redirect()
            ->route('mascotas.consultas.alimentacion', [$mascota->id, $consulta->id])
            ->with('success', 'se guardo la nueva informacion de la dieta con exito');
    }
}
