<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Gestión Veterinaria">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo_pagina', 'Veterinaria')</title>

    {{-- FontAwesome --}}
    <link href="{{ asset('startbootstrap/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- SB Admin 2 CSS --}}
    <link href="{{ asset('startbootstrap/css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- Estilos adicionales por página --}}
    @stack('styles')

</head>

<body id="page-top">

    {{-- ===== Page Wrapper ===== --}}
    <div id="wrapper">

        {{-- Sidebar --}}
        @if(!View::hasSection('hide_sidebar'))
            @include('layouts.partials.sidebar')
        @endif

        {{-- Content Wrapper --}}
        <div id="content-wrapper" class="d-flex flex-column">

            {{-- Main Content --}}
            <div id="content">

                {{-- Topbar --}}
                @include('layouts.partials.topbar')

                {{-- Begin Page Content --}}
                <div class="container-fluid">
                    @yield('content')
                </div>
                {{-- /.container-fluid --}}

            </div>
            {{-- End of Main Content --}}

            {{-- Footer --}}
            @include('layouts.partials.footer')

        </div>
        {{-- End of Content Wrapper --}}

    </div>
    {{-- End of Page Wrapper --}}

    {{-- Scroll to Top Button --}}
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    {{-- Modal de Cerrar Sesión --}}
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="logoutModalLabel">¿Listo para salir?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Selecciona "Cerrar sesión" si estás listo para terminar tu sesión actual.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ===== Scripts ===== --}}

    {{-- jQuery --}}
    <script src="{{ asset('startbootstrap/vendor/jquery/jquery.min.js') }}"></script>

    {{-- Bootstrap Bundle (incluye Popper) --}}
    <script src="{{ asset('startbootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- jQuery Easing --}}
    <script src="{{ asset('startbootstrap/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{-- SB Admin 2 JS --}}
    <script src="{{ asset('startbootstrap/js/sb-admin-2.min.js') }}"></script>

    {{-- Scripts adicionales por página --}}
    @stack('scripts')

</body>

</html>
