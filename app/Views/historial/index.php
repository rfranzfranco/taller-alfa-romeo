<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?> <?= $title ?> <?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Page Title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?= $title ?></h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Servicios</a></li>
                    <li class="breadcrumb-item active"><?= $title ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Search Form -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Buscar Servicios Realizados</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('historial') ?>" method="get">
                    <div class="row g-3">
                        <?php if (empty($isCliente)): ?>
                        <div class="col-md-3">
                            <select class="form-select" name="type">
                                <option value="placa" <?= $type == 'placa' ? 'selected' : '' ?>>Por Placa</option>
                                <option value="cliente" <?= $type == 'cliente' ? 'selected' : '' ?>>Por Cliente
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="search"
                                placeholder="Ingrese término de búsqueda..." value="<?= esc($search) ?>">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100"> <i
                                    class="ri-search-line align-bottom me-1"></i> Buscar</button>
                        </div>
                        <?php else: ?>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="search"
                                placeholder="Buscar por placa..." value="<?= esc($search) ?>">
                            <input type="hidden" name="type" value="placa">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100"> <i
                                    class="ri-search-line align-bottom me-1"></i> Buscar</button>
                        </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Results Table -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($ordenes)): ?>
                    <div class="alert alert-warning text-center">
                        No se encontraron servicios registrados con los criterios de búsqueda.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th># Orden</th>
                                    <th>Fecha Servicio</th>
                                    <?php if (empty($isCliente)): ?>
                                    <th>Cliente</th>
                                    <?php endif; ?>
                                    <th>Vehículo</th>
                                    <th>Técnico</th>
                                    <th>Estado Pago</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($ordenes as $orden): ?>
                                    <tr>
                                        <td><?= $orden['id_orden'] ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($orden['fecha_fin_real'])) ?></td>
                                        <?php if (empty($isCliente)): ?>
                                        <td><?= esc($orden['cliente_nombre']) ?></td>
                                        <?php endif; ?>
                                        <td>
                                            <span class="badge bg-info"><?= esc($orden['placa']) ?></span><br>
                                            <small><?= esc($orden['marca']) ?>         <?= esc($orden['modelo']) ?></small>
                                        </td>
                                        <td><?= esc($orden['tecnico_nombre']) ?></td>
                                        <td>
                                            <?php if (empty($orden['estado_pago'])): ?>
                                                <span class="badge bg-secondary-subtle text-secondary">Sin Factura</span>
                                            <?php elseif ($orden['estado_pago'] == 'PAGADO'): ?>
                                                <span class="badge bg-success-subtle text-success">PAGADO</span>
                                            <?php elseif ($orden['estado_pago'] == 'PENDIENTE'): ?>
                                                <span class="badge bg-warning-subtle text-warning">PENDIENTE</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger"><?= esc($orden['estado_pago']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('historial/' . $orden['id_orden']) ?>"
                                                class="btn btn-sm btn-info">
                                                <i class="ri-eye-line align-bottom me-1"></i> Ver Detalles
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>