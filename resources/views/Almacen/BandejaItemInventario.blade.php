@extends('Layout')

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
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="divContentItemIInventario">
                        <div>
                                <form action="{{url('/guardarItem')}}" method="post"> 
                                @csrf
                                    <div class="form-group">                                    
                                        <label>Nombre:</label>
                                        <input type="text" class="form-control" name="invi_str_nombre">
                                    </div>
                                    <div class="form-group" >
                                        <label>Unidad Medida:</label>
                                        <select class="custom-select my-1 mr-sm-2" name="itm_int_tipo_medida_entrada" >
                                            <option selected>Seleccione...</option>
                                            <option value="1">Unidad</option>
                                            <option value="2">Kilos</option>        
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label>Cantidad:</label>
                                        <input type="text" class="form-control" name="invi_dbl_cantidad_total_item">
                                    </div>
                                    <div class="form-group">
                                        <label>Peso:</label>
                                        <input type="text" class="form-control" name="invi_dbl_peso_neto"  >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button onClick="onSalir(this)"  type="button" class="btn btn-primary">Cerrar</button>
                                </form>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="divItemInventarioUModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div id="divContentItemUInventario">
                        <div>
                                <form action="{{url('/editarItem')}}" method="post"> 
                                @csrf
                                    <input  class="form-control" name="invi_int_id" id="Uinvi_int_id" hidden>
                                    <div class="form-group">                                    
                                        <label>Nombre:</label>
                                        <input type="text" class="form-control" name="invi_str_nombre" id="Uinvi_str_nombre">
                                    </div>
                                    <div class="form-group" >
                                        <label>Unidad Medida:</label>
                                        <select class="custom-select my-1 mr-sm-2" name="itm_int_tipo_medida_entrada" id="Uitm_int_tipo_medida_entrada">
                                            <option selected>Seleccione...</option>
                                            <option value="1">Unidad</option>
                                            <option value="2">Kilos</option>        
                                        </select>
                                    </div>
                                    <div class="form-group"> 
                                        <label>Cantidad:</label>
                                        <input type="text" class="form-control" name="invi_dbl_cantidad_total_item" id="Uinvi_dbl_cantidad_total_item">
                                    </div>
                                    <div class="form-group">
                                        <label>Peso:</label>
                                        <input type="text" class="form-control" name="invi_dbl_peso_neto" id="Uinvi_dbl_peso_neto" >
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button onClick="onSalir(this)"  type="button" class="btn btn-primary">Cerrar</button>
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
                                        { title: "Unidad Medida", data: "itm_int_tipo_medida_entrada", name: "itm_int_tipo_medida_entrada", "autoWidth": true },
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
            });

            $('#divItemInventarioUModal').on('shown.bs.modal', function () {
            });

            $('#divItemInventarioUModal').on('hidden.bs.modal', function (e) {

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
                $("#Uinvi_dbl_cantidad_total_item").val(rowData.invi_dbl_cantidad_total_item);
                $("#Uinvi_dbl_peso_neto").val(rowData.invi_dbl_peso_neto);
                $("#Uitm_int_tipo_medida_entrada").val(rowData.itm_int_tipo_medida_entrada);
            } );         
            $('#divItemInventarioUModal').modal("show");
        }
        
    </script>
@stop