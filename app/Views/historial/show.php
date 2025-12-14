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

                <!-- Payment & Invoice Card -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Facturación y Pago</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($factura): ?>
                            <div class="mb-3">
                                <span class="badge bg-<?= $factura['estado_pago'] == 'PAGADO' ? 'success' : ($factura['estado_pago'] == 'PENDIENTE' ? 'warning' : 'danger') ?>-subtle text-<?= $factura['estado_pago'] == 'PAGADO' ? 'success' : ($factura['estado_pago'] == 'PENDIENTE' ? 'warning' : 'danger') ?> fs-12">
                                    <?= $factura['estado_pago'] ?>
                                </span>
                            </div>
                            <div class="mb-2">
                                <strong>Factura #:</strong> <?= $factura['id_factura'] ?>
                            </div>
                            <div class="mb-2">
                                <strong>Monto Total:</strong> Bs. <?= number_format($factura['monto_total'], 2) ?>
                            </div>
                            <?php if ($factura['estado_pago'] == 'PAGADO'): ?>
                                <div class="mb-2">
                                    <strong>Monto Pagado:</strong> Bs. <?= number_format($factura['monto_pagado'] ?? 0, 2) ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Método:</strong> <?= esc($factura['metodo_pago'] ?? 'N/A') ?>
                                </div>
                                <div class="mb-2">
                                    <strong>Fecha Pago:</strong> <?= $factura['fecha_pago'] ? date('d/m/Y H:i', strtotime($factura['fecha_pago'])) : 'N/A' ?>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <div class="d-grid gap-2">
                                <?php if ($factura['estado_pago'] == 'PENDIENTE'): ?>
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalRegistrarPago">
                                        <i class="ri-money-dollar-circle-line me-1"></i> Registrar Pago
                                    </button>
                                    <a href="<?= base_url('facturas/print/' . $factura['id_factura']) ?>" class="btn btn-outline-secondary" target="_blank">
                                        <i class="ri-eye-line me-1"></i> Ver Factura
                                    </a>
                                <?php endif; ?>
                                <?php if ($factura['estado_pago'] == 'PAGADO'): ?>
                                    <a href="<?= base_url('facturas/print/' . $factura['id_factura']) ?>" class="btn btn-primary" target="_blank">
                                        <i class="ri-file-pdf-line me-1"></i> Ver/Imprimir Factura
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mb-3">No se ha generado factura para este servicio.</p>
                            <div class="d-grid">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalGenerarFactura">
                                    <i class="ri-file-list-3-line me-1"></i> Generar Factura
                                </button>
                            </div>
                        <?php endif; ?>
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
                                                        <?= number_format($totalGeneral, 2) ?></span>
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

<!-- Modal Generar Factura -->
<div class="modal fade" id="modalGenerarFactura" tabindex="-1" aria-labelledby="modalGenerarFacturaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalGenerarFacturaLabel">Generar Factura</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formGenerarFactura">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nit" class="form-label">NIT Facturación</label>
                        <input type="text" class="form-control" id="nit" name="nit" placeholder="Ingrese NIT o 0 para S/N">
                    </div>
                    <div class="mb-3">
                        <label for="razon_social" class="form-label">Razón Social</label>
                        <input type="text" class="form-control" id="razon_social" name="razon_social" placeholder="Nombre o razón social">
                    </div>
                    <div class="alert alert-info">
                        <strong>Monto Total:</strong> Bs. <?= number_format($totalGeneral, 2) ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Generar Factura</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Registrar Pago -->
<?php if ($factura && $factura['estado_pago'] == 'PENDIENTE'): ?>
<div class="modal fade" id="modalRegistrarPago" tabindex="-1" aria-labelledby="modalRegistrarPagoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegistrarPagoLabel">Registrar Pago</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formRegistrarPago">
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <strong>Factura #:</strong> <?= $factura['id_factura'] ?><br>
                        <strong>Monto a Pagar:</strong> Bs. <?= number_format($factura['monto_total'], 2) ?>
                    </div>
                    <div class="mb-3">
                        <label for="monto_pagado" class="form-label">Monto Pagado <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Bs.</span>
                            <input type="number" step="0.01" class="form-control" id="monto_pagado" name="monto_pagado" 
                                   value="<?= $factura['monto_total'] ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="metodo_pago" class="form-label">Método de Pago <span class="text-danger">*</span></label>
                        <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                            <option value="">Seleccione un método</option>
                            <option value="EFECTIVO">Efectivo</option>
                            <option value="TRANSFERENCIA">Transferencia Bancaria</option>
                            <option value="TARJETA">Tarjeta de Crédito/Débito</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_pago" class="form-label">Fecha de Pago <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" id="fecha_pago" name="fecha_pago" 
                               value="<?= date('Y-m-d\TH:i') ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">
                        <i class="ri-check-line me-1"></i> Confirmar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const idOrden = <?= $orden['id_orden'] ?>;
<?php if ($factura): ?>
const idFactura = <?= $factura['id_factura'] ?>;
<?php else: ?>
let idFactura = null;
<?php endif; ?>

// Helper function to show alerts
function showAlert(type, title, message, callback) {
    // Create alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <strong>${title}</strong><br>${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.appendChild(alertDiv);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        alertDiv.remove();
        if (callback) callback();
    }, 2000);
}

// Generate Invoice
document.getElementById('formGenerarFactura')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Generando...';
    
    fetch('<?= base_url('facturas/generate/') ?>' + idOrden, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalGenerarFactura'));
        modal.hide();
        
        if (data.id_factura) {
            showAlert('success', '¡Factura Generada!', 'La factura #' + data.id_factura + ' ha sido creada exitosamente.', () => {
                location.reload();
            });
        } else {
            showAlert('error', 'Error', data.messages?.error || 'No se pudo generar la factura');
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Generar Factura';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error', 'Ocurrió un error al generar la factura');
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Generar Factura';
    });
});

// Register Payment
document.getElementById('formRegistrarPago')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Procesando...';
    
    fetch('<?= base_url('facturas/pay/') ?>' + idFactura, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('modalRegistrarPago'));
        modal.hide();
        
        if (data.message && data.message.includes('correctamente')) {
            showAlert('success', '¡Pago Registrado!', 'El pago ha sido registrado exitosamente.', () => {
                location.reload();
            });
        } else {
            showAlert('error', 'Error', data.messages?.error || 'No se pudo registrar el pago');
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="ri-check-line me-1"></i> Confirmar Pago';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Error', 'Ocurrió un error al registrar el pago');
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i class="ri-check-line me-1"></i> Confirmar Pago';
    });
});
</script>
<?= $this->endSection() ?>