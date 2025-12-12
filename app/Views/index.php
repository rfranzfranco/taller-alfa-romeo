<?= $this->include('partials/main') ?>

<head>

    <?php echo view('partials/title-meta', array('title' => 'Dashboard')); ?>

    <?= $this->include('partials/head-css') ?>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include('partials/menu') ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col">

                            <div class="h-100">
                                <div class="row mb-3 pb-1">
                                    <div class="col-12">
                                        <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                            <div class="flex-grow-1">
                                                <h4 class="fs-16 mb-1">Bienvenido,
                                                    <?= session()->get('user_name') ?? 'Admin' ?>!</h4>
                                                <p class="text-muted mb-0">Resumen de actividad del Taller Alfa Romeo
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p
                                                            class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Reservas Hoy</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h5 class="text-success fs-14 mb-0"><?= $reservas_hoy ?></h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <?= $reservas_hoy ?></h4>
                                                        <a href="/reservas" class="text-decoration-underline">Ver
                                                            reservas</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-success-subtle rounded fs-3">
                                                            <i class="ri-calendar-event-line text-success"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p
                                                            class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Órdenes Activas</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h5 class="text-warning fs-14 mb-0"><?= $ordenes_activas ?></h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <?= $ordenes_activas ?></h4>
                                                        <a href="/ordenestrabajo" class="text-decoration-underline">Ver
                                                            órdenes</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-warning-subtle rounded fs-3">
                                                            <i class="ri-hammer-line text-warning"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p
                                                            class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Facturas Pendientes</p>
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <h5 class="text-danger fs-14 mb-0"><?= $facturas_pendientes ?>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <?= $facturas_pendientes ?></h4>
                                                        <a href="/facturas" class="text-decoration-underline">Ver
                                                            facturas</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-danger-subtle rounded fs-3">
                                                            <i class="ri-file-warning-line text-danger"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-3 col-md-6">
                                        <div class="card card-animate">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p
                                                            class="text-uppercase fw-medium text-muted text-truncate mb-0">
                                                            Total Vehículos</p>
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-end justify-content-between mt-4">
                                                    <div>
                                                        <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                            <?= $total_vehiculos ?></h4>
                                                        <a href="/vehiculos" class="text-decoration-underline">Ver
                                                            flota</a>
                                                    </div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <span class="avatar-title bg-info-subtle rounded fs-3">
                                                            <i class="ri-car-line text-info"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Próximas Reservas</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table
                                                        class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Cliente</th>
                                                                <th>Vehículo</th>
                                                                <th>Estado</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($latest_reservas)): ?>
                                                                <?php foreach ($latest_reservas as $reserva): ?>
                                                                    <tr>
                                                                        <td><?= $reserva['fecha_reserva'] ?></td>
                                                                        <td><?= $reserva['cliente_nombre'] ?></td>
                                                                        <td><?= $reserva['placa'] ?></td>
                                                                        <td>
                                                                            <span
                                                                                class="badge bg-primary-subtle text-primary"><?= $reserva['estado'] ?></span>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="4" class="text-center">No hay reservas
                                                                        próximas</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-6">
                                        <div class="card">
                                            <div class="card-header align-items-center d-flex">
                                                <h4 class="card-title mb-0 flex-grow-1">Órdenes en Progreso</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive table-card">
                                                    <table
                                                        class="table table-hover table-centered align-middle table-nowrap mb-0">
                                                        <thead class="text-muted table-light">
                                                            <tr>
                                                                <th>ID</th>
                                                                <th>Vehículo</th>
                                                                <th>Mecánico</th>
                                                                <th>Acción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php if (!empty($active_ordenes)): ?>
                                                                <?php foreach ($active_ordenes as $orden): ?>
                                                                    <tr>
                                                                        <td><a href="/ordenestrabajo/<?= $orden['id_orden'] ?>"
                                                                                class="fw-medium link-primary">#<?= $orden['id_orden'] ?></a>
                                                                        </td>
                                                                        <td><?= $orden['placa'] ?></td>
                                                                        <td><?= $orden['mecanico_nombre'] ?? 'Sin asignar' ?>
                                                                        </td>
                                                                        <td>
                                                                            <a href="/ordenestrabajo/<?= $orden['id_orden'] ?>"
                                                                                class="btn btn-sm btn-soft-info">Ver</a>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <tr>
                                                                    <td colspan="4" class="text-center">No hay órdenes en
                                                                        progreso</td>
                                                                </tr>
                                                            <?php endif; ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?= $this->include('partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?= $this->include('partials/customizer') ?>

    <?= $this->include('partials/vendor-scripts') ?>

    <!-- App js -->
    <script src="/assets/js/app.js"></script>
</body>

</html>