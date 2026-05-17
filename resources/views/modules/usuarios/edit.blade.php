@extends('layouts.admin')

@section('titulo_pagina', 'Editar Usuario')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Usuario: {{ $usuario->name }}</h1>
        <a href="{{ route('usuarios.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la Lista
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulario de Edición</h6>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                {{-- Campos Base del Usuario --}}
                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="name">Nombre de Usuario <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $usuario->name) }}" required>
                    </div>
                    <div class="col-sm-6">
                        <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6 mb-3 mb-sm-0">
                        <label for="password">Contraseña (Dejar en blanco para mantener la actual)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="col-sm-6">
                        <label for="rol">Rol del Sistema <span class="text-danger">*</span></label>
                        <select class="form-control" id="rol" name="rol" required onchange="toggleVeterinarioFields()">
                            <option value="">Seleccione un rol...</option>
                            <option value="administrador" {{ old('rol', $usuario->rol) == 'administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="veterinario" {{ old('rol', $usuario->rol) == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                        </select>
                    </div>
                </div>

                {{-- Campos Específicos para Veterinario --}}
                <div id="veterinario_fields" style="display: {{ old('rol', $usuario->rol) == 'veterinario' ? 'block' : 'none' }}; border-top: 1px solid #e3e6f0; padding-top: 20px; margin-top: 20px;">
                    <h5 class="text-primary mb-3">Datos del Veterinario</h5>
                    
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="especialidad">Especialidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="especialidad" name="especialidad" value="{{ old('especialidad', $usuario->veterinario->especialidad ?? '') }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="cedula_profesional">Cédula Profesional <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="cedula_profesional" name="cedula_profesional" value="{{ old('cedula_profesional', $usuario->veterinario->cedula_profesional ?? '') }}">
                        </div>
                    </div>
                </div>

                <hr>
                <button type="submit" class="btn btn-primary btn-user btn-block">
                    Actualizar Usuario
                </button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/admin/usuarios/edit.js') }}"></script>

@endsection
