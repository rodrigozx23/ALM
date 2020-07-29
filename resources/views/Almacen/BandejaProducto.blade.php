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
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="box-default">

                <br />
                <h2 style="margin: 10px 0 0 0; font-weight:600;">Producto</h2>
                <br />

                <div id="searchPanel" style="padding: 0 10px 0 10px;">
                        <div class="row">
                            <div class="form-group">
                                <label>Nombre:</label>
                                <input type="text" class="form-control" name="pro_str_nombre" disabled >
                            </div>
                        </div>
                </div>
                <br />
                <div class="form-group">
                    <button type="button" class="btn btn-primary btn-rounded btn-block" onclick="onClickBuscar(this)" disabled><strong>Buscar</strong></button>
                </div>
                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default btn-outline btn-block btn-rounded " onclick="onClickLimpiar(this)" disabled><strong>Limpiar</strong></button>
                    </div>
                    <div class="col-md-6">
                        <button type="button" class="btn btn-default btn-outline btn-block btn-rounded " onclick="onClickNuevo(this)" ><strong>Nuevo</strong></button>
                    </div>
                </div>

            </div>
        </div>
        <!--Listar PRODUCTO-->
        <div class="col-lg-9">
            <div class="box-default">
                <div class="table-responsive">
                    <br />
                    <table id="dvProducto" class="table table-hover"></table>
                </div>
            </div>
        </div>
        <!--INSERT PRODUCTO-->
        <div class="modal fade" id="divProductoIModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="divContentProductoI">
                            <div>
                                <form action="{{url('/guardarProducto')}}" method="post"> 
                                @csrf
                                    <div class="form-group">                                    
                                        <label>Nombre:</label>
                                        <input type="text" class="form-control" name="pro_str_nombre">
                                    </div>                                  
                                    <div class="form-group"> 
                                        <label>Precio Venta:</label>
                                        <input type="text" class="form-control" name="pro_dbl_precio_venta">
                                    </div>
                                    <div class="form-group">
                                        <label>Costo Produccion:</label>
                                        <input type="text" class="form-control" name="pro_dbl_costo_produccion"  >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button data-dismiss="modal" type="button" class="btn btn-primary">Cerrar</button>
                                </form>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--UPDATE PRODUCTO-->
        <div class="modal fade" id="divProductoUModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="divContentProductoU">
                            <div>   
                                <form action="{{url('/editarProducto')}}" method="post"> 
                                @csrf
                                    <input  class="form-control" name="pro_int_id" id="Upro_int_id" hidden>
                                    <div class="form-group">                                    
                                        <label>Nombre:</label>
                                        <input type="text" class="form-control" name="pro_str_nombre" id="pro_str_nombre">
                                    </div>                                  
                                    <div class="form-group"> 
                                        <label>Precio Venta:</label>
                                        <input type="text" class="form-control" name="pro_dbl_precio_venta" id="pro_dbl_precio_venta">
                                    </div>
                                    <div class="form-group">
                                        <label>Costo Produccion:</label>
                                        <input type="text" class="form-control" name="pro_dbl_costo_produccion" id="pro_dbl_costo_produccion" >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </form>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Listar PRODUCTO Detalle-->
        <div class="modal fade" id="divProductoDetalleModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="divContentProductoDetalle">    
                                <row>                                   
                                    <br />
                                    <div id="divProductoDetalle"></div>
                                    <!--<table id="dvProductoDetalle"  class="table table-striped table-hover responsive"></table>-->
                                </row>
                                <row>    
                                    <button onClick="onNuevoDetalle(this)" type="button"  class="btn btn-primary">Nuevo</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                </row>                
                        </div>  
                    </div>
                </div>
            </div>
        </div>        
            <!--INSERT DETALLE_PRODUCTO-->
            <div class="modal fade" id="divProductoDetalleIModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="divContentProductoIDetalle">
                            <div>
                                <form action="{{url('/guardarProductoDetalle')}}" method="post"> 
                                    @csrf
                                    <input class="form-control" name="pro_int_id" id="pro_id" hidden>
                                    <input class="form-control" name="invi_int_id" id="invi_int_id" hidden>
                                    <div class="form-group autocomplete">                                    
                                        <label for="prod_str_nombre" >Nombre:</label>
                                        <input class="form-control" name="prod_str_nombre" id="prod_str_nombre" autocomplete="off">
                                    </div>                                  
                                    <div class="form-group"> 
                                        <label>Unidad Medida:</label>
                                        <select class="custom-select my-1 mr-sm-2" name="prod_int_tipo_medida_salida">
                                            <option selected>Seleccione...</option>
                                            <option value="1">Unidad</option>
                                            <option value="2">Kilos</option>        
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Cantidad:</label>
                                        <input type="text" class="form-control" name="prod_dbl_cantidad_item"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Costo Produccion:</label>
                                        <input type="text" class="form-control" name="prod_dbl_costo_produccion_item"  >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>                             
                                </form>
                            </div>  
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
    <script>
        var _ITEMS_PRODUCTO;
        var _PRODUCTO = 0;
        $(document).ready(function() {
 
            $("#dvProducto").DataTable({

                responsive: true,
                retrieve: true,
                processing: false,
                serverSide: false,
                paging: true,
                searching: false,
                                    ajax: {
                                        url: "BandejaProducto",
                                        type: 'get',
                                    },
                                    columns: [
                                        {
                                            "title": "#", "mData": null, "bSortable": false, className: "text-center",
                                            "mRender": function (row) {
                                                return `<a class="btn btn-primary btn-rounded btn-outline btn-sm"><b onclick="fnOnClickModal(this)" >Editar</b></a>`;
                                                //return `<a href="${Ruta}?Id=${row.id}&editAction=2" class="btn btn-primary btn-rounded btn-outline btn-sm"><b>Editar</b></a>`;
                                            }
                                        },
                                        { title: "Descripcion", data: "pro_str_nombre", name: "pro_str_nombre", "autoWidth": true },
                                        { title: "Precio Venta", data: "pro_dbl_precio_venta", name: "pro_dbl_precio_venta", "autoWidth": true , "className": "text-right"},
                                        { title: "Costro Produccion", data: "pro_dbl_costo_produccion", name: "pro_dbl_costo_produccion", "autoWidth": true, "className": "text-right" },
                                        { title: "Usuario Creacion", data: "pro_str_usuario_creacion", name: "pro_str_usuario_creacion", "autoWidth": true },
                                        {
                                            "title": "#", "mData": null, "bSortable": false, className: "text-center",
                                            "mRender": function (row) {
                                                return `<a class="btn btn-primary btn-rounded btn-outline btn-sm"><b onclick="fnOnClickModalDetalle(this)" >Agregar</b></a>`;
                                                //return `<a href="${Ruta}?Id=${row.id}&editAction=2" class="btn btn-primary btn-rounded btn-outline btn-sm"><b>Editar</b></a>`;
                                            }
                                        },
                                    ], select: true,
                autoWidth: false,
                lengthChange: true,
                lengthMenu: [11, 20, 30, 100]
              });
              
            $('#divProductoIModal').on('shown.bs.modal', function () {
            });

            $('#divProductoIModal').on('hidden.bs.modal', function (e) {
                //$("#divContentProductoI").empty();
            });

            $('#divProductoUModal').on('shown.bs.modal', function () {
            });

            $('#divProductoUModal').on('hidden.bs.modal', function (e) {
               // $("#divContentProductoU").empty();
            });
            
            $('#divProductoDetalleModal').on('shown.bs.modal', function () {
                CrearTablaManual();      
            });

            $('#divProductoDetalleModal').on('hidden.bs.modal', function (e) {
               // $("#divContentProductoDetalle").empty();
            });

            $('#divProductoDetalleIModal').on('shown.bs.modal', function () {
                //var table = $('#dvProductoDetalle').DataTable();
                //table.ajax.reload();     
            });

            $('#divProductoDetalleIModal').on('hidden.bs.modal', function (e) {
                //$("#divProductoDetalleIModal").empty();
            });         
            

        });

        function onClickNuevo (e){
            $('#divProductoIModal').modal("show");        
        }

        function onSalir (e){ 
            //$('#divProductoIModal').modal('hide');
            //$('#divProductoUModal').modal('hide');
            //$('#divProductoDetalleModal').modal('hide');      
            //$('#divProductoDetalleIModal').modal('hide');   
            //table.fnDestroy();
           // $('#dvProductoDetalle').DataTable().Destroy();
            alert(_PRODUCTO);   
            var table = $('#dvProductoDetalle').DataTable();
            table.destroy();
            $("#divContentProductoDetalle").empty();
            $('#divProductoDetalleModal').modal('hide');   
        }


        function fnOnClickModal(e){
            debugger
            var table = $('#dvProducto').DataTable(); 
            $('#dvProducto tbody').on( 'click', 'tr', function () {
            var rowData = table.row( this ).data();
                $("#Upro_int_id").val(rowData.pro_int_id);
                $("#pro_str_nombre").val(rowData.pro_str_nombre);
                $("#pro_dbl_precio_venta").val(rowData.pro_dbl_precio_venta);
                $("#pro_dbl_costo_produccion").val(rowData.pro_dbl_costo_produccion);
            } );         
            $('#divProductoUModal').modal("show");
        }
        
        function fnOnClickModalDetalle(e){         
            var table = $('#dvProducto').DataTable(); 
            $('#dvProducto tbody').on( 'click', 'tr', function () {
                var rowData = table.row( this ).data();
                _PRODUCTO = rowData.pro_int_id;     
            } );
            $("#divProductoDetalle").empty();      
            $('#divProductoDetalleModal').modal("show");         
        }

        function onNuevoDetalle(e){
            $('#divProductoDetalleModal').modal('hide');     
            $("#pro_id").val(_PRODUCTO);  
            debugger     
            var postData = {
                            "text" :  $("#prod_str_nombre").val(),
                            "_token" : "{{ csrf_token() }}",
                        }; 
            const Productositems = []; 
            $.ajax( {
                        url: "listarItems",
                        type: 'POST',
                        data: postData,
                        success: function( data ) {
                            _ITEMS_PRODUCTO = data.data;
                            $.map(data.data, function (value, key) {
                                const count = Productositems.push(value.invi_str_nombre);    
                            });
                        }
                    } 
                );    
         
     
            autocomplete(document.getElementById("prod_str_nombre"), Productositems);

                //$("#au_prod_nombre").autocomplete({
                //    source: function( request, response ) {
                  
                   // },
                   // minLength: 2,
                  //  select: function( event, ui ) 
                 //       {
                         //   $("#au_prod_nombre").val(ui.label );
                         //   $("#invi_int_id").val(ui.value );
                 //       }
                //    } 
               // );          
            
            $('#divProductoDetalleIModal').modal("show");
           // $( "#au_prod_nombre" ).autocomplete( "option", "appendTo", ".eventInsForm" );
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
                const favoriteBooks = _ITEMS_PRODUCTO.filter((b) => { return b.invi_str_nombre ==  $("#prod_str_nombre").val()});
                $("#invi_int_id").val(favoriteBooks[0].invi_int_id);                 
                $("#prod_str_nombre").attr("readonly", true);
        }
   
        function detalleProducto(){
            debugger
            $("#dvProductoDetalle").DataTable({
                responsive: true,
                retrieve: true,
                processing: false,
                serverSide: false,
                paging: true,
                searching: false,
                                    ajax: {
                                        url: "listarProductoDetalle/"+_PRODUCTO,
                                        type: 'get',  
                                    },
                                    columns: [

                                        { title: "Descripcion", data: "prod_str_nombre", name: "prod_str_nombre", "autoWidth": true },
                                        { title: "Unidad Medida - Salida", data: "prod_int_tipo_medida_salida", name: "prod_int_tipo_medida_salida", "autoWidth": true , "className": "text-right"},
                                        { title: "Cantidad", data: "prod_dbl_cantidad_item", name: "prod_dbl_cantidad_item", "autoWidth": true, "className": "text-right" },
                                        { title: "Costo Produccion", data: "prod_dbl_costo_produccion_item", name: "prod_dbl_costo_produccion_item", "autoWidth": true },

                                    ], 
                select: true,
                autoWidth: true,
                lengthChange: true,
                lengthMenu: [11, 20, 30, 100]
            });  

        }

        function CrearTablaManual(){
            let text = '';
            $.get("listarProductoDetalle/"+_PRODUCTO,{},function(data){
                console.log(data);
                    let cant = 1;
                    text += '<table class="table table-striped table-hover responsive">';
                    text += '   <thead>';
                    text += '   <tr>';
                    text += '       <th>#</th>';
                    text += '       <th>Descripcion</th>';
                    text += '       <th>Unidad Medida - Salida</th>';
                    text += '       <th>Cantidad</th>';
                    text += '       <th>Costo Produccion</th>'; 
                    text += '   </tr>';
                    text += '   </thead>';
                    text += '   <tbody>';
                    for(var i = 0; i< data.data.length; i++){
                        text += '   <tr>';
                        text += '       <td>'+cant+'</td>';
                        text += '       <td>'+data.data[i]['prod_str_nombre']+'</td>';                      
                        text += '       <td>'+data.data[i]['prod_int_tipo_medida_salida']+'</td>';  
                        text += '       <td>'+data.data[i]['prod_dbl_cantidad_item']+'</td>';  
                        text += '       <td>'+data.data[i]['prod_dbl_costo_produccion_item']+'</td>';  
                        text += '   </tr>';
                        cant++;
                    }      
                    text += '   </tbody>';
                    text += '   </table>';

                    $("#divProductoDetalle").append(text);
            },'json')
        }


   </script>
 @stop

