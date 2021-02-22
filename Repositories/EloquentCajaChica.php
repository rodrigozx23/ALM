<?php

namespace App\Repositories;

use App\Repositories\CajaChicaInterface;
use App\CajaChica as caj;


class EloquentCajaChica implements CajaChicaInterface
{

    protected $model;
    
    function __construct(caj $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getById($id)
    {
        return $this->findById($id);
    }

    public function create(array $attributes)
    {
        //echo json_encode($attributes);
        return $this->model->create($attributes);
    }

    public function update ($id, array $attributes)
    {
        $item = $this->model->findOrFail($id);
        $item->update($attributes);
        return $item;
    }

    public function delete($id)
    {
        $this->getById($id)->delete();
        return true;
    }
}
