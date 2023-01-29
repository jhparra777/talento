<div class="modal-header alert-warning">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
</div>
<div class="modal-body" id="texto">
	<div style="width: 85%;" class="alert  alert-success">
		<b>Nota: </b>No seleccionar a las personas que estan en la siguiente lista.
	</div>
	Estos candidatos ya han sido enviado a este proceso: 
     @foreach($nombres as $nom)
    <br><b>{{$nom}}</b>
     @endforeach
    
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>