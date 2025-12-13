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
                                        <li class="breadcrumb-item"><a href="/empleados">Personal</a></li>
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
                                                <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-1">
                                                    <?= strtoupper(substr($empleado['nombre_completo'], 0, 2)) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-1"><?= esc($empleado['nombre_completo']) ?></h5>
                                        <p class="text-muted mb-0"><?= esc($empleado['cargo']) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>Información
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">ID Empleado:</th>
                                                    <td class="text-muted">#<?= $empleado['id_empleado'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">ID Usuario:</th>
                                                    <td class="text-muted">#<?= $empleado['id_usuario'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Cargo:</th>
                                                    <td class="text-muted">
                                                        <?php 
                                                        $cargoClass = 'bg-info-subtle text-info';
                                                        if (stripos($empleado['cargo'], 'técnico') !== false || stripos($empleado['cargo'], 'tecnico') !== false) {
                                                            $cargoClass = 'bg-primary-subtle text-primary';
                                                        } elseif (stripos($empleado['cargo'], 'jefe') !== false) {
                                                            $cargoClass = 'bg-warning-subtle text-warning';
                                                        }
                                                        ?>
                                                        <span class="badge <?= $cargoClass ?>"><?= esc($empleado['cargo']) ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Especialidad:</th>
                                                    <td class="text-muted">
                                                        <?= !empty($empleado['especialidad']) ? esc($empleado['especialidad']) : '<span class="text-muted">-</span>' ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Contratación:</th>
                                                    <td class="text-muted">
                                                        <?php if (!empty($empleado['fecha_contratacion'])): ?>
                                                            <i class="ri-calendar-line me-1"></i>
                                                            <?= date('d/m/Y', strtotime($empleado['fecha_contratacion'])) ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-9">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-briefcase-4-line me-2"></i>Órdenes de Trabajo Asignadas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($ordenes) && is_array($ordenes)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Orden</th>
                                                        <th>Reserva</th>
                                                        <th>Estado</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecha Fin</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($ordenes as $orden): ?>
                                                        <tr>
                                                            <td><a href="/ordenes-trabajo/<?= $orden['id_orden'] ?>" class="fw-medium">#<?= $orden['id_orden'] ?></a></td>
                                                            <td>#<?= $orden['id_reserva'] ?></td>
                                                            <td>
                                                                <?php 
                                                                $estadoClass = 'bg-secondary';
                                                                switch(strtoupper($orden['estado'])) {
                                                                    case 'PENDIENTE': $estadoClass = 'bg-warning'; break;
                                                                    case 'EN_PROCESO': $estadoClass = 'bg-info'; break;
                                                                    case 'COMPLETADA': case 'FINALIZADA': $estadoClass = 'bg-success'; break;
                                                                    case 'CANCELADA': $estadoClass = 'bg-danger'; break;
                                                                }
                                                                ?>
                                                                <span class="badge <?= $estadoClass ?>"><?= esc($orden['estado']) ?></span>
                                                            </td>
                                                            <td><?= !empty($orden['fecha_inicio_real']) ? date('d/m/Y H:i', strtotime($orden['fecha_inicio_real'])) : '-' ?></td>
                                                            <td><?= !empty($orden['fecha_fin_real']) ? date('d/m/Y H:i', strtotime($orden['fecha_fin_real'])) : '-' ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <i class="ri-file-list-3-line fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted mb-0">Este empleado no tiene órdenes de trabajo asignadas</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="/empleados" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i>Volver
                                        </a>
                                        <a href="/empleados/<?= $empleado['id_empleado'] ?>/edit" class="btn btn-primary">
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
