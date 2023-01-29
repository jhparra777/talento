@extends("admin.layout.master")
@section("contenedor")
<div class="col-md-8 col-md-offset-2">
    {!! Form::model($registro,["id"=>"fr_ciudad","route"=>"admin.ciudad.actualizar","method"=>"POST"]) !!}
    {!! Form::hidden("id") !!}

    <h3>Editar Ciudad</h3>
    <div class="clearfix"></div>
    @if(Session::has("mensaje_success"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_success")}}
        </div>
    </div>
    @endif

    <div class="row">

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
            <div class="col-sm-10">
                {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"nombre" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre",$errors) !!}</p>    
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Cod ciudad:</label>
            <div class="col-sm-10">
                {!! Form::text("cod_ciudad",null,["class"=>"form-control selectpicker","placeholder"=>"cod_ciudad" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_ciudad",$errors) !!}</p>    
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Pais:</label>
            <div class="col-sm-10">
                {!! Form::select("cod_pais",$paises,null,["class"=>"form-control selectpicker", "id"=>"cod_pais", "data-live-search" => "true"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_pais",$errors) !!}</p>    
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Departamento:</label>
            <div class="col-sm-10">
                {!! Form::select("cod_departamento",$departamento,null,["class"=>"form-control selectpicker", "id"=>"cod_departamento", "data-live-search" => "true" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cod_departamento",$errors) !!}</p>    
        </div>

        @if( isset($agencias) )
            <div id="select-agencia" class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Agencia:</label>
                        
                <div class="col-sm-10">
                    {!! Form::select('agencia', $agencias, null, ['id'=>'agencia','class'=>'form-control selectpicker', "required"=>"required"]) !!}
                </div>
            </div>
        @endif

        @if( isset($sitio->integracion_contratacion) && $sitio->integracion_contratacion == 1 )
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Código Homologación:</label>
                <div class="col-sm-10">
                    {!! Form::text("homologa_id",null,["class"=>"form-control","placeholder"=>"Código","required"=>"required"]); !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("homologa_id",$errors) !!}</p>    
            </div>
        @endif

    </div>

    <div class="clearfix" ></div>
    
    {!! FuncionesGlobales::valida_boton_req("admin.ciudad.actualizar","Actualizar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>

<script>
    $(function(){

        $("#cod_pais").change(function(){
            var pais=$("#cod_pais").val();
            
            if (pais == '170') {
                $("#select-agencia").show();
            }else{
                $("#select-agencia").hide();
            }

            buscarDepartamentos(pais)
        });

        function buscarDepartamentos(pais)
        {
            $.ajax({
                url: "{{ route('cv.selctDptos') }}",
                type: 'POST',
                data: {
                    id:pais
                },
                success: function(response){
                    var data = response.dptos;

                    $('#cod_departamento').empty();
                    $('#cod_ciudad').empty();
                    $('#cod_departamento').append("<option value=''>Seleccionar</option>");
                    $('#cod_ciudad').append("<option value=''>Seleccionar</option>");

                    $.each(data, function(key, element) {
                        $('#cod_departamento').append("<option value='" + element.cod_departamento + "'>" + element.nombre + "</option>");
                    });

                    $('.selectpicker').selectpicker('refresh');
                }
            });
        }
    })
</script>
@stop