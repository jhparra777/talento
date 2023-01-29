@extends("admin.layout.master")
@section('contenedor')

{{-- Header --}}
	
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Gestión documental cliente $cliente->nombre"])

<div>

	<br>

	<div class="row pt-2">
		@foreach($categorias as $categoria)
		   <div class="col-xs-6 ">
	           <div class="small-box bg-aqua | tri-hover-bd-purple tri-small-box tri-shadow-light  tri-transition-300 tri-bg-white ">
	           		<a class="tri-py-2" href="{{route('admin.gestion_documental.listado_documentos_clientes', ['categoria' => $categoria->id, 'cliente' => $cliente->id])}}">
		                 <div class="inner">
		                 		<div class="row">
		                 			<div class="col-sm-1" style="height: 110px;" >
		                 				{{--<span><i class="fas fa-folder" style="color: gray;"></i></span>--}}
		                 			</div>
		                 			<div class="col-sm-11">
		                 				<p class="tri-fs-30 .tri-py-4 text-center" style="color: gray;">{{$categoria->descripcion}}</p>
		                        		<p class="tri-txt-gray-600"></p>
		                 			</div>
		                 		</div>
		                 		
		                        
		                 </div>
		                 
	             	</a>
	                 	<div class="icon">
	                 		<i class="fas fa-folder"></i>
	             		</div>
	             	
	                 {{--<div class="btn-group btn-group-justified .tri-py-4" role="group" aria-label="...">
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
						  
					</div>--}}
	           </div>
	          </div>
           @endforeach

      
      
	</div>

	
	<div class="row">
		<div class="col-sm-12 text-right">
			<a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{ session('url_previa') }}" title="Volver">Volver</a>
        </div>
	</div>
</div>


@stop