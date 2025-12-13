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
                                        <li class="breadcrumb-item"><a href="/clientes">Clientes</a></li>
                                        <li class="breadcrumb-item active">Detalle</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-3">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                            <div class="avatar-lg">
                                                <div class="avatar-title bg-info-subtle text-info rounded-circle fs-1">
                                                    <?= strtoupper(substr($cliente['nombre_completo'], 0, 2)) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-1"><?= esc($cliente['nombre_completo']) ?></h5>
                                        <p class="text-muted mb-0">Cliente</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>Información Personal
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">ID Cliente:</th>
                                                    <td class="text-muted">#<?= $cliente['id_cliente'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">CI / NIT:</th>
                                                    <td class="text-muted">
                                                        <span class="badge bg-light text-body fs-12"><?= esc($cliente['ci_nit']) ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Teléfono:</th>
                                                    <td class="text-muted">
                                                        <i class="ri-phone-line me-1"></i><?= esc($cliente['telefono']) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Correo:</th>
                                                    <td class="text-muted">
                                                        <i class="ri-mail-line me-1"></i><?= esc($cliente['correo']) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Dirección:</th>
                                                    <td class="text-muted">
                                                        <?= !empty($cliente['direccion']) ? esc($cliente['direccion']) : '<span class="text-muted">-</span>' ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-9">
                            <!-- Vehículos del Cliente -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-car-line me-2"></i>Vehículos Registrados
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($vehiculos) && is_array($vehiculos)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Placa</th>
                                                        <th>Marca</th>
                                                        <th>Modelo</th>
                                                        <th>Año</th>
                                                        <th>Color</th>
                                                        <th>Motor</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($vehiculos as $vehiculo): ?>
                                                        <tr>
                                                            <td>
                                                                <span class="badge bg-primary-subtle text-primary fs-12"><?= esc($vehiculo['placa']) ?></span>
                                                            </td>
                                                            <td><?= esc($vehiculo['marca']) ?></td>
                                                            <td><?= esc($vehiculo['modelo']) ?></td>
                                                            <td><?= esc($vehiculo['anio']) ?></td>
                                                            <td><?= esc($vehiculo['color']) ?></td>
                                                            <td><small class="text-muted"><?= esc($vehiculo['tipo_motor']) ?></small></td>
                                                            <td>
                                                                <a href="/vehiculos/<?= $vehiculo['id_vehiculo'] ?>" class="btn btn-sm btn-soft-info" title="Ver detalles">
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
                                            <i class="ri-car-line fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted mb-0">Este cliente no tiene vehículos registrados</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Reservas del Cliente -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-calendar-check-line me-2"></i>Historial de Reservas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($reservas) && is_array($reservas)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Reserva</th>
                                                        <th>Vehículo</th>
                                                        <th>Fecha Programada</th>
                                                        <th>Estado</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($reservas as $reserva): ?>
                                                        <tr>
                                                            <td><a href="/reservas/<?= $reserva['id_reserva'] ?>" class="fw-medium">#<?= $reserva['id_reserva'] ?></a></td>
                                                            <td><?= esc($reserva['placa'] ?? '-') ?></td>
                                                            <td>
                                                                <i class="ri-calendar-line me-1"></i>
                                                                <?= date('d/m/Y H:i', strtotime($reserva['fecha_hora_reserva'])) ?>
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
                                            <p class="text-muted mb-0">Este cliente no tiene reservas registradas</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="/clientes" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i>Volver
                                        </a>
                                        <a href="/clientes/<?= $cliente['id_cliente'] ?>/edit" class="btn btn-primary">
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
