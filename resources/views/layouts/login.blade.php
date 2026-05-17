<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema de Gestión Veterinaria">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo_pagina', 'Iniciar Sesión') — Veterinaria</title>

    {{-- FontAwesome --}}
    <link href="{{ asset('startbootstrap/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    {{-- SB Admin 2 CSS --}}
    <link href="{{ asset('startbootstrap/css/sb-admin-2.min.css') }}" rel="stylesheet">

    {{-- Estilos adicionales por página --}}
    @stack('styles')

</head>

<body class="bg-gradient-primary">

    {{-- ===== Contenido de la página de autenticación ===== --}}
    @yield('content')

    {{-- ===== Scripts ===== --}}

    {{-- jQuery --}}
    <script src="{{ asset('startbootstrap/vendor/jquery/jquery.min.js') }}"></script>

    {{-- Bootstrap Bundle --}}
    <script src="{{ asset('startbootstrap/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    {{-- jQuery Easing --}}
    <script src="{{ asset('startbootstrap/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    {{-- SB Admin 2 JS --}}
    <script src="{{ asset('startbootstrap/js/sb-admin-2.min.js') }}"></script>

    {{-- Scripts adicionales por página --}}
    @stack('scripts')

</body>

</html>
