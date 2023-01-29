<div class="panel panel-default" style="border-radius: 0 1rem 1rem 1rem;">
    <div class="panel-body">
        <div class="col-sm-12 col-md-5 mb-2">
            <h4 class="tri-fs-14">ESTADOS CANDIDATO</h4>
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover text-center ultima_seleccionada">
                    <thead>
                        <tr>
                            <th>Fecha de Asociación</th>
                            <th>Usuario que lo Asocio</th>
                            <th>Estado del Candidato</th>
                            <th>Proceso</th>
                        </tr>
                    </thead>
            
                    @foreach($estadoCandidato as $estado)
                        <tr>
                            <td>{{$estado->created_at}}</td>
                            <td>{{$estado->usuarioRegistro()->name  }}</td>
                            <td>
                                @if(route("home") == "https://komatsu.t3rsc.co")
                                    {{ ($estado->estado_desc == 'EVALUACION DEL CLIENTE' ) ? 'ENVIADO COORDINADORA SELECCION' : $estado->estado_desc }}
                                @else
                                    {{ $estado->estado_desc }}
                                @endif
                            </td>
                            <td> 
                                @if(route("home") == "https://komatsu.t3rsc.co")
                                    @if($estado->nombre_proceso == 'ENVIO_DOCUMENTOS')
                                        ENV_EST_SEG
                                    @else
                                        {{ ($estado->nombre_proceso == 'ENVIO_APROBAR_CLIENTE' || $estado->nombre_proceso == 'ENVIO_CONTRATACION_CLIENTE' )?'ENVIO_COORDINADORA_SELECCION':$estado->nombre_proceso }}
                                    @endif
                                @else
                                    {{ $estado->nombre_proceso }}
                                @endif
                            </td>

                            {{--
                                @if(isset($estado->asis))
                                    <td>{{(($estado->asis==1)?"Si":"No ha asistido")}}</td>
                                @else
                                    <td>No se ha enviado a la entrevista</td>
                                @endif
                            --}}
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>