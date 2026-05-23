@extends('layouts/main')

@section('titulo_pagina', 'Tratamiento — ' . $mascota->nombre)

@push('styles')
<style>
    /* Ajustar altura mínima del editor CKEditor */
    .ck-editor__editable {
        min-height: 320px;
        font-size: .95rem;
        line-height: 1.7;
    }
    .ck-toolbar {
        border-radius: 4px 4px 0 0 !important;
    }
    .ck-editor__editable_inline {
        border-radius: 0 0 4px 4px !important;
    }
    .treatment-display {
        font-size: .95rem;
        line-height: 1.75;
        color: #3a3b45;
    }
    .treatment-display ul, .treatment-display ol {
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .treatment-display table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    .treatment-display table td, .treatment-display table th {
        border: 1px solid #e3e6f0;
        padding: 8px;
    }
    .treatment-display table th {
        background-color: #f8f9fc;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">

    {{-- ── Título ───────────────────────────────────────────────────────── --}}
    <h4 class="text-gray-800 mb-3 font-weight-bold">Tratamiento</h4>

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
            <li class="breadcrumb-item active text-gray-600" aria-current="page">Tratamiento</li>
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

    {{-- ── Tarjeta de mascota ───────────────────────────────────────────── --}}
    <div class="card shadow-sm mb-4" style="border-left: 4px solid #1cc88a; border-radius: 6px;">
        <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-pills text-success mr-3" style="font-size: 1.4rem;"></i>
                <div>
                    <div class="font-weight-bold text-gray-800" style="font-size: 1rem;">
                        {{ $mascota->nombre }}
                    </div>
                    <div class="text-muted" style="font-size: .8rem;">
                        Folio #{{ $mascota->id }}
                        @if($mascota->especie) &nbsp;•&nbsp; {{ $mascota->especie }} @endif
                        @if($mascota->raza) / {{ $mascota->raza }} @endif
                    </div>
                </div>
            </div>
            <div>
                <span class="btn btn-success btn-sm disabled" style="cursor:default; font-size:.8rem; border-radius:4px;">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Consulta del {{ $consulta->fecha_consulta?->format('d/m/Y') ?? '—' }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── Estructura de dos columnas ──────────────────────────────────── --}}
    <div class="row">
        
        {{-- Columna Izquierda: Mostrar Tratamiento Actual --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-prescription-bottle-alt mr-2"></i>Tratamiento Registrado
                    </h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-between px-4 py-4">
                    @php
                        $tratamientoLimpio = trim(strip_tags($consulta->tratamiento));
                    @endphp

                    @if(!empty($tratamientoLimpio))
                        <div class="treatment-display p-3 bg-light rounded border border-light shadow-sm mb-0 flex-grow-1" style="min-height: 280px;">
                            {!! $consulta->tratamiento !!}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1 py-5 border border-dashed rounded" style="border-width: 2px; border-color: #dddfeb !important; min-height: 280px; background-color: #fafbfe;">
                            <i class="fas fa-prescription-bottle-alt fa-3x text-gray-300 mb-3 animate__animated animate__pulse animate__infinite"></i>
                            <div class="h5 font-weight-bold text-gray-500 mb-2">Aún sin tratamiento</div>
                            <p class="text-xs text-muted text-center px-4 mb-0">Esta consulta no tiene ninguna prescripción o receta médica registrada actualmente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Formulario de Creación / Edición --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit mr-2"></i>Crear o Editar Tratamiento
                    </h6>
                </div>
                <div class="card-body px-4 py-4">
                    <form id="form-tratamiento"
                          action="{{ route('mascotas.consultas.tratamiento.guardar', [$mascota->id, $consulta->id]) }}"
                          method="POST">
                        @csrf

                        {{-- Textarea que CKEditor reemplaza --}}
                        <textarea
                            id="tratamiento"
                            name="tratamiento"
                            class="@error('tratamiento') is-invalid @enderror"
                        >{{ old('tratamiento', $consulta->tratamiento) }}</textarea>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-success px-4">
                                <i class="fas fa-save mr-1"></i> Guardar Tratamiento
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
        .create(document.querySelector('#tratamiento'), {
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
            placeholder: 'Redacta aquí la receta médica, dosis y plan de tratamiento detallado para la mascota...',
        })
        .then(editor => {
            // Sincronizar con el textarea al enviar el formulario
            document.getElementById('form-tratamiento').addEventListener('submit', function () {
                document.getElementById('tratamiento').value = editor.getData();
            });
        })
        .catch(error => {
            console.error('Error al iniciar CKEditor:', error);
        });
</script>
@endpush
