<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>Trazabilidad del Candidato</strong></h4>
</div>
<div class="modal-body">
    
    <table class="table table-bordered ultima_seleccionada">
        <thead>
            <tr>
                <th>N° Requerimiento</th>
                <th>Estado Usuario en el Requerimiento</th>
                <th>Estado Requerimiento</th>
                <th>Fecha Asociación</th>
                <th>Usuario quien lo asoció</th>
            </tr>
        </thead>
        <tr>
            {{-- {{ dd($reqCandidato) }} --}}
            @if(isset($reqCandidato))
            @foreach($reqCandidato as $reqCandi)
                      <tr>
                          
                        <td>{{ $reqCandi->req_id }}</td>
                        <td>{{ $reqCandi->estado_candidato }}</td>
                        <td>{{$reqCandi->estado_req_id}}</td>
                        <td>{{$reqCandi->fecha_asociacion }}</td>
                        <td>{{$reqCandi->usuario_gestiono_req}}</td>
                      </tr>
            @endforeach
            @endif
        </tr>
    </table>
   
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>