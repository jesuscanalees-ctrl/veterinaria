@extends('layouts.admin')

@section('titulo_pagina', 'Gestión de Usuarios')

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-4" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-users mr-1"></i> Lista de Usuarios
            </h6>
            <a href="{{ route('usuarios.create') }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus fa-sm text-white-50"></i> Nuevo Usuario
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <td>{{ $usuario->id }}</td>
                                <td>{{ $usuario->name }}</td>
                                <td>{{ $usuario->email }}</td>
                                <td>
                                    <span class="badge {{ $usuario->rol === 'administrador' ? 'badge-primary' : 'badge-success' }}">
                                        {{ ucfirst($usuario->rol) }}
                                    </span>
                                </td>
                                <td>
                                    {{-- El estado activo/inactivo no está en la BD, se asume activo por defecto o se puede quitar después --}}
                                    <span class="badge badge-info">Activo</span>
                                </td>
                                <td>
                                    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a href="{{ route('usuarios.show', $usuario->id) }}" class="btn btn-sm btn-danger" title="Eliminar"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted font-italic py-4">
                                    No hay usuarios registrados en el sistema.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-end mt-3">
                {{ $usuarios->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection
