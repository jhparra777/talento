<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>Trazabilidad candidatos</strong></h4>
</div>
<div class="modal-body">
            @if($candidatos_req->count()>0)
    
    <table class="table table-bordered ultima_seleccionada">
        <thead>
            <tr>
                <th>N° Requerimiento</th>
                <th>Identificación</th>
                <th>Nombre</th>
                <th>Movil</th>
                <th>Trazabilidad</th>
            </tr>
        </thead>
        <tr>
            {{-- {{ dd($reqCandidato) }} --}}
            @foreach($candidatos_req as $reqCandi)
                      <tr>
                          
                        <td>{{ $reqCandi->req_id }}</td>
                        <td>{{ $reqCandi->numero_id }}</td>
                        <td>{{ $reqCandi->nombres }} {{$reqCandi->primer_apellido}} {{$reqCandi->segundo_apellido}}</td>
                       
                        <td>{{$reqCandi->telefono_movil }}</td>
                        <td>
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


                                                    <!-- Contratacion -->

                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_CONTRATACION") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CON<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

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
                                        
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENTRE_TECNI<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENTRE_TECNI<br>

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
                                          
                                                <!-- ENVIO EXAMENES-->
                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_EXAMENES") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                    ENV_EXAME<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_EXAMENES") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_EXAME<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

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

                                                <!-- ENVIO ENTREVISTA VIRTUAL -->
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_ENTRE_VIR<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_ENTRE_VIR<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                                         
                                                @elseif($proce->apto ==null and $proce->proceso == "ENVIO_PRUEBA_IDIOMA") 

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_IDIO<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto ==1 and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_PRUEBA_IDIO<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == null and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CITA_CLI<br>

                                                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_CITA_POR_CLIENTE")

                                                    <div style="text-align: center;" id="respuestas" >
                                                        ENV_CITA_CLI<br>

                                                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                                                @endif

                                            @endforeach
                        </td>
                      </tr>
            @endforeach
        </tr>
    </table>
            @else
            <p>No hay candidatos vinculados</p>
            @endif

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

</div>