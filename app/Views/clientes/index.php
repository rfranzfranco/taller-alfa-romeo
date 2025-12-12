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
                                        <li class="breadcrumb-item active">Clientes</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Lista de Clientes</h4>
                                    <div class="flex-shrink-0">
                                        <!-- Redirects to User creation with Client role hint -->
                                        <a href="/usuarios/new"
                                            class="btn btn-success btn-label waves-effect waves-light">
                                            <i class="ri-user-add-line label-icon align-middle fs-16 me-2"></i> Nuevo
                                            Cliente
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        <table class="table table-hover table-centered align-middle table-nowrap mb-0">
                                            <thead class="text-muted table-light">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Nombre Completo</th>
                                                    <th scope="col">CI / NIT</th>
                                                    <th scope="col">Teléfono</th>
                                                    <th scope="col">Correo</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($clientes) && is_array($clientes)): ?>
                                                    <?php foreach ($clientes as $cliente): ?>
                                                        <tr>
                                                            <td><a href="#" class="fw-medium">#<?= $cliente['id_cliente'] ?></a>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-grow-1">
                                                                        <?= esc($cliente['nombre_completo']) ?></div>
                                                                </div>
                                                            </td>
                                                            <td><?= esc($cliente['ci_nit']) ?></td>
                                                            <td><?= esc($cliente['telefono']) ?></td>
                                                            <td><?= esc($cliente['correo']) ?></td>
                                                            <td>
                                                                <div class="hstack gap-3 flex-wrap">
                                                                    <a href="/clientes/<?= $cliente['id_cliente'] ?>/edit"
                                                                        class="link-success fs-15"><i
                                                                            class="ri-edit-2-line"></i></a>
                                                                    <form action="/clientes/<?= $cliente['id_cliente'] ?>"
                                                                        method="post" style="display:inline-block;"
                                                                        onsubmit="return confirm('¿Eliminar registro de cliente? Esto no elimina el usuario de acceso.');">
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
                                                        <td colspan="6" class="text-center">No se encontraron clientes
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