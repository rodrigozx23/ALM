@extends('Layout')

@section('ProductoBandeja')
<div  class="wrapper wrapper-content">

    <div class="row">

        <div class="col-md-10">
        </div>
        <div class="col-md-2">
            <button type="button"  class="btn btn-primary btn-rounded btn-block" onclick="onClickNuevo(this)" >
                <strong>Nuevo</strong>
            </button>
        </div>
        <div class="modal fade" id="divProductoDetalleModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div id="divContentProductoDetalle">    
                                    <row> 
                                        <for id="CreatePedido" action="{{url('/guardarPedido')}}" method="post"> 
                                             @csrf                                 
                                            <br />
                                            <div id="divProductoDetalle">
                                            <table id="dvProducto"  class="table table-striped table-hover responsive">
                                            </table>
                                            </div>
                                         </form>  
                                    </row>
                                    <row>    
                                        <button onClick="onNuevoPedido(this)" type="button"  class="btn btn-primary">GRABAR</button>
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                    </row>                
                            </div>  
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="row">  

        <div id="targetDIV" class="col-lg-12">

        </div>
    </div>


</div>

@endsection

@section('bandejajs')
<script type="text/javascript">

    $(document).ready(function() {

             $('#divProductoDetalleModal').on('shown.bs.modal', function () {

            });

            $('#divProductoDetalleModal').on('hidden.bs.modal', function (e) {
               //$("#divProductoDetalle").empty();
            });

            var s="<div name='prueba' class='col-md-3'>NUMERO PEDIDO.</div>";
            $("#targetDIV").append(s)    
            crearTablaProducto();
    });
    
    function onClickNuevo (e){
            $('#divProductoDetalleModal').modal("show");         
           // ("#tbproducto > tr").remove();
    }

    function onNuevoPedido(e){
            event.preventDefault();
            table =  $("#dvProducto").DataTable();
            var seleccionados = table.rows({ selected: true }).data();    
            if(!seleccionados.length)
                alert("No ha seleccionado ningún producto");
            else{
                var i=0;
                while(i < seleccionados.length){
                    $('<input>', {
                        type: 'hidden',
                        value: seleccionados[i][1],
                        name: 'ids[]'
                    }).appendTo('#CreatePedido');
                    console.log(    $("#CreatePedido").val())
                    i++;
                }
                $("#CreatePedido").submit();
            } 
    }

    function crearTablaProducto(){

        $("#dvProducto").DataTable({

            responsive: true,
            retrieve: true,
            processing: false,
            serverSide: false,
            paging: true,
            searching: true,
                ajax: {
                    url: "/PP",
                    type: 'get',
                },
                columns: [
                    { title: "id", data: "pro_int_id", name: "pro_int_id", "visible": false},
                    {   data:   "active",
                            render: function ( data, type, row ) {
                                return '<input name="idCBox" type="checkbox" class="editor-active">';                                                   
                            },
                            className: "dt-body-center"      
                    },                                                
                    { title: "Descripcion", data: "pro_str_nombre", name: "pro_str_nombre", "autoWidth": true },
                    /*{
                        "title": "#", "mData": null, "bSortable": false, className: "text-center",
                        "mRender": function (row) {
                            return `<a class="btn btn-primary btn-rounded btn-outline btn-sm"><b onclick="fnOnClickModal(this)" >Editar</b></a>`;
                            //return `<a href="${Ruta}?Id=${row.id}&editAction=2" class="btn btn-primary btn-rounded btn-outline btn-sm"><b>Editar</b></a>`;
                        }
                    },*/   
                    {
                        "title": "Cantidad", "mData": null, "bSortable": false, className: "text-center",
                        "mRender": function (row) {
                            return `<a> <input type="number" min="1" max="100"></a>`;
                            //return `<a href="${Ruta}?Id=${row.id}&editAction=2" class="btn btn-primary btn-rounded btn-outline btn-sm"><b>Editar</b></a>`;
                        }
                    },
                    { title: "Precio Venta", data: "pro_dbl_precio_venta", name: "pro_dbl_precio_venta", "autoWidth": true, "className": "text-right" },

                    /*{
                        "title": "#", "mData": null, "bSortable": false, className: "text-center",
                        "mRender": function (row) {
                            return `<a class="btn btn-primary btn-rounded btn-outline btn-sm"><b onclick="fnOnClickModalDetalle(this)" >Agregar</b></a>`;
                            //return `<a href="${Ruta}?Id=${row.id}&editAction=2" class="btn btn-primary btn-rounded btn-outline btn-sm"><b>Editar</b></a>`;
                        }
                    },*/
                ], 
            select: true,
            autoWidth: false,
            lengthChange: true,
            lengthMenu: [11, 20, 30, 100]
            });
    }

   function CrearTablaManual(){
            let text = '';
            $.get("/PP",{},function(data){
                console.log(data);
                    let cant = 1;
                    text += '<table id="tbproducto" class="table table-striped table-hover responsive">';
                    text += '   <thead>';
                    text += '   <tr>';
                    text += '       <th>#</th>';
                    text += '       <th>Descripcion</th>';
                    text += '       <th>Cantidad</th>';
                    text += '       <th>Precio Venta</th>'; 
                    text += '       <th></th>'; 
                    text += '   </tr>';
                    text += '   </thead>';
                    text += '   <tbody>';
                    for(var i = 0; i< data.data.length; i++){
                        text += '   <tr>';
                        text += '       <td>'+cant+'</td>';
                        text += '       <td>'+data.data[i]['pro_str_nombre']+'</td>';                      
                  
                        //text += '       <td>'+data.data[i]['prod_dbl_cantidad_item']+'</td>';  
                        //    text += '       <td>'+data.data[i]['prod_dbl_costo_produccion_item']+'</td>';                   
                        text += '       <td>CANTIDAD</td>';    
                        text += '       <td>'+data.data[i]['pro_dbl_precio_venta']+'</td>';           
                        text += '       <td></td>';     
                        text += '   </tr>';
                        cant++;
                    }      

                    text += '   </tbody>';
                    text += '   </table>';

                    $("#divProductoDetalle").append(text);
                    
            },'json');
     
        }


</script>

@stop