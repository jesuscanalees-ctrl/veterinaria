@extends('layouts/main')

@section('titulo_pagina', 'Alergias — ' . $mascota->nombre)

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
    .allergies-display {
        font-size: .95rem;
        line-height: 1.75;
        color: #3a3b45;
    }
    .allergies-display ul, .allergies-display ol {
        padding-left: 1.5rem;
        margin-bottom: 1rem;
    }
    .allergies-display table {
        width: 100%;
        margin-bottom: 1rem;
        border-collapse: collapse;
    }
    .allergies-display table td, .allergies-display table th {
        border: 1px solid #e3e6f0;
        padding: 8px;
    }
    .allergies-display table th {
        background-color: #f8f9fc;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">

    {{-- ── Título ───────────────────────────────────────────────────────── --}}
    <h4 class="text-gray-800 mb-3 font-weight-bold">Alergias del Paciente</h4>

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
            <li class="breadcrumb-item active text-gray-600" aria-current="page">Alergias</li>
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
    <div class="card shadow-sm mb-4" style="border-left: 4px solid #e74a3b; border-radius: 6px;">
        <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-allergies text-danger mr-3" style="font-size: 1.4rem;"></i>
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
                <span class="btn btn-danger btn-sm disabled" style="cursor:default; font-size:.8rem; border-radius:4px;">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Antecedentes Médicos
                </span>
            </div>
        </div>
    </div>

    {{-- ── Estructura de dos columnas ──────────────────────────────────── --}}
    <div class="row">
        
        {{-- Columna Izquierda: Mostrar Alergias Actuales --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-white d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-notes-medical mr-2"></i>Alergias Registradas
                    </h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-between px-4 py-4">
                    @php
                        $alergiasLimpio = trim(strip_tags($mascota->alergias));
                    @endphp

                    @if(!empty($alergiasLimpio))
                        <div class="allergies-display p-3 bg-light rounded border border-light shadow-sm mb-0 flex-grow-1" style="min-height: 280px;">
                            {!! $mascota->alergias !!}
                        </div>
                    @else
                        <div class="d-flex flex-column align-items-center justify-content-center flex-grow-1 py-5 border border-dashed rounded" style="border-width: 2px; border-color: #dddfeb !important; min-height: 280px; background-color: #fafbfe;">
                            <i class="fas fa-allergies fa-3x text-gray-300 mb-3"></i>
                            <div class="h5 font-weight-bold text-gray-500 mb-2">Aún sin alergia</div>
                            <p class="text-xs text-muted text-center px-4 mb-0">Esta mascota no cuenta con registros de alergias médicas, alimentarias o ambientales activas.</p>
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
                        <i class="fas fa-edit mr-2"></i>Crear o Editar Alergias
                    </h6>
                </div>
                <div class="card-body px-4 py-4">
                    <form id="form-alergias"
                          action="{{ route('mascotas.consultas.alergias.guardar', [$mascota->id, $consulta->id]) }}"
                          method="POST">
                        @csrf

                        {{-- Textarea que CKEditor reemplaza --}}
                        <textarea
                            id="alergias"
                            name="alergias"
                            class="@error('alergias') is-invalid @enderror"
                        >{{ old('alergias', $mascota->alergias) }}</textarea>

                        <div class="text-right mt-3">
                            <button type="submit" class="btn btn-danger px-4">
                                <i class="fas fa-save mr-1"></i> Guardar Alergias
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
        .create(document.querySelector('#alergias'), {
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
            placeholder: 'Registra aquí alergias del paciente (ej. Alergia a la penicilina, intolerancia alimentaria, dermatitis de contacto, etc.)...',
        })
        .then(editor => {
            // Sincronizar con el textarea al enviar el formulario
            document.getElementById('form-alergias').addEventListener('submit', function () {
                document.getElementById('alergias').value = editor.getData();
            });
        })
        .catch(error => {
            console.error('Error al iniciar CKEditor:', error);
        });
</script>
@endpush
