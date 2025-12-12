<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Usuarios extends ResourceController
{
    protected $modelName = 'App\Models\UsuariosModel';
    protected $format = 'html'; // Changed to html for view return

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $data = [
            'usuarios' => $this->model->findAll(),
            'title' => 'Gestión de Usuarios'
        ];
        return view('usuarios/index', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        // For now, we generally use edit for viewing details in simple CRUDs
        // Or we can implement a read-only view.
        // Let's redirect to edit for now or just show same as index
        return $this->index();
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        $data = [
            'title' => 'Nuevo Usuario'
        ];
        return view('usuarios/create', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $db = \Config\Database::connect();

        // Base user rules - Fixed min_length syntax (square brackets)
        $rules = [
            'username' => 'required|min_length[3]|is_unique[usuarios.username]',
            'password' => 'required|min_length[5]',
            'rol' => 'required',
            'estado' => 'required'
        ];

        // Conditional rules based on role
        $rol = $this->request->getPost('rol');
        if ($rol === 'EMPLEADO') {
            $rules['nombre_completo'] = 'required|min_length[5]';
            $rules['cargo'] = 'required';
        } elseif ($rol === 'CLIENTE') {
            $rules['nombre_completo'] = 'required|min_length[5]';
            $rules['ci_nit'] = 'required';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Start Transaction
        $db->transStart();

        try {
            // 1. Create User
            $userData = [
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'rol' => $rol,
                'estado' => $this->request->getPost('estado'),
            ];

            // Use model to insert (handling skipValidation if needed, or manual insert to avoid double validation if model has rules)
            // Since we validated manually above, we can assume data is good, but model might have its own rules.
            // Using insert() returns ID.
            $userId = $this->model->insert($userData);

            if (!$userId) {
                // If model validation failed (though we shouldn't hit this if rules match)
                throw new \Exception(implode(", ", $this->model->errors()));
            }

            // 2. Create Linked Entity
            if ($rol === 'EMPLEADO') {
                $empleadosModel = new \App\Models\EmpleadosModel();
                $empleadoData = [
                    'id_usuario' => $userId,
                    'nombre_completo' => $this->request->getPost('nombre_completo'),
                    'cargo' => $this->request->getPost('cargo'),
                    'especialidad' => $this->request->getPost('especialidad'),
                    'fecha_contratacion' => $this->request->getPost('fecha_contratacion') ?: date('Y-m-d'),
                ];
                $empleadosModel->insert($empleadoData);
            } elseif ($rol === 'CLIENTE') {
                $clientesModel = new \App\Models\ClientesModel();
                $clienteData = [
                    'id_usuario' => $userId,
                    'nombre_completo' => $this->request->getPost('nombre_completo'),
                    'ci_nit' => $this->request->getPost('ci_nit'),
                    'telefono' => $this->request->getPost('telefono'),
                    'correo' => $this->request->getPost('correo'),
                    'direccion' => $this->request->getPost('direccion'),
                ];
                $clientesModel->insert($clienteData);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Error al guardar en la base de datos.");
            }

            return redirect()->to('/usuarios')->with('message', 'Usuario creado exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        $usuario = $this->model->find($id);
        if (!$usuario) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado');
        }

        $data = [
            'usuario' => $usuario,
            'title' => 'Editar Usuario'
        ];
        return view('usuarios/edit', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $usuario = $this->model->find($id);
        if (!$usuario) {
            return redirect()->to('/usuarios')->with('error', 'Usuario no encontrado');
        }

        // Validation rules - Fixed min_length syntax
        $rules = [
            'username' => "required|min_length[3]|is_unique[usuarios.username,id_usuario,{$id}]",
            'rol' => 'required',
            'estado' => 'required'
        ];

        // Only validate password if it's being changed
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[5]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'rol' => $this->request->getPost('rol'),
            'estado' => $this->request->getPost('estado'),
        ];

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        // Note: For now we are not updating the linked entities in this simple edit. 
        // That would require fetching the linked entity based on id_usuario.

        return redirect()->to('/usuarios')->with('message', 'Usuario actualizado exitosamente');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        if ($this->model->delete($id)) {
            return redirect()->to('/usuarios')->with('message', 'Usuario eliminado exitosamente');
        }
        return redirect()->to('/usuarios')->with('error', 'No se pudo eliminar el usuario');
    }
}
