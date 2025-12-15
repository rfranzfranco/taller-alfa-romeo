<?= $this->include('partials/main') ?>

<head>
    <?php echo view('partials/title-meta', array('title' => $title)); ?>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <?= $this->include('partials/head-css') ?>
    <style>
        .badge-pendiente {
            background-color: #f7b84b;
            color: #000;
        }
        .badge-pagado {
            background-color: #0ab39c;
            color: #fff;
        }
        .stats-card {
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-3px);
        }
        .stats-icon {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        .bg-warning-gradient {
            background: linear-gradient(135deg, #f7b84b 0%, #f5a623 100%);
            color: #fff;
        }
        .bg-success-gradient {
            background: linear-gradient(135deg, #0ab39c 0%, #099885 100%);
            color: #fff;
        }
        .bg-info-gradient {
            background: linear-gradient(135deg, #299cdb 0%, #1e7bb8 100%);
            color: #fff;
        }
    </style>
</head>

<body>
    <div id="layout-wrapper">
        <?= $this->include('partials/menu') ?>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <?php echo view('partials/page-title', array('pagetitle' => 'Finanzas', 'title' => $title)); ?>

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

                    <!-- Resumen de Facturación -->
                    <?php
                        $totalFacturas = count($facturas);
                        $facturasPendientes = array_filter($facturas, fn($f) => $f['estado_pago'] === 'PENDIENTE');
                        $facturasPagadas = array_filter($facturas, fn($f) => $f['estado_pago'] === 'PAGADO');
                        $montoPendiente = array_sum(array_column($facturasPendientes, 'monto_total'));
                        $montoPagado = array_sum(array_column($facturasPagadas, 'monto_pagado'));
                    ?>
                    <div class="row mb-4">
                        <div class="col-xl-4 col-md-6">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon bg-warning-gradient me-3">
                                            <i class="ri-time-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Pendientes de Pago</p>
                                            <h4 class="mb-0"><?= count($facturasPendientes) ?></h4>
                                            <small class="text-muted">Bs. <?= number_format($montoPendiente, 2) ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon bg-success-gradient me-3">
                                            <i class="ri-checkbox-circle-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Facturas Pagadas</p>
                                            <h4 class="mb-0"><?= count($facturasPagadas) ?></h4>
                                            <small class="text-muted">Bs. <?= number_format($montoPagado, 2) ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="stats-icon bg-info-gradient me-3">
                                            <i class="ri-file-list-3-line"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1">Total Facturas</p>
                                            <h4 class="mb-0"><?= $totalFacturas ?></h4>
                                            <small class="text-muted">Generadas</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-success mb-3" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-bs-toggle="tab" href="#todas" role="tab">
                                Todas las Facturas <span class="badge bg-secondary rounded-pill ms-1"><?= $totalFacturas ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#pendientes" role="tab">
                                Pendientes <span class="badge bg-warning rounded-pill ms-1"><?= count($facturasPendientes) ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-bs-toggle="tab" href="#pagadas" role="tab">
                                Pagadas <span class="badge bg-success rounded-pill ms-1"><?= count($facturasPagadas) ?></span>
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <!-- TODAS -->
                        <div class="tab-pane active" id="todas" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <table id="todasTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th># Factura</th>
                                                <th>Fecha Emisión</th>
                                                <th>Cliente</th>
                                                <th>Vehículo</th>
                                                <th>Monto Total</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($facturas as $factura): ?>
                                                <tr>
                                                    <td><strong>#<?= str_pad($factura['id_factura'], 6, '0', STR_PAD_LEFT) ?></strong></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($factura['fecha_emision'])) ?></td>
                                                    <td><?= esc($factura['cliente_nombre']) ?></td>
                                                    <td>
                                                        <span class="badge bg-info"><?= esc($factura['placa']) ?></span>
                                                        <small class="text-muted"><?= esc($factura['marca'] . ' ' . $factura['modelo']) ?></small>
                                                    </td>
                                                    <td><strong>Bs. <?= number_format($factura['monto_total'], 2) ?></strong></td>
                                                    <td>
                                                        <?php if ($factura['estado_pago'] === 'PENDIENTE'): ?>
                                                            <span class="badge badge-pendiente">PENDIENTE</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-pagado">PAGADO</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <a href="/facturas/print/<?= $factura['id_factura'] ?>" class="btn btn-sm btn-info" title="Ver Factura" target="_blank">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                            <?php if ($factura['estado_pago'] === 'PENDIENTE'): ?>
                                                                <button type="button" class="btn btn-sm btn-success btn-registrar-pago" 
                                                                    data-id="<?= $factura['id_factura'] ?>"
                                                                    data-monto="<?= $factura['monto_total'] ?>"
                                                                    data-cliente="<?= esc($factura['cliente_nombre']) ?>"
                                                                    data-bs-toggle="modal" 
                                                                    data-bs-target="#modalPago"
                                                                    title="Registrar Pago">
                                                                    <i class="ri-money-dollar-circle-line"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- PENDIENTES -->
                        <div class="tab-pane" id="pendientes" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <table id="pendientesTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th># Factura</th>
                                                <th>Fecha Emisión</th>
                                                <th>Cliente</th>
                                                <th>Vehículo</th>
                                                <th>Monto Total</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($facturasPendientes as $factura): ?>
                                                <tr>
                                                    <td><strong>#<?= str_pad($factura['id_factura'], 6, '0', STR_PAD_LEFT) ?></strong></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($factura['fecha_emision'])) ?></td>
                                                    <td><?= esc($factura['cliente_nombre']) ?></td>
                                                    <td>
                                                        <span class="badge bg-info"><?= esc($factura['placa']) ?></span>
                                                        <small class="text-muted"><?= esc($factura['marca'] . ' ' . $factura['modelo']) ?></small>
                                                    </td>
                                                    <td><strong>Bs. <?= number_format($factura['monto_total'], 2) ?></strong></td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <a href="/facturas/print/<?= $factura['id_factura'] ?>" class="btn btn-sm btn-info" title="Ver Factura" target="_blank">
                                                                <i class="ri-eye-line"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-sm btn-success btn-registrar-pago" 
                                                                data-id="<?= $factura['id_factura'] ?>"
                                                                data-monto="<?= $factura['monto_total'] ?>"
                                                                data-cliente="<?= esc($factura['cliente_nombre']) ?>"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#modalPago"
                                                                title="Registrar Pago">
                                                                <i class="ri-money-dollar-circle-line"></i> Registrar Pago
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- PAGADAS -->
                        <div class="tab-pane" id="pagadas" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <table id="pagadasTable" class="table table-bordered dt-responsive nowrap table-striped align-middle" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th># Factura</th>
                                                <th>Fecha Emisión</th>
                                                <th>Cliente</th>
                                                <th>Vehículo</th>
                                                <th>Monto Pagado</th>
                                                <th>Método Pago</th>
                                                <th>Fecha Pago</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($facturasPagadas as $factura): ?>
                                                <tr>
                                                    <td><strong>#<?= str_pad($factura['id_factura'], 6, '0', STR_PAD_LEFT) ?></strong></td>
                                                    <td><?= date('d/m/Y H:i', strtotime($factura['fecha_emision'])) ?></td>
                                                    <td><?= esc($factura['cliente_nombre']) ?></td>
                                                    <td>
                                                        <span class="badge bg-info"><?= esc($factura['placa']) ?></span>
                                                        <small class="text-muted"><?= esc($factura['marca'] . ' ' . $factura['modelo']) ?></small>
                                                    </td>
                                                    <td><strong>Bs. <?= number_format($factura['monto_pagado'], 2) ?></strong></td>
                                                    <td>
                                                        <?php
                                                            $metodoBadge = 'bg-secondary';
                                                            if ($factura['metodo_pago'] === 'EFECTIVO') $metodoBadge = 'bg-success';
                                                            if ($factura['metodo_pago'] === 'TARJETA') $metodoBadge = 'bg-primary';
                                                            if ($factura['metodo_pago'] === 'TRANSFERENCIA') $metodoBadge = 'bg-info';
                                                        ?>
                                                        <span class="badge <?= $metodoBadge ?>"><?= esc($factura['metodo_pago']) ?></span>
                                                    </td>
                                                    <td><?= $factura['fecha_pago'] ? date('d/m/Y', strtotime($factura['fecha_pago'])) : '-' ?></td>
                                                    <td>
                                                        <a href="/facturas/print/<?= $factura['id_factura'] ?>" class="btn btn-sm btn-info" title="Ver Factura" target="_blank">
                                                            <i class="ri-eye-line"></i> Ver
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
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

    <!-- Modal Registrar Pago -->
    <div class="modal fade" id="modalPago" tabindex="-1" aria-labelledby="modalPagoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPagoLabel">
                        <i class="ri-money-dollar-circle-line me-2"></i>Registrar Pago
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formPago">
                    <div class="modal-body">
                        <input type="hidden" id="pago_factura_id" name="factura_id">
                        
                        <div class="alert alert-info">
                            <strong>Cliente:</strong> <span id="pago_cliente_nombre"></span>
                        </div>
                        
                        <div class="mb-3">
                            <label for="monto_pagado" class="form-label">Monto a Pagar (Bs.)</label>
                            <input type="number" step="0.01" class="form-control" id="monto_pagado" name="monto_pagado" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="metodo_pago" class="form-label">Método de Pago</label>
                            <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                <option value="">Seleccione...</option>
                                <option value="EFECTIVO">Efectivo</option>
                                <option value="TARJETA">Tarjeta</option>
                                <option value="TRANSFERENCIA">Transferencia</option>
                                <option value="QR">Código QR</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fecha_pago" class="form-label">Fecha de Pago</label>
                            <input type="date" class="form-control" id="fecha_pago" name="fecha_pago" value="<?= date('Y-m-d') ?>" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">
                            <i class="ri-check-line me-1"></i>Confirmar Pago
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?= $this->include('partials/customizer') ?>
    <?= $this->include('partials/vendor-scripts') ?>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script src="/assets/js/app.js"></script>
    
    <script>
        $(document).ready(function() {
            // Inicializar DataTables
            $('#todasTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                order: [[1, 'desc']]
            });
            
            $('#pendientesTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                order: [[1, 'desc']]
            });
            
            $('#pagadasTable').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
                },
                order: [[6, 'desc']]
            });

            // Configurar modal de pago
            $('.btn-registrar-pago').on('click', function() {
                const id = $(this).data('id');
                const monto = $(this).data('monto');
                const cliente = $(this).data('cliente');
                
                $('#pago_factura_id').val(id);
                $('#monto_pagado').val(monto);
                $('#pago_cliente_nombre').text(cliente);
            });

            // Enviar formulario de pago
            $('#formPago').on('submit', function(e) {
                e.preventDefault();
                
                const facturaId = $('#pago_factura_id').val();
                const data = {
                    monto_pagado: $('#monto_pagado').val(),
                    metodo_pago: $('#metodo_pago').val(),
                    fecha_pago: $('#fecha_pago').val()
                };

                $.ajax({
                    url: '/facturas/pay/' + facturaId,
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        $('#modalPago').modal('hide');
                        alert('Pago registrado correctamente');
                        location.reload();
                    },
                    error: function(xhr) {
                        alert('Error al registrar el pago: ' + (xhr.responseJSON?.messages?.error || 'Error desconocido'));
                    }
                });
            });
        });
    </script>
</body>
</html>
