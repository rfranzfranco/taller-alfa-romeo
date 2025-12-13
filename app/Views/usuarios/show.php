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
                                        <li class="breadcrumb-item"><a href="/usuarios">Usuarios</a></li>
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
                                                <?php 
                                                $avatarClass = 'bg-secondary-subtle text-secondary';
                                                if ($usuario['rol'] == 'ADMIN') $avatarClass = 'bg-danger-subtle text-danger';
                                                elseif ($usuario['rol'] == 'RECEPCIONISTA') $avatarClass = 'bg-warning-subtle text-warning';
                                                elseif ($usuario['rol'] == 'EMPLEADO') $avatarClass = 'bg-primary-subtle text-primary';
                                                elseif ($usuario['rol'] == 'CLIENTE') $avatarClass = 'bg-info-subtle text-info';
                                                ?>
                                                <div class="avatar-title <?= $avatarClass ?> rounded-circle fs-1">
                                                    <?= strtoupper(substr($usuario['username'], 0, 2)) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-1"><?= esc($usuario['username']) ?></h5>
                                        <p class="text-muted mb-0">
                                            <?php 
                                            $rolClass = 'bg-info-subtle text-info';
                                            if ($usuario['rol'] == 'ADMIN') $rolClass = 'bg-danger-subtle text-danger';
                                            elseif ($usuario['rol'] == 'RECEPCIONISTA') $rolClass = 'bg-warning-subtle text-warning';
                                            elseif ($usuario['rol'] == 'EMPLEADO') $rolClass = 'bg-primary-subtle text-primary';
                                            ?>
                                            <span class="badge <?= $rolClass ?> fs-12"><?= esc($usuario['rol']) ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>Información de Cuenta
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">ID Usuario:</th>
                                                    <td class="text-muted">#<?= $usuario['id_usuario'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Username:</th>
                                                    <td class="text-muted"><?= esc($usuario['username']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Rol:</th>
                                                    <td class="text-muted">
                                                        <span class="badge <?= $rolClass ?>"><?= esc($usuario['rol']) ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Estado:</th>
                                                    <td>
                                                        <?php if ($usuario['estado'] == '1'): ?>
                                                            <span class="badge bg-success-subtle text-success">Activo</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger-subtle text-danger">Inactivo</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Creación:</th>
                                                    <td class="text-muted">
                                                        <i class="ri-calendar-line me-1"></i>
                                                        <?= date('d/m/Y', strtotime($usuario['fecha_creacion'])) ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-9">
                            <?php if ($usuario['rol'] === 'CLIENTE' && !empty($cliente)): ?>
                                <!-- Información del Cliente -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-user-3-line me-2"></i>Información Personal
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong>Nombre Completo:</strong> <?= esc($cliente['nombre_completo']) ?></p>
                                                <p class="mb-2"><strong>CI/NIT:</strong> <span class="badge bg-light text-body"><?= esc($cliente['ci_nit']) ?></span></p>
                                                <p class="mb-0"><strong>Teléfono:</strong> <?= esc($cliente['telefono']) ?></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong>Correo:</strong> <?= esc($cliente['correo']) ?></p>
                                                <p class="mb-0"><strong>Dirección:</strong> <?= !empty($cliente['direccion']) ? esc($cliente['direccion']) : '-' ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Vehículos del Cliente -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-car-line me-2"></i>Vehículos Registrados
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($vehiculos)): ?>
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Placa</th>
                                                            <th>Marca</th>
                                                            <th>Modelo</th>
                                                            <th>Año</th>
                                                            <th>Color</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($vehiculos as $vehiculo): ?>
                                                            <tr>
                                                                <td><span class="badge bg-primary-subtle text-primary fs-12"><?= esc($vehiculo['placa']) ?></span></td>
                                                                <td><?= esc($vehiculo['marca']) ?></td>
                                                                <td><?= esc($vehiculo['modelo']) ?></td>
                                                                <td><?= esc($vehiculo['anio']) ?></td>
                                                                <td><?= esc($vehiculo['color']) ?></td>
                                                                <td>
                                                                    <a href="/vehiculos/<?= $vehiculo['id_vehiculo'] ?>" class="btn btn-sm btn-soft-info">
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
                                                <p class="text-muted mb-0">Sin vehículos registrados</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Reservas Recientes -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-calendar-check-line me-2"></i>Reservas Recientes
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($reservas)): ?>
                                            <div class="table-responsive">
                                                <table class="table table-hover align-middle mb-0">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Reserva</th>
                                                            <th>Vehículo</th>
                                                            <th>Fecha</th>
                                                            <th>Estado</th>
                                                            <th>Acción</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($reservas as $reserva): ?>
                                                            <tr>
                                                                <td><span class="fw-medium">#<?= $reserva['id_reserva'] ?></span></td>
                                                                <td><?= esc($reserva['placa'] ?? '-') ?></td>
                                                                <td><?= date('d/m/Y H:i', strtotime($reserva['fecha_hora_reserva'])) ?></td>
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
                                                                    <a href="/reservas/<?= $reserva['id_reserva'] ?>" class="btn btn-sm btn-soft-primary">
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
                                                <p class="text-muted mb-0">Sin reservas registradas</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php elseif ($usuario['rol'] === 'EMPLEADO' && !empty($empleado)): ?>
                                <!-- Información del Empleado -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-user-3-line me-2"></i>Información del Empleado
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong>Nombre Completo:</strong> <?= esc($empleado['nombre_completo']) ?></p>
                                                <p class="mb-0"><strong>Cargo:</strong> 
                                                    <?php 
                                                    $cargoClass = 'bg-info-subtle text-info';
                                                    if (stripos($empleado['cargo'], 'técnico') !== false || stripos($empleado['cargo'], 'tecnico') !== false) {
                                                        $cargoClass = 'bg-primary-subtle text-primary';
                                                    } elseif (stripos($empleado['cargo'], 'jefe') !== false) {
                                                        $cargoClass = 'bg-warning-subtle text-warning';
                                                    }
                                                    ?>
                                                    <span class="badge <?= $cargoClass ?>"><?= esc($empleado['cargo']) ?></span>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p class="mb-2"><strong>Especialidad:</strong> <?= !empty($empleado['especialidad']) ? esc($empleado['especialidad']) : '-' ?></p>
                                                <p class="mb-0"><strong>Fecha Contratación:</strong> 
                                                    <?= !empty($empleado['fecha_contratacion']) ? date('d/m/Y', strtotime($empleado['fecha_contratacion'])) : '-' ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Órdenes de Trabajo -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="ri-briefcase-4-line me-2"></i>Órdenes de Trabajo Asignadas
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <?php if (!empty($ordenes)): ?>
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
                                                                <td><span class="fw-medium">#<?= $orden['id_orden'] ?></span></td>
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
                                                <i class="ri-briefcase-4-line fs-1 text-muted d-block mb-2"></i>
                                                <p class="text-muted mb-0">Sin órdenes de trabajo asignadas</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php else: ?>
                                <!-- Usuario Admin o Recepcionista sin datos adicionales -->
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center py-5">
                                            <div class="avatar-lg mx-auto mb-4">
                                                <div class="avatar-title <?= $avatarClass ?> rounded-circle fs-1">
                                                    <i class="ri-admin-line"></i>
                                                </div>
                                            </div>
                                            <h5 class="mb-2">Usuario de Sistema</h5>
                                            <p class="text-muted mb-0">
                                                Este usuario tiene rol <strong><?= esc($usuario['rol']) ?></strong> y tiene acceso 
                                                <?php if ($usuario['rol'] === 'ADMIN'): ?>
                                                    completo al sistema de gestión.
                                                <?php else: ?>
                                                    para gestionar reservas y recepción de vehículos.
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Acciones -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="/usuarios" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i>Volver
                                        </a>
                                        <a href="/usuarios/<?= $usuario['id_usuario'] ?>/edit" class="btn btn-primary">
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
