@extends("admin.layout.master")
@section('contenedor')


	<div class="row">
	    <div class="col-md-12">
	    	<div class="form-alt">
                                        <div class="row">
                                           <div class="form-group col-md-12">
                                            <div style="text-align: center;" class="alert alert-info" role="alert">
                                            <strong>Nota: </strong>A continuación tenemos las dos opciones de prueba que tenemos en el sistema.
                                          </div>
                            
                            <div>
                        
                                <br><br><br>
                               
                            </div>
                            <br>
                            
            
                        </div>
                                        </div>
                                    </div>
	        <div class="box box-info">
                       

	                <h3 class="box-title"></h3>
	                 <div class="row">
        
      {{--   <div class="col-lg-3 col-xs-6">
        <a href="{{route("admin.demostracion_video_entrevista")}}">
                    <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>-</h3>
                    <p>VIDEO ENTREVISTA</p>
                </div>
                <div class="icon">
                   <i class="fa fa-video-camera" aria-hidden="true"></i>

                </div>
            </div>

                </a>
                </div> --}}
                <div class="col-lg-3 col-md-offset-1 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3><i class="fa fa-video-camera"></i><sup style="font-size: 20px"></sup></h3>

              <p>VIDEO ENTREVISTA</p>
            </div>
            <div class="icon">
              <i class="fa fa-video-camera"></i>
            </div>
            <a href="{{route("admin.demostracion_video_entrevista")}}" class="small-box-footer">PRUÉBALO <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      <div class="col-lg-4 col-xs-6">
            <div class="small-box bg-primary">
            <div class="inner">
              <h3><i class="fa fa-user-circle" aria-hidden="true"></i><sup style="font-size: 20px"></sup></h3>

              <p>VIDEO RESPUESTAS</p>
            </div>
            <div class="icon">
              <i class="fa fa-user-circle" aria-hidden="true"></i>

            </div>
            <a href="{{route("admin.demostracion_video_entrevista_respuestas")}}" class="small-box-footer">VER <i class="fa fa-arrow-circle-right"></i></a>
          </div>
          
        </div>

           <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><i class="fa fa-mobile"></i><sup style="font-size: 20px"></sup></h3>

              <p>LLAMADA Y MENSAJE</p>
            </div>
            <div class="icon">
              <i class="fa fa-mobile"></i>
            </div>
            <a href="{{route("admin.demostracion_llamada_mensaje")}}" class="small-box-footer">PRUÉBALO <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>     
        <!-- ./col -->
        
        <!-- ./col -->
    </div>
	            </div>


	           
	            
	        </div>
	    </div>
	</div>

<script>
	 $(function () {




           $(document).on("click", "#enviar_entrevista", function() {
           
            $.ajax({
                type: "POST",
                data: $("#fr_enviar_entrevista_prueba").serialize() + "&enviar=1",
                url: "{{ route('admin.enviar_video_entrevista') }}",
                success: function(response) {
                       
                         mensaje_success("Se ha enviado la solicitud con éxito");
                         //location.reload();
                }
            });
        });



      });
        
    
</script>
@stop