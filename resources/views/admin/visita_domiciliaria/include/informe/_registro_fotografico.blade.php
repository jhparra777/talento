<section>
    <h4>REGISTRO FOTOGRÁFICO DE LA VISITA</h4>
    <div class="registro-fotografico">
    	<div class="fila">
    		<div>
                @if($imagenes["foto_evaluado"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_evaluado]")}}'>
                 @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto evaluado</p>
                

            </div>
    		<div>

                @if($imagenes["foto_evaluado_nucleo"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_evaluado_nucleo]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto núcleo familiar</p>
                
    
                   
            </div>
            <div>

                @if($imagenes["foto_sala"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_sala]")}}'>
                 @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto sala</p>


                  
            </div>
    	</div>
    	<div class="clearfix">
    		
    	</div>
    	<div class="fila">
    		<div>
                @if($imagenes["foto_comedor"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_comedor]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto comedor</p>      
            </div>
    		<div>
                @if($imagenes["foto_cocina"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_cocina]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto cocina</p>      
            </div>
            <div>
                @if($imagenes["foto_habitacion"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_habitacion]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto habitación</p>
            </div>
    	</div>
    	<div class="clearfix">
    	<div class="fila">
    		<div>
                @if($imagenes["foto_nro_apto"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_nro_apto]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto nro apto</p>  
            </div>

    		<div>
                @if($imagenes["foto_direccion"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_direccion]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto dirección</p>      
            </div>
            <div>
                @if($imagenes["foto_fachada"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_fachada]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto fachada</p>
            </div>
    	</div>
    	<div class="clearfix">
    	<div class="fila">
    		<div>
                @if($imagenes["foto_alrededores"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_alrededores]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Foto alrededores</p>      
            </div>
    		<div>
                @if($imagenes["foto_ubicacion_wp"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_ubicacion_wp]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Ubicación Whatsapp</p>      
            </div>
            <div>
                @if($imagenes["foto_ubicacion_maps"]!=null)
                    <img class="img-registro" src='{{asset("recursos_visita_domiciliaria/$visita->visita_candidato_id/img/admin/$imagenes[foto_ubicacion_maps]")}}'>
                @else
                    <div class="no-image">
                        <span>Imagen no cargada</span>
                    </div>
                @endif 
                <p class=pie>Ubicación Maps</p>
            </div>
    	</div>
    	
    	<div class="clearfix">
    	
            </div>
    
  	

</section>

