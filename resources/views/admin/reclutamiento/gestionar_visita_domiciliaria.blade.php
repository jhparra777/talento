@extends("admin.layout.master")
@section('contenedor')
    
    <h3>Gestionar visita domiciliaria</h3>
    
    <h5 class="titulo1">Información Candidato</h5>
    
    <table class="table table-bordered">
        <tr>
            <th>Cedula</th>
            <td>{{$candidato->numero_id}}</td>
            <th>Nombres</th>
            <td>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</td>
        </tr>
        <tr>
            <th>Telefono</th>
            <td>{{$candidato->telefono_fijo}}</td>
            <th>Movil</th>
            <td>{{$candidato->telefono_movil}}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{$candidato->email}}</td>
        </tr>
    </table>

 
        <button type="button" class="btn btn-info" id="nueva_visita">Realizar Visita</button>
   
        <button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>

        
    
    </a>

    <a type="button" class="btn  btn-info" href="{{(route('home') == 'http://komatsu.t3rsc.co' || route('home') == 'https://komatsu.t3rsc.co')?route('admin.informe_seleccion',['user_id'=>$candidato->req_cand_id]): route('admin.hv_pdf',['ref_id'=>$candidato->user_id])}}" target="_blank">HV PDF</a>

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a
                    role="button"
                    style="width: 100%; display: block;"
                    data-toggle="collapse"
                    data-parent="#accordion"
                    href="#collapseOne"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                >
                    Referencias Laborales
                </a>
            </h4>
        </div>

        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                @foreach($experiencias_laborales as $experiencia)
                    <div class="container_referencia">
                        <div class="referencia">
                            <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                                <tr>
                                    <th>Nombre Empresa</th>
                                    <td>{{$experiencia->nombre_empresa}}</td>
                                    <th>Teléfono Empresa</th>
                                    <td>{{$experiencia->telefono_temporal}}</td>
                                </tr>
                                <tr>
                                    <th>Ciudad</th>
                                    <td>{{$experiencia->ciudades}}</td>
                                    <th>Cargo Desempeñado</th>
                                    <td>{{$experiencia->cargo_especifico}}</td>
                                </tr>
                                <tr>
                                    <th>Nombres Jefe</th>
                                    <td>{{$experiencia->nombres_jefe}}</td>
                                    <th>Cargo jefe</th>
                                    <td>{{$experiencia->cargo_jefe}}</td>
                                </tr>
                                <tr>
                                    <th>Teléfono móvil Jefe</th>
                                    <td>{{$experiencia->movil_jefe}}</td>
                                    <th>Teléfono fijo jefe</th>
                                    <td>{{$experiencia->fijo_jefe}}</td>
                                </tr>
                                <tr>
                                    <th>Trabajo Ingreso</th>
                                    <td>{{$experiencia->fecha_inicio}}</td>
                                    <th>Fecha Salida</th>
                                    <td>{{$experiencia->fecha_final}}</td>
                                </tr>
                                <tr>
                                    <th>Salario</th>
                                    <td>{{$experiencia->salario}}</td>
                                    <th>Motivo Retiro</th>
                                    <td>{{$experiencia->desc_motivo}}</td>
                                </tr>
                                <tr>
                                    <th>Funciones y logros</th>
                                    <td colspan="3">{{$experiencia->funciones_logros}}</td>
                                </tr>
                            </table>
                        </div>

                        <div class="requerimientos">
                            <div class="btn_procesos">
                                @if(!in_array($experiencia->id ,$req_referencia_gestionado))
                                    <!--
                                        <a class="btn btn-success verficar_referencia" data-ref_hv="{$experiencia->id}}" >Verificado</a>  
                                    -->
                                    <a class="btn btn-warning gestionar_referencia" data-ref_hv="{{$experiencia->id}}">Gestionar</a> 
                                @else
                                    <a class="btn btn-warning detalle_referencia" data-ref_hv="{{$experiencia->id}}">Editar</a> 
                                @endif
                            </div>

                            <h4 class="titulo1" style="margin: 0">Requerimientos</h4>

                            @foreach($experiencia->getRequerimientos() as $req)
                                <div class="badge">
                                    <label>
                                        {!! Form::radio("ref_gestionada",$req->entidad_id,null,["class"=>"referencias_verificadas"]) !!} 
                                        <span> Req:{{$req->requerimiento_id}} </span>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingTwo">
            <h4 class="panel-title">
                <a
                    class="collapsed"
                    style="display: block;width: 100%;"
                    role="button"
                    data-toggle="collapse"
                    data-parent="#accordion"
                    href="#collapseTwo"
                    aria-expanded="false"
                    aria-controls="collapseTwo"
                >
                    Referencias Personales
                </a>
            </h4>
        </div>

        <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
            <div class="panel-body">
                @foreach($referencias_personales as $ref_personales)
                <div class="container_referencia">
                    <div class="referencia">
                        <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                            <tr>
                              <th>Nombres</th>
                              <td>{{$ref_personales->nombres}}</td>
                              <th>Primer Apellido</th>
                              <td>{{$ref_personales->primer_apellido}}</td>
                            </tr>
                            <tr>
                              <th>Segundo Apellido</th>
                              <td>{{$ref_personales->segundo_apellido}}</td>
                              <th>Tipo relación</th>
                              <td>{{$ref_personales->relacion}}</td>
                            </tr>
                            <tr>
                              <th>Teléfono Móvil</th>
                              <td>{{$ref_personales->telefono_movil}}</td>
                              <th>Teléfono Fijo</th>
                              <td>{{$ref_personales->telefono_fijo}}</td>
                            </tr>
                            <tr>
                                <th>Ciudad</th>
                                <td>{{$ref_personales->ciudad_seleccionada}}</td>
                                <th>Ocupación</th>
                                <td>{{$ref_personales->ocupacion}}</td>
                            </tr>

                        </table>
                    </div>
                    <div class="requerimientos">
                        <div class="btn_procesos">
                            @if(!in_array($ref_personales->id ,$req_referencia_personal_gestionado))
                            <a class="btn btn-success verficar_referencia_personal" data-ref_hv="{{$ref_personales->id}}"> Verificado</a>    
                            <a class="btn btn-warning gestionar_referencia_personal" data-ref_hv="{{$ref_personales->id}}"> Gestionar</a>
                            @else 
                             <a class="btn btn-warning editar_referencia_personal" data-ref_hv="{{$ref_personales->id}}"> Editar</a>
                            @endif
                        </div>

                        <h4 class="titulo1" style="margin: 0">Requerimientos</h4>
                        @foreach($ref_personales->getRequerimientos() as $req)
                        <div class="badge">
                          <label>
                            {!! Form::radio("ref_gestionada",$req->entidad_id,null,["class"=>"referencias_verificadas"]) !!} 
                            <span> Req: {{$req->requerimiento_id}} </span>
                          </label>
                        </div>
                        @endforeach

                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading3">
            <h4 class="panel-title">
                <a class="collapsed" style="display: block;width: 100%;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" aria-controls="collapse3">
                    Estudios
                </a>
            </h4>
        </div>
        <div id="collapse3" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading3">
            <div class="panel-body">
                @foreach($estudios as $estudio)
                <div class="container_referencia">
                    <div class="referencia">
                        <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                            <tr>
                                <th>Nivel Estudios</th>
                                <td>{{$estudio->nivel_estudio}}</td>
                                <th>Institución</th>
                                <td>{{$estudio->institucion}}</td>
                            </tr>
                            <tr>
                                <th>Terminó Estudios:</th>
                                <td>{{(($estudio->termino_estudios==1)?"SI":"")}}</td>
                                <th>Titulo Obtenido: </th>
                                <td>{{$estudio->titulo_obtenido}}</td>
                            </tr>
                            <tr>
                                <th>Fecha Finalización</th>
                                <td>{{$estudio->fecha_finalizacion}}</td>
                                <th>Estudia actualmente?</th>
                                <td>{{(($estudio->estudio_actual==1)?"SI":"NO")}}</td>
                            </tr>
                            <tr>
                                <th>Semestres Cursados:</th>
                                <td>{{$estudio->semestres_cursados}}</td>
                            </tr>

                        </table>
                    </div>

                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>


    <div class="row">

        <h3 class="titulo1">Visitas Realizadas</h3>

        
    
        <h4 style="color: #1183e1;" >Visitas</h4>
        
        @foreach($visitas as $visitas)
    
            <div class="container_referencia">
                <div class="referencia">
                    <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                        <tr>
                            <th>Fuente de Reclutamiento </th>
                            <td>{{$entrevista->desc_fuente}}</td>
                            <th>Apto</th>
                            <td>{{(($entrevista->apto==1)?"Si":"No")}}</td>
                            <td><button class="btn btn-info ver_detalle" data-id="{{$entrevista->id}}">Ver detalle</button></td>
                            <!--
                                <th>Aspecto Familiar</th>
                                <td>{$entrevista->aspecto_familiar}}</td>
                            -->
                        </tr>
                        <!--
                            <tr>
                                <th>Aspectos Académicos</th>
                                <td>{$entrevista->aspecto_academico}}</td>
                                <th>Aspectos Experiencia</th>
                                <td>{$entrevista->aspectos_experiencia}}</td>
                            </tr>
                        -->
                        <tr>
                            <th>Usuario Gestion</th>
                            <td>{{$entrevista->name}}</td>
                            <th>Fecha Gestion</th>
                            <td>{{$entrevista->created_at}}</td>
                        </tr>
                    </table>
                </div>

                <div class="requerimientos">
                    <div class="btn_procesos">
                        <span style="position: relative;top:-15px;"><strong>¿Usar en este requerimiento?</strong></span>
                        <label class="switchBtn">
                                 {!! Form::checkbox("definitiva",0,($entrevista->getRequerimientosActivos($candidato->requerimiento_id)!=null)? 1:null,["class"=>"usar","id"=>"switch","data-entrevista"=>$entrevista->id,"data-req"=>$candidato->requerimiento_id]) !!}
                                <div class="slide"></div>
                        </label>

                        {{--@if($entrevista->activo!=0)
                            <a class="btn btn-danger entrevista_utilizada" id="" data-prueba="{{$entrevista->id}}" data-req="{{$candidato->requerimiento_id}}">No Usar Entrevista</a>
                        @else
                            <a class="btn btn-success entrevista_utilizada2" id="" data-prueba="{{$entrevista->id}}" data-req="{{$candidato->requerimiento_id}}">Usar Entrevista</a>
                        @endif--}}
                    </div>
                    
                    <br>

                    <h4 class="titulo1" style="margin: 0">Requerimientos</h4>
                    @foreach($entrevista->getRequerimientos() as $req)
                        <div class="badge  badge-over">
                            <span>Req:{{$req->requerimiento_id}}</span>
                        </div>
                    @endforeach
                </div>
            </div>

        @endforeach
    </div>

