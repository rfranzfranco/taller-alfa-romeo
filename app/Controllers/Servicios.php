<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Servicios extends ResourceController
{
    protected $modelName = 'App\Models\ServiciosModel';
    protected $format = 'html';

    public function index()
    {
        $data = [
            'servicios' => $this->model->findAll(),
            'title' => 'Catálogo de Servicios'
        ];
        return view('servicios/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Nuevo Servicio'
        ];
        return view('servicios/create', $data);
    }

    public function create()
    {
        $rules = [
            'nombre' => 'required|min_length[3]',
            'costo_mano_obra' => 'required|decimal',
            'tiempo_estimado' => 'required|integer' // Minutes
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        // Handle Checkbox
        if (!isset($data['requiere_rampa'])) {
            $data['requiere_rampa'] = 0;
        }

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/servicios')->with('message', 'Servicio creado exitosamente');
    }

    public function edit($id = null)
    {
        $servicio = $this->model->find($id);
        if (!$servicio) {
            return redirect()->to('/servicios')->with('error', 'Servicio no encontrado');
        }

        $data = [
            'servicio' => $servicio,
            'title' => 'Editar Servicio'
        ];
        return view('servicios/edit', $data);
    }

    public function update($id = null)
    {
        $servicio = $this->model->find($id);
        if (!$servicio) {
            return redirect()->to('/servicios')->with('error', 'Servicio no encontrado');
        }

        $rules = [
            'nombre' => 'required|min_length[3]',
            'costo_mano_obra' => 'required|decimal',
            'tiempo_estimado' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        // Handle Checkbox
        if (!isset($data['requiere_rampa'])) {
            $data['requiere_rampa'] = 0;
        }

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/servicios')->with('message', 'Servicio actualizado exitosamente');
    }

    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/servicios')->with('message', 'Servicio eliminado exitosamente');
        }
        return redirect()->to('/servicios')->with('error', 'No se pudo eliminar el servicio');
    }
}
