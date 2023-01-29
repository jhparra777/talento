@extends("admin.layout.master")
@section('contenedor')

{{-- Header --}}
	<?php
		$cargo=$requerimiento->cargo_especifico()->descripcion;
	?>
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Gestión documental requerimiento # $requerimiento->id",'more_info' => "<h4> $datos_candidato->nombres  $datos_candidato->primer_apellido  $datos_candidato->segundo_apellido </h4><h4><b>Cargo:</b> $cargo </h4>"])

<div>
	@if(!$candi_req->bloqueo_carpeta)
		{{--<div class="row">
	        <div class="col-sm-12" style="text-align: right;">
	            
	             
	            <button type="button" class="btn btn-info status" id="btn-cerrar-carpeta" data-req_can={{$candi_req->id}}>Cerrar carpeta selección</button>
	           
	        </div>
	    </div>--}}
    @endif
     
	    
	
   
	

	<br>

	<div class="row pt-2">
	   <div class="col-xs-6 col-xs-offset-3">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_seleccion == 0) tri-bl-red @elseif($porcentaje_seleccion == 100) tri-bl-green @else tri-bl-yellow @endif' tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href={{route('admin.gestion_documental.documentos_seleccion_gd', ["candidato" => $candidato, "req" => $req, "req_can" => $candi_req->id])}}>
	                 <div class="inner">
	                 		<div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 				<span class="@if($porcentaje_seleccion == 0) tri-red @elseif($porcentaje_seleccion == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_seleccion}}%</span>
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 .tri-py-4 text-center" style="color: gray;">Carpeta de selección</p>
	                        		<p class="tri-txt-gray-600"></p>
	                 			</div>
	                 		</div>
	                 		
	                        
	                 </div>
	                 
             	</a>
                
             	@if($candi_req->bloqueo_carpeta)
                 <div class="icon">
	                 <i class="fas fa-lock"></i>
	             </div>
                 @endif
                 <div class="btn-group btn-group-justified .tri-py-4" role="group" aria-label="...">
                 	@if($current_user->hasAccess("admin.gestion_documental.descargar_carpeta"))
					  <div class="btn-group" role="group">
					  	
					    <a type="button" class="btn btn-default" href="{{ route('admin.gestion_documental.download_carpeta', [folder=>1]) }}?req_can[]={{$candi_req->id}}">
						   	 <i class="fas fa-download"></i>
						    Descargar
						</a>
					  </div>
					 @endif

					  @if(!$candi_req->bloqueo_carpeta && $current_user->hasAccess("admin.gestion_documental.cerrar_carpeta"))
						  <div class="btn-group" role="group">
						    <button type="button" class="btn btn-default cerrar-carpeta" data-req_can="{{$candi_req->id}}" data-folder=1>
						    	<i class="fas fa-lock"></i>
						   		 Cerrar
							</button>
						  </div>
					 @endif
					  
				</div>
           </div>

      </div>
      <div class="col-xs-6 col-xs-offset-3">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_contratacion == 0) tri-bl-red @elseif($porcentaje_contratacion == 100) tri-bl-green @else tri-bl-yellow @endif' tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href="{{route('admin.gestion_documental.documentos_contratacion_gd', ['candidato' => $candidato, 'req' => $req, 'req_can' => $candi_req->id])}}">
	                 <div class="inner">
	                        <div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 				<span class="@if($porcentaje_contratacion == 0) tri-red @elseif($porcentaje_contratacion == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_contratacion}}%</span>
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 .tri-py-4 text-center" style="color: gray;">Carpeta de contratación</p>
	                        		<p class="tri-txt-gray-600"></p>
	                 			</div>
	                 		</div>
	                 </div>
	                 
             	</a>
                

                 @if($candi_req->bloqueo_carpeta_contratacion)
	                 <div class="icon">
		                 <i class="fas fa-lock"></i>
		             </div>
                 @endif
                 <div class="btn-group btn-group-justified .tri-py-4" role="group" aria-label="...">
                 	@if($current_user->hasAccess("admin.gestion_documental.descargar_carpeta"))
					  <div class="btn-group" role="group">
					    <a type="button" class="btn btn-default" href='{{ route("admin.gestion_documental.download_carpeta", [folder=>2]) }}?req_can[]={{$candi_req->id}}'>
						   	 <i class="fas fa-download"></i>
						    Descargar
						</a>
					  </div>
					  @endif
					  @if(!$candi_req->bloqueo_carpeta_contratacion && $current_user->hasAccess("admin.gestion_documental.cerrar_carpeta"))
						  <div class="btn-group" role="group">
						    <button type="button" class="btn btn-default cerrar-carpeta" data-req_can="{{$candi_req->id}}" data-folder=2>
						    	<i class="fas fa-lock"></i>
						   		 Cerrar
							</button>
						  </div>
					  @endif
					  
				</div>
           </div>

      </div>
      <div class="col-xs-6 col-xs-offset-3">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_confidencial == 0) tri-bl-red @elseif($porcentaje_confidencial == 100) tri-bl-green @else tri-bl-yellow @endif tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href="{{route('admin.gestion_documental.documentos_confidenciales_gd', ['candidato' => $candidato, 'req' => $req, 'req_can' => $candi_req->id])}}">
	                 <div class="inner">
	                        <div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 				<span class="@if($porcentaje_confidencial == 0) tri-red @elseif($porcentaje_confidencial == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_confidencial}}%</span>
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 .tri-py-4 text-center" style="color: gray;">Carpeta confidencial</p>
	                        		<p class="tri-txt-gray-600"></p>
	                 			</div>
	                 		</div>
	                 </div>
	                 
             	</a>
                

                 {{--<div class="icon">
                        <i class="ion ion-eye"></i>
                 </div>--}}
                 <div class="btn-group btn-group-justified .tri-py-4" role="group" aria-label="...">
                 	@if($current_user->hasAccess("admin.gestion_documental.descargar_carpeta"))
					  <div class="btn-group" role="group">
					    <a type="button" class="btn btn-default" href='{{ route("admin.gestion_documental.download_carpeta", [folder=>3]) }}?req_can[]={{$candi_req->id}}'>
						   	 <i class="fas fa-download"></i>
						    Descargar
						</a>
					  </div>
					@endif
					  {{--<div class="btn-group" role="group">
					    <button type="button" class="btn btn-default">
					    	<i class="fas fa-lock"></i>
					   		 Cerrar
						</button>
					  </div>--}}
					  
				</div>
           </div>

      </div>
      <div class="col-xs-6 col-xs-offset-3">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_post == 0) tri-bl-red @elseif($porcentaje_post == 100) tri-bl-green @else tri-bl-yellow @endif' tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href="{{route('admin.gestion_documental.documentos_post_gd', ['candidato' => $candidato, 'req' => $req, 'req_can' => $candi_req->id])}}">
	                 <div class="inner">
	                        <div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 				<span class="@if($porcentaje_post == 0) tri-red @elseif($porcentaje_post == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_post}}%</span>
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 .tri-py-4 text-center" style="color: gray;">Carpeta post-contratación</p>
	                        		<p class="tri-txt-gray-600"></p>
	                 			</div>
	                 		</div>
	                 </div>
	               
             	</a>
                

                 @if($candi_req->bloqueo_carpeta_post)
	                 <div class="icon">
		                 <i class="fas fa-lock"></i>
		             </div>
                 @endif
                 <div class="btn-group btn-group-justified .tri-py-4" role="group" aria-label="...">
                 	@if($current_user->hasAccess("admin.gestion_documental.descargar_carpeta"))
					  <div class="btn-group" role="group">
					    <a type="button" class="btn btn-default" href='{{ route("admin.gestion_documental.download_carpeta", [folder=>4]) }}?req_can[]={{$candi_req->id}}'>
						   	 <i class="fas fa-download"></i>
						    Descargar
						</a>
					  </div>
					@endif
					 @if(!$candi_req->bloqueo_carpeta_post  && $current_user->hasAccess("admin.gestion_documental.cerrar_carpeta"))
					 	@if($candi_req->contratado_retirado)
		                	<div class="btn-group" role="group">
								<button type="button" class="btn btn-default cerrar-carpeta" data-req_can="{{$candi_req->id}}" data-folder=4>
									  <i class="fas fa-lock"></i>
									   		 Cerrar
							    </button>
							</div>
						@endif
					@endif
                 	
					  
					  
				</div>
           </div>

      </div>
	</div>

	
	<div class="row">
		<div class="col-sm-12 text-right">
			<a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{ route('admin.gestion_documental.index') }}" title="Volver">Volver</a>
        </div>
	</div>
