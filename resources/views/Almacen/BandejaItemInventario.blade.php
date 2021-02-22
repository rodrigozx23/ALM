@extends('Home')

@section('Bandeja')
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="box-default">

                <br />
                <h2 style="margin: 10px 0 0 0; font-weight:600;">Almacen</h2>
                <br />

                <div id="searchPanel" style="padding: 0 10px 0 10px;">

                    <div class="row">
                        <div class="form-group">
                            <label>Nombre:</label>
                            <input type="text" class="form-control" name="invi_str_nombre" disabled >
                        </div>
                        <div class="form-group">
                            <label>Unidad Medida:</label>
                            <select class="custom-select my-1 mr-sm-2" name="itm_int_tipo_medida_entrada" disabled>
                                <option selected>Seleccione...</option>
                                <option value="1">Unidad</option>
                                <option value="2">Kilos</option>        
                            </select>
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

        <div class="col-lg-9">
            <div class="box-default">
                <div class="table-responsive">
                    <br />
                    <table id="dvItemInventario" class="table table-hover"></table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="divItemInventarioIModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="divContentItemIInventario">
                        <div>
                                <div id="alertboxInsert" class="alert alert-warning fade show d-none" role="alert">
                                        <strong id="MensajeErrorIns"></strong>
                                </div>
                                <form action="{{url('/guardarItem')}}" method="post"> 
                                @csrf
                                    <div class="row">
                                            <div class="col-md-12">                                    
                                                <label>Nombre:</label>
                                                <input type="text" class="form-control" name="invi_str_nombre" id="invi_str_nombre">
                                            </div>
                                    </div>
                                    <div class="row">
                                            <div class="col-md-12" >
                                                <label>Unidad Medida:</label>
                                                <select class="custom-select my-1 mr-sm-2" name="itm_int_tipo_medida_entrada" id="itm_int_tipo_medida_entrada" >
                                                    <option value="0" selected>Seleccione...</option>
                                                    <option value="4">Unidad</option>
                                                    <option value="3">Gramos</option>  
                                                    <option value="2">Kilos</option>         
                                                </select>
                                            </div>  
                                    </div>
                                    <div class="row">
                                            <div class="col-md-12"> 
                                                <label>Valor Entrante:</label>
                                                <input type="text" class="form-control" name="invi_dbl_cantidad" id="invi_dbl_cantidad">
                                            </div>   
                                    </div> 
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                        </div>                                                                             
                                        <div class="col-md-4">
                                            <button onClick="onSalir(this)"  type="button" class="btn btn-primary btn-block">Cerrar</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" onClick="return onInsertarItem(this)" class="btn btn-primary btn-block">Guardar</button>
                                        </div>
                                    </div>                                                                   
                                </form>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="divItemInventarioUModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="divContentItemUInventario">
                        <div>                                                           
                                <form action="{{url('/editarItem')}}" method="post"> 
                                @csrf
                                    <div class="row">
                                    <div class="col-md-12">    
                                        <div id="alertboxUpdate" class="alert alert-warning fade show d-none" role="alert">
                                            <strong id="MensajeErrorUpdate"></strong>
                                        </div>        
                                    </div>
                                    <input  class="form-control" name="invi_int_id" id="Uinvi_int_id" hidden>
                                        <div class="col-md-12">                                    
                                            <label>Nombre:</label>
                                            <input type="text" class="form-control" name="invi_str_nombre" id="Uinvi_str_nombre">
                                        </div>
                                        <div class="col-md-12" >
                                            <label>Unidad Medida:</label>
                                            <select class="custom-select my-1 mr-sm-2" name="itm_int_tipo_medida_entrada" id="Uitm_int_tipo_medida_entrada">
                                                <option value="0" selected>Seleccione...</option>
                                                <option value="4">Unidad</option>
                                                <option value="3">Gramos</option>  
                                                <option value="2">Kilos</option>        
                                            </select>
                                        </div>   
                                        <div class="col-md-12"> 
                                            <label>Valor Entrante:</label>
                                            <input type="text" class="form-control" name="invi_dbl_cantidad" id="Uinvi_dbl_cantidad">
                                        </div>                                   
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-md-4">
                                        </div>                                                                             
                                        <div class="col-md-4">
                                            <button onClick="onSalir(this)"  type="button" class="btn btn-primary btn-block">Cerrar</button>
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" onClick="return onActualizarItem(this)" class="btn btn-primary btn-block">Guardar</button>
                                        </div>
                                    </div>                                                                        
                                </form>
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
        $(document).ready(function() {
 
            $("#dvItemInventario").DataTable({
                responsive: true,
                processing: false,
                serverSide: false,
                paging: true,
                searching: false,
                                    ajax: {
                                        url: "BandejaAlmacen",
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
                                        { title: "Descripcion", data: "invi_str_nombre", name: "invi_str_nombre", "autoWidth": true },
                                        { title: "Unidad Medida", data: "mlt_str_descripcion", name: "mlt_str_descripcion", "autoWidth": true },
                                        { title: "Cantidad", data: "invi_dbl_cantidad_total_item", name: "invi_dbl_cantidad_total_item", "autoWidth": true , "className": "text-right"},
                                        { title: "Peso", data: "invi_dbl_peso_neto", name: "invi_dbl_peso_neto", "autoWidth": true, "className": "text-right" },
                                        { title: "UsuarioCreacion", data: "invi_str_usuario_creacion", name: "invi_str_usuario_creacion", "autoWidth": true },
                                    ], select: true,
                autoWidth: false,
                lengthChange: true,
                lengthMenu: [11, 20, 30, 100]
              });
              
            $('#divItemInventarioIModal').on('shown.bs.modal', function () {
                    
            });

            $('#divItemInventarioIModal').on('hidden.bs.modal', function (e) {
                var element = document.getElementById("alertboxInsert");        
                element.classList.add("d-none"); 
                $('#MensajeErrorIns').text("");
                $('#invi_str_nombre').val("");   
                $('#itm_int_tipo_medida_entrada').val(0);   
                $('#invi_dbl_cantidad').val("");  
            });

            $('#divItemInventarioUModal').on('shown.bs.modal', function () {
            });

            $('#divItemInventarioUModal').on('hidden.bs.modal', function (e) {
                var element = document.getElementById("alertboxUpdate");        
                element.classList.add("d-none"); 
                $('#MensajeErrorUpdate').text("");
            });
        });

        function onClickNuevo (e){
            $('#divItemInventarioIModal').modal("show");        
        }

        function onSalir (e){
            $('#divItemInventarioIModal').modal('hide');
            $('#divItemInventarioUModal').modal('hide');
        }

        function fnOnClickModal(e){
            debugger
            var table = $('#dvItemInventario').DataTable(); 
            $('#dvItemInventario tbody').on( 'click', 'tr', function () {
            var rowData = table.row( this ).data();
                $("#Uinvi_int_id").val(rowData.invi_int_id);
                $("#Uinvi_str_nombre").val(rowData.invi_str_nombre);
                console.log(rowData.invi_dbl_peso_neto);
                console.log(rowData.invi_dbl_cantidad_total_item);
                if(rowData.itm_int_tipo_medida_entrada == 2 || rowData.itm_int_tipo_medida_entrada == 3 ){       
               
                    $("#Uinvi_dbl_cantidad").val(rowData.invi_dbl_peso_neto);
                }else{
              
                    $("#Uinvi_dbl_cantidad").val(rowData.invi_dbl_cantidad_total_item);
                }
              
          
                
                $("#Uitm_int_tipo_medida_entrada").val(rowData.itm_int_tipo_medida_entrada);
            } );         
            $('#divItemInventarioUModal').modal("show");
        }

        function onActualizarItem(e){

            var element = document.getElementById("alertboxUpdate");        
            element.classList.add("d-none"); 
            $('#MensajeErrorUpdate').text("");

            var nombre = $('#Uinvi_str_nombre').val();
            if(nombre == null || nombre == ""){
                $('.alert').alert();
                element.classList.remove("d-none");
                $('#MensajeErrorUpdate').text("Debe ingresar una Descripcion.");
                return false;
            }

            var id_medida = $('#Uitm_int_tipo_medida_entrada').val();
            if(id_medida == 0){
                $('.alert').alert();
                element.classList.remove("d-none");
                $('#MensajeErrorUpdate').text("Debe seleccionar una Unidad Medida.");
                return false;
            }

            var cantidad = $('#Uinvi_dbl_cantidad').val();
            if(cantidad  == null || cantidad == "" || cantidad == 0){
                $('.alert').alert();
                element.classList.remove("d-none");
                $('#MensajeErrorUpdate').text("Debe ingresar una cantidad.");
                return false;
            } 
    
        }

        function onInsertarItem(e){
            var element = document.getElementById("alertboxInsert");        
            element.classList.add("d-none"); 
            $('#MensajeErrorIns').text("");

            var nombre = $('#invi_str_nombre').val();        
            if(nombre == null || nombre == ""){
                $('.alert').alert();
                element.classList.remove("d-none");
                $('#MensajeErrorIns').text("Debe ingresar una Descripcion.");
                return false;
            }

            var id_medida = $('#itm_int_tipo_medida_entrada').val();
            if(id_medida == 0){
                $('.alert').alert();
                element.classList.remove("d-none");
                $('#MensajeErrorIns').text("Debe seleccionar una Unidad Medida.");
                return false;
            }                 

            var cantidad = $('#invi_dbl_cantidad').val();
            if(cantidad  == null || cantidad == "" || cantidad == 0){
                $('.alert').alert();
                element.classList.remove("d-none");
                $('#MensajeErrorIns').text("Debe ingresar un Valor de Entrada.");
                return false;
            }     
        }
    </script>
@stop