<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;

class Empleados extends ResourceController
{
    protected $modelName = 'App\Models\EmpleadosModel';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data)
            return $this->failNotFound('No Data Found with id ' . $id);
        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->request->getPost();
        if (!$this->model->save($data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respondCreated($data, 'Data Created');
    }

    public function update($id = null)
    {
        $data = $this->request->getRawInput();
        if (!$this->model->update($id, $data)) {
            return $this->fail($this->model->errors());
        }
        return $this->respond($data, 200, 'Data Updated');
    }

    public function delete($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            $this->model->delete($id);
            return $this->respondDeleted($data, 'Data Deleted');
        }
        return $this->failNotFound('No Data Found with id ' . $id);
    }
}
