@extends('layouts.admin')

@section('titulo_pagina', 'Gestión de Usuarios')

@section('content')

    {{-- Encabezado de página --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Usuario
        </a>
    </div>

    {{-- Tarjeta de contenido --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-users mr-1"></i> Lista de Usuarios
            </h6>
        </div>
        <div class="card-body">
            <p class="mb-0">
                Aquí se mostrará la tabla con la lista de usuarios registrados en el sistema.
            </p>
            <div class="table-responsive mt-3">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center">No hay usuarios para mostrar.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
