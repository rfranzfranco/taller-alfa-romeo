<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <?= $this->include('partials/head-css') ?>
</head>

<body>
    <!-- Begin page -->
    <div id="layout-wrapper">
        <?= $this->include('partials/menu') ?>

        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <!-- Page Title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0"><?= $title ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="/ordenestrabajo">Órdenes de Trabajo</a></li>
                                        <li class="breadcrumb-item active">Detalle</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Información Principal -->
                        <div class="col-xl-8">
                            <!-- Estado de la Orden -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex align-items-center">
                                        <h5 class="card-title flex-grow-1 mb-0">
                                            <i class="ri-file-list-3-line me-2"></i>Orden de Trabajo #<?= str_pad($orden['id_orden'], 4, '0', STR_PAD_LEFT) ?>
                                        </h5>
                                        <?php 
                                            $estadoClass = 'bg-warning';
                                            $estadoIcon = 'ri-time-line';
                                            if ($orden['estado'] == 'EN_PROCESO') {
                                                $estadoClass = 'bg-info';
                                                $estadoIcon = 'ri-tools-line';
                                            } elseif ($orden['estado'] == 'FINALIZADA') {
                                                $estadoClass = 'bg-success';
                                                $estadoIcon = 'ri-check-double-line';
                                            }
                                        ?>
                                        <span class="badge <?= $estadoClass ?> fs-12">
                                            <i class="<?= $estadoIcon ?> me-1"></i><?= $orden['estado'] ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Información del Vehículo</h6>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar-sm flex-shrink-0 me-3">
                                                    <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-3">
                                                        <i class="ri-roadster-line"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-14 mb-1"><?= esc($orden['marca']) ?> <?= esc($orden['modelo']) ?></h5>
                                                    <p class="text-muted mb-0">
                                                        <span class="badge bg-dark"><?= esc($orden['placa']) ?></span>
                                                        <span class="ms-2"><?= esc($orden['anio']) ?> - <?= esc($orden['color']) ?></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Técnico Asignado</h6>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="avatar-sm flex-shrink-0 me-3">
                                                    <span class="avatar-title bg-success-subtle text-success rounded-circle fs-3">
                                                        <i class="ri-user-settings-line"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h5 class="fs-14 mb-1"><?= esc($orden['tecnico_nombre'] ?? 'Sin asignar') ?></h5>
                                                    <p class="text-muted mb-0"><?= esc($orden['tecnico_cargo'] ?? '') ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <p class="text-muted mb-1">Fecha de Reserva</p>
                                            <h6><?= date('d/m/Y H:i', strtotime($orden['fecha_reserva'])) ?></h6>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-muted mb-1">Inicio del Trabajo</p>
                                            <h6><?= $orden['fecha_inicio_real'] ? date('d/m/Y H:i', strtotime($orden['fecha_inicio_real'])) : '-' ?></h6>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-muted mb-1">Fin del Trabajo</p>
                                            <h6><?= $orden['fecha_fin_real'] ? date('d/m/Y H:i', strtotime($orden['fecha_fin_real'])) : '-' ?></h6>
                                        </div>
                                    </div>

                                    <?php if ($orden['rampa_nombre']): ?>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <p class="text-muted mb-1">Rampa Asignada</p>
                                            <h6><i class="ri-parking-box-line me-1"></i><?= esc($orden['rampa_nombre']) ?></h6>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Servicios Solicitados -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-service-line me-2"></i>Servicios Solicitados
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Servicio</th>
                                                    <th class="text-center">Tiempo Est.</th>
                                                    <th class="text-end">Costo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($servicios as $servicio): ?>
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0"><?= esc($servicio['nombre']) ?></h6>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info-subtle text-info"><?= $servicio['tiempo_estimado'] ?> min</span>
                                                    </td>
                                                    <td class="text-end">Bs. <?= number_format($servicio['costo_mano_obra'], 2) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <th colspan="2">Total Servicios</th>
                                                    <th class="text-end">Bs. <?= number_format($totalServicios, 2) ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Insumos Utilizados (si la orden está finalizada) -->
                            <?php if (!empty($insumosUsados)): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-box-3-line me-2"></i>Insumos Utilizados
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless align-middle mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Insumo</th>
                                                    <th class="text-center">Cantidad</th>
                                                    <th class="text-end">Precio Unit.</th>
                                                    <th class="text-end">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($insumosUsados as $insumo): ?>
                                                <tr>
                                                    <td>
                                                        <h6 class="mb-0"><?= esc($insumo['nombre']) ?></h6>
                                                    </td>
                                                    <td class="text-center"><?= $insumo['cantidad'] ?> <?= esc($insumo['unidad_medida']) ?></td>
                                                    <td class="text-end">Bs. <?= number_format($insumo['costo_unitario'], 2) ?></td>
                                                    <td class="text-end">Bs. <?= number_format($insumo['cantidad'] * $insumo['costo_unitario'], 2) ?></td>
                                                </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                            <tfoot class="table-light">
                                                <tr>
                                                    <th colspan="3">Total Insumos</th>
                                                    <th class="text-end">Bs. <?= number_format($totalInsumos, 2) ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>

                            <!-- Observaciones Técnicas -->
                            <?php if (!empty($orden['observaciones_tecnicas'])): ?>
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-file-text-line me-2"></i>Observaciones Técnicas
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0"><?= nl2br(esc($orden['observaciones_tecnicas'])) ?></p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Panel Lateral -->
                        <div class="col-xl-4">
                            <!-- Información del Cliente -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-user-line me-2"></i>Datos del Cliente
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="avatar-sm flex-shrink-0 me-3">
                                            <span class="avatar-title bg-primary-subtle text-primary rounded-circle fs-4">
                                                <?= strtoupper(substr($orden['cliente_nombre'], 0, 1)) ?>
                                            </span>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="fs-14 mb-1"><?= esc($orden['cliente_nombre']) ?></h5>
                                        </div>
                                    </div>
                                    <?php if ($orden['cliente_telefono']): ?>
                                    <p class="mb-2">
                                        <i class="ri-phone-line text-muted me-2"></i>
                                        <?= esc($orden['cliente_telefono']) ?>
                                    </p>
                                    <?php endif; ?>
                                    <?php if ($orden['cliente_correo']): ?>
                                    <p class="mb-0">
                                        <i class="ri-mail-line text-muted me-2"></i>
                                        <?= esc($orden['cliente_correo']) ?>
                                    </p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Resumen de Costos -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-money-dollar-circle-line me-2"></i>Resumen de Costos
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>Mano de Obra:</td>
                                                    <td class="text-end">Bs. <?= number_format($totalServicios, 2) ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Insumos:</td>
                                                    <td class="text-end">Bs. <?= number_format($totalInsumos, 2) ?></td>
                                                </tr>
                                                <tr class="border-top">
                                                    <th>Total:</th>
                                                    <th class="text-end fs-16 text-primary">Bs. <?= number_format($totalServicios + $totalInsumos, 2) ?></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Acciones -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="ri-settings-3-line me-2"></i>Acciones
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <?php if ($orden['estado'] == 'EN_PROCESO'): ?>
                                        <a href="/ordenestrabajo/complete/<?= $orden['id_orden'] ?>" class="btn btn-success">
                                            <i class="ri-check-double-line me-1"></i> Finalizar Orden
                                        </a>
                                        <?php endif; ?>
                                        
                                        <a href="/ordenestrabajo" class="btn btn-light">
                                            <i class="ri-arrow-left-line me-1"></i> Volver a Órdenes
                                        </a>
                                        
                                        <?php if ($orden['estado'] == 'FINALIZADA'): ?>
                                        <a href="/facturas/generate/<?= $orden['id_orden'] ?>" class="btn btn-primary">
                                            <i class="ri-file-text-line me-1"></i> Generar Factura
                                        </a>
                                        <?php endif; ?>
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
