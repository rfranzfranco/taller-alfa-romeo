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
                            <ul class="mb-0">
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
                                        <li class="breadcrumb-item"><a href="/empleados">Personal</a></li>
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
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        <i class="ri-user-add-line me-2"></i>Registrar Nuevo Empleado
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form action="/empleados" method="post">
                                        <?= csrf_field() ?>
                                        
                                        <div class="row g-3">
                                            <!-- Seleccionar Usuario -->
                                            <div class="col-lg-6">
                                                <label for="id_usuario" class="form-label">Usuario del Sistema <span class="text-danger">*</span></label>
                                                <select class="form-select" id="id_usuario" name="id_usuario" required>
                                                    <option value="">Seleccione un usuario...</option>
                                                    <?php if (!empty($usuarios)): ?>
                                                        <?php foreach ($usuarios as $usuario): ?>
                                                            <option value="<?= $usuario['id_usuario'] ?>" <?= old('id_usuario') == $usuario['id_usuario'] ? 'selected' : '' ?>>
                                                                <?= esc($usuario['username']) ?> (<?= esc($usuario['rol']) ?>)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                                <div class="form-text">Seleccione el usuario que se asociará a este empleado</div>
                                            </div>

                                            <!-- Nombre Completo -->
                                            <div class="col-lg-6">
                                                <label for="nombre_completo" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" 
                                                       placeholder="Ej: Juan Pérez García" value="<?= old('nombre_completo') ?>" required>
                                            </div>

                                            <!-- Cargo -->
                                            <div class="col-lg-6">
                                                <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                                                <select class="form-select" id="cargo" name="cargo" required>
                                                    <option value="">Seleccione un cargo...</option>
                                                    <option value="Técnico Mecánico" <?= old('cargo') == 'Técnico Mecánico' ? 'selected' : '' ?>>Técnico Mecánico</option>
                                                    <option value="Técnico Eléctrico" <?= old('cargo') == 'Técnico Eléctrico' ? 'selected' : '' ?>>Técnico Eléctrico</option>
                                                    <option value="Técnico de Diagnóstico" <?= old('cargo') == 'Técnico de Diagnóstico' ? 'selected' : '' ?>>Técnico de Diagnóstico</option>
                                                    <option value="Jefe de Taller" <?= old('cargo') == 'Jefe de Taller' ? 'selected' : '' ?>>Jefe de Taller</option>
                                                    <option value="Recepcionista" <?= old('cargo') == 'Recepcionista' ? 'selected' : '' ?>>Recepcionista</option>
                                                    <option value="Auxiliar" <?= old('cargo') == 'Auxiliar' ? 'selected' : '' ?>>Auxiliar</option>
                                                </select>
                                            </div>

                                            <!-- Especialidad -->
                                            <div class="col-lg-6">
                                                <label for="especialidad" class="form-label">Especialidad</label>
                                                <input type="text" class="form-control" id="especialidad" name="especialidad" 
                                                       placeholder="Ej: Motor y Transmisión, Sistema Eléctrico" value="<?= old('especialidad') ?>">
                                                <div class="form-text">Opcional: Área de especialización del empleado</div>
                                            </div>

                                            <!-- Fecha de Contratación -->
                                            <div class="col-lg-6">
                                                <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
                                                <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" 
                                                       value="<?= old('fecha_contratacion', date('Y-m-d')) ?>">
                                            </div>

                                            <!-- Botones -->
                                            <div class="col-12 mt-4">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <a href="/empleados" class="btn btn-light">
                                                        <i class="ri-close-line me-1"></i>Cancelar
                                                    </a>
                                                    <button type="submit" class="btn btn-success">
                                                        <i class="ri-save-line me-1"></i>Guardar Empleado
                                                    </button>
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
