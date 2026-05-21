@extends('layouts/main')

@section('titulo_pagina', 'Diagnóstico — ' . $mascota->nombre)

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
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">

    {{-- ── Título ───────────────────────────────────────────────────────── --}}
    <h4 class="text-gray-800 mb-3 font-weight-bold">Diagnóstico</h4>

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
            <li class="breadcrumb-item active text-gray-600" aria-current="page">Diagnóstico</li>
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
    <div class="card shadow-sm mb-4" style="border-left: 4px solid #4e73df; border-radius: 6px;">
        <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-paw text-primary mr-3" style="font-size: 1.4rem;"></i>
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
                <span class="btn btn-primary btn-sm disabled" style="cursor:default; font-size:.8rem; border-radius:4px;">
                    <i class="fas fa-calendar-alt mr-1"></i>
                    Consulta del {{ $consulta->fecha_consulta?->format('d/m/Y') ?? '—' }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── Formulario de diagnóstico ────────────────────────────────────── --}}
    <div class="card shadow">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-file-medical mr-2"></i>Diagnóstico de la Consulta
            </h6>
        </div>
        <div class="card-body px-4 py-4">
            <form id="form-diagnostico"
                  action="{{ route('mascotas.consultas.diagnostico.guardar', [$mascota->id, $consulta->id]) }}"
                  method="POST">
                @csrf

                {{-- Textarea que CKEditor reemplaza --}}
                <textarea
                    id="diagnostico"
                    name="diagnostico"
                    class="@error('diagnostico') is-invalid @enderror"
                >{{ old('diagnostico', $consulta->diagnostico) }}</textarea>

                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
{{-- CKEditor 5 Classic Build CDN --}}
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#diagnostico'), {
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
            placeholder: 'Redacta aquí el diagnóstico completo del paciente...',
        })
        .then(editor => {
            // Sincronizar con el textarea al enviar el formulario
            document.getElementById('form-diagnostico').addEventListener('submit', function () {
                document.getElementById('diagnostico').value = editor.getData();
            });
        })
        .catch(error => {
            console.error('Error al iniciar CKEditor:', error);
        });
</script>
@endpush
