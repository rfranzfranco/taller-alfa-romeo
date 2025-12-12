<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
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

                    <?php echo view('partials/page-title', array('pagetitle' => 'Servicios', 'title' => $title)); ?>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Registrar Nuevo Servicio</h4>
                                </div>
                                <div class="card-body">

                                    <?php if (session()->getFlashdata('errors')): ?>
                                        <div class="alert alert-danger">
                                            <ul>
                                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                                    <li><?= esc($error) ?></li>
                                                <?php endforeach ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>

                                    <form action="/servicios/create" method="post">
                                        <?= csrf_field() ?>
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="nombre" class="form-label">Nombre del Servicio <span
                                                        class="text-danger">*</span></label>
                                                <select class="form-select" id="nombre" name="nombre" required
                                                    onchange="checkRampa()">
                                                    <option value="">Seleccione...</option>
                                                    <option value="Lavado">Lavado</option>
                                                    <option value="Limpieza">Limpieza</option>
                                                    <option value="Fumigado">Fumigado</option>
                                                    <option value="Cambio de Aceite">Cambio de Aceite</option>
                                                    <option value="Engrasado">Engrasado</option>
                                                    <option value="Cambio de Frenos">Cambio de Frenos</option>
                                                    <option value="Ajuste de Frenos">Ajuste de Frenos</option>
                                                    <option value="Encerado">Encerado</option>
                                                    <option value="Pulido">Pulido</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="costo_mano_obra" class="form-label">Costo Mano de Obra (Bs)
                                                    <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" class="form-control"
                                                    id="costo_mano_obra" name="costo_mano_obra"
                                                    value="<?= old('costo_mano_obra') ?>" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label">&nbsp;</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="requiere_rampa" name="requiere_rampa" value="1">
                                                    <label class="form-check-label" for="requiere_rampa">Requiere
                                                        Rampa</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="tiempo_estimado" class="form-label">Tiempo Estimado
                                                    (minutos) <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control" id="tiempo_estimado"
                                                    name="tiempo_estimado" value="<?= old('tiempo_estimado') ?>"
                                                    required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <textarea class="form-control" id="descripcion" name="descripcion"
                                                    rows="3"><?= old('descripcion') ?></textarea>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <a href="/servicios" class="btn btn-light">Cancelar</a>
                                            <button type="submit" class="btn btn-primary">Crear Servicio</button>
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
    <script src="/assets/js/app.js"></script>
    <script>
        function checkRampa() {
            const rampServices = ['Lavado', 'Limpieza', 'Fumigado'];
            const selectedService = document.getElementById('nombre').value;
            const checkbox = document.getElementById('requiere_rampa');
            
            if (rampServices.includes(selectedService)) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        }
    </script>
</body>

</html>