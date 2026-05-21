{{-- ===== Sidebar ===== --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar - Brand / Logo --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Veterinaria</div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- ════════════════════════════════
         SECCIÓN: CONSULTA
    ════════════════════════════════ --}}
    <div class="sidebar-heading">
        Consulta
    </div>

    {{-- Diagnóstico --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-notes-medical"></i>
            <span>Diagnóstico</span>
        </a>
    </li>

    {{-- Tratamiento --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-pills"></i>
            <span>Tratamiento</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- ════════════════════════════════
         SECCIÓN: ANTECEDENTES
    ════════════════════════════════ --}}
    <div class="sidebar-heading">
        Antecedentes
    </div>

    {{-- Alergias --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-allergies"></i>
            <span>Alergias</span>
        </a>
    </li>

    {{-- Lesiones --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-band-aid"></i>
            <span>Lesiones</span>
        </a>
    </li>

    {{-- Patológicos --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-heartbeat"></i>
            <span>Patológicos</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- ════════════════════════════════
         SECCIÓN: HISTORIAL
    ════════════════════════════════ --}}
    <div class="sidebar-heading">
        Historial
    </div>

    {{-- Alimentación --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Alimentación</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
{{-- ===== End of Sidebar ===== --}}
