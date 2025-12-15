<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Insumos extends ResourceController
{
    protected $modelName = 'App\Models\InsumosModel';
    protected $format = 'html';

    private function requireAdmin()
    {
        if (session()->get('rol') !== 'ADMIN') {
            return redirect()->to('/')->with('error', 'No tiene permisos para acceder al inventario.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = [
            'insumos' => $this->model->findAll(),
            'title' => 'Gestión de Inventario'
        ];
        return view('insumos/index', $data);
    }

    public function new()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $data = [
            'title' => 'Nuevo Insumo'
        ];
        return view('insumos/create', $data);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'codigo' => 'required|is_unique[insumos.codigo]|min_length[3]',
            'nombre' => 'required|min_length[3]',
            'precio_venta' => 'required|decimal',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'codigo' => $this->request->getPost('codigo'),
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio_venta' => $this->request->getPost('precio_venta'),
            'stock_actual' => $this->request->getPost('stock_actual'),
            'stock_minimo' => $this->request->getPost('stock_minimo'),
        ];

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/insumos')->with('message', 'Insumo creado exitosamente');
    }

    public function show($id = null)
    {
        $insumo = $this->model->find($id);
        if (!$insumo) {
            return redirect()->to('/insumos')->with('error', 'Insumo no encontrado');
        }

        // Obtener historial de uso en reservas
        $db = \Config\Database::connect();
        $historial = $db->table('detalle_reserva')
            ->where('id_insumo', $id)
            ->orderBy('id_detalle', 'DESC')
            ->get()->getResultArray();

        $data = [
            'insumo' => $insumo,
            'historial' => $historial,
            'title' => 'Detalle de Insumo'
        ];
        return view('insumos/show', $data);
    }

    public function edit($id = null)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $insumo = $this->model->find($id);
        if (!$insumo) {
            return redirect()->to('/insumos')->with('error', 'Insumo no encontrado');
        }

        $data = [
            'insumo' => $insumo,
            'title' => 'Editar Insumo'
        ];
        return view('insumos/edit', $data);
    }

    public function update($id = null)
    {        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }
        $insumo = $this->model->find($id);
        if (!$insumo) {
            return redirect()->to('/insumos')->with('error', 'Insumo no encontrado');
        }

        $rules = [
            'codigo' => "required|is_unique[insumos.codigo,id_insumo,{$id}]|min_length[3]",
            'nombre' => 'required|min_length[3]',
            'precio_venta' => 'required|decimal',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'codigo' => $this->request->getPost('codigo'),
            'nombre' => $this->request->getPost('nombre'),
            'descripcion' => $this->request->getPost('descripcion'),
            'precio_venta' => $this->request->getPost('precio_venta'),
            'stock_actual' => $this->request->getPost('stock_actual'),
            'stock_minimo' => $this->request->getPost('stock_minimo'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/insumos')->with('message', 'Insumo actualizado exitosamente');
    }

    public function delete($id = null)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        if ($this->model->delete($id)) {
            return redirect()->to('/insumos')->with('message', 'Insumo eliminado exitosamente');
        }
        return redirect()->to('/insumos')->with('error', 'No se pudo eliminar el insumo');
    }
}
