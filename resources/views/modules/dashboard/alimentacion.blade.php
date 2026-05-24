@extends('layouts/main')

@section('titulo_pagina', 'Alimentación y Nutrición — ' . $mascota->nombre)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('css/modules/alimentacion.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid mt-2" style="max-width: 1400px;">

    {{-- ── Título ───────────────────────────────────────────────────────── --}}
    <h4 class="text-gray-800 mb-3 font-weight-bold">Nutrición y Prescripción Alimentaria</h4>

    {{-- ── Breadcrumb ──────────────────────────────────────────────────── --}}
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-white shadow-sm py-2 px-3 mb-0" style="border-radius:6px; font-size:.875rem;">
            <li class="breadcrumb-item">
                <a href="{{ route('expedientes.index') }}" class="text-primary">Expedientes</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('mascotas.consultas', $mascota->id) }}" class="text-primary">
                    {{ $mascota->nombre }}
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('mascotas.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="text-primary">
                    Consulta #{{ $consulta->id }}
                </a>
            </li>
            <li class="breadcrumb-item active text-gray-600" aria-current="page">Alimentación</li>
        </ol>
    </nav>

    {{-- ── Alertas ──────────────────────────────────────────────────────── --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>{{ $errors->first() }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- ── Ficha del Paciente ────────────────────────────────────────────── --}}
    <div class="card shadow-sm mb-4" style="border-left: 4px solid #1cc88a; border-radius: 6px;">
        <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-apple-alt text-success mr-3" style="font-size: 1.4rem;"></i>
                <div>
                    <div class="font-weight-bold text-gray-800" style="font-size: 1.05rem;">
                        Nutrición: {{ $mascota->nombre }}
                    </div>
                    <div class="text-muted" style="font-size: .82rem;">
                        Folio #{{ $mascota->id }}
                        @if($mascota->especie) &nbsp;•&nbsp; {{ $mascota->especie }} @endif
                        @if($mascota->raza) / {{ $mascota->raza }} @endif
                        @if($consulta->peso) &nbsp;•&nbsp; <span class="badge badge-secondary" style="font-size: 0.75rem;">Peso Actual: {{ $consulta->peso }} kg</span> @endif
                    </div>
                </div>
            </div>
            <div>
                <a href="{{ route('mascotas.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="btn btn-outline-secondary btn-sm" style="font-size:.78rem; border-radius:4px;">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Volver a Consulta
                </a>
            </div>
        </div>
    </div>

    {{-- ── Estructura de dos columnas ──────────────────────────────────── --}}
    <div class="row">
        
        {{-- COLUMNA IZQUIERDA: Formulario de Dieta y Recomendador --}}
        <div class="col-xl-7 col-lg-6 mb-4">
            
            <form id="form-alimentacion"
                  action="{{ route('mascotas.consultas.alimentacion.guardar', [$mascota->id, $consulta->id]) }}"
                  method="POST">
                @csrf
                
                {{-- Formulario Principal --}}
                <div class="card shadow mb-4">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 font-weight-bold text-success">
                            <i class="fas fa-sliders-h mr-2"></i>Nueva Configuración de Dieta
                        </h6>
                    </div>
                    <div class="card-body p-4">
                        
                        <div class="row">
                            {{-- Tipo de Comida --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-xs font-weight-bold text-gray-700 uppercase" for="tipo_comida">Tipo de Comida</label>
                                <select class="form-control form-control-solid custom-select @error('tipo_comida') is-invalid @enderror"
                                        name="tipo_comida" id="tipo_comida" style="border-radius: 6px; font-size: 0.9rem;">
                                    <option value="">Seleccione tipo...</option>
                                    <option value="Croquetas (Seco)" {{ old('tipo_comida', $dietaActual->tipo_comida ?? '') == 'Croquetas (Seco)' ? 'selected' : '' }}>Croquetas (Alimento Seco)</option>
                                    <option value="Comida Húmeda (Lata)" {{ old('tipo_comida', $dietaActual->tipo_comida ?? '') == 'Comida Húmeda (Lata)' ? 'selected' : '' }}>Comida Húmeda (Sachets/Lata)</option>
                                    <option value="BARF / Alimento Natural Crudo" {{ old('tipo_comida', $dietaActual->tipo_comida ?? '') == 'BARF / Alimento Natural Crudo' ? 'selected' : '' }}>Dieta BARF / Crudo Natural</option>
                                    <option value="Comida Casera Cocida" {{ old('tipo_comida', $dietaActual->tipo_comida ?? '') == 'Comida Casera Cocida' ? 'selected' : '' }}>Alimentación Casera Cocida</option>
                                    <option value="Alimentación Mixta" {{ old('tipo_comida', $dietaActual->tipo_comida ?? '') == 'Alimentación Mixta' ? 'selected' : '' }}>Mixta (Seco + Húmedo)</option>
                                    <option value="Dieta de Prescripción Veterinaria" {{ old('tipo_comida', $dietaActual->tipo_comida ?? '') == 'Dieta de Prescripción Veterinaria' ? 'selected' : '' }}>Dieta Clínica de Prescripción</option>
                                </select>
                            </div>

                            {{-- Condición Clínica --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-xs font-weight-bold text-gray-700 uppercase" for="condicion">Condición Especial / Salud</label>
                                <select class="form-control form-control-solid custom-select @error('condicion') is-invalid @enderror"
                                        name="condicion" id="condicion" style="border-radius: 6px; font-size: 0.9rem;">
                                    <option value="Ninguna / Adulto Sano" {{ old('condicion', $dietaActual->condicion ?? '') == 'Ninguna / Adulto Sano' ? 'selected' : '' }}>Ninguna / Adulto Sano</option>
                                    <option value="Obesidad / Sobrepeso" {{ old('condicion', $dietaActual->condicion ?? '') == 'Obesidad / Sobrepeso' ? 'selected' : '' }}>Obesidad o Sobrepeso</option>
                                    <option value="Insuficiencia Renal" {{ old('condicion', $dietaActual->condicion ?? '') == 'Insuficiencia Renal' ? 'selected' : '' }}>Insuficiencia Renal Crónica</option>
                                    <option value="Diabetes Mellitus" {{ old('condicion', $dietaActual->condicion ?? '') == 'Diabetes Mellitus' ? 'selected' : '' }}>Diabetes Mellitus</option>
                                    <option value="Alergias Alimentarias" {{ old('condicion', $dietaActual->condicion ?? '') == 'Alergias Alimentarias' ? 'selected' : '' }}>Alergias o Intolerancias Alimentarias</option>
                                    <option value="Cachorro / Crecimiento" {{ old('condicion', $dietaActual->condicion ?? '') == 'Cachorro / Crecimiento' ? 'selected' : '' }}>Cachorro o Crecimiento</option>
                                    <option value="Senior / Geriatra" {{ old('condicion', $dietaActual->condicion ?? '') == 'Senior / Geriatra' ? 'selected' : '' }}>Senior o Geriatra</option>
                                </select>
                            </div>
                        </div>

                        {{-- Checkboxes Frecuencia Horarios --}}
                        <div class="mb-4">
                            <label class="text-xs font-weight-bold text-gray-700 uppercase d-block mb-2">Frecuencia / Horarios de Comida</label>
                            @php
                                $frecuenciaActual = old('frecuencia', $dietaActual->frecuencia ?? []);
                            @endphp
                            <div class="schedule-check-group">
                                <label>
                                    <input type="checkbox" name="frecuencia[]" value="Mañana" {{ in_array('Mañana', $frecuenciaActual) ? 'checked' : '' }}>
                                    <span class="schedule-btn">
                                        <i class="fas fa-sun text-warning"></i>Mañana
                                    </span>
                                </label>
                                <label>
                                    <input type="checkbox" name="frecuencia[]" value="Mediodía" {{ in_array('Mediodía', $frecuenciaActual) ? 'checked' : '' }}>
                                    <span class="schedule-btn">
                                        <i class="fas fa-cloud-sun text-info"></i>Mediodía
                                    </span>
                                </label>
                                <label>
                                    <input type="checkbox" name="frecuencia[]" value="Tarde" {{ in_array('Tarde', $frecuenciaActual) ? 'checked' : '' }}>
                                    <span class="schedule-btn">
                                        <i class="fas fa-cloud-moon text-secondary"></i>Tarde
                                    </span>
                                </label>
                                <label>
                                    <input type="checkbox" name="frecuencia[]" value="Noche" {{ in_array('Noche', $frecuenciaActual) ? 'checked' : '' }}>
                                    <span class="schedule-btn">
                                        <i class="fas fa-moon text-primary"></i>Noche
                                    </span>
                                </label>
                            </div>
                        </div>



                        {{-- CKEditor Detalle --}}
                        <div class="mb-0">
                            <label class="text-xs font-weight-bold text-gray-700 uppercase d-block mb-2" for="detalles">Especificaciones Clínicas y Raciones</label>
                            <textarea
                                id="detalles"
                                name="detalles"
                                class="@error('detalles') is-invalid @enderror"
                            >{{ old('detalles', $dietaActual->detalles ?? '') }}</textarea>
                        </div>

                    </div>
                </div>



                {{-- Submit Button --}}
                <div class="text-right">
                    <button type="submit" class="btn btn-success px-5 py-2 font-weight-bold shadow-sm" style="border-radius: 6px; font-size: 0.95rem;">
                        <i class="fas fa-save mr-2"></i> Guardar Configuración Alimenticia
                    </button>
                </div>
            </form>
        </div>

        {{-- COLUMNA DERECHA: Historial de Evolución Nutricional --}}
        <div class="col-xl-5 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-history mr-2"></i>Historial de Evolución Nutricional
                    </h6>
                </div>
                <div class="card-body px-4 py-4 d-flex flex-column">
                    
                    @if(count($historial) > 0)
                        <ul class="diet-timeline mb-0">
                            @foreach($historial as $index => $item)
                                <li class="timeline-item">
                                    <div class="timeline-badge">
                                        <i class="fas fa-apple-alt"></i>
                                    </div>
                                    
                                    <div class="timeline-card p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                            <div>
                                                <span class="badge badge-success text-xs px-2 py-1 mb-1 font-weight-bold" style="border-radius: 4px;">
                                                    {{ $item->tipo_comida }}
                                                </span>
                                                <div class="text-xs text-muted">
                                                    <i class="fas fa-user-md mr-1"></i> Registrado por: 
                                                    <strong>{{ $item->consulta->veterinario ? $item->consulta->veterinario->nombre_completo : 'Veterinario' }}</strong>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs text-dark font-weight-bold">
                                                    {{ $item->created_at->format('d M, Y') }}
                                                </div>
                                                <div class="text-muted" style="font-size: 0.7rem;">
                                                    {{ $item->created_at->format('h:i A') }}
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Frecuencia --}}
                                        <div class="mb-2">
                                            <div class="text-xs font-weight-bold text-gray-700">Horarios / Frecuencia:</div>
                                            <div class="d-flex gap-1 flex-wrap mt-1">
                                                @if(is_array($item->frecuencia))
                                                    @foreach($item->frecuencia as $freq)
                                                        <span class="badge badge-light border text-dark text-xs px-2 py-0.5" style="border-radius: 3px;">
                                                            {{ $freq }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    <span class="text-xs text-muted">No especificada</span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Condición --}}
                                        <div class="mb-2">
                                            <div class="text-xs font-weight-bold text-gray-700">Condición Médica:</div>
                                            <span class="badge text-xs px-2 py-1 font-weight-bold mt-1 {{ $item->condicion == 'Ninguna / Adulto Sano' ? 'badge-light border text-dark' : ($item->condicion == 'Obesidad / Sobrepeso' ? 'badge-warning' : 'badge-danger') }}" style="border-radius: 4px;">
                                                <i class="fas fa-heartbeat mr-1"></i>{{ $item->condicion }}
                                            </span>
                                        </div>

                                        {{-- Sugerencia Nutricional --}}
                                        @if(!empty($item->recomendacion))
                                            <div class="mb-2 p-2 bg-light rounded border border-light-success text-xs" style="border-left: 3px solid #1cc88a; line-height: 1.5; color: #404249;">
                                                <div class="font-weight-bold text-success mb-1"><i class="fas fa-stethoscope mr-1"></i>Prescripción de Dieta:</div>
                                                {{ $item->recomendacion }}
                                            </div>
                                        @endif

                                        {{-- Detalles Raciones --}}
                                        @if(!empty(trim(strip_tags($item->detalles))))
                                            <div class="timeline-details text-xs mt-2 border-top pt-2 text-gray-800" style="line-height: 1.6;">
                                                <div class="font-weight-bold text-gray-700 mb-1"><i class="fas fa-sticky-note mr-1"></i>Raciones y Anotaciones:</div>
                                                {!! $item->detalles !!}
                                            </div>
                                        @endif

                                        <div class="mt-2 text-right">
                                            <span class="text-muted" style="font-size: 0.72rem;">
                                                Consulta Folio #{{ $item->consulta_id }}
                                            </span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1 py-5 border border-dashed rounded" style="border-width: 2px; border-color: #dddfeb !important; min-height: 380px; background-color: #fafbfe;">
                            <i class="fas fa-utensils fa-4x text-gray-300 mb-3"></i>
                            <div class="h5 font-weight-bold text-gray-500 mb-2">Sin Historial Clínico</div>
                            <p class="text-xs text-muted text-center px-4 mb-0">Esta mascota no posee registros dietéticos anteriores. La evolución y evolución de peso se mostrará a medida que agregues nuevas dietas.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
{{-- CKEditor 5 Classic Build CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>


    // ClassicEditor Configuration
    ClassicEditor
        .create(document.querySelector('#detalles'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'bulletedList', 'numberedList', '|',
                    'outdent', 'indent', '|',
                    'blockQuote', 'insertTable', '|',
                    'link', 'horizontalLine', '|',
                    'undo', 'redo'
                ]
            },
            heading: {
                options: [
                    { model: 'paragraph',  title: 'Párrafo',   class: 'ck-heading_paragraph' },
                    { model: 'heading1',   view: 'h1', title: 'Título 1', class: 'ck-heading_heading1' },
                    { model: 'heading2',   view: 'h2', title: 'Título 2', class: 'ck-heading_heading2' },
                    { model: 'heading3',   view: 'h3', title: 'Título 3', class: 'ck-heading_heading3' },
                ]
            },
            language: 'es',
            placeholder: 'Prescribe raciones en gramos, marcas particulares recetadas, número de comidas por día o indicaciones personalizadas para el dueño...',
        })
        .then(editor => {
            // Sincronizar con el textarea al enviar el formulario
            document.getElementById('form-alimentacion').addEventListener('submit', function () {
                document.getElementById('detalles').value = editor.getData();
            });
        })
        .catch(error => {
            console.error('Error al iniciar CKEditor:', error);
        });
</script>
@endpush
