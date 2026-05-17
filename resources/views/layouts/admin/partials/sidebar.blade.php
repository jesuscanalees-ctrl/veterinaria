{{-- ===== Sidebar ===== --}}
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar - Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Veterinaria</div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Inicio --}}
    <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.home') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Inicio</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Sección: Clínica --}}
    <div class="sidebar-heading">
        Clínica
    </div>

    {{-- Atenciones --}}
    <li class="nav-item {{ request()->routeIs('atenciones.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAtenciones"
            aria-expanded="false" aria-controls="collapseAtenciones">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Atenciones</span>
        </a>
        <div id="collapseAtenciones" class="collapse {{ request()->routeIs('atenciones.*') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Atenciones:</h6>
                <a class="collapse-item {{ request()->routeIs('atenciones.index') ? 'active' : '' }}"
                   href="#">Ver Atenciones</a>
                <a class="collapse-item {{ request()->routeIs('atenciones.create') ? 'active' : '' }}"
                   href="#">Nueva Atención</a>
            </div>
        </div>
    </li>

    {{-- Pacientes --}}
    <li class="nav-item {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePacientes"
            aria-expanded="false" aria-controls="collapsePacientes">
            <i class="fas fa-fw fa-dog"></i>
            <span>Pacientes</span>
        </a>
        <div id="collapsePacientes" class="collapse {{ request()->routeIs('pacientes.*') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Pacientes:</h6>
                <a class="collapse-item {{ request()->routeIs('pacientes.index') ? 'active' : '' }}"
                   href="#">Ver Pacientes</a>
                <a class="collapse-item {{ request()->routeIs('pacientes.create') ? 'active' : '' }}"
                   href="#">Agregar Paciente</a>
            </div>
        </div>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Sección: Administración --}}
    <div class="sidebar-heading">
        Administración
    </div>

    {{-- Usuarios --}}
    <li class="nav-item {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="false" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-users"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse {{ request()->routeIs('usuarios.*') ? 'show' : '' }}"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Usuarios:</h6>
                <a class="collapse-item" href="#">Ver Usuarios</a>
                <a class="collapse-item" href="#">Agregar Usuario</a>
            </div>
        </div>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
{{-- ===== End of Sidebar ===== --}}
