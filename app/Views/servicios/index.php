<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

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

                    <?php echo view('partials/page-title', array('pagetitle' => 'Gestión', 'title' => $title)); ?>

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
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h5 class="card-title mb-0 flex-grow-1">Lista de Servicios</h5>
                                    <div>
                                        <a href="/servicios/new" class="btn btn-primary">Nuevo Servicio</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="serviciosData"
                                        class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Descripción</th>
                                                <th>Costo Mano de Obra</th>
                                                <th>Tiempo Estimado (min)</th>
                                                <th>Acciónes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($servicios as $servicio): ?>
                                                <tr>
                                                    <td><?= $servicio['id_servicio'] ?></td>
                                                    <td><?= $servicio['nombre'] ?></td>
                                                    <td><?= $servicio['descripcion'] ?? '-' ?></td>
                                                    <td>Bs. <?= number_format($servicio['costo_mano_obra'], 2) ?></td>
                                                    <td><?= $servicio['tiempo_estimado'] ?> min</td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown"
                                                                type="button" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a href="/servicios/<?= $servicio['id_servicio'] ?>/edit"
                                                                        class="dropdown-item"><i
                                                                            class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                                        Editar</a></li>
                                                                <li>
                                                                    <a href="/servicios/delete/<?= $servicio['id_servicio'] ?>"
                                                                        class="dropdown-item remove-item-btn"
                                                                        onclick="return confirm('¿Está seguro de eliminar este elemento?');">
                                                                        <i
                                                                            class="ri-delete-bin-fill align-bottom me-2 text-muted"></i>
                                                                        Eliminar
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
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
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?= $this->include('partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?= $this->include('partials/vendor-scripts') ?>

    <!-- videocall handling -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#serviciosData').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                }
            });
        });
    </script>
    <script src="/assets/js/app.js"></script>
</body>

</html>