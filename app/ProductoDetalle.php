<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductoDetalle extends Model
{
    // 
    protected $table = 'tb_productos_detalle';

    protected $primaryKey = 'prod_int_id';

    public $timestamps = false;

    protected $fillable = [
        'prod_int_tipo_medida_salida', //TIPÖ DE SALIDA EL ITEMPRODUCTO
        'prod_dbl_cantidad_item', // CANTIDAD ENTRE ITEM Y PRODUCTO
        'pro_int_id','invi_int_id', // FK
        'prod_int_item', // Numeracion
        'prod_str_nombre', // Descripcion
        'prod_dbl_costo_produccion_item', // Valor de Costo de Item
        'prod_dat_usuario_creacion', 'prod_dat_usuario_modificacion', 'prod_str_usuario_modificacion', 'prod_str_usuario_creacion',
        'prod_bit_estado'];
}
