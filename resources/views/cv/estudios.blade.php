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
            <h1>Estudios Realizados @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Applied Studies @endif </h1>

            <div class="blind line_1"></div>
            <div class="flipInX-1 blind icon"><span class="icon"><i class="fa fa-stop"></i>&nbsp;&nbsp;<i class="fa fa-stop"></i></span></div>
            <div class="blind line_2"></div>
        </div>
        
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div id="submit_listing_box">
                <h3 class="header-section-form"> 
                    <span class='text-danger sm-text'> 
                        @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                            Por favor completar su información personal, los campos con asterisco(*) son obligatorios
                        @else
                            Recuerde que los campos marcados con el símbolo (*) son obligatorios.
                        @endif
                    </span>
                </h3>

                @if(route('home') == "https://gpc.t3rsc.co" || route('home') == "http://localhost:8000")
                    <ul style="text-align: justify; padding: 5%; padding-top: 2%; font-size: 1.4rem;">
                        <li>
                            Al ingresar su información utilice mayúsculas únicamente cuando sea necesario, es decir, en nombres propios y al inicio de cada oración.
                        </li>
                        <li>
                            En la redacción de la información sea concreto y objetivo.
                        </li>
                        <li>
                            Valide que su información no tenga errores ortográficos y que la redacción sea adecuada.
                        </li>
                        <li>
                            La información que completará debe ser confiable, estrictamente ajustada a la realidad en todos sus datos y situación personal. 
                        </li>
                        <li>
                            La trayectoria laboral y formación académica será verificada en las instituciones y con las empresas validando fechas, cargos y motivos de salida. 
                        </li>
                        <li>
                            Las referencias laborales se aplicarán en el avance final del proceso, por lo que deben constar los jefes directos, una muestra de colegas y colaboradores, sus nombres serán verificados con las empresas previamente.
                        </li>
                        <li>
                            Coloca N/A en los campos donde la información no aplique a tu caso, no dejes espacios en blanco.
                        </li>
                    </ul>
                @endif
        
                <p class="text-primary set-general-font-bold">
                    Por favor ingresa los datos de tus estudios, ingresa desde el más antiguo al más reciente.
                </p>

                <div class="form-alt">
                    <div class="row">
                        <p class="direction-botones-left">
                            <a href="#grilla_datos" class="btn btn-defecto btn-peq"><i class="fa fa-file-text"></i>&nbsp; {{(route('home') == "https://gpc.t3rsc.co")?'Formacion Academica':'Mis Estudios'}} </a>
                        </p>

                        <div id="container_estudios"> </div>
                        
                        {!! Form::open(["id"=>"fr_estudios", "role"=>"form", "files" => true]) !!}
                            {!!Form::hidden("id",null,["class"=>"id_modificar_estudios", "id"=>"id_modificar_estudios"])!!}
                            <div id="no_tengo" class="col-md-12 mb-4" style="margin-bottom: 15px;">
                                <label>
                                    {!! Form::checkbox("tiene_estudio",0,isset($datos_basicos->tiene_estudio) && $datos_basicos->tiene_estudio == "0" ? 1 : null,["class"=>"tiene_estudio","id"=>"tiene_estudio", "style" => "height:initial;"]) !!}
                                        No tengo estudios certificados</label>
                            </div>
                            @if(route('home') != "https://gpc.t3rsc.co")
                                <div class="form-group actual-c col-xs-6">
                                    <div class="form-group">
                                        <label for="trabajo-empresa-temporal" class="col-md-8  control-label">
                                            ¿Estudio actual?
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Applied Studies @endif
                                        </label>
                                        {!! Form::select("estudio_actual",["0" => "No", "1" => "Si"],null,["class"=>"form-control","id"=>"estudio_actual"]) !!}
                                    </div>
                                </div>
                            @endif

                            @if(route("home") == "https://gpc.t3rsc.co")
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label> Institución <span>* </span> </label>
                                    
                                    {!! Form::text("universidades_autocomplete",null,["class"=>"form-control","id"=>"universidades_autocomplete","placheholder"=>"Digita Institucion"])!!}
                                </div>
                            @else
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                    <label> Institución @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Institute @endif:
                                    <span>* </span> </label>
                                    {!! Form::text("institucion",null,["class"=>"form-control","placeholder"=>"Institución","id"=>"institucion"]) !!}
                                </div>
                            @endif
                      
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                                  <label> Nombre del estudio: <span>*</span></label>
                                @else
                                  <label> Titulo obtenido @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Applied Studies @endif : <span>*</span></label>
                                @endif

                                {!! Form::text("titulo_obtenido",null,["class"=>"form-control", "id"=>"titulo_obtenido" ,"placeholder"=>"Titulo Obtenido" ]) !!}
                            </div>
                      
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                <label> Ciudad estudio @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /City Study @endif : 
                                 <span> * </span>
                                 <span style="color:red;display: none;" id="error_ciudad">Debe seleccionar de la lista</span>
                                </label>

                                {!! Form::hidden("pais_estudio",null,["class"=>"form-control","id"=>"pais_estudio"]) !!}
                                {!! Form::hidden("ciudad_estudio",null,["class"=>"form-control","id"=>"ciudad_estudio"]) !!}
                                {!! Form::hidden("departamento_estudio",null,["class"=>"form-control","id"=>"departamento_estudio"]) !!}
                                
                                {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita Cuidad"]) !!}
                            </div>
                       
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                <label> Nivel estudios @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Level Study @endif :
                                    <span>*</span>
                                </label>

                                {!! Form::select("nivel_estudio_id",$nivelEstudios,null,["class"=>"form-control","id"=>"nivel_estudio_id"]) !!}
                            </div>

                            @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co" || route("home") == "https://gpc.t3rsc.co")
                                <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                 <label>
                                  Estatus de formación académica <span>*</span>
                                   @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co")
                                   /Training Status Academico @endif :
                                 </label>

                                    {!!Form::select("estatus_academico",[""=>"Seleccionar",'Abandono'=>"Abandono",'Egresado'=>"Egresado",'en curso'=>"En Curso","Graduado"=>"Graduado",'otro'=>"otro"],null,["class"=>"form-control","id"=>"estatus_academico"])!!}
                                </div>
                            @endif

                            @if(route("home") != "http://tiempos.t3rsc.co" && route("home") != "https://tiempos.t3rsc.co" && route("home") != "https://gpc.t3rsc.co")
                                <div id="periodos" class="form-group col-md-6 col-sm-12 col-xs-12">
                                    @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                                        <label>Semestres cursados:</label>
                                    @else
                                        <label>
                                            Períodos cursados:
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Applied Studies @endif
                                            
                                        </label>
                                    @endif
                                    
                                    {!! Form::select("semestres_cursados",[""=>"Seleccionar",0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15],null,["class"=>"form-control","id"=>"semestres_cursados"]) !!}
                                </div>
                            @endif
                            
                            <div id="" class="form-group col-md-6 col-sm-12 col-xs-12">
                                    
                                        <label>
                                            Períodicidad:
                                            @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Applied Studies @endif
                                            
                                        </label>
                                 
                                    
                                    {!! Form::select("periodicidad",$periodicidad,null,["class"=>"form-control","id"=>"periodicidad"]) !!}
                                </div>
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                <label>
                                    Fecha inicio:<span>*</span>
                                </label>
                                {!!Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"Fecha Inicio","id"=>"fecha_inicio" ])!!}
                            </div>
                            <div class="form-group col-md-6 col-sm-12 col-xs-12 fecha_finalizacion">
                                <label>
                                  Fecha finalización
                                    @if(route('home') == "http://colpatria.t3rsc.co" || route('home') == "https://colpatria.t3rsc.co") /Date Finished @endif :
                                    <span> </span>
                                </label>
                               @if(route('home') != "https://gpc.t3rsc.co")
                                {!!Form::text("fecha_finalizacion",null,["class"=>"form-control fecha_finalizacion","placeholder"=>"Fecha Finalización","id"=>"fecha_finalizacion" ])!!}
                               @else
                                {!!Form::date("fecha_finalizacion",null,["max"=>date('Y-m-d'),"class"=>"form-control","placeholder"=>"Fecha Finalización","id"=>"fecha_finalizacion"])!!}
                               @endif
                            </div>
                            
                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                
                                <label>Acta: <span></span></label>
                                
                                {!! Form::text("acta",null,["class"=>"form-control", "id"=>"acta" ,"placeholder"=>"Acta" ]) !!}
                            </div>

                            <div class="form-group col-md-6 col-sm-12 col-xs-12">
                                
                                <label>Folio: <span></span></label>
                                
                                {!! Form::text("folio",null,["class"=>"form-control", "id"=>"folio" ,"placeholder"=>"Folio" ]) !!}
                            </div>

                            <p class="direction-botones set-margin-top">
                                <button class="btn btn-warning pull-right" id="cancelar_estudios" style="display:none; margin: auto 10px auto;" type="button">
                                    <i class="fa fa-pencil"></i> Cancelar
                                </button>
                         
                                <button class="btn btn-success pull-right" id="actualizar_estudios" style="display:none; margin: auto 10px auto;" type="button">
                                    <i class="fa fa-floppy-o"></i> Actualizar
                                </button>
                         
                                <button class="btn btn-success pull-right" id="guardar_estudios" type="button">
                                    <i class="fa fa-floppy-o"> </i> Guardar @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co")  y Siguiente @endif
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
                                            <th>Título obtenido</th>
                                            <th>Institución</th>
                                            <th>Nivel estudio</th>
                                            @if(route("home") != "https://gpc.t3rsc.co")
                                                <th>Estudio actual</th>
                                                <th>Fecha finalización</th>
                                            @else
                                                <th>Fecha finalización</th>
                                                <th>Estatus académico</th>
                                            @endif
                                            <th></th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        @if($estudios->count() == 0)
                                            <tr id="registro_nulo">
                                                <td colspan="6">No  hay registros</td>
                                            </tr>
                                        @endif

                                        @foreach($estudios as $estudio)
                                            <tr id="tr_{{$estudio->id}}">
                                                <td>{{ $estudio->titulo_obtenido }}</td>
                                                <td>{{$estudio->institucion}}</td>
                                                <td>{{$estudio->descripcion_nivel}}</td>
                                                @if(route("home") != "https://gpc.t3rsc.co")
                                                    <td>{{(($estudio->estudio_actual==1)?"SI":"NO") }}</td>
                                                    <td>{{$estudio->fecha_finalizacion}}</td>
                                                @else
                                                    <td>{{$estudio->fecha_finalizacion}}</td>
                                                    <td>{{$estudio->estatus_academico}}</td>
                                                @endif
                                                <td>
                                                    {!!Form::hidden("id",$estudio->id, ["id"=>$estudio->id])!!}
                                                    <button class="btn btn-info btn-peq certificados" type="button" title="Certificados">
                                                        <i class="fa fa-file-text-o"></i>
                                                    </button>
                                                    <button class="btn btn-primary btn-peq editar_estudios disabled_estudios" type="button"> <i class="fa fa-pencil"></i>                           <!--Editar-->
                                                    </button>
                                                    <button class="btn btn-danger btn-peq eliminar_estudios disabled_estudios" type="button">
                                                        <i class="fa fa-trash"> </i>
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
        </div>
    </div>
