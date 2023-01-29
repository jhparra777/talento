@extends("req.layout.master")
@section('contenedor')

    <style>
        .dropdown-menu{
            left: -80px;
            padding: 0;
        }

        .form-control-feedback{
            display: none !important;
        }

        .smk-error-msg{
            position: unset !important;
            float: right;
            margin-right: 14px !important;
        }
    </style>

    <h3>Candidatos</h3>

    {!! Form::model(Request::all(), ["route" => "req.mis_contratados", "method" => "GET"]) !!}
    
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">@if(route('home') == "https://gpc.t3rsc.co") Nombre del Proceso @else Num Req @endif:</label>

            <div class="col-sm-10">
                {!! Form::text("num_req", null, ["class" => "form-control solo-numero" ]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Cédula:</label>

            <div class="col-sm-10">
                {!! Form::text("cedula", null, ["class" => "form-control solo-numero" ]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Estado:</label>
        
            <div class="col-sm-10">
                {!! Form::select("estado", $estados, null, ["class" => "form-control" ]); !!}
            </div>
        </div>
    
        {!! Form::submit("Buscar", ["class" => "btn btn-success"]) !!}

        <a class="btn btn-danger" href="{{ route("admin.asistente_contratacion") }}">Limpiar</a>
    {!! Form::close() !!}

    <div class="clearfix"></div>
   
    <div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <td>{!! Form::checkbox("seleccionar_todos_candidatos_vinculados",null,false,["id"=>"seleccionar_todos_candidatos_vinculados"]) !!}</td>
                    <th>#REQ</th>
                    <th>CLIENTE</th>
                    <th>CARGO</th>
                    <th>PROCESO</th>
                    <th>IDENTIFICACION</th>
                    <th>NOMBRES</th>
                    <th>MOVIL</th>
                    <th>FECHA INICIO</th>
                    <th>TRAZABILIDAD</th>
                    <th style="text-align: center;" colspan="4">ACCIÓN</th>
                </tr>
            </thead>

            <tbody>
                @if($candidatos->count() == 0)
                    <tr>
                        <td colspan="5">No se encontraron registros</td>
                    </tr>
                @endif

                @foreach($candidatos as $candidato)
                    <tr @if($candidato->asistira == "0") style="background:rgba(210,0,0,.2)" @endif>
                        <td>
                            {!! Form::hidden("req_id", $candidato->req_id) !!}
                            <input
                                class="check_candi"
                                data-candidato_req="{{ $candidato->requerimiento_candidato }}"
                                data-cliente=""
                                name="req_candidato[]"
                                type="checkbox"
                                value="{{ $candidato->requerimiento_candidato }}"
                            >
                        </td>
                        <td>
                            {{ $candidato->req_id }}
                        </td>
                        <td>
                            {{ $candidato->cliente }}
                        </td>
                        <td>
                            {{ $candidato->cargo }}
                        </td>
                        <td>
                            {{ $candidato->tipo_proceso }}
                        </td>
                        <td>
                            {{ $candidato->numero_id }}
                        </td>
                        <td>
                            {{ mb_strtoupper($candidato->nombres ." ".$candidato->primer_apellido." ".$candidato->segundo_apellido) }}
                        </td>
                        <td>
                            {{ $candidato->telefono_movil }}
                        </td>
                        <td>
                            {{ $candidato->fecha_inicio }}
                        </td>
                        
                        <td>
                            @foreach($candidato->getProcesosAsistente($candidato->requerimiento_candidato) as $count => $proce)
                                @if($proce->apto == null and $proce->proceso == "ENVIO_REFERENCIACION")    
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_REF
                                    </div>
            
                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_REFERENCIACION")
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_REF
                                    <div>
                                    
                                        <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_CONTRATACION") 
                                    <div style="text-align: center;" id="respuestas" >
                                        {{ (route("home") == "https://gpc.t3rsc.co") ? 'ENV_APR' : 'ENV_CON' }}
                                    <div>

                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_CONTRATACION") 
                                    <div style="text-align: center;" id="respuestas" >
                                        {{ (route("home") == "https://gpc.t3rsc.co")?'ENV_APR':'ENV_CON' }}<br>
                                        
                                        <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_CONTRATACION") 
                                    <div style="text-align: center;" id="respuestas" >
                                        {{ (route("home") == "https://gpc.t3rsc.co")?'ENV_APR':'ENV_CON'}}
                                    </div>
                                    
                                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->proceso == "CONTR_CANCE") 
                                    <div style="text-align: center;color:red;font-weight: bold;" id="respuestas">
                                        CONTR_CANCE
                                    </div>
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_ENTRE
                                    </div>
                                    
                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_ENTREVISTA")
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_ENTRE
                                    </div>

                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ENTREVISTA") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_ENTRE
                                    </div>

                                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA")
                                    <div style="text-align: center;" id="respuestas" >
                                        ENTRE_TECNI
                                    </div>

                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENTRE_TECNI
                                    </div>
                                        
                                    <hr style="background-color: #d24242;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENTRE_TECNI
                                    </div>

                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBAS") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_PRUE
                                    </div>

                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBAS") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_PRUE
                                    </div>

                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBAS") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_PRUE
                                    </div>

                                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_DOCUMENTOS") 
                                    <div style="text-align: center;" id="respuestas" >
                                        {{ (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") ? 'ENV_EST_SEG' : 'ENV_DOCU' }}
                                    </div>
                                    
                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_DOCUMENTOS")
                                    <div style="text-align: center;" id="respuestas" >
                                        {{ (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") ? 'ENV_EST_SEG' : 'ENV_DOCU' }}
                                    </div>
                                    
                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_EXAMENES") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_EXAME
                                    </div>

                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_EXAMENES") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_EXAME
                                    </div>
                                    
                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_APROBAR_CLIENTE")
                                    <div style="text-align: center;" id="respuestas" >
                                        {{ (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") ? 'ENV_COORD' : 'ENV_CLI' }}
                                    </div>
                                        
                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_APROBAR_CLIENTE") 
                                    <div style="text-align: center;" id="respuestas" >
                                        {{ (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") ? 'ENV_COORD' : 'ENV_CLI' }}
                                    </div>

                                    <hr style="background-color:red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_APROBAR_CLIENTE")
                                    <div style="text-align: center;" id="respuestas" >
                                        {{ (route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") ? 'ENV_COORD' : 'ENV_CLI' }}
                                    </div>
                                    
                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL")
                                    <div style="text-align: center;" id="respuestas">
                                        ENV_ENTRE_VIR
                                    </div>

                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL") 
                                    <div style="text-align: center;" id="respuestas">
                                        ENV_ENTRE_VIR
                                    </div>
                                        
                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_PRUEBA_IDIO
                                    </div>
                                        
                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_PRUEBA_IDIO
                                    </div>
                                        
                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_CITA_CLI
                                    </div>
                                        
                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_CITA_CLI<br>
                                        
                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_EST_SEG
                                    </div>

                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_EST_SEG
                                    </div>

                                    <hr style="background-color:red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD") 
                                    <div style="text-align: center;" id="respuestas" >
                                        ENV_EST_SEG
                                    </div>

                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "FIN_CONTRATACION_VIRTUAL") 
                                    <div style="text-align: center;" id="respuestas" >
                                        FIN_CON_VIR
                                    </div>

                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "FIN_CONTRATACION_MANUAL") 
                                    <div style="text-align: center;" id="respuestas" >
                                        FIN_CON_MAN
                                    </div>

                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "CANCELA_CONTRATACION") 
                                    <div style="text-align: center;" id="respuestas" >
                                        CANC_CON
                                    </div>

                                    <hr style="background-color: red; height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "FIRMA_VIRTUAL_SIN_VIDEOS") 
                                    <div style="text-align: center;" id="respuestas" >
                                        FIRMA_SIN_VIDEOS
                                    </div>

                                    <hr style="background-color: #51beb1; height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @elseif($proce->apto == 1 and $proce->proceso == "CONTRATO_ANULADO") 
                                    <div style="text-align: center;" id="respuestas" >
                                        CONTRATO_ANULADO<br>

                                    <hr style="background-color: #d24242; height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                @endif
                            @endforeach

                            @if($candidato->asistira == "0")
                                <button
                                    style="color:red;padding: 0;"
                                    class="btn cambiar_estado_asistencia"
                                    data-proceso="{{ $candidato->proceso }}"
                                    type="button"
                                    title="Cambiar"
                                >
                                    <i class="fa fa-exclamation-circle" aria-hidden="true" style="color:red; padding: 0;margin:0;" class="alert"></i>
                                    <span>No asistirá</span>
                                </button>
                             @endif
                        </td>

                        <td>
                            <div class="btn-group-vertical" role="group" aria-label="...">
                                {{--<button
                                    type="button"
                                    class="btn btn-primary btn-sm btn-block status"
                                    data-candidato="{{ $candidato->nombres }}"
                                    data-fecha="{{ $candidato->fecha_inicio }}"
                                    data-req="{{ $candidato->req_id }}"
                                    data-observacion="{{ $candidato->observacion }}"
                                    data-user="{{ $candidato->user_envio }}"
                                    data-req_can="{{ $candidato->requerimiento_candidato }}"
                                    data-user_id="{{ $candidato->user_id }}"
                                    data-proceso_cand="{{ $candidato->proceso_candidato_req }}">
                                    Status
                                </button>--}}

                                {{--<div class="btn-group">
                                    <button
                                        type="button"
                                        class="btn btn-info btn-sm btn-block dropdown-toggle"
                                        data-toggle="dropdown"
                                        aria-haspopup="true"
                                        aria-expanded="false"
                                    >
                                        PROCESOS <span class="caret"></span>
                                    </button>

                                    <ul class="dropdown-menu">
                                        <div class="btn-group-vertical" role="group" aria-label="...">
                                            <button
                                                type="button"
                                                data-candidato_req="{{ $candidato->requerimiento_candidato }}"
                                                class="btn btn-info btn-sm btn-block btn-enviar-examenes"
                                                @if($candidato->enviado_examen != null || $candidato->enviado_examen != "") disabled @endif
                                            >
                                                EXAMEN MÉDICO
                                            </button>
        
                                            <!-- Pausar firma de contrato - Anular contrato -->
                                            @if($candidato->firma_digital == 1 && $sitio->asistente_contratacion == 1)
                                                <button
                                                    type="button"
                                                    class="btn btn-info btn-sm btn-block"
                                                    id="pausar_firma"
                                                    data-user_id ="{{ $candidato->user_id }}"
                                                    data-req_id="{{ $candidato->req_id }}"
                                                    data-req_cand_id="{{ $candidato->requerimiento_candidato }}"
                                                    data-cliente="{{ $candidato->cliente_id }}"

                                                    {!!
                                                        ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                                                            $candidato->req_id,
                                                            $candidato->user_id,
                                                            ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"]
                                                        )) ? "disabled title='El contrato ya se encuentra firmado.'" : "")
                                                    !!}

                                                    {!!
                                                        ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                                                            $candidato->req_id,
                                                            $candidato->user_id,
                                                            ["ENVIO_CONTRATACION"]
                                                        )) ? "" : "disabled")
                                                    !!}
                                                >
                                                    {{
                                                        (App\Jobs\FuncionesGlobales::getStateContract($candidato->user_id, $candidato->req_id)) ? "INICIAR FIRMA" : "PAUSAR FIRMA"
                                                    }}
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-warning btn-sm btn-block"
                                                    id="anular_contrato"
                                                    data-user_id ="{{ $candidato->user_id }}"
                                                    data-req_id="{{ $candidato->req_id }}"
                                                    data-req_cand_id="{{ $candidato->requerimiento_candidato }}"
                                                    data-cliente_id="{{ $candidato->cliente_id }}"

                                                    {!!
                                                        ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                                                            $candidato->req_id,
                                                            $candidato->user_id,
                                                            ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"]
                                                        )) ? "" : "disabled")
                                                    !!}
                                                >
                                                    ANULAR CONTRATO
                                                </button>
                                            @endif

                                            <li role="separator" class="divider"></li>

                                            @if($candidato->firma_digital == 1 && $sitio->asistente_contratacion == 1)
                                                <button
                                                    type="submit"
                                                    class="btn btn-info btn-sm btn-block"
                                                    onclick="sendContractFirmForm('{{ route('home.contrato-laboral-recurso', ['user_id' => $candidato->user_id, 'req' => $candidato->req_id]) }}')"
                                                    {!!
                                                        ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                                                            $candidato->req_id,
                                                            $candidato->user_id,
                                                            ["ENVIO_CONTRATACION"]
                                                        )) ? : "disabled = 'disabled'")
                                                    !!}
                                                >
                                                    CONTRATO SIN FIRMAR
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="btn btn-info btn-sm btn-block"
                                                    onclick="sendContractFirmForm('{{ route('home.contrato-laboral-recurso', ['user_id' => $candidato->user_id, 'req' => $candidato->req_id, 'email' => 'true']) }}')"
                                                    {!!
                                                        ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                                                            $candidato->req_id,
                                                            $candidato->user_id,
                                                            ["ENVIO_CONTRATACION"]
                                                        )) ? : "disabled = 'disabled'")
                                                    !!}
                                                >
                                                    EMAIL CONTRATO
                                                </button>

                                                <button
                                                    type="button"
                                                    class="btn btn-info btn-sm btn-block"
                                                    id="reenviar_correo_contrato"
                                                    data-candidato_id ="{{ $candidato->user_id }}"
                                                    data-req_id="{{ $candidato->req_id }}"

                                                    {!!
                                                        ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                                                            $candidato->req_id,
                                                            $candidato->user_id,
                                                            ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"]
                                                        )) ? "disabled" : "")
                                                    !!}
                                                >
                                                    REENVIAR CORREO CONTRA.
                                                </button>

                                                @if (App\Jobs\FuncionesGlobales::getCargoVideo($candidato->cargo_id))
                                                    <!-- Valida si el candidato esta en proceso de firma sin videos -->
                                                    @if (App\Jobs\FuncionesGlobales::getLastProcess($candidato->requerimiento_candidato, $candidato->user_id, $candidato->req_id))
                                                        <li>
                                                            <button
                                                                type="button"
                                                                class="btn btn-info btn-sm btn-block"
                                                                id="btn_recontratar_videos"
                                                                data-candidato_id ="{{ $candidato->user_id }}"
                                                                data-requerimiento_id ="{{ $candidato->req_id }}"
                                                            >
                                                                COMPLETAR VIDEOS CONTRATO
                                                            </button>
                                                        </li>
                                                    @endif
                                                @endif
                                            @endif

                                            <li role="separator" class="divider"></li>

                                            <button
                                                type="button"
                                                class="btn btn-success btn-sm btn-block confirmacion_contratacion"
                                                data-candidato_req="{{ $candidato->requerimiento_candidato }}"
                                                data-req="{{ $candidato->req_id }}"
                                            >
                                                CONFIRMAR CONTRATACIÓN
                                            </button>

                                            <button
                                                type="button"
                                                class="btn btn-danger btn-sm btn-block cancelar_contratacion"
                                                data-candidato_req="{{ $candidato->requerimiento_candidato }}"
                                                data-req="{{ $candidato->req_id }}"

                                                {!!
                                                    ((App\Jobs\FuncionesGlobales::validaBotonProcesosAsistente(
                                                        $candidato->req_id,
                                                        $candidato->user_id,
                                                        ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"]
                                                    )) ? "disabled" : "")
                                                !!}
                                            >
                                                CANCELAR CONTRATACIÓN
                                            </button>

                                            @if($candidato->contratacionCompleta())
                                                <button
                                                    type="button"
                                                    class="btn btn-success btn-sm btn-block finalizar_contratacion"
                                                    data-candidato_req="{{ $candidato->requerimiento_candidato }}"
                                                    data-req="{{ $candidato->req_id }}"
                                                >
                                                    FINALIZAR CONTRATACIÓN
                                                </button>
                                            @endif
                                        </div>
                                    </ul>
                                </div>--}}

                                <a
                                    class="btn btn-warning btn-sm btn-block"
                                    href="{{ route('req.gestion_contratacion', ["candidato" => $candidato->candidato_id, "req" => $candidato->req_id]) }}"
                                >
                                    Gestionar
                                </a>

                                {{--<button
                                    type="button"
                                    class="btn btn-primary btn-sm btn-block orden"
                                    data-candidato="{{ $candidato->nombres }}"
                                    data-fecha="{{ $candidato->fecha_inicio }}"
                                    data-req="{{$candidato->req_id}}"
                                    data-observacion="{{$candidato->observacion}}"
                                    data-user="{{$candidato->user_envio}}"
                                    data-req_can="{{$candidato->requerimiento_candidato}}"
                                    data-proceso_cand="{{$candidato->proceso_candidato_req}}"
                                    data-saludo="hola"
                                >
                                    Orden
                                </button>--}}

                                {{-- Ver paquete de contratación --}}
                                @if(route('home') != "https://gpc.t3rsc.co" && route('home') != "https://asuservicio.t3rsc.co" &&
                                    route('home')!= "https://humannet.t3rsc.co")
                                    @if($user_sesion->hasAccess("admin.paquete_contratacion_pdf"))
                                        <a
                                            class="btn btn-primary btn-sm btn-block"
                                            href="{{ route('admin.paquete_contratacion_pdf', ['id' => $candidato->requerimiento_candidato]) }}"
                                            target="_blank"
                                            data-cliente="{{ $candidato->cliente_id }}"
                                            data-candidato_req="{{ $candidato->requerimiento_candidato }}"
                                        >
                                            ORDEN
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {!! $candidatos->appends(Request::all())->render() !!}
    </div>

    <script>
        $(function () {
            $(".status").on("click", function(){
                req_can = $(this).data("req_can");
                proceso = $(this).data("proceso_cand");
                candidato = $(this).data("candidato");
                requerimiento = $(this).data("req");
                user_id = $(this).data("user_id");

                $.ajax({
                    type: "POST",
                    data: {
                        "req_can" : req_can,
                        "proceso" : proceso,
                        'candidato' : candidato,
                        'requerimiento' : requerimiento,
                        'user_id' : user_id
                    },
                    url: "{{ route('admin.contratacion.status_contratacion') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });
        });
    </script>
@stop
