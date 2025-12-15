<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class Facturas extends ResourceController
{
    protected $modelName = 'App\Models\FacturasModel';
    protected $format = 'json';

    private function requireStaff()
    {
        $role = session()->get('rol');
        if ($role !== 'ADMIN' && $role !== 'EMPLEADO') {
            return redirect()->to('/')->with('error', 'No tiene permisos para acceder a facturación.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireStaff()) {
            return $redirect;
        }

        $db = \Config\Database::connect();
        
        // Obtener todas las facturas con información relacionada
        $facturas = $this->model->select('facturas.*, ordenes_trabajo.id_reserva, vehiculos.placa, vehiculos.marca, vehiculos.modelo, clientes.nombre_completo as cliente_nombre')
            ->join('ordenes_trabajo', 'ordenes_trabajo.id_orden = facturas.id_orden')
            ->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
            ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
            ->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
            ->orderBy('facturas.fecha_emision', 'DESC')
            ->findAll();

        $data = [
            'title' => 'Facturación',
            'facturas' => $facturas
        ];

        return view('facturas/index', $data);
    }

    public function show($id = null)
    {
        if ($redirect = $this->requireStaff()) {
            return $redirect;
        }

        $data = $this->model->find($id);
        if (!$data)
            return $this->failNotFound('No Data Found with id ' . $id);
        return $this->respond($data);
    }

    public function create()
    {
        if ($redirect = $this->requireStaff()) {
            return $redirect;
        }

        $data = $this->request->getPost();
        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respondCreated($data, 'Data Created');
    }

    public function update($id = null)
    {
        if ($redirect = $this->requireStaff()) {
            return $redirect;
        }

        $data = $this->request->getRawInput();
        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respond($data, 200, 'Data Updated');
    }

    public function delete($id = null)
    {
        if ($redirect = $this->requireStaff()) {
            return $redirect;
        }

        $data = $this->model->find($id);
        if ($data) {
            $this->model->delete($id);
            return $this->respondDeleted($data, 'Data Deleted');
        }
        return $this->failNotFound('No Data Found with id ' . $id);
    }

    // RF-09: Generación de facturas
    public function generate($idOrden = null)
    {
        if ($redirect = $this->requireStaff()) {
            return $redirect;
        }

        $db = \Config\Database::connect();

        // Check if invoice already exists
        $existing = $this->model->where('id_orden', $idOrden)->first();
        if ($existing) {
            return $this->fail('La factura ya existe para esta orden');
        }

        // Get order info
        $ordenModel = new \App\Models\OrdenesTrabajoModel();
        $orden = $ordenModel->find($idOrden);

        if (!$orden)
            return $this->failNotFound('Orden no encontrada');

        // Calculate total from services (costo_mano_obra)
        $builderServicios = $db->table('detalle_reserva dr');
        $builderServicios->selectSum('s.costo_mano_obra', 'total_servicios');
        $builderServicios->join('servicios s', 's.id_servicio = dr.id_servicio');
        $builderServicios->where('dr.id_reserva', $orden['id_reserva']);
        $resultServicios = $builderServicios->get()->getRowArray();
        $totalServicios = $resultServicios['total_servicios'] ?? 0;

        // Calculate total from supplies/parts (detalle_insumos_orden)
        $builderInsumos = $db->table('detalle_insumos_orden dio');
        $builderInsumos->select('SUM(dio.cantidad * dio.costo_unitario) as total_insumos');
        $builderInsumos->where('dio.id_orden', $idOrden);
        $resultInsumos = $builderInsumos->get()->getRowArray();
        $totalInsumos = $resultInsumos['total_insumos'] ?? 0;

        $total = $totalServicios + $totalInsumos;

        $facturaData = [
            'id_orden' => $idOrden,
            'fecha_emision' => date('Y-m-d H:i:s'),
            'monto_total' => $total,
            'nit_facturacion' => $this->request->getVar('nit') ?? '0',
            'razon_social' => $this->request->getVar('razon_social') ?? 'SN',
            'estado_pago' => 'PENDIENTE'
        ];

        $this->model->save($facturaData);
        $newId = $this->model->getInsertID();

        return $this->respondCreated(['id_factura' => $newId, 'monto_total' => $total], 'Factura generada');
    }

    // RF-10: Registro de pagos
    public function pay($id = null)
    {
        if ($redirect = $this->requireStaff()) {
            return $redirect;
        }

        $factura = $this->model->find($id);
        if (!$factura)
            return $this->failNotFound('Factura no encontrada');

        $monto = $this->request->getVar('monto_pagado');
        $metodoPago = $this->request->getVar('metodo_pago');
        $fechaPago = $this->request->getVar('fecha_pago');

        // Validate required fields
        if (empty($monto) || empty($metodoPago) || empty($fechaPago)) {
            return $this->fail('Todos los campos son requeridos: monto, método de pago y fecha');
        }

        $updateData = [
            'estado_pago' => 'PAGADO',
            'monto_pagado' => $monto,
            'metodo_pago' => $metodoPago,
            'fecha_pago' => $fechaPago
        ];

        $this->model->update($id, $updateData);

        return $this->respond([
            'message' => 'Pago registrado correctamente',
            'factura' => array_merge($factura, $updateData)
        ]);
    }

    // Get invoice by order ID
    public function getByOrden($idOrden = null)
    {
        if ($redirect = $this->requireStaff()) {
            return $redirect;
        }

        $factura = $this->model->where('id_orden', $idOrden)->first();
        if (!$factura)
            return $this->failNotFound('Factura no encontrada para esta orden');
        return $this->respond($factura);
    }

    // RF-09: Vista de factura para imprimir/PDF
    public function print($id = null)
    {
        $db = \Config\Database::connect();
        $role = session()->get('rol');
        
        // Get invoice data
        $factura = $this->model->find($id);
        if (!$factura) {
            return redirect()->back()->with('error', 'Factura no encontrada');
        }

        // Get order data
        $ordenModel = new \App\Models\OrdenesTrabajoModel();
        $orden = $ordenModel->select('ordenes_trabajo.*, reservas.fecha_reserva, reservas.id_cliente, clientes.nombre_completo as cliente_nombre, clientes.telefono, clientes.correo, clientes.direccion, vehiculos.placa, vehiculos.marca, vehiculos.modelo, vehiculos.anio, vehiculos.tipo_motor, vehiculos.color, empleados.nombre_completo as tecnico_nombre')
            ->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
            ->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
            ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
            ->join('empleados', 'empleados.id_empleado = ordenes_trabajo.id_empleado_asignado')
            ->where('ordenes_trabajo.id_orden', $factura['id_orden'])
            ->first();

        // Verificar permisos para CLIENTE - solo puede ver facturas de sus propios servicios pagados
        if ($role === 'CLIENTE') {
            $userId = session()->get('id_usuario');
            $clientesModel = new \App\Models\ClientesModel();
            $cliente = $clientesModel->where('id_usuario', $userId)->first();
            
            if (!$cliente || $orden['id_cliente'] != $cliente['id_cliente']) {
                return redirect()->to('/historial')->with('error', 'No tiene permiso para ver esta factura.');
            }
            
            // Solo facturas pagadas
            if ($factura['estado_pago'] !== 'PAGADO') {
                return redirect()->to('/historial')->with('error', 'Solo puede ver facturas de servicios pagados.');
            }
        }

        // Get services
        $detalleReservaModel = new \App\Models\DetalleReservaModel();
        $servicios = $detalleReservaModel->select('servicios.nombre, servicios.costo_mano_obra')
            ->join('servicios', 'servicios.id_servicio = detalle_reserva.id_servicio')
            ->where('id_reserva', $orden['id_reserva'])
            ->findAll();

        // Get supplies/parts
        $detalleInsumosModel = new \App\Models\DetalleInsumosOrdenModel();
        $insumos = $detalleInsumosModel->select('detalle_insumos_orden.*, insumos.nombre, insumos.codigo')
            ->join('insumos', 'insumos.id_insumo = detalle_insumos_orden.id_insumo')
            ->where('id_orden', $factura['id_orden'])
            ->findAll();

        // Calculate totals
        $totalServicios = 0;
        foreach ($servicios as $servicio) {
            $totalServicios += $servicio['costo_mano_obra'];
        }

        $totalInsumos = 0;
        foreach ($insumos as $insumo) {
            $totalInsumos += ($insumo['cantidad'] * $insumo['costo_unitario']);
        }

        $data = [
            'factura' => $factura,
            'orden' => $orden,
            'servicios' => $servicios,
            'insumos' => $insumos,
            'totalServicios' => $totalServicios,
            'totalInsumos' => $totalInsumos,
            'totalGeneral' => $totalServicios + $totalInsumos,
            'title' => 'Factura #' . $factura['id_factura']
        ];

        return view('facturas/print', $data);
    }
}
