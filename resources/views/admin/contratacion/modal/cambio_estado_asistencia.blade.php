<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
       Confirmar finalización
    </h4>



</div>
<div class="modal-body" id="print">

  <p>¿Seguro que quiere confirmar la asistencia?</p>
</div>
<input type="hidden" name="proceso" id="proceso" value={{$proceso}}>
<input type="hidden" name="respuesta" id="respuesta" value={{$respuesta}}>
<div class="modal-footer">
  <button class="btn btn-default" data-dismiss="modal" type="button">
   <i class="fa fa-close"></i>Cerrar
  </button>
  <button type="button" class="btn btn-success" id="confirmar_cambio_estado_asistencia" >Confirmar</button> 
</div>


<script type="text/javascript">

	 $(function () {
	
$(document).on("click","#confirmar_cambio_estado_asistencia", function () {
                
                
            
                
                $.ajax({
                	 type: "POST",
                    data: {proceso: $("#proceso").val(), respuesta: $("#respuesta").val()},
                    url: "{{route('admin.contratacion.confirmar_cambio estado_asistencia')}}",
                    success: function (response) {
                    $("#modal_peq").modal("show");
                       mensaje_succes("Confirmacion modificada");
                    }
                });

            });

});

</script>