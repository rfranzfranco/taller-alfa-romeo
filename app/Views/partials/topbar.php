<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="/" class="logo logo-dark">
                        <span class="logo-sm">
                            <i class="ri-roadster-fill fs-24 text-primary"></i>
                        </span>
                        <span class="logo-lg">
                            <span class="fw-bold text-dark">TALLER</span> <span class="text-primary fw-bold">ALFA</span>
                        </span>
                    </a>

                    <a href="/" class="logo logo-light">
                        <span class="logo-sm">
                            <i class="ri-roadster-fill fs-24 text-white"></i>
                        </span>
                        <span class="logo-lg">
                            <span class="fw-bold text-white">TALLER</span> <span style="color: #6ae0bd;" class="fw-bold">ALFA</span>
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger" id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>

            <div class="d-flex align-items-center">

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>

                <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                        <i class='bx bx-bell fs-22'></i>
                        <?php 
                        $insumosModel = new \App\Models\InsumosModel();
                        $alertasInsumos = $insumosModel->where('stock_actual <= stock_minimo')->findAll();
                        $countAlertas = count($alertasInsumos);
                        if ($countAlertas > 0): ?>
                        <span class="position-absolute topbar-badge fs-10 translate-middle badge rounded-pill bg-danger"><?= $countAlertas ?><span class="visually-hidden">alertas</span></span>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">

                        <div class="dropdown-head bg-primary bg-pattern rounded-top">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold text-white"> Alertas de Insumos </h6>
                                    </div>
                                    <?php if ($countAlertas > 0): ?>
                                    <div class="col-auto dropdown-tabs">
                                        <span class="badge bg-light-subtle text-body fs-13"><?= $countAlertas ?> Alertas</span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content position-relative" id="notificationItemsTabContent">
                            <div class="tab-pane fade show active py-2 ps-2" id="alerts-tab" role="tabpanel">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <?php if ($countAlertas > 0): ?>
                                        <?php foreach ($alertasInsumos as $insumo): ?>
                                        <div class="text-reset notification-item d-block dropdown-item position-relative">
                                            <div class="d-flex">
                                                <div class="avatar-xs me-3 flex-shrink-0">
                                                    <span class="avatar-title bg-warning-subtle text-warning rounded-circle fs-16">
                                                        <i class="bx bx-error"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <a href="<?= base_url('insumos') ?>" class="stretched-link">
                                                        <h6 class="mt-0 mb-2 lh-base">
                                                            <b><?= esc($insumo['nombre']) ?></b> - Stock bajo
                                                        </h6>
                                                    </a>
                                                    <p class="mb-0 fs-11 fw-medium text-muted">
                                                        Stock actual: <span class="text-danger fw-bold"><?= $insumo['stock_actual'] ?></span> | 
                                                        Mínimo: <?= $insumo['stock_minimo'] ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <div class="avatar-md mx-auto mb-3">
                                                <span class="avatar-title bg-success-subtle text-success rounded-circle fs-24">
                                                    <i class="bx bx-check-circle"></i>
                                                </span>
                                            </div>
                                            <h6 class="text-muted">Sin alertas de stock</h6>
                                            <p class="text-muted fs-12">Todos los insumos tienen stock suficiente</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usuario Logueado -->
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <div class="avatar-xs">
                                <div class="avatar-title bg-primary-subtle text-primary rounded-circle">
                                    <?= strtoupper(substr(session()->get('username') ?? 'U', 0, 1)) ?>
                                </div>
                            </div>
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?= esc(session()->get('username') ?? 'Usuario') ?></span>
                                <span class="d-none d-xl-block ms-1 fs-12 user-name-sub-text"><?= esc(session()->get('rol') ?? 'Sin rol') ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">¡Bienvenido, <?= esc(session()->get('username') ?? 'Usuario') ?>!</h6>
                        <a class="dropdown-item" href="/usuarios/<?= session()->get('id_usuario') ?>/edit">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Mi Perfil</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="<?= base_url('logout') ?>">
                            <i class="mdi mdi-logout text-danger fs-16 align-middle me-1"></i> 
                            <span class="align-middle">Cerrar Sesión</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>