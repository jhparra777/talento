@extends("admin.layout.master")
@section("contenedor")
    
     {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => " Nuevo centro de costos","more_info"=>"<b>Cliente</b> $negocio->nombre_cliente | <b>Negocio </b>: $negocio->num_negocio"])

    {!! Form::open(["id"=>"frm_datos_empesa","route"=>"admin.guardar_centro_costo","method"=>"POST","data-smk-icon"=>"glyphicon-remove-sign"]) !!}

        {!! Form::hidden('cliente_id',$negocio->cliente_id) !!}
        {!! Form::hidden('negocio_id',$negocio->id) !!}

        <div class="clearfix"></div>
        
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{Session::get("mensaje_success")}}
                </div>
            </div>
        @endif

        <div class="col-md-12">

            
            
            {{--<div class="row">
                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-3  control-label">Clientes:</label>
                    <div class="col-sm-9 ">
                        {!! Form::select("cliente_id",$cliente,null,["class" => "form-control", "id" => "selectCliente", "required" => "required"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cliente_id",$errors) !!}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 form-group">
                    <label for="inputEmail3" class="col-sm-3  control-label">Negocio:</label>
                    <div class="col-sm-9 ">
                        <select name="negocio_id" id="selectNegocio" class="form-control" required="required">
                            <option value="">Seleccionar</option>
                        </select>
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cliente_id",$errors) !!}</p>
                </div>
            </div>
            --}}

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="page-header">
                                <h4 class="tri-fw-600">
                                    INFORMACIÓN DEL CENTRO DE COSTOS
                                </h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class=" form-group">
                                <label for="inputEmail3" class="control-label">Código del centro de costos:</label>
                                
                                    {!! Form::number("codigo_centro",null,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "required" => "required"]); !!}
                               
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("num_negocio",$errors) !!}</p>
                            </div>
                        </div>

                        <div class="col-md-8 col-md-offset-2">
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label">Nombre del centro de costos:</label>
                                
                                    {!! Form::text("desc_negocio",null,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "required" => "required"]); !!}
                                
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("num_negocio",$errors) !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

        </div>

        <div class="clearfix"></div>

        {{-- {!! FuncionesGlobales::valida_boton_req("admin.guardar_centro_costo","Guardar","submit","btn btn-success") !!} --}}

        <div class="col-sm-12 text-center">
            <button id="guardar-centro" class='btn btn-success | tri-br-2 tri-txt-green tri-bg-white tri-bd-green tri-transition-200 tri-hover-out-green' type='button'>Guardar</button>
        </div>
        
        <div class="col-md-12">
            <a href="#" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200 pull-right" onclick="window.history.back()">Volver Listado</a>
        </div>

    {!! Form::close() !!}

    <script>

        $(function () {

           $('#guardar-centro').on('click', function(){

                if ($('#frm_datos_empesa').smkValidate()) {
                    
                    $("#frm_datos_empesa").submit();
                }

           });

        });
</script>
@stop