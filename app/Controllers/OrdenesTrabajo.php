<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\OrdenesTrabajoModel;
use App\Models\ReservasModel;
use App\Models\DetalleReservaModel;
use App\Models\UsuariosModel;
use App\Models\RampasModel;

class OrdenesTrabajo extends ResourceController
{
    protected $modelName = 'App\Models\OrdenesTrabajoModel';
    protected $format = 'html';

    public function index()
    {
        // List reservations that need assignment (Status: PENDIENTE)
        $reservasModel = new ReservasModel();

        $pendientes = $reservasModel->select('reservas.*, clientes.nombre_completo as cliente_nombre, vehiculos.placa, vehiculos.marca, vehiculos.modelo')
            ->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
            ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
            ->where('reservas.estado', 'PENDIENTE')
            ->orderBy('fecha_reserva', 'ASC')
            ->findAll();

        $enProceso = $this->model->select('ordenes_trabajo.*, reservas.fecha_reserva, clientes.nombre_completo as cliente_nombre, vehiculos.placa')
            ->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
            ->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
            ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
            ->whereIn('ordenes_trabajo.estado', ['EN_PROCESO', 'PENDIENTE']) // Active orders
            ->findAll();

        $data = [
            'pendientes' => $pendientes,
            'enProceso' => $enProceso,
            'title' => 'Gestión de Órdenes'
        ];
        return view('ordenestrabajo/index', $data);
    }

    public function assign($id_reserva = null)
    {
        $reservasModel = new ReservasModel();
        $reserva = $reservasModel->select('reservas.*, clientes.nombre_completo, vehiculos.placa')
            ->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
            ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
            ->find($id_reserva);

        if (!$reserva) {
            return redirect()->to('/ordenestrabajo')->with('error', 'Reserva no encontrada');
        }

        // Get details to check for Ramp Requirement
        $detalleModel = new DetalleReservaModel();
        $detalles = $detalleModel->select('detalle_reserva.*, servicios.nombre, servicios.requiere_rampa')
            ->join('servicios', 'servicios.id_servicio = detalle_reserva.id_servicio')
            ->where('id_reserva', $id_reserva)
            ->findAll();

        $needsRamp = false;
        foreach ($detalles as $d) {
            if ($d['requiere_rampa'] == 1) {
                $needsRamp = true;
                break;
            }
        }

        // Fetch Employees (Technicians)
        $usuariosModel = new UsuariosModel();
        // Assuming rol='EMPLEADO' or 'TECNICO'. 
        $empleados = $usuariosModel->select('usuarios.id_usuario, empleados.id_empleado, empleados.nombre_completo')
            ->join('empleados', 'empleados.id_usuario = usuarios.id_usuario')
            ->where('usuarios.rol', 'EMPLEADO')
            ->findAll();

        // Fetch Free Ramps
        $rampasModel = new RampasModel();
        $rampas = $rampasModel->where('estado', 'LIBRE')->findAll();

        $data = [
            'reserva' => $reserva,
            'detalles' => $detalles,
            'empleados' => $empleados,
            'rampas' => $rampas,
            'needsRamp' => $needsRamp,
            'title' => 'Asignar Recursos'
        ];

        return view('ordenestrabajo/assign', $data);
    }

