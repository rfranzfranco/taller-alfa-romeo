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
                    <?php echo view('partials/page-title', array('pagetitle' => 'Órdenes de Trabajo', 'title' => $title)); ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> Error! </strong> <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Detalles de la Reserva #<?= $reserva['id_reserva'] ?>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-truncate font-size-15"><?= $reserva['nombre_completo'] ?>
                                            </h5>
                                            <p class="text-muted mb-1">Vehículo: <?= $reserva['placa'] ?></p>
                                            <p class="text-muted mb-0">Fecha: <?= $reserva['fecha_reserva'] ?></p>
                                        </div>
                                    </div>
                                    <h6 class="mt-4">Servicios Solicitados:</h6>
                                    <div class="table-responsive">
                                        <table class="table table-sm table-nowrap align-middle mb-0">
                                            <tbody>
                                                <?php foreach ($detalles as $d): ?>
                                                    <tr>
                                                        <td><?= $d['nombre'] ?></td>
                                                        <td>
                                                            <?php if ($d['requiere_rampa']): ?>
                                                                <span class="badge bg-warning">Requiere Rampa</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-light text-dark">Estándar</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Asignación de Recursos</h5>
                                </div>
                                <div class="card-body">
                                    <form action="/ordenestrabajo/store" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_reserva" value="<?= $reserva['id_reserva'] ?>">

                                        <div class="mb-3">
                                            <label for="id_empleado" class="form-label">Técnico Responsable <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select" id="id_empleado" name="id_empleado" required>
                                                <option value="">Seleccione...</option>
                                                <?php foreach ($empleados as $emp): ?>
                                                    <option value="<?= $emp['id_empleado'] ?>">
                                                        <?= $emp['nombre_completo'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <?php if (empty($empleados)): ?>
                                                <div class="form-text text-danger">No hay técnicos (Rol: EMPLEADO)
                                                    registrados.</div>
                                            <?php endif; ?>
                                        </div>

                                        <?php if ($needsRamp): ?>
                                            <div class="mb-3">
                                                <label for="id_rampa" class="form-label">Rampa de Servicio <span
                                                        class="text-danger">*</span></label>
                                                <div class="alert alert-info py-2">Esta reserva requiere uso de rampa.</div>
                                                <select class="form-select" id="id_rampa" name="id_rampa" required>
                                                    <option value="">Seleccione Rampa...</option>
                                                    <?php foreach ($rampas as $rampa): ?>
                                                        <option value="<?= $rampa['id_rampa'] ?>">
                                                            <?= $rampa['nombre'] ?> (<?= $rampa['estado'] ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <?php if (empty($rampas)): ?>
                                                    <div class="form-text text-danger">Todas las rampas están ocupadas.</div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>

                                        <div class="d-grid gap-2">
                                            <button type="submit" class="btn btn-primary">Crear Orden de
                                                Trabajo</button>
                                            <a href="/ordenestrabajo" class="btn btn-light">Cancelar</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <?= $this->include('partials/footer') ?>
        </div>
    </div>
    <?= $this->include('partials/vendor-scripts') ?>
    <script src="/assets/js/app.js"></script>
</body>

</html>