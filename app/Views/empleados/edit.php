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
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        <i class="ri-edit-line me-2"></i>Editar Empleado: <?= esc($empleado['nombre_completo']) ?>
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form action="/empleados/<?= $empleado['id_empleado'] ?>" method="post">
                                        <input type="hidden" name="_method" value="PUT">
                                        <?= csrf_field() ?>
                                        
                                        <div class="row g-3">
                                            <!-- Usuario Asociado (solo lectura) -->
                                            <div class="col-lg-6">
                                                <label for="id_usuario" class="form-label">Usuario del Sistema</label>
                                                <input type="text" class="form-control" value="ID: <?= esc($empleado['id_usuario']) ?>" disabled>
                                                <input type="hidden" name="id_usuario" value="<?= $empleado['id_usuario'] ?>">
                                                <div class="form-text">El usuario asociado no se puede cambiar</div>
                                            </div>

                                            <!-- Nombre Completo -->
                                            <div class="col-lg-6">
                                                <label for="nombre_completo" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" 
                                                       placeholder="Ej: Juan Pérez García" 
                                                       value="<?= old('nombre_completo', $empleado['nombre_completo']) ?>" required>
                                            </div>

                                            <!-- Cargo -->
                                            <div class="col-lg-6">
                                                <label for="cargo" class="form-label">Cargo <span class="text-danger">*</span></label>
                                                <select class="form-select" id="cargo" name="cargo" required>
                                                    <option value="">Seleccione un cargo...</option>
                                                    <?php 
                                                    $cargos = ['Técnico Mecánico', 'Técnico Eléctrico', 'Técnico de Diagnóstico', 'Jefe de Taller', 'Recepcionista', 'Auxiliar'];
                                                    $cargoActual = old('cargo', $empleado['cargo']);
                                                    foreach ($cargos as $cargo): 
                                                    ?>
                                                        <option value="<?= $cargo ?>" <?= $cargoActual == $cargo ? 'selected' : '' ?>><?= $cargo ?></option>
                                                    <?php endforeach; ?>
                                                    <?php if (!in_array($cargoActual, $cargos) && !empty($cargoActual)): ?>
                                                        <option value="<?= esc($cargoActual) ?>" selected><?= esc($cargoActual) ?></option>
                                                    <?php endif; ?>
                                                </select>
                                            </div>

                                            <!-- Especialidad -->
                                            <div class="col-lg-6">
                                                <label for="especialidad" class="form-label">Especialidad</label>
                                                <input type="text" class="form-control" id="especialidad" name="especialidad" 
                                                       placeholder="Ej: Motor y Transmisión, Sistema Eléctrico" 
                                                       value="<?= old('especialidad', $empleado['especialidad']) ?>">
                                                <div class="form-text">Opcional: Área de especialización del empleado</div>
                                            </div>

                                            <!-- Fecha de Contratación -->
                                            <div class="col-lg-6">
                                                <label for="fecha_contratacion" class="form-label">Fecha de Contratación</label>
                                                <input type="date" class="form-control" id="fecha_contratacion" name="fecha_contratacion" 
                                                       value="<?= old('fecha_contratacion', $empleado['fecha_contratacion']) ?>">
                                            </div>

                                            <!-- Botones -->
                                            <div class="col-12 mt-4">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <a href="/empleados" class="btn btn-light">
                                                        <i class="ri-close-line me-1"></i>Cancelar
                                                    </a>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="ri-save-line me-1"></i>Guardar Cambios
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
