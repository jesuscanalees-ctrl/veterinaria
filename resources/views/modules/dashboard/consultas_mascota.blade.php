@extends('layouts/main')

@section('titulo_pagina', 'Consultas — ' . $mascota->nombre)
@section('hide_sidebar', true)

@section('content')
<div class="container-fluid mt-4">

    {{-- Encabezado / info de la mascota --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <a href="{{ route('expedientes.index') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left mr-1"></i> Volver a Expedientes
            </a>
            <h3 class="text-gray-800 mb-0 mt-1">
                <i class="fas fa-paw text-primary mr-2"></i>{{ $mascota->nombre }}
                <small class="text-muted font-weight-normal" style="font-size:1rem;">
                    — Folio #{{ $mascota->id }}
                </small>
            </h3>
        </div>
        <button class="btn btn-primary shadow-sm mt-2 mt-sm-0">
            <i class="fas fa-plus mr-1"></i> Nueva Consulta
        </button>
    </div>

    {{-- Tarjeta de datos de la mascota --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Dueño</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $mascota->dueno ? $mascota->dueno->nombre_completo : 'Sin registro' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Especie / Raza</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $mascota->especie ?? '—' }} / {{ $mascota->raza ?? '—' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dog fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Fecha de nacimiento</div>
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $mascota->fecha_nacimiento ?? '—' }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-birthday-cake fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total de consultas</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $mascota->consultas->count() }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-stethoscope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabla de consultas --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clipboard-list mr-1"></i> Historial de Consultas
            </h6>
        </div>
        <div class="card-body">
            @if($mascota->consultas->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-3x text-gray-300 mb-3"></i>
                    <p class="text-muted mb-0">Esta mascota aún no tiene consultas registradas.</p>
                    <button class="btn btn-primary mt-3">
                        <i class="fas fa-plus mr-1"></i> Registrar primera consulta
                    </button>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                        <thead class="bg-primary text-white">
                            <tr>
                                <th>#</th>
                                <th>Fecha</th>
                                <th>Veterinario</th>
                                <th>Peso (kg)</th>
                                <th>Talla (cm)</th>
                                <th>Diagnóstico</th>
                                <th>Tratamiento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($mascota->consultas as $consulta)
                                <tr>
                                    <td class="font-weight-bold text-primary">{{ $consulta->id }}</td>
                                    <td>
                                        <i class="fas fa-calendar-alt text-gray-400 mr-1"></i>
                                        {{ $consulta->fecha_consulta ? $consulta->fecha_consulta->format('d/m/Y H:i') : '—' }}
                                    </td>
                                    <td>
                                        @if($consulta->veterinario)
                                            <i class="fas fa-user-md text-success mr-1"></i>
                                            {{ $consulta->veterinario->nombre_completo }}
                                        @else
                                            <span class="text-muted">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>{{ $consulta->peso ?? '—' }}</td>
                                    <td>{{ $consulta->talla ?? '—' }}</td>
                                    <td>
                                        <span title="{{ $consulta->diagnostico }}">
                                            {{ Str::limit($consulta->diagnostico, 60) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span title="{{ $consulta->tratamiento }}">
                                            {{ Str::limit($consulta->tratamiento, 60) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('mascotas.consultas.detalle', [$mascota->id, $consulta->id]) }}" class="btn btn-sm btn-outline-info" title="Ver detalle">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
