<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Nueva visita domiciliaria
    </h4>
</div>
<div class="modal-body">
    {!! Form::open(["class"=>"form-horizontal", "role"=>"form", "id"=>"fr_nuevaVisita", "files"=>true]) !!}
     {{ csrf_field() }}

        
          

          {!! Form::hidden("visita", 1) !!}
        <div class="row">
            
        
          <div class="col-md-12 form-group">
               <label for="cedula" class="col-sm-2 control-label">Cédula <span style="color:red;">*</span></label>
               
               <div class="col-sm-6">
                    {!! Form::text("cedula", (!empty($datos["cedula"])) ? $datos["cedula"] : "", ["class" => "form-control solo-numero input-number", "id" => "cedula", "required" => "required","placeholder"=>"Cédula de candidato"]); !!}

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
        </div>
       <div class="row" id="datos-visita">
          <fieldset>
            <legend>Datos de la visita</legend>
           {{--  <div class="col-md-12 form-group">
              <label for="cedula" class="col-sm-2 control-label">Tipo de visita <span style="color:red;">*</span></label>
               
               <div class="col-sm-10">
                    {!! Form::select("tipo_visita_id",$tipos_visitas,null, ["class" => "form-control", "id" => "tipo_visita", "required" => "required"]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_visita_id",$errors) !!}</p>
               </div>
           </div> --}}

        <div class="col-md-12 form-group">
             <label for="cedula" class="col-sm-2 control-label">Clase de visita <span style="color:red;">*</span></label>
               
              <div class="col-sm-10">
                  {!! Form::select("clase_visita_id",$clase_visita,null, ["class" => "form-control", "id" => "clase_visita_id", "required" => "required"]); !!}

                  <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("clase_visita",$errors) !!}</p>
              </div>
        </div>

        <div class="col-md-12 form-group">
            <label for="cedula" class="col-sm-2 control-label">Empresa que gestiona <span style="color:red;">*</span></label>
               
            <div class="col-sm-10">
                {!! Form::select("empresa_logo_id",$empresa_logo,null, ["class" => "form-control", "id" => "empresa_logo_id", "required" => "required"]); !!}

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_visita_id",$errors) !!}</p>
            </div>
        </div>
        </fieldset>
      </div>

        
        
        {!! Form::close() !!}

      <div class="alert alert-info" style="display: none;" id="mensaje_info">
          <strong>Info!</strong> Este candidato tiene una visita activa.
     </div>
  
  </div>
  <div class="modal-footer">

     <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar </button>
     <button type="button" class="btn btn-success" id="guardar_visita"> Guardar visita </button>
     
     
  </div>
<div class="mensajeNuevaVisita" style="display: none;">
    <h1>
        Visita
    </h1>
    <span>
        Visita registrada!
    </span>
</div>
<script>
    $(function(){

            $("#datos-visita").hide();
            $("#guardar_visita").hide();
            $("#buscar_candidato").click(function(){
               if ($('#fr_otra_fuente').smkValidate()) {
                    var cedula=$("#cedula").val();
                    var req_id=$("#requerimiento_id").val();
                    
                    $.ajax({
                         url: "{{route('admin.ajaxgetcandidato')}}",
                         type: 'POST',
                         data:{ cedula:cedula,req_id:req_id,visita:1}
                    }).done(function (response) {
                         $("#guardar_candidato_fuente").removeAttr("disabled");
                         $("#asociar_directo").removeAttr("disabled");
                         $('#data').html(response.view);
                         $("#limpiar_otra_fuente").show();
                         
                         if(response.find){
                              
                              if(!response.tiene_visita){
                                $("#datos-visita").show();
                                $("#guardar_visita").show();
                              }
                              else{
                                $("#mensaje_info").show();
                              }
                              
                         }else{
                              $("#datos-visita").show();
                              $("#guardar_visita").show();
                              
                         }
                    });
               }
          });

            $("#guardar_visita").click(function(){
               if ($('#fr_nuevaVisita').smkValidate()) {
                    //var cedula=$("#cedula").val();
                   // var req_id=$("#requerimiento_id").val();
                    
                    $.ajax({
                         url: "{{route('admin.visita.guardar_nueva_visita')}}",
                         type: 'POST',
                         data:$('#fr_nuevaVisita').serialize(),
                         beforeSend: function(){
                    //imagen de carga
                              /*$.blockUI({
                                  message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                                  css: {
                                      border: "0",
                                      background: "transparent"
                                  },
                                  overlayCSS:  {
                                      backgroundColor: "#fff",
                                      opacity:         0.6,
                                      cursor:          "wait"
                                  }
                              });
                              */
                          },
                         success: function(response) {
                            
                            if(response.success){
                              $.smkAlert({
                                text: 'Visita creada con exito',
                                type: 'success',
                                position:'top-right',
                                time:3
                              });
                            $("#modal_gr").modal('toggle');
                            setTimeout(function(){
                             
                             location.reload();
                              }, 3000);
                            

                            }
                         },
                         error: function (jqXHR, textStatus, data) {

                         }

                    });
               }
          });

          $("#limpiar_otra_fuente").click(function() {
               $("#asociar_directo").hide();
               $("#asociar_directo_submit").hide();
               $("#guardar_candidato_fuente").show();
               $('#fr_otra_fuente #cedula').val('');
               $('#fr_otra_fuente #cedula').attr('readonly', false);
               $("#limpiar_otra_fuente").hide();
               $("#asociado").hide();
               $('#data').html('');
               $("#mensaje_info").hide();
          });
    })
</script>
