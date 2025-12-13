<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo-dark.png" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/" class="logo logo-light">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo-light.png" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span data-key="t-menu">Menu</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Inicio</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Operaciones</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarReservas" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarReservas">
                        <i class="ri-calendar-event-line"></i> <span data-key="t-reservas">Reservas</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarReservas">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="/reservas" class="nav-link" data-key="t-mis-citas">Mis Citas / Lista</a>
                            </li>
                            <li class="nav-item">
                                <a href="/reservas/new" class="nav-link" data-key="t-nueva-reserva">Nueva Reserva</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="/ordenestrabajo">
                        <i class="ri-hammer-line"></i> <span data-key="t-ordenes">Órdenes de Trabajo</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/vehiculos/recepcion"> <!-- Placeholder for now -->
                        <i class="ri-car-line"></i> <span data-key="t-recepcion">Recepción Vehículos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/historial">
                        <i class="ri-history-line"></i> <span data-key="t-historial">Historial de Servicios</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Gestión</span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link" href="/servicios">
                        <i class="ri-price-tag-3-line"></i> <span data-key="t-servicios">Catálogo Servicios</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/clientes">
                        <i class="ri-user-line"></i> <span data-key="t-clientes">Clientes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/vehiculos">
                        <i class="ri-roadster-line"></i> <span data-key="t-vehiculos">Vehículos</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/insumos">
                        <i class="ri-stack-line"></i> <span data-key="t-inventario">Inventario</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/empleados">
                        <i class="ri-team-line"></i> <span data-key="t-personal">Personal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/usuarios">
                        <i class="ri-user-settings-line"></i> <span data-key="t-usuarios">Usuarios</span>
                    </a>
                </li>

                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Finanzas</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="/facturas">
                        <i class="ri-file-list-3-line"></i> <span data-key="t-facturacion">Facturación</span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>