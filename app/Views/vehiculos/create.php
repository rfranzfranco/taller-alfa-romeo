<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <?= $this->include('partials/head-css') ?>
    <link href="/assets/libs/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" type="text/css" />
    <style>
        /* Fix for Choices.js transparent dropdown */
        .choices__list--dropdown,
        .choices__list[aria-expanded] {
            background-color: #ffffff !important;
            z-index: 1000 !important;
            /* Ensure it stays on top */
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        /* Fix for dark mode if applicable, though we default to light for now */
        [data-layout-mode="dark"] .choices__list--dropdown,
        [data-layout-mode="dark"] .choices__list[aria-expanded] {
            background-color: #292e32 !important;
            border-color: #32383e;
        }

        /* Fix text cutoff */
        .choices__list--dropdown .choices__item {
            padding-left: 25px !important;
            font-size: 0.9rem;
            /* Match form font size */
        }
    </style>
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
                                        <li class="breadcrumb-item"><a href="/vehiculos">Vehículos</a></li>
                                        <li class="breadcrumb-item active">Nuevo</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">Registrar Nuevo Vehículo</h4>
                                </div>
                                <div class="card-body">
                                    <form action="/vehiculos" method="post">
                                        <?= csrf_field() ?>
                                        <div class="row g-3">
                                            <?php if (empty($isCliente)): ?>
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="id_cliente" class="form-label">Propietario
                                                        (Cliente)</label>
                                                    <select class="form-control" data-choices name="id_cliente"
                                                        id="id_cliente" required>
                                                        <option value="">Seleccionar Cliente</option>
                                                        <?php foreach ($clientes as $client): ?>
                                                            <option value="<?= $client['id_cliente'] ?>"
                                                                <?= old('id_cliente') == $client['id_cliente'] ? 'selected' : '' ?>>
                                                                <?= esc($client['nombre_completo']) ?> -
                                                                <?= esc($client['ci_nit']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php else: ?>
                                            <input type="hidden" name="id_cliente" value="<?= $clienteId ?>">
                                            <?php endif; ?>

                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="placa" name="placa"
                                                        placeholder="Placa" value="<?= old('placa') ?>" required
                                                        style="text-transform: uppercase;">
                                                    <label for="placa">Placa</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="marca" name="marca"
                                                        placeholder="Marca" value="<?= old('marca') ?>" required>
                                                    <label for="marca">Marca</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="modelo" name="modelo"
                                                        placeholder="Modelo" value="<?= old('modelo') ?>" required>
                                                    <label for="modelo">Modelo</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="anio" name="anio"
                                                        placeholder="Año" value="<?= old('anio') ?>" required>
                                                    <label for="anio">Año</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <select class="form-select" id="tipo_motor" name="tipo_motor"
                                                        required>
                                                        <option value="" disabled selected>Selecciona Motor</option>
                                                        <option value="Gasolina" <?= old('tipo_motor') == 'Gasolina' ? 'selected' : '' ?>>Gasolina</option>
                                                        <option value="Diesel" <?= old('tipo_motor') == 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                                                        <option value="Híbrido" <?= old('tipo_motor') == 'Híbrido' ? 'selected' : '' ?>>Híbrido</option>
                                                        <option value="Eléctrico" <?= old('tipo_motor') == 'Eléctrico' ? 'selected' : '' ?>>Eléctrico</option>
                                                        <option value="GNV" <?= old('tipo_motor') == 'GNV' ? 'selected' : '' ?>>GNV</option>
                                                    </select>
                                                    <label for="tipo_motor">Tipo de Motor</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="color" name="color"
                                                        placeholder="Color" value="<?= old('color') ?>" required>
                                                    <label for="color">Color</label>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-4">
                                                <div class="text-end">
                                                    <a href="/vehiculos" class="btn btn-light">Cancelar</a>
                                                    <button type="submit" class="btn btn-primary">Registrar
                                                        Vehículo</button>
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
    <!-- choices js -->
    <script src="/assets/libs/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="/assets/js/app.js"></script>
</body>

</html>