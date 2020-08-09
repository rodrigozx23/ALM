@extends('Layout')

@section('Bandeja')
<style>
{ box-sizing: border-box; }
body {
  font: 16px Arial;
}
.btnPed{
    margin: 10px;
    padding: 10px;
    text-align: center;
    border: 1px solid black;
}
.autocomplete {
  /*the container must be positioned relative:*/
  width: 100%;
  position: relative;
  display: inline-block;
}
input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}
input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}
input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
}
.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}
.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff;
  border-bottom: 1px solid #d4d4d4;
}
.autocomplete-items div:hover {
  /*when hovering an item:*/
  background-color: #e9e9e9;
}
.autocomplete-active {
  /*when navigating through the items using the arrow keys:*/
  background-color: DodgerBlue !important;
  color: #ffffff;
}
</style>
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
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong id="MensajeError"></strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                                
                                    <row> 
                                        <form id="CreatePedido" target="dummyframe">                               
                                            <input class="form-control" name="pro_int_id" id="pro_int_id" hidden>
                                            <input class="form-control" name="ped_int_id" id="ped_int_id" hidden>
                                            <div class="form-group autocomplete">                                    
                                                <label for="pro_str_nombre" >Producto:</label>
                                                <input class="form-control" name="pro_str_nombre" id="pro_str_nombre" autocomplete="off">
                                            </div>                                  
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Cantidad:</label>
                                                    <input type="number" min="1" max="100" value="1" class="form-control" name="pedd_int_cantidad" id="pedd_int_cantidad" >
                                                 </div>
                                                <div class="col-md-6">
                                                    <label>Precio Unitario:</label>
                                                    <input type="text" class="form-control" name="pedd_dbl_precio" id="pedd_dbl_precio"  >
                                                 </div>                                                                         
                                            </div>                                        
                                            <button onClick="onAddPedidoDetalle(this)" class="btn btn-primary">Añadir Pedido</button>    
                                         </form>  
                                    </row>
                                    <row>
                                        <table id="tableDetallePedido" class="table table-striped table-hover responsive">
                                            <thead>
                                            <tr>
                                            <th>#</th>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Sub Total</th>
                                            </tr>
                                            </thead>
                                            <tbody id="divProductoDetalle">
                                            </tbody>
                                        </table>                               
                                    </row>
                                    <row>    
                                        <button onClick="onConfirmar(this)" type="button"  class="btn btn-primary">Confirmar Pedido</button>
                                        <button type="button" class="btn btn-primary" id="idCerrarNuevoDetalle" data-dismiss="modal">Cerrar</button>
                                    </row>                
                            </div>  
                        </div>
                    </div>
                </div>
        </div>

        <div class="modal fade" id="divPedidoModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div id="divContentPedido">    
                                    <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                                    <row> 
                                        <form id="UpdatePedido" target="dummyframe">                               
                                            <input class="form-control" name="ped_int_id" id="ped_int_id" hidden>                             
                                                                   
                                         </form>  
                                    </row>
                                    <row>
                                        <table id="tabledp" class="table table-striped table-hover responsive">
                                            <thead>
                                                <tr>
                                                <th>#</th>
                                                <th>Descripcion</th>
                                                <th>Cantidad</th>
                                                <th>Sub Total</th>
                                            </tr>
                                            </thead>
                                            <tbody id="divPedidoDetalle">
                                            </tbody>
                                            <tfoot id="divTotalesPD">
                                            </tfoot>
                                        </table>                               
                                    </row>
                                    <row>    
                                        <button onClick="" type="button"  class="btn btn-primary">CancelarPedido</button>
                                        <button onClick="" type="button"  class="btn btn-primary">GUARDAR</button>
                                        <button type="button" class="btn btn-primary" id="idCerrarNuevoDetalle" data-dismiss="modal">Cerrar</button>
                                    </row>                
                            </div>  
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="row"> 
        <div class="col-sm-2">                    
            <div id="targetList" class="list-group"></div>
        </div>
        <div class="col-sm-1">
        </div>
        <div class="col-sm-9">                   
            <div  class="Container">                 
                    <div class="row align-items-center">        
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
    </div>
</div>

@endsection

