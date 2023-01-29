@extends("cv.layouts.master")
<?php
    $porcentaje=FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
                                            //$porcentaje=$porcentaje["total"];
?>
@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    <div class="col-right-item-container">
        <div class="container-fluid">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
                <h1>Referencias @if(route('home') == "https://gpc.t3rsc.co") Laborales @else Personal @endif </h1>
                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div id="container_referencia">
                {!! Form::open(["class"=>"form-horizontal form-datos-basicos" ,"role"=>"form","id"=>"fr_referencias_personales"]) !!}
                    {!! Form::hidden("id",null,["class"=>"id_modificar_referencia", "id"=>"id_modificar_referencia"]) !!}

                    <div class="row">
                        <h3 class="header-section-form">
                            <span class='text-danger sm-text'>Recuerde que los campos marcados con el símbolo (*) son obligatorios.</span>
                        </h3>
                        
                        <div class="col-md-12">
                            @if (route('home') == 'https://gpc.t3rsc.co' || route('home') == 'http://localhost:8000')
                                <p class="text-primary set-general-font-bold">
                                    Por favor, ingrese los datos de las personas que se contactarán para el proceso de referenciación laboral y coloque sus últimas 2 a 3 experiencias laborales. Y luego dale clic en guardar.
                                </p>
                            @else
                                <p class="text-primary set-general-font-bold">
                                    Por favor ingrese los datos de las personas que se contactarán para el proceso de referenciación laboral y luego haga clic en Guardar.
                                </p>
                            @endif
                            
                            <p class="direction-botones-left">
                                <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Referencias</a>
                            </p>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="ref_nombres" class="col-md-4 control-label">Nombres:<span class='text-danger sm-text-label'>*</span> </label>
                                
                                <div class="col-md-6">
                                    {!! Form::text("nombres",null,["id"=>"nombres", "class"=>"form-control","placeholder"=>"Nombres"]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="ref_apellido1" class="col-md-4 control-label">
                                    @if(route('home') == "https://gpc.t3rsc.co") Apellidos @else Primer apellido @endif :<span class='text-danger sm-text-label'>*</span>
                                </label>
                                
                                <div class="col-md-6">
                                    {!! Form::text("primer_apellido",null,["id"=>"primer_apellido","class"=>"form-control" , "placeholder"=>"Primer apellido" ]) !!}
                                </div>
                            </div>
                        </div>

                        @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="ref_apellido2" class="col-md-4 control-label">Empresa:<span class='text-danger sm-text-label'>*</span> </label>
                                    
                                    <div class="col-md-6">
                                        {!!Form::text("empresa", null, ["id" => "empresa", "class" => "form-control", "placeholder" => " "])!!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="ref_apellido2" class="col-md-4 control-label">Segundo apellido:<span class='text-danger sm-text-label'></span> </label>
                                    
                                    <div class="col-md-6">
                                        {!! Form::text("segundo_apellido",null,["id"=>"segundo_apellido","class"=>"form-control" ,"placeholder"=>"Segundo apellido"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="tipo_relacion" class="col-md-4 control-label">
                                    Tipo relación @if(route('home') == "https://gpc.t3rsc.co") Laboral @endif : <span class='text-danger sm-text-label'>*</span>
                                </label>
                                
                                <div class="col-md-6">
                                    {!! Form::select("tipo_relacion_id",$tipoRelaciones, null, ["id"=>"tipo_relacion_id","class"=>"form-control"]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                             <label for="telefono_movil" class="col-md-4 control-label">Teléfono móvil:<span class='text-danger sm-text-label'>*</span> </label>   
                                <div class="col-md-6">
                                 {!! Form::text("telefono_movil",null,["id"=>"telefono_movil","class"=>"form-control solo-numero" , "placeholder"=>"Teléfono móvil" ]) !!}
                                </div>                                
                            </div>
                        </div>

                            <div class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                 <label for="telefono_fijo" class="col-md-4 control-label">Teléfono fijo:<span class='text-danger sm-text-label'></span> </label>
                                    <div class="col-md-6">
                                    {!! Form::text("telefono_fijo",null,["class"=>"form-control solo-numero", "placeholder"=>"Teléfono fijo","id"=>"telefono_fijo" ]) !!}
                                    </div>
                                </div>
                            </div>

                          @if(route('home') == "https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-12">
                              <div class="form-group">
                               <label for="correo" class="col-md-4 control-label"> Correo electrónico: <span class='text-danger sm-text-label'></span> </label>
                                <div class="col-md-6">
                                {!! Form::email("correo", null, ["class" => "form-control", "placeholder" => "Correo", "id" => "correo" ]) !!}
                                </div>
                              </div>
                            </div>
                        @endif
                
                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="ref_ciudad" class="col-md-4 control-label">Ciudad:<span class='text-danger sm-text-label'>*</span> </label>
                                <span style="color:red;display: none;" id="error_ciudad">Debe seleccionar de la lista</span>
                   
                                <div class="col-md-6">
                                    {!! Form::hidden("codigo_pais",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                                    {!! Form::hidden("codigo_ciudad",null,["id"=>"ciudad_id","class"=>"form-control"]) !!}
                                    {!! Form::hidden("codigo_departamento",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                                
                                    {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="ocupacion" class="col-md-4 control-label">
                                    @if(route('home') == "https://gpc.t3rsc.co") Cargo de la persona @else Ocupación @endif : <span class='text-danger sm-text-label'>*</span>
                                </label>
                                
                                <div class="col-md-6">
                                    @if(route('home') == "https://gpc.t3rsc.co")
                                        {!! Form::text("cargo",null,["class"=>"form-control", "placeholder"=>"Cargo","id"=>"cargo"])!!}
                                    @else
                                        {!! Form::select("ocupacion",["" => "Seleccionar", "desempleado"=>"Desempleado", "empleado" => "Empleado", "estudiante"=>"Estudiante", "independiente" => "Independiente"],null,["id"=>"ocupacion","class"=>"form-control" ]) !!}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 separador"></div>
                    
                    <p class="direction-botones-center set-margin-top">
                        <button class="btn btn-warning pull-right" id="cancelar_referencia" style="display:none; margin: auto 10px auto;" type="button">
                            <i class="fa fa-pen"></i>
                            Cancelar
                        </button>
                        
                        <button class="btn btn-success pull-right" id="actualizar_referencia" style="display:none; margin: auto 10px auto;" type="button">
                            <i class="fa fa-floppy-o"></i>
                            Actualizar
                        </button>
                        <button class="btn-quote" type="button" id="guardar_referencia" ><i class="fa fa-floppy-o"></i>&nbsp;Guardar</button>
                    </p>
                {!!  Form::close() !!}
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="mensaje-error" class="alert alert-danger danger" role="alert" style="display: none;">
                        <strong id="error"></strong>
                    </div>

                    {!! Form::open(["id"=>"grilla-datos"]) !!}               
                        <div class="grid-container table-responsive">
                            <table class="table table-striped" id="table_referencias">
                                <thead>
                                    <tr>
                                        <th>Nombres</th>
                                        <th>Apellidos</th>
                                        <th>Teléfono móvil</th>
                                        <th>Teléfono fijo</th>
                                        <th>Tipo relación</th>
                                        <th>Ciudad</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($referencias->count() == 0)
                                        <tr id="registro_nulo">
                                            <td colspan="7">No  hay registros</td>
                                        </tr>
                                    @endif
                                    
                                    @foreach($referencias as $referencia)
                                      <tr id="tr_{{$referencia->id}}">
                                       <td>{{$referencia->nombres}}</td>
                                       <td>{{ $referencia->primer_apellido." ".$referencia->segundo_apellido }}</td>
                                       <td>{{$referencia->telefono_movil}}</td>
                                       <td>{{$referencia->telefono_fijo}}</td>
                                       <td>{{$referencia->relacion}}</td>
                                       <td>{{$referencia->ciudad_seleccionada}}</td>
                                       <td>
                                        {!! Form::hidden("id",$referencia->id, ["id"=>$referencia->id]) !!}
                                        <button class="btn btn-primary btn-peq editar_referencia disabled_experiencia" type="button">
                                        <i class="fa fa-pen"></i>
                                        <!--Editar-->
                                        </button>        
                                        <button class="btn btn-danger btn-peq eliminar_referencia disabled_experiencia" type="button">
                                         <i class="fa fa-trash"></i>           <!--Eliminar-->
                                        </button>
                                       </td>
                                      </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $(function () {
            $(document).on("click", "input[name=id]", function () {
                $("#table_referencias tbody tr").removeClass("oferta_aplicada");
                if ($(this).prop("checked")) {
                    $(this).parents("tr").addClass("oferta_aplicada");
                }
            });

            $('#ciudad_autocomplete').keypress(function(){
                $(this).css("border-color","red");
                $("#error_ciudad").show();
                //$("#select_expedicion_id").val("no");            
            });

            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#error_ciudad").hide();
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });
            /**
                *  Guardar referencia personal
            **/
            $(document).on("click","#guardar_referencia", function () {
                $.ajax({
                    type: "POST",
                    data: $("#fr_referencias_personales").serialize(),
                    url: "{{route('guardar_referencia')}}",
                    success: function (data) {
                        $("#mensaje-error").hide();
                        $(document).ready(function(){
                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});
                            $("textarea").css({"border": "1px solid #ccc"});
                            $(".text").remove();
                        });

                        var mensaje = data.mensaje_success 
                        var campos = data.referencia;
                        var relacion = data.relacionTipo;
                        var ciudad = data.ciudad;

                        var tr = $("<tr id='tr_" + campos.id + "'></tr>");
                        tr.append($("<td></td>", {text: campos.nombres}));
                        tr.append($("<td></td>", {text: campos.primer_apellido + " "}));
                        tr.append($("<td></td>", {text: campos.telefono_movil}));
                        tr.append($("<td></td>", {text: campos.telefono_fijo}));
                        tr.append($("<td></td>", {text: relacion.descripcion}));
                        tr.append($("<td></td>", {text: ciudad.ciudad_seleccionada}));

                        tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_referencia disabled_referencia"><i class="fa fa-pen"></i></button> <button type="button" class="btn btn-danger btn-peq eliminar_referencia disabled_referencia"><i class="fa fa-trash"></i></button>'}));
                        
                        $("#table_referencias tbody").append(tr);
                        $("#registro_nulo").remove();
                       
                        //Busca todos los input y lo pone a su color original
                        swal("Referencia Agregada", "\t\t @if(route('home') == 'https://gpc.t3rsc.co') *Recuerda llenar por lo menos 3 referencias laborales de tu trabajo actual y tres referencias de tus dos empresas anteriores. \n @endif ¿Desea agregar un nuevo registro?", "info", {
                            buttons: {
                              cancelar: { text: "Agregar Nueva Referencia",className:'btn btn-success' },
                              agregar:  { text: "Siguiente Sección",className:'btn btn-warning' },
                            },
                        }).then((value) => {
                            switch (value) {
                                case "cancelar":
                                    // swal("Ok","Datos Guardados!!","warning");
                                    //$('#btn-aprobar').removeAttr('disabled');
                                    //CODIGO DE NO AGREGADO O LO QUE QUIERAS HACER
                                break;
                                case "agregar":
                                  window.location.href = '{{route('grupo_familiar').'#fr_grupo'}}';
                                    //AQUI CODIGO DONDE AGREGAS
                                break;
                            }
                        });
                        //mensaje_success("Se guardaron sus datos satisfactoriamente.");
                        //Limpiar campos del formulario
                        $("#fr_referencias_personales")[0].reset();
                    },
                    error:function(data){
                        $(document).ready(function(){
                          $("input").css({"border": "1px solid #ccc"});
                          $("select").css({"border": "1px solid #ccc"});
                          $("textarea").css({"border": "1px solid #ccc"});
                          $(".text").remove();
                        });

                        $.each(data.responseJSON.errors, function(index, val){
                           $('input[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                           $('textarea[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                           $('select[name='+index+']').after('<span class="text">'+val[0]+'</span>'); 
                           document.getElementById(index).style.border = 'solid red';
                        });
                        
                        $("#error").html("Upps, creo que olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");
                        $("#mensaje-error").fadeIn();
                    }
                })
            });
            
            /**
                * Eliminar Referencia
            **/
            $(document).on("click",".eliminar_referencia", function() {
                var objButton = $(this);
                id = objButton.parent().find("input").val();
                
                if (id) {
                    if (confirm("Desea eliminar este registro?")){
                        $(".disabled_referencia").prop("disabled", true);
                        $.ajax({
                            type: "POST",
                            data: {"id":id},
                            url: "{{route('eliminar_referencia_hv')}}",
                            success: function (response) {
                              $("#tr_" + response.id).remove();
                              $(".disabled_referencia").prop("disabled", false);
                             mensaje_success("Registro eliminado.");
                            }
                        });
                    }
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                }
            });
            /**
                *  Editar Referencia
            **/
            $(document).on("click",".editar_referencia", function() {
                //Mostar Botones Cancelar Guardar.
                document.getElementById('cancelar_referencia').style.display = 'block';
                document.getElementById('actualizar_referencia').style.display = 'block';
                
                //Ocultar Boton Guardar
                document.getElementById('guardar_referencia').style.display = 'none';
                
                //Desactivar botones Editar + Eliminar
                $(".disabled_referencia").prop("disabled", true);

                var objButton = $(this);
                id = objButton.parent().find("input").val();
                
                if(id){
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{route('editar_referencia')}}",
                        success: function (response) {
                            $("#nombres").val(response.data.nombres);
                            $("#primer_apellido").val(response.data.primer_apellido);
                            $("#telefono_movil").val(response.data.telefono_movil);
                            $("#telefono_fijo").val(response.data.telefono_fijo);
                            $("#segundo_apellido").val(response.data.segundo_apellido);
                            $("#tipo_relacion_id").val(response.data.tipo_relacion_id);
                            $("#telefono_movil").val(response.data.telefono_movil);
                            $("#telefono_fijo").val(response.data.telefono_fijo);
                            $("#codigo_pais").val(response.data.codigo_pais);
                            $("#codigo_ciudad").val(response.data.codigo_ciudad);
                            $("#codigo_departamento").val(response.data.codigo_departamento);
                            $("#ocupacion").val(response.data.ocupacion);
                            $(".id_modificar_referencia").val(response.data.id);

                            //Ciudad-Residencia
                            $("#ciudad_autocomplete").val(response.ciudad);
                            $("#pais_id").val(response.data.codigo_pais);
                            $("#departamento_id").val(response.data.codigo_departamento);
                            $("#ciudad_id").val(response.data.codigo_ciudad);

                        }
                    });
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                }
            });

            $("#cancelar_referencia").on("click", function () {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_referencia').style.display = 'none';
                document.getElementById('actualizar_referencia').style.display = 'none';
                
                //MOstrar Boton Guardar
                document.getElementById('guardar_referencia').style.display = 'block';
                
                //Activar botones Editar + Eliminar
                $(".disabled_referencia").prop("disabled", false);

                var objButton = $(this);
                id = objButton.parents("form").find("input").val();
                
                if (id) {
                    $("#fr_referencias_personales")[0].reset();
                }else{
                    mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
                }
            });
            
            /**
                * Actualizar Referencia
            **/
            $(document).on("click","#actualizar_referencia", function() {
                var objButton = $(this);
                id = objButton.parents("form").find(".id_modificar_referencia").val();
                
                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_referencias_personales").serialize(),
                        url: "{{route('actualizar_referencia')}}",
                        success: function (response) {
                            $("#fr_referencias_personales")[0].reset();
                            $(".disabled_referencia").prop("disabled", false);
                            mensaje_success("Registro actualizado.");

                            var campos = response.referencia;
                            var relacion = response.relacionTipo;
                            var ciudad = response.ciudad;

                            $("#tr_" + campos.id).html(tr);

                            var tr = $("#tr_" + campos.id + "").find("td");

                            tr.eq(1).html(campos.nombres);
                            tr.eq(2).html(campos.primer_apellido + " " + campos.segundo_apellido);
                            tr.eq(3).html(campos.telefono_movil);
                            tr.eq(4).html(campos.telefono_fijo);
                            tr.eq(5).html(relacion.descripcion);

                            tr.eq(7).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_referencia disabled_referencia"><i class="fa fa-pen"></i></button> <button type="button" class="btn btn-danger btn-peq eliminar_referencia disabled_referencia"><i class="fa fa-trash"></i></button>'}));

                            $("#mensaje-error").hide();
                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});
                            location.reload();

                            //Ocultar Botones Cancelar Guardar.
                            document.getElementById('cancelar_referencia').style.display = 'none';
                            document.getElementById('actualizar_referencia').style.display = 'none';
                            //MOstrar Boton Guardar
                            document.getElementById('guardar_referencia').style.display = 'block';
                        },
                        error:function(data)
                        { 
                            $(document).ready(function(){
                                $("input").css({"border": "1px solid #ccc"});
                                $("select").css({"border": "1px solid #ccc"});
                                $("textarea").css({"border": "1px solid #ccc"});
                                $(".text").remove();
                            });

                            $.each(data.responseJSON.errors, function(index, val){
                                $('input[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                                $('textarea[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                                $('select[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                                document.getElementById(index).style.border = 'solid red';
                            });

                            $("#error").html("Upps, creo que olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");
                            $("#mensaje-error").fadeIn();
                        }
                    });
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                    $(".disabled_referencia").prop("disabled", false);
                }
            });
        });
    </script>
@stop