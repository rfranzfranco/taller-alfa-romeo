<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class DetalleReserva extends ResourceController
{
    protected $modelName = 'App\Models\DetalleReservaModel';
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

        // RF-07: Gestión automática de inventario
        if (!empty($data['id_insumo']) && !empty($data['cantidad_insumo'])) {
            $insumoModel = new \App\Models\InsumosModel();
            $insumo = $insumoModel->find($data['id_insumo']);

            if (!$insumo) {
                return $this->failNotFound('Insumo no encontrado');
            }

            if ($insumo['stock_actual'] < $data['cantidad_insumo']) {
                return $this->fail('Stock insuficiente. Disponible: ' . $insumo['stock_actual']);
            }

            // Deduct stock
            $newStock = $insumo['stock_actual'] - $data['cantidad_insumo'];
            $insumoModel->update($data['id_insumo'], ['stock_actual' => $newStock]);

            // RF-08: Alertas de stock mínimo
            if ($newStock <= $insumo['stock_minimo']) {
                // In a real app, this might send an email or notification
                $data['warning'] = "ALERTA: El insumo '{$insumo['nombre']}' ha alcanzado el stock mínimo ($newStock).";
            }
        }

        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }

        $responseMsg = 'Detalle agregado.';
        if (isset($data['warning'])) {
            $responseMsg .= ' ' . $data['warning'];
        }

        return $this->respondCreated($data, $responseMsg);
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
}
