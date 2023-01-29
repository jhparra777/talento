{!! Form::open(["route"=>"admin.transferir_dato", "id" => "fr_transferir_candidato_req"]) !!}
    {!! Form::hidden("req_id", (!empty($req_id)) ? $req_id : '' ) !!}
    {!! Form::hidden("tabla_aplicar", $tabla_aplicar) !!}
    {!! Form::hidden("otra_fuente_id", $otra_fuente_id) !!}
    {!! Form::hidden("observacion_ingreso", $observacion_ingreso) !!}
    {!! Form::hidden("modulo_gestion", (!empty($modulo_gestion) ? $modulo_gestion : 'gestion_req')) !!}

    <div class="modal-header">
        <button type="button" class="close cerrar_modal_transferir" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Transferir candidatos desde otro requerimiento</h4>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                @if(count($candidatos_transferir) > 0)
                    <div class="alert alert-info | tri-br-1 tri-blue-2 tri-border--none" role="alert">
                        @if(count($candidatos_transferir) > 1)
                            <i class="fas fa-info-circle"></i> Seleccione los candidatos y los procesos de cada candidato que desea transferir a este requerimiento.
                        @else
                            <i class="fas fa-info-circle"></i> Seleccione los procesos que desea transferir a este requerimiento.
                        @endif
                    </div>
                @endif
                <div class="mt-1">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <?php $tamano = 23; ?>
                                        @if(count($candidatos_transferir) > 1)
                                            {{-- Si es un solo candidato, no se usa esta columna --}}
                                            <th width="6%"></th>
                                            <?php $tamano = 20; ?>
                                        @endif
                                        <th width="54%">Observación</th>
                                        @if(count($candidatos_transferir) > 0)
                                            <th width="{{$tamano}}%">Procesos que se pueden transferir</th>
                                            <th width="{{$tamano}}%">Procesos que no se pueden transferir</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidatos_transferir as $candidato)
                                        <?php
                                            if ($candidato->procesos != null) {
                                                $bloque_proceso = '';
                                                $procesos = [];
                                                $bloque_proceso = explode(', ', $candidato->procesos);
                                                for ($i=0; $i < count($bloque_proceso); $i++) {
                                                    $aux_proc = explode(' | ', $bloque_proceso[$i]);
                                                    $procesos[] = array('proceso' => $aux_proc[0], 'visible' => $aux_proc[1]);
                                                }
                                                $candidato->procesos_candidato = $procesos;
                                            }

                                            if ($candidato->procesos_transferibles != null) {
                                                $bloque_proceso = '';
                                                $procesos = [];
                                                $bloque_proceso = explode(', ', $candidato->procesos_transferibles);
                                                for ($i=0; $i < count($bloque_proceso); $i++) {
                                                    $aux_proc = explode(' | ', $bloque_proceso[$i]);
                                                    $procesos[] = array('proceso' => $aux_proc[0], 'visible' => $aux_proc[1]);
                                                }
                                                $candidato->procesos_trans = $procesos;
                                            }
                                        ?>
                                        <tr>
                                            @if(count($candidatos_transferir) > 1)
                                                <td>
                                                    <div class="tri-checkbox form-group">
                                                        <label>
                                                            <input type="checkbox" name="req_cand_id[]" value="{{$candidato->req_cand}}" class="form-control" required> <span></span>
                                                        </label>
                                                    </div>
                                                </td>
                                            @else
                                                {{-- Si es solo 1 candidato no se muestra el checkbox y se marca la opcion checked para transferir al candidato (si presionan transferir) --}}
                                                <input type="checkbox" name="req_cand_id[]" value="{{$candidato->req_cand}}" checked="checked" hidden="">
                                            @endif
                                            <td class="text-justify">
                                                <?php
                                                    $tipo_doc = ($candidato->tipo_doc_desc != '' && $candidato->tipo_doc_desc != null ? $candidato->tipo_doc_desc : 'Nro. identificación');
                                                    $nombre = ($candidato->primer_nombre != '' && $candidato->primer_nombre != null ? $candidato->primer_nombre : $candidato->nombres);
                                                    $observacion = "El candidato <b>$nombre " . $candidato->primer_apellido . "</b>, $tipo_doc <b>" . $candidato->numero_id . "</b> fue asociado el pasado <b>" . dar_formato_fecha($candidato->fecha_asocio, 'corta') . "</b> por <b>" . $candidato->usuario_asocio . "</b> al requerimiento <b>" . $candidato->requerimiento . "</b> y su estado en ese requerimiento es <b>".$candidato->estado_actual."</b>";
                                                ?>
                                                {!! $observacion !!}
                                            </td>
                                            <td>
                                                @forelse($candidato->procesos_trans as $proceso)
                                                    <div class="tri-checkbox">
                                                        <label>
                                                            <input type="checkbox" name="proceso_req_cand_{{$candidato->req_cand}}[]" value="{{$proceso['proceso']}}"> <span>{{$proceso['visible']}}</span>
                                                        </label>
                                                    </div>
                                                @empty
                                                    <ul>
                                                        <li>No fueron enviados procesos de este tipo</li>
                                                    </ul>
                                                @endforelse
                                            </td>
                                            <td>
                                                <ul>
                                                    @forelse($candidato->procesos_candidato as $proceso)
                                                        <li>
                                                            <span>{{$proceso['visible']}}</span>
                                                        </li>
                                                    @empty
                                                        <li>No fueron enviados procesos de este tipo</li>
                                                    @endforelse
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @foreach($errores_array as $errors)
                                        @if ($errors != "<li>No se agrego el candidato. No tiene actualizada la hoja de vida</li>" && $errors != "<li>No se seleccionaron candidatos.</li>" && $errors != "<li>Se han agregado los candidatos con éxito.</li>" && $errors != '')
                                            <tr>
                                                @if(count($candidatos_transferir) > 1)
                                                    <td></td>
                                                @endif
                                                <td>
                                                    <ul>
                                                        {!! $errors !!}
                                                    </ul>
                                                </td>
                                                @if(count($candidatos_transferir) > 0)
                                                    <td></td>
                                                    <td></td>
                                                @endif
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default cerrar_modal_transferir | tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
        @if(count($candidatos_transferir) > 0)
            <button type="button" class="btn btn-default | text-white tri-br-2 tri-border--none tri-transition-200 tri-green" id="transferir_candidatos_req">Transferir</button>
        @endif
    </div>
{!! Form::close() !!}

<script type="text/javascript">
    $('#transferir_candidatos_req').click(function () {
        if ($('#fr_transferir_candidato_req').smkValidate()) {
            $('#fr_transferir_candidato_req').hide();
            $('#fr_transferir_candidato_req').submit();
        }
    });

    @if ($asocio_candidato)
        //Si se asocio al menos 1 candidato de forma directa, al cerrar el modal de transferir, se recargara la pagina para que se muestre el candidato asignado al Requerimiento (a menos que se haga submit, en ese caso se ejecutara la parte de la transferencia de usuario)
        $("#modalTriLarge").on('hidden.bs.modal', function () {
            setTimeout(function(){
                location.reload();
            }, 3000);
        });
    @endif
</script>