<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaChica extends Model
{
    //
    protected $table = 'tb_historial_cajachica';

    protected $primaryKey = 'hcjc_int_id';

    public $timestamps = false;

    protected $fillable = [

        'hcjc_dbl_monto_ingreso',        
        'hcjc_dbl_monto_salida',

        'hcjc_dat_fecha_ingreso',
        'hcjc_dat_fecha_salida',

        'hcjc_dat_fecha_venta',
        'hcjc_str_observacion',

        'hcjc_str_estado_caja', // 00 Entrada, 01 Salida, 02 Venta, 03 Otros

        'hcjc_str_usuario_creacion',
        'hcjc_dat_fecha_creacion',
        'hcjc_str_usuario_modificacion',
        'hcjc_dat_fecha_modificacion',
        'cjc_int_id',
        'ped_int_id',
    ];
}
