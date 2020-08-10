<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ItemInventarioInterface as itemI;
use App\Repositories\ProductoInterface as productoI;
use App\Repositories\ProductoDetalleInterface as productodetalleI;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\item_inventario as invi;
use App\Producto as pro;
use App\ProductoDetalle as prod;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AlmacenController extends Controller
{
    protected $iteminventarioObject;
    protected $productoObject;
    protected $productodetalleObject;
    public function __construct(itemI $ii, productoI $p, productodetalleI $pd)
    {
        $this->iteminventarioObject = $ii;
        $this->productoObject = $p;
        $this->productodetalleObject = $pd;
    }

    public function getAllItems()
    {
      return $this->iteminventarioObject->getAll();
    }

    public function listarAlmacen()
    {
      
      $iItems =  DB::select('select i.*, ma.mlt_str_descripcion from tb_item_inventario i
      inner join tb_multiusos_almacen ma on i.itm_int_tipo_medida_entrada = ma.mlt_int_id');
      //var_dump($ProductoDetalle);
      return response()
            ->json(['draw' => 10,'recordsTotal' => 10,'recordsFiltered' => 10,'data' =>$iItems]);
    }

    public function searchItem($id)
    {
      $invi_int_id = $id;
      $iItems = $this->iteminventarioObject->getById($invi_int_id);
      return response()
            ->json(['draw' => 10,'recordsTotal' => 10,'recordsFiltered' => 10,'data' =>$iItems->toArray()]);
    }
    /**
     * Store a new items by REST.
     *
     * @param  Request $request
     * @return Response
     */
    public function storeItems(Request $request)
    {
      $item_inventario = new invi;
      $mytime =Carbon::now();

      $item_inventario->invi_str_nombre = $request->input('invi_str_nombre');
      $item_inventario->invi_bit_estado = $request->input('invi_bit_estado');
      //$item_inventario->invi_dat_fecha_creacion = $mytime->format('d-m-Y H:i:s');
      //$item_inventario->invi_dat_fecha_modificacion = $mytime->format('d-m-Y H:i:s');
      $item_inventario->invi_dat_fecha_creacion = $mytime;
      $item_inventario->invi_dat_fecha_modificacion = $mytime;
      $item_inventario->invi_str_usuario_creacion =  $request->input('invi_str_usuario_creacion');
      $item_inventario->invi_str_usuario_modificacion = $request->input('invi_str_usuario_modificacion');
      $item_inventario->invi_str_tipo_medida_entrada = $request->input('invi_str_tipo_medida_entrada');
      $item_inventario->itm_int_tipo_medida_entrada = $request->input('itm_int_tipo_medida_entrada');

      $item_inventario->inv_int_id = $request->input('inv_int_id');
      $item_inventario->invi_dbl_cantidad_total_item = $request->input('invi_dbl_cantidad_total_item');
      $item_inventario->invi_str_estado_item = $request->input('invi_str_estado_item');
      $item_inventario->invi_int_estado_item = $request->input('invi_int_estado_item');
      $item_inventario->invi_dbl_peso_neto = $request->input('invi_dbl_peso_neto');
      //echo($item_inventario);
      $this->iteminventarioObject->create($item_inventario->toArray());
      //$item_inventario->save();
      return response()->json($item_inventario);
    }

    /**
     * Store a new Item. Debe devolver una vista
     *
     * @param  Request $request
     * @return Response
     */
    public function updateItem(Request $request)
    {
        $item_inventario = new invi;
        $mytime =Carbon::now();

        $id_item_inventario = $request->input('invi_int_id');
        $item_inventarioUpdate = new invi;  
        $item_inventarioUpdate->invi_str_nombre = $request->input('invi_str_nombre');
        $item_inventarioUpdate->invi_bit_estado = 1;
        $item_inventarioUpdate->inv_int_id = 1;
        $item_inventarioUpdate->invi_dat_fecha_modificacion = $mytime;
        $item_inventarioUpdate->invi_str_usuario_modificacion =  "Admin";
        $item_inventarioUpdate->itm_int_tipo_medida_entrada = $request->input('itm_int_tipo_medida_entrada');    
        $item_inventarioUpdate->invi_dbl_cantidad_total_item = $request->input('invi_dbl_cantidad_total_item');
        $item_inventarioUpdate->invi_dbl_peso_neto = $request->input('invi_dbl_peso_neto');
        $item_inventarioUpdate->invi_int_estado_item = 1;
        $this->iteminventarioObject->update($id_item_inventario, $item_inventarioUpdate->toArray());         
      //$item_inventario->save();
      //return response()->json($item_inventario);
      return redirect('/Almacen');
    }
    
    /**
     * Store a new Item. Debe devolver una vista
     *
     * @param  Request $request
     * @return Response
     */
    public function storeItem(Request $request)
    {
        $item_inventario = new invi;
        $mytime =Carbon::now();      
        
        $item_inventarioInsert = new invi;  
        $item_inventarioInsert->invi_str_nombre = $request->input('invi_str_nombre');
        $item_inventarioInsert->invi_bit_estado = 1;
        $item_inventarioInsert->inv_int_id = 1;
        $item_inventarioInsert->invi_dat_fecha_creacion = $mytime;
        $item_inventarioInsert->invi_dat_fecha_modificacion = $mytime;
        $item_inventarioInsert->invi_str_usuario_creacion = "Admin";
        $item_inventarioInsert->invi_str_usuario_modificacion =  "Admin";
        $item_inventarioInsert->itm_int_tipo_medida_entrada = $request->input('itm_int_tipo_medida_entrada');    
        $item_inventarioInsert->invi_dbl_cantidad_total_item = $request->input('invi_dbl_cantidad_total_item');
        $item_inventarioInsert->invi_dbl_peso_neto = $request->input('invi_dbl_peso_neto');
        $item_inventarioInsert->invi_int_estado_item = 1;
        $this->iteminventarioObject->create($item_inventarioInsert->toArray());       
      //$item_inventario->save();
      //return response()->json($item_inventario);
      return redirect('/Almacen');
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // PRODUCTO

    public function getAllProductos()
    {
      return $this->productoObject->getAll();
    }

    public function listarProducto()
    {
      $Productos = $this->productoObject->getAll();
      return response()
            ->json(['draw' => 10,'recordsTotal' => 10,'recordsFiltered' => 10,'data' =>$Productos->toArray()]);
    }

    public function listarProductoDetalle($id)
    { 

      $ProductoDetalle =  DB::select('select pd.*, ma.mlt_str_descripcion from tb_productos_detalle pd
      inner join tb_multiusos_almacen ma on pd.prod_int_tipo_medida_salida = ma.mlt_int_id where pro_int_id = ?', [$id] );
      //var_dump($ProductoDetalle);
      
      return response()
            ->json(['draw' => 10,'recordsTotal' => 10,'recordsFiltered' => 10,'data' =>$ProductoDetalle]);
    }

    public function ListarItemsInventario(Request $request)
    {
        $text = $request->input('text'); //$request->query('text');
        //$iteminventario =  $this->iteminventarioObject->getAll();
        $iteminventario =  DB::select('select * from tb_item_inventario where invi_str_nombre like ?', ["%{$text}%"] );
        return response()
            ->json(['data' =>$iteminventario], 200);
    }

    /**
     * Store a new Item. Debe devolver una vista
     *
     * @param  Request $request
     * @return Response
     */
    public function storeProducto(Request $request)
    {
        $Producto = new pro;
        $mytime =Carbon::now();      
        
        $ProductoInsert = new pro;  

        $ProductoInsert->pro_str_nombre = $request->input('pro_str_nombre');
        $ProductoInsert->pro_bit_estado = 1;
        $ProductoInsert->pro_dat_fecha_creacion = $mytime;
        $ProductoInsert->pro_dat_fecha_modificacion = $mytime;
        $ProductoInsert->pro_str_usuario_creacion = "Admin";
        $ProductoInsert->pro_str_usuario_modificacion =  "Admin";
        $ProductoInsert->pro_dbl_precio_venta = $request->input('pro_dbl_precio_venta');    
        $ProductoInsert->pro_dbl_costo_produccion = $request->input('pro_dbl_costo_produccion');

        $this->productoObject->create($ProductoInsert->toArray());       
        return redirect('/Producto');

    }

    /**
     * Store a new Item. Debe devolver una vista
     *
     * @param  Request $request
     * @return Response
     */
    public function updateProducto(Request $request)
    {
        $Producto= new pro;
        $mytime =Carbon::now();

        $id_Producto = $request->input('pro_int_id');
        $ProductoUpdate = new pro;  
        $ProductoUpdate->pro_str_nombre = $request->input('pro_str_nombre');
        $ProductoUpdate->pro_bit_estado = 1;
        $ProductoUpdate->pro_dat_fecha_modificacion = $mytime;
        $ProductoUpdate->pro_str_usuario_modificacion =  "Admin";
        $ProductoUpdate->pro_dbl_precio_venta = $request->input('pro_dbl_precio_venta');    
        $ProductoUpdate->pro_dbl_costo_produccion = $request->input('pro_dbl_costo_produccion');

        $this->productoObject->update($id_Producto, $ProductoUpdate->toArray());         
        return redirect('/Producto');

    }

    /**
     * Store a new Item. Debe devolver una vista
     *
     * @param  Request $request
     * @return Response
     */
    public function storeProductoDetalle(Request $request)
    {
        $ProductoDetalle = new prod;
        $mytime =Carbon::now();      
        
        $ProductoDetalleInsert = new prod;  
        $ProductoDetalleInsert->invi_int_id = 1;
        $ProductoDetalleInsert->pro_int_id = $request->input('pro_int_id');
        $ProductoDetalleInsert->prod_str_nombre = $request->input('prod_str_nombre');
        $ProductoDetalleInsert->prod_bit_estado = 1;
        $ProductoDetalleInsert->prod_int_item = 1;
        $ProductoDetalleInsert->prod_dat_usuario_creacion = $mytime;
        $ProductoDetalleInsert->prod_dat_usuario_modificacion = $mytime;
        $ProductoDetalleInsert->prod_str_usuario_creacion = "Admin";
        $ProductoDetalleInsert->prod_str_usuario_modificacion =  "Admin";
        $ProductoDetalleInsert->prod_dbl_costo_produccion_item = $request->input('prod_dbl_costo_produccion_item');    
        $ProductoDetalleInsert->prod_dbl_cantidad_item = $request->input('prod_dbl_cantidad_item');
        $ProductoDetalleInsert->prod_str_tipo_medida_salida = " ";
        $ProductoDetalleInsert->prod_int_tipo_medida_salida = $request->input('prod_int_tipo_medida_salida');

        $this->productodetalleObject->create($ProductoDetalleInsert->toArray());       
        return redirect('/Producto');

    }
}
