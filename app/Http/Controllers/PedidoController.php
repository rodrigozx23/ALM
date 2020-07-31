<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PedidoInterface as pedidoI;
use App\Repositories\PedidoDetalleInterface as pedidodI;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pedido as ped;
use App\PedidoDetalle as pedd;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class PedidoController extends Controller
{
    
    protected $pedidoObject;
    protected $pedidoDetalleObject;

    public function __construct(pedidoI $p, pedidodI $pd)
    {
        $this->pedidoObject = $p;     
        $this->pedidoDetalleObject = $pd;  
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function listarProducto(Request $request)
    {
        $text = $request->input('text'); //$request->query('text');
        //$iteminventario =  $this->iteminventarioObject->getAll();
        $producto =  DB::select('select * from tb_productos where pro_str_nombre  like ?', ["%{$text}%"] );
        return response()
            ->json(['data' =>$producto], 200);
    }

     /**
     * Store a new Item. Debe devolver una vista
     *
     * @param  Request $request
     * @return Response
     */
    public function storePedido(Request $request)
    {
        $Pedido = new ped;
        $mytime =Carbon::now();      
        
        $PedidoInsert = new ped;  

        $PedidoInsert->ped_str_mesa = "Test";
        $PedidoInsert->ped_dat_fecha_inicio = $mytime;
        // MONTOS
        $PedidoInsert->ped_dbl_igv = 0;    
        $PedidoInsert->ped_dbl_isc = 0;
        $PedidoInsert->ped_dbl_valor_neto = 0;    
        $PedidoInsert->ped_dbl_venta_total = 0;
        $PedidoInsert->ped_dbl_descuento = 0;
        // ESTADOS DEL PEDIDO
        $PedidoInsert->ped_bit_cancelado = 0;
        $PedidoInsert->ped_bit_combo = 0;
        $PedidoInsert->ped_int_estado_pedido = 1;
        $PedidoInsert->ped_int_estado = 1;
        // AUDITORIA
        $PedidoInsert->ped_int_empresa = 1;
        $PedidoInsert->ped_dat_fecha_creacion = $mytime;
        $PedidoInsert->ped_str_fecha_modificacion = $mytime;
        $PedidoInsert->ped_str_usuario_creacion = "Admin";
        $PedidoInsert->ped_str_usuario_modificacion =  "Admin";

        $this->pedidoObject->create($PedidoInsert->toArray());    

        $insertedId = $id = DB::getPdo()->lastInsertId();    
        return response()
            ->json(['data' =>$insertedId], 200);

    }

    
    public function listarPedidoDetalle($id)
    { 

      $PedidoDetalle =  DB::select('select * from tb_pedidos_detalle where pedd_int_estado_detalle = 1 and ped_int_id= ?', [$id] );
      //var_dump($ProductoDetalle);
      
      return response()
            ->json(['draw' => 10,'recordsTotal' => 10,'recordsFiltered' => 10,'data' =>$PedidoDetalle]);
    }
}