</div>

<script>
	$(function(){

		$("#btn-cerrar-carpeta").on("click", function() {


				var req_can=$(this).data("req_can");

                    swal("Cerrar carpeta selección", "Al cerrar esta carpeta no se podrán cargar nuevos documentos ¿Desea cerrar la carpeta sde selección?", "info", {
                    buttons: {
                        cancelar: { text: "No",className:'btn btn-success'
                    },
                    agregar: {
                        text: "Si",className:'btn btn-warning'
                    },
                },
                }).then((value) => {
                    switch(value){
                        case "cancelar":
                         var candidato=$(allPages).find(".check_candi").serialize();
               
                    //var candidato = $("input[name='req_candidato[]']").serialize();

                    //$(this).prop("href","?"+candidato+"&req_id="+req);

                    
                    window.open("{{route('admin.hv_long_list')}}?"+candidato+"&req_id="+req,'_blank');
                   
             
                    //return false;
                        break;
                        case "agregar":
                       	
                       	$.ajax({
			                type: "POST",
			                data: {
			                	req_can:req_can
			                },
			                url: "{{ route('admin.contratacion.status_carpetas') }}",
			                success: function(response) {
			                    
			                    mensaje_success("carpeta cerrada");
			                     setTimeout(() => {
		                            window.location.reload(true);
		                        }, 2000)
			                }
			            });
                        

                        break;
                    }
                });

                

		   });

		$(".cerrar-carpeta").on("click", function() {
		 	
		 	var boton=$(this);
            var req_can_id = $(this).data("req_can");
            var folder = $(this).data("folder");


             swal("Cerrar carpeta", " ¿Desea cerrar esta carpeta?", "info", {
                        buttons: {
                            cancelar: { text: "No",className:'btn btn-warning'
                            },
                            enviar: {
                                text: "Si",className:'btn btn-success'
                            },
                        },
                    }).then((value) => {
                        switch(value){
                            case "cancelar":
                                return false;
                            break;
                            case "enviar":
                                $.ajax({
					                type: "POST",
					                data: {
					                	req_can_id:req_can_id,
					                	folder:folder
					                },
					                url: "{{ route('admin.gestion_documental.close_folder_gestion') }}",
					                success: function(response) {
					                    boton.hide();
					                    $.smkAlert({
				                            text: 'Carpeta cerrada con exito',

				                            type: 'info',
				                            position:'top-right',
				                            time:3
				                        });

					                }
					            });
                            break;
                        }
                    });

         //console.log(id+'//'+cliente);
         
            
        });

		 $(".btn-enviar-examenes").on("click", function() {
		 	
		 	
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

         //console.log(id+'//'+cliente);
         
            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_examenes_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response.view);
                    $("#modal_peq").modal("show");
                }
            });
        });

		  $(document).on("click", "#guardar_examen", function() {
		  	
            var obj = $(this);
            $.ajax({
                type: "POST",
                data: $("#fr_enviar_examen").serialize(),
                url: "{{ route('admin.enviar_examenes') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        mensaje_success("El candidato se ha enviado a exámenes médicos.");
                        obj.prop("disabled", true);
                        var candidato_req = $("#candidato_req_fr").val();
                        $("#grupo_btn_" + candidato_req + "").find(".btn-enviar-examenes").prop("disabled", true);
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            });
        });


		  $(".btn-enviar-estudio").on("click", function() {
		 		alert("Estamos trabajando por usted");
		 	/*
            var id = $(this).data("candidato_req");
            var cliente = $(this).data("cliente");

         //console.log(id+'//'+cliente);
         
            $.ajax({
                type: "POST",
                data: "candidato_req=" + id + "&cliente_id=" + cliente,
                url: "{{ route('admin.enviar_examenes_view') }}",
                success: function(response) {
                    $("#modal_peq").find(".modal-content").html(response.view);
                    $("#modal_peq").modal("show");
                }
            });
            */
       	 });

		   

	});


</script>


@stop