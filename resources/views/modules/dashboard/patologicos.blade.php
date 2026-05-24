@extends('layouts/main')

@section('titulo_pagina', 'Antecedentes Patológicos — ' . $mascota->nombre)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link href="{{ asset('css/modules/patologicos.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container-fluid mt-2" style="max-width: 1400px;">

    {{-- ── Título ───────────────────────────────────────────────────────── --}}
    <h4 class="text-gray-800 mb-3 font-weight-bold">Antecedentes Patológicos</h4>

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
            <li class="breadcrumb-item active text-gray-600" aria-current="page">Patológicos</li>
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

    {{-- ── Tarjeta de Mascota ───────────────────────────────────────────── --}}
    <div class="card shadow-sm mb-4" style="border-left: 4px solid #e74a3b; border-radius: 6px;">
        <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-heartbeat text-danger mr-3" style="font-size: 1.4rem;"></i>
                <div>
                    <div class="font-weight-bold text-gray-800" style="font-size: 1.05rem;">
                        Historial Médico: {{ $mascota->nombre }}
                    </div>
                    <div class="text-muted" style="font-size: .82rem;">
                        Folio #{{ $mascota->id }}
                        @if($mascota->especie) &nbsp;•&nbsp; {{ $mascota->especie }} @endif
                        @if($mascota->raza) / {{ $mascota->raza }} @endif
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

    {{-- ── Estructura de Dos Columnas ──────────────────────────────────── --}}
    <div class="row">
        
        {{-- COLUMNA IZQUIERDA: Historial Cronológico por Categorías --}}
        <div class="col-xl-7 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-notes-medical mr-2"></i>Evolución de Antecedentes Patológicos
                    </h6>
                    <span class="badge badge-light-danger text-danger font-weight-bold px-2 py-1">
                        {{ count($historial) }} Registros
                    </span>
                </div>
                <div class="card-body px-4 py-4 d-flex flex-column">

                    @if(count($historial) > 0)
                        <ul class="pathology-timeline mb-0">
                            @foreach($historial as $item)
                                @php
                                    // Determinar clase de badge e icono según categoría
                                    $badgeClass = 'badge-otra';
                                    $iconClass = 'fa-file-medical';
                                    
                                    switch($item->categoria) {
                                        case 'Enfermedad Crónica / Sistémica':
                                            $badgeClass = 'badge-cronica';
                                            $iconClass = 'fa-clock';
                                            break;
                                        case 'Cirugía o Intervención Quirúrgica':
                                            $badgeClass = 'badge-quirurgica';
                                            $iconClass = 'fa-syringe';
                                            break;
                                        case 'Enfermedad Infecciosa Previa':
                                            $badgeClass = 'badge-infecciosa';
                                            $iconClass = 'fa-virus';
                                            break;
                                        case 'Trastorno Congénito / Hereditario':
                                            $badgeClass = 'badge-congenita';
                                            $iconClass = 'fa-dna';
                                            break;
                                        case 'Traumatismo o Lesión Física':
                                            $badgeClass = 'badge-lesion';
                                            $iconClass = 'fa-band-aid';
                                            break;
                                    }
                                @endphp
                                <li class="timeline-item">
                                    <div class="timeline-badge" style="border-color: #e74a3b; color: #e74a3b;">
                                        <i class="fas {{ $iconClass }}"></i>
                                    </div>
                                    
                                    <div class="timeline-card p-3">
                                        <div class="d-flex justify-content-between align-items-start mb-2 border-bottom pb-2">
                                            <div>
                                                <span class="badge text-xs px-2 py-1 font-weight-bold {{ $badgeClass }}" style="border-radius: 4px;">
                                                    <i class="fas {{ $iconClass }} mr-1"></i>{{ $item->categoria }}
                                                </span>
                                                <div class="text-xs text-muted mt-1">
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

                                        {{-- Descripción / Diagnóstico --}}
                                        <div class="timeline-desc text-gray-800 text-xs mb-3" style="line-height: 1.6;">
                                            {!! $item->descripcion !!}
                                        </div>

                                        {{-- Medicamentos Relacionados --}}
                                        @if(!empty($item->medicamentos))
                                            <div class="meds-box mb-3">
                                                <div class="text-xs font-weight-bold text-slate-700 mb-1">
                                                    <i class="fas fa-pills text-secondary mr-1"></i>Medicamentos Relacionados:
                                                </div>
                                                @php
                                                    $meds = explode(',', $item->medicamentos);
                                                @endphp
                                                @foreach($meds as $med)
                                                    @if(!empty(trim($med)))
                                                        <span class="med-pill">
                                                            <i class="fas fa-capsules mr-1" style="font-size:0.65rem;"></i>{{ trim($med) }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Relaciones Clínicas con Otras Áreas --}}
                                        <div class="relations-box d-flex align-items-center justify-content-between text-xs">
                                            <span class="font-weight-bold text-success">
                                                <i class="fas fa-link mr-1"></i>Relación Clínica:
                                            </span>
                                            <div>
                                                <a href="{{ route('mascotas.consultas.detalle', [$mascota->id, $item->consulta_id]) }}" 
                                                   class="btn btn-link text-primary p-0 mr-3 text-xs" style="text-decoration:none;">
                                                    <i class="fas fa-stethoscope mr-1"></i>Ver Consulta #{{ $item->consulta_id }}
                                                </a>
                                                <a href="{{ route('mascotas.consultas.tratamiento', [$mascota->id, $item->consulta_id]) }}" 
                                                   class="btn btn-link text-primary p-0 text-xs" style="text-decoration:none;">
                                                    <i class="fas fa-pills mr-1"></i>Ver Tratamiento Relacionado
                                                </a>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1 py-5 border border-dashed rounded" style="border-width: 2px; border-color: #dddfeb !important; min-height: 380px; background-color: #fafbfe;">
                            <i class="fas fa-heartbeat fa-4x text-gray-300 mb-3"></i>
                            <div class="h5 font-weight-bold text-gray-500 mb-2">Sin Antecedentes Clínicos</div>
                            <p class="text-xs text-muted text-center px-4 mb-0">Esta mascota no posee diagnósticos patológicos, cirugías u hospitalizaciones previas en su ficha.</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: Formulario de Creación --}}
        <div class="col-xl-5 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit mr-2"></i>Registrar Diagnóstico Patológico
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form id="form-patologicos"
                          action="{{ route('mascotas.consultas.patologicos.guardar', [$mascota->id, $consulta->id]) }}"
                          method="POST">
                        @csrf

                        {{-- Categoría select --}}
                        <div class="mb-3">
                            <label class="text-xs font-weight-bold text-gray-700 uppercase" for="categoria">Categoría Clínica</label>
                            <select class="form-control form-control-solid custom-select @error('categoria') is-invalid @enderror"
                                    name="categoria" id="categoria" style="border-radius: 6px; font-size: 0.9rem;" required>
                                <option value="">Seleccione categoría...</option>
                                <option value="Enfermedad Crónica / Sistémica" {{ old('categoria') == 'Enfermedad Crónica / Sistémica' ? 'selected' : '' }}>Enfermedad Crónica / Sistémica</option>
                                <option value="Cirugía o Intervención Quirúrgica" {{ old('categoria') == 'Cirugía o Intervención Quirúrgica' ? 'selected' : '' }}>Cirugía o Intervención Quirúrgica</option>
                                <option value="Enfermedad Infecciosa Previa" {{ old('categoria') == 'Enfermedad Infecciosa Previa' ? 'selected' : '' }}>Enfermedad Infecciosa Previa</option>
                                <option value="Traumatismo o Lesión Física" {{ old('categoria') == 'Traumatismo o Lesión Física' ? 'selected' : '' }}>Traumatismo o Lesión Física</option>
                                <option value="Trastorno Congénito / Hereditario" {{ old('categoria') == 'Trastorno Congénito / Hereditario' ? 'selected' : '' }}>Trastorno Congénito / Hereditario</option>
                                <option value="Otra Categoría" {{ old('categoria') == 'Otra Categoría' ? 'selected' : '' }}>Otra Categoría / Padecimiento</option>
                            </select>
                        </div>

                        {{-- Medicamentos relacionados --}}
                        <div class="mb-3">
                            <label class="text-xs font-weight-bold text-gray-700 uppercase" for="medicamentos">Medicamentos Relacionados</label>
                            <input type="text"
                                   id="medicamentos"
                                   name="medicamentos"
                                   class="form-control @error('medicamentos') is-invalid @enderror"
                                   placeholder="ej. Insulina, Enalapril, Meloxicam (separe con comas)"
                                   value="{{ old('medicamentos') }}"
                                   style="border-radius: 6px; font-size: 0.9rem;">
                            <small class="text-muted text-xs"><i class="fas fa-info-circle mr-1"></i>Suministre medicamentos de base recetados de por vida o temporales para esta patología.</small>
                        </div>

                        {{-- Textarea para CKEditor --}}
                        <div class="mb-4">
                            <label class="text-xs font-weight-bold text-gray-700 uppercase d-block mb-2" for="descripcion">Descripción y Diagnóstico Clínico</label>
                            <textarea
                                id="descripcion"
                                name="descripcion"
                                class="@error('descripcion') is-invalid @enderror"
                            >{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" class="btn btn-danger px-5 py-2 font-weight-bold shadow-sm" style="border-radius: 6px; font-size: 0.95rem;">
                                <i class="fas fa-save mr-2"></i> Guardar Antecedente
                            </button>
                        </div>
                    </form>
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
    ClassicEditor
        .create(document.querySelector('#descripcion'), {
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
            placeholder: 'Escribe aquí la descripción del diagnóstico patológico, notas evolutivas, hallazgos anatomopatológicos u observaciones críticas...',
        })
        .then(editor => {
            // Sincronizar con el textarea al enviar el formulario
            document.getElementById('form-patologicos').addEventListener('submit', function () {
                document.getElementById('descripcion').value = editor.getData();
            });
        })
        .catch(error => {
            console.error('Error al iniciar CKEditor:', error);
        });
</script>
@endpush
