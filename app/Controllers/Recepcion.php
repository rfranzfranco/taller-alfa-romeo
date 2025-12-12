<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VehiculosModel;
use App\Models\ServiciosModel;
use App\Models\ReservasModel;
use App\Models\DetalleReservaModel;
use App\Models\OrdenesTrabajoModel; // If we want to auto-create order? Requirement says "assign immediate services".

class Recepcion extends BaseController
{
    public function index()
    {
        $vehiculosModel = new VehiculosModel();
        $serviciosModel = new ServiciosModel();

        // Join to get client name
        $vehiculos = $vehiculosModel->select('vehiculos.*, clientes.nombre_completo, clientes.ci_nit')
            ->join('clientes', 'clientes.id_cliente = vehiculos.id_cliente')
            ->findAll();

        $servicios = $serviciosModel->findAll();

        $data = [
            'vehiculos' => $vehiculos,
            'servicios' => $servicios,
            'title' => 'Recepción de Vehículos (Sin Reserva)'
        ];

        return view('recepcion/index', $data);
    }

    public function store()
    {
        $rules = [
            'id_vehiculo' => 'required|integer',
            'servicios' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_vehiculo = $this->request->getPost('id_vehiculo');
        $servicios = $this->request->getPost('servicios');
        $observaciones = $this->request->getPost('observaciones');

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Get Vehicle Owner
            $vehiculosModel = new VehiculosModel();
            $vehiculo = $vehiculosModel->find($id_vehiculo);

            if (!$vehiculo) {
                throw new \Exception("Vehículo no encontrado.");
            }

            // 2. Create Reservation (Immediate)
            $reservasModel = new ReservasModel();
            $reservaData = [
                'id_cliente' => $vehiculo['id_cliente'],
                'id_vehiculo' => $id_vehiculo,
                'fecha_reserva' => date('Y-m-d H:i:s'), // Now
                'estado' => 'PENDIENTE' // Will be PENDIENTE of assignment to Tech
            ];
            $reservasModel->insert($reservaData);
            $id_reserva = $reservasModel->getInsertID();

            // 3. Add Services
            $detalleReservaModel = new DetalleReservaModel();
            $serviciosModel = new ServiciosModel();

            foreach ($servicios as $id_servicio) {
                $servicio = $serviciosModel->find($id_servicio);
                $detalleReservaModel->insert([
                    'id_reserva' => $id_reserva,
                    'id_servicio' => $id_servicio,
                    'precio_unitario_momento' => $servicio['costo_mano_obra']
                ]);
            }

            // Note: We leave it as PENDIENTE so it shows up in "Órdenes de Trabajo" -> "Pendientes de Asignación".
            // The requirement "asignarle servicios inmediatos" is met by creating the reservation with services attached ready for tech assignment.

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->back()->withInput()->with('error', 'Error al registrar la recepción.');
            }

            return redirect()->to('/ordenestrabajo')->with('message', 'Vehículo recepcionado y servicios asignados. Pendiente de asignar técnico.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
