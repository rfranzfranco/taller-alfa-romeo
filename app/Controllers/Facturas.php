<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class Facturas extends ResourceController
{
    protected $modelName = 'App\Models\FacturasModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data)
            return $this->failNotFound('No Data Found with id ' . $id);
        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respondCreated($data, 'Data Created');
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respond($data, 200, 'Data Updated');
    }

    public function delete($id = null)
    {
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
        $factura = $this->model->where('id_orden', $idOrden)->first();
        if (!$factura)
            return $this->failNotFound('Factura no encontrada para esta orden');
        return $this->respond($factura);
    }
}
