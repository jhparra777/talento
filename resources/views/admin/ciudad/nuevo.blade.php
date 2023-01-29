@extends("admin.layout.master")
@section("contenedor")
<div class="box box-info" id="contratacion-directa">
    <div class="box-header with-border">
        <h3 class="box-title">
            Registrar Nueva Ciudad
        </h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="col-md-10 col-md-offset-1">
            {!! Form::open(["id"=>"fr_ciudad","route"=>"admin.ciudad.guardar","method"=>"POST"]) !!}
            <!-- -->
            @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">
                            ×
                        </span>
                    </button>
                    {{Session::get("mensaje_success")}}
                </div>
            </div>
            @endif
            <!-- -->
            <div class="row">
                <div class="col-md-6 form-group">
                    <label class="col-sm-4 control-label" for="inputEmail3">
                        Nombre Ciudad:
                    </label>
                    <div class="col-sm-8">
                        {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"Nombre","required"=>"required" ]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("nombre",$errors) !!}
                    </p>
                </div>

                @if( isset($sitio->integracion_contratacion) && $sitio->integracion_contratacion == 1 )
                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Código Homologación:</label>
                        <div class="col-sm-8">
                            {!! Form::text("homologa_id",null,["class"=>"form-control","placeholder"=>"Código","required"=>"required"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("homologa_id",$errors) !!}</p>    
                    </div>
                @endif

            </div>

            <div class="row">

                <div class="col-md-6 form-group">
                    <label class="col-sm-4 control-label" for="inputEmail3">
                        País:
                    </label>
                    <div class="col-sm-8">
                        {!! Form::select("cod_pais",$paises,null,["class"=>"form-control selectpicker", "id"=>"cod_pais","required"=>"required", "data-live-search" => "true" ]) !!}
                    </div>
                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("cod_pais",$errors) !!}
                    </p>
                </div>

                <div class="col-md-6 form-group">
                    <label class="col-sm-4 control-label" for="inputEmail3">
                        Departamento:
                    </label>
                    <div class="col-sm-8">
                        {!! Form::select("cod_departamento",null,null,["class"=>"form-control selectpicker", "id"=>"cod_departamento","required"=>"required", "data-live-search" => "true"]) !!}
                    </div>
                    <p class="error text-danger direction-botones-center">
                        {!! FuncionesGlobales::getErrorData("cod_departamento",$errors) !!}
                    </p>
                </div>
            </div>
            <div class="row">
                @if( isset($agencias) )
                    <div id="select-agencia" class="col-md-6 form-group" style="display: none;">
                        <label for="inputEmail3" class="col-sm-4 control-label">Agencia:</label>
                        
                        <div class="col-sm-8">
                         {!! Form::select('agencia', $agencias, null, ['id'=>'agencia','class'=>'form-control selectpicker', "required"=>"required"]) !!}
                        </div>
                    </div>
                @endif
            </div>

            {!! FuncionesGlobales::valida_boton_req("admin.ciudad.guardar","Guardar","submit","btn btn-success") !!}
            <a class="btn btn-warning" href="#" onclick="window.history.back()">
                Volver Listado
            </a>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    $(function(){

        @if( request('cod_pais') )
            buscarDepartamentos("{{request('cod_pais')}}")
        @endif

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
@endsection
