<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <?= $this->include('partials/head-css') ?>
    <link href="/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
    <style>
        /* Fix for Choices.js transparent dropdown */
        .choices__list--dropdown,
        .choices__list[aria-expanded] {
            background-color: #ffffff !important;
            z-index: 1000 !important;
            /* Ensure it stays on top */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        /* Fix for dark mode if applicable */
        [data-layout-mode="dark"] .choices__list--dropdown,
        [data-layout-mode="dark"] .choices__list[aria-expanded] {
            background-color: #292e32 !important;
            border-color: #32383e;
        }

        /* Fix text cutoff */
        .choices__list--dropdown .choices__item {
            padding-left: 15px !important;
            padding-right: 15px !important;
        }
    </style>
</head>

<body>
    <div id="layout-wrapper">
        <?= $this->include('partials/menu') ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <?php echo view('partials/page-title', array('pagetitle' => 'Gestión', 'title' => $title)); ?>

                    <!-- Alerts -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">Registrar Llegada de Vehículo</h4>
                                </div>
                                <div class="card-body p-4">
                                    <form action="/vehiculos/recepcion/store" method="post">
                                        <?= csrf_field() ?>
                                        <div class="row g-3">

                                            <!-- Vehicle Selection -->
                                            <div class="col-md-6">
                                                <label class="form-label">Vehículo <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="id_vehiculo" id="id_vehiculo"
                                                    data-choices required>
                                                    <option value="">Buscar por Placa o Cliente...</option>
                                                    <?php foreach ($vehiculos as $v): ?>
                                                        <option value="<?= $v['id_vehiculo'] ?>">
                                                            <?= esc($v['placa']) ?> - <?= esc($v['marca']) ?>
                                                            <?= esc($v['modelo']) ?>
                                                            (Prop: <?= esc($v['nombre_completo']) ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="form-text">Si el vehículo no existe, debe registrarlo
                                                    primero en <a href="/vehiculos/new">Vehículos</a>.</div>
                                            </div>

                                            <!-- Services Selection -->
                                            <div class="col-md-6">
                                                <label class="form-label">Servicios a Realizar <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control" name="servicios[]" id="servicios"
                                                    data-choices multiple required>
                                                    <?php foreach ($servicios as $s): ?>
                                                        <option value="<?= $s['id_servicio'] ?>">
                                                            <?= esc($s['nombre']) ?> (Bs. <?= $s['costo_mano_obra'] ?>)
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <!-- Observations -->
                                            <div class="col-12">
                                                <label class="form-label">Observaciones de Recepción</label>
                                                <textarea class="form-control" name="observaciones" rows="3"
                                                    placeholder="Estado del vehículo al llegar, daños visibles, etc."></textarea>
                                            </div>

                                            <div class="col-12 mt-4">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="ri-save-line align-middle me-1"></i> Registrar Ingreso y
                                                    Asignar Servicios
                                                </button>
                                            </div>

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
    <?= $this->include('partials/customizer') ?>
    <?= $this->include('partials/vendor-scripts') ?>
    <script src="/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>

</html>