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

                    <?php echo view('partials/page-title', array('pagetitle' => 'Operaciones', 'title' => $title)); ?>

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
                                    <h5 class="card-title mb-0 flex-grow-1">Mis Reservas</h5>
                                    <div>
                                        <a href="/reservas/new" class="btn btn-primary">Nueva Reserva</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="reservasData" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Fecha Reserva</th>
                                                <?php if (session()->get('rol') !== 'CLIENTE'): ?>
                                                    <th>Cliente</th>
                                                <?php endif; ?>
                                                <th>Vehículo (Placa)</th>
                                                <th>Estado</th>
                                                <th>Acciónes</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reservas as $reserva): ?>
                                                <tr>
                                                    <td><?= $reserva['id_reserva'] ?></td>
                                                    <td><?= $reserva['fecha_reserva'] ?></td>
                                                    <?php if (session()->get('rol') !== 'CLIENTE'): ?>
                                                        <td><?= $reserva['cliente_nombre'] ?? 'N/A' ?></td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <span class="badge bg-info"><?= $reserva['placa'] ?></span>
                                                        <?php if(isset($reserva['marca'])): ?> 
                                                            <small class="text-muted"><?= $reserva['marca'] ?> <?= $reserva['modelo'] ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                            $badgeClass = 'bg-primary';
                                                            if($reserva['estado'] == 'PENDIENTE') $badgeClass = 'bg-warning';
                                                            if($reserva['estado'] == 'CANCELADA') $badgeClass = 'bg-danger';
                                                            if($reserva['estado'] == 'TERMINADO') $badgeClass = 'bg-success';
                                                        ?>
                                                        <span class="badge <?= $badgeClass ?>"><?= $reserva['estado'] ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown d-inline-block">
                                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <!-- RF-13: Cancel if pending -->
                                                                <?php if($reserva['estado'] == 'PENDIENTE'): ?>
                                                                <li>
                                                                    <form action="/reservas/cancel/<?= $reserva['id_reserva'] ?>" method="post" style="display:inline;">
                                                                        <?= csrf_field() ?>
                                                                        <button type="submit" class="dropdown-item remove-item-btn" onclick="return confirm('¿Está seguro de cancelar esta reserva?');">
                                                                            <i class="ri-close-circle-fill align-bottom me-2 text-danger"></i> Cancelar
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <?php endif; ?>
                                                                
                                                                <?php if (session()->get('rol') !== 'CLIENTE' && $reserva['estado'] == 'PENDIENTE'): ?>
                                                                    <li>
                                                                        <a href="#" class="dropdown-item" onclick="alert('Funcionalidad de Asignación en Desarrollo (RF-05)')">
                                                                            <i class="ri-user-settings-line align-bottom me-2 text-muted"></i> Asignar
                                                                        </a>
                                                                    </li>
                                                                <?php endif; ?>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#reservasData').DataTable();
        });
    </script>
    <script src="/assets/js/app.js"></script>
</body>

</html>
