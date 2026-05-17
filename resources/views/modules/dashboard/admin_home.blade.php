@extends('layouts.admin')

@section('titulo_pagina', 'Panel de inicio')

@section('content')

    {{-- Encabezado de página --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Panel de inicio</h1>
    </div>

    {{-- Tarjeta de bienvenida --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-home mr-1"></i> Bienvenido al sistema
            </h6>
        </div>
        <div class="card-body">
            <p class="mb-0">
                Hola, <strong>{{ Auth::user()->name ?? 'Administrador' }}</strong>.
                Seleccione una opción del menú lateral para comenzar.
            </p>
        </div>
    </div>

@endsection