</div>

<script>
    $(function () {
        @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co")
            $('#periodos').hide();
            $('.actual-c').hide();

            //para colpatria estatus academico periodo actual
            $('#estatus_academico').change(function(){
                var valor = $(this).val();            
                
                switch (valor){
                    case 'en curso':
                        $('#estudio_actual').attr('checked',true);
                        $('#periodos').show();
                        $('.fecha_finalizacion').hide();
                    break;

                    default:
                        $('#periodos').hide();
                        $('.fecha_finalizacion').show();
                        $('#estudio_actual').removeAttr('checked');
                    break;
                }
            });
        @endif

        @if(route("home") != "https://gpc.t3rsc.co")
            $('.fecha_finalizacion').show();
            
            $('#estudio_actual').change(function(){
                if(!$(this).prop('checked')){           
                    $('.fecha_finalizacion').show();
                }else{
                    $('.fecha_finalizacion').hide();
                }
            });
        @endif

        @if( isset($datos_basicos->tiene_estudio) && $datos_basicos->tiene_estudio == "0" )

             $(".form-group").fadeOut()

        @endif

        $("#tiene_estudio").on("click", function() {
                
                if( $( this ).is( ':checked' ) ){

                    $(".form-group").fadeOut()
                }else{
                    $(".form-group").fadeIn()
                }
        })

        /**
            * Guardar Estudios
        **/
        $(document).on("click","#guardar_estudios", function () {
            var formData = new FormData(document.getElementById("fr_estudios"));
            $.ajax({
                type: "POST",
                data: formData,
                url: "{{route('guardar_estudios')}}",
                cache:false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $("#mensaje-error").hide();

                    $(document).ready(function(){
                      $("input").css({"border": "1px solid #ccc"});
                      $("select").css({"border": "1px solid #ccc"});
                      $("textarea").css({"border": "1px solid #ccc"});
                      $(".text").remove();
                    });
                    
                    var campos = data.rs;
                    if(campos){

                        var tr = $("<tr id='tr_" + campos.id + "'></tr>");

                        tr.append($("<td></td>", {text: campos.titulo_obtenido}));
                        tr.append($("<td></td>", {text: campos.institucion}));
                        tr.append($("<td></td>", {text: campos.descripcion_nivel}));

                        @if(route("home") != "https://gpc.t3rsc.co")
                            tr.append($("<td></td>", {text: ((campos.estudio_actual == 1) ? "SI" : "NO")}));
                            tr.append($("<td></td>", {text: campos.fecha_finalizacion}));
                        @else
                            tr.append($("<td></td>", {text: campos.fecha_finalizacion}));
                            tr.append($("<td></td>", {text: campos.estatus_academico}));
                        @endif

                        tr.append($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button class="btn btn-info btn-peq certificados" type="button" title="Certificados"><i class="fa fa-file-text-o"></i></button><button type="button" class="btn btn-primary btn-peq editar_estudios disabled_estudios"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger btn-peq eliminar_estudios disabled_estudios"><i class="fa fa-trash"></i></button>'}));

                        $("#tbl_estudios tbody").append(tr);
                        $("#registro_nulo").remove();

                        //Busca todos los input y lo pone a su color original
                        swal("Nuevo estudio Agregado", " ¿Desea agregar una nuevo estudio?", "info", {
                            buttons: {
                                cancelar: { text: "Agregar Nuevo Estudio",className:'btn btn-success' },
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
                                  window.location.href = '{{route('grupo_familiar').'#fr_grupo'}}';
                                  //AQUI CODIGO DONDE AGREGAS
                                break;
                            }
                        });

                        $("#fr_estudios")[0].reset();
                        $("#tiene_estudio").prop('checked', false);
                    }else{
                        mensaje_success("Se ha guardado sin estudios.");
                        window.location.href = '{{route('grupo_familiar').'#fr_grupo'}}';
                    }
                },
                error:function(data){
                    $(document).ready(function(){
                      $("input").css({"border": "1px solid #ccc"});
                      $("select").css({"border": "1px solid #ccc"});
                      $("textarea").css({"border": "1px solid #ccc"});
                      $(".text").remove();
                    });

                    $.each(data.responseJSON.errors, function(index, val){
                        $('input[name='+index+']').after('<span class="text-danger">'+val[0]+'</span>');
                        $('textarea[name='+index+']').after('<span class="text-danger">'+val[0]+'</span>');
                        $('select[name='+index+']').after('<span class="text-danger">'+val[0]+'</span>');
                        document.getElementById(index).style.border = 'solid red';
                    });

                    $("#error").html("Upps, creo que olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");
                    $("#mensaje-error").fadeIn();
                }
            })
        });
        /**
            * Eliminar Estudio
        **/
        $(document).on("click",".eliminar_estudios", function() {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id){
                if(confirm("Desea eliminar este registro?")){
                    $(".disabled_estudios").prop("disabled", true);
               
                    $.ajax({
                        type: "POST",
                        data: {"id":id},
                        url: "{{route('eliminar_estudio')}}",
                        success: function (response) {
                            $("#tr_" + response.id).remove();
                            mensaje_success("Registro eliminado.");
                            $(".disabled_estudios").prop("disabled", false);
                        }
                    });
                }
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });

        $('#ciudad_autocomplete').keypress(function(){
            $(this).css("border-color","red");
            $("#error_ciudad").show();
            $("#select_expedicion_id").val("no");
        });


            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades_all") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion){
                    $("#error_ciudad").hide();
                    $(this).css("border-color","rgb(210,210,210)");
                    $("#pais_estudio").val(suggestion.cod_pais);
                    $("#departamento_estudio").val(suggestion.cod_departamento);
                    $("#ciudad_estudio").val(suggestion.cod_ciudad);
                }
            });

        $('#universidades_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_universidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                /*$("#pais_estudio").val(suggestion.cod_pais);
                $("#departamento_estudio").val(suggestion.cod_departamento);
                $("#ciudad_estudio").val(suggestion.cod_ciudad);*/
            }
        });

        @if(route('home') == "http://tiempos.t3rsc.co" || route('home') == "https://tiempos.t3rsc.co")      
            var confDatepicker = {
                closeText: 'Seleccionar',
                startView: "months", 
                minViewMode: "months",
                prevText: '<Ant',
                nextText: 'Sig>',
                currentText: 'Hoy',
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                dateFormat: 'mm-yy',
                altFormat: "yy-mm-dd",
                yearRange: "1930:2020",
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            }
        @endif
        
        var confDatepicker = {
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonImage: "img/gifs/018.gif",
            buttonImageOnly: true,
            autoSize: true,
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            yearRange: "1930:2050"
         };
        //$("#fecha_finalizacion").datepicker(confDatepicker);
        @if(route('home') != "https://gpc.t3rsc.co")   
          $("#fecha_inicio, #fecha_finalizacion").datepicker(confDatepicker);
        @endif

        $("#eliminar_estudio").on("click", function () {
            if (seleccionarLista("id") && confirm("Desea eliminar este registro?")) {
                $.ajax({
                    type: "POST",
                    data: $("#grilla_datos").serialize(),
                    url: " {{route('eliminar_estudio')}} ",
                    success: function(response){
                        $("#tr_" + response.id).remove();
                        alert("Registro eliminado");
                    }
                });
            }
        });
        
        $("#cancelar_estudios").on("click", function () {
            //Ocultar Botones Cancelar Guardar.
            document.getElementById('cancelar_estudios').style.display = 'none';
            document.getElementById('actualizar_estudios').style.display = 'none';

            //MOstrar Boton Guardar
            document.getElementById('guardar_estudios').style.display = 'block';

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
       
        $(document).on("click",".editar_estudios", function() {
            //Mostar Botones Cancelar Guardar.
            document.getElementById('cancelar_estudios').style.display = 'block';
            document.getElementById('actualizar_estudios').style.display = 'block';

            //Ocultar Boton Guardar
            document.getElementById('guardar_estudios').style.display = 'none';

            //Desactivar botones Editar + Eliminar
            $(".disabled_estudios").prop("disabled", true);

            var objButton = $(this);
            id = objButton.parent().find("input").val();
            if(id){
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{route('editar_estudio')}}",
                    success: function (response) {
                        $("#nivel_estudio_id").val(response.data.nivel_estudio_id);
                        $("#institucion").val(response.data.institucion);
                        $("#titulo_obtenido").val(response.data.titulo_obtenido);
                        $("#estudio_actual").val(response.data.estudio_actual);

                        @if(route("home") == "http://colpatria.t3rsc.co" || route("home") == "https://colpatria.t3rsc.co" || route("home") == "https://gpc.t3rsc.co")
                            //solo para colpatria
                            $("#estatus_academico").val(response.data.estatus_academico);
                        @endif
                    
                        $("#semestres_cursados").val(response.data.semestres_cursados);
                        $("#fecha_inicio").val(response.data.fecha_inicio);
                        $("#fecha_finalizacion").val(response.data.fecha_finalizacion);
                        $("#pais_estudio").val(response.data.pais_estudio);
                        $("#departamento_estudio").val(response.data.departamento_estudio);
                        $("#ciudad_estudio").val(response.data.ciudad_estudio);
                   
                        $("#ocupacion").val(response.data.ocupacion);
                        $(".id_modificar_estudios").val(response.data.id);

                        @if(route("home") == "https://gpc.t3rsc.co")
                         $("#universidades_autocomplete").val(response.data.institucion);
                        @endif
                        
                        //Ciudad-Residencia
                        $("#ciudad_autocomplete").val(response.ciudad_estudios);
                        $("#acta").val(response.data.acta);
                        $("#folio").val(response.data.folio);
                    }
                });
            }else{
                mensaje_danger("No se borro el registro, favor intentar nuevamente.");
            }
        });

        $(document).on("click","#actualizar_estudios", function() {
            var objButton = $(this);
            id = objButton.parents("form").find(".id_modificar_estudios").val();
            //alert(id);
            if (id) {
                var formData = new FormData(document.getElementById("fr_estudios"));
                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{route('actualizar_estudios')}}",
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        $("#fr_estudios")[0].reset();
                        $(".disabled_estudios").prop("disabled", false);
                        mensaje_success("Registro actualizado.");

                        var campos = response.estudios;
                        $("#tr_" + campos.id).html(tr);
                        var tr = $("#tr_" + campos.id + "").find("td");
                
                        tr.eq(0).html(campos.titulo_obtenido);
                        tr.eq(1).html(campos.institucion);
                        tr.eq(2).html(campos.descripcion_nivel);
                        tr.eq(3).html((campos.estudio_actual == 1) ? "SI" : "NO");
                        tr.eq(4).html(campos.fecha_finalizacion);
                        tr.eq(5).html($("<td></td>", {html: '<input type="hidden" name="id" value="'+campos.id+'"><button type="button" class="btn btn-primary btn-peq editar_estudios disabled_estudios"><i class="fa fa-pencil"></i></button> <button type="button" class="btn btn-danger btn-peq eliminar_estudios disabled_estudios"><i class="fa fa-trash"></i></button>'}));

                        $("#mensaje-error").hide();
                        $("input").css({"border": "1px solid #ccc"});
                        $("select").css({"border": "1px solid #ccc"});

                        //Ocultar Botones Cancelar Guardar.
                        document.getElementById('cancelar_estudios').style.display = 'none';
                        document.getElementById('actualizar_estudios').style.display = 'none';
                        //MOstrar Boton Guardar
                        document.getElementById('guardar_estudios').style.display = 'block';
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
                $(".disabled_estudios").prop("disabled", false);
            }
        });

        $(".certificados").on("click", function () {
            var objButton = $(this);
            id = objButton.parent().find("input").val();

            if(id) {
                $.ajax({
                    type: "POST",
                    data: {"id":id},
                    url: "{{ route('certificados_estudios') }}",
                    success: function (response) {
                        $("#modal2").find(".modal-content").html(response);
                        $("#modal2").modal("show");
                    }
                });
            }else{
                mensaje_danger("No se pueden ver los documentos, favor intentar nuevamente.");
            }
        });
    });
</script>
@stop