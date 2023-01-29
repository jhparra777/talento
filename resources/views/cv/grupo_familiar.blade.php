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
                <h1>Grupo Familiar</h1>
                
                <div class="blind line_1"></div>
                <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
                <div class="blind line_2"></div>
            </div>

            <div id="grupo_container">
                {!! Form::open(["class" => "form-horizontal form-datos-basicos" ,"role" => "form", "id" => "fr_grupo"]) !!}
                    {!! Form::hidden("id", null, ["class" => "id_modificar_familiar", "id" => "id_modificar_familiar"]) !!}
                
                    <div class="row">
                        <h3 class="header-section-form">
                            <span class='text-danger sm-text'>Recuerde que los campos marcados con el símbolo (*) son obligatorios.</span>
                        </h3>

                        <div class="col-md-12">
                            <p class="text-primary set-general-font-bold">
                                Por favor ingrese los datos de las personas que componen su núcleo familiar y luego haga clic en Guardar.
                            </p>

                            <p class="direction-botones-left">
                                <a href="#grilla-datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp;Mis Familiares</a>
                            </p>
                        </div>

                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" ||
                            route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "https://gpc.t3rsc.co")
                        @else
                            <div class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="tipo_documento" class="col-md-4 control-label">
                                        Tipo documento:
                                        @if(route('home') != "https://listos.t3rsc.co" &&route('home') != "https://vym.t3rsc.co")
                                            <span class='text-danger sm-text-label'>*</span>
                                        @endif
                                    </label>
                                
                                    <div class="col-md-6">
                                        {!! Form::select("tipo_documento", $selectores->tipoDocumento, null, ["class"=>"form-control","id"=>"tipo_documento"])!!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="documento_identidad" class="col-md-4 control-label">
                                        # Documento: <span class='text-danger sm-text-label'>*</span>
                                    </label>

                                    <div class="col-md-6">
                                        {!! Form::text("documento_identidad",null,["class"=>"form-control solo_numeros","id"=>"documento_identidad"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="nombres" class="col-md-4 control-label">
                                    Nombres
                                    @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co")
                                        /Name
                                    @endif : <span class='text-danger sm-text-label'>*</span>
                                </label>
                                
                                <div class="col-md-6">
                                    {!! Form::text("nombres",null,["class"=>"form-control","placeholder"=>"Nombres","id"=>"nombres"]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="ref_apellido1" class="col-md-4 control-label">
                                    Primer apellido
                                    @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /First Surname @endif :
                                    <span class='text-danger sm-text-label'>*</span>
                                </label>

                                <div class="col-md-6">
                                    {!! Form::text("primer_apellido",null,["class"=>"form-control","placeholder"=>"Primer Apellido","id"=>"primer_apellido" ]) !!}
                                </div>
                            </div>
                        </div>

                        @if(route('home') != "https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="ref_apellido2" class="col-md-4 control-label">
                                       @if(route("home") == "https://gpc.t3rsc.co") Apellidos @else Segundo apellido @endif @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Second Surname @endif : @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif
                                    </label>

                                    <div class="col-md-6">
                                     {!! Form::text("segundo_apellido",null,["class"=>"form-control","placeholder"=>"Segundo Apellido","id"=>"segundo_apellido" ]) !!}
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-6 col-lg-12">
                              <div class="form-group">
                                <label for="ref_apellido2" class="col-md-4 control-label"> Ocupacion: <span>*</span> </label>

                                <div class="col-md-6">
                                 {!! Form::text("ocupacion",null,["class"=>"form-control","placeholder"=>"ocupacion","id"=>"ocupacion" ]) !!}
                                </div>
                              </div>
                            </div>
                        @endif

                        @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" && route('home') != "http://nases.t3rsc.co" && route('home') != "https://nases.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")

                            <div id="nivel_estudio" class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="escolaridad" class="col-md-4 control-label">
                                        Nivel estudio
                                        @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Study Level @endif :
                                        <span class='text-danger sm-text-label'>*</span>
                                    </label>
                                    <div class="col-md-6">
                                        {!! Form::select("escolaridad_id",$selectores->escolaridad,null,["class"=>"form-control","id"=>"escolaridad_id"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-sm-6 col-lg-12">
                            <div class="form-group">
                                <label for="parentesco" class="col-md-4 control-label">
                                    Parentesco
                                    @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Relationship @endif:
                                    <span class='text-danger sm-text-label'>*</span>
                                </label>
                        
                                <div class="col-md-6">
                                    {!!Form::select("parentesco_id",$selectores->parentesco,null,["class"=>"form-control","id"=>"parentesco_id"]) !!}
                                </div>
                            </div>
                        </div>

                        @if(route('home') != "http://nases.t3rsc.co" && route('home') != "https://nases.t3rsc.co" &&
                            route('home') != "https://gpc.t3rsc.co")
                            <div class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="genero" class="col-md-4 control-label">
                                        Género
                                        @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Gender @endif :
                                        <span class='text-danger sm-text-label'>*</span>
                                    </label>
                            
                                    <div class="col-md-6">
                                        {!! Form::select("genero",$selectores->genero,null,["class"=>"form-control","id"=>"genero"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co")
                            @if(route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" ||
                                route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                                <div id="rangoedad" class="col-sm-6 col-lg-12">
                                    <div class="form-group">
                                        <label for="escolaridad" class="col-md-4 control-label">
                                            Rango edad: @if(route('home') == "https://gpc.t3rsc.co") <span>*</span> @endif
                                        </label>

                                        <div class="col-md-6">
                                            {!! Form::select("rango_edad",['' => 'Seleccionar','0-5'=>"0-5",'6-10'=>"6-10",'11-15'=>"11-15",'16-20'=>"16-20",'21-25'=>"21-25",'26-30'=>"26-30",'31-35'=>"31-35",'36-40'=>"36-40",'41-45'=>"41-45",'45-50'=>"45-50",'50-mas'=>"50-mas"],null,["class"=>"form-control","id"=>"rango_edad"])!!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(route('home') != "http://nases.t3rsc.co" && route('home') != "https://nases.t3rsc.co" &&
                                route('home') != "https://gpc.t3rsc.co")
                                <div id="fecha_nac" class="col-sm-6 col-lg-12">
                                    <div class="form-group">
                                        <label for="fecha_nacimiento" class="col-md-4 control-label">
                                            Fecha nacimiento
                                            @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Birth Date @endif : 
                                            @if(route('home') != "https://listos.t3rsc.co" && route('home') != "https://vym.t3rsc.co") <span class='text-danger sm-text-label'>*</span> @endif
                                        </label>
                                        
                                        <div class="col-md-6">
                                            {!! Form::text("fecha_nacimiento",null,["class"=>"form-control" ,"id"=>"fecha_nacimiento", "placeholder"=>"Fecha Nacimiento","id"=>"fecha_nacimiento" ]) !!}
                                        </div>
                                    </div>
                                </div>

                                <div id="ciudad_nac" class="col-sm-6 col-lg-12">
                                    <div class="form-group">
                                        <label for="ciudad_nacimiento" class="col-md-4 control-label">
                                            Ciudad Nacimiento
                                            @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Birth City @endif :
                                            <span class='text-danger sm-text-label'>*</span>
                                        </label>

                                        <span style="color:red;display: none;" id="error_ciudad2">Debe seleccionar de la lista</span>

                                        <div class="col-md-6">
                                          {!! Form::hidden("codigo_pais_nacimiento",null,["class"=>"form-control","id"=>"codigo_pais_nacimiento"]) !!}
                                          {!! Form::hidden("codigo_ciudad_nacimiento",null,["class"=>"form-control","id"=>"codigo_ciudad_nacimiento"]) !!}
                                          {!! Form::hidden("codigo_departamento_nacimiento",null,["class"=>"form-control","id"=>"codigo_departamento_nacimiento"]) !!}

                                          {!! Form::text("ciudad_autocomplete2",null,["class"=>"form-control","id"=>"ciudad_autocomplete2","placeholder"=>"Ciudad Nacimiento"]) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(route('home') != "http://nases.t3rsc.co" && route('home') != "https://nases.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                                <div class="col-sm-6 col-lg-12">
                                    <div class="form-group">
                                     <label for="profesion" class="col-md-4 control-label">
                                      Profesión @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co") /Profession @endif :
                                         <span class='text-danger sm-text-label'>*</span>
                                        </label>
                                
                                        <div class="col-md-6">
                                         {!! Form::text("profesion_id",null,["class"=>"form-control", "placeholder"=>"Profesión","id"=>"profesion_id"]) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co")
                                <div class="col-sm-6 col-lg-12">
                                    <div class="form-group">
                                      <label for="celular_contacto" class="col-md-4 control-label"> Celular / Teléfono  <span class='text-danger sm-text-label'>*</span>
                                      </label>

                                        <div class="col-md-6">
                                         {!! Form::number("celular_contacto",null,["class"=>"form-control","id"=>"celular_contacto", "placeholder"=>"Celular de contacto"]) !!}
                                        </div>
                                    </div>
                                </div>    

                                <div class="col-sm-6 col-lg-12">
                                  <div class="form-group">
                                     <label for="profesion" class="col-md-4 control-label">¿ Conviven ? <span class='text-danger sm-text-label'>*</span> </label>
                                 
                                    <div class="col-md-6">
                                     {!!Form::select("convive",[""=>"Seleccionar","1"=>"Si","0"=>"No"],null,["class"=>"form-control","id"=>"convive"]) !!}
                                    </div>
                                  </div>
                                </div>
                            @endif
                        @else
                            <div id="rangoedad" class="col-sm-6 col-lg-12">
                                <div class="form-group">
                                    <label for="escolaridad" class="col-md-4 control-label">
                                        Rango edad: @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co") <span>*</span> @endif
                                    </label>

                                    <div class="col-md-6">
                                     {!! Form::select("rango_edad",['0-5'=>"0-5",'6-10'=>"6-10",'11-15'=>"11-15",'16-20'=>"16-20",'21-25'=>"21-25",'26-30'=>"26-30",'31-35'=>"31-35",'36-40'=>"36-40",'41-45'=>"41-45",'45-50'=>"45-50",'50-mas'=>"50-mas"],null,["class"=>"form-control","id"=>"rango_edad"]) !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-12 separador"></div>

                    <p class="direction-botones-center set-margin-top">
                        <button class="btn btn-warning pull-right" id="cancelar_familiar" style="display:none; margin: auto 10px auto;" type="button">
                            <i class="fa fa-pen"></i>Cancelar
                        </button>
              
                        <button class="btn btn-success pull-right" id="actualizar_familiar" style="display:none; margin: auto 10px auto;" type="button">
                            <i class="fa fa-floppy-o"></i>Actualizar
                        </button>
              
                        <button class="btn-quote" type="button" id="guardar_familiar">
                         <i class="fa fa-floppy-o"></i>&nbsp;Guardar
                        </button>
                    </p>
                {!! Form::close() !!}
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div id="mensaje-error" class="alert alert-danger danger" role="alert" style="display: none;">
                        <strong id="error"></strong>
                    </div>
               
                    <div class="grid-container table-responsive">
                        <table class="table table-striped" id="tbl_familia">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>
                                        Nombres @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")/Name @endif
                                    </th>

                                    <th>
                                        Apellidos @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")/Surname @endif
                                    </th>

                                    @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" ||
                                        route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" ||
                                        route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "https://gpc.t3rsc.co" ||
                                        route('home') == "http://localhost:8000")
                                    @else
                                        <th># Identidad</th>
                                  
                                        <th>
                                         Género @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Gender @endif
                                        </th>
                                  
                                        <th>
                                         Fecha nacimiento @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Birth Date @endif
                                        </th>
                                    
                                        <th>
                                          Escolaridad @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Study @endif
                                        </th>
                                    @endif

                                    @if(route('home') == "https://gpc.t3rsc.co")
                                      <th> Parentesco </th>
                                    @endif

                                    @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                                        <th>
                                         Ciudad nacimiento
                                         @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Birth City @endif
                                        </th>
                                    @endif
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @if($familiares->count() == 0)
                                    <tr id="no_registros">
                                        <td colspan="8">No registros</td>
                                    </tr>
                                @endif

                                @foreach($familiares as $familiar)
                                    <tr id="tr_{{$familiar->id}}">
                                        <td scope="row"></td>

                                        <td>{{$familiar->nombres}}</td>

                                        <td>{{$familiar->primer_apellido." ".$familiar->segundo_apellido}}</td>

                                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" ||
                                            route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" ||
                                            route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "https://gpc.t3rsc.co" ||
                                            route('home') == "http://localhost:8000")
                                        @else
                                            <td>{{$familiar->documento_identidad}}</td>
                                            <td>{{$familiar->genero}}</td>
                                            <td>{{$familiar->fecha_nacimiento}}</td>
                                            <td>{{$familiar->escolaridad}}</td>
                                        @endif

                                        @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" &&
                                            route('home') != "https://gpc.t3rsc.co")
                                            <td>
                                                @if(!empty($familiar->getLugarNacimiento()))
                                                    {{$familiar->getLugarNacimiento()->ciudad}}
                                                @endif
                                            </td>
                                        @endif

                                        @if(route('home') == "https://gpc.t3rsc.co")
                                         <td> {{$familiar->parentesco}} </td>
                                        @endif

                                        <td>
                                            {!! Form::hidden("id",$familiar->id, ["id"=>$familiar->id]) !!}

                                            <button class="btn btn-success cargar_documentos" type="button" data-target="#cargar_documento_grupo_familiar" data-toggle="modal">
                                                <i class="fa fa-file"></i>
                                                <!-- cargar documentos -->
                                            </button>
                                            
                                            <button class="btn btn-primary btn-peq editar_familiar disabled_experiencia" type="button">
                                                <i class="fa fa-pen"></i>
                                                <!--Editar-->
                                            </button>

                                            <button class="btn btn-danger btn-peq eliminar_familiar disabled_experiencia" type="button">
                                                <i class="fa fa-trash"></i>
                                                <!--Eliminar-->
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
        <!-- Modal para mostrar cargar documentos-->
        <div class="modal fade" id="modal-cargar-documento">
            <div class="modal-dialog modal-lg" style="width: 900px">
                <div class="modal-content"></div>
            </div>
        </div>
    </div>
    
    <script>
        $(function () {

            //Modal Cargar Documentos
            $('#tbl_familia').delegate( '.cargar_documentos', 'click', function () {

                    let grupo_familiar = $(this).parent().find("input").val();

                    $.ajax({
                        type: "GET",
                        url: "{{ route('cargar_documento_grupo_familiar') }}",
                        data: {grupo_familiar_id: grupo_familiar},
                        success: function (response) {
                            $("#modal-cargar-documento").find(".modal-content").html(response);
                            $("#modal-cargar-documento").modal("show");
                        }
                    });
                });

            /* auto complete profesion */
            $('#cargo_desempenado_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cargo_desempenado") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#profesion_id").val(suggestion.id);
                }
            });

            /* fin auto complete profesion */
            $(document).on("click", "input[name=id]", function () {
                $("#tbl_familia tbody tr").removeClass("oferta_aplicada");
                
                if($(this).prop("checked")) {
                    $(this).parents("tr").addClass("oferta_aplicada");
                }
            });

            $("#fecha_nacimiento").datepicker(confDatepicker);
        
            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });

            $('#ciudad_autocomplete2').keypress(function(){
                $(this).css("border-color","red");
                $("#error_ciudad2").show();
                $("#select_expedicion_id").val("no");            
            });

            $('#ciudad_autocomplete2').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#error_ciudad2").hide();
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#codigo_pais_nacimiento").val(suggestion.cod_pais);
                    $("#codigo_ciudad_nacimiento").val(suggestion.cod_ciudad);
                    $("#codigo_departamento_nacimiento").val(suggestion.cod_departamento);
                }
            });

            /** Guardar Grupo familiar **/
            $(document).on("click","#guardar_familiar", function (e) {
                    // e.preventDefault();
                $.ajax({
                    type: "POST",
                    data: $("#fr_grupo").serialize(),
                    url: "{{route('guardar_familia')}}",
                    success: function (response) {
                        $("#mensaje-error").hide();
                      
                        $(document).ready(function(){
                            swal("Nuevo grupo familiar guardado", " ¿Desea agregar otro familiar?", "info", {
                                buttons: {
                                    cancelar: { text: "Agregar Nuevo Familiar",className:'btn btn-success' },
                                    agregar: { text: "Siguiente Sección",className:'btn btn-warning' },
                                },
                            }).then((value) => {
                                switch (value) {
                                    case "cancelar":
                                        // swal("Ok","Datos Guardados!!","warning");
                                        //$('#btn-aprobar').removeAttr('disabled');
                                        //CODIGO DE NO AGREGADO O LO QUE QUIERAS HACER
                                    break;

                                    case "agregar":
                                        window.location.href = '{{route('documentos').'#fr_documento'}}';
                                        //AQUI CODIGO DONDE AGREGAS
                                    break;
                                }
                            });

                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});
                            $("textarea").css({"border": "1px solid #ccc"});
                            $(".text").remove();

                        var campos = response.registro;
                        var ciudad = response.lugarNacimiento;
                    
                        var tr = $("<tr id='tr_" + campos.id + "'></tr>");
                        tr.append($("<td></td>", {text: ""}));
                        tr.append($("<td></td>", {text: campos.nombres}));
                        tr.append($("<td></td>", {text: campos.primer_apellido + " "}));

                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co" || route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co" || route('home') == "https://gpc.t3rsc.co" || route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://localhost:8000")
                         console.log();
                        @else
                          tr.append($("<td></td>", {text: campos.documento_identidad}));
                          tr.append($("<td></td>", {text: campos.genero}));
                          tr.append($("<td></td>", {text: campos.fecha_nacimiento}));
                          tr.append($("<td></td>", {text: campos.escolaridad}));
                        @endif

                        @if(route('home') != "http://tiempos.t3rsc.co" && route('home') != "https://tiempos.t3rsc.co" && route('home') != "https://gpc.t3rsc.co")
                          tr.append($("<td></td>", {text: ciudad.ciudad}));
                        @endif

                        @if(route('home') == "https://gpc.t3rsc.co")
                          tr.append($("<td></td>", {text: campos.parentesco}));
                        @endif

                        tr.append($("<td></td>", {html: `
                            <button class="btn btn-success cargar_documentos" type="button" data-target="#cargar_documento_grupo_familiar" data-toggle="modal">
                                <i class="fa fa-file"></i>
                                <!-- cargar documentos -->
                            </button>
                            <input type="hidden" name="id" value="${campos.id}">
                            <button type="button" class="btn btn-primary btn-peq editar_familiar disabled_familiar">
                                <i class="fa fa-pen"></i>
                                </button>
                            <button type="button" class="btn btn-danger btn-peq eliminar_familiar disabled_familiar">
                                <i class="fa fa-trash"></i>
                            </button>`}));

                        $("#tbl_familia tbody").append(tr);
                        $("#no_registros").remove();
                        //Busca todos los input y lo pone a su color original
                        //mensje_success("Se guardaron sus datos satisfactoriamente.");
                        //Limpiar campos del formulario
                        // location.reload();
                        $("#fr_grupo")[0].reset();

                      });

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

            /* Eliminar */
            $(document).on("click",".eliminar_familiar", function() {
                var objButton = $(this);

                id = objButton.parent().find("input").val();
                
                if(id){
                    if(confirm("Desea eliminar este registro?")){

                    $(".disabled_familiar").prop("disabled", true);
                        $.ajax({
                            type: "POST",
                            data: {"id":id},
                            url: "{{route('eliminar_familiar')}}",
                            success: function (response) {
                             $("#tr_" + response.id).remove();
                             $(".disabled_familiar").prop("disabled", false);
                             mensaje_success("Registro eliminado.");
                            }
                        });
                    }
                }else{
                  mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                }
            });
        
            //Comprobar edad de hijos
            @if(route('home') == "http://demo.t3rsc.co" || route('home') == "https://demo.t3rsc.co" )
                $(document).on("change","#parentesco_id", function() {
                 parentesco = $(this).val();
                  if(parentesco === '2') {
                    //console.log('hijo')
                     edad();
                  }
                });

                $(document).on("change","#fecha_nacimiento", function() {
                    parentesco = $("#parentesco_id").val();
                    if(parentesco === '2') {
                        //console.log('hijo')
                        edad();
                    }
                });

                function edad(){
                    fecha = $('#fecha_nacimiento').val();
                    if(fecha){
                        $.ajax({
                            type: "POST",
                            data: {"fecha":fecha},
                            url: "{{route('edad_hijos')}}",
                            success: function (response) {
                                if(response.mensaje == 'success'){
                                    console.log('edad valida');
                                }else{
                                    alert(response.mensaje);
                                    $('#fecha_nacimiento').val('');
                                }
                            },
                            error: function (response){
                                console.log('error');
                            }
                        });
                    }
                }
            @endif

            /** Editar familiar **/
            $(document).on("click",".editar_familiar", function() {
                //Mostar Botones Cancelar Guardar.
                document.getElementById('cancelar_familiar').style.display = 'block';
                document.getElementById('actualizar_familiar').style.display = 'block';
                
                //Ocultar Boton Guardar
                document.getElementById('guardar_familiar').style.display = 'none';
                
                //Desactivar botones Editar + Eliminar
                $(".disabled_familiar").prop("disabled", true);

                var objButton = $(this);
                id = objButton.parent().find("input").val();
                
                if(id){
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{route('editar_familiar')}}",
                        success: function (response) {
                            $("#nombres").val(response.data.nombres);
                            $("#fecha_nacimiento").val(response.data.fecha_nacimiento);
                            $("#profesion_id").val(response.data.profesion_id);
                            $("#ciudad_autocomplete2").val(response.data.ciudad_autocomplete2);
                            $("#primer_apellido").val(response.data.primer_apellido);
                            $("#segundo_apellido").val(response.data.telefono_fijo);
                            $("#segundo_apellido").val(response.data.segundo_apellido);
                            $("#escolaridad_id").val(response.data.escolaridad_id);
                            @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co")
                                $("#tipo_documento").val(response.data.tipo_documento);
                                $("#documento_identidad").val(response.data.documento_identidad);
                            @endif
                            $("#parentesco_id").val(response.data.parentesco_id);
                            $("#codigo_pais_nacimiento").val(response.data.codigo_pais_nacimiento);
                            $("#codigo_ciudad_nacimiento").val(response.data.codigo_ciudad_nacimiento);
                            $("#codigo_departamento_nacimiento").val(response.data.codigo_departamento_nacimiento);
                            $("#genero").val(response.data.genero);
                            @if (route('home') == "http://nases.t3rsc.co" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://localhost:8000")
                                $("#celular_contacto").val(response.data.celular_contacto);
                                $("#convive").val(response.data.convive);
                            @endif
                            $(".id_modificar_familiar").val(response.data.id);
                        }
                    });
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                }
            });

            /** Actualizar **/
            $(document).on("click","#actualizar_familiar", function() {
                var objButton = $(this);
                id = objButton.parents("form").find(".id_modificar_familiar").val();
                if (id) {
                    $.ajax({
                        type: "POST",
                        data: $("#fr_grupo").serialize(),
                        url: "{{route('actualizar_familiar')}}",
                        success: function (response) {
                            $("#fr_grupo")[0].reset();
                            $(".disabled_familiar").prop("disabled", false);
                            
                            mensaje_success("Registro actualizado.");

                            var campos = response.registro;
                            var ciudad = response.lugarNacimiento;

                            $("#tr_" + campos.id).html(tr);
                            var tr = $("#tr_" + campos.id + "").find("td");
                   
                            //tr.eq(0).html(($("<input />", {name: "id", value: campos.id, type: "radio"})));
                            tr.eq(1).html(campos.nombres);
                            tr.eq(2).html(campos.primer_apellido + " " + campos.segundo_apellido);
                            
                            @if(route('home') != "http://colpatria.t3rsc.co" && route('home') != "https://colpatria.t3rsc.co")
                                tr.eq(3).html(campos.documento_identidad);
                            @endif

                            tr.eq(4).html(campos.genero);
                            tr.eq(5).html(campos.fecha_nacimiento);
                            tr.eq(6).html(ciudad.ciudad);
                            tr.eq(7).html(campos.escolaridad);

                            tr.eq(8).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_familiar disabled_familiar"><i class="fa fa-pen"></i></button> <button type="button" class="btn btn-danger btn-peq eliminar_familiar disabled_referencia"><i class="fa fa-trash"></i></button>'}));

                            $("#mensaje-error").hide();
                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});

                            //Ocultar Botones Cancelar Guardar.
                            document.getElementById('cancelar_familiar').style.display = 'none';
                            document.getElementById('actualizar_familiar').style.display = 'none';

                            //MOstrar Boton Guardar
                            document.getElementById('guardar_familiar').style.display = 'block';
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
                    });
                }else{
                    mensaje_danger("No se borro el registro, favor intentar nuevamente.");
                    $(".disabled_referencia").prop("disabled", false);
                }
            });
     
            /*  
                $(document).on("click", "#eliminar_familiar", function () {
                    if (seleccionarLista() && confirm("Desea eliminar este registro?")) {
                        $.ajax({
                            type: "POST",
                            data: $("#grilla-datos").serialize(),
                            url: "",
                            success: function (response) {
                                $("#tr_" + response.id).remove();
                                alert("El registro familiar se ha eliminado.");
                            }
                        });
                    }
                });
                  
            */
  
            $("#cancelar_familiar").on("click", function () {
                //Ocultar Botones Cancelar Guardar.
                document.getElementById('cancelar_familiar').style.display = 'none';
                document.getElementById('actualizar_familiar').style.display = 'none';
                
                //Mostrar Boton Guardar
                document.getElementById('guardar_familiar').style.display = 'block';
                
                //Activar botones Editar + Eliminar
                $(".disabled_familiar").prop("disabled", false);

                var objButton = $(this);
                id = objButton.parents("form").find("input").val();
                
                if (id) {
                    $("#fr_grupo")[0].reset();
                }else{
                  mensaje_danger("No se encontro el registro, favor intentar nuevamente.");
                }
            });
        });
</script>
@stop
