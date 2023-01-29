@extends("cv.layouts.master")
<?php
    $porcentaje=FuncionesGlobales::porcentaje_hv(Sentinel::getUser()->id);
                                            //$porcentaje=$porcentaje["total"];
?>
@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    @if (route('home') == 'https://gpc.t3rsc.co' || route('home') == 'http://localhost:8000')
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css" rel="stylesheet" />
        <style>
            select {font-family: 'FontAwesome', 'sans-serif';}
        </style>
    @endif

    <div class="col-right-item-container">
        <div class="container-fluid">
            <div class="col-md-12 all-categorie-list-title bt_heading_3">
                <h1>
                    Añadir idiomas
                    @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")
                        (Opcional)
                    @endif
                </h1>
                @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")
                    <span>NOTA: Si tu cargo es directivo, mandos medios o comercial, te sugerimos completar la información</span>
                @endif
                <br>
                
                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="submit_listing_box">
                    <h3 class="header-section-form"> 
                        <span class='text-danger sm-text'> Idiomas </span>
                    </h3>
          
                    <p class="text-primary set-general-font-bold"> </p>

                    <div class="form-alt">
                        <div class="row">
                            <p class="direction-botones-left">
                                <a href="#grilla_datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Idiomas </a>
                            </p>

                            {!! Form::open(["id"=>"fr_idioma", "role"=>"form"]) !!}
                                {!! Form::hidden("id",null,["class"=>"e_idioma_id", "id"=>"e_idioma_id"]) !!}
                      
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label>Idioma:  <span>*</span></label>
                   
                                    {!! Form::hidden("id_idioma",null,["class"=>"form-control","id"=>"id_idioma"]) !!}
                                    {!! Form::text("idioma",null,["class"=>"form-control","placeholder"=>"Digite Idioma","id"=>"idioma_autocomplete"])!!}
                                </div>

                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                  <label>Nivel idioma: <span>*</span></label>
                                  {!! Form::select("nivel", $niveles, null, ["class"=>"form-control","id"=>"nivel_idioma"]) !!}
                                </div>

                                @if(route("home") == "https://gpc.t3rsc.co")
                                    <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                        <label> Lugar de formación: </label>
                                        {!!Form::text("lugar_formacion",null,["class"=>"form-control","id"=>"lugar_formacion"]) !!}
                                    </div>
                                @endif

                                <p class="direction-botones set-margin-top">
                                    <button class="btn btn-warning pull-right" id="cancelar_idioma" style="display:none; margin: auto 10px auto;" type="button">
                                     <i class="fa fa-pen"> </i> Cancelar
                                    </button>
                     
                                    <button class="btn btn-success pull-right" id="actualizar_idioma" style="display:none; margin: auto 10px auto;" type="button">
                                      <i class="fa fa-floppy-o"> </i> Actualizar
                                    </button>
                    
                                    <button class="btn btn-success pull-right" id="guardar_idioma" type="button">
                                      <i class="fa fa-floppy-o"> </i> Guardar
                                    </button>
                                </p>
                            {!! Form::close() !!}
                        </div>
                    </div>
           
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <div id="mensaje-error" class="alert alert-danger danger" role="alert" style="display: none;">
                                <strong id="error"></strong>
                            </div>
                            
                            {!! Form::open(["id"=>"grilla_datos"]) !!}
                                <div class="grid-container table-responsive">
                                    <table class="table table-striped" id="tbl_estudios">
                                        <thead>
                                            <tr>
                                                <th>Idioma</th>
                                                <th>Nivel</th>
                                                @if(route("home") == "https://gpc.t3rsc.co")
                                                    <th>Lugar formación</th>
                                                @endif
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($idiomas->count() == 0)
                                                <tr id="registro_nulo">
                                                    <td colspan="6">No  hay registros</td>
                                                </tr>
                                            @else
                                                @foreach($idiomas as $idioma)
                                                    <tr id="tr_{{$idioma->id}}">
                                                        <td>@if($idioma->nombre_idioma) {{ $idioma->nombre_idioma->descripcion}} @endif </td>
                                                        <td>@if($idioma->nivel_idioma) {{$idioma->nivel_idioma->descripcion}} @endif </td>
                                                        @if(route("home") == "https://gpc.t3rsc.co")
                                                            <td>{{$idioma->lugar_formacion}}</td>
                                                        @endif
                                                        <td>
                                                            {!! Form::hidden("id",$idioma->id, ["id"=>$idioma->id]) !!}
                                                            <button class="btn btn-primary btn-peq editar_idiomas disabled_idiomas" data-id="{{$idioma->id}}" type="button">
                                                                <i class="fa fa-pen"></i>
                                                                <!--Editar-->
                                                            </button>
                                           
                                                            <button class="btn btn-danger btn-peq eliminar_idiomas disabled_estudios" data-id="{{$idioma->id}}" type="button">
                                                                <i class="fa fa-trash"></i>
                                                                <!--Eliminar-->
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>                                
                                    </table>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        @if (route('home') == 'https://gpc.t3rsc.co')
                            <a class="btn btn-warning pull-right" href="{{route('video_perfil')}}" type="button">&nbsp;Siguiente</a>
                        @else
                            <a class="btn btn-warning pull-right" href="{{route('grupo_familiar')}}" type="button">&nbsp;Siguiente</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#idioma_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocompletar_idiomas") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#id_idioma").val(suggestion.id);
                    $("#idioma_autocomplete").val(suggestion.value);
                }
            });

            /**
                * Guardar Idiomas
            **/
            $(document).on("click","#guardar_idioma", function () {
                $("#mensaje-error").hide();

                if($("#id_idioma").val().length > 0){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_idioma").serialize(),
                        url: "{{route('guardar_idioma')}}",
                        success: function (data) {
                            $("#mensaje-error").hide();

                            $(document).ready(function(){
                              $("input").css({"border": "1px solid #ccc"});
                              $("select").css({"border": "1px solid #ccc"});
                              $("textarea").css({"border": "1px solid #ccc"});
                              $(".text").remove();
                            });
                       
                            $("#registro_nulo").remove();
                        
                            //Busca todos los input y lo pone a su color original
                            //mensaje_success("Se guardaron sus datos satisfactoriamente.");
                            //Limpiar campos del formulario
                            swal("Idioma agregado", " ¿Desea agregar otro?", "info", {
                                buttons: {
                                    cancelar: { text: "Agregar Nuevo Idioma",className:'btn btn-success' },
                                    agregar: { text: "Siguiente Sección",className:'btn btn-warning' },
                                },
                            }).then((value) => {
                                switch (value) {
                                    case "cancelar":
                                     swal("Ok","Datos Guardados!!","warning");
                                     location.reload();
                                     //CODIGO DE NO AGREGADO O LO QUE QUIERAS HACER
                                    break;
                                    case "agregar":
                                     @if(route("home") != "https://gpc.t3rsc.co")
                                      window.location.href = '{{route('perfilamiento')}}';
                                     @else
                                      window.location.href = '{{ route('video_perfil') }}';
                                     @endif
                                        //AQUI CODIGO DONDE AGREGAS
                                    break;
                                }
                            });
                        },
                        error:function(data){ 
                            $.each(data.responseJSON.errors, function(index, val){
                              $('input[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                             $('select[name='+index+']').after('<span class="text">'+val[0]+'</span>');
                             document.getElementById(index).style.border = 'solid red';
                            });

                            $("#error").html("Upps, Olvidaste seleccionar el idioma de la lista desplegable.");
                            $("#mensaje-error").fadeIn();
                        }
                    });
                }else{
                    $(document).ready(function(){
                        $("#idioma_autocomplete").after('<span class="text"> Selecciona de la lista</span>');
                        $("#idioma_autocomplete").focus();
                        $("#idioma_autocomplete").css({"border": "1px solid #ccc"});

                        $("#nivel_idioma").after('<span class="text"> Selecciona de la lista</span>');
                        $("#nivel_idioma").focus();
                        $("#nivel_idioma").css({"border": "1px solid #ccc"});
                    });

                    document.getElementById('idioma_autocomplete').style.border = 'solid red';
                    document.getElementById('nivel_idioma').style.border = 'solid red';

                 $("#error").html("Upps, Olvidaste seleccionar el idioma de la lista desplegable.");
                 $("#mensaje-error").fadeIn();
                 return false;
                }
            });

            /**
                * Eliminar Estudio
            **/
            $(document).on("click",".eliminar_idiomas", function() {
                var objButton = $(this);
                id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('eliminar_idioma')}}",
                    success: function (response) {
                     objButton.parents('td').parents('tr').remove();
                     alert("Registro eliminado");
                    }
                });
            });
         
            $("#cancelar_idioma").on("click", function () {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_idioma').style.display = 'none';
                document.getElementById('actualizar_idioma').style.display = 'none';
                //MOstrar Boton Guardar
                document.getElementById('guardar_idioma').style.display = 'block';
                
                //Activar botones Editar + Eliminar
                $(".disabled_estudios").prop("disabled", false);

                var objButton = $(this);
                id = objButton.parents("form").find("input").val();
                if(id){
                 $("#fr_estudios")[0].reset();
                }else{
                 mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
                }
            });
       
            $(document).on("click",".editar_idiomas", function() {
                //Mostar Botones Cancelar Guardar.
                document.getElementById('cancelar_idioma').style.display = 'block';
                document.getElementById('actualizar_idioma').style.display = 'block';
                //Ocultar Boton Guardar
                document.getElementById('guardar_idioma').style.display = 'none';
                //Desactivar botones Editar + Eliminar
                $(".disabled_idioma").prop("disabled", true);

                var objButton = $(this);
                id = $(this).data('id');
                
                if(id){
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{route('editar_idioma')}}",
                        success: function (response) {
                            $("#id_idioma").val(response.datos.id_idioma);
                            $("#idioma_autocomplete").val(response.datos.nombre_idioma);
                            $("#nivel_idioma").val(response.datos.nivel);
                            
                            @if(route("home") == "https://gpc.t3rsc.co")
                             $("#lugar_formacion").val(response.datos.lugar_formacion);
                            @endif
                       
                            $("#e_idioma_id").val(response.datos.id);
                        }
                    });
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                }
            });

            $(document).on("click","#actualizar_idioma", function() {
                var objButton = $(this);
                id = objButton.parents("form").find("#e_idioma_id").val();

                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_idioma").serialize(),
                        url: "{{route('actualizar_idioma')}}",
                        success: function (response) {
                          mensaje_success("Registro actualizado.");
                           location.reload();
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
                              document.getElementById(index).style.border = 'solid red';
                            });

                            $("#error").html("Upps, creo que olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");
                            $("#mensaje-error").fadeIn();
                        }
                    });
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                    $(".disabled_estudios").prop("disabled", false);
                }
            });
        });
    </script>
@stop