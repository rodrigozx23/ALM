<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ItemInventarioInterface as itemI;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\item_inventario as invi;
use Carbon\Carbon;

class AlmacenController extends Controller
{
    protected $iteminventarioObject;

    public function __construct(itemI $ii)
    {
        $this->iteminventarioObject = $ii;
    }

    public function getAllItems()
    {
      return $this->iteminventarioObject->getAll();
    }

    public function listarAlmacen()
    {
      $iItems = $this->iteminventarioObject->getAll();
      return response()
            ->json(['draw' => 10,'recordsTotal' => 10,'recordsFiltered' => 10,'data' =>$iItems->toArray()]);
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
}
