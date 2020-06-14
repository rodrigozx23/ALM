<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class inventario extends Model
{
    //
     protected $table = 'tb_inventario';

    protected $primaryKey = 'inv_int_id';

    public $timestamps = false;

    //public function item_inventario()
    //{
    //	return $this->hasMany(ItemInventario::class);
    //}
}
