@extends("admin.layout.master")
@section('contenedor')
    {{-- Header --}}
    <?php
		$cargo=$requerimiento->cargo_especifico()->descripcion;
	?>
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "$datos_candidato->nombres  $datos_candidato->primer_apellido  $datos_candidato->segundo_apellido",'more_info' => "<b>Requerimiento</b> $requerimiento->id | <b>Cargo</b> $cargo"])

    <div class="row pt-2">
        <div class="col-xs-6">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_seleccion == 0) tri-bl-red @elseif($porcentaje_seleccion == 100) tri-bl-green @else tri-bl-yellow @endif tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href={{route('admin.documentos_seleccion', ["candidato" => $candidato, "req" => $req, "req_can" => $candi_req->id])}}>
	                 <div class="inner">
	                 		<div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 				<span class="@if($porcentaje_seleccion == 0) tri-red @elseif($porcentaje_seleccion == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_seleccion}}%</span>
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 tri-py-4 text-center" style="color: gray;">Documentos selección</p>
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
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
					  @if(!$candi_req->bloqueo_carpeta)
						  <div class="btn-group" role="group">
						    <button type="button" class="btn btn-default" id="btn-cerrar-carpeta" data-req_can="{{$candi_req->id}}" data-folder=1>
						    	<i class="fas fa-lock"></i>
						   		 Cerrar
							</button>
						  </div>
					 @endif
					  
				</div>
           </div>

        </div>

        <div class="col-xs-6">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_contratacion == 0) tri-bl-red @elseif($porcentaje_contratacion == 100) tri-bl-green @else tri-bl-yellow @endif tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href={{ route('admin.documentos_contratacion', ["candidato" => $candidato, "req" => $req]) }}>
	                 <div class="inner">
	                        <div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 				<span class="@if($porcentaje_contratacion == 0) tri-red @elseif($porcentaje_contratacion == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_contratacion}}%</span>
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 tri-py-4 text-center" style="color: gray;">Documentos contratación</p>
	                        		<p class="tri-txt-gray-600"></p>
	                 			</div>
	                 		</div>
	                 </div>
	                 
             	</a>
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
						  <div class="btn-group" role="group">
						    <button type="button" class="btn btn-default">
                                &nbsp
							</button>
						  </div>
				</div>
           </div>

        </div>

        <div class="col-xs-6">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_confidencial == 0) tri-bl-red @elseif($porcentaje_confidencial == 100) tri-bl-green @else tri-bl-yellow @endif tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href={{ route('admin.documentos_confidenciales', ["candidato" => $candidato, "req" => $req]) }}>
	                 <div class="inner">
	                        <div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 				<span class="@if($porcentaje_confidencial == 0) tri-red @elseif($porcentaje_confidencial == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_confidencial}}%</span>
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 tri-py-4 text-center" style="color: gray;">Documentos confidenciales</p>
	                        		<p class="tri-txt-gray-600"></p>
	                 			</div>
	                 		</div>
	                 </div>
	                 
             	</a>
                
                <div class="btn-group btn-group-justified" role="group" aria-label="...">
					  <div class="btn-group" role="group">
					    <a type="button" class="btn btn-default">
                            &nbsp
						</a>
					  </div> 
				</div>
           </div>

        </div>

        <div class="col-xs-6">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light @if($porcentaje_post == 0) tri-bl-red @elseif($porcentaje_post == 100) tri-bl-green @else tri-bl-yellow @endif tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href={{ route('admin.documentos_post', ["candidato" => $candidato, "req" => $req])}}>
	                 <div class="inner">
	                        <div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 				<span class="@if($porcentaje_post == 0) tri-red @elseif($porcentaje_post == 100) tri-green @else tri-yellow @endif text-white tri-px-05">{{$porcentaje_post}}%</span>
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 tri-py-4 text-center" style="color: gray;">Documentos post-contratación</p>
	                        		<p class="tri-txt-gray-600"></p>
	                 			</div>
	                 		</div>
	                 </div>
	               
             	</a>

                <div class="btn-group btn-group-justified" role="group" aria-label="...">
					  <div class="btn-group" role="group">
					    <a type="button" class="btn btn-default">
                            &nbsp
						</a>
					  </div>
				</div>
           </div>
        </div>

        <div class="col-xs-6 col-xs-offset-3">
           <div class="small-box bg-aqua | tri-small-box tri-shadow-light tri-bl-yellow tri-transition-300 tri-bg-white">
           		<a class="tri-py-2" href={{ route('admin.documentos_beneficiarios', ["candidato" => $candidato, "req" => $req])}}>
	                 <div class="inner">
	                        <div class="row">
	                 			<div class="col-sm-1" style="height: 110px;" >
	                 			</div>
	                 			<div class="col-sm-11">
	                 				<p class="tri-fs-30 tri-py-4 text-center" style="color: gray;">Documentos beneficiarios</p>
	                        		<p class="tri-txt-gray-600"></p>
	                 			</div>
	                 		</div>
	                 </div>
	               
             	</a>

                <div class="btn-group btn-group-justified" role="group" aria-label="...">
					  <div class="btn-group" role="group">
					    <a type="button" class="btn btn-default">
                            &nbsp
						</a>
					  </div>
				</div>
           </div>
        </div>
    </div>

    <div class="row">
		<div class="col-sm-12 text-right">
			<a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{ session('url_previa') }}" title="Volver">Volver</a>
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

        });


    </script>
@stop