<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><b>Respuestas candidato</b></h4>
</div>

<div class="modal-body">
    <div class="page-header">
        <h5>{{ ucwords($informacion_candidato->nombre_completo) }} <small>({{ $informacion_candidato->total_global }}%)</small></h5>
    </div>
    
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach($preguntas as $index => $pregunta)
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a
                            class="collapsed"
                            role="button"
                            data-toggle="collapse"
                            data-parent="#accordion"
                            href="#collapse-pregunta-{{ $index }}"
                            aria-expanded="false"
                            aria-controls="collapse-pregunta-{{ $index }}"
                            style="cursor: pointer;"
                        >
                            <label>{{ $pregunta->descripcion }} </label>
                            <small><label>{{ ($pregunta->filtro == 1) ? 'Pregunta filtro' : '' }}</label></small> 
                            <small>(Expandir)</small>
                        </a>
                    </h4>
                </div>
                
                <div id="collapse-pregunta-{{ $index }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                                <th>Respuesta</th>
                                <th>Puntaje respuesta</th>
                            </thead>

                            <tbody>
                                @foreach($pregunta->respuestas_candidato_lista($user_id, $pregunta->id) as $respuesta)
                                    <tr>
                                        <td>{{ $respuesta->descripcion }}</td>
                                        <td>{{ $respuesta->puntuacion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>