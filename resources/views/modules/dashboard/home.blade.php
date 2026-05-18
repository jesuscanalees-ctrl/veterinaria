@extends('layouts/main')

@section('titulo_pagina', 'Home')
@section('hide_sidebar', true)

@section('content')
    <div class="container-fluid mt-4">
        <h3 class="text-gray-800 mb-4">Dashboard</h3>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-paw mr-1"></i> Bienvenido al Sistema Veterinario
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0">Has iniciado sesión correctamente como <strong>{{ Auth::user()->name ?? 'veterinario' }}</strong>. Usa el menú superior para navegar entre las secciones del sistema.</p>
            </div>
        </div>
    </div>
@endsection
