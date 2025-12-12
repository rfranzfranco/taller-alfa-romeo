<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		if (!session()->get('is_logged_in')) {
			return redirect()->to('/');
		}

		$reservasModel = new \App\Models\ReservasModel();
		$ordenesModel = new \App\Models\OrdenesTrabajoModel();
		$vehiculosModel = new \App\Models\VehiculosModel();
		$facturasModel = new \App\Models\FacturasModel();

		// Stats
		$activeOrdersKey = 'ordenes_activas';
		$todayReservationsKey = 'reservas_hoy';

		$data = [
			'ordenes_activas' => $ordenesModel->where('estado', 'EN_PROCESO')->countAllResults(),
			'reservas_hoy' => $reservasModel->where('fecha_reserva >=', date('Y-m-d 00:00:00'))->where('fecha_reserva <=', date('Y-m-d 23:59:59'))->countAllResults(),
			'total_vehiculos' => $vehiculosModel->countAllResults(),
			'facturas_pendientes' => $facturasModel->where('estado_pago', 'PENDIENTE')->countAllResults(),
			// Lists
			'latest_reservas' => $reservasModel->select('reservas.*, clientes.nombre_completo as cliente_nombre, vehiculos.placa')
				->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
				->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
				->where('fecha_reserva >=', date('Y-m-d'))
				->orderBy('fecha_reserva', 'ASC')
				->limit(5)
				->findAll(),
			'active_ordenes' => $ordenesModel->select('ordenes_trabajo.*, vehiculos.placa, empleados.nombre_completo as mecanico_nombre')
				->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
				->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
				->join('empleados', 'empleados.id_empleado = ordenes_trabajo.id_empleado_asignado', 'left')
				->where('ordenes_trabajo.estado', 'EN_PROCESO')
				->findAll()
		];

		return view('index', $data);
	}

	public function root($path = '')
	{
		if ($path !== '') {
			if (@file_exists(APPPATH . 'Views/' . $path . '.php')) {
				return view($path);
			} else {
				throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
			}
		} else {
			echo 'Page Not Found.';
		}
	}

	public function prueba()
	{
		$data = [
			'title' => 'Inicio - Plantilla UTO prueba',
			'metaDescription' => 'Bienvenido a nuestra plataforma basada en CodeIgniter 4 con Bootstrap 5'
		];

		// Cargar la vista con el layout
		return view('home/prueba', $data);
	}

}