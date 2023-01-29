<div class="md-chips">
    @foreach($procesos as $count => $proce)
        {{-- Referenciación --}}
        @if($proce->apto == null and $proce->proceso == "ENVIO_REFERENCIACION")    
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Referenciación laboral',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_referencia', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-id-card"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_REFERENCIACION")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Referenciación laboral',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-id-card"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_REFERENCIACION")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Referenciación laboral',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_referencia', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-id-card"
            ])
            
         {{-- Referencia estudios --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_REFERENCIA_ESTUDIOS")              
        
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Referenciación académica',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_referencia_estudios', $proce->id),
                'btnIrProceso' => true,
                'btnEliminarProceso' => true,
                'icon' => "fa-book-reader"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_REFERENCIA_ESTUDIOS")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Referenciación académica',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => false,
                'icon' => "fa-book-reader"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_REFERENCIA_ESTUDIOS")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Referenciación académica',
                'bgColor' => 'tri-yellow',
                'ruta' => route('admin.gestionar_referencia_estudios', $proce->id),
                'btnIrProceso' => true,
                'btnEliminarProceso' => true,
                'icon' => "fa-book-reader"
            ])

        {{-- Contratación --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_CONTRATACION") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://gpc.t3rsc.co") ? 'ENV_APR' : 'Envío a contratar',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_CONTRATACION")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://gpc.t3rsc.co") ? 'ENV_APR' : 'Envío a contratar',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_CONTRATACION")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://gpc.t3rsc.co") ? 'ENV_APR' : 'Envío a contratar',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_CONTRATACION")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://gpc.t3rsc.co") ? 'ENV_APR' : 'Envío a contratar',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-briefcase"
            ])
        @elseif($proce->apto == null and $proce->proceso == "VISITA_DOMICILIARIA") 
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Visita domiciliaria',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-briefcase"
            ])
                                                    

        @elseif($proce->apto == 1 and $proce->proceso == "VISITA_DOMICILIARIA") 
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Visita domiciliaria',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])

        {{-- Estudio Virtual de Seguridad EVS --}}
        @elseif($proce->apto == null and $proce->proceso == "ESTUDIO_VIRTUAL_SEGURIDAD") 
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Estudio virtual de seguridad',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-briefcase"
            ])
        @elseif($proce->apto == 1 and $proce->proceso == "ESTUDIO_VIRTUAL_SEGURIDAD") 
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Estudio virtual de seguridad',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])
        @elseif($proce->apto == 0 and $proce->proceso == "ESTUDIO_VIRTUAL_SEGURIDAD") 
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Estudio virtual de seguridad',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->proceso == "CONTR_CANCE")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Contratación cancelada',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-briefcase"
            ])

        {{-- Entrevista --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_entrevista', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ENTREVISTA")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ENTREVISTA")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista',
                'bgColor' => 'tri-d-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_ENTREVISTA")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_entrevista', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-tie"
            ])

        {{-- Entrevista tecnica --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista técnica',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista técnica',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista técnica',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista técnica',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-user-tie"
            ])

        {{-- PRUEBAS --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBAS")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Pruebas',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_prueba', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-clipboard"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBAS") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Pruebas',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-clipboard"
            ])

        @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBAS")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Pruebas',
                'bgColor' => 'tri-d-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-clipboard"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBAS") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Pruebas',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_prueba', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-clipboard"
            ])

        {{-- DOCUMENTOS --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_DOCUMENTOS")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route('home') == 'https://komatsu.t3rsc.co') ? 'Estudio seguridad' : 'Validación documental',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_documentos', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-address-card"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_DOCUMENTOS")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://komatsu.t3rsc.co") ? 'Estudio seguridad' : 'Validación documental',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-address-card"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_DOCUMENTOS")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://komatsu.t3rsc.co") ? 'Estudio seguridad' : 'Validación documental',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_documentos', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-address-card"
            ])
        
        {{-- ENVIO EXAMENES--}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_EXAMENES")
            @if($sitioModulo->salud_ocupacional != 'si')
                <?php $ruta = route('admin.gestionar_documentos_medicos', ['ref_id' => $proce->id]) . '?dsd='.$dsd; ?>
            @else
                <?php $ruta = route('admin.examenes_medicos') . '?codigo='.$proce->requerimiento_id.'&cedula='.$candidato_req->numero_id.'&dsd='.$dsd; ?>
            @endif
            <?php
                $irProceso = (!empty($gestionaProcesos) && $gestionaProcesos ? true : (isset($inactiveAllbtn)?null:true));
            ?>
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Exámenes médicos',
                'bgColor' => 'tri-d-yellow',
                'ruta' => $ruta,
                'btnIrProceso' => $irProceso,
                'icon' => "fa-briefcase-medical"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_EXAMENES") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Exámenes médicos',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-briefcase-medical"
            ])        

        @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_EXAMENES") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Exámenes médicos',
                'bgColor' => 'tri-d-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-briefcase-medical"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_EXAMENES")
            @if($sitioModulo->salud_ocupacional != 'si')
                <?php $ruta = route('admin.gestionar_documentos_medicos', ['ref_id' => $proce->id]) . '?dsd='.$dsd; ?>
            @else
                <?php $ruta = route('admin.examenes_medicos') . '?codigo='.$proce->requerimiento_id.'&cedula='.$candidato_req->numero_id.'&dsd='.$dsd; ?>
            @endif
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Exámenes médicos',
                'bgColor' => 'tri-d-yellow',
                'ruta' => $ruta,
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-briefcase-medical"
            ])

        {{-- ENVIO CLIENTE --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_APROBAR_CLIENTE")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://komatsu.t3rsc.co") ? 'ENV_COORD' : 'Envío al cliente',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_aprobar_cliente_admin', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-check"
            ])

        @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_APROBAR_CLIENTE")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://komatsu.t3rsc.co") ? 'ENV_COORD' : 'Envío al cliente',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-user-check"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_APROBAR_CLIENTE")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://komatsu.t3rsc.co") ? 'ENV_COORD' : 'Envío al cliente',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-user-check"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_APROBAR_CLIENTE")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => (route("home") == "https://komatsu.t3rsc.co") ? 'ENV_COORD' : 'Envío al cliente',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_aprobar_cliente_admin', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-check"
            ])

        {{-- ENVIO ENTREVISTA VIRTUAL --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista virtual',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_entrevista_virtual',['ref_id'=>$requermiento->id] ),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-video"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista virtual',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-video"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista virtual',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_entrevista_virtual', ['ref_id'=>$requermiento->id]),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-video"
            ])

        {{-- PRUEBA IDIOMA --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba idioma',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_prueba_idioma', $requermiento->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-globe-americas"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba idioma',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-globe-americas"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba idioma',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_prueba_idioma', $requermiento->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-globe-americas"
            ])

        {{-- CITA CLIENTE --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")
            
            {{-- Chip trazabilidad --}}

            {{-- TODO: Colocar el botón que gestiona la cita o algo --}}
            {{-- 
                <a href="#" class="btn btn_citar_to_cliente" id="btn-irReq" data-cliente="{{$cliente->id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">  
                    <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    Ir 
                </a>
                --}}

            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Cita cliente',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Cita cliente',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")
            
            {{-- Chip trazabilidad --}}

            {{-- 
                <a href="" class="btn" id="btn-irReq btn_citar_to_cliente" data-cliente="{{$cliente->id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">  
                    <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    Ir 
                </a>
                --}}

            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Cita cliente',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-user-tie"
            ])
        
        {{-- Estudio de seguridad --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Estudio seguridad',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_documentos_estudio_seguridad', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-lock"
            ])

        @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Estudio seguridad',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-user-lock"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Estudio seguridad',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => true,
                'icon' => "fa-user-lock"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Estudio seguridad',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_documentos_estudio_seguridad', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-lock"
            ])

        {{-- Contratación virtual --}}
        @elseif($proce->apto == 1 and $proce->proceso == "FIN_CONTRATACION_VIRTUAL")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Firma con video confirmación',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 0 and $proce->proceso == "FIN_CONTRATACION_VIRTUAL")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Firma con video confirmación',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "FIN_CONTRATACION_MANUAL") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Contrato cargado manual',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 0 and $proce->proceso == "FIN_CONTRATACION_MANUAL") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Contrato cargado manual',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "CANCELA_CONTRATACION") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Cancela contratación',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-briefcase"
            ])

            <!-- pasamos aqui para buscar procesos y validar if para ocultar Firma sin videos -->
        @php
            $processes = $procesos->pluck("proceso")->toArray();
        @endphp

        @elseif($proce->apto == 1 and $proce->proceso == "FIRMA_VIRTUAL_SIN_VIDEOS" and !in_array("FIN_CONTRATACION_VIRTUAL", $processes) and !in_array("FIRMA_CONF_MAN", $processes) and !in_array("FIN_CONTRATACION_MANUAL", $processes) )          

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Firma sin confirmación',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "FIRMA_CONF_MAN") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Firma con confirmación manual',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 0 and $proce->proceso == "FIRMA_CONF_MAN") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Firma con confirmación manual',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "CONTRATO_ANULADO") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Contrato anulado',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-briefcase"
            ])
        
        {{-- Trazabilidad prueba BRYG --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_BRYG")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba BRYG',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.pruebas_bryg_gestion', FuncionesGlobales::getBrygId($proce->requerimiento_id, $proce->candidato_id)),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-dice-d6"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_BRYG") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba BRYG',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-dice-d6"
            ])

            {{-- 
                <a 
                    type="button" 
                    class="reabrir_proceso" 
                    data-id="{{ $proce->id }}" 
                    data-proceso="{{ $proce->proceso }}" 
                    data-candidato="{{ mb_strtoupper($candidato_req->nombres ." ".$candidato_req->primer_apellido." ".$candidato_req->segundo_apellido)}}">
                        <i class="fa fa-folder-open-o" aria-hidden="true" title="Reabrir"></i>
                </a>
                --}}
            

        @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBA_BRYG")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba BRYG',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-dice-d6"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_BRYG") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba BRYG',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.pruebas_bryg_gestion', FuncionesGlobales::getBrygId($proce->requerimiento_id, $proce->candidato_id)),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'btnEliminarProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-dice-d6"
            ])

        {{-- Trazabilidad PRE CONTRATAR --}}
        @elseif($proce->apto == null and $proce->proceso == "PRE_CONTRATAR")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Pre-contratar',
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "PRE_CONTRATAR") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Pre-contratar',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-briefcase"
            ])

        @elseif($proce->apto == 2 and $proce->proceso == "PRE_CONTRATAR") 
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Pre-contratar',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-briefcase"
            ])

        {{-- Trazabilidad ENTREVISTA MULTIPLE --}}
        @elseif($proce->apto == null and $proce->proceso == "ENTREVISTA_MULTIPLE")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista multiple',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.entrevistas_multiples', $requermiento->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-tie"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENTREVISTA_MULTIPLE")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista multiple',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-user-tie"
            ])        

        @elseif($proce->apto == 2 and $proce->proceso == "ENTREVISTA_MULTIPLE") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Entrevista multiple',
                'bgColor' => 'tri-d-red',
                'icon' => "fa-user-tie"
            ])

        {{-- Retroalimentación --}}
        @elseif($proce->apto == null and $proce->proceso == "RETROALIMENTACION")    
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Retroalimentación',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_retroalimentacion_video',['ref_id'=>$candidato_req->req_candidato_id] ),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "RETROALIMENTACION")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Retroalimentación',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 2 and $proce->proceso == "RETROALIMENTACION")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Retroalimentación',
                'bgColor' => 'tri-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "RETROALIMENTACION")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Retroalimentación',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.retroalimentacion_videos', $requermiento->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == null and $proce->proceso == "CONSULTA_SEGURIDAD")
            <?php
                $consultaSeguridad = App\Http\Controllers\ConsultaSeguridadController::validarFactorConsulta($candidato_req->candidato_id, $requermiento->id);
            ?>

            @if($consultaSeguridad == 'bajo')
                <?php
                    $bgColorFactor = 'tri-red';
                ?>
            @elseif($consultaSeguridad == 'medio')
                <?php
                    $bgColorFactor = 'tri-d-yellow';
                ?>
            @elseif($consultaSeguridad == 'alto')
                <?php
                    $bgColorFactor = 'tri-blue-2';
                ?>
            @endif

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Consulta seguridad',
                'bgColor' => $bgColorFactor,
                'icon' => "fa-shield-alt"
            ])
        
        @elseif($proce->apto == null and $proce->proceso == "LISTAS_VINCULANTES")
            <?php
                $consultaSeguridad = App\Http\Controllers\ListaVinculanteController::validarFactorConsulta($candidato_req->candidato_id, $requermiento->id);
            ?>

            @if($consultaSeguridad == 'bajo')
                <?php
                    $bgColorFactor = 'tri-red';
                ?>
            @elseif($consultaSeguridad == 'medio')
                <?php
                    $bgColorFactor = 'tri-d-yellow';
                ?>
            @elseif($consultaSeguridad == 'alto')
                <?php
                    $bgColorFactor = 'tri-blue-2';
                ?>
            @endif

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Listas Vinculantes',
                'bgColor' => $bgColorFactor,
                'icon' => "fa-shield-alt"
            ])

        @elseif($proce->apto == null and $proce->proceso == "ENVIO_SST")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => $configuracion_sst->nombre_trazabilidad,
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_SST")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => $configuracion_sst->nombre_trazabilidad,
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == null and $proce->proceso == "CONSENTIMIENTO_PERMISO")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => $consentimiento_config->nombre_visible_trazabilidad,
                'bgColor' => 'tri-d-yellow',
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "CONSENTIMIENTO_PERMISO")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => $consentimiento_config->nombre_visible_trazabilidad,
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-file"
            ])

        {{-- Trazabilidad prueba Excel Basico --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_EXCEL_BASICO") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba Excel básico',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_excel_basico', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_EXCEL_BASICO")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba Excel básico',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_EXCEL_BASICO")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba Excel básico',
                'bgColor' => 'tri-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_EXCEL_BASICO")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba Excel básico',
                'bgColor' => 'tri-yellow',
                'ruta' => route('admin.gestionar_excel_basico', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        {{-- Trazabilidad prueba Excel Intermedio --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_EXCEL_INTERMEDIO") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba Excel intermedio',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_excel_intermedio', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_EXCEL_INTERMEDIO")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba Excel intermedio',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_EXCEL_INTERMEDIO")
            
            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba Excel intermedio',
                'bgColor' => 'tri-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_EXCEL_INTERMEDIO") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba Excel intermedio',
                'bgColor' => 'tri-yellow',
                'ruta' => route('admin.gestionar_excel_intermedio', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        {{-- Trazabilidad prueba de Valores 1 --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba ethical values',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.gestionar_valores_1', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba ethical values',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba ethical values',
                'bgColor' => 'tri-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba ethical values',
                'bgColor' => 'tri-yellow',
                'ruta' => route('admin.gestionar_valores_1', $proce->id),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        {{-- Trazabilidad PRUEBA DIGITACIÓN --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_DIGITACION")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba digitación',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.pruebas_digitacion_gestion', FuncionesGlobales::getDigitacionId($proce->requerimiento_id, $proce->candidato_id)),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-keyboard"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_DIGITACION")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba digitación',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-keyboard"
            ])

        @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBA_DIGITACION")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba digitación',
                'bgColor' => 'tri-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-keyboard"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_DIGITACION") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba digitación',
                'bgColor' => 'tri-yellow',
                'ruta' => route('admin.pruebas_digitacion_gestion', FuncionesGlobales::getDigitacionId($proce->requerimiento_id, $proce->candidato_id)),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-keyboard"
            ])

        {{-- Trazabilidad PRUEBA COMPETENCIAS --}}
        @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_COMPETENCIA") 

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba personal skills',
                'bgColor' => 'tri-d-yellow',
                'ruta' => route('admin.pruebas_competencias_gestion', FuncionesGlobales::getCompetenciasId($proce->requerimiento_id, $proce->candidato_id)),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_COMPETENCIA")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba personal skills',
                'bgColor' => 'tri-blue-old',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBA_COMPETENCIA")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba personal skills',
                'bgColor' => 'tri-red',
                'btnReabrirProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_COMPETENCIA")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Prueba personal skills',
                'bgColor' => 'tri-yellow',
                'ruta' => route('admin.pruebas_competencias_gestion', FuncionesGlobales::getCompetenciasId($proce->requerimiento_id, $proce->candidato_id)),
                'btnIrProceso' => isset($inactiveAllbtn)?null:true,
                'icon' => "fa-file"
            ])

        @elseif($proce->apto == 1 and $proce->proceso == "NOTIFICACION_TERMINACION_CONTRATO")

            {{-- Chip trazabilidad --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._chip_trazabilidad_gestion', [
                'proceso' => 'Carta terminación contrato',
                'bgColor' => 'tri-blue-old',
                'icon' => "fa-envelope"
            ])

        @endif
    @endforeach
</div>