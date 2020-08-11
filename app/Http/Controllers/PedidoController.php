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
        $input =  (json_decode($request->getContent(), true));

        $mytime =Carbon::now();     
        $PedidoInsert = new ped;
        $PedidoDetalleInsert = new pedd;
        $PedidoInsert->ped_str_mesa = "Test";
        $PedidoInsert->ped_dat_fecha_inicio = $mytime;
        //CLIENTE
        $PedidoInsert->ped_str_telefono_cliente = $input['cli']['Telefono'];
        $PedidoInsert->ped_str_nombre_cliente = $input['cli']['Nombre'];
        $PedidoInsert->ped_str_direccion_cliente = $input['cli']['Direccion'];
        // MONTOS
        $PedidoInsert->ped_dbl_igv = 0;
        $PedidoInsert->ped_dbl_isc = 0;
        $PedidoInsert->ped_dbl_valor_neto = 0;    
        $PedidoInsert->ped_dbl_venta_total = 0;
        $PedidoInsert->ped_dbl_descuento = 0;
        // ESTADOS DEL PEDIDO
        $PedidoInsert->ped_bit_cancelado = 0;
        $PedidoInsert->ped_bit_combo = 0;
        $PedidoInsert->ped_int_estado_pedido = 1; //CREADO
        $PedidoInsert->ped_int_estado = 1;
        // AUDITORIA
        $PedidoInsert->ped_int_empresa = 1;
        $PedidoInsert->ped_dat_fecha_creacion = $mytime;
        $PedidoInsert->ped_str_fecha_modificacion = $mytime;
        $PedidoInsert->ped_str_usuario_creacion = "Admin";
        $PedidoInsert->ped_str_usuario_modificacion =  "Admin";

        $this->pedidoObject->create($PedidoInsert->toArray());    

        $insertedId = $id = DB::getPdo()->lastInsertId();  

        $total_precio_venta = 0;

        ($input['ped']);

        foreach ($input['ped'] as $item)
        {
            error_log($item['IdProducto']);
            $PedidoDetalleInsert->pedd_dbl_precio = $item['Precio'] ;
            $PedidoDetalleInsert->pedd_int_cantidad = $item['Cantidad'] ;
            $PedidoDetalleInsert->ped_int_id = $insertedId;
            $PedidoDetalleInsert->pro_int_id = $item['IdProducto'] ;
            $PedidoDetalleInsert->pedd_int_item =  1;
            // ESTADOS DEL PEDIDO
            $PedidoDetalleInsert->pedd_bit_cancelado = 0;
            $PedidoDetalleInsert->pedd_int_estado_detalle = 1;
            // AUDITORIA
            $PedidoDetalleInsert->pedd_dat_fecha_creacion = $mytime;
            $PedidoDetalleInsert->pedd_dat_fecha_modificacion = $mytime;
            $PedidoDetalleInsert->pedd_str_usuario_creacion = "Admin";
            $PedidoDetalleInsert->pedd_str_usuario_modificacion =  "Admin";

            $total_precio_venta += $PedidoDetalleInsert->pedd_dbl_precio;

            $this->pedidoDetalleObject->create($PedidoDetalleInsert->toArray());   
        }

        //CERRAR PRECIOS TOTALES.
        $Pedido = new ped;
        // MONTOS
        $Pedido->ped_dbl_igv = 0;    
        $Pedido->ped_dbl_isc = 0;
        $Pedido->ped_dbl_descuento = 0;
        $Pedido->ped_dbl_valor_neto = $total_precio_venta;// SUM()    

        $Pedido->ped_dbl_venta_total = $total_precio_venta;// ped_dbl_valor_neto+ped_dbl_isc+ped_dbl_igv+ped_dbl_descuento
        // AUDITORIA                     
        $Pedido->ped_str_fecha_modificacion = $mytime; 
        $Pedido->ped_str_usuario_modificacion =  "Admin";
        $this->pedidoObject->update($insertedId, $Pedido->toArray());    

        return response()
            ->json(['data' =>$insertedId], 200);

    }

    
    public function listarPedidos()
    { 

      $Pedido =  DB::select('select * from tb_pedidos p where ped_int_estado_pedido = 1');
      
      return response()
            ->json(['draw' => 10,'recordsTotal' => 10,'recordsFiltered' => 10,'data' =>$Pedido]);
    }

    
    public function listarPedidoDetalle($id)
    { 

      $PedidoDetalle =  DB::select('select pd.*, p.pro_str_nombre, tp.ped_str_nombre_cliente, tp.ped_str_telefono_cliente, tp.ped_str_direccion_cliente from 
      tb_pedidos_detalle pd inner join tb_productos p on pd.pro_int_id = p.pro_int_id inner join tb_pedidos tp on tp.ped_int_id = pd.ped_int_id 
      where pedd_int_estado_detalle = 1 and pd.ped_int_id = ?', [$id] );
      
      return response()
            ->json(['draw' => 10,'recordsTotal' => 10,'recordsFiltered' => 10,'data' =>$PedidoDetalle]);
    }

      /**
     * Store a new Item. Debe devolver una vista
     *
     * @param  Request $request
     * @return Response
     */
    public function sellPedido($id)
    {   
        $mytime =Carbon::now();     
        $PedidoInsert = new ped;             
        //ID
        $insertedId = $id;  
        $Pedido = new ped;
        // MONTOS
        $Pedido->ped_int_estado_pedido = 3; //VENDIDO    
        // AUDITORIA                     
        $Pedido->ped_str_fecha_modificacion = $mytime; 
        $Pedido->ped_str_usuario_modificacion =  "Admin";

        $this->pedidoObject->update($insertedId, $Pedido->toArray());    

        $PedidoDetalle =  DB::select('CALL SP_CERRAR_PEDIDO (?,?,?)', [$id,"Admin",3] );
        
        return response()
            ->json(['data' =>$insertedId], 200);

    }

          /**
     * Store a new Item. Debe devolver una vista
     *
     * @param  Request $request
     * @return Response
     */
    public function cancelPedido($id)
    {   
        $mytime =Carbon::now();     
        $PedidoInsert = new ped;             
        //ID
        $insertedId = $id;  
        $Pedido = new ped;
        // MONTOS
        $Pedido->ped_int_estado_pedido = 4; //VENDIDO    
        // AUDITORIA                     
        $Pedido->ped_str_fecha_modificacion = $mytime; 
        $Pedido->ped_str_usuario_modificacion =  "Admin";

        $this->pedidoObject->update($insertedId, $Pedido->toArray());          
        return response()
            ->json(['data' =>$insertedId], 200);

    }
}
