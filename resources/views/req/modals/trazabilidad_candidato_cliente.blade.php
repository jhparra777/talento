<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Trazabilidad candidatos - N. Req {{ $requerimiento->id }} / Cargo {{ $requerimiento->cargo_req() }}</h4>
</div>

<div class="modal-body">
    <div class="row">
        @if ($requerimiento->candidatosAprobar()->count() > 0)
            <div class="col-md-12 text-right mb-2">
                <button 
                    type="button"
                    class="btn btn-success btn_contratacion_cliente_masivo"
                    id="btn_contratacion_cliente_masivo"
                    data-cliente="{{ $cliente->id }}"
                >
                    Contratación masiva
                </button>    
            </div>
        @endif

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if($candidatos_req->count() > 0)    
                        <?php
                            $configuracion_sst = $sitioModulo->configuracionEvaluacionSst();
                        ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        @if ($requerimiento->candidatosAprobar()->count() > 0)
                                            {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos"]) !!}
                                        @else
                                            -
                                        @endif
                                    </th>
                                    {{-- <th>N° Requerimiento</th> --}}
                                    <th class="text-center">Identificación</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Móvil</th>
                                    <th class="text-center">Trazabilidad</th>
                                    <th class="text-center">Informe selección</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($candidatos_req as $reqCandi)
                                    <?php
                                        $procesoCliente = $reqCandi->candidatosAprobar($reqCandi->candidato_id, $reqCandi->req_id);
                                    ?>

                                    <tr>
                                        <td class="text-center">
                                            @if(!empty($procesoCliente))
                                                <input 
                                                    type="checkbox"
                                                    name="req_candidato_id[]"
                                                    value="{{ $reqCandi->req_candidato_id }}"
                                                    data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                >
                                            @else
                                                -
                                            @endif
                                        </td>
                                        {{-- <td>{{ $reqCandi->req_id }}</td> --}}
                                        <td class="text-center">{{ $reqCandi->numero_id }}</td>

                                        <td class="text-center">{{ $reqCandi->nombres }} {{ $reqCandi->primer_apellido }} {{ $reqCandi->segundo_apellido }}</td>
                                        
                                        <td class="text-center">{{ $reqCandi->telefono_movil }}</td>

                                        <td class="text-center">
                                            @foreach($reqCandi->getProcesos() as $count => $proce)
                                                @if($proce->apto == null and $proce->proceso == "ENVIO_REFERENCIACION")
                                                    
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_REF<br> 
                                                    </div> 
                            
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_REFERENCIACION")
                            
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_REF<br> 

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_REFERENCIACION")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_REF <br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                
                                                    <!-- Contratacion -->
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_CONTRATACION") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CON<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_CONTRATACION")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CON<br>
                                                    </div>

                                                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_CONTRATACION") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CON<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                    
                                                <!-- Entrevista -->
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_ENTREVISTA") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_ENTRE<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                
                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_ENTREVISTA") 


                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_ENTRE<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==0 and $proce->proceso == "ENVIO_ENTREVISTA") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                    ENV_ENTRE<br>

                                                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_ENTREVISTA") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_ENTRE <br>
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENTRE_TECNI<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENTRE_TECNI<br> 
                                                    <hr style="background-color: #d24242;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENTRE_TECNI<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENTRE_TECNI<br> 
                                                
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_SST")
                                                    <div style="text-align: center;" id="respuestas">

                                                        {{ $configuracion_sst->nombre_trazabilidad }}<br>
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_SST")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        {{ $configuracion_sst->nombre_trazabilidad }}<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                <!-- PRUEBAS -->
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_PRUEBAS") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_PRUEBAS") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==0 and $proce->proceso == "ENVIO_PRUEBAS") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE<br>

                                                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBAS") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE
                                                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBAS") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                <!-- PRUEBAS -->
                                                <!-- DOCUMENTOS -->
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_DOCUMENTOS") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_DOCU<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_DOCUMENTOS") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_DOCU<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_DOCUMENTOS") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_DOCU<br>
                                                        
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                <!-- ENVIO EXAMENES-->
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_EXAMENES") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                    ENV_EXAME<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_EXAMENES") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXAME<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif(($proce->apto ==0 || $proce->apto ==2) and $proce->proceso == "ENVIO_EXAMENES") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXAME<br>
                                                    <hr style="background-color:red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_EXAMENES") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                    ENV_EXAME<br>
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                <!-- ENVIO CLIENTE -->
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_APROBAR_CLIENTE") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CLI<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==0 and $proce->proceso == "ENVIO_APROBAR_CLIENTE") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CLI<br>

                                                    <hr style="background-color:red;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_APROBAR_CLIENTE") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CLI<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_APROBAR_CLIENTE")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CLI<br>
                                                        
                                                        <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_APROBAR_CLIENTE")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CLI
                                                        <br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                <!-- ENVIO ENTREVISTA VIRTUAL -->
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_ENTRE_VIR<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_ENTRE_VIR<br>

                                                        <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL")
                                                    <div style="text-align: center;" id="respuestas" > ENV_ENTRE_VIR<br>
                                                        
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_PRUEBA_IDIOMA") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_IDIO<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_IDIO<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_IDIO<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- RETROALIMENTACION --}}
                                                @elseif($proce->apto == null and $proce->proceso == "RETROALIMENTACION")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        RETROALIMENTACIÓN<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "RETROALIMENTACION")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        RETROALIMENTACIÓN
                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 2 and $proce->proceso == "RETROALIMENTACION")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        RETROALIMENTACIÓN
                                                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "RETROALIMENTACION")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        RETROALIMENTACIÓN<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CITA_CLI<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CITA_CLI<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CITA_CLI<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                
                                                {{-- Estudio de seguridad --}}
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EST_SEG<br>
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EST_SEG <br>

                                                    <hr style="background-color:red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EST_SEG <br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_ESTUDIO_SEGURIDAD") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EST_SEG<br>
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- Contratación virtual --}}
                                                @elseif($proce->apto == 1 and $proce->proceso == "FIN_CONTRATACION_VIRTUAL") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        FIN_CON_VIR<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "FIN_CONTRATACION_MANUAL") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        FIN_CON_MAN<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "CANCELA_CONTRATACION") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        CANC_CON<br>

                                                    <hr style="background-color: red; height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "FIRMA_VIRTUAL_SIN_VIDEOS") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        FIRMA_SIN_VIDEOS<br>

                                                    <hr style="background-color: #51beb1; height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                
                                                @elseif($proce->apto == 1 and $proce->proceso == "FIRMA_CONF_MAN") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        FIRMA_CONF_MAN<br>

                                                    <hr style="background-color: #51beb1; height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 1 and $proce->proceso == "CONTRATO_ANULADO") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        CONTRATO_ANULADO<br>

                                                    <hr style="background-color: #d24242; height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- Trazabilidad prueba BRYG --}}
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_BRYG") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE_BRYG<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_BRYG") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE_BRYG<br>
                                                        <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBA_BRYG") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE_BRYG<br>
                                                        <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_BRYG") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUE_BRYG<br>
                                                        <hr style="background-color: #f7d031;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- Trazabilidad prueba Excel Basico --}}
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_EXCEL_BASICO") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXCEL_BAS<br>
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_EXCEL_BASICO") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXCEL_BAS<br>
                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_EXCEL_BASICO")
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXCEL_BAS<br>
                                                    <hr style="background-color:red;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_EXCEL_BASICO") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXCEL_BAS<br>
                                                    <hr style="background-color: #f7d031;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- Trazabilidad prueba Excel Intermedio --}}
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_EXCEL_INTERMEDIO") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXCEL_MEDIO<br>
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_EXCEL_INTERMEDIO") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXCEL_MEDIO<br>
                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_EXCEL_INTERMEDIO") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXCEL_MEDIO<br>
                                                    <hr style="background-color:red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_EXCEL_INTERMEDIO") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXCEL_MEDIO<br>
                                                    <hr style="background-color: #f7d031;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- Trazabilidad prueba de Valores 1 --}}
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_EV<br>
                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_EV<br>
                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_EV<br>
                                                    <hr style="background-color:red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_ETHICAL_VALUES") 
                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_EV<br>
                                                    <hr style="background-color: #f7d031;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- Trazabilidad PRE CONTRATAR --}}
                                                @elseif($proce->apto == null and $proce->proceso == "PRE_CONTRATAR") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRE_CONTRATAR<br>

                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "PRE_CONTRATAR") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRE_CONTRATAR<br>
                                                        <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 2 and $proce->proceso == "PRE_CONTRATAR") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRE_CONTRATAR<br>
                                                        <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                    {{-- Trazabilidad ENTREVISTA MULTIPLE --}}
                                                @elseif($proce->apto == null and $proce->proceso == "ENTREVISTA_MULTIPLE") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        ENTREVISTA_MULTIPLE<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "ENTREVISTA_MULTIPLE") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        ENTREVISTA_MULTIPLE<br>
                                                        <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 2 and $proce->proceso == "ENTREVISTA_MULTIPLE") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        ENTREVISTA_MULTIPLE<br>
                                                        <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- Trazabilidad CONSULTA SEGURIDAD --}}
                                                @elseif($proce->apto == null and $proce->proceso == "CONSULTA_SEGURIDAD") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        CONSULTA_SEGURIDAD

                                                        <?php
                                                            $consultaSeguridad = App\Http\Controllers\ConsultaSeguridadController::validarFactorConsulta($reqCandi->candidato_id, $reqCandi->req_id);
                                                        ?>

                                                        @if($consultaSeguridad == 'bajo')
                                                            <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                        @elseif($consultaSeguridad == 'medio')
                                                            <hr style="background-color: #f1c40f;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                        @elseif($consultaSeguridad == 'alto')
                                                            <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                        @endif
                                                {{-- Trazabilidad PRUEBA DIGITACIÓN --}}
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_DIGITACION") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRUEBA_DIGITACION<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_DIGITACION") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRUEBA_DIGITACION<br>
                                                        <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBA_DIGITACION") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRUEBA_DIGITACION<br>
                                                        <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_DIGITACION") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRUEBA_DIGITACION<br>
                                                        <hr style="background-color: #f7d031;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                {{-- Trazabilidad PRUEBA COMPETENCIAS --}}
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_COMPETENCIA") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRUE_PERSONAL_SKILLS<br>
                                                        <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_COMPETENCIA") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRUE_PERSONAL_SKILLS<br>
                                                        <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 2 and $proce->proceso == "ENVIO_PRUEBA_COMPETENCIA") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRUE_PERSONAL_SKILLS<br>
                                                        <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @elseif($proce->apto == 3 and $proce->proceso == "ENVIO_PRUEBA_COMPETENCIA") 
                                                    <div style="text-align: center;" id="respuestas">
                                                        PRUE_PERSONAL_SKILLS<br>
                                                        <hr style="background-color: #f7d031;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                                @endif
                                            @endforeach
                                        </td>

                                        @if (!empty($procesoCliente))
                                            <td class="text-center">
                                                <a 
                                                    class="btn btn-primary" 
                                                    target="_blank"
                                                    href="{{ route('req.informe_seleccion', [$reqCandi->req_candidato_id]) }}"
                                                >
                                                    Ver informe de selección
                                                </a>
                                            </td>

                                            {{-- Acción --}}
                                            @if (is_null($procesoCliente->apto) || $procesoCliente->apto == '')
                                                <td class="text-center">
                                                    <div class="btn-group-vertical" role="group" aria-label="...">
                                                        <button 
                                                            class="btn btn-info btn-block btn_observaciones"
                                                            data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                            data-cliente="{{ $cliente->id }}"
                                                            data-req_id="{{ $reqCandi->req_id }}"
                                                            data-user_id="{{ $reqCandi->candidato_id }}"
                                                        >
                                                            Observaciones
                                                        </button>

                                                        @if(route('home') == "http://localhost:8000" || route('home') == "https://desarrollo.t3rsc.co" || route('home') == "https://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co")
                                                            <button 
                                                                class="btn btn-warning btn-block btn_citar"
                                                                data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                                data-cliente="{{ $cliente->id }}"
                                                                data-req_id="{{ $reqCandi->req_id }}"
                                                                data-user_id="{{ $reqCandi->candidato_id }}"
                                                            >
                                                                Citar
                                                            </button>
                                                        @endif

                                                        @if(route('home') != "http://komatsu.t3rsc.co")
                                                            <button 
                                                                class="btn btn-success btn-block btn_contratar"
                                                                data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                                data-cliente="{{ $cliente->id }}"
                                                                data-req_id="{{ $reqCandi->req_id }}"
                                                                data-user_id="{{ $reqCandi->candidato_id }}"
                                                            >
                                                                Contratar
                                                            </button>
                                                        @else
                                                            <button 
                                                                class="btn btn-success btn-block btn_contratar"
                                                                data-candidato_req="{{ $reqCandi->req_candidato_id }}"
                                                                data-cliente="{{ $cliente->id}}" 
                                                                data-req_id="{{ $reqCandi->req_id }}"
                                                                data-user_id="{{ $reqCandi->candidato_id }}"
                                                            >
                                                                Continuar
                                                            </button>
                                                        @endif

                                                        <button 
                                                            class="btn btn-danger btn-block candidato_no_aprobado"
                                                            data-candidato="{{ $reqCandi->candidato_id }}"
                                                            data-req_candidato="{{ $reqCandi->req_candidato_id }}"
                                                        >
                                                            NO Aprobado
                                                        </button>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="text-center">-</td>
                                            @endif
                                        @else
                                            <td class="text-center">-</td>
                                            <td class="text-center">-</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No hay candidatos vinculados</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>

