<div class="col-md-12 mt-4">
    <h3 class="mb-2">Fin de las firmas</h3>

    <div class="alert alert-info" role="alert">
        Te invitamos a continuar con el tercer y último paso del proceso de contratación. Por favor haz <b>clic</b> en el botón <b>"Siguiente paso"</b> para continuar con la confirmación de la contratación en video. Recuerda que todos los pasos son obligatorios para la contratación.
    </div>

    <a type="button" class="btn btn-warning pull-right" href="{{ route('home.confirmar-contratacion-video', [$userIdHash, $firmaContratoHash, $moduloHash]) }}" id="siguientePasoAdicionales">
        Siguiente paso <i class="fa fa-arrow-right" aria-hidden="true"></i>
    </a>
</div>