<style>
 .usar + .slide:after {
    position: absolute;
    content: "NO" !important;
 }

.usar:checked + .slide:after {
   content: "SI"  !important;
}
</style>

    <script>
        $(function () {
         
         var ruta = "{{route('admin.gestion_requerimiento',$candidato->requerimiento_id)}}";

         $(".usar").on("change", function () {
        if(!$(this).prop("checked")){
            

            var entrevista = $(this).data("entrevista");
            var req = $(this).data("req");
            //var btn = $(this);
            
            $.ajax({
                type: "POST",
                data: {req_id: req, entrevista_id: entrevista},
                url: "{{ route('admin.registra_entrevista_entidad') }}",
                success:function(response){
                    mensaje_success("Esta entrevista no se usará para este requerimiento");
                    setTimeout(function(){
                        window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}'; }, 2000);
                   
                    
                }
            });
        
            
        }
        else{

            var entrevista = $(this).data("entrevista");
            var req = $(this).data("req");
            //var btn = $(this);
            
            $.ajax({
                type: "POST",
                data: {req_id: req, entrevista_id: entrevista},
                url: "{{ route('admin.registra_entrevista_entidad2') }}",
                success:function(response){
                    mensaje_success("¡Esta entrevista se usará para este requerimiento!");
                     setTimeout(function(){
                        window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}'; }, 2000);
                    
                }
            });
        

        }
            
            /*$.ajax({
                type: "POST",
                data: "ref_id={{$candidato->ref_id}}&modulo=pruebas",
                url: "{{route('admin.cambiar_estado_view')}}",
                success: function (response) {
                    console.log("af");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");

                }
            });*/
        });


            //Nueva entravista (modal)
            

            //Guardar entrevista semi
            $(document).on("click", "#guardar_entrevista_semi", function () {
                $(this).prop("disabled", false);

                @if (route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co" || route('home') == "http://localhost:8000")
                    
                 if(!$('input[name="autorizacion"]').is(':checked')){

                    $('#label_autorizacion').css('color', 'red');
                    $('#autorizacion').focus();

                    setTimeout(function(){
                     $('#label_autorizacion').css('color', '#333');
                    }, 4000);

                    }else if($('#observacion_preguntas').val() == ''){
                        
                        $('#observacion_preguntas').css('border', 'solid 1px red');
                        $('#observacion_preguntas').focus();

                        setTimeout(function(){
                            $('#observacion_preguntas').css('border', 'solid 1px #d2d6de');
                        }, 4000);

                    }else if (!$('input[name="concepto_final_preg_1"]').is(':checked')) {

                        $('#label_concepto_final_preg_1').css('color', 'red');
                        $('#concepto_final_preg_1').focus();

                        setTimeout(function(){
                            $('#label_concepto_final_preg_1').css('color', '#333');
                        }, 4000);

                    }else if (!$('input[name="concepto_final_preg_2"]').is(':checked')) {

                        $('#label_concepto_final_preg_2').css('color', 'red');
                        $('#concepto_final_preg_2').focus();

                        setTimeout(function(){
                            $('#label_concepto_final_preg_2').css('color', '#333');
                        }, 4000);

                    }else if (!$('input[name="concepto_final_preg_3"]').is(':checked')) {

                        $('#label_concepto_final_preg_3').css('color', 'red');
                        $('#concepto_final_preg_3').focus();

                        setTimeout(function(){
                            $('#label_concepto_final_preg_3').css('color', '#333');
                        }, 4000);

                    }else if($('#concepto_final').val() == ''){
                        
                        $('#concepto_final').css('border', 'solid 1px red');
                        $('#concepto_final').focus();

                        setTimeout(function(){
                            $('#concepto_final').css('border', 'solid 1px #d2d6de');
                        }, 4000);

                    }else if (!$('input[name="apto"]').is(':checked')) {

                        $('#label_apto').css('color', 'red');
                        $('#apto').focus();

                        setTimeout(function(){
                            $('#label_apto').css('color', '#333');
                        }, 4000);

                    }
                    else{
                        $.ajax({
                            type: "POST",
                            data: $("#fr_entrevista_semi").serialize(),
                            url: "{{ route('admin.guardar_entrevista_semi') }}",
                            success: function (response) {
                                
                                mensaje_success("Entrevista Semiestructurada creada");

                                if(response.final == 1){
                                   mensaje_success("Entrevista Guardada con Exito!!");
                                    setTimeout(function(){
                                     location.href=ruta; }, 3000);
                                    }
                                else{
                                    window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}';
                                }
                                {{-- window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}';--}}
                            },
                            error: function (response) {
                                
                                $(document).ready(function(){
                                    $(".text").remove();
                                });

                                $.each(response.responseJSON, function(index, val){
                                    $('radio[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                                    $('textarea[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                                    $('select[name='+index+']').after('<span  class="text">'+val+'</span>');
                                });

                                $("#modal_peq").find(".modal-content").html(response.view);
                            }

                        });
                    }

                @else

                    $.ajax({
                        type: "POST",
                        data: $("#fr_entrevista_semi").serialize(),
                        url: "{{ route('admin.guardar_entrevista_semi') }}",
                        success: function (response) {
                            
                            mensaje_success("Entrevista Semiestructurada creada");

                            if(response.final == 1){
                                window.location.href = '{{ route("admin.entrevistas") }}';
                            }
                            else{
                                window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}';
                            }
                            {{-- window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}';--}}
                        },
                        error: function (response) {
                            
                            $(document).ready(function(){
                                $(".text").remove();
                            });

                            $.each(response.responseJSON, function(index, val){
                                $('radio[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                                $('textarea[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                                $('select[name='+index+']').after('<span  class="text">'+val+'</span>');
                            });

                            $("#modal_peq").find(".modal-content").html(response.view);
                        }

                    });

                @endif

            });

            //Ver detalle entrevista semi
            $(".ver_detalle_semi").on("click", function () {
                var id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    data: {entre_id: id, ref_id: "{{$candidato->ref_id}}"},
                    url: " {{ route('admin.detalle_entrevista_modal_semi') }} ",
                    success: function (response) {
                        $('#modal_gr').modal({ backdrop: 'static', keyboard: false });
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");   
                    }
                });
            });

            $("#cambiar_estado").on("click", function () {
                $.ajax({
                    type: "POST",
                    data: "ref_id={{$candidato->ref_id}}",
                    url: "{{route('admin.cambiar_estado_view')}}",
                    success: function (response) {
                        console.log("af");
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_estado", function () {
                $.ajax({
                    data: $("#fr_cambio_estado").serialize(),
                    url: "{{route('admin.guardar_cambio_estado')}}",
                    success: function (response) {
                        if(response.success) {
                          mensaje_success("Estado actualizado");
                          window.location.href = ruta;
                        }else{

                          $("#modal_peq").find(".modal-content").html(response.view);
                        }

                    }
                });
            });

            $(document).on("click",".entrevista_semi_utilizada", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{ route('admin.registra_entrevista_semi_entidad') }}",
                    success: function (response) {
                        mensaje_success("Entrevista Semi no mostrada");
                        window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}'
                    }
                });
            });

            $(document).on("click",".entrevista_semi_utilizada2", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{ route('admin.registra_entrevista_semi_entidad2') }}",
                    success: function (response) {
                        mensaje_success("Entrevista Semi mostrada");
                        window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}'
                   }
                });
            });

            $("#nueva_entrevista").on("click", function () {
                $.ajax({
                    type: "POST",
                    data: "ref_id={{$candidato->ref_id}}",
                    url: "{{ route('admin.nueva_visita_domiciliaria') }}",
                    success: function (response) {
                        $('#modal_gr').modal({ backdrop: 'static', keyboard: false });
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });           

            $(document).on("click", "#guardar_entrevista", function(){
                $('.text.error').hide()
                $(this).prop("disabled",true);
                //guarda entrevista definitiva 3gh
                $.ajax({
                    type: "POST",
                    data: $("#fr_entrevista").serialize(),
                    url: "{{ route('admin.guardar_entrevista') }}",
                    success: function (response) {
                      $("#guardar_entrevista").removeAttr("disabled");
                        mensaje_success("Entrevista creada con éxito!!");

                        if(response.final == 1){
                         // window.location.href = '{{route("admin.entrevistas")}}';
                          mensaje_success("Entrevista Guardada con Exito!!");
                            setTimeout(function(){
                             location.href=ruta; }, 3000);
                        }else{
                         window.location.href = '{{route("admin.gestionar_entrevista",[$candidato->ref_id])}}';
                        }
                    },
                    error: function (response) {
                      $("#guardar_entrevista").removeAttr("disabled");
                        $.each(response.responseJSON, function(index, val){
                            $('#error-'+index).show();
                            $('#error-'+index).html(val);
                        });

                        $("#modal_peq").find(".modal-content").html(response.view);
                    }

                });
            });
         
            $(document).on("click",".entrevista_utilizada", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);
                   
                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{route('admin.registra_entrevista_entidad')}}",
                    success: function (response) {
                        var prueba = $(this).data("prueba");
                        var req = $(this).data("req");
                        mensaje_success("Entrevista no mostrada!!");
                        window.location.href = '{{route("admin.gestionar_entrevista",[$candidato->ref_id])}}'
                    }
                });
            });

            $(document).on("click",".entrevista_utilizada2", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);

                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{ route('admin.registra_entrevista_entidad2') }}",
                    success: function (response) {
                        mensaje_success("Entrevista  mostrada!!");
                        window.location.href = '{{ route("admin.gestionar_entrevista",[$candidato->ref_id]) }}'
                   }
                });
            });

            $(".ver_detalle").on("click", function () {
                var id = $(this).data("id");
                $.ajax({
                    type: "POST",
                    data: {entrevista_id: id, ref_id: "{{$candidato->ref_id}}"},
                    url: " {{ route('admin.detalle_entrevista_modal') }} ",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");   
                    }
                });
            });
         
        });
    </script>

@stop