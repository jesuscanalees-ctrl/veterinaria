@extends('layouts.admin')

@section('titulo_pagina', 'Detalle de Usuario')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Eliminar Usuario</h1>
        <a href="{{ route('usuarios.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la Lista
        </a>
    </div>

    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <div class="card shadow mb-4 border-bottom-danger">
                <div class="card-header py-3 bg-danger">
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-danger text-center">
                        <strong>¡Advertencia!</strong> Está a punto de eliminar permanentemente al siguiente usuario. Esta acción no se puede deshacer.
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light" width="40%">ID</th>
                            <td>{{ $usuario->id }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Nombre</th>
                            <td>{{ $usuario->name }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Correo Electrónico</th>
                            <td>{{ $usuario->email }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Rol</th>
                            <td><span class="badge {{ $usuario->rol === 'administrador' ? 'badge-primary' : 'badge-success' }}">{{ ucfirst($usuario->rol) }}</span></td>
                        </tr>
                        
                        @if($usuario->rol === 'veterinario' && $usuario->veterinario)
                            <tr>
                                <th class="bg-light">Especialidad</th>
                                <td>{{ $usuario->veterinario->especialidad }}</td>
                            </tr>
                            <tr>
                                <th class="bg-light">Cédula Profesional</th>
                                <td>{{ $usuario->veterinario->cedula_profesional }}</td>
                            </tr>
                        @endif
                    </table>

                    <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="mt-4 text-center">
                        @csrf
                        @method('DELETE')
                        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary mr-2">Cancelar</a>
                        <button type="submit" class="btn btn-danger">Sí, Eliminar Usuario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