@section('bandejajs')
<script type="text/javascript">
    var _ITEMS_PRODUCTO;
    $(document).ready(function() {

             $('#divProductoDetalleModal').on('shown.bs.modal', function () {
                $("#divProductoDetalle").empty();
                $('#pedd_int_cantidad').val("1");
                PedidoDetalle = [];
            });

            $('#divProductoDetalleModal').on('hidden.bs.modal', function (e) {
                $("#divProductoDetalle").empty();
                PedidoDetalle = [];
            });

            CrearBotonesPedidos()
    });
    
    function onClickNuevo (e){            
            var postData = {
                            "text" :  $("#pro_str_nombre").val(),
                            "_token" : "{{ csrf_token() }}",
                        }; 
            const Productositems = []; 
            $.ajax( {
                        url: "listarProducto",
                        type: 'POST',
                        data: postData,
                        success: function( data ) {
                            _ITEMS_PRODUCTO = data.data;
                            $.map(data.data, function (value, key) {
                                const count = Productositems.push(value.pro_str_nombre);    
                            });
                        }
                    } 
                );                
            autocomplete(document.getElementById("pro_str_nombre"), Productositems);       
            $('#divProductoDetalleModal').modal("show");         
           // ("#tbproducto > tr").remove();
    }

    function onAddPedidoDetalle(e){
        var pedidoid =  $('#ped_int_id').val();
        // CREAR EL PEDIDO CAB,
        // RETORNE SU ID -> PARA VALIDAR LAS MODAS
        var pro_id = $('#pro_int_id').val();
        if(pro_id.length == 0 || pro_id.length < 0){
            $('#MensajeError').text("Debe Seleccionar un producto.");
            return;
        }

        var parametros = {              
                "ped_int_id" : pedidoid,
                "pro_int_id" : $('#pro_int_id').val(),
                "pedd_int_cantidad" : $('#pedd_int_cantidad').val(),
                "pedd_dbl_precio" : $('#pedd_dbl_precio').val(),
                "pro_str_nombre" : $('#pro_str_nombre').val(),
        };
        insertarDetalloPedido(parametros)

            $('#pro_int_id').val(""),
            $('#pedd_int_cantidad').val("1"),
            $('#pedd_dbl_precio').val(""),
            $('#pro_str_nombre').val(""),
            $("#pro_str_nombre").attr("readonly", false);
    }

    function autocomplete(inp, arr) {
            /*the autocomplete function takes two arguments,
            the text field element and an array of possible autocompleted values:*/
            var currentFocus;
            /*execute a function when someone writes in the text field:*/
            inp.addEventListener("input", function(e) {
                var a, b, i, val = this.value;
                /*close any already open lists of autocompleted values*/
                closeAllLists();
                if (!val) { return false;}
                currentFocus = -1;
                /*create a DIV element that will contain the items (values):*/
                a = document.createElement("DIV");
                a.setAttribute("id", this.id + "autocomplete-list");
                a.setAttribute("class", "autocomplete-items");
                /*append the DIV element as a child of the autocomplete container:*/
                this.parentNode.appendChild(a);
                /*for each item in the array...*/
                for (i = 0; i < arr.length; i++) {
                    /*check if the item starts with the same letters as the text field value:*/
                    if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/
                    b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                    b.innerHTML += arr[i].substr(val.length);
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                        b.addEventListener("click", function(e) {
                        /*insert the value for the autocomplete text field:*/
                        inp.value = this.getElementsByTagName("input")[0].value;
                        /*close the list of autocompleted values,
                        (or any other open lists of autocompleted values:*/
                        closeAllLists();
                        guardaridItem();
                    });
                    a.appendChild(b);
                    }
                }
            });
            /*execute a function presses a key on the keyboard:*/
            inp.addEventListener("keydown", function(e) {
                var x = document.getElementById(this.id + "autocomplete-list");
                if (x) x = x.getElementsByTagName("div");
                if (e.keyCode == 40) {
                    /*If the arrow DOWN key is pressed,
                    increase the currentFocus variable:*/
                    currentFocus++;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 38) { //up
                    /*If the arrow UP key is pressed,
                    decrease the currentFocus variable:*/
                    currentFocus--;
                    /*and and make the current item more visible:*/
                    addActive(x);
                } else if (e.keyCode == 13) {
                    /*If the ENTER key is pressed, prevent the form from being submitted,*/
                    e.preventDefault();
                    if (currentFocus > -1) {
                    /*and simulate a click on the "active" item:*/
                    if (x) x[currentFocus].click();
                    }
                }
            });
            function addActive(x) {
                /*a function to classify an item as "active":*/
                if (!x) return false;
                /*start by removing the "active" class on all items:*/
                removeActive(x);
                if (currentFocus >= x.length) currentFocus = 0;
                if (currentFocus < 0) currentFocus = (x.length - 1);
                /*add class "autocomplete-active":*/
                x[currentFocus].classList.add("autocomplete-active");
            }
            function removeActive(x) {
                /*a function to remove the "active" class from all autocomplete items:*/
                for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
                }
            }
            function closeAllLists(elmnt) {
                /*close all autocomplete lists in the document,
                except the one passed as an argument:*/
                var x = document.getElementsByClassName("autocomplete-items");
                for (var i = 0; i < x.length; i++) {
                    if (elmnt != x[i] && elmnt != inp) {
                        x[i].parentNode.removeChild(x[i]);
                    }                
                }
            }
            /*execute a function when someone clicks in the document:*/
            document.addEventListener("click", function (e) {
                closeAllLists(e.target);
            });

    } 

    function guardaridItem(){               
        const productos = _ITEMS_PRODUCTO.filter((b) => { return b.pro_str_nombre ==  $("#pro_str_nombre").val()});
        
        $("#pro_int_id").val(productos[0].pro_int_id);      
        $("#pedd_dbl_precio").val(productos[0].pro_dbl_precio_venta);              
        $("#pro_str_nombre").attr("readonly", true);
                
    }

    function fnOnClickModalDetalle(e){         
            var table = $('#dvPedido').DataTable(); 
            $('#dvPedido tbody').on( 'click', 'tr', function () {
                var rowData = table.row( this ).data();
                _PRODUCTO = rowData.pro_int_id;     
            } );
            $("#divProductoDetalle").empty();      
            $('#divProductoDetalleModal').modal("show");         
    }

    let PedidoDetalle = []
    function insertarDetalloPedido(parametros){
        const DETALLE = {
                    IdPedido: 0,
                    IdProducto: 0,
                    Cantidad: 0,
                    Precio: 0,
                    Descripcion:""
        };    

        const pedidodetalle = Object.create(DETALLE);

        pedidodetalle.Descripcion = parametros.pro_str_nombre; 
        pedidodetalle.IdProducto = parametros.pro_int_id;
        pedidodetalle.pro_str_nombre = parametros.pro_str_nombre; 
        pedidodetalle.Cantidad = parametros.pedd_int_cantidad;
        pedidodetalle.Precio = parametros.pedd_int_cantidad * parametros.pedd_dbl_precio; 
        if(PedidoDetalle.length == 0){
            PedidoDetalle.push(pedidodetalle);            
        }
        else if(PedidoDetalle.find(e => e.Descripcion == pedidodetalle.Descripcion)){
            debugger;
            for(var i = 0; i < PedidoDetalle.length; i++){ 
                if(PedidoDetalle[i]['Descripcion'] == pedidodetalle.Descripcion){
                    PedidoDetalle[i].Cantidad  =    parseInt(PedidoDetalle[i].Cantidad) +  parseInt(pedidodetalle.Cantidad);
                    PedidoDetalle[i].Precio =     parseFloat(PedidoDetalle[i].Precio) +  parseFloat(pedidodetalle.Precio);
                } 
            }  

        }
        else{
            PedidoDetalle.push(pedidodetalle);     
        }

        let textDetalle = '';
      
         $("#divProductoDetalle").empty();

        var contador = 1;
        for(var i = 0; i < PedidoDetalle.length; i++){   
            textDetalle += '   <tr>';       
            textDetalle += '       <td>'+contador+'</td>';            
            textDetalle += '       <td>'+PedidoDetalle[i]['Descripcion']+'</td>';  
            textDetalle += '       <td>'+PedidoDetalle[i]['Cantidad']+'</td>';  
            textDetalle += '       <td>'+PedidoDetalle[i]['Precio']+'</td>';  
            textDetalle += '   <tr>';    
            contador++; 
        }                                  
        $("#divProductoDetalle").append(textDetalle);
    }

    function onConfirmar (){
        var envio = PedidoDetalle;
        console.log(JSON.stringify(envio));
        $.ajax({
            type: 'POST',
            url: 'guardarPedido'+'?_token=' + '{{ csrf_token() }}',
            data: JSON.stringify(envio),
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                $("#divProductoDetalle").empty();                  
                $('#divProductoDetalleModal').modal('hide');
                CrearBotonesPedidos();
                PedidoDetalle = [];                
            }
        });   
    }
     
    
    function CrearTablaManual(e){
            $("#divResumenPedidoDetalle").empty();
            let text = '';
            var totalPrecio = 0;    
            $.get("listarPedidoDetalle/"+e,{},function(data){
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
                        console.log(data.data);
                        text += '   <tr>';
                        text += '       <td>'+cant+'</td>';
                        text += '       <td>'+data.data[i]['pro_str_nombre']+'</td>';                      
                        text += '       <td>'+data.data[i]['pedd_int_cantidad']+'</td>';  
                        text += '       <td>'+data.data[i]['pedd_dbl_precio']+'</td>';  
                        text += '   </tr>';
                        cant++;              
                        totalPrecio += parseFloat(data.data[i]['pedd_dbl_precio']); 
                    }      
            
                    text += '   </tbody>';
                    text += '   <tfoot>';
                    text += '   <tr>';
                    text += '       <td></td>';
                    text += '       <td></td>';                      
                    text += '       <td>Total</td>';  
                    text += '       <td>'+totalPrecio.toFixed(2)+'</td>';  
                    text += '   </tr>';       
                    text += '   </tfoot>';
                    text += '   </table>';

                    $("#divResumenPedidoDetalle").append(text);
            },'json')
        }
     
    function CrearBotonesPedidos(){
        $("#targetList").empty();
        let text = '';
        
        $.get("listarPedidos/",{},function(data){
            for(var i = 0; i < data.data.length; i++){
                text += '<button id="" onclick="return  CrearTablaManual('+data.data[i]['ped_int_id']+')" type="button" class="list-group-item list-group-item-action btnPed" value="'+data.data[i]['ped_int_id']+'">Pedido</button>';
            }
            $("#targetList").append(text);
        },'json')
    }
</script>
@stop