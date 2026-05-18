@extends('layouts/main')

@section('titulo_pagina', 'Expedientes')
@section('hide_sidebar', true)

@section('content')
    <div class="container-fluid mt-4">
        <h3 class="text-gray-800 mb-4">Gestión de Expedientes</h3>
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-search fa-3x text-gray-300 mb-4"></i>
                        <h5 class="text-gray-600 font-weight-bold mb-4">Buscar Expediente de Paciente</h5>
                        
                        {{-- Buscador --}}
                        <div class="form-group row justify-content-center mb-4">
                            <div class="col-md-10">
                                <div class="input-group input-group-lg shadow-sm">
                                    <input type="text" class="form-control border-left-primary" placeholder="Buscar por nombre de mascota, dueño o folio..." aria-label="Buscar expediente">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search"></i> Buscar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Botones de acción --}}
                        <div class="mt-4">
                            <button class="btn btn-info mx-2 mb-2 px-4 shadow-sm">
                                <i class="fas fa-stethoscope mr-1"></i> Ver Consultas
                            </button>
                            <button class="btn btn-success mx-2 mb-2 px-4 shadow-sm">
                                <i class="fas fa-plus-circle mr-1"></i> Crear Nuevo Paciente / Mascota
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
