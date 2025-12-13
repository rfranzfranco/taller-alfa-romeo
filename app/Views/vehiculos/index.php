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
                                        <li class="breadcrumb-item active">Vehículos</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Lista de Vehículos</h4>
                                    <div class="flex-shrink-0">
                                        <a href="/vehiculos/new"
                                            class="btn btn-success btn-label waves-effect waves-light">
                                            <i class="ri-car-line label-icon align-middle fs-16 me-2"></i> Nuevo
                                            Vehículo
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="vehiculosTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Placa</th>
                                                <th>Propietario</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Año</th>
                                                <th>Color</th>
                                                <th>Acciones</th>
                                            </tr>
                                            <tr>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar placa"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar propietario"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar marca"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar modelo"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar año"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar color"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($vehiculos) && is_array($vehiculos)): ?>
                                                <?php foreach ($vehiculos as $vehiculo): ?>
                                                    <tr>
                                                        <td><span class="badge bg-light text-body fs-12 fw-medium"><?= esc($vehiculo['placa']) ?></span></td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title bg-info-subtle text-info rounded-circle">
                                                                            <?= strtoupper(substr($vehiculo['nombre_cliente'] ?? 'N', 0, 1)) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1"><?= esc($vehiculo['nombre_cliente'] ?? 'Sin asignar') ?></div>
                                                            </div>
                                                        </td>
                                                        <td><?= esc($vehiculo['marca']) ?></td>
                                                        <td><?= esc($vehiculo['modelo']) ?> <small class="text-muted">(<?= esc($vehiculo['tipo_motor']) ?>)</small></td>
                                                        <td><?= esc($vehiculo['anio']) ?></td>
                                                        <td><?= esc($vehiculo['color']) ?></td>
                                                        <td>
                                                            <div class="hstack gap-3 flex-wrap">
                                                                <a href="/vehiculos/<?= $vehiculo['id_vehiculo'] ?>"
                                                                    class="link-info fs-15" title="Ver detalles"><i
                                                                        class="ri-eye-line"></i></a>
                                                                <a href="/vehiculos/<?= $vehiculo['id_vehiculo'] ?>/edit"
                                                                    class="link-success fs-15" title="Editar"><i
                                                                        class="ri-edit-2-line"></i></a>
                                                                <form action="/vehiculos/<?= $vehiculo['id_vehiculo'] ?>"
                                                                    method="post" style="display:inline-block;"
                                                                    onsubmit="return confirm('¿Eliminar vehículo?');">
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
            var table = $('#vehiculosTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });

            $('#vehiculosTable thead tr:eq(1) th').each(function(i) {
                $('input', this).on('keyup change', function() {
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