<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Clientes extends ResourceController
{
    protected $modelName = 'App\Models\ClientesModel';
    protected $format = 'html';

    public function index()
    {
        $data = [
            'clientes' => $this->model->findAll(),
            'title' => 'Gestión de Clientes'
        ];
        return view('clientes/index', $data);
    }

    // Since Clients usually require a User account, we might redirect to user creation 
    // or assume this controller handles creating the Client RECORD linked to an existing user?
    // Given the previous task, User Creation creates both. 
    // So "New Client" here could just redirect to /usuarios/new with a query param?
    // Let's make it simple: basic CRUD for the CLIENT details. 
    // If they want a NEW client, they should go to Users > New.
    // Or I can just redirect New to /usuarios/new
    public function new()
    {
        return redirect()->to('/usuarios/new?role=CLIENTE')->with('message', 'Para registrar un nuevo cliente, cree un usuario con rol CLIENTE.');
    }

    public function show($id = null)
    {
        $cliente = $this->model->find($id);
        if (!$cliente) {
            return redirect()->to('/clientes')->with('error', 'Cliente no encontrado');
        }

        // Obtener vehículos del cliente
        $vehiculosModel = new \App\Models\VehiculosModel();
        $vehiculos = $vehiculosModel->where('id_cliente', $id)->findAll();

        // Obtener reservas del cliente
        $db = \Config\Database::connect();
        $reservas = $db->table('reservas r')
            ->select('r.*, v.placa')
            ->join('vehiculos v', 'v.id_vehiculo = r.id_vehiculo', 'left')
            ->where('r.id_cliente', $id)
            ->orderBy('r.fecha_reserva', 'DESC')
            ->get()->getResultArray();

        $data = [
            'cliente' => $cliente,
            'vehiculos' => $vehiculos,
            'reservas' => $reservas,
            'title' => 'Detalle de Cliente'
        ];
        return view('clientes/show', $data);
    }

    public function edit($id = null)
    {
        $cliente = $this->model->find($id);
        if (!$cliente) {
            return redirect()->to('/clientes')->with('error', 'Cliente no encontrado');
        }

        $data = [
            'cliente' => $cliente,
            'title' => 'Editar Cliente'
        ];
        return view('clientes/edit', $data);
    }

    public function update($id = null)
    {
        $cliente = $this->model->find($id);
        if (!$cliente) {
            return redirect()->to('/clientes')->with('error', 'Cliente no encontrado');
        }

        $rules = [
            'nombre_completo' => 'required|min_length[5]',
            'ci_nit' => "required|min_length[5]",
            // Unique check if needed? 'ci_nit' => 'required|is_unique[clientes.ci_nit,id_cliente,{id}]'
            'telefono' => 'required',
            'correo' => 'required|valid_email' // Basic email check
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre_completo' => $this->request->getPost('nombre_completo'),
            'ci_nit' => $this->request->getPost('ci_nit'),
            'telefono' => $this->request->getPost('telefono'),
            'correo' => $this->request->getPost('correo'),
            'direccion' => $this->request->getPost('direccion'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/clientes')->with('message', 'Datos del cliente actualizados exitosamente');
    }

    public function delete($id = null)
    {
        // Deleting a client is sensitive because of the User link.
        // Usually we delete the User, which deletes the client?
        // Or if we delete here, do we leave an orphan User?
        // For now, let's just delete the Client record. 
        // Warning: This creates a user with no client data if that was their only role.
        if ($this->model->delete($id)) {
            return redirect()->to('/clientes')->with('message', 'Cliente eliminado exitosamente');
        }
        return redirect()->to('/clientes')->with('error', 'No se pudo eliminar el cliente');
    }
}
