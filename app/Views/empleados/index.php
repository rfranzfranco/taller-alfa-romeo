<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <?= $this->include('partials/head-css') ?>
    <?= $this->include('partials/datatables-css') ?>
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
                                        <li class="breadcrumb-item active">Personal</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row">
                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Total Empleados</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <span class="counter-value" data-target="<?= count($empleados ?? []) ?>"><?= count($empleados ?? []) ?></span>
                                            </h4>
                                            <a href="#" class="text-decoration-underline text-muted">Ver todos</a>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-primary-subtle rounded fs-3">
                                                <i class="ri-team-line text-primary"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6">
                            <div class="card card-animate">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Técnicos</p>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-end justify-content-between mt-4">
                                        <div>
                                            <h4 class="fs-22 fw-semibold ff-secondary mb-4">
                                                <?php 
                                                $tecnicos = array_filter($empleados ?? [], function($e) {
                                                    return stripos($e['cargo'], 'técnico') !== false || stripos($e['cargo'], 'tecnico') !== false;
                                                });
                                                ?>
                                                <span class="counter-value"><?= count($tecnicos) ?></span>
                                            </h4>
                                            <span class="badge bg-success">Activos</span>
                                        </div>
                                        <div class="avatar-sm flex-shrink-0">
                                            <span class="avatar-title bg-success-subtle rounded fs-3">
                                                <i class="ri-tools-line text-success"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header align-items-center d-flex">
                                    <h4 class="card-title mb-0 flex-grow-1">
                                        <i class="ri-team-line me-2"></i>Lista de Personal
                                    </h4>
                                    <div class="flex-shrink-0">
                                        <a href="/empleados/new" class="btn btn-success btn-label waves-effect waves-light">
                                            <i class="ri-user-add-line label-icon align-middle fs-16 me-2"></i> Nuevo Empleado
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <table id="empleadosTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Empleado</th>
                                                <th>Cargo</th>
                                                <th>Especialidad</th>
                                                <th>Fecha Contratación</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                            <tbody>
                                                <?php if (!empty($empleados) && is_array($empleados)): ?>
                                                    <?php foreach ($empleados as $empleado): ?>
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="flex-shrink-0 me-2">
                                                                        <div class="avatar-sm">
                                                                            <div class="avatar-title bg-primary-subtle text-primary rounded-circle fs-5">
                                                                                <?= strtoupper(substr($empleado['nombre_completo'], 0, 1)) ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex-grow-1">
                                                                        <h5 class="fs-14 mb-1"><?= esc($empleado['nombre_completo']) ?></h5>
                                                                        <p class="text-muted mb-0">ID Usuario: <?= esc($empleado['id_usuario']) ?></p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <?php 
                                                                $cargoClass = 'bg-info-subtle text-info';
                                                                if (stripos($empleado['cargo'], 'técnico') !== false || stripos($empleado['cargo'], 'tecnico') !== false) {
                                                                    $cargoClass = 'bg-primary-subtle text-primary';
                                                                } elseif (stripos($empleado['cargo'], 'jefe') !== false || stripos($empleado['cargo'], 'gerente') !== false) {
                                                                    $cargoClass = 'bg-warning-subtle text-warning';
                                                                }
                                                                ?>
                                                                <span class="badge <?= $cargoClass ?>"><?= esc($empleado['cargo']) ?></span>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($empleado['especialidad'])): ?>
                                                                    <span class="text-muted">
                                                                        <i class="ri-settings-3-line me-1"></i>
                                                                        <?= esc($empleado['especialidad']) ?>
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="text-muted">-</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!empty($empleado['fecha_contratacion'])): ?>
                                                                    <i class="ri-calendar-line me-1 text-muted"></i>
                                                                    <?= date('d/m/Y', strtotime($empleado['fecha_contratacion'])) ?>
                                                                <?php else: ?>
                                                                    <span class="text-muted">-</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <div class="hstack gap-3 flex-wrap">
                                                                    <a href="/empleados/<?= $empleado['id_empleado'] ?>" 
                                                                       class="link-info fs-15"
                                                                       title="Ver Detalles">
                                                                        <i class="ri-eye-line"></i>
                                                                    </a>
                                                                    <a href="/empleados/<?= $empleado['id_empleado'] ?>/edit" 
                                                                       class="link-success fs-15" 
                                                                       title="Editar">
                                                                        <i class="ri-edit-2-line"></i>
                                                                    </a>
                                                                    <form action="/empleados/<?= $empleado['id_empleado'] ?>" 
                                                                          method="post" 
                                                                          style="display:inline-block;"
                                                                          onsubmit="return confirm('¿Está seguro de eliminar este empleado?');">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <?= csrf_field() ?>
                                                                        <button type="submit" 
                                                                                class="link-danger fs-15" 
                                                                                style="border:none; background:none; padding:0;"
                                                                                title="Eliminar">
                                                                            <i class="ri-delete-bin-line"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
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
    <?= $this->include('partials/datatables-scripts') ?>
    
    <script>
        $(document).ready(function() {
            $('#empleadosTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });
        });
    </script>
    <script src="/assets/js/app.js"></script>
</body>

</html>
