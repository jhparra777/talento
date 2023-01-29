<button 
	type="button" 
	class="eliminar_proceso | md-chip-remove" 

	data-id="{{ $proce->id }}" 
	data-proceso="{{ $proce->proceso }}" 
	data-candidato="{{ mb_strtoupper($candidato_req->nombres ." ".$candidato_req->primer_apellido." ".$candidato_req->segundo_apellido) }}"
	
	data-toggle="tooltip"
	data-placement="top"
	data-container="body"
	title="Eliminar proceso"></button>

{{-- <span 
	type="button"
	class="eliminar_proceso | icon icon--trailing tri-fs-16 tri-cursor-pointer"

	data-id="{{ $proce->id }}" 
    data-proceso="{{ $proce->proceso }}" 
    data-candidato="{{ mb_strtoupper($candidato_req->nombres ." ".$candidato_req->primer_apellido." ".$candidato_req->segundo_apellido) }}"

    data-toggle="tooltip"
	data-placement="top"
	data-container="body"
	title="Eliminar proceso actual">
    <i class="fa fa-times-circle"></i>
</span> --}}