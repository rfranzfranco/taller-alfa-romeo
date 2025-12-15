<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmpleadosModel;
use App\Models\UsuariosModel;
use App\Models\OrdenesTrabajoModel;

class Empleados extends BaseController
{
    protected $empleadosModel;
    protected $usuariosModel;

    public function __construct()
    {
        $this->empleadosModel = new EmpleadosModel();
        $this->usuariosModel = new UsuariosModel();
    }

    private function requireAdmin()
    {
        if (session()->get('rol') !== 'ADMIN') {
            return redirect()->to('/')->with('error', 'No tiene permisos para acceder a la gestión de personal.');
        }
        return null;
    }

    public function index()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }
        $data = [
            'title' => 'Gestión de Personal',
            'empleados' => $this->empleadosModel->findAll()
        ];
        return view('empleados/index', $data);
    }

    public function show($id = null)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $empleado = $this->empleadosModel->find($id);
        
        if (!$empleado) {
            return redirect()->to('/empleados')->with('error', 'Empleado no encontrado');
        }

        // Obtener órdenes de trabajo asignadas a este empleado
        $ordenesModel = new OrdenesTrabajoModel();
        $ordenes = $ordenesModel->where('id_empleado_asignado', $id)->findAll();

        $data = [
            'title' => 'Detalle del Empleado',
            'empleado' => $empleado,
            'ordenes' => $ordenes
        ];
        return view('empleados/show', $data);
    }

    public function new()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        // Obtener usuarios que pueden ser empleados (rol EMPLEADO o RECEPCIONISTA)
        $usuarios = $this->usuariosModel
            ->whereIn('rol', ['EMPLEADO', 'RECEPCIONISTA', 'ADMIN'])
            ->where('estado', 1)
            ->findAll();

        $data = [
            'title' => 'Nuevo Empleado',
            'usuarios' => $usuarios
        ];
        return view('empleados/create', $data);
    }

    public function create()
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $rules = [
            'id_usuario' => 'required|numeric',
            'nombre_completo' => 'required|min_length[3]|max_length[100]',
            'cargo' => 'required|min_length[3]|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id_usuario' => $this->request->getPost('id_usuario'),
            'nombre_completo' => $this->request->getPost('nombre_completo'),
            'cargo' => $this->request->getPost('cargo'),
            'especialidad' => $this->request->getPost('especialidad'),
            'fecha_contratacion' => $this->request->getPost('fecha_contratacion'),
        ];

        if ($this->empleadosModel->save($data)) {
            return redirect()->to('/empleados')->with('message', 'Empleado registrado correctamente');
        }

        return redirect()->back()->withInput()->with('errors', $this->empleadosModel->errors());
    }

    public function edit($id = null)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $empleado = $this->empleadosModel->find($id);
        
        if (!$empleado) {
            return redirect()->to('/empleados')->with('error', 'Empleado no encontrado');
        }

        $data = [
            'title' => 'Editar Empleado',
            'empleado' => $empleado
        ];
        return view('empleados/edit', $data);
    }

    public function update($id = null)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $empleado = $this->empleadosModel->find($id);
        
        if (!$empleado) {
            return redirect()->to('/empleados')->with('error', 'Empleado no encontrado');
        }

        $rules = [
            'nombre_completo' => 'required|min_length[3]|max_length[100]',
            'cargo' => 'required|min_length[3]|max_length[50]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nombre_completo' => $this->request->getPost('nombre_completo'),
            'cargo' => $this->request->getPost('cargo'),
            'especialidad' => $this->request->getPost('especialidad'),
            'fecha_contratacion' => $this->request->getPost('fecha_contratacion'),
        ];

        if ($this->empleadosModel->update($id, $data)) {
            return redirect()->to('/empleados')->with('message', 'Empleado actualizado correctamente');
        }

        return redirect()->back()->withInput()->with('errors', $this->empleadosModel->errors());
    }

    public function delete($id = null)
    {
        if ($redirect = $this->requireAdmin()) {
            return $redirect;
        }

        $empleado = $this->empleadosModel->find($id);
        
        if (!$empleado) {
            return redirect()->to('/empleados')->with('error', 'Empleado no encontrado');
        }

        if ($this->empleadosModel->delete($id)) {
            return redirect()->to('/empleados')->with('message', 'Empleado eliminado correctamente');
        }

        return redirect()->to('/empleados')->with('error', 'Error al eliminar el empleado');
    }
}
