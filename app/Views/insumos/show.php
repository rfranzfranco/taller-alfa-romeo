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

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= $title ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Gestión</a></li>
                                        <li class="breadcrumb-item"><a href="/insumos">Inventario</a></li>
                                        <li class="breadcrumb-item active">Detalle</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xxl-4">
                            <div class="card">
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <div class="profile-user position-relative d-inline-block mx-auto mb-4">
                                            <div class="avatar-lg">
                                                <div class="avatar-title bg-warning-subtle text-warning rounded-circle fs-1">
                                                    <i class="ri-tools-line"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-1"><?= esc($insumo['nombre']) ?></h5>
                                        <p class="text-muted mb-0">
                                            <span class="badge bg-light text-body fs-12"><?= esc($insumo['codigo']) ?></span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i class="ri-information-line me-2"></i>Información del Insumo
                                    </h5>
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <th class="ps-0" scope="row">ID:</th>
                                                    <td class="text-muted">#<?= $insumo['id_insumo'] ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Código:</th>
                                                    <td class="text-muted">
                                                        <span class="badge bg-secondary"><?= esc($insumo['codigo']) ?></span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Nombre:</th>
                                                    <td class="text-muted"><?= esc($insumo['nombre']) ?></td>
                                                </tr>
                                                <tr>
                                                    <th class="ps-0" scope="row">Precio Venta:</th>
                                                    <td>
                                                        <span class="text-success fw-semibold fs-14">
                                                            Bs <?= number_format($insumo['precio_venta'], 2) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Estado de Stock -->
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">
                                        <i class="ri-stack-line me-2"></i>Estado de Stock
                                    </h5>
                                    
                                    <?php 
                                    $porcentajeStock = ($insumo['stock_minimo'] > 0) ? ($insumo['stock_actual'] / $insumo['stock_minimo']) * 100 : 100;
                                    $stockBajo = $insumo['stock_actual'] <= $insumo['stock_minimo'];
                                    $stockClass = $stockBajo ? 'danger' : 'success';
                                    ?>
                                    
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-muted">Stock Actual</span>
                                        <span class="fw-semibold <?= $stockBajo ? 'text-danger' : 'text-success' ?>">
                                            <?= $insumo['stock_actual'] ?> unidades
                                        </span>
                                    </div>
                                    
                                    <div class="progress mb-3" style="height: 8px;">
                                        <div class="progress-bar bg-<?= $stockClass ?>" role="progressbar" 
                                             style="width: <?= min($porcentajeStock, 100) ?>%" 
                                             aria-valuenow="<?= $insumo['stock_actual'] ?>" 
                                             aria-valuemin="0" 
                                             aria-valuemax="<?= $insumo['stock_minimo'] * 2 ?>">
                                        </div>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between">
                                        <span class="text-muted fs-12">Stock Mínimo: <?= $insumo['stock_minimo'] ?></span>
                                        <?php if ($stockBajo): ?>
                                            <span class="badge bg-danger-subtle text-danger">
                                                <i class="ri-alert-line me-1"></i>Stock Bajo
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success-subtle text-success">
                                                <i class="ri-check-line me-1"></i>En Stock
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-8">
                            <!-- Descripción -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-file-text-line me-2"></i>Descripción
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($insumo['descripcion'])): ?>
                                        <p class="text-muted mb-0"><?= esc($insumo['descripcion']) ?></p>
                                    <?php else: ?>
                                        <p class="text-muted mb-0 fst-italic">Sin descripción disponible</p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Historial de Uso en Reservas -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-history-line me-2"></i>Historial de Uso
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($historial) && is_array($historial)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Reserva</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio Unit.</th>
                                                        <th>Total</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($historial as $item): ?>
                                                        <tr>
                                                            <td><a href="/reservas/<?= $item['id_reserva'] ?>" class="fw-medium">#<?= $item['id_reserva'] ?></a></td>
                                                            <td><?= $item['cantidad'] ?></td>
                                                            <td>Bs <?= number_format($item['precio_unitario'], 2) ?></td>
                                                            <td class="fw-semibold">Bs <?= number_format($item['cantidad'] * $item['precio_unitario'], 2) ?></td>
                                                            <td>
                                                                <a href="/reservas/<?= $item['id_reserva'] ?>" class="btn btn-sm btn-soft-primary" title="Ver reserva">
                                                                    <i class="ri-eye-line"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center py-4">
                                            <i class="ri-history-line fs-1 text-muted d-block mb-2"></i>
                                            <p class="text-muted mb-0">Este insumo no ha sido utilizado en ninguna reserva</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex gap-2 justify-content-end">
                                        <a href="/insumos" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i>Volver
                                        </a>
                                        <a href="/insumos/<?= $insumo['id_insumo'] ?>/edit" class="btn btn-primary">
                                            <i class="ri-edit-line me-1"></i>Editar
                                        </a>
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
