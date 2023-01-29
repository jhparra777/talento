@extends("admin.layout.master")
@section('contenedor')
<style>
    .text{
        font-size: 10pt;
    }
</style>
<h3>Gestionar Referencia Estudios</h3>

<h5 class="titulo1">Información Candidato</h5>

<table class="table table-bordered">
    <tr>
        <th>Cédula</th>
        <td>{{$candidato->numero_id}}</td>
        <th>Nombres</th>
        <td>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</td>
    </tr>
    <tr>
        <th>Teléfono</th>
        <td>{{$candidato->telefono_fijo}}</td>
        <th>Móvil</th>
        <td>{{$candidato->telefono_movil}}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{$candidato->email}}</td>
    </tr>
</table>

<table class="table table-bordered tbl_info">
    <tr>
        <th colspan="7">Estado</th>
    </tr>
    <tr>
        <th>Requerimiento</th>
        <th>Usuario Envío</th>
        <th>Fecha Registro</th>
        <th>Proceso</th>
        <th>Estado</th>
        <th>Motivo Rechazo</th>
        <th>Observaciones</th>
        <th>Gestión Req</th>
    </tr>
    @foreach($estados_procesos_referenciacion as $ref)
        <tr>
            <td>{{$candidato->requerimiento_id}}</td>
            <td>{{$ref->name}}</td>

            <td>{{$ref->fecha_inicio}}</td>

            <td>{{$ref->proceso}}</td>
            <td>
                <?php
                switch ($ref->apto) {
                    case 1:
                        echo "Apto";
                        break;
                    case 2:
                        echo "No Apto";
                        break;
                    case 3:
                       
                        echo "Pendiente";

                        break;
                }
                ?>
            </td>
            <td>{{$ref->motivo_rechazo_id}}</td>
            <td>{{$ref->observaciones}}</td>
            <td>
                <a href="{{ route('admin.gestion_requerimiento', $candidato->requerimiento_id) }}" class="btn btn-sm btn-info"> <i class="fa fa-arrow-circle-right"></i> Ir gestión Req</a>
            </td>
        </tr>
    @endforeach
</table>

<button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>

