@extends('Layout')

@section('ProductoBandeja')
<style>
{ box-sizing: border-box; }
body {
  font: 16px Arial;
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
                                    <iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>
                                    <row> 
                                        <form id="CreatePedido" target="dummyframe"> 
                                             @csrf                                 
                                            <input class="form-control" name="pro_int_id" id="pro_id" hidden>
                                            <input class="form-control" name="ped_int_id" id="ped_int_id" hidden>
                                            <div class="form-group autocomplete">                                    
                                                <label for="pro_str_nombre" >Producto:</label>
                                                <input class="form-control" name="pro_str_nombre" id="pro_str_nombre" autocomplete="off">
                                            </div>                                  
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <label>Cantidad:</label>
                                                    <input type="number" min="1" max="100" class="form-control" name="pedd_int_cantidad"  >
                                                 </div>
                                                <div class="col-md-6">
                                                    <label>Costo venta:</label>
                                                    <input type="text" class="form-control" name="pedd_dbl_precio" id="pedd_dbl_precio"  >
                                                 </div>                                                                         
                                            </div>                                        
                                            <button onClick="onNuevoPedido(this)" class="btn btn-primary">Añadir Pedido</button>    
                                         </form>  
                                    </row>
                                    <row>                                    
                                            <table id="dvPedido"  class="table table-striped table-hover responsive">
                                            </table>                                      
                                    </row>
                                    <row>    
                                        <button onClick="onNuevoPedidoDetalle(this)" type="button"  class="btn btn-primary">Confirmar Pedido</button>
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
    var _ITEMS_PRODUCTO;
    $(document).ready(function() {

             $('#divProductoDetalleModal').on('shown.bs.modal', function () {

            });

            $('#divProductoDetalleModal').on('hidden.bs.modal', function (e) {
               //$("#divProductoDetalle").empty();
            });

            var s="<div name='prueba' class='col-md-3'>NUMERO PEDIDO.</div>";
            $("#targetDIV").append(s)    
            //crearTablaProducto();
    });
    
    function onClickNuevo (e){          
            debugger     
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

    function onNuevoPedido(e){
        var pedidoid =  $('#ped_int_id').val();
        // CREAR EL PEDIDO CAB,
        // RETORNE SU ID -> PARA VALIDAR LAS MODAS
        if(pedidoid > 0){
            //e.preventDefault();
            $.ajax({
            type: 'POST',
            url: 'guardarPedido'+'?_token=' + '{{ csrf_token() }}',
            data: $('#CreatePedido').serialize(),
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                $('#ped_int_id').val(data.data);
            }
            });
        }else{
            $.ajax({
            type: 'POST',
            url: 'AgregarPedidoDetalle'+'?_token=' + '{{ csrf_token() }}',
            data: $('#CreatePedido').serialize(),
            contentType: 'application/json; charset=utf-8',
            success: function (data) {
                //$('#ped_int_id').val(data.data);
            }
            });
        }  
        // CREAR EL PEDIDO DETALLE
        // AL CONFIRMAR EL PEDIDO SE AGREGUEN LOS IDS. y las CANTIDADES
    }

    function crearTablaProducto(){

        $("#dvPedido").DataTable({

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
                   // { title: "Cantidad", data: "pro_dbl_precio_venta", name: "pro_dbl_precio_venta", "autoWidth": true, "className": "text-right" },
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
                debugger    
                const productos = _ITEMS_PRODUCTO.filter((b) => { return b.pro_str_nombre ==  $("#pro_str_nombre").val()});
                $("#pro_id").val(productos[0].pro_int_id);      
                $("#pedd_dbl_precio").val(productos[0].pro_dbl_precio_venta);              
                $("#pro_str_nombre").attr("readonly", true);
                
    }
</script>

@stop