<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?> <?= $title ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0"><?= $title ?></h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Servicios</a></li>
                            <li class="breadcrumb-item"><a href="<?= base_url('historial') ?>">Historial</a></li>
                            <li class="breadcrumb-item active">Detalle</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Customer & Vehicle Info -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Información del Cliente</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-grow-1">
                                <h5 class="fs-14 mb-1"><?= esc($orden['cliente_nombre']) ?></h5>
                                <p class="text-muted mb-0">Cliente</p>
                            </div>
                        </div>
                        <ul class="list-unstyled vstack gap-2 mb-0">
                            <li><i
                                    class="ri-phone-line me-2 align-middle text-muted fs-16"></i><?= esc($orden['telefono']) ?>
                            </li>
                            <li><i
                                    class="ri-mail-line me-2 align-middle text-muted fs-16"></i><?= esc($orden['correo']) ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Información del Vehículo</h5>
                    </div>
                    <div class="card-body">
                        <h5 class="fs-14 mb-1"><?= esc($orden['placa']) ?></h5>
                        <p class="text-muted mb-0"><?= esc($orden['marca']) ?> <?= esc($orden['modelo']) ?>
                            (<?= esc($orden['anio']) ?>)</p>
                        <div class="mt-3">
                            <p class="mb-1"><strong>Motor:</strong> <?= esc($orden['tipo_motor']) ?></p>
                            <p class="mb-0"><strong>Color:</strong> <?= esc($orden['color']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Details -->
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Detalles del Servicio #<?= $orden['id_orden'] ?></h4>
                        <div class="flex-shrink-0">
                            <span class="badge bg-success-subtle text-success text-uppercase">FINALIZADA</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h6 class="text-muted text-uppercase fw-semibold">Técnico Asignado</h6>
                                <p class="fs-14 mb-0"><?= esc($orden['tecnico_nombre']) ?></p>
                            </div>
                            <div class="col-sm-6">
                                <h6 class="text-muted text-uppercase fw-semibold">Fecha Finalización</h6>
                                <p class="fs-14 mb-0"><?= date('d F, Y - H:i', strtotime($orden['fecha_fin_real'])) ?>
                                </p>
                            </div>
                        </div>

                        <h6 class="text-muted text-uppercase fw-semibold mb-3">Servicios Realizados</h6>
                        <div class="table-responsive table-card">
                            <table class="table table-borderless mb-0">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col">Descripción</th>
                                        <th scope="col" class="text-end">Costo Mano de Obra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalServicios = 0; ?>
                                    <?php foreach ($servicios as $servicio): ?>
                                        <tr>
                                            <td><?= esc($servicio['nombre']) ?></td>
                                            <td class="text-end">Bs. <?= number_format($servicio['costo_mano_obra'], 2) ?>
                                            </td>
                                        </tr>
                                        <?php $totalServicios += $servicio['costo_mano_obra']; ?>
                                    <?php endforeach; ?>
                                    <tr class="border-top border-top-dashed">
                                        <td class="fw-medium">Subtotal Servicios</td>
                                        <td class="text-end fw-medium">Bs. <?= number_format($totalServicios, 2) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <h6 class="text-muted text-uppercase fw-semibold mb-3 mt-4">Repuestos e Insumos Utilizados</h6>
                        <?php $totalInsumos = 0; ?>
                        <?php if (empty($insumos)): ?>
                            <p class="text-muted">No se registraron insumos para esta orden.</p>
                        <?php else: ?>
                            <div class="table-responsive table-card">
                                <table class="table table-borderless mb-0">
                                    <thead class="table-light text-muted">
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Producto</th>
                                            <th scope="col" class="text-center">Cant.</th>
                                            <th scope="col" class="text-end">Precio Unit.</th>
                                            <th scope="col" class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($insumos as $insumo): ?>
                                            <tr>
                                                <td><?= esc($insumo['codigo']) ?></td>
                                                <td><?= esc($insumo['nombre']) ?></td>
                                                <td class="text-center"><?= $insumo['cantidad'] ?></td>
                                                <td class="text-end">Bs. <?= number_format($insumo['costo_unitario'], 2) ?></td>
                                                <td class="text-end">Bs.
                                                    <?= number_format($insumo['cantidad'] * $insumo['costo_unitario'], 2) ?>
                                                </td>
                                            </tr>
                                            <?php $totalInsumos += ($insumo['cantidad'] * $insumo['costo_unitario']); ?>
                                        <?php endforeach; ?>
                                        <tr class="border-top border-top-dashed">
                                            <td colspan="4" class="fw-medium">Subtotal Insumos</td>
                                            <td class="text-end fw-medium">Bs. <?= number_format($totalInsumos, 2) ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <div class="row mt-4">
                            <div class="col-lg-8">
                                <div class="alert alert-secondary mb-0">
                                    <h6 class="alert-heading">Observaciones Técnicas:</h6>
                                    <p class="mb-0"><?= nl2br(esc($orden['observaciones_tecnicas'])) ?></p>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="table-responsive table-card">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr class="table-active">
                                                <th class="fw-bold">Total General :</th>
                                                <td class="text-end">
                                                    <span class="fw-bold text-success fs-16">Bs.
                                                        <?= number_format($totalServicios + $totalInsumos, 2) ?></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>