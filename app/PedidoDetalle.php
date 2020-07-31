<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PedidoDetalle extends Model
{
    //
    protected $table = 'tb_pedidos_detalle';

    protected $primaryKey = 'pedd_int_id';

    public $timestamps = false;

    protected $fillable = [
        'pedd_dbl_precio',
        'pedd_int_cantidad', 
        'pedd_bit_cancelado', 
        'pedd_int_estado_detalle',       
        'pro_int_id',  
        'ped_int_id', 
        'pedd_int_item', 
        'pedd_str_usuario_creacion',
        'pedd_dat_fecha_creacion',
        'pedd_str_usuario_modificacion',
        'pedd_dat_fecha_modificacion'
    ];
}
