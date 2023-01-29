@extends("admin.layout.master")
@section("contenedor")
<style>
    .dropdown-menu{ left: -80px !important; padding: 0 !important; }

    .form-control-feedback{
        display: none !important;
    }

    .smk-error-msg{
        position: unset !important;
        float: right;
        margin-right: 14px !important;
    }

    .text-center {
        text-align: center;
    }
</style>
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Asistente contratación"])
    <div class="row pt-2">
        @if($sitio->precontrata)
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow | tri-small-box tri-shadow-light tri-bl-yellow tri-transition-300 tri-bg-white">
                    <div class="inner">
                        <h3 class="tri-fs-30 tri-txt-yellow">{{ $contrataciones_pendientes }}</h3>
                        <p class="tri-txt-gray-600">Pendientes por contratar</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-android-attach"></i>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua | tri-small-box tri-shadow-light tri-bl-blue tri-transition-300 tri-bg-white">
                <div class="inner">
                    <h3 class="tri-fs-30 tri-txt-blue">{{ $firmas_pendientes }}</h3>
                    <p class="tri-txt-gray-600">Pendientes por firmar</p>
                </div>

                <div class="icon">
                    <i class="ion ion-edit"></i>
                </div>
            </div>
        </div>
        @if($sitio->precontrata)
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red | tri-small-box tri-shadow-light tri-bl-red tri-transition-300 tri-bg-white">
                    <div class="inner">
                        <h3 class="tri-fs-30 tri-txt-red">{{ $contrataciones_vencidas }}</h3>                      
                        <p class="tri-txt-gray-600">Contrataciones vencidas</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-clock"></i>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>

                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif
    </div>

    {!! Form::model(Request::all(), ["route" => "admin.asistente_contratacion", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="control-label" for="num_req">
                    Número requerimiento:
                </label>

                {!! Form::text("num_req",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 solo-numero", "placeholder" => "Número requerimiento", "id" => "num_req"]); !!}
            
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="cliente_id">
                    Cliente:
                </label>

                {!! Form::select('cliente_id', $clientes, null, ['id'=>'cliente_id', 'class'=>'form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}

            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="cedula">
                    Cédula:
                </label>

                {!! Form::text("cedula",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 solo-numero", "placeholder" => "Cédula", "id" => "cedula"]); !!}
            
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="estado">
                    Estado:
                </label>

                {!! Form::select('estado', $estados, null, [ 'class'=>'form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300', "id" => "estado"]) !!}

            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route('admin.asistente_contratacion') }}">
                    Limpiar
                </a>
            </div>
        </div>
    {!! Form::close() !!}

    {{-- Acciones globales al requerimiento --}}
    <div class="row pt-2">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="tri-fs-16 text-center mb-2">
                        ACCIONES GLOBALES
                    </h4>

                    @include('admin.contratacion.includes.asistente-contratacion._section_acciones_globales')
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="tabla table-responsive">
            <?php
                $configuracion_sst = $sitioModulo->configuracionEvaluacionSst();
                $consentimiento_config = $sitioModulo->configuracionConsentimientoPermiso();
                $dsd = 'asistente';
            ?>
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                {!! Form::checkbox("seleccionar_todos_candidatos_vinculados", null, false, ["id" => "seleccionar_todos_candidatos_vinculados"]) !!}
                            </th>
                            <th>REQ</th>
                            <th>CLIENTE</th>
                            @if( $sitio->multiple_empresa_contrato )
                                <th>EMPRESA CONTRATA</th>
                            @endif
                            <th>CARGO</th>
                            <th>CIUDAD</th>
                            <th>PROCESO</th>
                            <th>IDENTIFICACIÓN</th>
                            <th>NOMBRES</th>
                            <th>%HV</th>
                            <th>MOVIL</th>
                            <th>FECHA INGRESO</th>
                            <th>TRAZABILIDAD</th>
                            <th>ACCIÓN</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($candidatos as $candidato)
                        <?php
                            $processes_collect = collect($candidato->procesos);
                            $processes = $processes_collect->pluck("proceso")->toArray();
                            $processes_apto = $processes_collect->where('apto', '1')->pluck("proceso")->toArray();
                        ?>
                            <tr>
                                <td>
                                    {!! Form::hidden("req_id", $candidato->req_id) !!}
                                    <input
                                        class="check_candi"
                                        data-candidato_req="{{ $candidato->req_can_id }}"
                                        data-cliente=""
                                        name="req_candidato[]"
                                        type="checkbox"
                                        value="{{ $candidato->req_can_id }}"
                                    >
                                </td>
                                <td>
                                    {{ $candidato->req_id }}
                                </td>
                                <td>
                                    {{ $candidato->cliente }}
                                </td>
                                @if( $sitio->multiple_empresa_contrato )
                                    <td>{{$candidato->nombre_empresa_contrata}}</td>
                                @endif
                                <td>
                                    {{ $candidato->cargo }}
                                </td>
                                <td>
                                    {{$candidato->nombre_ciudad}}
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

                                {{-- Porcentaje HV --}}
                                <td>
                                    <?php $porcentaje = FuncionesGlobales::porcentaje_hv($candidato->user_id); ?>
                                    @if($porcentaje != null && isset($porcentaje["total"]) )
                                        {{$porcentaje['total'] }}%
                                    @else
                                        5%
                                    @endif
                                </td>

                                <td>
                                    {{ $candidato->telefono_movil }}

                                    {{-- Boton de whatsapp --}}
                                    <div class="mt-1">
                                        @if($user_sesion->hasAccess("boton_ws"))
                                            <a 
                                                class="btn btn-success | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-green" 
                                                target="blank" 
                                                href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $candidato->telefono_movil }}&text=Hola!%20{{$candidato->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}}."
                                 
                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-container="body"
                                                title="Enviar mensaje a tráves de Whatsapp"
                                            >
                                                <i class="fab fa-whatsapp tri-fs-14" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($candidato->contratacion_directa)
                                        {{ $candidato->fecha_inicio }}
                                    
                                    @else
                                        {{ $candidato->fecha_ingreso }}
                                    
                                    @endif
                                </td>
                                <td>
                                    {{-- Trazabilidad candidato --}}
                                    <?php
                                        //Variables temporales necesarias para la trazabilidad
                                        $candidato_req->numero_id = $candidato->numero_id;
                                        $candidato_req->candidato_id = $candidato->user_id;
                                        $candidato_req->req_candidato_id = $candidato->req_can_id;
                                        $requermiento->id = $candidato->req_id;
                                    ?>
                                    @include('admin.reclutamiento.includes.gestion-requerimiento._section_trazabilidad_gestion', ["procesos" => $processes_collect, "inactiveAllbtn" => true, "gestionaProcesos" => $sitio->gestiona_procesos_asistente])
                                </td>
                                <td>
                                    <div class="btn-group-vertical">
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm btn-block status | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            data-candidato="{{ $candidato->nombres }}"
                                            data-fecha="{{ $candidato->fecha_inicio }}"
                                            data-req="{{ $candidato->req_id }}"
                                            data-observacion="{{ $candidato->observacion }}"
                                            data-user="{{ $candidato->user_envio }}"
                                            data-req_can="{{ $candidato->req_can_id }}"
                                            data-user_id="{{ $candidato->user_id }}"
                                            data-proceso_cand="{{ $candidato->proceso_candidato_req }}"
                                        >
                                            Status
                                        </button>

                                        <div class="btn-group">
                                            <button
                                                type="button"
                                                class="btn btn-info btn-sm btn-block dropdown-toggle | tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                data-toggle="dropdown"
                                                aria-haspopup="true"
                                                aria-expanded="false"
                                                >
                                                PROCESOS
                                                <span class="caret"></span>
                                            </button>

                                            <ul class="dropdown-menu pd-0">
                                                <div class="btn-group-vertical" role="group" aria-label="..." style="width: 100%;">
                                                    
                                                    <button
                                                        type="button"
                                                        data-candidato_req="{{ $candidato->req_can_id }}"
                                                        class="btn btn-default btn-sm btn-block btn-enviar-examenes | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                        @if($candidato->enviado_examen != null || $candidato->enviado_examen != "" || $candidato->estado_candidato==config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') || $candidato->estado_candidato==config('conf_aplicacion.C_CONTRATADO')) disabled @endif
                                                    >
                                                        EXAMEN MÉDICO
                                                    </button>

                                                    @if($sitioModulo->evaluacion_sst === 'enabled')
                                                        @if ($configuracion_sst->envia_evaluacion_asistente == 'si')
                                                            <button
                                                                type="button"
                                                                data-candidato_req="{{ $candidato->req_can_id }}"
                                                                class="btn btn-default btn-sm btn-block btn-enviar-sst | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"

                                                                @if(in_array('ENVIO_SST',$processes) || $candidato->estado_candidato==config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') || $candidato->estado_candidato==config('conf_aplicacion.C_CONTRATADO'))
                                                                disabled
                                                                @endif
                                                            >
                                                                {{ $configuracion_sst->titulo_boton_envio_proceso }}
                                                            </button>
                                                        @endif
                                                    @endif

                                                    @if($sitioModulo->consentimiento_permisos == 'enabled')
                                                        @if($consentimiento_config->envia_proceso_asistente == 'SI')
                                                            <button 
                                                                class="btn btn-default btn-sm btn-block btn_consentimiento_permisos_adic | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                type="button"
                                                                data-candidato_req="{{ $candidato->req_can_id }}"

                                                                @if(in_array('CONSENTIMIENTO_PERMISO',$processes) || $candidato->estado_candidato==config('conf_aplicacion.C_EN_PROCESO_CONTRATACION') || $candidato->estado_candidato==config('conf_aplicacion.C_CONTRATADO'))
                                                                    disabled
                                                                @endif
                                                            >
                                                                {{ $consentimiento_config->titulo_boton_envio_proceso }}
                                                            </button>
                                                        @endif
                                                    @endif

                                                    {{-- Pausar firma de contrato - Anular contrato --}}
                                                    @if($candidato->firma_digital == 1 && $sitio->asistente_contratacion == 1)
                                                        @if($user_sesion->hasAccess("admin.pausar_firma_virtual"))
                                                            <button
                                                                type="button"
                                                                
                                                                class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                id="pausar_firma"
                                                                data-user_id ="{{ $candidato->user_id }}"
                                                                data-req_id="{{ $candidato->req_id }}"
                                                                data-req_cand_id="{{ $candidato->req_can_id }}"
                                                                data-cliente="{{ $candidato->cliente_id }}"
                                                                onclick="pausar_firma_contrato(this)"

                                                                @if(in_array('ENVIO_CONTRATACION',$processes)) @else disabled @endif

                                                                @if(in_array('FIRMA_VIRTUAL_SIN_VIDEOS',$processes) || in_array('FIN_CONTRATACION_VIRTUAL',$processes)) disabled title='El contrato ya se encuentra firmado' @endif
                                                                
                                                            >
                                                                {{
                                                                    (App\Jobs\FuncionesGlobales::getStateContract($candidato->user_id, $candidato->req_id)) ? "INICIAR FIRMA" : "PAUSAR FIRMA"
                                                                }}
                                                            </button>
                                                        @endif
                                                        @if($user_sesion->hasAccess("admin.anular_contratacion_candidato"))
                                                            <button
                                                                type="button"
                                                                
                                                                class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                id="anular_contrato"
                                                                data-user_id ="{{ $candidato->user_id }}"
                                                                data-req_id="{{ $candidato->req_id }}"
                                                                data-req_cand_id="{{ $candidato->req_can_id }}"
                                                                data-cliente_id="{{ $candidato->cliente_id }}"

                                                                {!!
                                                                    ((App\Jobs\FuncionesGlobales::getFirmState(
                                                                        $candidato->user_id,
                                                                        $candidato->req_id
                                                                    )) ? "" : "disabled")
                                                                !!}
                                                            >
                                                                ANULAR CONTRATO
                                                            </button>
                                                        @endif
                                                    @endif

                                                    <li role="separator" class="divider"></li>

                                                    <a 
                                                        type="button" 
                                                        data-req_can_id ="{{$candidato->req_can_id}}"
                                                        class="btn btn-default btn-sm btn-block btn_observaciones | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                        target="_blank">
                                                        OBSERVACIONES
                                                    </a>

                                                    @if($candidato->firma_digital == 1 && $sitio->asistente_contratacion == 1)
                                                        <button
                                                            type="submit"
                                                            class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                            onclick="sendContractFirmForm('{{ route('home.contrato-laboral-recurso', ['user_id' => $candidato->user_id, 'req' => $candidato->req_id]) }}')"

                                                            @if(in_array('ENVIO_CONTRATACION',$processes)) @else disabled @endif
                                                        >
                                                            CONTRATO SIN FIRMAR
                                                        </button>

                                                        <button
                                                            type="submit"
                                                            class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                            onclick="sendContractFirmForm('{{ route('home.contrato-laboral-recurso', ['user_id' => $candidato->user_id, 'req' => $candidato->req_id, 'email' => 'true']) }}')"
                                                            
                                                            @if(in_array('ENVIO_CONTRATACION',$processes)) @else disabled @endif
                                                        >
                                                            EMAIL CONTRATO
                                                        </button>

                                                        <button
                                                            type="button"
                                                            class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                            id="reenviar_correo_contrato"
                                                            data-candidato_id ="{{ $candidato->user_id }}"
                                                            data-req_id="{{ $candidato->req_id }}"

                                                            @if(in_array('ENVIO_CONTRATACION',$processes)) @else disabled @endif

                                                            @if(in_array('FIRMA_VIRTUAL_SIN_VIDEOS',$processes) || in_array('FIN_CONTRATACION_VIRTUAL',$processes)) disabled  @endif

                                                            
                                                        >
                                                            REENVIAR CORREO CONTRA.
                                                        </button>

                                                        @if (App\Jobs\FuncionesGlobales::getCargoVideo($candidato->cargo_id))
                                                            {{-- Valida si el candidato esta en proceso de firma sin videos --}}
                                                            @if (App\Jobs\FuncionesGlobales::getLastProcess($candidato->req_can_id, $candidato->user_id, $candidato->req_id))
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                                    id="btn_recontratar_videos"
                                                                    data-candidato_id ="{{ $candidato->user_id }}"
                                                                    data-requerimiento_id ="{{ $candidato->req_id }}"
                                                                >
                                                                    COMPLETAR VIDEOS CONTRATO
                                                                </button>
                                                            @endif
                                                        @endif
                                                    @endif

                                                    <li role="separator" class="divider"></li>

                                                    <button
                                                        type="button"
                                                        class="btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                        id="confirmacion_contratacion_modal"
                                                        data-candidato_req="{{ $candidato->req_can_id }}"
                                                        data-req="{{ $candidato->req_id }}"
                                                        data-user_id ="{{ $candidato->user_id }}"
                                                    >
                                                        CONFIRMAR CONTRATACIÓN
                                                    </button>
                                                    @if($user_sesion->hasAccess("admin.contratacion.cancelar_contratacion_asistente"))
                                                        <button
                                                            type="button"
                                                            class="btn btn-default btn-sm btn-block cancelar_contratacion | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                            data-candidato_req="{{ $candidato->req_can_id }}"
                                                            data-req="{{ $candidato->req_id }}"
                                                            {!!
                                                                ((App\Jobs\FuncionesGlobales::validaBotonProcesosUltimo(
                                                                    $candidato->req_id,
                                                                    $candidato->user_id,
                                                                    ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"]
                                                                )) ? "disabled" : "")
                                                            !!}
                                                        >
                                                            CANCELAR CONTRATACIÓN
                                                        </button>
                                                    @endif

                                                    @if($candidato->contratacionCompleta())
                                                        <button
                                                            type="button"
                                                            class="btn btn-default btn-sm btn-block finalizar_contratacion | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"
                                                            data-candidato_req="{{ $candidato->req_can_id }}"
                                                            data-req="{{ $candidato->req_id }}"
                                                        >
                                                            FINALIZAR CONTRATACIÓN
                                                        </button>
                                                    @endif
                                                </div>
                                            </ul>           
                                        </div>

                                        <a
                                            class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            href="{{ route('admin.gestion_contratacion', ["candidato" => $candidato->candidato_id, "req" => $candidato->req_id]) }}"
                                        >
                                            Gestionar
                                        </a>

                                        {{--
                                        <button
                                            type="button"
                                            class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                            data-candidato="{{ $candidato->nombres }}"
                                            data-fecha="{{ $candidato->fecha_inicio }}"
                                            data-req="{{$candidato->req_id}}"
                                            data-observacion="{{$candidato->observacion}}"
                                            data-user="{{$candidato->user_envio}}"
                                            data-req_can="{{$candidato->req_can_id}}"
                                            data-proceso_cand="{{$candidato->proceso_candidato_req}}"
                                            data-saludo="hola"
                                        >
                                            Orden
                                        </button>
                                        --}}

                                        {{-- Ver paquete de contratación --}}
                                        @if($user_sesion->hasAccess("admin.paquete_contratacion_pdf"))
                                            <a
                                                class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                href="{{ route('admin.paquete_contratacion_pdf', ['id' => $candidato->req_can_id]) }}"
                                                target="_blank"
                                                data-cliente="{{ $candidato->cliente_id }}"
                                                data-candidato_req="{{ $candidato->req_can_id }}"
                                            >
                                                ORDEN
                                            </a>
                                        @endif

                                        @if(!App\Jobs\FuncionesGlobales::validaBotonProcesosUltimo($candidato->req_id, $candidato->candidato_id, ["FIRMA_VIRTUAL_SIN_VIDEOS", "FIN_CONTRATACION_VIRTUAL"]))
                                            <button 
                                                type="button" 
                                                class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                title="Permite previsualizar el pdf del contrato."
                                                onclick="generateContractPreview('{{ route('home.contrato-laboral-recurso', [$candidato->candidato_id, $candidato->req_id]) }}')"
                                            >
                                                PREVIEW CONTRATO <i class="fa fa-file-text"></i>
                                            </button>
                                        @endif

                                        @if($sitio->precontrata == 1)
                                            <?php 
                                            $datos_procesos=$candidato->getProcesosAsistente($candidato->req_can_id);
                                            $ultimo_proceso = end($datos_procesos); ?>
                                            @if ($candidato->nombre_proceso == 'PRE_CONTRATAR' || $ultimo_proceso->proceso == 'CONTRATO_ANULADO' || $ultimo_proceso->proceso == 'CANCELA_CONTRATACION')
                                                <button
                                                    class="btn btn-primary btn-sm btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                    id="enviar_contratar_asistente"
                                                    data-cliente="{{ $candidato->cliente_id }}"
                                                    data-candidato_req="{{ $candidato->req_can_id }}"

                                                    {!!
                                                        ((App\Jobs\FuncionesGlobales::validaBotonContratar(
                                                            $candidato->req_can_id, 
                                                            [
                                                                config('conf_aplicacion.C_EN_PROCESO_CONTRATACION'),
                                                                config('conf_aplicacion.C_CONTRATADO')
                                                            ]
                                                        ) ? "disabled='disabled'" : ""))
                                                    !!}
                                                >
                                                    CONTRATAR
                                                </button>
                                            @endif
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12">
                                    No se encontraron registros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div>
                {!! $candidatos->appends(Request::all())->render() !!}
            </div>

            {{-- Modal de anulación --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento.modals._modal_anulacion_gestion')

        </div>
    </div>

    <script type="text/javascript">
        
        function updateClock(id_elemento, totalTime) {
            document.getElementById(id_elemento).innerHTML = totalTime;
            if(totalTime > 0){
                totalTime -= 1;
                //console.log(id_elemento + ' ' + totalTime);
                setTimeout("updateClock('"+id_elemento+"', "+totalTime+")",1000);
            }
        }

        function sendContractFirmForm(ruta) {
            $('<form>', {
                "method" : "get",
                "id": "form_contrato_firma",
                "action": ruta
            }).appendTo(document.body).submit();
        }

        function validar_email(email) {
            var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return regex.test(email) ? true : false;
        }

        //Pausar firma contrato
        const pausar_firma_contrato = obj => {
            const user_id  = obj.dataset.user_id
            const req_id   = obj.dataset.req_id
            const cand_req = obj.dataset.req_cand_id
            const cliente  = obj.dataset.cliente

            $.ajax({
                type: "POST",
                url: "{{ route('admin.pausar_firma_virtual') }}",
                data: {
                    user_id : user_id,
                    req_id : req_id,
                    cand_req : cand_req
                },
                beforeSend: function() {
                    mensaje_success('Actualizando estado ...')
                },
                success: function(response) {
                    if(response.success == true){
                        if(response.stand_by == 1){
                            mensaje_success('Firma de contrato pausada')
                            obj.textContent = "INICIAR FIRMA"

                            setTimeout(() => {
                                $("#modal_success").modal("hide")
                            }, 1500)
                        }else if(response.stand_by == 0){
                            //Si la firma está pausada
                            setTimeout(() => {
                                $("#modal_success").modal("hide")
                            }, 1500)

                            //Solicitud de modal para actualizar datos
                            $.ajax({
                                type: "POST",
                                data: {
                                    candidato_req : cand_req,
                                    cliente : cliente,
                                    user_id : user_id,
                                    req_id : req_id
                                },
                                url: "{{ route('admin.editar_informacion_contrato') }}",
                                success: function(response) {
                                    $("#modalTriLarge").find(".modal-content").html(response)
                                    $("#modalTriLarge").modal("show")
                                    $("#modalTriLarge").css("overflow-y", "scroll")
                                }
                            });

                            //mensaje_success('Firma de contrato iniciada');
                            obj.textContent = "PAUSAR FIRMA"
                        }
                    }else if(response.firmado == true){
                        mensaje_danger('El contrato ya se encuentra firmado.')
                    }else{
                        mensaje_danger('Ha ocurrido un error, intenta nuevamente.')
                    }
                }
            });
        }

        $(function () {

            $('.js-example-basic-single').select2({
                placeholder: 'Selecciona o busca un cliente'
            });

             $(document).on("click", ".btn_observaciones", function() {

            //var req_id = $(this).data("req_id");
            //var user_id = $(this).data("user_id");
            var id = $(this).data("req_can_id");
            //var cliente = $(this).data("cliente");
            
            $.ajax({
                type: "POST",
                data:    "candidato_req=" + id,
                url: "{{ route('admin.crear_observacion') }}",
                success: function(response) {
                    $("#modalTriLarge").modal("hide");
                    $("#modalTriLarge").find(".modal-content").html(response);
                    $("#modalTriLarge").modal("show");
                }
            });
        });

        $(document).on("click", "#guardar_observacion", function() {
            $(this).prop("disabled",true);
            var btn_id = $(this).prop("id");

            setTimeout(function(){
                $("#"+btn_id).prop("disabled",false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_observacion_req").serialize(),
                url: "{{ route('admin.guardar_observacion') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_gr").modal("hide");
                        alert("Se ha creado la observación con éxito!");
                        //window.location.href = '{{route("req.mis_requerimiento")}}';
                    } else {
                        //mensaje_success("El requerimiento ya se encuentra cerrado");
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }

                }
            });
        });


            $(document).on("click", "#btn_recontratar_videos", function() {
                var user_id = $(this).data("candidato_id");
                var req_id = $(this).data("requerimiento_id");

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.reenviar_correo_video_confirmacion') }}",
                    data: {
                        user_id : user_id,
                        req_id : req_id
                    },
                    beforeSend: function() {
                        mensaje_success('Enviando correo con enlace ...');
                    },
                    success: function(response) {
                        if(response.success == true){
                            mensaje_success('Correo enviado correctamente a la dirección '+ response.email);
                        }else{
                            mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                        }
                    }
                });
            });


            $(document).on("click", "#llamada_virtual", function() {
                var candidatos_llamar = 0;
                $(".check_candi").each(function (id, item) {
                    if (item.checked) {
                        candidatos_llamar++;
                        $('#bloque_candidatos_llamar').append('<input type="hidden" name="candidatos_llamar[]" value="'+item.value+'"/>')
                    }
                })
                if (candidatos_llamar > 0) {
                    $( "#fr_candidatos" ).submit();
                } else {
                    mensaje_danger("Debe seleccionar 1 o mas candidatos");
                }
            })

            //Guardar datos editados el contrato pausado
            $(document).on("click", "#confirmar_informacion_contratacion", function() {
                if($('#fr_informacion_contratacion').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_informacion_contratacion").serialize(),
                        url: "{{ route('admin.guardar_informacion_contratacion') }}",
                        beforeSend: function(){
                            mensaje_success("Espere mientras se carga la información");
                        },
                        success: function(response){
                            if (response.success) {
                                $("#modal_peq").modal("hide");

                                mensaje_success("La información se ha editado correctamente y el contrato ha sido iniciado nuevamente.");

                                setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                                setTimeout(function(){ location.reload(); }, 2000);
                            } else {
                                $("#modal_success .close").click();
                                $("#modal_success").modal("hide");

                                $("#modal_peq").find(".modal-content").html(response.view);

                                $("#modal_peq").css("overflow-y", "scroll");
                            }
                        },
                        error: function(){
                            $("#modal_peq .close").click();
                            $("#modal_success .close").click();
                            mensaje_danger("Ha ocurrido un error. Verifique los datos.");
                        }
                    })
                }
            });
            //

            $(document).on('click', "#anular_contrato", function () {
                $("#modal_anulacion").modal("show");

                const user_id = $(this).data("user_id");
                const req_id = $(this).data("req_id");
                const cand_req = $(this).data("req_cand_id");
                const cliente_id = $(this).data("cliente_id");

                $('#anular_user_id').val(user_id);
                $('#anular_req_id').val(req_id);
                $('#anular_cand_req').val(cand_req);
                $('#anular_cliente_id').val(cliente_id);
            });

            $(document).on("click", "#anular_contrato_frm", function() {
                let cand_req = $('#anular_cand_req').val();
                let cliente_id = $('#anular_cliente_id').val();

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.anular_contratacion_candidato') }}",
                    data: $('#fr_anular').serialize(),
                    beforeSend: function() {
                        mensaje_success('Anulando contrato, está acción puede tardar. Aguarde ...');
                    },
                    success: function(response) {
                        if(response.success == true){
                            mensaje_success('Contrato anulado correctamente');
                            
                            setTimeout(() => {
                                $("#modal_peq").modal("hide");
                                $("#modal_success").modal("hide");
                                $("#modal_anulacion").modal("hide");
                            }, 1000)

                            setTimeout(() => {
                                window.location.reload(true)
                            }, 1500)
                            
                            /*
                                $.smkConfirm({
                                    text:'¿Deseas enviar a contratar nuevamente al candidat@?',
                                    accept:'Aceptar',
                                    cancel:'Cancelar'
                                },function(res){
                                    if (res) {
                                        //Llamar función con todo
                                        enviar_a_contratar(cand_req, cliente_id)
                                    }else {
                                        //Cerrar modal y ya :v
                                        window.location.reload(true);
                                    }
                                })
                            */
                        }else{
                            mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                        }
                    }
                });
            });

            //Carga modal con información de contratación
            const enviar_a_contratar = (cand_req, cliente) => {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.reenviar_a_contratar') }}",
                    data: {
                        candidato_req : cand_req,
                        cliente_id : cliente
                    },
                    beforeSend: function() {
                        mensaje_success('Cargando información ...')
                        setTimeout(() => {
                            $("#modal_success").modal("hide")
                        }, 1000)
                    },
                    success: function(response) {
                        if(response){
                            $("#modal_peq").find(".modal-content").html(response);
                            $("#modal_peq").modal("show");
                            $("#modal_peq").css("overflow-y", "scroll");
                        }else{
                            mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                        }
                    }
                })
            }

            $(document).on("click", "#confirmar_contratacion_re", function() {
                if($('#fr_contratar').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_contratar").serialize(),
                        url: "{{ route('admin.reenviar_a_contratar_proceso') }}",
                        beforeSend: function(){
                            mensaje_success("Espere mientras se carga la información");
                        },
                        error: function(){
                            $("#modal_peq .close").click();
                            $("#modal_success .close").click();

                            mensaje_danger("Ha ocurrido un error, verifique los datos.");
                        },
                        success: function(response){
                            if(response.success) {
                                $("#modal_peq").modal("hide");

                                mensaje_success("El candidato se ha enviado a {{(route('home') == 'https://gpc.t3rsc.co')?'aprobar':'contratar'}}.");

                                setTimeout(function(){
                                    $("#modal_success").modal("hide");
                                    window.location.reload(true);
                                }, 1000);

                            } else {
                                $("#modal_success .close").click();
                                $("#modal_success").modal("hide");
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").css("overflow-y","scroll");
                            }
                        }
                    });
                }
            });

            $(document).on("click", "#reenviar_correo_contrato", function() {
                var user_id = $(this).data("candidato_id");
                var req_id = $(this).data("req_id");

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.reenviar_correo_contratacion') }}",
                    data: {
                        user_id : user_id,
                        req_id: req_id
                    },
                    beforeSend: function() {
                        mensaje_success('Enviando ...');
                    },
                    success: function(response) {
                        if(response.success == true){
                            mensaje_success('Correo reenviado correctamente a la dirección '+ response.email);
                        }else{
                            mensaje_danger('Ha ocurrido un error, intenta nuevamente.');
                        }
                    }
                });
            });

            $(document).on("click", ".cambiar_estado_asistencia", function () {
                var proceso = $(this).data("proceso");

                $.ajax({
                    data: {proceso: proceso, respuesta: "si"},
                    url: "{{route('admin.contratacion.cambiar estado_asistencia')}}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", ".asignar_psicologo", function () {
                var req_id = $(this).data("req_id");
                var cliente_id = $(this).data("cliente_id");

                $.ajax({
                    data: {req_id: req_id, cliente_id: cliente_id},
                    url: "{{route('admin.asignar_psicologo')}}",
                    success: function (response) {
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_asignacion", function () {
                $(this).prop("disabled", false)

                $.ajax({
                    type: "POST",
                    data: $("#fr_asig").serialize(),
                    url: "{{ route('admin.asignar_psicologo_guardar')}}",
                    success: function(response) {
                        if(response.success){
                            $("#modal_peq").find(".modal-content").html(response.view);
                            $("#modal_peq").modal("show");
                            $("#modal_peq").modal("hide");
                            mensaje_success("Asignación realizada");
                            location.reload();
                         }else{
                            $("#modal_peq").find(".modal-content").html(response.view);
                            $("#modal_peq").modal("show");
                            $("#modal_peq").modal("hide");
                            mensaje_danger("Ya se le hizo la asignación al analista");
                        }
                    }
                });
            });

            $(document).on("click", ".orden", function(){

                req_can=$(this).data("req_can");
                proceso=$(this).data("proceso_cand");
                
                $.ajax({
                    type: "POST",
                    data: {
                        "req_can":req_can,
                        "proceso":proceso
                    },
                    url: "{{ route('admin.contratacion.detalle_orden') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", ".status", function(){
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
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });

            /* Modal de envío de documentos */
            $(document).on("click", "#confirmacion_contratacion_modal", function(){
                var dato = $(this).data('candidato_req');

                $.ajax({
                    type: "POST",
                    data: {
                        req : $(this).data("req"),
                        candidato_req : $(this).data('candidato_req'),
                        user_id : $(this).data('user_id'),
                    },
                    url: "{{ route('admin.contratacion.confirmacion_contratacion_asistente') }}",
                    success: function (response) {
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });

            function enviarDocumentos() {
                $.ajax({
                    type: "POST",
                    data: $("#form_contratacion").serialize(),
                    url: "{{ route('admin.envio_documentos_contratacion') }}",
                    beforeSend: function(response) {
                        $("#modalTriLarge").modal("hide");
                        $.smkAlert({
                            text: 'Enviando confirmación de contratación ...',
                            type: 'info',
                            icon: 'glyphicon-info-sign'
                        });
                    },
                    success: function(response) {
                        if (response.success) {
                          $("#modalTriLarge").modal("hide");

                          mensaje = "Confirmación de contratación enviada a los siguientes correos:";

                          $.each(response.correos, function (i,val) {
                            mensaje += ' '+val.email+',';
                          });

                           mensaje+="<br/>"+response.otros;

                           if (response.candidato_email != '') {
                               mensaje+="<br/>"+response.candidato_email;
                           }

                           mensaje_success(mensaje);

                            $.smkAlert({
                                text: 'Confirmación de contratación enviada correctamente',
                                type: 'success',
                            });

                            //mensaje_success("Confirmación de contratación enviada");
                        } else {
                            $("#modalTriSmall").find(".modal-content").html(response.view);
                        }
                    },
                    error: function(response){
                        $.smkAlert({
                            text: 'Ha ocurrido un error inesperado, intente nuevamente.',
                            type: 'danger',
                        });
                    }
                });
            }

            /* Envío de documentos al cliente */
            $(document).on("click", "#enviar_confirmacion_contratacion_modal", function() {
                if (! $('#form_contratacion').smkValidate() || ($('input[name="documentos[]"]:checked').length === 0 && ! $('#carnet').prop('checked'))) {
                    //Sino selecciono ningun documento o sino existen documentos; se pregunta si desea enviar el correo
                    swal("Sin documentos por enviar", " ¿Desea enviar el correo sin documentos?", "info", {
                        buttons: {
                            cancelar: { text: "No",className:'btn btn-warning'
                            },
                            enviar: {
                                text: "Si",className:'btn btn-success'
                            },
                        },
                    }).then((value) => {
                        switch(value){
                            case "cancelar":
                                return false;
                            break;
                            case "enviar":
                                enviarDocumentos();
                            break;
                        }
                    });
                } else {
                    enviarDocumentos();
                }
            });

            $(document).on("click" ,".cancelar_contratacion", function(){
                var dato = $(this).data('candidato_req');

                $.ajax({
                    type: "POST",
                    data: {
                        req: $(this).data("req"),
                        dato: $(this).data('candidato_req')
                    },
                    url: "{{ route('admin.contratacion.cancelar_contratacion_asistente') }}",
                    success: function (response) {
                        $("#modalTriSmall").find(".modal-content").html(response);
                        $("#modalTriSmall").modal("show");
                    }
                });
            });

            $(document).on("click", ".finalizar_contratacion", function(){
                var dato = $(this).data('candidato_req');

                $.ajax({
                    type: "POST",
                    data: {
                     req: $(this).data("req"), dato:$(this).data('candidato_req')
                    },
                    url: "{{ route('admin.contratacion.finalizar_contratacion_asistente') }}",
                    success: function (response) {
                        mensaje_success("Contratación finalizada");
                    }
                });

            });

            $(".btn-enviar-examenes").on("click", function() {
            
                var id = $(this).data("candidato_req");
                var cliente = $(this).data("cliente");         
         
                $.ajax({
                    type: "POST",
                    data: "candidato_req=" + id + "&cliente_id=" + cliente,
                    url: "{{ route('admin.enviar_examenes_view') }}",
                    success: function(response) {
                        $("#modalTriLarge").find(".modal-content").html(response.view);
                        $("#modalTriLarge").modal("show");
                    }
                });

            });

            $(document).on("click", "#guardar_examen", function() {
            
                if($('#proveedor').val() === ""){
                    $('#proveedor_med_text').show();
                }else{
                    
                    var obj = $(this);

                    $.ajax({
                        type: "POST",
                        data: $("#fr_enviar_examen").serialize(),
                        url: "{{ route('admin.enviar_examenes') }}",
                        success: function(response) {
                            if (response.success) {
                                $("#modal_peq").modal("hide");
                                mensaje_success("El candidato se ha enviado a exámenes médicos.");
                                obj.prop("disabled", true);
                                var candidato_req = $("#candidato_req_fr").val();
                                $(".this").prop("disabled", true);
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                            }
                        }
                    });
                }

            });

            //---
            $(".btn-enviar-estudio").on("click", function() {
            
                var id = $(this).data("candidato_req");
                var cliente = $(this).data("cliente");         
         
                $.ajax({
                    type: "POST",
                    data: "candidato_req=" + id + "&cliente_id=" + cliente,
                    url: "{{ route('admin.enviar_estudio_seguridad_view') }}",
                    success: function(response) {
                        $("#modal_gr").find(".modal-content").html(response.view);
                        $("#modal_gr").modal("show");
                    }
                });

            });

            $(document).on("click", "#guardar_estudio_seguridad", function() {
                
                if($('#proveedor_seg').val() === ""){
                    $('#proveedor_seg_text').show();
                }else{
                    var obj = $(this);
                    $.ajax({
                        type: "POST",
                        data: $("#fr_enviar_estudio_seg").serialize(),
                        url: "{{ route('admin.enviar_estudio_seguridad') }}",
                        success: function(response) {
                            if (response.success) {
                                $("#modal_peq").modal("hide");
                                mensaje_success("El candidato se ha enviado a estudios de seguridad.");
                                obj.prop("disabled", true);
                                var candidato_req = $("#candidato_req_fr").val();
                                $("#grupo_btn_" + candidato_req + "").find(".btn-enviar-estudio").prop("disabled", true);
                                location.reload();
                            } else {
                                $("#modal_peq").find(".modal-content").html(response.view);
                            }
                        }
                    });
                }

            });
            //---

            $(".btn-enviar-examenes-masivos").on("click", function() {
           
                if ($("input[name='req_candidato[]']").serialize() != "") {
                    $.ajax({
                        type: "POST",
                        data: $("input[name='req_candidato[]']").serialize(),
                        url: "{{ route('admin.enviar_examenes_masivo') }}",
                        success: function(response) {
                            $("#modalTriSmall").find(".modal-content").html(response);
                            $("#modalTriSmall").modal("show");
                        }
                    });
                } else {
                    mensaje_danger("Debe seleccionar 1 o mas candidatos");
                }

            });

            $(document).on("click", "#confirmar_examenes_masivo", function() {
                if($('#fr_exam_masi').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_exam_masi").serialize(),
                        url: "{{ route('admin.confirmar_examenes_masivo') }}",
                        beforeSend: function(){
                            $("#modal_peq").modal("hide");
                            //imagen de carga
                            $.blockUI({
                                message: '<img src="http://www.fundacionprotejer.com/wp-content/plugins/filtros/img/loading.gif">', 
                                css: { 
                                    border: "0",
                                    background: "transparent"
                                },
                                overlayCSS:  { 
                                    backgroundColor: "#fff",
                                    opacity:         0.6, 
                                    cursor:          "wait" 
                                }
                            });
                        },
                        success: function(response) {
                            $.unblockUI();
                            if(response.success) {
                                var mensaje = 'Se han enviado a los candidatos satisfactoriamente.';
                                if (response.candidatos_no_enviados.length > 0) {
                                    mensaje += "<br>Pero " + response.candidatos_no_enviados.length + " candidatos ya se encuentran en proceso de exámenes médicos y no se han enviado:<br>";
                                    response.candidatos_no_enviados.forEach(function(cand, index) {
                                        mensaje += '<b>' + cand + '</b>';
                                        if (response.candidatos_no_enviados.length - 1 > index) {
                                            mensaje += ' - ';
                                        }
                                    });
                                }
                                mensaje_success(mensaje);
                                setTimeout(function(){
                                    location.reload();
                                }, 10000);
                            }else{
                                $("#modal_peq").find(".modal-content").html(response.view);
                                $("#modal_peq").modal("show");
                            }
                        }
                    });
                }

            });

            $(".btn_contratacion_masivo").on("click", function() {
                if ($("input[name='req_candidato[]']").serialize() != "") {
                    $.ajax({
                        type: "POST",
                        data: $("input[name='req_candidato[]']").serialize(),
                        url: "{{ route('admin.contratar_masivo_view') }}",
                        success: function(response) {
                            $("#modalTriLarge").find(".modal-content").html(response.view);
                            $("#modalTriLarge").modal("show");
                        }
                    });
                } else {
                    mensaje_danger("Debe seleccionar 1 o mas candidatos");
                }
            });

            $(document).on("click", "#confirmar_contratacion_masiva", function() {
                if($('#fr_contratar_masivo').smkValidate()){
                    $.ajax({
                        type: "POST",
                        data: $("#fr_contratar_masivo").serialize(),
                        url: "{{ route('admin.confirmar_contratar_masivo') }}",
                        beforeSend: function(){
                            $("#modal_gr").modal("hide");
                            mensaje_success("Espere mientras se carga la información");
                            //imagen de carga
                            $.blockUI({
                                message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">', 
                                css: { 
                                    border: "0",
                                    background: "transparent"
                                },
                                overlayCSS:  { 
                                    backgroundColor: "#fff",
                                    opacity:         0.6, 
                                    cursor:          "wait" 
                                }
                            });
                        },
                        success: function(response) {
                            $.unblockUI();
                            if (response.success) {
                                var totalTime = 5;
                                var mensaje = 'Se han contratado los candidatos satisfactoriamente.';
                                if (response.no_contratados_masivo.length > 0) {
                                    totalTime = 15;
                                    mensaje += "<br><br>Pero " + response.no_contratados_masivo.length + " candidatos no se han enviado a contratar:<br><table id='table_no_contratados' class='table table-striped'><thead><th>Documento identidad</th><th>Nombres y apellido</th><th>Motivo no se envia a contratar</th></thead><tbody>";
                                    response.no_contratados_masivo.forEach(function(cand, index) {
                                        mensaje += '<tr><td>' + cand.numero_id + '</td><td>' + cand.nombres + '</td><td>' + cand.observacion + '</td></tr>';
                                    });
                                    mensaje += "</tbody></table>";
                                }
                                mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                                mensaje_success(mensaje);
                                if (response.no_contratados_masivo.length > 0) {
                                    $('#table_no_contratados').DataTable({
                                        'stateSave': true,
                                        "lengthChange": false,
                                        "responsive": true,
                                        "paginate": true,
                                        "autoWidth": true,
                                        "searching": false,
                                        "order": [[1,"desc"]],
                                        "lengthMenu": [[3,10, 25, -1], [3,10, 25, "All"]],
                                        "language": {
                                          "url": '{{ url("js/Spain.json") }}'
                                        }
                                    });
                                }
                                updateClock("tiempo_recarga", totalTime);
                                setTimeout(function(){
                                    location.reload();
                                }, totalTime*1000);
                            } else {
                                $("#modal_peq").modal("hide");
                                mensaje_danger(response.view);
                            }
                        }
                    });
                }
            });

            @if($sitioModulo->evaluacion_sst == 'enabled')
                $(document).on("click",".btn-enviar-sst", function() {
                    //para mostrar el modal de la evaluacion sst
                    var id = $(this).data("candidato_req");

                    $.ajax({
                        type: "POST",
                        data: "candidato_req=" + id,
                    url: "{{ route('enviar_evaluacion_sst')}}",
                        success: function(response) {
                          $("#modalTriSmall").find(".modal-content").html(response);
                          $("#modalTriSmall").modal("show");
                        }
                    });
                });

                $(document).on("click", "#confirmar_envio_evaluacion_sst", function(e) {
                    e.preventDefault();

                    $(this).prop("disabled",true);
                    
                    var btn_id = $(this).prop("id");
                    
                    setTimeout(function(){
                       $("#"+btn_id).prop("disabled",false);
                    }, 5000);

                    $.ajax({
                        type: "POST",
                        data: $("#fr_evaluacion").serialize(),
                        url: "{{ route('confirmar_envio_evaluacion_sst') }}",
                        success: function(response) {
                            if(response.success) {
                                location.reload();

                                mensaje_success("El candidato se ha enviado a evaluación sst.");
                                setTimeout(function(){ $("#modal_success").modal("hide"); }, 1000);
                            }else{
                                $("#modalTriSmall").find(".modal-content").html(response.view);
                                $("#modalTriSmall").modal("show");
                            }
                        }
                    });
                });
            @endif

            @if($sitioModulo->consentimiento_permisos == 'enabled')
                $(document).on("click",".btn_consentimiento_permisos_adic", function() {
                    var id = $(this).data("candidato_req");

                    $.ajax({
                        type: "POST",
                        data: "candidato_req=" + id,
                        url: "{{ route('admin.enviar_consentimiento_permisos_adicionales')}}",
                        success: function(response) {
                            $("#modalTriSmall").find(".modal-content").html(response);
                            $("#modalTriSmall").modal("show");
                        }
                    });
                });

                $(document).on("click", "#confirmar_envio_consentimiento_permisos_adic", function(e) {
                    e.preventDefault();

                    $(this).prop("disabled",true);

                    $.ajax({
                        type: "POST",
                        data: $("#fr_consentimientos_permisos").serialize(),
                        url: "{{ route('admin.confirmar_envio_consentimiento_permisos_adicionales') }}",
                        success: function(response) {
                            if(response.success) {
                                mensaje_success("Candidato enviado al proceso correctamente");
                                setTimeout(function(){ location.reload(); }, 2000);
                            }
                        }
                    });
                });
            @endif

            $("#seleccionar_todos_candidatos_vinculados").on("change", function () {
                
                var obj = $(this);
                
                var stat = obj.prop("checked");
                console.log(stat);
                
                if(stat){
                    $("input[name='req_candidato[]']").prop("checked", true);
                }else{
                    $("input[name='req_candidato[]']").prop("checked", false);
                }
                
            });

            $(document).on("click", "#enviar_contratar_asistente", function() {
                var cliente = $(this).data("cliente");
                var id = $(this).data("candidato_req");

                $.ajax({
                    type: "POST",
                    data:  "&candidato_req=" + id + "&cliente_id=" + cliente,
                    url: "{{ route('admin.enviar_contratar2') }}",
                    success: function(response) {
                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");
                    }
                });
            });

            function confirmar_cuenta(){
                var i = 0;
            
                @if(route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" ||
                    route("home")=="https://pruebaslistos.t3rsc.co" || route("home")=="https://listos.t3rsc.co")
                    var c_una =  $("#numero_cuenta").val();
                    var c_dos =  $("#confirm_numero_cuenta").val();

                    if(c_una.length != 0){ //validar solo si se lleno 
                        if(c_una == c_dos){
                            i = 0//si las cuentas coinciden
                        }else{
                            alert('Confirmacion de la cuenta erroneo');
                            i = 1;
                            $("#confirm_numero_cuenta").css('border', 'solid 1px red');
                            $("#confirm_numero_cuenta").focus();
                        }
                    }
                @endif

                return i;
            }

            $(document).on("click", "#confirmar_contratacion", function() {
                var m = confirmar_cuenta();

                if(m === 1){
                    return false;
                }else{
                    if($('#fr_contratar').smkValidate()){
                        $.ajax({
                            type: "POST",
                            data: $("#fr_contratar").serialize(),
                            url: "{{ route('admin.enviar_a_contratar') }}",
                            beforeSend: function(){
                                mensaje_success("Espere mientras se carga la información");
                            },
                            success: function(response){
                                if(response.success) {
                                    $("#modalTriLarge").modal("hide");

                                    var totalTime = 5;
                                    var mensaje = '';
                                    if (response.no_contratados_masivo.length == 0) {
                                        mensaje = "El candidato se ha enviado a {{ (route('home') == 'https://gpc.t3rsc.co') ? 'aprobar' : 'contratar' }}.";
                                    }
                                    if (response.no_contratados_masivo.length > 0) {
                                        totalTime = 15;
                                        mensaje += "No se ha enviado a contratar al candidato:<br><table id='table_no_contratados' class='table table-striped'><thead><th>Documento identidad</th><th>Nombres y apellido</th><th>Motivo no se envia a contratar</th></thead><tbody>";
                                        response.no_contratados_masivo.forEach(function(cand, index) {
                                            mensaje += '<tr><td>' + cand.numero_id + '</td><td>' + cand.nombres + '</td><td>' + cand.observacion + '</td></tr>';
                                        });
                                        mensaje += "</tbody></table>";
                                    }
                                    mensaje += '<br><div style="text-align: right;">La página se actualizará en <span id="tiempo_recarga"></span> seg.</div>';
                                    mensaje_success(mensaje);
                                    if (response.no_contratados_masivo.length > 0) {
                                        $('#table_no_contratados').DataTable({
                                            'stateSave': true,
                                            "lengthChange": false,
                                            "responsive": true,
                                            "paginate": true,
                                            "autoWidth": true,
                                            "searching": false,
                                            "order": [[1,"desc"]],
                                            "lengthMenu": [[3,10, 25, -1], [3,10, 25, "All"]],
                                            "language": {
                                              "url": '{{ url("js/Spain.json") }}'
                                            }
                                        });
                                    }
                                    updateClock("tiempo_recarga", totalTime);
                                    setTimeout(function(){
                                        location.reload();
                                    }, totalTime*1000);
                                }
                            },
                            error: function(){
                                $("#modalTriLarge .close").click();
                                $("#modal_success .close").click();

                                mensaje_danger("Ha ocurrido un error. Verifique los datos.");
                            }
                        });
                    }
                }
            });
        });
    </script>
@stop