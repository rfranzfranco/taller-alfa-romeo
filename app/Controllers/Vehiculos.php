<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ClientesModel;

class Vehiculos extends ResourceController
{
    protected $modelName = 'App\Models\VehiculosModel';
    protected $format = 'html';

    // Helper para obtener id_cliente del usuario actual si es CLIENTE
    private function getClienteIdForCurrentUser()
    {
        if (session()->get('rol') === 'CLIENTE') {
            $userId = session()->get('id_usuario');
            $clientesModel = new ClientesModel();
            $cliente = $clientesModel->where('id_usuario', $userId)->first();
            return $cliente ? $cliente['id_cliente'] : null;
        }
        return null;
    }

    public function index()
    {
        $role = session()->get('rol');

        if ($role === 'CLIENTE') {
            $clienteId = $this->getClienteIdForCurrentUser();
            if (!$clienteId) {
                return redirect()->to('/')->with('error', 'No se encontró su perfil de cliente.');
            }
            $data['vehiculos'] = $this->model->select('vehiculos.*, clients.nombre_completo as nombre_cliente')
                ->join('clientes as clients', 'clients.id_cliente = vehiculos.id_cliente')
                ->where('vehiculos.id_cliente', $clienteId)
                ->findAll();
            $data['title'] = 'Mis Vehículos';
            $data['isCliente'] = true;
        } else {
            $data['vehiculos'] = $this->model->select('vehiculos.*, clients.nombre_completo as nombre_cliente')
                ->join('clientes as clients', 'clients.id_cliente = vehiculos.id_cliente')
                ->findAll();
            $data['title'] = 'Gestión de Vehículos';
            $data['isCliente'] = false;
        }

        return view('vehiculos/index', $data);
    }

    public function new()
    {
        $role = session()->get('rol');
        $clientesModel = new ClientesModel();

        if ($role === 'CLIENTE') {
            $clienteId = $this->getClienteIdForCurrentUser();
            if (!$clienteId) {
                return redirect()->to('/vehiculos')->with('error', 'No se encontró su perfil de cliente.');
            }
            $cliente = $clientesModel->find($clienteId);
            $data = [
                'clientes' => [$cliente],
                'clienteId' => $clienteId,
                'title' => 'Registrar Mi Vehículo',
                'isCliente' => true
            ];
        } else {
            $data = [
                'clientes' => $clientesModel->findAll(),
                'clienteId' => null,
                'title' => 'Registrar Vehículo',
                'isCliente' => false
            ];
        }

        return view('vehiculos/create', $data);
    }

