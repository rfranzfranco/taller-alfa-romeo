<?= $this->include('partials/main') ?>

<head>

    <?php echo view('partials/title-meta', array('title' => 'Dashboard')); ?>

    <?= $this->include('partials/head-css') ?>
    
    <style>
        /* Dashboard Theme Styles - Matching Login Design */
        :root {
            --primary-blue: #405189;
            --primary-dark: #2c3e6e;
            --secondary-blue: #364574;
            --accent-green: #6ae0bd;
            --bg-dark: #1a1a2e;
        }
        
        .page-content {
            background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
            min-height: calc(100vh - 70px);
        }
        
        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            border-radius: 16px;
            padding: 30px;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(64, 81, 137, 0.3);
        }
        
        .welcome-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .welcome-banner::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(106, 224, 189, 0.15) 0%, transparent 70%);
            border-radius: 50%;
        }
        
        .welcome-banner .welcome-content {
            position: relative;
            z-index: 1;
        }
        
        .welcome-banner h4 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }
        
        .welcome-banner p {
            opacity: 1;
            font-size: 15px;
            margin-bottom: 0;
            color: #e0e5f1;
        }
        
        .welcome-banner .car-icon {
            font-size: 80px;
            opacity: 0.2;
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
        }
        
        .current-time {
            background: rgba(255,255,255,0.15);
            padding: 8px 16px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            margin-top: 15px;
        }
        
        /* Stats Cards */
        .stats-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        
        .stats-card .card-body {
            padding: 24px;
        }
        
        .stats-card .stats-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
        }
        
        .stats-card .stats-icon.bg-primary-gradient {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            color: white;
        }
        
        .stats-card .stats-icon.bg-success-gradient {
            background: linear-gradient(135deg, #0ab39c 0%, #099885 100%);
            color: white;
        }
        
        .stats-card .stats-icon.bg-warning-gradient {
            background: linear-gradient(135deg, #f7b84b 0%, #f5a623 100%);
            color: white;
        }
        
        .stats-card .stats-icon.bg-danger-gradient {
            background: linear-gradient(135deg, #f06548 0%, #e74c3c 100%);
            color: white;
        }
        
        .stats-card .stats-icon.bg-info-gradient {
            background: linear-gradient(135deg, #299cdb 0%, #2081b9 100%);
            color: white;
        }
        
        .stats-card .stats-number {
            font-size: 32px;
            font-weight: 700;
            color: var(--bg-dark);
            line-height: 1.2;
        }
        
        .stats-card .stats-label {
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 600;
            color: #6c757d;
            letter-spacing: 0.5px;
        }
        
        .stats-card .stats-link {
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 13px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
        }
        
        .stats-card .stats-link:hover {
            color: var(--primary-dark);
            gap: 8px;
        }
        
        /* Data Tables Cards */
        .data-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        
        .data-card .card-header {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            border: none;
            padding: 18px 24px;
        }
        
        .data-card .card-header .card-title {
            color: white;
            font-weight: 600;
            font-size: 16px;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .data-card .card-header .card-title i {
            font-size: 20px;
            opacity: 0.8;
        }
        
        .data-card .card-body {
            padding: 0;
        }
        
        .data-card .table {
            margin-bottom: 0;
        }
        
        .data-card .table thead {
            background: #f8f9fc;
        }
        
        .data-card .table thead th {
            border: none;
            padding: 14px 20px;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 700;
            color: var(--primary-blue);
            letter-spacing: 0.5px;
        }
        
        .data-card .table tbody td {
            padding: 14px 20px;
            vertical-align: middle;
            border-color: #f1f1f1;
        }
        
        .data-card .table tbody tr:hover {
            background: rgba(64, 81, 137, 0.03);
        }
        
        .data-card .table tbody tr:last-child td {
            border-bottom: none;
        }
        
        /* Status Badges */
        .badge-status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .badge-status.status-pending {
            background: rgba(64, 81, 137, 0.15);
            color: var(--primary-blue);
        }
        
        .badge-status.status-confirmed {
            background: rgba(10, 179, 156, 0.15);
            color: #0ab39c;
        }
        
        .badge-status.status-progress {
            background: rgba(247, 184, 75, 0.15);
            color: #f5a623;
        }
        
        /* Quick Action Buttons */
        .quick-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .quick-action-btn {
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 13px;
            color: var(--primary-blue);
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }
        
        .quick-action-btn:hover {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(64, 81, 137, 0.3);
        }
        
        .quick-action-btn i {
            font-size: 18px;
        }
        
        /* View Button in Tables */
        .btn-view {
            background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-dark) 100%);
            border: none;
            color: white;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.2s;
        }
        
        .btn-view:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(64, 81, 137, 0.3);
            color: white;
        }
        
        /* Empty State */
        .empty-state {
            padding: 40px 20px;
            text-align: center;
            color: #6c757d;
        }
        
        .empty-state i {
            font-size: 48px;
            opacity: 0.3;
            margin-bottom: 15px;
            display: block;
        }
        
        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-card {
            animation: fadeInUp 0.5s ease forwards;
        }
        
        .animate-card:nth-child(1) { animation-delay: 0.1s; }
        .animate-card:nth-child(2) { animation-delay: 0.2s; }
        .animate-card:nth-child(3) { animation-delay: 0.3s; }
        .animate-card:nth-child(4) { animation-delay: 0.4s; }
    </style>

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <?= $this->include('partials/menu') ?>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- Welcome Banner -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="welcome-banner">
                                <i class="ri-roadster-line car-icon"></i>
                                <div class="welcome-content">
                                    <h4>¡Bienvenido, <?= session()->get('user_name') ?? 'Admin' ?>!</h4>
                                    <p>Panel de control del Sistema de Gestión - Taller Mecánico Alfa Romeo</p>
                                    <div class="current-time">
                                        <i class="ri-time-line"></i>
                                        <span id="current-datetime"><?= date('l, d M Y - H:i') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="quick-actions">
                                <a href="/reservas/new" class="quick-action-btn">
                                    <i class="ri-add-circle-line"></i> Nueva Reserva
                                </a>
                                <a href="/vehiculos/recepcion" class="quick-action-btn">
                                    <i class="ri-car-washing-line"></i> Recepción Vehículo
                                </a>
                                <a href="/clientes/new" class="quick-action-btn">
                                    <i class="ri-user-add-line"></i> Nuevo Cliente
                                </a>
                                <a href="/facturas" class="quick-action-btn">
                                    <i class="ri-file-list-3-line"></i> Ver Facturas
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 animate-card">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="stats-icon bg-success-gradient">
                                            <i class="ri-calendar-check-line"></i>
                                        </div>
                                        <span class="badge bg-success-subtle text-success">Hoy</span>
                                    </div>
                                    <div class="stats-number"><?= $reservas_hoy ?></div>
                                    <p class="stats-label mb-3">Reservas del Día</p>
                                    <a href="/reservas" class="stats-link">
                                        Ver todas <i class="ri-arrow-right-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 animate-card">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="stats-icon bg-warning-gradient">
                                            <i class="ri-tools-line"></i>
                                        </div>
                                        <span class="badge bg-warning-subtle text-warning">Activas</span>
                                    </div>
                                    <div class="stats-number"><?= $ordenes_activas ?></div>
                                    <p class="stats-label mb-3">Órdenes en Proceso</p>
                                    <a href="/ordenestrabajo" class="stats-link">
                                        Ver órdenes <i class="ri-arrow-right-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 animate-card">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="stats-icon bg-danger-gradient">
                                            <i class="ri-bill-line"></i>
                                        </div>
                                        <span class="badge bg-danger-subtle text-danger">Pendientes</span>
                                    </div>
                                    <div class="stats-number"><?= $facturas_pendientes ?></div>
                                    <p class="stats-label mb-3">Facturas por Cobrar</p>
                                    <a href="/facturas" class="stats-link">
                                        Ver facturas <i class="ri-arrow-right-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 animate-card">
                            <div class="card stats-card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div class="stats-icon bg-info-gradient">
                                            <i class="ri-roadster-line"></i>
                                        </div>
                                        <span class="badge bg-info-subtle text-info">Total</span>
                                    </div>
                                    <div class="stats-number"><?= $total_vehiculos ?></div>
                                    <p class="stats-label mb-3">Vehículos Registrados</p>
                                    <a href="/vehiculos" class="stats-link">
                                        Ver flota <i class="ri-arrow-right-line"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Tables Row -->
                    <div class="row">
                        <div class="col-xl-6 mb-4">
                            <div class="card data-card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="ri-calendar-event-line"></i> Próximas Reservas
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($latest_reservas)): ?>
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Cliente</th>
                                                        <th>Vehículo</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($latest_reservas as $reserva): ?>
                                                        <tr>
                                                            <td>
                                                                <span class="fw-medium"><?= date('d/m/Y', strtotime($reserva['fecha_reserva'])) ?></span>
                                                                <br>
                                                                <small class="text-muted"><?= date('H:i', strtotime($reserva['fecha_reserva'])) ?></small>
                                                            </td>
                                                            <td><?= esc($reserva['cliente_nombre']) ?></td>
                                                            <td><span class="badge bg-light text-dark"><?= esc($reserva['placa']) ?></span></td>
                                                            <td>
                                                                <span class="badge-status status-<?= strtolower($reserva['estado']) == 'pendiente' ? 'pending' : (strtolower($reserva['estado']) == 'confirmada' ? 'confirmed' : 'progress') ?>">
                                                                    <?= esc($reserva['estado']) ?>
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="empty-state">
                                            <i class="ri-calendar-line"></i>
                                            <p class="mb-0">No hay reservas próximas</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 mb-4">
                            <div class="card data-card">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="ri-hammer-line"></i> Órdenes en Progreso
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($active_ordenes)): ?>
                                        <div class="table-responsive">
                                            <table class="table mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Orden</th>
                                                        <th>Vehículo</th>
                                                        <th>Mecánico</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($active_ordenes as $orden): ?>
                                                        <tr>
                                                            <td>
                                                                <a href="/ordenestrabajo/<?= $orden['id_orden'] ?>" class="fw-semibold text-primary">
                                                                    #<?= str_pad($orden['id_orden'], 4, '0', STR_PAD_LEFT) ?>
                                                                </a>
                                                            </td>
                                                            <td><span class="badge bg-light text-dark"><?= esc($orden['placa']) ?></span></td>
                                                            <td>
                                                                <?php if ($orden['mecanico_nombre']): ?>
                                                                    <span class="d-flex align-items-center gap-2">
                                                                        <span class="avatar-xs">
                                                                            <span class="avatar-title rounded-circle bg-primary-subtle text-primary">
                                                                                <?= strtoupper(substr($orden['mecanico_nombre'], 0, 1)) ?>
                                                                            </span>
                                                                        </span>
                                                                        <?= esc($orden['mecanico_nombre']) ?>
                                                                    </span>
                                                                <?php else: ?>
                                                                    <span class="text-muted fst-italic">Sin asignar</span>
                                                                <?php endif; ?>
                                                            </td>
                                                            <td>
                                                                <a href="/ordenestrabajo/<?= $orden['id_orden'] ?>" class="btn btn-view">
                                                                    <i class="ri-eye-line me-1"></i> Ver
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="empty-state">
                                            <i class="ri-tools-line"></i>
                                            <p class="mb-0">No hay órdenes en progreso</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <?= $this->include('partials/footer') ?>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <?= $this->include('partials/customizer') ?>

    <?= $this->include('partials/vendor-scripts') ?>

    <!-- App js -->
    <script src="/assets/js/app.js"></script>
    
    <!-- Dashboard Time Update -->
    <script>
        // Update current time
        function updateDateTime() {
            const options = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };
            const now = new Date();
            const formatted = now.toLocaleDateString('es-ES', options);
            document.getElementById('current-datetime').textContent = formatted;
        }
        
        // Update every minute
        setInterval(updateDateTime, 60000);
    </script>
</body>

</html>