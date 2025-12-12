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

                    <!-- Notification -->
                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> Error! </strong>
                            <ul>
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach ?>
                            </ul>
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
                                        <li class="breadcrumb-item"><a href="/clientes">Clientes</a></li>
                                        <li class="breadcrumb-item active">Editar</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Editar Cliente:
                                        <?= esc($cliente['nombre_completo']) ?></h4>
                                </div>
                                <div class="card-body">
                                    <form action="/clientes/<?= $cliente['id_cliente'] ?>" method="post">
                                        <input type="hidden" name="_method" value="PUT">
                                        <?= csrf_field() ?>
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="nombre_completo"
                                                        name="nombre_completo" placeholder="Nombre Completo"
                                                        value="<?= old('nombre_completo', $cliente['nombre_completo']) ?>"
                                                        required>
                                                    <label for="nombre_completo">Nombre Completo</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="ci_nit" name="ci_nit"
                                                        placeholder="CI / NIT"
                                                        value="<?= old('ci_nit', $cliente['ci_nit']) ?>" required>
                                                    <label for="ci_nit">CI / NIT</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="telefono"
                                                        name="telefono" placeholder="Teléfono"
                                                        value="<?= old('telefono', $cliente['telefono']) ?>">
                                                    <label for="telefono">Teléfono</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control" id="correo" name="correo"
                                                        placeholder="Correo Electrónico"
                                                        value="<?= old('correo', $cliente['correo']) ?>">
                                                    <label for="correo">Correo Electrónico</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="direccion"
                                                        name="direccion" placeholder="Dirección"
                                                        value="<?= old('direccion', $cliente['direccion']) ?>">
                                                    <label for="direccion">Dirección</label>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-4">
                                                <div class="text-end">
                                                    <a href="/clientes" class="btn btn-light">Cancelar</a>
                                                    <button type="submit" class="btn btn-primary">Guardar
                                                        Cambios</button>
                                                </div>
                                            </div>
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

    <?= $this->include('partials/customizer') ?>
    <?= $this->include('partials/vendor-scripts') ?>
    <script src="/assets/js/app.js"></script>
</body>

</html>