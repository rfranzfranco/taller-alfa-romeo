<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <!-- Flatpickr css -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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

                    <?php echo view('partials/page-title', array('pagetitle' => 'Reservas', 'title' => $title)); ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Modificar Reserva</h4>
                                    <div class="flex-shrink-0">
                                        <span class="badge bg-warning-subtle text-warning fs-12">
                                            Reserva #<?= $reserva['id_reserva'] ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">

                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> Error! </strong> <?= session()->getFlashdata('error') ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <i class="ri-information-line me-2"></i>
                                        <strong>Nota:</strong> Puede modificar la fecha, hora, vehículo y servicios de su reserva hasta 2 horas antes de la cita programada.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>

                                    <form action="/reservas/update/<?= $reserva['id_reserva'] ?>" method="post">
                                        <?= csrf_field() ?>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="id_vehiculo" class="form-label">Vehículo <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="id_vehiculo" name="id_vehiculo"
                                                    required>
                                                    <option value="">Seleccione su vehículo</option>
                                                    <?php foreach ($vehiculos as $vehiculo): ?>
                                                        <option value="<?= $vehiculo['id_vehiculo'] ?>" 
                                                            <?= $vehiculo['id_vehiculo'] == $reserva['id_vehiculo'] ? 'selected' : '' ?>>
                                                            <?= $vehiculo['placa'] ?> - <?= $vehiculo['marca'] ?>
                                                            <?= $vehiculo['modelo'] ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="fecha_reserva" class="form-label">Nueva Fecha y Hora <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="ri-calendar-line"></i></span>
                                                    <input type="text" class="form-control"
                                                        id="fecha_reserva" name="fecha_reserva"
                                                        value="<?= $reserva['fecha_reserva'] ?>"
                                                        placeholder="Seleccione fecha y hora" readonly required>
                                                </div>
                                                <small class="text-muted">Horario de atención: Lun-Sáb 08:00 - 18:00</small>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <h5 class="font-size-14 mb-3">Seleccione los Servicios</h5>
                                                <div class="row">
                                                    <?php foreach ($servicios as $servicio): ?>
                                                        <div class="col-md-4 mb-2">
                                                            <div class="form-check card-radio">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="servicios[]"
                                                                    id="servicio_<?= $servicio['id_servicio'] ?>"
                                                                    value="<?= $servicio['id_servicio'] ?>"
                                                                    <?= in_array($servicio['id_servicio'], $serviciosSeleccionados) ? 'checked' : '' ?>>
                                                                <label class="form-check-label"
                                                                    for="servicio_<?= $servicio['id_servicio'] ?>">
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="flex-grow-1">
                                                                            <h6 class="fs-14 mb-1">
                                                                                <?= $servicio['nombre'] ?></h6>
                                                                            <p class="text-muted mb-0">
                                                                                <?= $servicio['tiempo_estimado'] ?> min -
                                                                                Bs.
                                                                                <?= number_format($servicio['costo_mano_obra'], 2) ?>
                                                                            </p>
                                                                            <?php if ($servicio['requiere_rampa']): ?>
                                                                                <span class="badge badge-soft-warning">Requiere
                                                                                    Rampa</span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <div id="serviceError" class="text-danger mt-2" style="display:none;">
                                                    Debe seleccionar al menos un servicio.</div>
                                            </div>
                                        </div>

                                        <div class="text-end mt-4">
                                            <a href="/reservas" class="btn btn-light">Cancelar</a>
                                            <button type="submit" class="btn btn-success"
                                                onclick="return validateServices()">
                                                <i class="ri-save-line me-1"></i> Guardar Cambios
                                            </button>
                                        </div>
                                    </form>
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

    <?= $this->include('partials/vendor-scripts') ?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script>
        // Inicializar Flatpickr para el campo de fecha y hora
        flatpickr("#fecha_reserva", {
            locale: "es",
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            defaultDate: "<?= $reserva['fecha_reserva'] ?>",
            minDate: "today",
            minTime: "08:00",
            maxTime: "18:00",
            time_24hr: true,
            disableMobile: false,
            allowInput: false,
            clickOpens: true,
            disable: [
                function(date) {
                    // Deshabilitar domingos (0 = domingo)
                    return (date.getDay() === 0);
                }
            ],
            onChange: function(selectedDates, dateStr, instance) {
                // Validar que la hora esté dentro del horario de atención
                if (selectedDates.length > 0) {
                    const hour = selectedDates[0].getHours();
                    if (hour < 8 || hour >= 18) {
                        alert('Por favor seleccione un horario entre 08:00 y 18:00');
                        instance.clear();
                    }
                }
            }
        });

        function validateServices() {
            const checkboxes = document.querySelectorAll('input[name="servicios[]"]:checked');
            if (checkboxes.length === 0) {
                document.getElementById('serviceError').style.display = 'block';
                return false;
            }
            document.getElementById('serviceError').style.display = 'none';
            return true;
        }
    </script>
    <script src="/assets/js/app.js"></script>
</body>

</html>
