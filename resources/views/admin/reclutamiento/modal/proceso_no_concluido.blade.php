<div class="modal-header alert-warning">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h4 class="modal-title"><span class="fa fa-check-circle "></span> Importante</h4>
</div>
<div class="modal-body" id="texto">

    El candidato <b>{{$candidato->nombres." ".$candidato->primer_apellido}}</b> tiene los siguientes procesos pendientes:
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario Envío</th>
                <th>Proceso</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @foreach($procesoInconclusos as $proceso)
            <tr>

                <td>{{$proceso->usuarioRegistro()->name}}</td>
                <td>
                    @if($proceso->proceso == "ENVIO_VALIDACION")
                    <p>ENVIO VINCULACIÓN</p>
                    @else
                    {{$proceso->proceso}}
                    @endif
                </td>
                <td>{{$proceso->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>