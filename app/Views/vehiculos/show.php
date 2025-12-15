<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <?= $this->include('partials/head-css') ?>
</head>

<body>
    <div id="layout-wrapper">
        <?= $this->include('partials/menu') ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= $title ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Gestión</a></li>
                                        <li class="breadcrumb-item"><a href="/vehiculos">Vehículos</a></li>
                                        <li class="breadcrumb-item active">Detalle</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-4">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                            <div class="avatar-lg">
                                                <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-1">
                                                    <i class="ri-car-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-1">
                                            <span class="badge bg-dark fs-14"><?= esc($vehiculo['placa']) ?></span>
                                        </h5>
                                        <p class="text-muted mb-0"><?= esc($vehiculo['marca']) ?> <?= esc($vehiculo['modelo']) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>Especificaciones
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">ID Vehículo:</th>
                                                    <td class="text-muted">#<?= $vehiculo['id_vehiculo'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Placa:</th>
                                                    <td class="text-muted">
                                                        <span class="badge bg-light text-body fs-12"><?= esc($vehiculo['placa']) ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Marca:</th>
                                                    <td class="text-muted"><?= esc($vehiculo['marca']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Modelo:</th>
                                                    <td class="text-muted"><?= esc($vehiculo['modelo']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Año:</th>
                                                    <td class="text-muted"><?= esc($vehiculo['anio']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Color:</th>
                                                    <td class="text-muted">
                                                        <i class="ri-palette-line me-1"></i><?= esc($vehiculo['color']) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Tipo Motor:</th>
                                                    <td class="text-muted">
                                                        <span class="badge bg-info-subtle text-info"><?= esc($vehiculo['tipo_motor']) ?></span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Propietario -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i class="ri-user-line me-2"></i>Propietario
                                    </h5>
                                    <?php if (!empty($cliente)): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-3">
                                                <div class="avatar-title bg-info-subtle text-info rounded-circle">
                                                    <?= strtoupper(substr($cliente['nombre_completo'], 0, 1)) ?>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?= esc($cliente['nombre_completo']) ?></h6>
                                                <p class="text-muted mb-0 fs-12">
                                                    <i class="ri-phone-line me-1"></i><?= esc($cliente['telefono']) ?>
                                                </p>
                                            </div>
                                            <a href="/clientes/<?= $cliente['id_cliente'] ?>" class="btn btn-sm btn-soft-primary">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted mb-0">Sin propietario asignado</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-8">
                            <!-- Historial de Reservas/Servicios -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-calendar-check-line me-2"></i>Historial de Servicios
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($reservas) && is_array($reservas)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Reserva</th>
                                                        <th>Fecha</th>
                                                        <th>Estado</th>
                                                        <th>Descripción</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($reservas as $reserva): ?>
                                                        <tr>
                                                            <td><a href="/reservas/<?= $reserva['id_reserva'] ?>" class="fw-medium">#<?= $reserva['id_reserva'] ?></a></td>
                                                            <td>
                                                                <i class="ri-calendar-line me-1 text-muted"></i>
                                                                <?= date('d/m/Y', strtotime($reserva['fecha_reserva'])) ?>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                $estadoClass = 'bg-secondary';
                                                                switch(strtoupper($reserva['estado'])) {
                                                                    case 'PENDIENTE': $estadoClass = 'bg-warning'; break;
                                                                    case 'CONFIRMADA': $estadoClass = 'bg-info'; break;
                                                                    case 'EN_PROCESO': $estadoClass = 'bg-primary'; break;
                                                                    case 'COMPLETADA': $estadoClass = 'bg-success'; break;
                                                                    case 'CANCELADA': $estadoClass = 'bg-danger'; break;
                                                                }
                                                                ?>
                                                                <span class="badge <?= $estadoClass ?>"><?= esc($reserva['estado']) ?></span>
                                                            </td>
                                                            <td>
                                                                <small class="text-muted">
                                                                    <?= esc(substr($reserva['descripcion_problema'] ?? 'Sin descripción', 0, 40)) ?>...
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <a href="/reservas/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-soft-primary" title="Ver reserva">
                                                                    <i class="ri-eye-line"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <i class="ri-calendar-check-line fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted mb-0">Este vehículo no tiene historial de servicios</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="/vehiculos" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i>Volver
                                        </a>
                                        <a href="/vehiculos/<?= $vehiculo['id_vehiculo'] ?>/edit" class="btn btn-primary">
                                            <i class="ri-edit-line me-1"></i>Editar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>

    <?= $this->include('partials/customizer') ?>
    <?= $this->include('partials/vendor-scripts') ?>
    <script src="/assets/js/app.js"></script>
</body>

</html>
