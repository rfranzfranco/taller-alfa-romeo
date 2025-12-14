<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #<?= $factura['id_factura'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: #f5f5f5;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        
        .invoice-header {
            background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .company-info h1 {
            font-size: 22px;
            margin-bottom: 3px;
            font-weight: 700;
        }
        
        .company-info p {
            opacity: 0.9;
            font-size: 10px;
            margin: 1px 0;
        }
        
        .company-logo {
            text-align: center;
            padding: 10px;
        }
        
        .company-logo i {
            font-size: 50px;
        }
        
        .invoice-title {
            text-align: right;
        }
        
        .invoice-title h2 {
            font-size: 28px;
            font-weight: 300;
            letter-spacing: 2px;
        }
        
        .invoice-number {
            background: rgba(255,255,255,0.2);
            padding: 5px 12px;
            border-radius: 5px;
            margin-top: 5px;
            display: inline-block;
            font-size: 12px;
        }
        
        .invoice-body {
            padding: 30px;
        }
        
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            gap: 30px;
        }
        
        .info-box {
            flex: 1;
            padding: 20px;
            background: #f8fafc;
            border-radius: 8px;
            border-left: 4px solid #2c5282;
        }
        
        .info-box h3 {
            color: #2c5282;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            font-weight: 600;
        }
        
        .info-box p {
            margin: 5px 0;
        }
        
        .info-box strong {
            color: #1a365d;
        }
        
        .vehicle-info {
            border-left-color: #38a169;
        }
        
        .vehicle-info h3 {
            color: #38a169;
        }
        
        .invoice-details {
            border-left-color: #d69e2e;
        }
        
        .invoice-details h3 {
            color: #d69e2e;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .items-table thead th {
            background: #2c5282;
            color: white;
            padding: 12px 15px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items-table thead th:last-child,
        .items-table thead th:nth-child(3),
        .items-table thead th:nth-child(4) {
            text-align: right;
        }
        
        .items-table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .items-table tbody td:last-child,
        .items-table tbody td:nth-child(3),
        .items-table tbody td:nth-child(4) {
            text-align: right;
        }
        
        .items-table tbody tr:hover {
            background: #f7fafc;
        }
        
        .section-title {
            background: #edf2f7;
            padding: 10px 15px;
            font-weight: 600;
            color: #2d3748;
            font-size: 13px;
            border-left: 4px solid #2c5282;
            margin: 20px 0 0 0;
        }
        
        .section-title.insumos {
            border-left-color: #38a169;
        }
        
        .subtotal-row td {
            background: #f7fafc;
            font-weight: 600;
            border-top: 2px solid #e2e8f0;
        }
        
        .totals-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }
        
        .totals-box {
            width: 300px;
        }
        
        .totals-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .totals-row.total {
            background: #2c5282;
            color: white;
            font-size: 16px;
            font-weight: 700;
            border-radius: 0 0 8px 8px;
        }
        
        .payment-info {
            margin-top: 30px;
            padding: 20px;
            background: #f0fff4;
            border-radius: 8px;
            border: 1px solid #9ae6b4;
        }
        
        .payment-info.pending {
            background: #fffbeb;
            border-color: #fbd38d;
        }
        
        .payment-info h4 {
            color: #276749;
            margin-bottom: 10px;
            font-size: 13px;
        }
        
        .payment-info.pending h4 {
            color: #975a16;
        }
        
        .payment-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
        }
        
        .payment-item label {
            font-size: 10px;
            color: #718096;
            text-transform: uppercase;
        }
        
        .payment-item p {
            font-weight: 600;
            color: #2d3748;
        }
        
        .invoice-footer {
            background: #1a365d;
            color: white;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .footer-text {
            font-size: 11px;
            opacity: 0.8;
        }
        
        .footer-text p {
            margin: 3px 0;
        }
        
        .qr-placeholder {
            width: 60px;
            height: 60px;
            background: white;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1a365d;
            font-size: 8px;
            text-align: center;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .badge-success {
            background: #c6f6d5;
            color: #276749;
        }
        
        .badge-warning {
            background: #fefcbf;
            color: #975a16;
        }
        
        .print-actions {
            text-align: center;
            padding: 20px;
            background: white;
            max-width: 800px;
            margin: 0 auto 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 30px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            border: none;
            font-size: 14px;
            margin: 0 5px;
        }
        
        .btn-primary {
            background: #2c5282;
            color: white;
        }
        
        .btn-secondary {
            background: #718096;
            color: white;
        }
        
        .btn:hover {
            opacity: 0.9;
        }
        
        /* Print Styles */
        @media print {
            body {
                background: white;
            }
            
            .invoice-container {
                box-shadow: none;
                margin: 0;
                max-width: 100%;
            }
            
            .print-actions {
                display: none;
            }
            
            .invoice-header {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .items-table thead th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .totals-row.total {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .invoice-footer {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <!-- Print Actions -->
    <div class="print-actions">
        <button class="btn btn-primary" onclick="window.print()">
            🖨️ Imprimir Factura
        </button>
        <button class="btn btn-secondary" onclick="window.close()">
            ← Volver al Detalle
        </button>
    </div>

    <div class="invoice-container">
        <!-- Header -->
        <div class="invoice-header">
            <div class="company-info">
                <h1>🔧 TALLER AUTOMOTRIZ</h1>
                <p>Servicios de Mantenimiento y Reparación</p>
                <p>Dirección: Av. Principal #123, Ciudad</p>
                <p>Teléfono: (123) 456-7890 | Email: taller@ejemplo.com</p>
                <p>NIT: 1234567890</p>
            </div>
            <div class="invoice-title">
                <h2>FACTURA</h2>
                <div class="invoice-number">
                    N° <?= str_pad($factura['id_factura'], 6, '0', STR_PAD_LEFT) ?>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="invoice-body">
            <!-- Info Section -->
            <div class="info-section">
                <div class="info-box">
                    <h3>📋 Datos del Cliente</h3>
                    <p><strong><?= esc($orden['cliente_nombre']) ?></strong></p>
                    <p>NIT/CI: <?= esc($factura['nit_facturacion']) ?></p>
                    <p>Razón Social: <?= esc($factura['razon_social']) ?></p>
                    <p>Tel: <?= esc($orden['telefono']) ?></p>
                    <p>Email: <?= esc($orden['correo']) ?></p>
                </div>
                
                <div class="info-box vehicle-info">
                    <h3>🚗 Datos del Vehículo</h3>
                    <p><strong>Placa: <?= esc($orden['placa']) ?></strong></p>
                    <p><?= esc($orden['marca']) ?> <?= esc($orden['modelo']) ?> (<?= esc($orden['anio']) ?>)</p>
                    <p>Motor: <?= esc($orden['tipo_motor']) ?></p>
                    <p>Color: <?= esc($orden['color']) ?></p>
                </div>
                
                <div class="info-box invoice-details">
                    <h3>📅 Datos de Factura</h3>
                    <p><strong>Fecha Emisión:</strong></p>
                    <p><?= date('d/m/Y H:i', strtotime($factura['fecha_emision'])) ?></p>
                    <p><strong>Estado:</strong></p>
                    <p>
                        <?php if ($factura['estado_pago'] == 'PAGADO'): ?>
                            <span class="badge badge-success">PAGADO</span>
                        <?php else: ?>
                            <span class="badge badge-warning"><?= $factura['estado_pago'] ?></span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>

            <!-- Services Table -->
            <div class="section-title">🔧 SERVICIOS REALIZADOS (Mano de Obra)</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 60%">Descripción</th>
                        <th style="width: 15%">Cantidad</th>
                        <th style="width: 25%">Precio (Bs.)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($servicios as $servicio): ?>
                    <tr>
                        <td><?= esc($servicio['nombre']) ?></td>
                        <td style="text-align: center;">1</td>
                        <td><?= number_format($servicio['costo_mano_obra'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="subtotal-row">
                        <td colspan="2" style="text-align: right;">Subtotal Servicios:</td>
                        <td>Bs. <?= number_format($totalServicios, 2) ?></td>
                    </tr>
                </tbody>
            </table>

            <!-- Supplies Table -->
            <?php if (!empty($insumos)): ?>
            <div class="section-title insumos">📦 REPUESTOS E INSUMOS UTILIZADOS</div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 15%">Código</th>
                        <th style="width: 35%">Descripción</th>
                        <th style="width: 15%">Cantidad</th>
                        <th style="width: 17%">P. Unit. (Bs.)</th>
                        <th style="width: 18%">Total (Bs.)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($insumos as $insumo): ?>
                    <tr>
                        <td><?= esc($insumo['codigo']) ?></td>
                        <td><?= esc($insumo['nombre']) ?></td>
                        <td style="text-align: center;"><?= $insumo['cantidad'] ?></td>
                        <td><?= number_format($insumo['costo_unitario'], 2) ?></td>
                        <td><?= number_format($insumo['cantidad'] * $insumo['costo_unitario'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="subtotal-row">
                        <td colspan="4" style="text-align: right;">Subtotal Insumos:</td>
                        <td>Bs. <?= number_format($totalInsumos, 2) ?></td>
                    </tr>
                </tbody>
            </table>
            <?php endif; ?>

            <!-- Totals -->
            <div class="totals-section">
                <div class="totals-box">
                    <div class="totals-row">
                        <span>Subtotal Servicios:</span>
                        <span>Bs. <?= number_format($totalServicios, 2) ?></span>
                    </div>
                    <div class="totals-row">
                        <span>Subtotal Insumos:</span>
                        <span>Bs. <?= number_format($totalInsumos, 2) ?></span>
                    </div>
                    <div class="totals-row total">
                        <span>TOTAL A PAGAR:</span>
                        <span>Bs. <?= number_format($totalGeneral, 2) ?></span>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <?php if ($factura['estado_pago'] == 'PAGADO'): ?>
            <div class="payment-info">
                <h4>✅ INFORMACIÓN DE PAGO</h4>
                <div class="payment-grid">
                    <div class="payment-item">
                        <label>Monto Pagado</label>
                        <p>Bs. <?= number_format($factura['monto_pagado'] ?? $totalGeneral, 2) ?></p>
                    </div>
                    <div class="payment-item">
                        <label>Método de Pago</label>
                        <p><?= esc($factura['metodo_pago'] ?? 'N/A') ?></p>
                    </div>
                    <div class="payment-item">
                        <label>Fecha de Pago</label>
                        <p><?= $factura['fecha_pago'] ? date('d/m/Y H:i', strtotime($factura['fecha_pago'])) : 'N/A' ?></p>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="payment-info pending">
                <h4>⏳ PAGO PENDIENTE</h4>
                <p>Esta factura aún no ha sido pagada. El monto total a pagar es de <strong>Bs. <?= number_format($totalGeneral, 2) ?></strong></p>
            </div>
            <?php endif; ?>

            <!-- Technical Notes -->
            <?php if (!empty($orden['observaciones_tecnicas'])): ?>
            <div style="margin-top: 20px; padding: 15px; background: #f7fafc; border-radius: 8px; border-left: 4px solid #718096;">
                <h4 style="color: #4a5568; font-size: 12px; margin-bottom: 8px;">📝 OBSERVACIONES TÉCNICAS:</h4>
                <p style="color: #718096;"><?= nl2br(esc($orden['observaciones_tecnicas'])) ?></p>
            </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="invoice-footer">
            <div class="footer-text">
                <p><strong>¡Gracias por su preferencia!</strong></p>
                <p>Este documento es una representación impresa de la factura.</p>
                <p>Técnico responsable: <?= esc($orden['tecnico_nombre']) ?></p>
            </div>
            <div class="qr-placeholder">
                <span>QR<br>CODE</span>
            </div>
        </div>
    </div>

    <script>
        // Auto print if requested via URL parameter
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('autoprint') === '1') {
            window.print();
        }
    </script>
</body>
</html>
