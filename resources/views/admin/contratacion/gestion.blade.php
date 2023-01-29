@extends("admin.layout.master")
@section('contenedor')
<div>
	@if(!$candi_req->bloqueo_carpeta)
		<div class="row">
	        <div class="col-sm-12" style="text-align: right;">
	            
	             
	            <button type="button" class="btn btn-info status" id="btn-cerrar-carpeta" data-req_can={{$candi_req->id}}>Cerrar carpeta selección</button>
	           
	        </div>
	    </div>
    @endif
	<div class="row">
		<div class="col-sm-6">
			<h2>{{ $datos_candidato->nombres }} {{ $datos_candidato->primer_apellido }} {{ $datos_candidato->segundo_apellido }}</h2>
			<h4><b>#Req:</b> {{ $requerimiento->id }}</h4>
			<h4><b>Cargo:</b> {{ $requerimiento->cargo_especifico()->descripcion }}</h4>
		</div>
	</div>

	<br>

	<div class="row">
		<a href={{route('admin.documentos_seleccion', ["candidato" => $candidato, "req" => $req, "req_can" => $candi_req->id])}}>
			<div class="col-sm-6 col-xs-12">
	            <div class='small-box @if($porcentaje_seleccion == 0) bg-red @elseif($porcentaje_seleccion == 100) bg-green @else bg-yellow @endif' style="padding: 2em 0;">

	                <div class="inner">
	                    <h3 class="text-center"><sup style="font-size: 20px;">Documentos Selección</sup></h3>
					</div>
					@if($candi_req->bloqueo_carpeta)
						<div class="icon" style="margin-top: 20px;">
	                   		<i class="fa fa-lock"></i>
	                	</div>
					@endif


					
	                <div class="icon" style="font-size:  2.5em;">
                   		<i>{{ $porcentaje_seleccion }}%</i>
                	</div>
	            </div>
	        </div>
		</a>

       	<a href={{ route('admin.documentos_contratacion', ["candidato" => $candidato, "req" => $req]) }}>
			<div class="col-sm-6 col-xs-12">
	            <div class='small-box @if($porcentaje_contratacion == 0) bg-red @elseif($porcentaje_contratacion == 100) bg-green @else bg-yellow @endif' style="padding: 2em 0;">
	                <div class="inner">
	                	<h3 class="text-center"><sup style="font-size: 20px;">Documentos Contratación</sup></h3>
					</div>
					
	                <div class="icon" style="font-size:  2.5em;">
                   		<i>{{ $porcentaje_contratacion }}%</i>
                	</div>
	                
	            </div>

	        </div>
		</a>
	</div>

	<div class="row">
		<a href={{ route('admin.documentos_confidenciales', ["candidato" => $candidato, "req" => $req]) }}>
			<div class="col-sm-6 col-xs-12">
	            <div class='small-box @if($porcentaje_confidencial == 0) bg-red @elseif($porcentaje_confidencial == 100) bg-green  @else bg-yellow @endif' style="padding: 2em 0;">
	                <div class="inner">
	                    <h3 class="text-center"><sup style="font-size: 20px;">Documentos Confidenciales</sup></h3>
					</div>

	                <div class="icon" style="font-size:  2.5em;">
                   		<i>{{ $porcentaje_confidencial }}%</i>
                	</div>
	            </div>
	        </div>
		</a>

        <a href={{ route('admin.documentos_post', ["candidato" => $candidato, "req" => $req])}}>
			<div class="col-sm-6 col-xs-12">
	            <div class='small-box @if($porcentaje_post == 0) bg-red @elseif($porcentaje_confidencial == 100) bg-green  @else bg-yellow @endif' style="padding: 2em 0;">
	                <div class="inner">
	                	<h3 class="text-center"><sup style="font-size: 20px;">Documentos post contratación</sup></h3>
					</div>
					
	                <div class="icon" style="font-size:  2.5em;">
                   		<i>{{ $porcentaje_post }}%</i>
                	</div>
	            </div>
	        </div>
        </a>

        
	</div>
	<div class="row">
		<a href={{ route('admin.documentos_beneficiarios', ["candidato" => $candidato, "req" => $req])}}>
			<div class="col-sm-offset-3 col-sm-6 col-xs-12">
	            <div class='small-box bg-yellow' style="padding: 2em 0;">
	                <div class="inner">
	                	<h3 class="text-center"><sup style="font-size: 20px;">Documentos Beneficiarios</sup></h3>
					</div>
					
	                <div class="icon" style="font-size:  2.5em;">
                   		<!--<i>%</i>-->
                	</div>
	            </div>
	        </div>
        </a>
		
	</div>
	<div class="row">
		<div style="text-align: center;">
			<a class="btn btn-warning" href="{{ session('url_previa') }}" title="Volver">Volver</a>
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