<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ReservasModel;
use App\Models\DetalleReservaModel;
use App\Models\VehiculosModel;
use App\Models\ServiciosModel;
use App\Models\ClientesModel;

class Reservas extends ResourceController
{
    protected $modelName = 'App\Models\ReservasModel';
    protected $format = 'html';

    public function index()
    {
        $userId = session()->get('id_usuario');
        $role = session()->get('rol');
        $reservas = [];

        if ($role === 'CLIENTE') {
            // Find linked client
            $clientesModel = new ClientesModel();
            $cliente = $clientesModel->where('id_usuario', $userId)->first();

            if ($cliente) {
                $reservas = $this->model->select('reservas.*, vehiculos.placa, vehiculos.marca, vehiculos.modelo')
                    ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
                    ->where('reservas.id_cliente', $cliente['id_cliente'])
                    ->orderBy('fecha_reserva', 'DESC')
                    ->findAll();
            }
        } else {
            // Admin/Employee sees all
            $reservas = $this->model->select('reservas.*, clientes.nombre_completo as cliente_nombre, vehiculos.placa')
                ->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
                ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
                ->orderBy('fecha_reserva', 'DESC')
                ->findAll();
        }

        $data = [
            'reservas' => $reservas,
            'title' => 'Mis Reservas'
        ];
        return view('reservas/index', $data);
    }

    public function new()
    {
        $userId = session()->get('id_usuario');
        $role = session()->get('rol');

        $vehiculosModel = new VehiculosModel();
        $serviciosModel = new ServiciosModel();
        $clientesModel = new ClientesModel();

        $vehiculos = [];
        $clienteId = null;

        if ($role === 'CLIENTE') {
            $cliente = $clientesModel->where('id_usuario', $userId)->first();
            if ($cliente) {
                $clienteId = $cliente['id_cliente'];
                $vehiculos = $vehiculosModel->where('id_cliente', $clienteId)->findAll();
            }
        } else {
            // Admin logic: Ideally select client first, but for now let's load all vehicles or require a refined flow.
            // Simplified: Admin can select any vehicle? 
            // Better: Admin selects a client, then fetching vehicles via AJAX?
            // For MVP: Load all vehicles with owner name.
            $vehiculos = $vehiculosModel->select('vehiculos.*, clientes.nombre_completo as owner_name')
                ->join('clientes', 'clientes.id_cliente = vehiculos.id_cliente')
                ->findAll();
        }

        $data = [
            'vehiculos' => $vehiculos,
            'servicios' => $serviciosModel->findAll(),
            'title' => 'Nueva Reserva',
            'role' => $role
        ];
        return view('reservas/create', $data);
    }

    public function create()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $userId = session()->get('id_usuario');
            $role = session()->get('rol');

            $id_cliente = null;
            $clientesModel = new ClientesModel();

            // Determine Client ID
            if ($role === 'CLIENTE') {
                $cliente = $clientesModel->where('id_usuario', $userId)->first();
                if ($cliente) {
                    $id_cliente = $cliente['id_cliente'];
                }
            } else {
                // If Admin, the form should ideally provide the vehicle which is linked to a client.
                // We can derive id_cliente from the selected id_vehiculo.
                $vehiculosModel = new VehiculosModel();
                $vehicle = $vehiculosModel->find($this->request->getPost('id_vehiculo'));
                if ($vehicle) {
                    $id_cliente = $vehicle['id_cliente'];
                }
            }

            if (!$id_cliente) {
                throw new \Exception("No se pudo identificar al cliente.");
            }

            // 1. Create Reserva
            $reservaData = [
                'id_cliente' => $id_cliente,
                'id_vehiculo' => $this->request->getPost('id_vehiculo'),
                'fecha_reserva' => $this->request->getPost('fecha_reserva'),
                'estado' => 'PENDIENTE'
            ];

            $this->model->insert($reservaData);
            $reservaId = $this->model->getInsertID();

            // 2. Create DetalleReserva (Services)
            $servicios = $this->request->getPost('servicios'); // Array of service IDs
            if (!empty($servicios)) {
                $detalleModel = new DetalleReservaModel();
                $serviciosModel = new ServiciosModel();

                foreach ($servicios as $servicioId) {
                    // Get price at this moment
                    $serviceInfo = $serviciosModel->find($servicioId);

                    $detalleData = [
                        'id_reserva' => $reservaId,
                        'id_servicio' => $servicioId,
                        'precio_unitario_momento' => $serviceInfo['costo_mano_obra']
                    ];
                    $detalleModel->insert($detalleData);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->back()->withInput()->with('error', 'Error al crear la reserva.');
            }

            return redirect()->to('/reservas')->with('message', 'Reserva creada exitosamente');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cancel($id = null)
    {
        $reserva = $this->model->find($id);
        if (!$reserva) {
            return redirect()->to('/reservas')->with('error', 'Reserva no encontrada');
        }

        $fechaReserva = strtotime($reserva['fecha_reserva']);
        $ahora = time();
        $diferenciaHoras = ($fechaReserva - $ahora) / 3600;

        // Allow Admin to cancel anytime? For now apply rule to all.
        if ($diferenciaHoras < 2) {
            return redirect()->to('/reservas')->with('error', 'No se puede cancelar con menos de 2 horas de antelación.');
        }

        $this->model->update($id, ['estado' => 'CANCELADA']);
        return redirect()->to('/reservas')->with('message', 'Reserva cancelada exitosamente');
    }
}
