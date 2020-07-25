<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    protected $table = 'tb_productos';

    protected $primaryKey = 'pro_int_id';

    public $timestamps = false;

    protected $fillable = [
        'pro_str_nombre',
        'pro_dbl_precio_venta', // Precio del producto 
        'pro_dbl_costo_produccion', // Precio del Costo de Produccion del producto
        'invi_dbl_peso_neto', // Cantidad de peso
        'pro_bit_estado', // Estado
        'pro_dat_fecha_creacion',  
        'pro_dat_fecha_modificacion',
        'pro_str_usuario_creacion',
        'pro_str_usuario_modificacion',
        'pro_int_estado_pedido', // Estoado del Pedido 0Inactivo 1Activo 3Waring 
        'invi_int_estado_item'
    ];

}