    public function store()
    {
        $id_reserva = $this->request->getPost('id_reserva');
        $id_empleado = $this->request->getPost('id_empleado');
        $id_rampa = $this->request->getPost('id_rampa'); // Optional

        // Validation
        if (!$id_reserva || !$id_empleado) {
            return redirect()->back()->withInput()->with('error', 'Faltan datos requeridos.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Create Order
            $orderData = [
                'id_reserva' => $id_reserva,
                'id_empleado_asignado' => $id_empleado,
                'estado' => 'EN_PROCESO',
                'id_rampa' => $id_rampa ? $id_rampa : null,
                'fecha_inicio_real' => date('Y-m-d H:i:s')
            ];
            $this->model->insert($orderData);

            // Update Reservation Status
            $reservasModel = new ReservasModel();
            $reservasModel->update($id_reserva, ['estado' => 'EN_PROCESO']);

            // Update Ramp Status if used
            if ($id_rampa) {
                $rampasModel = new RampasModel();
                $rampasModel->update($id_rampa, ['estado' => 'OCUPADA']);
            }

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->back()->withInput()->with('error', 'Error al asignar recursos.');
            }

            return redirect()->to('/ordenestrabajo')->with('message', 'Orden de trabajo creada exitosamente.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function complete($id_orden = null)
    {
        $orden = $this->model->select('ordenes_trabajo.*, vehiculos.placa')
            ->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
            ->join('vehiculos', 'reservas.id_vehiculo = vehiculos.id_vehiculo')
            ->find($id_orden);

        if (!$orden) {
            return redirect()->to('/ordenestrabajo')->with('error', 'Orden no encontrada');
        }

        // Fetch Insumos for selection
        $insumosModel = new \App\Models\InsumosModel();
        $insumos = $insumosModel->where('stock_actual >', 0)->findAll();

        $data = [
            'orden' => $orden,
            'insumos' => $insumos,
            'title' => 'Finalizar Orden de Trabajo'
        ];
        return view('ordenestrabajo/complete', $data);
    }

    public function finalize()
    {
        $id_orden = $this->request->getPost('id_orden');
        $observaciones = $this->request->getPost('observaciones_tecnicas');
        $insumos = $this->request->getPost('insumos'); // Array of IDs
        $cantidades = $this->request->getPost('cantidades'); // Array of Quantities

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Update Order
            if (
                !$this->model->update($id_orden, [
                    'fecha_fin_real' => date('Y-m-d H:i:s'),
                    'observaciones_tecnicas' => $observaciones,
                    'estado' => 'FINALIZADA'
                ])
            ) {
                throw new \Exception("Error al actualizar el estado de la orden.");
            }

            // 2. Register Insumos Used
            if ($insumos && is_array($insumos)) {
                $detalleInsumosModel = new \App\Models\DetalleInsumosOrdenModel();
                $insumosModel = new \App\Models\InsumosModel();

                foreach ($insumos as $index => $id_insumo) {
                    $cantidad = $cantidades[$index];
                    if ($cantidad > 0) {
                        // Check stock (Optional stricter check here, but assuming UI filters)
                        $insumoData = $insumosModel->find($id_insumo);

                        if (!$insumoData) {
                            throw new \Exception("Insumo con ID $id_insumo no encontrado.");
                        }

                        // Use precio_venta as the cost for the order
                        $currentCost = $insumoData['precio_venta'] ?? 0;

                        // Verify stock before decrementing
                        if ($insumoData['stock_actual'] < $cantidad) {
                            throw new \Exception("Stock insuficiente para el insumo: " . $insumoData['nombre']);
                        }

                        $detalleInsumosModel->insert([
                            'id_orden' => $id_orden,
                            'id_insumo' => $id_insumo,
                            'cantidad' => $cantidad,
                            'costo_unitario' => $currentCost
                        ]);

                        // Decrement Stock
                        $newStock = $insumoData['stock_actual'] - $cantidad;
                        $insumosModel->update($id_insumo, ['stock_actual' => $newStock]);
                    }
                }
            }

            // 3. Free Ramp if used
            $orden = $this->model->find($id_orden);
            if ($orden['id_rampa']) {
                $rampasModel = new RampasModel();
                $rampasModel->update($orden['id_rampa'], ['estado' => 'LIBRE']);
            }

            // 4. Update Reservation to FINALIZADA
            $reservasModel = new ReservasModel();
            if (!$reservasModel->update($orden['id_reserva'], ['estado' => 'FINALIZADA'])) {
                // Non-critical if reservation update fails? Or should be critical? 
                // Let's treat as critical to ensure consistency.
                throw new \Exception("Error al actualizar el estado de la reserva.");
            }

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                // Get Database or Model Errors
                $errorMsg = 'Error al finalizar la orden (Transacción fallida).';

                $dbError = $db->error();
                if (!empty($dbError['message'])) {
                    $errorMsg .= ' DB: ' . $dbError['message'];
                }

                return redirect()->back()->withInput()->with('error', $errorMsg);
            }

            return redirect()->to('/ordenestrabajo')->with('message', 'Servicio completado exitosamente.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }
}
