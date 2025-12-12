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
                                        <li class="breadcrumb-item active">Usuarios</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Lista de Usuarios</h4>
                                    <div class="flex-shrink-0">
                                        <a href="/usuarios/new"
                                            class="btn btn-success btn-label waves-effect waves-light">
                                            <i class="ri-add-line label-icon align-middle fs-16 me-2"></i> Nuevo Usuario
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Nombre de Usuario</th>
                                                    <th scope="col">Rol</th>
                                                    <th scope="col">Estado</th>
                                                    <th scope="col">Fecha Creación</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($usuarios) && is_array($usuarios)): ?>
                                                    <?php foreach ($usuarios as $user): ?>
                                                        <tr>
                                                            <td><a href="#" class="fw-medium">#<?= $user['id_usuario'] ?></a>
                                                            </td>
                                                            <td><?= esc($user['username']) ?></td>
                                                            <td>
                                                                <span
                                                                    class="badge bg-info-subtle text-info text-uppercase"><?= esc($user['rol']) ?></span>
                                                            </td>
                                                            <td>
                                                                <?php if ($user['estado'] == '1'): ?>
                                                                    <span
                                                                        class="badge bg-success-subtle text-success text-uppercase">Activo</span>
                                                                <?php else: ?>
                                                                    <span
                                                                        class="badge bg-danger-subtle text-danger text-uppercase">Inactivo</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td><?= $user['fecha_creacion'] ?></td>
                                                            <td>
                                                                <div class="hstack gap-3 flex-wrap">
                                                                    <a href="/usuarios/<?= $user['id_usuario'] ?>/edit"
                                                                        class="link-success fs-15"><i
                                                                            class="ri-edit-2-line"></i></a>

                                                                    <form action="/usuarios/<?= $user['id_usuario'] ?>"
                                                                        method="post" style="display:inline-block;"
                                                                        onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
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
                                                        <td colspan="6" class="text-center">No se encontraron usuarios</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?= $this->include('partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?= $this->include('partials/customizer') ?>
    <?= $this->include('partials/vendor-scripts') ?>
    <script src="/assets/js/app.js"></script>
</body>

</html>