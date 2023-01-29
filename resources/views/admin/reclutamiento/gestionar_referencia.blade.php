@extends("admin.layout.master")
@section('contenedor')

<h3>Gestionar Referencia</h3>

<h5 class="titulo1">Información Candidato</h5>

<table class="table table-bordered">
    <tr>
        @if (route('home') == 'https://gpc.t3rsc.co')
            <th>CI</th>
        @else
            <th>Cédula</th>
        @endif
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
                       
                      if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co" || route("home") == "http://desarrollo.t3rsc.co"){
                          
                          echo "Tentativo";
                          
                      }else{

                           echo "Pendiente";
                      }

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

<a class="btn btn-danger" target="_black" href="{{route("admin.ficha_pdf",["id"=>$candidato->requerimiento_id])}}">
    Ficha PDF
</a>

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
                    Referencias Laborales
                </a>
            </h4>
        </div>

        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                    <div class="container_referencia">
                        <div class="referencia">
                            <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                            <thead>
                                <tr>
                                    <th>Nombre Empresa</th>
                                    <th>Ciudad</th>
                                    <th>Cargo Desempeñado</th>
                                    <th>Teléfono Empresa</th>
                                    <th>Verificado</th>
                                    <th>Requerimientos</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($experiencias_laborales as $experiencia)
                                <tr>
                                    <td>{{$experiencia->nombre_empresa}}</td>
                                    <td>{{$experiencia->ciudades}}</td>
                                    <td>{{$experiencia->cargo_especifico}}</td>
                                    <td>{{$experiencia->telefono_temporal}}</td>
                                    <td class="text-center">
                                    @if(in_array($experiencia->id ,$req_referencia_gestionado))
                                        <i class="fa fa-check"></i>
                                    @endif
                                    </td>
                                    <td>
                                        @foreach($experiencia->getRequerimientos() as $req)
                                            <div class="badge">
                                                <label>
                                                    {!! Form::radio("ref_gestionada",$req->entidad_id,null,["class"=>"referencias_verificadas"]) !!} 
                                                    <span> Req:{{$req->requerimiento_id}} </span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </td>
                                    <td>
                                    @if(!in_array($experiencia->id ,$req_referencia_gestionado))
                                        <!--
                                            <a class="btn btn-success verficar_referencia" data-ref_hv="{$experiencia->id}}" >Verificado</a>  
                                        -->
                                        <a class="btn btn-warning gestionar_referencia" data-ref_hv="{{$experiencia->id}}">Gestionar</a> 
                                    @else
                                        <a class="btn btn-warning detalle_referencia" data-ref_hv="{{$experiencia->id}}">Editar</a> 
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

        $(".gestionar_referencia").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv, ref_id: "{{$candidato->ref_id}}"},
                url: " {{route('admin.gestionar_referencia_candidato')}} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });
        
        $(".detalle_referencia").on("click", function () {
            var ref_hv = $(this).data("ref_hv");

            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv, ref_id: "{{$candidato->ref_id}}"},
                url: " {{route('admin.editar_referencia_candidato')}} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                    $("#modal_gr #ref_id").val("{{$candidato->ref_id}}");
                }
            });
        });
        
        $(".gestionar_referencia_personal").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv, ref_id: "{{$candidato->ref_id}}"},
                url: " {{ route('admin.gestionar_referencia_personal_candidato') }} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });
        
        $(".editar_referencia_personal").on("click", function (){
            var ref_hv = $(this).data("ref_hv");

            $.ajax({
                type: "POST",
                data: {referencia_id: ref_hv, ref_id: "{{$candidato->ref_id}}"},
                url: " {{ route('admin.editar_referencia_personal_candidato') }} ",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                    $("#modal_gr #ref_id").val("{{$candidato->ref_id}}");
                }
            });
        });

        $(".verficar_referencia").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            var padre = $(this).parents(".requerimientos");
            var id_req = padre.find(".referencias_verificadas:checked").val();
            
            if(id_req == undefined){
                alert("Debe seleccionar un requerimiento.");
            }else{
                $.ajax({
                    type: "POST",
                    data: "referencia_id=" + ref_hv + "&ref_id={{$candidato->ref_id}}&req_id=" + id_req,
                    url: "{{route('admin.verificar_referencia_candidato')}}",
                    success: function (response){
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            }
        });

        $(".verficar_referencia_personal").on("click", function () {
            var ref_hv = $(this).data("ref_hv");
            var padre = $(this).parents(".requerimientos");
            var id_req = padre.find(".referencias_verificadas:checked").val();
            if(id_req == undefined) {
              alert("Debe seleccionar un requerimiento.");
            }else{
                $.ajax({
                    type: "POST",
                    data: "referencia_id=" + ref_hv + "&ref_id={{$candidato->ref_id}}&req_id=" + id_req,
                    url: "{{route('admin.verificar_referencia_personal_candidato')}}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            }
            
        });

        $(document).on("click", "#guardar_nueva_referencia", function () {             
            $(this).prop("disabled",true);
              
            valid =  validar_campos();
            
            if(valid === 1){return false;} //validar si los campos estan llenos

            $.ajax({
                type: "POST",
                data: $("#fr_referencia").serialize(),
                url: "{{route('admin.guardar_referencia_verificada')}}",
                success: function (response) {
                    $("#guardar_nueva_referencia").removeAttr("disabled");
                    if(response.success) {
                        $("#modal_gr").modal("hide");
                        mensaje_success("Referencia Verificada");
                        window.location.href = "{{route('admin.gestionar_referencia',[$candidato->ref_id])}}";
                    }else{
                        $("#modal_gr").find(".modal-content").html(response.view);
                    }
                },
                error: function (response) {
                    $("#guardar_nueva_referencia").removeAttr("disabled");
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

        $(document).on("click", "#guardar_nueva_referencia_personal", function () {
            valid =  validar_campos_per();
            
            if(valid === 1){return false;} //validar si los campos estan llenos
            
            $.ajax({
                type: "POST",
                data: $("#fr_referencia").serialize(),
                url: "{{ route('admin.guardar_referencia_personal_verificada') }}",
                success: function (response) {
                    if(response.success){
                     $("#modal_gr").modal("hide");
                     mensaje_success("Referencia Verificada!!");
                     window.location.href = "{{ route('admin.gestionar_referencia',[$candidato->ref_id])}}";

                    }else{
                      $("#modal_gr").find(".modal-content").html(response.view);
                    }
                }

            })
        });
      
      function validar_campos(){

         i = 0;
         message = "";
         //se validaran los campos de nombre ref*, cargo ref*, fecha inicio*, adecuado*
          c_dos =  $("#nombre_ref").val();
          c_tres = $("#cargo_ref").val();
          c_cuatro = $("#fecha_inicio").val();
          c_cinco = $("#adecuado").val();// if(c_dos.length!=0 && c_tres.length!=0){ //validar solo si se lleno 
            
            if(c_dos == ""){

             message += " Debes Colocar nombre del referenciante \n";

             i=1;

              $("#fr_referencia #nombre_ref").css('border', 'solid 1px red');
              $("#fr_referencia #nombre_ref").focus();
              $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #nombre_ref");

            }
            if(c_tres == ""){ message += 'Debes Escribir el cargo del referenciante';

             i=1;

              $("#fr_referencia #cargo_ref").css('border', 'solid 1px red');
              $("#fr_referencia #cargo_ref").focus();
              $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #nombre_ref");
              
            }
            
            if(c_cuatro == ""){ message += 'Debes Escribir el cargo del referenciante';

              i=1;

               $("#fr_referencia #fecha_inicio").css('border', 'solid 1px red');
               $("#fr_referencia #fecha_inicio").focus();
               $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #fecha_inicio");
                        
            }

            //if(i === 1){ alert(message);}
           // }else{
             // alert('Debes Llenar los campos Obligatorios');
            // i=1;
           // }
          return i;
      }

      function validar_campos_per(){

         i = 0;
         message = "";
         //se validaran los campos de nombre ref*, cargo ref*, fecha inicio*, adecuado*
          c_dos =  $("#encuestado").val();
          c_tres = $("#dificultades").val();
          c_cuatro = $("#observaciones").val();
          //c_cinco = $("#adecuado").val();// if(c_dos.length!=0 && c_tres.length!=0){ //validar solo si se lleno 
            if(c_dos == ""){

             message += " Debes Colocar nombre del referenciante \n";

             i=1;

              $("#fr_referencia #encuestado").css('border', 'solid 1px red');
              $("#fr_referencia #encuestado").focus();
              $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #encuestado");

            }
            if(c_tres == ""){ message += 'Debes Escribir el cargo del referenciante';

             i=1;

              $("#fr_referencia #dificultades").css('border', 'solid 1px red');
              $("#fr_referencia #dificultades").focus();
              $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #dificultades");
              
            }
            
            if(c_cuatro == ""){ message += 'Debes Escribir el cargo del referenciante';

              i=1;

               $("#fr_referencia #observaciones").css('border', 'solid 1px red');
               $("#fr_referencia #observaciones").focus();
               $("<p class='text text-danger'> Debes Llenar este campo </p>").insertAfter("#fr_referencia #observaciones");
                        
            }
            //if(i === 1){ alert(message);}
           // }else{
             // alert('Debes Llenar los campos Obligatorios');
            // i=1;
           // }
          return i;
      }

    });
</script>
@stop