    public function create()
    {
        $role = session()->get('rol');

        if ($role === 'CLIENTE') {
            $clienteId = $this->getClienteIdForCurrentUser();
            if (!$clienteId) {
                return redirect()->to('/vehiculos')->with('error', 'No se encontró su perfil de cliente.');
            }
            // Forzar que el vehículo se registre a su propio cliente
            $_POST['id_cliente'] = $clienteId;
        }

        $rules = [
            'id_cliente' => 'required|integer',
            'placa' => 'required|is_unique[vehiculos.placa]|min_length[5]',
            'marca' => 'required',
            'modelo' => 'required',
            'anio' => 'required|numeric|exact_length[4]',
            'tipo_motor' => 'required',
            'color' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        if (!$this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/vehiculos')->with('message', 'Vehículo registrado exitosamente');
    }

    public function show($id = null)
    {
        $vehiculo = $this->model->find($id);
        if (!$vehiculo) {
            return redirect()->to('/vehiculos')->with('error', 'Vehículo no encontrado');
        }

        // Verificar que el cliente sea propietario
        if (session()->get('rol') === 'CLIENTE') {
            $clienteId = $this->getClienteIdForCurrentUser();
            if ($vehiculo['id_cliente'] != $clienteId) {
                return redirect()->to('/vehiculos')->with('error', 'No tiene permiso para ver este vehículo.');
            }
        }

        // Obtener propietario
        $clientesModel = new ClientesModel();
        $cliente = $clientesModel->find($vehiculo['id_cliente']);

        // Obtener historial de reservas
        $db = \Config\Database::connect();
        $reservas = $db->table('reservas')
            ->where('id_vehiculo', $id)
            ->orderBy('fecha_reserva', 'DESC')
            ->get()->getResultArray();

        $data = [
            'vehiculo' => $vehiculo,
            'cliente' => $cliente,
            'reservas' => $reservas,
            'title' => 'Detalle de Vehículo'
        ];
        return view('vehiculos/show', $data);
    }

    public function edit($id = null)
    {
        $vehiculo = $this->model->find($id);
        if (!$vehiculo) {
            return redirect()->to('/vehiculos')->with('error', 'Vehículo no encontrado');
        }

        $role = session()->get('rol');
        $clientesModel = new ClientesModel();

        if ($role === 'CLIENTE') {
            $clienteId = $this->getClienteIdForCurrentUser();
            if ($vehiculo['id_cliente'] != $clienteId) {
                return redirect()->to('/vehiculos')->with('error', 'No tiene permiso para editar este vehículo.');
            }
            $cliente = $clientesModel->find($clienteId);
            $data = [
                'vehiculo' => $vehiculo,
                'clientes' => [$cliente],
                'title' => 'Editar Mi Vehículo',
                'isCliente' => true
            ];
        } else {
            $data = [
                'vehiculo' => $vehiculo,
                'clientes' => $clientesModel->findAll(), // In case owner is changed
                'title' => 'Editar Vehículo',
                'isCliente' => false
            ];
        }
        return view('vehiculos/edit', $data);
    }

    public function update($id = null)
    {
        $vehiculo = $this->model->find($id);
        if (!$vehiculo) {
            return redirect()->to('/vehiculos')->with('error', 'Vehículo no encontrado');
        }

        $role = session()->get('rol');
        if ($role === 'CLIENTE') {
            $clienteId = $this->getClienteIdForCurrentUser();
            if ($vehiculo['id_cliente'] != $clienteId) {
                return redirect()->to('/vehiculos')->with('error', 'No tiene permiso para editar este vehículo.');
            }
            // Forzar propietario al mismo cliente
            $_POST['id_cliente'] = $clienteId;
        }

        $rules = [
            'id_cliente' => 'required|integer',
            'placa' => "required|is_unique[vehiculos.placa,id_vehiculo,{$id}]|min_length[5]",
            'marca' => 'required',
            'modelo' => 'required',
            'anio' => 'required|numeric|exact_length[4]',
            'tipo_motor' => 'required',
            'color' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->request->getPost();

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/vehiculos')->with('message', 'Vehículo actualizado exitosamente');
    }

    public function delete($id = null)
    {
        $vehiculo = $this->model->find($id);
        if (!$vehiculo) {
            return redirect()->to('/vehiculos')->with('error', 'Vehículo no encontrado');
        }

        if (session()->get('rol') === 'CLIENTE') {
            $clienteId = $this->getClienteIdForCurrentUser();
            if ($vehiculo['id_cliente'] != $clienteId) {
                return redirect()->to('/vehiculos')->with('error', 'No tiene permiso para eliminar este vehículo.');
            }
        }

        if ($this->model->delete($id)) {
            return redirect()->to('/vehiculos')->with('message', 'Vehículo eliminado exitosamente');
        }
        return redirect()->to('/vehiculos')->with('error', 'No se pudo eliminar el vehículo');
    }

    // RF-11: Consulta de estado en tiempo real
    public function status($id = null)
    {
        // Join with reservas and ordenes_trabajo to find active status
        $db = \Config\Database::connect();
        $builder = $db->table('vehiculos v');
        $builder->select('v.placa, v.modelo, r.estado as estado_reserva, ot.estado as estado_orden, ot.observaciones_tecnicas');
        $builder->join('reservas r', 'r.id_vehiculo = v.id_vehiculo', 'left');
        $builder->join('ordenes_trabajo ot', 'ot.id_reserva = r.id_reserva', 'left');
        $builder->where('v.id_vehiculo', $id);

        // Prioritize active processes (ignoring old completed ones for simplified status)
        // In a real app we might want the *latest* status.
        $builder->orderBy('r.fecha_reserva', 'DESC');
        $builder->limit(1);

        $query = $builder->get();
        $result = $query->getRow();

        if (!$result) {
            return $this->failNotFound('Vehiculo no encontrado o sin actividad');
        }

        // Logic to determine "display" status
        $status = "Sin actividad reciente";
        if ($result->estado_orden == 'EN_PROGRESO') {
            $status = "En Mantenimiento (Orden Abierta)";
        } elseif ($result->estado_reserva == 'CONFIRMADA' || $result->estado_reserva == 'EN_PROCESO') {
            $status = "En Taller / Pendiente de Orden";
        } elseif ($result->estado_orden == 'TERMINADO') {
            $status = "Listo para Entrega";
        }

        return $this->respond([
            'vehiculo' => $result->placa . ' - ' . $result->modelo,
            'estado_actual' => $status,
            'detalles' => $result
        ]);
    }

    // RF-12: Historial de servicios
    public function history($id = null)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('reservas r');
        $builder->select('r.fecha_reserva, s.nombre as servicio, ot.observaciones_tecnicas, ot.fecha_fin_real');
        $builder->join('detalle_reserva dr', 'dr.id_reserva = r.id_reserva');
        $builder->join('servicios s', 's.id_servicio = dr.id_servicio');
        $builder->join('ordenes_trabajo ot', 'ot.id_reserva = r.id_reserva', 'left');
        $builder->where('r.id_vehiculo', $id);
        $builder->where('r.estado', 'FINALIZADA'); // Only completed history
        $builder->orderBy('r.fecha_reserva', 'DESC');

        $query = $builder->get();
        return $this->respond($query->getResult());
    }
}
