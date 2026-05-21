@extends('layouts/main')

@section('titulo_pagina', 'Consulta #' . $consulta->id . ' — ' . $mascota->nombre)
{{-- Sin hide_sidebar: esta vista SÍ muestra el sidebar --}}

@push('styles')
<style>
    .stat-divider {
        border-right: 1px solid #e3e6f0;
    }
    .stat-cell {
        text-align: center;
        padding: 1rem 1.5rem;
    }
    .stat-label {
        font-size: .7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #b7b9cc;
        margin-bottom: .4rem;
    }
    .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #3a3b45;
        line-height: 1.1;
    }
    .stat-unit {
        font-size: .85rem;
        color: #858796;
        font-weight: 400;
    }
    .patient-card {
        border-left: 4px solid #4e73df;
        border-radius: 6px;
    }
    .section-icon-diag {
        color: #f6c23e;
    }
    .section-icon-trat {
        color: #1cc88a;
    }
    .datos-field-label {
        font-size: .65rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #b7b9cc;
        margin-bottom: .15rem;
    }
    .datos-field-value {
        font-size: .88rem;
        font-weight: 600;
        color: #3a3b45;
    }
    .badge-adoptado {
        background: #1cc88a;
        color: #fff;
        padding: .25rem .6rem;
        border-radius: 4px;
        font-size: .75rem;
        font-weight: 700;
    }
    .badge-no-adoptado {
        background: #858796;
        color: #fff;
        padding: .25rem .6rem;
        border-radius: 4px;
        font-size: .75rem;
        font-weight: 700;
    }
    .consulta-header-card {
        border-radius: 8px 8px 0 0;
        background: #fff;
        border-bottom: 1px solid #e3e6f0;
        padding: .85rem 1.25rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .datos-dot {
        width: 10px; height: 10px;
        border-radius: 50%;
        background: #1cc88a;
        display: inline-block;
        margin-right: 6px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid mt-2">

    {{-- ── Título ───────────────────────────────────────────────────────── --}}
    <h4 class="text-gray-800 mb-3 font-weight-bold">Detalle de Consulta</h4>

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
            <li class="breadcrumb-item active text-gray-600" aria-current="page">
                Consulta #{{ $consulta->id }}
            </li>
        </ol>
    </nav>

    {{-- ── Tarjeta horizontal del paciente ────────────────────────────── --}}
    <div class="card shadow-sm patient-card mb-4">
        <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <i class="fas fa-paw fa-lg text-primary mr-3" style="font-size:1.6rem;"></i>
                <div>
                    <div class="font-weight-bold text-gray-800" style="font-size:1.1rem;">
                        {{ $mascota->nombre }}
                    </div>
                    <div class="text-muted" style="font-size:.82rem;">
                        Folio #{{ $mascota->id }}
                        @if($mascota->especie) &nbsp;•&nbsp; {{ $mascota->especie }} @endif
                        @if($mascota->raza) / {{ $mascota->raza }} @endif
                        @if($mascota->tipo_sangre) &nbsp;•&nbsp; Tipo de sangre: {{ $mascota->tipo_sangre }} @endif
                    </div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xs font-weight-bold text-uppercase text-muted mb-1">Dueño</div>
                <div class="font-weight-bold text-gray-800" style="font-size:.95rem;">
                    <i class="fas fa-user mr-1 text-gray-400"></i>
                    {{ $mascota->dueno?->nombre_completo ?? 'Sin registro' }}
                </div>
                @if($mascota->dueno?->telefono)
                <div class="text-muted" style="font-size:.82rem;">
                    <i class="fas fa-phone mr-1"></i>{{ $mascota->dueno->telefono }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Contenido principal: 2 columnas ────────────────────────────── --}}
    <div class="row">

        {{-- Columna izquierda: Consulta --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow">

                {{-- Header de la consulta --}}
                <div class="consulta-header-card">
                    <span class="font-weight-bold text-gray-800" style="font-size:.97rem;">
                        <i class="fas fa-stethoscope text-primary mr-2"></i>Consulta #{{ $consulta->id }}
                    </span>
                    <span class="badge badge-primary px-3 py-2" style="font-size:.82rem; border-radius:20px;">
                        {{ $consulta->fecha_consulta?->format('d/m/Y H:i') ?? '—' }}
                    </span>
                </div>

                {{-- Stats: Veterinario | Peso | Talla --}}
                <div class="d-flex border-bottom" style="background:#fff;">
                    <div class="stat-cell stat-divider flex-fill">
                        <div class="stat-label">Veterinario</div>
                        <div class="stat-value" style="font-size:1rem;">
                            @if($consulta->veterinario)
                                <i class="fas fa-user-md text-primary mr-1" style="font-size:.95rem;"></i>
                                {{ $consulta->veterinario->nombre_completo }}
                            @else
                                <i class="fas fa-user-md text-gray-300 mr-1"></i>
                                <span class="text-muted" style="font-size:.9rem;">—</span>
                            @endif
                        </div>
                    </div>
                    <div class="stat-cell stat-divider flex-fill">
                        <div class="stat-label">Peso</div>
                        <div class="stat-value">
                            {{ $consulta->peso ?? '—' }}
                            <span class="stat-unit">kg</span>
                        </div>
                    </div>
                    <div class="stat-cell flex-fill">
                        <div class="stat-label">Talla</div>
                        <div class="stat-value">
                            {{ $consulta->talla ?? '—' }}
                            <span class="stat-unit">cm</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Columna derecha: Datos del Paciente + Antecedentes --}}
        <div class="col-lg-4 mb-4">

            {{-- Datos del Paciente --}}
            <div class="card shadow mb-3">
                <div class="card-body py-3 px-4">
                    <h6 class="font-weight-bold mb-3" style="font-size:.92rem; color:#3a3b45;">
                        <span class="datos-dot"></span>Datos del Paciente
                    </h6>

                    @if($mascota->fecha_nacimiento)
                    <div class="mb-3">
                        <div class="datos-field-label">Fecha de Nacimiento</div>
                        <div class="datos-field-value">
                            {{ \Carbon\Carbon::parse($mascota->fecha_nacimiento)->format('d/m/Y') }}
                        </div>
                    </div>
                    @endif

                    @if($mascota->tipo_sangre)
                    <div class="mb-3">
                        <div class="datos-field-label">Tipo de Sangre</div>
                        <div class="datos-field-value">{{ $mascota->tipo_sangre }}</div>
                    </div>
                    @endif

                    @if($mascota->comportamiento)
                    <div class="mb-3">
                        <div class="datos-field-label">Comportamiento</div>
                        <div class="datos-field-value">{{ $mascota->comportamiento }}</div>
                    </div>
                    @endif

                    <div class="mb-1">
                        <div class="datos-field-label">Adoptado</div>
                        <div class="mt-1">
                            @if($mascota->es_adoptado)
                                <span class="badge-adoptado">SI</span>
                            @else
                                <span class="badge-no-adoptado">NO</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Antecedentes eliminados de esta vista --}}

        </div>
    </div>

</div>
@endsection
