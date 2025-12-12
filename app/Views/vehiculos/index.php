<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <?= $this->include('partials/head-css') ?>
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
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">Placa</th>
                                                    <th scope="col">Propietario</th>
                                                    <th scope="col">Vehículo</th>
                                                    <th scope="col">Año</th>
                                                    <th scope="col">Color</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($vehiculos) && is_array($vehiculos)): ?>
                                                    <?php foreach ($vehiculos as $vehiculo): ?>
                                                        <tr>
                                                            <td><span
                                                                    class="badge bg-light text-body fs-12 fw-medium"><?= esc($vehiculo['placa']) ?></span>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">
                                                                        <?= esc($vehiculo['nombre_cliente']) ?></div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <h5 class="fs-14 mb-1"><?= esc($vehiculo['marca']) ?></h5>
                                                                <p class="text-muted mb-0"><?= esc($vehiculo['modelo']) ?>
                                                                    (<?= esc($vehiculo['tipo_motor']) ?>)</p>
                                                            </td>
                                                            <td><?= esc($vehiculo['anio']) ?></td>
                                                            <td><?= esc($vehiculo['color']) ?></td>
                                                            <td>
                                                                <div class="hstack gap-3 flex-wrap">
                                                                    <a href="/vehiculos/<?= $vehiculo['id_vehiculo'] ?>/edit"
                                                                        class="link-success fs-15"><i
                                                                            class="ri-edit-2-line"></i></a>
                                                                    <form action="/vehiculos/<?= $vehiculo['id_vehiculo'] ?>"
                                                                        method="post" style="display:inline-block;"
                                                                        onsubmit="return confirm('¿Eliminar vehículo?');">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <button type="submit" class="link-danger fs-15"
                                                                            style="border:none; background:none; padding:0;"><i
                                                                                class="ri-delete-bin-line"></i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No se encontraron vehículos
                                                            registrados</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
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
    <script src="/assets/js/app.js"></script>
</body>

</html>