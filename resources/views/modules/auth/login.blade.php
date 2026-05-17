@extends('layouts.login')

@section('titulo_pagina', 'Iniciar Sesión')

@section('content')

    <div class="container">

        {{-- Outer Row --}}
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">

                        {{-- Fila dentro de la tarjeta --}}
                        <div class="row">

                            {{-- Imagen decorativa izquierda (visible desde lg) --}}
                            {{-- Panel izquierdo con logo --}}
                            <div class="col-lg-6 d-none d-lg-flex align-items-center justify-content-center bg-gradient-primary">
                                <div class="text-center p-4">
                                    <img src="{{ asset('img/logo1.jpg') }}"
                                         alt="Logo Veterinaria"
                                         class="img-fluid rounded-circle shadow-lg mb-3"
                                         style="max-width: 220px; border: 5px solid rgba(255,255,255,0.5);">
                                    <h2 class="text-white font-weight-bold mt-2">Veterinaria</h2>
                                    <p class="text-white-50 small">Sistema de Gestión</p>
                                </div>
                            </div>

                            {{-- Formulario de login --}}
                            <div class="col-lg-6">
                                <div class="p-5">

                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Sistema de Veterinaria</h1>
                                    </div>

                                    {{-- Mensaje de error --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <ul class="mb-0 pl-3">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                    @endif

                                    {{-- Formulario --}}
                                    <form class="user" action="{{ route('logear') }}" method="POST">
                                        @csrf

                                        {{-- Correo --}}
                                        <div class="form-group">
                                            <input type="email"
                                                class="form-control form-control-user @error('email') is-invalid @enderror"
                                                id="email"
                                                name="email"
                                                value="{{ old('email') }}"
                                                placeholder="Correo electrónico..."
                                                required
                                                autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Contraseña --}}
                                        <div class="form-group">
                                            <input type="password"
                                                class="form-control form-control-user @error('password') is-invalid @enderror"
                                                id="password"
                                                name="password"
                                                placeholder="Contraseña"
                                                required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Recuérdame --}}
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="remember" name="remember">
                                                <label class="custom-control-label" for="remember">
                                                    Recordarme
                                                </label>
                                            </div>
                                        </div>

                                        {{-- Botón Ingresar --}}
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-sign-in-alt mr-1"></i> Iniciar Sesión
                                        </button>

                                    </form>

                                    <hr>

                                    <div class="text-center">
                                        <a class="small" href="#">¿Olvidaste tu contraseña?</a>
                                    </div>

                                </div>
                            </div>
                            {{-- End of Login Form --}}

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>

@endsection
