@extends('PedidoDetalle')
@section('PedidoDetalle')
<div class="wrapper wrapper-content">
    <div class="row">       
            <div class="col-lg-10">
                <div class="box-default">
                    <div class="table-responsive">
                        <br />
                        <div id="divResumenPedidoDetalle"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('bandejajs')
<script type="text/javascript">
    $(document).ready(function() {
        
    });

    function CrearTablaManual(e){
            $("#divResumenPedidoDetalle").empty();

            let text = '';
            var _Pedido = $("#divProductoDetalle").val();
            $.get("listarPedidoDetalle/"+_Pedido,{},function(data){
                console.log(data);
                    let cant = 1;
                    text += '<table class="table table-striped table-hover responsive">';
                    text += '   <thead>';
                    text += '   <tr>';
                    text += '       <th>#</th>';
                    text += '       <th>Descripcion</th>';
                    text += '       <th>Cantidad</th>';
                    text += '       <th>Costo Venta</th>'; 
                    text += '   </tr>';
                    text += '   </thead>';
                    text += '   <tbody>';
                    for(var i = 0; i< data.data.length; i++){
                        text += '   <tr>';
                        text += '       <td>'+cant+'</td>';
                        text += '       <td>'+data.data[i]['pro_str_nombre']+'</td>';                      
                        text += '       <td>'+data.data[i]['pedd_int_cantidad']+'</td>';  
                        text += '       <td>'+data.data[i]['pedd_dbl_precio']+'</td>';  
                        text += '   </tr>';
                        cant++;
                    }      
                    text += '   </tbody>';
                    text += '   </table>';

                    $("#divResumenPedidoDetalle").append(text);
            },'json')
        }
</script>
@stop