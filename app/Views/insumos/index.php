<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <?= $this->include('partials/head-css') ?>
    <?= $this->include('partials/datatables-css') ?>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?= $this->include('partials/menu') ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Result Notification -->
                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong> Éxito! </strong> <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> Error! </strong> <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= $title ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Gestión</a></li>
                                        <li class="breadcrumb-item active">Inventario</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Lista de Insumos</h4>
                                    <div class="flex-shrink-0">
                                        <a href="/insumos/new"
                                            class="btn btn-success btn-label waves-effect waves-light">
                                            <i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Nuevo Insumo
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="insumosTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Precio (Bs)</th>
                                                <th>Stock Actual</th>
                                                <th>Stock Mínimo</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                            <tr>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar código"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar nombre"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar precio"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar stock"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar mínimo"></th>
                                                <th>
                                                    <select class="form-select form-select-sm column-filter">
                                                        <option value="">Todos</option>
                                                        <option value="Stock Bajo">Stock Bajo</option>
                                                        <option value="En Stock">En Stock</option>
                                                    </select>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($insumos) && is_array($insumos)): ?>
                                                <?php foreach ($insumos as $insumo): ?>
                                                    <tr>
                                                        <td><span class="fw-medium"><?= esc($insumo['codigo']) ?></span></td>
                                                        <td>
                                                            <h5 class="fs-14 mb-1"><?= esc($insumo['nombre']) ?></h5>
                                                            <p class="text-muted mb-0">
                                                                <?= esc(substr($insumo['descripcion'] ?? '', 0, 30)) ?>...
                                                            </p>
                                                        </td>
                                                        <td><?= number_format($insumo['precio_venta'], 2) ?></td>
                                                        <td><span class="fs-14"><?= $insumo['stock_actual'] ?></span></td>
                                                        <td><?= $insumo['stock_minimo'] ?></td>
                                                        <td>
                                                            <?php if ($insumo['stock_actual'] <= $insumo['stock_minimo']): ?>
                                                                <span class="badge bg-danger-subtle text-danger text-uppercase">Stock Bajo</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-success-subtle text-success text-uppercase">En Stock</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <div class="hstack gap-3 flex-wrap">
                                                                <a href="/insumos/<?= $insumo['id_insumo'] ?>/edit"
                                                                    class="link-success fs-15" title="Editar"><i
                                                                        class="ri-edit-2-line"></i></a>
                                                                <form action="/insumos/<?= $insumo['id_insumo'] ?>"
                                                                    method="post" style="display:inline-block;"
                                                                    onsubmit="return confirm('¿Estás seguro de eliminar este insumo?');">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <?= csrf_field() ?>
                                                                    <button type="submit" class="link-danger fs-15"
                                                                        style="border:none; background:none; padding:0;" title="Eliminar"><i
                                                                            class="ri-delete-bin-line"></i></button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
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
    <?= $this->include('partials/datatables-scripts') ?>
    
    <script>
        $(document).ready(function() {
            var table = $('#insumosTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });

            $('#insumosTable thead tr:eq(1) th').each(function(i) {
                $('input, select', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
            });
        });
    </script>
    <script src="/assets/js/app.js"></script>
</body>

</html>