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
                                    <h4 class="card-title mb-0 flex-grow-1">Crear Nuevo Usuario</h4>
                                </div>
                                <div class="card-body">
                                    <form action="/usuarios" method="post">
                                        <?= csrf_field() ?>
                                        <div class="row g-3">
                                            <!-- Basic User Information -->
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="username"
                                                        name="username" placeholder="Nombre de usuario"
                                                        value="<?= old('username') ?>" required>
                                                    <label for="username">Nombre de Usuario</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Contraseña" required>
                                                    <label for="password">Contraseña</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <select class="form-select" id="rol" name="rol" aria-label="Seleccionar Rol" required onchange="toggleExtraFields()">
                                                        <option value="" disabled selected>Selecciona un rol</option>
                                                        <option value="ADMINISTRADOR" <?= old('rol') == 'ADMINISTRADOR' ? 'selected' : '' ?>>Administrador</option>
                                                        <option value="EMPLEADO" <?= old('rol') == 'EMPLEADO' ? 'selected' : '' ?>>Empleado</option>
                                                        <option value="CLIENTE" <?= old('rol') == 'CLIENTE' ? 'selected' : '' ?>>Cliente</option>
                                                    </select>
                                                    <label for="rol">Rol</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-floating">
                                                    <select class="form-select" id="estado" name="estado" aria-label="Seleccionar Estado" required>
                                                        <option value="1" <?= old('estado') == '1' ? 'selected' : '' ?>>Activo</option>
                                                        <option value="0" <?= old('estado') == '0' ? 'selected' : '' ?>>Inactivo</option>
                                                    </select>
                                                    <label for="estado">Estado</label>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <hr>
                                            </div>

                                            <!-- Common Extra Field: Full Name (Both tables have it) -->
                                            <div class="col-lg-12 d-none" id="commonFields">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control" id="nombre_completo"
                                                        name="nombre_completo" placeholder="Nombre Completo"
                                                        value="<?= old('nombre_completo') ?>">
                                                    <label for="nombre_completo">Nombre Completo</label>
                                                </div>
                                            </div>

                                            <!-- Employee Specific Fields -->
                                            <div id="employeeFields" class="row g-3 d-none">
                                                <div class="col-lg-12">
                                                    <h6 class="fw-semibold">Detalles del Empleado</h6>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <select class="form-select" id="cargo" name="cargo">
                                                            <option value="" disabled selected>Selecciona Cargo</option>
                                                            <option value="MECANICO" <?= old('cargo') == 'MECANICO' ? 'selected' : '' ?>>Mecánico</option>
                                                            <option value="AYUDANTE" <?= old('cargo') == 'AYUDANTE' ? 'selected' : '' ?>>Ayudante</option>
                                                            <option value="LAVADOR" <?= old('cargo') == 'LAVADOR' ? 'selected' : '' ?>>Lavador</option>
                                                            <option value="RECEPCION" <?= old('cargo') == 'RECEPCION' ? 'selected' : '' ?>>Recepción</option>
                                                        </select>
                                                        <label for="cargo">Cargo</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="especialidad"
                                                            name="especialidad" placeholder="Especialidad"
                                                            value="<?= old('especialidad') ?>">
                                                        <label for="especialidad">Especialidad</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <input type="date" class="form-control" id="fecha_contratacion"
                                                            name="fecha_contratacion"
                                                            value="<?= old('fecha_contratacion') ?>">
                                                        <label for="fecha_contratacion">Fecha Contratación</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Client Specific Fields -->
                                            <div id="clientFields" class="row g-3 d-none">
                                                <div class="col-lg-12">
                                                    <h6 class="fw-semibold">Detalles del Cliente</h6>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="ci_nit"
                                                            name="ci_nit" placeholder="CI / NIT"
                                                            value="<?= old('ci_nit') ?>">
                                                        <label for="ci_nit">CI / NIT</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="telefono"
                                                            name="telefono" placeholder="Teléfono"
                                                            value="<?= old('telefono') ?>">
                                                        <label for="telefono">Teléfono</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-floating">
                                                        <input type="email" class="form-control" id="correo"
                                                            name="correo" placeholder="Correo Electrónico"
                                                            value="<?= old('correo') ?>">
                                                        <label for="correo">Correo Electrónico</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="form-floating">
                                                        <input type="text" class="form-control" id="direccion"
                                                            name="direccion" placeholder="Dirección"
                                                            value="<?= old('direccion') ?>">
                                                        <label for="direccion">Dirección</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 mt-4">
                                                <div class="text-end">
                                                    <a href="/usuarios" class="btn btn-light">Cancelar</a>
                                                    <button type="submit" class="btn btn-primary">Crear Usuario</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        function toggleExtraFields() {
                                            const rol = document.getElementById('rol').value;
                                            const commonFields = document.getElementById('commonFields');
                                            const employeeFields = document.getElementById('employeeFields');
                                            const clientFields = document.getElementById('clientFields');

                                            // Reset visibility
                                            commonFields.classList.add('d-none');
                                            employeeFields.classList.add('d-none');
                                            clientFields.classList.add('d-none');

                                            // Client Logic
                                            if (rol === 'CLIENTE') {
                                                commonFields.classList.remove('d-none');
                                                clientFields.classList.remove('d-none');
                                            }
                                            // Employee Logic
                                            else if (rol === 'EMPLEADO') {
                                                commonFields.classList.remove('d-none');
                                                employeeFields.classList.remove('d-none');
                                            }
                                        }

                                        // Run on load in case of validation error return
                                        document.addEventListener('DOMContentLoaded', toggleExtraFields);
                                    </script>
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