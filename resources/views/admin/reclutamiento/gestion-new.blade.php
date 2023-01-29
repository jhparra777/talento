@extends("admin.layout.master")
@section('contenedor')
    <?php
        $boton = false;

        if(!empty($requermiento->estadoRequerimiento()->estado_id)){
            $boton = FuncionesGlobales::estado_boton($requermiento->estadoRequerimiento()->estado_id);
        }

        $configuracion_sst = $sitioModulo->configuracionEvaluacionSst();
        $consentimiento_config = $sitioModulo->configuracionConsentimientoPermiso();
        $dsd = 'gestionreq';
    ?>

    {{-- Estilos --}}
    @include('admin.reclutamiento.includes.gestion-requerimiento.src.css._css_gestion_requerimiento')

    {{-- Header --}}
    @if (route("home") == "https://komatsu.t3rsc.co")
        @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Gestión Candidatos Requerimiento $requermiento->id", 'more_info' => "<b>Cargo</b> $requermiento->nombre_cargo_especifico"])
    @else
        @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Gestión Candidatos Requerimiento $requermiento->id", 'more_info' => "<b>Cliente</b> $requermiento->nombre_cliente | <b>Cargo</b> $requermiento->nombre_cargo_especifico"])
    @endif

    <input type="hidden" name="boton_var" value='{{$boton}}' id="boton_var">
    <input type="hidden" name="requerimiento" value='{{$requermiento->id}}' id="requerimiento_global">

    {{-- <div class="row">
        <div class="col-md-12 mb-2">
            <h3 class="text-center | tri-fs-20">
                Gestión Candidatos Requerimiento {{ $requermiento->id }} |
                
                @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
                @else
                    Cliente {{ $requermiento->nombre_cliente }} |
                @endif

                Cargo {{ $requermiento->nombre_cargo_especifico }}
            </h3>
        </div>
    </div> --}}

    {{-- Alert para muestra de errores --}}
    <div class="row">
        @if($errors->any())
            <div class="col-md-12">
                <div class="alert alert-danger alert-dismissible | tri-br-1 tri-red tri-border--none">
                  <button aria-hidden="true" class="close" data-dismiss="alert" type="button"> × </button>
                    <h5><i class="icon fa fa-ban"></i> Alerta</h5>

                    <ul>
                        @foreach($errors->all() as $error)
                            <li> {{ $error }}. </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="col-md-12" id="mensaje-error" style="display: none;">
            <div class="alert alert-danger alert-dismissible | tri-br-1 tri-red tri-border--none">
                <button aria-hidden="true" class="close" data-dismiss="alert" type="button">×</button>
                <h5><i class="icon fa fa-ban"></i> Alerta</h5>
                <strong id="error"></strong>
            </div>
        </div>
    </div>

    {{-- Información general de la solicitud --}}
    <div class="row">
        @include('admin.reclutamiento.includes.gestion-requerimiento._section_informacion_general')
    </div>

    {{-- Acciones globales al requerimiento --}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="tri-fs-16 text-center mb-2">
                        ACCIONES GLOBALES AL REQUERIMIENTO
                    </h4>

                    {{-- Botones parte de arriba --}}
                    @include('admin.reclutamiento.includes.gestion-requerimiento._section_acciones_globales')
                </div>
            </div>
        </div>

        {{-- Botones parte de abajo --}}
        <div class="col-md-12">
            <div class="panel panel-default | mb-1">
                <div class="panel-body">
                    @include('admin.reclutamiento.includes.gestion-requerimiento._section_procesos_masivos_globales')
                </div>
            </div>

            {{-- Longlist form --}}
            @if(route("home") == "https://gpc.t3rsc.co")
                {!! Form::open(["method" => "POST", "id" => "long-list", "target" => "_blank"])!!}
                    {!! Form::hidden("req_id", $requermiento->id) !!}
                {!!Form::close()!!}
            @endif
        </div>
    </div>

    {{-- Gráficos --}}
    @include('admin.reclutamiento.includes.gestion-requerimiento._section_grafico_preliminar')

    {{-- Listas candidatos vínculados, otras fuentes y preperfilados al requerimiento --}}
    <div class="row">
        @include('admin.reclutamiento.includes.gestion-requerimiento._tabs_candidatos_gestion')
    </div>

    {{-- Botón ingresar candidato otras fuentes --}}
    <div class="row mb-2" id="boxBotonAgregarCandidato">
        <div class="col-md-12">
            <button 
                type="button" 
                class="btn btn-info | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" 
                data-req="{{ $requermiento->id }}" 
                id="ingresarCandidatoOtrasFuentes" 

                data-toggle="tooltip"
                data-placement="top"
                data-container="body"
                title="Ingresar candidato a otras fuentes."
            >
                <i class="fas fa-user-plus" aria-hidden="true"></i> Ingresar candidato
            </button>
        </div>
    </div>

    {{-- Candidatos aplicaron al requerimiento --}}
    {{-- <div class="row">
        @include('admin.reclutamiento.includes.gestion._section_candidatos_aplicaron_gestion')
    </div> --}}

    {{-- Candidatos reclutamiento externo --}}
    @if($candidatos_reclutamiento_externo->count() > 0)
        <div class="row">
            @include('admin.reclutamiento.includes.gestion-requerimiento._section_candidatos_reclutamiento_externo_gestion')
        </div>
    @endif

    {{-- Candidatos aplicaron al requerimiento EE --}}
    @if (route('home') == 'https://listos.t3rsc.co' || route('home') == 'https://desarrollo.t3rsc.co')
        <div class="row">
            @include('admin.reclutamiento.includes.gestion-requerimiento._section_candidatos_aplicaron_ee_gestion')
        </div>
    @endif

    {{-- Modal success --}}
    @if(Session::has("success"))
        <div class="modal" id="modal_success_view">
            <div class="modal-dialog">
                <div class="modal-content">
                    @include("admin.reclutamiento.modal.lista_transferir", ["errores_array" => Session::get("errores_array"), "errores_array_req" => Session::get("errores_array_req"), "req_id" => $requermiento->id])
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(function() {
                $("#modal_success_view").modal("show");
            });
        </script>
    @endif

    {{-- Modal informativo --}}
    <div class="modal" id="modal_info_async_view">
        <div class="modal-dialog">
            <div class="modal-content tri-br-1">
                <div class="modal-header alert-info | tri-blue" style="border-radius: 1rem 1rem 0 0;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h5 class="modal-title"><span class="fa fa-check-circle "></span> Información</h5>
                </div>

                <div class="modal-body">
                    <ul id="ul_error_ee"></ul>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-300" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="modal_verificado">
        <div class="modal-dialog">
            <div class="modal-content"></div>
        </div>
    </div>

    {{-- Modal de anulación --}}
    @include('admin.reclutamiento.includes.gestion-requerimiento.modals._modal_anulacion_gestion')

    {{-- Modal ver respuestas --}}
    @include('admin.reclutamiento.includes.gestion-requerimiento.modals._modal_respuestas_gestion')

    {{-- Modal firmar contrato --}}
    @include('admin.reclutamiento.includes.gestion-requerimiento.modals._modal_firmar_contrato_gestion')

    @include('admin.bryg._modal_configuracion_cuadrantes')

    {{-- Configuración BRYG --}}
    <script src="{{ asset('js/admin/bryg-scripts/_js_configuracion_cuadrantes.js') }}"></script>

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

    {{-- Todo JS --}}
    @include('admin.reclutamiento.includes.gestion-requerimiento.src.js._js_gestion_requerimiento')
@stop