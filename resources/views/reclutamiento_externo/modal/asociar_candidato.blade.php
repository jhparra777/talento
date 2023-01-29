<div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     <h4 class="modal-title">Datos del candidato</h4>
</div>

<div class="modal-body">
     {!! Form::model(Request::all(), ["route" => "reclutamiento_externo.guardar_candidato_asociado", "id" => "fr_asociar_candidato","data-smk-icon"=>"glyphicon-remove"]) !!}
          {{ csrf_field() }}

          {!! Form::hidden("req_id", $requerimiento_id, ["id" => "requerimiento_id"]) !!}
          {{--{!! Form::hidden("cand_otra_id", (!empty($datos["id"])) ? $datos["id"] : "") !!}--}}

          <div class="col-md-12 form-group">
               <label for="inputEmail3" class="col-sm-2 control-label">Cédula</label>   
               
               <div class="col-sm-7">
                    {!! Form::text("cedula", "", ["class" => "form-control solo-numero input-number", "id" => "cedula","required"=>true]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cedula",$errors) !!}</p>
               </div>

               <div class="col-sm-3">
                    <button type="button" class="btn btn-info" id="buscar_candidato" >Buscar</button>
               </div>
          </div>

          <div id="data"></div>
     {!! Form::close() !!}
     
     <div class="clearfix"></div>

     <div class="alert alert-info" style="display: none;" id="asociado">
          <strong>Info!</strong> Este candidato ya está registrado.
     </div>
     <div class="alert alert-danger" style="display: none;" id="errores">
          <ul style="list-style: none;" id="list-errors">
               
          </ul>
          
     </div>
</div>


<div class="modal-footer">  
     <button type="button" class="btn btn-default" data-dismiss="modal"> Cerrar </button>
     <button type="button" class="btn btn-success" id="btn_asociar_candidato"> Asociar candidato </button>
     {{--<button type="button" class="btn btn-warning" id="asociar_directo" disabled> Asociar al requerimiento </button>--}}

          
</div>

<script>
    $(function(){
          $("#asociar_directo_submit").hide();
          $("#asociar_directo").hide();
          $("#btn_asociar_candidato").hide();

          $("#buscar_candidato").click(function(){

               

               var cedula=$("#cedula").val();
               var req_id=$("#requerimiento_id").val();
               
               $.ajax({
                    url: "{{route('reclutamiento_externo.ajaxgetcandidato')}}",
                    type: 'POST',
                    data:{ cedula:cedula,req_id:req_id}
               }).done(function (response) {
                    $("#btn_asociar_candidato").removeAttr("disabled");
                    $("#asociar_directo").removeAttr("disabled");
                    $('#data').html(response.view);
                    
                    if(response.find){
                          $("#asociado").show();
                          $("#btn_asociar_candidato").hide();
                         /*if(response.asociado){
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
                         }*/
                         
                    }else{
                         //$("#asociar_directo").show();
                         //$("#asociar_directo_submit").hide();
                         $("#btn_asociar_candidato").show();
                          $("#asociado").hide();
                    }
               });
               //fin smk
          });

          $("#fr_otra_fuente").keypress(function(e) {
               if(e.which == 13) {
                    return false;
               }
          });

          $("#fr_asociar_directo").submit(function(e){
               $(this).prop("disabled",true);// Enable #x
               
               //para enviar los nuevos cambios a agregar otras fuentes
               camposRellenados = true;
               
               //cedula = $("#cedula").val();
               $("#cedula_otro").val($("#cedula").val());
               $("#nombres_otro").val($("#nombres").val());
               $("#primer_apellido_otro").val($("#primer_apellido").val());
               $("#segundo_apellido_otro").val($("#segundo_apellido").val());
               $("#celular_otro").val($("#celular").val());
               $("#email_otro").val($("#email").val());
               $("#tipo_fuente_otro").val($("#tipo_fuente_id").val());

               $("#data .editable").each(function() {
                    var valu = $(this);
                    

                    if(valu.val().length <= 0){
                         camposRellenados = false;
                         $(valu).css('border', 'solid 1px red');
                         $(valu).focus();
                    }
               });

               if(camposRellenados == false) {
                    $(".mensajes").html('Llenar Campos Obligatorios');
                    return false;
               }else{
                    return true;
               }
               
               $(this).prop("disabled",false);
          });
     })

    $(document).on("click", "#btn_asociar_candidato", function(e) {
            e.preventDefault();
            //alert();
            $(this).prop("disabled", false);
            url = $("#fr_asociar_candidato").attr('action');
            
             if($('#fr_asociar_candidato').smkValidate()){

            $.ajax({
                type: "POST",
                data: $("#fr_asociar_candidato").serialize(),
                url:  url,
                error: function (jqXHR, textStatus, data) {
                 //console.log(jqXHR.responseText[0]);
                 var valor = JSON.parse(jqXHR.responseText);
                 var mensaje = "";
                 $.each(valor, function (k, v) {
                  
                  mensaje += k + ": "+ v + " \n\n ";

                 $('select[name='+k+']').after('<span class="text text-danger">'+v+'</span>');

                });
                 //swal("Atencion",mensaje,"warning");
                // $("#modal_gr").modal('toggle');
                 return false;
                },
                success: function(response) {

               if(response.success){
                    $("#modal").modal("hide");
                    $("#errores").hide();
                      $.smkAlert({
                        text: 'Candidato asociado con exito"',
                        type: 'success',
                        position:'top-right',
                        icon:'glyphicon-ok-sign',
                        time:5
                      });
                    

               }
               else{
                    $.each(response.errors, function(index, val){
                        $("#list-errors").append("<li>"+val+"</li>");
                    });
                    $("#errores").show();
               }

                 var candidatos = response.candidatos;



                 {{--if(response.success==false) {
                    mensaje_danger("El candidato ya asociado");
                 }

                    if(response.candidatos == ''){

                        $('#no_hay').show();

                    }else{
                    
                        if(typeof response.editar != 'undefined') {
                            $('#tr_candidato_'+candidatos.id).remove();
                        }

                        var tr = $("<tr id='tr_candidato_"+response.candidatos.id+"'></tr>");

                        tr.append( $("<td> <input name='aplicar_candidatos_fuentes[]' type='checkbox' value="+response.candidatos.cedula+"> </td>") );
                        tr.append($("<td></td>", {text: response.candidatos.cedula}));
                        
                        if(response.candidatos.nombres != ""){
                            tr.append($("<td></td>", {text: response.candidatos.nombres}));
                        }else{
                            tr.append($("<td></td>", {text: response.emptyName}));
                        }

                        tr.append($("<td></td>", {text: response.candidatos.celular}));
                        
                        if(response.hvView == 1){
                            tr.append($("<td>Si</td>"));
                        }else{
                            tr.append($("<td>No</td>"));
                        }

                        vu ="{{url("admin/editar-candidato-fuentes")}}"+"/"+candidatos.id;
                      
                        //console.log(vu);
                        ///////////////////************************** botones editar y eliminar
                        tr.append($("<td><a data-url='"+vu+"' class='btn btn-xs btn-primary edit-fuente' title='Editar Candidato' href='#'><i class='fa fa-pen-square-o'></i></a><a class='bn btn-xs btn-danger elim-fuente' data-url='{{url("admin/eliminar-candidato-fuente")}}/"+candidatos.id+"' title='Eliminar Candidato' href='#''><i class='fa fa-trash'></i></a></td>"));

                        if(response.candidatos.email != ''){
                            tr.append($("<td> <button type='button' class='btn btn-xs btn-info construir_email'> <i class='fa fa-envelope'></i> </button> <input type='hidden' id='id_candidato' value="+response.candidatos.id+"> </td>"));
                        }

                        if(response.candidatos.celular != ''){

                          tr.append($("<td> @if($user_sesion->hasAccess('boton_ws')) <a class='btn btn-xs btn-info' href='https://api.whatsapp.com/send?phone=57"+response.candidatos.celular+"&text=Hola!%20"+candidatos.nombres+"%20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},' target='_blank'> <i class='fa fa-whatsapp'></i> </a> @endif </td>"));

                        }

                        if(response.estado_req == true){
                            $('#botonAgregarCandidato').html('<button class="btn btn-warning" type="submit">Agregar candidatos seleccionados</button>');
                        }

                        if (response.success) {
                            $("#tbl_preguntas tbody").append(tr);
                            
                            mensaje_success("Se ha agregado el candidato con exito.");
                            
                            $("#modal_peq").modal("hide");
                            $("#no_hay").hide();

                            setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);

                        } else {

                             mensaje_success("El candidato ya está en otras fuentes");

                        }
                    } --}}  
                }
            });
          }
        });

</script>