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
                                            <div class="col-md-6 mb-3">
                                                <label for="nombre" class="form-label">Nombre del Servicio <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                                    value="<?= old('nombre') ?>" placeholder="Ej: Cambio de Aceite" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="descripcion" class="form-label">Descripción</label>
                                                <input type="text" class="form-control" id="descripcion" name="descripcion" 
                                                    value="<?= old('descripcion') ?>" placeholder="Descripción breve del servicio">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="costo_mano_obra" class="form-label">Costo Mano de Obra (Bs) <span class="text-danger">*</span></label>
                                                <input type="number" step="0.01" min="0" class="form-control"
                                                    id="costo_mano_obra" name="costo_mano_obra"
                                                    value="<?= old('costo_mano_obra') ?>" placeholder="0.00" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="tiempo_estimado" class="form-label">Tiempo Estimado (minutos) <span class="text-danger">*</span></label>
                                                <input type="number" min="1" class="form-control" id="tiempo_estimado"
                                                    name="tiempo_estimado" value="<?= old('tiempo_estimado') ?>" 
                                                    placeholder="Ej: 30" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="form-label d-block">Opciones</label>
                                                <div class="form-check form-switch mt-2">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                        id="requiere_rampa" name="requiere_rampa" value="1">
                                                    <label class="form-check-label" for="requiere_rampa">Requiere Rampa</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end mt-3">
                                            <a href="/servicios" class="btn btn-light me-2">Cancelar</a>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="ri-save-line me-1"></i> Crear Servicio
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
    <script src="/assets/js/app.js"></script>
</body>

</html>