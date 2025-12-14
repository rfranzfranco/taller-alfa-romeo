<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\OrdenesTrabajoModel;
use App\Models\ReservasModel;
use App\Models\DetalleReservaModel;
use App\Models\DetalleInsumosOrdenModel;
use App\Models\FacturasModel;

class Historial extends BaseController
{
    public function index()
    {
        $ordenesModel = new OrdenesTrabajoModel();

        // Get filter parameters
        $search = $this->request->getGet('search');
        $type = $this->request->getGet('type') ?? 'placa'; // placa, cliente

        $builder = $ordenesModel->select('ordenes_trabajo.*, reservas.fecha_reserva, clientes.nombre_completo as cliente_nombre, vehiculos.placa, vehiculos.marca, vehiculos.modelo, empleados.nombre_completo as tecnico_nombre, facturas.estado_pago, facturas.id_factura')
            ->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
            ->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
            ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
            ->join('empleados', 'empleados.id_empleado = ordenes_trabajo.id_empleado_asignado')
            ->join('facturas', 'facturas.id_orden = ordenes_trabajo.id_orden', 'left')
            ->where('ordenes_trabajo.estado', 'FINALIZADA');

        if ($search) {
            if ($type == 'placa') {
                $builder->like('vehiculos.placa', $search);
            } elseif ($type == 'cliente') {
                $builder->like('clientes.nombre_completo', $search);
            }
        }

        $ordenes = $builder->orderBy('fecha_fin_real', 'DESC')->findAll();

        $data = [
            'ordenes' => $ordenes,
            'search' => $search,
            'type' => $type,
            'title' => 'Historial de Servicios'
        ];

        return view('historial/index', $data);
    }

    public function show($id_orden)
    {
        $ordenesModel = new OrdenesTrabajoModel();

        // 1. Get Main Order Info
        $orden = $ordenesModel->select('ordenes_trabajo.*, reservas.fecha_reserva, clientes.nombre_completo as cliente_nombre, clientes.telefono, clientes.correo, vehiculos.placa, vehiculos.marca, vehiculos.modelo, vehiculos.anio, vehiculos.tipo_motor, vehiculos.color, empleados.nombre_completo as tecnico_nombre')
            ->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
            ->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
            ->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
            ->join('empleados', 'empleados.id_empleado = ordenes_trabajo.id_empleado_asignado')
            ->where('ordenes_trabajo.id_orden', $id_orden)
            ->first();

        if (!$orden) {
            return redirect()->to('/historial')->with('error', 'Orden no encontrada.');
        }

        // 2. Get Services performed
        $detalleReservaModel = new DetalleReservaModel();
        $servicios = $detalleReservaModel->select('servicios.nombre, servicios.costo_mano_obra')
            ->join('servicios', 'servicios.id_servicio = detalle_reserva.id_servicio')
            ->where('id_reserva', $orden['id_reserva'])
            ->findAll();

        // 3. Get Supplies/Parts used
        $detalleInsumosModel = new DetalleInsumosOrdenModel();
        $insumos = $detalleInsumosModel->select('detalle_insumos_orden.*, insumos.nombre, insumos.codigo')
            ->join('insumos', 'insumos.id_insumo = detalle_insumos_orden.id_insumo')
            ->where('id_orden', $id_orden)
            ->findAll();

        // 4. Get Invoice if exists
        $facturasModel = new FacturasModel();
        $factura = $facturasModel->where('id_orden', $id_orden)->first();

        // Calculate totals for the view
        $totalServicios = 0;
        foreach ($servicios as $servicio) {
            $totalServicios += $servicio['costo_mano_obra'];
        }

        $totalInsumos = 0;
        foreach ($insumos as $insumo) {
            $totalInsumos += ($insumo['cantidad'] * $insumo['costo_unitario']);
        }

        $totalGeneral = $totalServicios + $totalInsumos;

        $data = [
            'orden' => $orden,
            'servicios' => $servicios,
            'insumos' => $insumos,
            'factura' => $factura,
            'totalServicios' => $totalServicios,
            'totalInsumos' => $totalInsumos,
            'totalGeneral' => $totalGeneral,
            'title' => 'Detalle del Servicio #' . $id_orden
        ];

        return view('historial/show', $data);
    }
}
