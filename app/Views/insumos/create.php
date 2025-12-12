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
                                        <li class="breadcrumb-item"><a href="/insumos">Inventario</a></li>
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
                                    <h4 class="card-title mb-0 flex-grow-1">Registrar Nuevo Insumo</h4>
                                </div>
                                <div class="card-body">
                                    <form action="/insumos" method="post">
                                        <?= csrf_field() ?>
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="codigo" name="codigo"
                                                        placeholder="Código" value="<?= old('codigo') ?>" required>
                                                    <label for="codigo">Código</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                                        placeholder="Nombre del insumo" value="<?= old('nombre') ?>"
                                                        required>
                                                    <label for="nombre">Nombre</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-floating">
                                                    <textarea class="form-control" placeholder="Descripción"
                                                        id="descripcion" name="descripcion"
                                                        style="height: 100px"><?= old('descripcion') ?></textarea>
                                                    <label for="descripcion">Descripción</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <input type="number" step="0.01" class="form-control"
                                                        id="precio_venta" name="precio_venta"
                                                        placeholder="Precio de Venta" value="<?= old('precio_venta') ?>"
                                                        required>
                                                    <label for="precio_venta">Precio Venta (Bs)</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="stock_actual"
                                                        name="stock_actual" placeholder="Stock Actual"
                                                        value="<?= old('stock_actual', 0) ?>" required>
                                                    <label for="stock_actual">Stock Actual</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control" id="stock_minimo"
                                                        name="stock_minimo" placeholder="Stock Mínimo"
                                                        value="<?= old('stock_minimo', 5) ?>" required>
                                                    <label for="stock_minimo">Stock Mínimo</label>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-4">
                                                <div class="text-end">
                                                    <a href="/insumos" class="btn btn-light">Cancelar</a>
                                                    <button type="submit" class="btn btn-primary">Guardar
                                                        Insumo</button>
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