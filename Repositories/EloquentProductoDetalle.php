<?php

namespace App\Repositories;

use App\Repositories\ProductoDetalleInterface;
use App\ProductoDetalle as prod;


class EloquentProductoDetalle implements ProductoDetalleInterface
{

    protected $model;
    
    function __construct(prod $model)
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
