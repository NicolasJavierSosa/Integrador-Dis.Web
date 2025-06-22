<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="../index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img src="{{asset('assets/img/AdminLTELogo.png')}}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">Sistema</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('dashboard')}}" class="nav-link" id="mnuDashboard">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('perfil.pedidos')}}" class="nav-link" id="mnuPedidos">
                        <i class="nav-icon bi bi-bag-fill"></i>
                        <p>
                            Pedidos
                        </p>
                    </a>
                </li>
                @canany(['user-list', 'rol-list'])
                <li class="nav-item" id="mnuSeguridad">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-shield-lock"></i>
                        <p>
                            Seguridad
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('user-list')
                        <li class="nav-item">
                            <a href="{{route('usuarios.index')}}" class="nav-link" id="itemUsuario">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Usuarios</p>
                            </a>
                        </li>
                        @endcan
                        @can('rol-list')
                        <li class="nav-item">
                            <a href="{{route('roles.index')}}" class="nav-link" id="itemRole">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany
                @canany(['producto-list'])
                <li class="nav-item" id="mnuAlmacen">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-archive-fill"></i>
                        <p>
                            Almacén
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @can('producto-list')
                        <li class="nav-item">
                            <a href="{{route('productos.index')}}" class="nav-link" id="itemProducto">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>Productos</p>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcanany            
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>