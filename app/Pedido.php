<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    //
    protected $table = 'tb_pedidos';

    protected $primaryKey = 'ped_int_id';

    public $timestamps = false;

    protected $fillable = [
        'ped_str_telefono_cliente',
        'ped_str_nombre_cliente',
        'ped_str_direccion_cliente',
        'ped_str_mesa',
        'ped_dat_fecha_inicio',
        'ped_dat_fecha_fin',
        'ped_bit_combo',
        'ped_bit_cancelado',
        'ped_int_estado_pedido',
        'ped_int_empresa',
        'ped_int_estado',
        'ped_dbl_descuento',
        'ped_dbl_igv',
        'ped_dbl_isc',
        'ped_dbl_valor_neto',
        'ped_dbl_venta_total',
        'ped_str_usuario_creacion',
        'ped_dat_fecha_creacion',
        'ped_str_usuario_modificacion',
        'ped_str_fecha_modificacion'
    ];
}
