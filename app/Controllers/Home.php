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
		$clientesModel = new \App\Models\ClientesModel();

		$rol = session()->get('rol');
		$data = ['rol' => $rol];

		if ($rol === 'CLIENTE') {
			// Obtener el id_cliente del usuario logueado
			$idUsuario = session()->get('id_usuario');
			$cliente = $clientesModel->where('id_usuario', $idUsuario)->first();
			$idCliente = $cliente ? $cliente['id_cliente'] : 0;

			// Stats específicos para CLIENTE
			$data['mis_vehiculos'] = $vehiculosModel->where('id_cliente', $idCliente)->countAllResults();
			$data['mis_reservas'] = $reservasModel->where('id_cliente', $idCliente)->countAllResults();
			
			// Contar servicios finalizados del cliente
			$data['mis_servicios'] = $ordenesModel
				->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
				->where('reservas.id_cliente', $idCliente)
				->where('ordenes_trabajo.estado', 'FINALIZADA')
				->countAllResults();

			// Últimas reservas del cliente
			$data['cliente_reservas'] = $reservasModel->select('reservas.*, vehiculos.placa, vehiculos.marca, vehiculos.modelo')
				->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
				->where('reservas.id_cliente', $idCliente)
				->orderBy('fecha_reserva', 'DESC')
				->limit(5)
				->findAll();

			// Vehículos del cliente
			$data['cliente_vehiculos'] = $vehiculosModel->where('id_cliente', $idCliente)->findAll();

		} else {
			// Stats para ADMIN y EMPLEADO
			$data['ordenes_activas'] = $ordenesModel->where('estado', 'EN_PROCESO')->countAllResults();
			$data['reservas_hoy'] = $reservasModel
				->where('DATE(fecha_reserva)', date('Y-m-d'))
				->whereNotIn('estado', ['FINALIZADA', 'CANCELADA'])
				->countAllResults();
			$data['total_vehiculos'] = $vehiculosModel->countAllResults();
			$data['facturas_pendientes'] = $facturasModel->where('estado_pago', 'PENDIENTE')->countAllResults();

			// Lists para ADMIN y EMPLEADO
			$data['latest_reservas'] = $reservasModel->select('reservas.*, clientes.nombre_completo as cliente_nombre, vehiculos.placa')
				->join('clientes', 'clientes.id_cliente = reservas.id_cliente')
				->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
				->where('fecha_reserva >=', date('Y-m-d'))
				->whereNotIn('reservas.estado', ['FINALIZADA', 'CANCELADA'])
				->orderBy('fecha_reserva', 'ASC')
				->limit(5)
				->findAll();

			$data['active_ordenes'] = $ordenesModel->select('ordenes_trabajo.*, vehiculos.placa, empleados.nombre_completo as mecanico_nombre')
				->join('reservas', 'reservas.id_reserva = ordenes_trabajo.id_reserva')
				->join('vehiculos', 'vehiculos.id_vehiculo = reservas.id_vehiculo')
				->join('empleados', 'empleados.id_empleado = ordenes_trabajo.id_empleado_asignado', 'left')
				->where('ordenes_trabajo.estado', 'EN_PROCESO')
				->findAll();
		}

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