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
                                    <table id="usuariosTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre de Usuario</th>
                                                <th>Rol</th>
                                                <th>Estado</th>
                                                <th>Fecha Creación</th>
                                                <th>Acciones</th>
                                            </tr>
                                            <tr>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar ID"></th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar usuario"></th>
                                                <th>
                                                    <select class="form-select form-select-sm column-filter">
                                                        <option value="">Todos</option>
                                                        <option value="ADMIN">Admin</option>
                                                        <option value="RECEPCIONISTA">Recepcionista</option>
                                                        <option value="EMPLEADO">Empleado</option>
                                                        <option value="CLIENTE">Cliente</option>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="form-select form-select-sm column-filter">
                                                        <option value="">Todos</option>
                                                        <option value="Activo">Activo</option>
                                                        <option value="Inactivo">Inactivo</option>
                                                    </select>
                                                </th>
                                                <th><input type="text" class="form-control form-control-sm column-filter" placeholder="Buscar fecha"></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($usuarios) && is_array($usuarios)): ?>
                                                <?php foreach ($usuarios as $user): ?>
                                                    <tr>
                                                        <td><a href="#" class="fw-medium">#<?= $user['id_usuario'] ?></a></td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0 me-2">
                                                                    <div class="avatar-xs">
                                                                        <div class="avatar-title bg-secondary-subtle text-secondary rounded-circle">
                                                                            <?= strtoupper(substr($user['username'], 0, 1)) ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1"><?= esc($user['username']) ?></div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php 
                                                            $rolClass = 'bg-info-subtle text-info';
                                                            if ($user['rol'] == 'ADMIN') $rolClass = 'bg-danger-subtle text-danger';
                                                            elseif ($user['rol'] == 'RECEPCIONISTA') $rolClass = 'bg-warning-subtle text-warning';
                                                            elseif ($user['rol'] == 'EMPLEADO') $rolClass = 'bg-primary-subtle text-primary';
                                                            ?>
                                                            <span class="badge <?= $rolClass ?> text-uppercase"><?= esc($user['rol']) ?></span>
                                                        </td>
                                                        <td>
                                                            <?php if ($user['estado'] == '1'): ?>
                                                                <span class="badge bg-success-subtle text-success text-uppercase">Activo</span>
                                                            <?php else: ?>
                                                                <span class="badge bg-danger-subtle text-danger text-uppercase">Inactivo</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $user['fecha_creacion'] ?></td>
                                                        <td>
                                                            <div class="hstack gap-3 flex-wrap">
                                                                <a href="/usuarios/<?= $user['id_usuario'] ?>"
                                                                    class="link-info fs-15" title="Ver detalles"><i
                                                                        class="ri-eye-line"></i></a>
                                                                <a href="/usuarios/<?= $user['id_usuario'] ?>/edit"
                                                                    class="link-success fs-15" title="Editar"><i
                                                                        class="ri-edit-2-line"></i></a>
                                                                <form action="/usuarios/<?= $user['id_usuario'] ?>"
                                                                    method="post" style="display:inline-block;"
                                                                    onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                                                    <input type="hidden" name="_method" value="DELETE">
                                                                    <?= csrf_field() ?>
                                                                    <button type="submit" class="link-danger fs-15"
                                                                        style="border:none; background:none; padding:0;" title="Eliminar"><i
                                                                            class="ri-delete-bin-line"></i></button>
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
            var table = $('#usuariosTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                orderCellsTop: true,
                fixedHeader: true,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });

            $('#usuariosTable thead tr:eq(1) th').each(function(i) {
                $('input, select', this).on('keyup change', function() {
                    if (table.column(i).search() !== this.value) {
                        table.column(i).search(this.value).draw();
                    }
                });
            });
        });
    </script>
    <script src="/assets/js/app.js"></script>
</body>

</html>