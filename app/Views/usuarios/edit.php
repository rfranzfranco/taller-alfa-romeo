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
                                        <li class="breadcrumb-item"><a href="/usuarios">Usuarios</a></li>
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
                                    <h4 class="card-title mb-0 flex-grow-1">Editar Usuario:
                                        <?= esc($usuario['username']) ?>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form action="/usuarios/<?= $usuario['id_usuario'] ?>" method="post">
                                        <input type="hidden" name="_method" value="PUT">
                                        <?= csrf_field() ?>
                                        <div class="row g-3">
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Nombre de usuario"
                                                        value="<?= old('username', $usuario['username']) ?>" required>
                                                    <label for="username">Nombre de Usuario</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Contraseña">
                                                    <label for="password">Contraseña (Dejar en blanco para mantener
                                                        actual)</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <select class="form-select" id="rol" name="rol"
                                                        aria-label="Seleccionar Rol" required>
                                                        <option value="" disabled>Selecciona un rol</option>
                                                        <option value="ADMINISTRADOR" <?= old('rol', $usuario['rol']) == 'ADMINISTRADOR' ? 'selected' : '' ?>>
                                                            Administrador</option>
                                                        <option value="EMPLEADO" <?= old('rol', $usuario['rol']) == 'EMPLEADO' ? 'selected' : '' ?>>Empleado
                                                        </option>
                                                        <option value="CLIENTE" <?= old('rol', $usuario['rol']) == 'CLIENTE' ? 'selected' : '' ?>>Cliente
                                                        </option>
                                                    </select>
                                                    <label for="rol">Rol</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <select class="form-select" id="estado" name="estado"
                                                        aria-label="Seleccionar Estado" required>
                                                        <option value="1" <?= old('estado', $usuario['estado']) == '1' ? 'selected' : '' ?>>Activo</option>
                                                        <option value="0" <?= old('estado', $usuario['estado']) == '0' ? 'selected' : '' ?>>Inactivo</option>
                                                    </select>
                                                    <label for="estado">Estado</label>
                                                </div>
                                            </div>
                                            <div class="col-12 mt-4">
                                                <div class="text-end">
                                                    <a href="/usuarios" class="btn btn-light">Cancelar</a>
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