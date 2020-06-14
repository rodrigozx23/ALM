<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class item_inventario extends Model
{
    //
    protected $table = 'tb_item_inventario';

    protected $primaryKey = 'invi_int_id';

    public $timestamps = false;

    protected $fillable = ['invi_str_nombre','invi_bit_estado','invi_dat_fecha_creacion',
    'invi_dat_fecha_modificacion','invi_str_usuario_creacion',
    'invi_str_usuario_modificacion','invi_str_tipo_medida_entrada',
    'itm_int_tipo_medida_entrada','inv_int_id','invi_dbl_cantidad_total_item',
    'invi_str_estado_item','invi_int_estado_item','invi_dbl_peso_neto'];

    //public function inventario(){
    //	return $this->belongsTo(Invetario::class);
    //}
}
