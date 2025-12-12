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

        // Calculate total
        // 1. Service Cost (from reservation or order? Schema links detail->reserva->sevicio)
        // Need to traverse: Orden -> Reserva -> DetalleReserva
        $ordenModel = new \App\Models\OrdenesTrabajoModel();
        $orden = $ordenModel->find($idOrden);

        if (!$orden)
            return $this->failNotFound('Orden no encontrada');

        $builder = $db->table('detalle_reserva dr');
        $builder->select('dr.precio_unitario_momento, dr.cantidad_insumo, s.costo_mano_obra');
        $builder->join('servicios s', 's.id_servicio = dr.id_servicio');
        $builder->where('dr.id_reserva', $orden['id_reserva']);
        $detalles = $builder->get()->getResultArray();

        $total = 0;
        foreach ($detalles as $det) {
            // Cost logic: (Insumo unit price * Qty) + Labor Cost? 
            // The schema has 'precio_unitario_momento' in detalle_reserva. Assuming this is for the insumo.
            // And labor cost is in services.
            $insumoCost = $det['precio_unitario_momento'] * $det['cantidad_insumo'];
            $manoObra = $det['costo_mano_obra'];
            $total += ($insumoCost + $manoObra);
        }

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

        $this->model->update($id, ['estado_pago' => 'PAGADO']);

        return $this->respond(['message' => 'Pago registrado correctamente']);
    }
}