<div class="panel-group mt-2" id="accordion" role="tablist" aria-multiselectable="true">
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
                    Estudios
                </a>
            </h4>
        </div>

        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                    <div class="container_referencia">
                        <div class="referencia">
                            <table class="table table-bordered tbl_info" style="margin-bottom: 0px;text-align: center;">
                            <thead>
                                <tr>
                                    <th>Nivel Estudios</th>
                                    <th>Institución</th>
                                    <th>Titulo Obtenido</th>
                                    <th>Verificado</th>
                                    <th>Observación</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($estudios as $estudio)
                                <tr>
                                    <td>{{$estudio->nivel_estudio}}</td>
                                    <td>{{$estudio->institucion}}</td>
                                    <td>{{$estudio->titulo_obtenido}}</td>
                                    <td>
                                        @if( $estudio->referencia_estudio->id!=null && $estudio->referencia_estudio->verificado == 0 )
                                            <i class="fa fa-envelope" style="color:#f39c12;"></i>
                                        @elseif($estudio->referencia_estudio->id!=null && $estudio->referencia_estudio->verificado == 1)
                                            <i class="fa fa-check" style="color:green;"></i>
                                        @elseif($estudio->referencia_estudio->id!=null && $estudio->referencia_estudio->verificado == 2)
                                            <i class="fa fa-times" style="color:red;"></i>
                                        @endif
                                    </td>
                                    <td>
                                        @if( $estudio->referencia_estudio->observaciones_referenciante != null )
                                            {{$estudio->referencia_estudio->observaciones_referenciante}}
                                        @endif
                                    </td>
                                    <td>
                                        @if( $estudio->referencia_estudio->id==null )
                                            <a class="btn btn-warning  gestionar_referencia_estudio" data-estudio="{{$estudio->id}}">Gestionar</a>
                                        @elseif($estudio->referencia_estudio->verificado == 0)
                                            <span class="label label-warning">enviado</span>
                                        @elseif( $estudio->referencia_estudio->verificado == 1 )
                                            <span class="label label-success">verificado</span>
                                        @elseif( $estudio->referencia_estudio->verificado == 2 )
                                         <!--<span class="label label-danger">inválido</span>-->
                                         <a class="btn btn-warning editar_referencia_estudio" data-ref_hv="{{$estudio->referencia_estudio->id}}">Editar</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            </table>
                        </div>
                        
                    </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        var ruta = "{{ $redireccion }}";

        $("#cambiar_estado").on("click", function () {
            $.ajax({
                type: "POST",
                data: "ref_id={{ $candidato->ref_id }}",
                url: "{{ route('admin.cambiar_estado_view') }}",
                success: function (response) {
                    console.log("af");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");

                }
            });
        });
    
        $(document).on('change','.empleo_actual',function(){
            if($(this).is(":checked")){
                //si elije q es empleo actual ocultar campo de salario
                $('.ocultar').hide();
            }else{
                $('.ocultar').show();
            }
        });

        $(document).on("click", "#guardar_estado", function () {
            $.ajax({
                data: $("#fr_cambio_estado").serialize(),
                url: "{{route('admin.guardar_cambio_estado')}}",
                success: function (response) {
                    if(response.success){
                        mensaje_success("Estado actualizado");
                        setTimeout(function(){ location.href=ruta; }, 3000);
                    }else{
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            });
        });

        $(".gestionar_referencia_estudio").on("click", function () {
            var estudio = $(this).data("estudio");
            $.ajax({
                type: "POST",
                data: {estudio_id: estudio, ref_id: "{{$candidato->ref_id}}"},
                url: " {{route('admin.gestionar_referencia_estudio')}} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });
        
    
        $(".editar_referencia_estudio").on("click", function (){
            var ref_hv = $(this).data("ref_hv");

            $.ajax({
                type: "POST",
                data: {referencia_estudio_id: ref_hv, ref_id: "{{$candidato->ref_id}}"},
                url: " {{ route('admin.editar_referencia_estudio') }} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                    $("#modal_gr #ref_id").val("{{$candidato->ref_id}}");
                }
            });
        });

    

        $(document).on("click", "#guardar_nueva_referencia_estudio", function () {             
              
            valid =  validar_campos();
            
            if(valid === 1){return false;} //validar si los campos estan llenos
            $(this).prop("disabled",true);
            $.ajax({
                type: "POST",
                data: $("#fr_referencia").serialize(),
                url: "{{route('admin.guardar_referencia_estudio_verificada')}}",
                success: function (response) {
                    $("#guardar_nueva_referencia_estudio").removeAttr("disabled");
                    if(response.success) {
                        $("#modal_gr").modal("hide");
                        mensaje_success("Solicitud de referencia estudio enviada.");
                        window.location.href = "{{route('admin.gestionar_referencia_estudios',[$candidato->ref_id])}}";
                    }else{
                        $("#modal_gr").find(".modal-content").html(response.view);
                    }
                },
                error: function (response) {
                    $("#guardar_nueva_referencia_estudio").removeAttr("disabled");
                    $(document).ready(function(){
                        $(".text").remove();
                    });

                    $.each(response.responseJSON, function(index, val){
                        $('input[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                        $('textarea[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                        $('select[name='+index+']').after('<span  style ="color:red;" class="text">'+val+'</span>');
                    });
                    
                    $("#modal_peq").find(".modal-content").html(response.view);
                }

            })
        });
      
    function validar_campos(){

        i = 0;
        message = "";
        //se validaran los campos de nombre ref*, cargo ref*, fecha inicio*, adecuado*
        c_dos =  $("#correos").val();
        c_tres = $("#fecha_inicio").val();
        c_cuatro = $("#fecha_finalizacion").val();
        c_cinco = $("#nivel_estudio_id").val();
        c_seis = $("#programa").val();
        c_siete = $("#observaciones").val();

        $("#fr_referencia input").css({"border": "1px solid #ccc"});
        $("#fr_referencia select").css({"border": "1px solid #ccc"});
        $("#fr_referencia textarea").css({"border": "1px solid #ccc"});
        $("#fr_referencia .text").remove();

        if(c_dos == "" && $("#solicitar_referencia").is(":checked")){

            message += "Debes escribir al menos un correo \n";

            i=1;

            $("#fr_referencia #correos").css('border', 'solid 1px red');
            $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #correos");

        }
        
        if(c_tres == ""){ message += 'Debes Escribir la fecha de inicio';

            i=1;

            $("#fr_referencia #fecha_inicio").css('border', 'solid 1px red');
            $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #fecha_inicio");
              
        }
            
        if(c_cuatro == "" && !$("#estudio_actual").is(":checked")){ 
            message += 'Debes Escribir la fecha de finalización';

            i=1;

            $("#fr_referencia #fecha_finalizacion").css('border', 'solid 1px red');
            $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #fecha_finalizacion");
                        
        }

        if(c_cinco == ""){
            message += 'Debes seleccionar un nivel de estudio';

            i=1;

            $("#fr_referencia #nivel_estudio_id").css('border', 'solid 1px red');
            $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #nivel_estudio_id");
        }

        if(c_seis == ""){
            message += 'Debes escribir un programa';

            i=1;

            $("#fr_referencia #programa").css('border', 'solid 1px red');
            $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #programa");
        }

        if(c_siete == "" && !$("#solicitar_referencia").is(":checked")){

            message += "Debes escribir una observación \n";

            i=1;

            $("#fr_referencia #observaciones").css('border', 'solid 1px red');
            $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #observaciones");

        }
        
        return i;
      }

    });
</script>
@stop