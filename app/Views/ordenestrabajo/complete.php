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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Finalizar Servicio (Orden
                                        #<?= $orden['id_orden'] ?>)</h4>
                                </div>
                                <div class="card-body">
                                    <?php if (session()->getFlashdata('error')): ?>
                                        <div class="alert alert-danger">
                                            <?= session()->getFlashdata('error') ?>
                                        </div>
                                    <?php endif; ?>
                                    <form action="/ordenestrabajo/finalize" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id_orden" value="<?= $orden['id_orden'] ?>">

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Vehículo</label>
                                                <input type="text" class="form-control" value="<?= $orden['placa'] ?>"
                                                    readonly disabled>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Inicio Real</label>
                                                <input type="text" class="form-control"
                                                    value="<?= $orden['fecha_inicio_real'] ?>" readonly disabled>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="observaciones_tecnicas" class="form-label">Observaciones
                                                Técnicas <span class="text-danger">*</span></label>
                                            <textarea class="form-control" id="observaciones_tecnicas"
                                                name="observaciones_tecnicas" rows="3" required
                                                placeholder="Describa el trabajo realizado, recomendaciones, etc."></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Insumos Utilizados</label>
                                            <div id="insumos-container">
                                                <!-- Dynamic Rows -->
                                                <div class="row mb-2 insumo-row">
                                                    <div class="col-md-6">
                                                        <select class="form-select" name="insumos[]">
                                                            <option value="">Seleccione Insumo...</option>
                                                            <?php foreach ($insumos as $insumo): ?>
                                                                <option value="<?= $insumo['id_insumo'] ?>">
                                                                    <?= $insumo['nombre'] ?> (Stock:
                                                                    <?= $insumo['stock_actual'] ?>
                                                                    <?= $insumo['unidad_medida'] ?? 'unidades' ?>)
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="number" class="form-control" name="cantidades[]"
                                                            placeholder="Cantidad" min="0" step="0.01">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button"
                                                            class="btn btn-danger btn-icon waves-effect waves-light remove-row"><i
                                                                class="ri-delete-bin-5-line"></i></button>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" id="add-insumo"
                                                class="btn btn-soft-secondary btn-sm mt-2"><i
                                                    class="ri-add-line align-middle me-1"></i> Agregar Insumo</button>
                                        </div>

                                        <div class="text-end mt-4">
                                            <a href="/ordenestrabajo" class="btn btn-light">Cancelar</a>
                                            <button type="submit" class="btn btn-success">Finalizar Orden</button>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Add Row
            $('#add-insumo').click(function () {
                var row = $('.insumo-row').first().clone();
                row.find('input').val(''); // Clear input
                row.find('select').val(''); // Clear select
                $('#insumos-container').append(row);
            });

            // Remove Row
            $(document).on('click', '.remove-row', function () {
                if ($('.insumo-row').length > 1) {
                    $(this).closest('.insumo-row').remove();
                } else {
                    alert('Debe haber al menos una fila de insumos (o déjela vacía si no usó nada).');
                }
            });
        });
    </script>
    <script src="/assets/js/app.js"></script>
</body>

</html>