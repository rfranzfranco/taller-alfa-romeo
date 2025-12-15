<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <?= $this->include('partials/head-css') ?>
</head>

<body>
    <div id="layout-wrapper">
        <?= $this->include('partials/menu') ?>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php echo view('partials/page-title', array('pagetitle' => 'Operaciones', 'title' => $title)); ?>

                    <?php if (session()->getFlashdata('message')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong> Éxito! </strong> <?= session()->getFlashdata('message') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#pendientes" role="tab">
                                Pendientes de Asignación <span
                                    class="badge bg-danger rounded-pill ms-1"><?= count($pendientes) ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#proceso" role="tab">
                                Órdenes en Proceso <span
                                    class="badge bg-primary rounded-pill ms-1"><?= count($enProceso) ?></span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content text-muted">
                        <!-- PENDIENTES -->
                        <div class="tab-pane active" id="pendientes" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <table id="pendientesTable"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID Reserva</th>
                                                <th>Fecha Reserva</th>
                                                <th>Cliente</th>
                                                <th>Vehículo</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pendientes as $p): ?>
                                                <tr>
                                                    <td>#<?= $p['id_reserva'] ?></td>
                                                    <td><?= $p['fecha_reserva'] ?></td>
                                                    <td><?= $p['cliente_nombre'] ?></td>
                                                    <td><?= $p['placa'] ?> <small
                                                            class="text-muted">(<?= $p['marca'] ?>)</small></td>
                                                    <td>
                                                        <a href="/ordenestrabajo/assign/<?= $p['id_reserva'] ?>"
                                                            class="btn btn-sm btn-success">
                                                            <i class="ri-user-add-line align-middle me-1"></i> Asignar
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- EN PROCESO -->
                        <div class="tab-pane" id="proceso" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <table id="procesoTable"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID Orden</th>
                                                <th>Fecha Inicio</th>
                                                <th>Cliente</th>
                                                <th>Vehículo</th>
                                                <th>Estado</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($enProceso as $o): ?>
                                                <tr>
                                                    <td>#<?= $o['id_orden'] ?></td>
                                                    <td><?= $o['fecha_inicio_real'] ?></td>
                                                    <td><?= $o['cliente_nombre'] ?></td>
                                                    <td><?= $o['placa'] ?></td>
                                                    <td><span class="badge bg-primary"><?= $o['estado'] ?></span></td>
                                                    <td>
                                                        <a href="/ordenestrabajo/complete/<?= $o['id_orden'] ?>"
                                                            class="btn btn-sm btn-info">
                                                            <i class="ri-check-double-line align-middle me-1"></i> Finalizar
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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
    <?= $this->include('partials/vendor-scripts') ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function () {
            var spanishLanguage = {
                processing: "Procesando...",
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando _START_ a _END_ de _TOTAL_",
                infoEmpty: "Sin registros",
                infoFiltered: "(filtrado de _MAX_)",
                loadingRecords: "Cargando...",
                zeroRecords: "No se encontraron registros",
                emptyTable: "No hay datos disponibles",
                paginate: {
                    first: "Primero",
                    previous: "Anterior",
                    next: "Siguiente",
                    last: "Último"
                }
            };
            $('#pendientesTable').DataTable({ language: spanishLanguage });
            $('#procesoTable').DataTable({ language: spanishLanguage });
        });
    </script>
    <script src="/assets/js/app.js"></script>
</body>

</html>