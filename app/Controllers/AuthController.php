<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\ClientesModel;

class AuthController extends BaseController
{
    public function login()
    {
        // If already logged in, redirect to dashboard
        if (session()->get('is_logged_in')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login');
    }

    public function authenticate()
    {
        $session = session();
        $model = new UsuariosModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $model->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                // Check if user is active
                if ($user['estado'] == 0) {
                    return redirect()->back()->withInput()->with('error', 'Su cuenta está inactiva. Contacte al administrador.');
                }

                $ses_data = [
                    'id_usuario' => $user['id_usuario'],
                    'username' => $user['username'],
                    'rol' => $user['rol'],
                    'is_logged_in' => TRUE
                ];
                $session->set($ses_data);
                return redirect()->to('/dashboard');
            } else {
                return redirect()->back()->withInput()->with('error', 'Contraseña incorrecta');
            }
        } else {
            return redirect()->back()->withInput()->with('error', 'Usuario no encontrado');
        }
    }

    public function register()
    {
        // Registration is only for Clients
        return view('auth/register');
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // 1. Create User (Role: CLIENTE, Status: 1 Active)
            $usuariosModel = new UsuariosModel();

            // Validate User Data
            $rulesUser = [
                'username' => 'required|min_length[3]|is_unique[usuarios.username]',
                'password' => 'required|min_length[5]',
                'password_confirm' => 'required|matches[password]'
            ];

            if (!$this->validate($rulesUser)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $userData = [
                'username' => $this->request->getPost('username'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'rol' => 'CLIENTE',
                'estado' => 1
            ];

            $usuariosModel->insert($userData);
            $userId = $usuariosModel->getInsertID();

            // 2. Create Client Linked to User
            $clientesModel = new ClientesModel();

            // Validate Client Data
            $rulesClient = [
                'nombre_completo' => 'required|min_length[5]',
                'ci_nit' => 'required|min_length[5]',
                'telefono' => 'required',
                'correo' => 'required|valid_email'
            ];

            if (!$this->validate($rulesClient)) {
                // Manual rollback as validation failed for second part
                $db->transRollback();
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $clienteData = [
                'nombre_completo' => $this->request->getPost('nombre_completo'),
                'ci_nit' => $this->request->getPost('ci_nit'),
                'telefono' => $this->request->getPost('telefono'),
                'correo' => $this->request->getPost('correo'),
                'direccion' => $this->request->getPost('direccion'),
                'id_usuario' => $userId // Link to the created user
            ];

            $clientesModel->insert($clienteData);

            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                return redirect()->back()->withInput()->with('error', 'Error al registrar el cliente. Intente nuevamente.');
            }

            return redirect()->to('/')->with('message', 'Cuenta creada exitosamente. Inicie sesión.');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error del sistema: ' . $e->getMessage());
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }
}