<script>
    $(function () {
        $("#seleccionar_todos").on("change", function () {
            let obj = $(this);

            $("input[name='req_candidato_id[]']").prop("checked", obj.prop("checked"));
        })

        $(".btn_observaciones").on("click", function(e) {
            let req_id = $(this).data("req_id");
            let user_id = $(this).data("user_id");
            let id = $(this).data("candidato_req");
            let cliente = $(this).data("cliente");
            let modulo="cliente";

            $.ajax({
                type: "POST",
                data: {req_id: req_id, user_id: user_id, candidato_req: id, cliente_id: cliente, modulo: modulo},
                url: "{{ route('req.crear_observacion') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_gra").find(".modal-content").html(response);
                    $("#modal_gra").modal("show");
                }
            })
        })

        $(".btn_contratar").on("click", function() {
            let req_id = $(this).data("req_id");
            let user_id = $(this).data("user_id");
            let id = $(this).data("candidato_req");
            let cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: {req_id: req_id, user_id: user_id, candidato_req: id, cliente_id: cliente},
                url: "{{ route('req.enviar_contratar_req') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            })
        })

        $(".btn_citar").on("click", function() {
            let req_id = $(this).data("req_id");
            let user_id = $(this).data("user_id");
            let id = $(this).data("candidato_req");
            let cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: {req_id: req_id, user_id: user_id, candidato_req: id, cliente_id: cliente},
                url: "{{ route('req.crear_cita_cliente') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_gra").find(".modal-content").html(response);
                    $("#modal_gra").modal("show");
                }
            })
        })

        $(".btn_contratar2").on("click", function() {
            let req_id = $(this).data("req_id");
            let user_id = $(this).data("user_id");
            let id = $(this).data("candidato_req");
            let cliente = $(this).data("cliente");

            $.ajax({
                type: "POST",
                data: {req_id: req_id, user_id: user_id, candidato_req: id, cliente_id: cliente},
                url: "{{ route('req.enviar_contratar2_req') }}",
                success: function(response) {
                    $("#modal_gr").modal("hide");
                    $("#modal_peq").find(".modal-content").html(response);
                    $("#modal_peq").modal("show");
                }
            })
        })

        $(document).on("click", "#confirmar_contratacion", function() {
            $(this).prop("disabled", true);
            let btn_id = $(this).prop("id");
            
            setTimeout(function(){
                $("#"+btn_id).prop("disabled", false);
            }, 50000);

            $.ajax({
                type: "POST",
                data: $("#fr_contratar_req").serialize(),
                url: "{{ route('req.enviar_a_contratar_cliente_req') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        mensaje_success("Los datos de contratación han sido enviados.");
                        window.location.href = '{{ route("req.mis_requerimiento") }}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            })
        })

        $(".btn_contratacion_cliente_masivo").on("click", function() {
           let cliente_id = $(this).data("cliente");

           $.ajax({
                type: "POST",
                data: $("input[name='req_candidato_id[]']").serialize() + "&cliente_id="+cliente_id,
                url: "{{ route('req.contratar_masivo_cliente') }}",
                success: function(response) {
                   $("#modal_peq").find(".modal-content").html(response);
                   $("#modal_gr").modal("hide");
                   $("#modal_peq").modal("show");
                }
            })
        })

        $(document).on("click", "#guardar_observacion", function(e) {
            e.preventDefault();
            e.stopImmediatePropagation();
        
            $(this).prop("disabled", true);
            let btn_id = $(this).prop("id");

            setTimeout(function(){
                $("#"+btn_id).prop("disabled", false);
            }, 5000);

            $.ajax({
                type: "POST",
                data: $("#fr_observacion_req").serialize(),
                url: "{{ route('req.guardar_observacion') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        alert("Se ha creado la observación con éxito!");
                        window.location.href = '{{route("req.mis_requerimiento")}}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            })
        })

        $(document).on("click", "#guardar_cita_cliente", function() {
            if($('#fecha_cita').val() == '') {
                $('#fecha_cita').css('border', 'solid red 1px');
            }else if($('#observacion_cita').val() == '') {
                $('#observacion_cita').css('border', 'solid red 1px');
            }else {
                $(this).prop('disabled', 'disabled');

                $.ajax({
                    type: "POST",
                    data: $("#frm_crear_cita").serialize(),
                    url: "{{ route('req.guardar_cita_cliente') }}",
                    success: function(response) {
                        if (response.success) {
                            $("#modal_gra").modal("hide");
                            $(this).prop('disabled', 'false');
                            alert('Se ha creado la cita con éxito.');
                        }else {
                            alert("Ocurrio un error en el servidor.");
                        }
                    }
                })
            }
        })

        $(document).on("click", "#confirmar_contratacion_masivo", function() {
            $.ajax({
                type: "POST",
                data: $("#fr_contratar_masivo_req").serialize(),
                url: "{{ route('req.contratar_masivo_cli') }}",
                success: function(response) {
                    if (response.success) {
                        $("#modal_peq").modal("hide");
                        alert("Los datos de contratación han sido enviados.");
                        window.location.href = '{{route("req.mis_requerimiento")}}';
                    } else {
                        $("#modal_peq").find(".modal-content").html(response.view);
                    }
                }
            })
        })
    })

    function mensaje_success_sin_boton(mensaje) {
        $("#modal_success_view #texto").html(mensaje);
        $("#modal_success_view").modal("show");
    }
</script>
