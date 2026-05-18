{{-- ===== Topbar ===== --}}
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    {{-- Sidebar Toggle (visible en móvil) --}}
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Brand / Logo --}}
    <a class="navbar-brand d-flex align-items-center justify-content-center mr-4" href="{{ route('home') }}">
        <div class="sidebar-brand-icon text-primary">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-2 text-dark font-weight-bold">Sistema Veterinario</div>
    </a>

    {{-- Enlaces Izquierdos --}}
    <ul class="navbar-nav">
        <li class="nav-item {{ request()->routeIs('expedientes.index') ? 'active' : '' }}">
            <a class="nav-link text-gray-600 font-weight-bold" href="{{ route('expedientes.index') }}">
                <i class="fas fa-folder fa-fw mr-1 text-primary"></i> Expedientes
            </a>
        </li>
    </ul>

    {{-- Buscador --}}
    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
        <div class="input-group">
            <input type="text" class="form-control bg-light border-0 small"
                placeholder="Buscar..." aria-label="Buscar" aria-describedby="buscar-btn">
            <div class="input-group-append">
                <button class="btn btn-primary" type="button" id="buscar-btn">
                    <i class="fas fa-search fa-sm"></i>
                </button>
            </div>
        </div>
    </form>

    {{-- Navbar derecho --}}
    <ul class="navbar-nav ml-auto">

        {{-- Buscador (visible solo en XS) --}}
        <li class="nav-item dropdown no-arrow d-sm-none">
            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small"
                            placeholder="Buscar..." aria-label="Buscar">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>



        {{-- Separador --}}
        <div class="topbar-divider d-none d-sm-block"></div>

        {{-- Usuario actual --}}
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    {{ Auth::user()->name ?? 'Usuario' }}
                </span>
                <img class="img-profile rounded-circle"
                    src="{{ asset('startbootstrap/img/undraw_profile.svg') }}"
                    alt="Perfil">
            </a>

            {{-- Dropdown menú usuario --}}
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">

                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Mi Perfil
                </a>

                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Configuración
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Cerrar sesión
                </a>
            </div>
        </li>

    </ul>

</nav>
{{-- ===== End of Topbar ===== --}}
