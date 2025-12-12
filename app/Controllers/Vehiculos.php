<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ClientesModel;

class Vehiculos extends ResourceController
{
    protected $modelName = 'App\Models\VehiculosModel';
    protected $format = 'html';

    public function index()
    {
        // Ideally we join with Clientes to show Owner Name
        $data['vehiculos'] = $this->model->select('vehiculos.*, clients.nombre_completo as nombre_cliente')
            ->join('clientes as clients', 'clients.id_cliente = vehiculos.id_cliente')
            ->findAll();
        $data['title'] = 'Gestión de Vehículos';
        return view('vehiculos/index', $data);
    }

    public function new()
    {
        $clientesModel = new ClientesModel();
        $data = [
            'clientes' => $clientesModel->findAll(),
            'title' => 'Registrar Vehículo'
        ];
        return view('vehiculos/create', $data);
    }

    public function create()
    {
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

    public function edit($id = null)
    {
        $vehiculo = $this->model->find($id);
        if (!$vehiculo) {
            return redirect()->to('/vehiculos')->with('error', 'Vehículo no encontrado');
        }

        $clientesModel = new ClientesModel();
        $data = [
            'vehiculo' => $vehiculo,
            'clientes' => $clientesModel->findAll(), // In case owner is changed
            'title' => 'Editar Vehículo'
        ];
        return view('vehiculos/edit', $data);
    }

    public function update($id = null)
    {
        $vehiculo = $this->model->find($id);
        if (!$vehiculo) {
            return redirect()->to('/vehiculos')->with('error', 'Vehículo no encontrado');
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
