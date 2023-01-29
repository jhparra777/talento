<button 
	type="button" 
	class="reabrir_proceso | md-chip-reopen"

	data-id="{{ $proce->id }}" 
    data-proceso="{{ $proce->proceso }}" 
    data-candidato="{{ mb_strtoupper($candidato_req->nombres ." ".$candidato_req->primer_apellido." ".$candidato_req->segundo_apellido) }}"
	
	data-toggle="tooltip"
	data-placement="top"
	data-container="body"
	title="Reabrir proceso">
	<i class="fas fa-folder-open text-white tri-fs-12"></i>
</button>

{{-- <span 
	type="button"
	class="reabrir_proceso | icon icon--trailing tri-fs-16 tri-cursor-pointer"

	data-id="{{ $proce->id }}" 
    data-proceso="{{ $proce->proceso }}" 
    data-candidato="{{ mb_strtoupper($candidato_req->nombres ." ".$candidato_req->primer_apellido." ".$candidato_req->segundo_apellido) }}"

    data-toggle="tooltip"
	data-placement="top"
	data-container="body"
	title="Reabrir proceso actual">
    <i class="fa fa-folder-open" aria-hidden="true"></i>
</span> --}}