<div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Datos del candidato</h4>
</div>

<div class="modal-body">
     {!! Form::model(Request::all(), ["route" => (!empty($datos["id"])) ? "admin.actualizar_candidato_fuente" : "admin.guardar_candidato_fuente", "id" => "fr_otra_fuente"]) !!}
          {{ csrf_field() }}

          {!! Form::hidden("requerimiento_id", $datos["requerimiento_id"], ["id" => "requerimiento_id"]) !!}
          {!! Form::hidden("cand_otra_id", (!empty($datos["id"])) ? $datos["id"] : "") !!}

          <div class="col-md-12 form-group">
               <label for="cedula" class="col-sm-2 control-label">Cédula <span style="color:red;">*</span></label>
               
               <div class="col-sm-6">
                    {!! Form::text("cedula", (!empty($datos["cedula"])) ? $datos["cedula"] : "", ["class" => "form-control solo-numero input-number", "id" => "cedula", "required" => "required"]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cedula",$errors) !!}</p>
               </div>

               <div class="col-sm-2">
                    <button type="button" class="btn btn-info" id="buscar_candidato" >Buscar</button>
               </div>
               <div class="col-sm-2">
                    <button type="button" class="btn btn-warning" id="limpiar_otra_fuente" style="display: none;">Limpiar</button>
               </div>
          </div>

          <div id="data"></div>
     {!! Form::close() !!}
     
     <div class="clearfix"></div>

     <div class="alert alert-info" style="display: none;" id="asociado">
          <strong>Info!</strong> Este candidato ya está activo en este requerimiento.
     </div>
     @if(isset($email_error))
          <div class="alert alert-info" id="email_error">
               {{$email_error}}
          </div>
     @endif
</div>


<div class="modal-footer">  
     <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar </button>
     <button type="button" class="btn btn-success" id="guardar_candidato_fuente"> Agregar otras fuentes </button>
     <button type="button" class="btn btn-warning" id="asociar_directo" disabled> Asociar al requerimiento </button>
     <button type="submit" class="btn btn-warning" id="asociar_directo_submit">Asociar al requerimiento</button>

     {!! Form::model(Request::all(), ["route" => "admin.agregar_candidato_fuentes", "id" => "fr_asociar_directo"]) !!}
          {{ csrf_field() }}

          {!! Form::hidden("requerimiento_id", $datos["requerimiento_id"], ["id" => "req_id", "form" => "fr_asociar_directo"]) !!}

          <input name="aplicar_candidatos_fuentes[]" type="hidden" value="{{ (!empty($datos['cedula'])) ? $datos['cedula'] : '' }}" id="candidato_a_asociar">

          {!! Form::hidden("cedula", (!empty($datos["cedula"])) ? $datos["cedula"] : "", ["class" => "form-control input-number", "id" => "cedula_otro", "form" => "fr_asociar_directo"]); !!}

          {{--{!! Form::hidden("nombres", (!empty($candidato->nombres)) ? $candidato->nombres : "", ["class" => "form-control", "id" => "nombres_otro", "form" => "fr_asociar_directo"]); !!}--}}

          {!! Form::hidden("primer_nombre", (!empty($candidato->primer_nombre)) ? $candidato->primer_nombre : "", ["class" => "form-control", "id" => "primer_nombre_otro", "form" => "fr_asociar_directo"]); !!}

          {!! Form::hidden("segundo_nombre", (!empty($candidato->segundo_nombre)) ? $candidato->segundo_nombre : "", ["class" => "form-control", "id" => "segundo_nombre_otro", "form" => "fr_asociar_directo"]); !!}

          {!! Form::hidden("primer_apellido", (!empty($candidato->primer_apellido)) ? $candidato->primer_apellido : "", ["class" => "editables form-control", "id" => "primer_apellido_otro", "form" => "fr_asociar_directo"]); !!}

          {!! Form::hidden("segundo_apellido", (!empty($candidato->segundo_apellido)) ? $candidato->segundo_apellido : "", ["class" => "editables form-control", "id" => "segundo_apellido_otro", "form" => "fr_asociar_directo"]); !!}

          {!! Form::hidden("email", (!empty($datos["email"])) ? $datos["email"] : "", ["class" => "form-control", "id" => "email_otro", "form" => "fr_asociar_directo"]); !!}

          {!! Form::hidden("celular", (!empty($candidato->telefono_movil)) ? $candidato->telefono_movil : "", ["class" => "form-control numerico", "id" => "celular_otro", "form" => "fr_asociar_directo"]); !!}

          {!! Form::hidden("tipo_fuente_id", (!empty($candidato->tipo_fuente_id)) ? $candidato->tipo_fuente_id : "", ["class" => "form-control hidden", "id" => "tipo_fuente_otro", "form" => "fr_asociar_directo"]); !!}
     {!! Form::close() !!}
</div>

<script>
    $(function(){
          $("#guardar_candidato_fuente").hide();
          $("#asociar_directo_submit").hide();
          $("#asociar_directo").hide();

          $("#buscar_candidato").click(function(){
               if ($('#fr_otra_fuente').smkValidate()) {
                    var cedula=$("#cedula").val();
                    var req_id=$("#requerimiento_id").val();
                    
                    $.ajax({
                         url: "{{route('admin.ajaxgetcandidato')}}",
                         type: 'POST',
                         data:{ cedula:cedula,req_id:req_id}
                    }).done(function (response) {
                         $("#guardar_candidato_fuente").removeAttr("disabled");
                         $("#asociar_directo").removeAttr("disabled");
                         $('#data').html(response.view);
                         $("#limpiar_otra_fuente").show();
                         
                         if(response.find){
                              if(response.asociado){
                                   $("#asociar_directo").hide();
                                   $("#asociar_directo_submit").hide();
                                   $("#guardar_candidato_fuente").hide();
                                   $("#asociado").show();
                              }
                              else{
                                   $("#asociar_directo").hide();
                                   $("#asociar_directo_submit").show();
                                   $("#candidato_a_asociar").val(response.candidato);
                                   $("#guardar_candidato_fuente").show();
                                   $("#asociado").hide();
                              }
                              
                         }else{
                              $("#asociar_directo").show();
                              $("#asociar_directo_submit").hide();
                              $("#guardar_candidato_fuente").show();
                         }
                    });
               }
          });

          $("#limpiar_otra_fuente").click(function() {
               $("#asociar_directo").hide();
               $("#asociar_directo_submit").hide();
               $("#guardar_candidato_fuente").hide();
               $('#fr_otra_fuente #cedula').val('');
               $('#fr_otra_fuente #cedula').attr('readonly', false);
               $("#limpiar_otra_fuente").hide();
               $("#asociado").hide();
               $('#data').html('');
          });

          $("#fr_otra_fuente").keypress(function(e) {
               if(e.which == 13) {
                    return false;
               }
          });

          $("#asociar_directo_submit").click(function(e){
               if ($('#fr_otra_fuente').smkValidate()) {
                    mensaje_success('Espere mientras se agrega el candidato');
                    $("#cedula_otro").val($("#cedula").val());
                    $("#primer_nombre_otro").val($("#primer_nombre").val());
                    $("#segundo_nombre_otro").val($("#segundo_nombre").val());
                    $("#primer_apellido_otro").val($("#primer_apellido").val());
                    $("#segundo_apellido_otro").val($("#segundo_apellido").val());
                    $("#celular_otro").val($("#celular").val());
                    $("#email_otro").val($("#email").val());
                    $("#tipo_fuente_otro").val($("#tipo_fuente_id").val());
                    $('#fr_asociar_directo').submit();
               }
          });
     })

</script>