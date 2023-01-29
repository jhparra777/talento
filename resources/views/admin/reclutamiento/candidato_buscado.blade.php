@foreach($candidatos_req as $candidato_req)

    <tr  @if($candidato_req->important == 1) style="background: #f7fc9b;@endif">
        
        <td>
            {!! Form::hidden("req_id", $req_id) !!}
            
            <input class="check_candi" data-candidato_req="{{$candidato_req->req_candidato_id}}" data-cliente="{{$cliente_id}}" name="req_candidato[]" type="checkbox" value="{{$candidato_req->req_candidato_id}}" @if($boton) disabled @endif/>

            <p class="error text-danger direction-botones-center">
                {!! FuncionesGlobales::getErrorData("numero_candidato",$errors) !!}
            </p>
        </td>
        
        <td>
            {{$candidato_req->numero_id}}
        </td>

        <td>
            {{mb_strtoupper($candidato_req->nombres ." ".$candidato_req->primer_apellido." ".$candidato_req->segundo_apellido)}}
        </td>

        <td>
            {{$candidato_req->telefono_movil}}
        </td>

        <td>
            {{$candidato_req->estado_candidatos}}
            
            @if($candidato_req->llamada_id == null)
 
            @elseif($candidato_req->llamada_id != null && $candidato_req->asis === null )  

                <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

            @elseif($candidato_req->llamada_id != null && $candidato_req->asis == 0 )  

                <hr style="background-color: #dd4b39;height: 5px;margin-top: 1px;margin-bottom: 1px;">

            @elseif($candidato_req->llamada_id != null && $candidato_req->asis == 1 )  

                <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

            @endif
        </td>

        <td>
            @foreach($candidato_req->getProcesos() as $count => $proce)

                @if($proce->apto == null and $proce->proceso == "ENVIO_REFERENCIACION")
                    
                    <div style="text-align: center;" id="respuestas" >
                        ENV_REF<br> 
                    </div> 

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_REFERENCIACION")

                    <div style="text-align: center;" id="respuestas" >
                        ENV_REF<br> 

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                <!-- Contratacion -->
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_CONTRATACION") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_CON<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_CONTRATACION") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_CON<br>

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                    
                <!-- Entrevista -->
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_ENTRE<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                
                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ENTREVISTA") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_ENTRE<br>

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 0 and $proce->proceso == "ENVIO_ENTREVISTA") 

                    <div style="text-align: center;" id="respuestas" >
                    ENV_ENTRE<br>

                    <hr style="background-color: red;height: 5px;margin-top: 1px;margin-bottom: 1px;">
        
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 

                    <div style="text-align: center;" id="respuestas" >
                        ENTRE_TECNI<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ENTREVISTA_TECNICA") 

                    <div style="text-align: center;" id="respuestas" >
                        ENTRE_TECNI<br>

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
    
                <!-- PRUEBAS -->
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBAS") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_PRUE<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBAS") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_PRUE<br>

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                <!-- DOCUMENTOS -->
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_DOCUMENTOS") 

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
                
                <!-- PRUEBAS -->
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBAS") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_PRUE<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBAS") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_PRUE<br>

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                <!-- DOCUMENTOS -->
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_DOCUMENTOS") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_DOCU<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_DOCUMENTOS") 

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
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_APROBAR_CLIENTE") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_CLI<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_APROBAR_CLIENTE") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_CLI<br>

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                <!-- ENVIO ENTREVISTA VIRTUAL -->
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_ENTRE_VIR<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_ENTREVISTA_VIRTUAL") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_ENTRE_VIR<br>

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">
         
                @elseif($proce->apto == null and $proce->proceso == "ENVIO_PRUEBA_IDIOMA") 

                    <div style="text-align: center;" id="respuestas" >
                        ENV_PRUEBA_IDIO<br>

                    <hr style="background-color: #f39c12;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @elseif($proce->apto == 1 and $proce->proceso == "ENVIO_PRUEBA_IDIOMA")

                    <div style="text-align: center;" id="respuestas" >
                        ENV_PRUEBA_IDIO<br>

                    <hr style="background-color: #51beb1;height: 5px;margin-top: 1px;margin-bottom: 1px;">

                @endif

            @endforeach
        </td>

        @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
        
            <td><!-- boton si es interno -->
                @if($candidato_req->trabaja != 0)
                    <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>
                @endif
            </td>
        
        @endif

        <td>
            <!-- Boton de Status -->
            @if($user_sesion->hasAccess("admin.seguimiento_candidato"))

                <button type="button" class="btn btn-sm btn-primary mostrar_seguimiento" data-req_id ="{{$req_id}}" data-cliente="{{$cliente_id}}"  data-candidato_id="{{$candidato_req->candidato_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                    ESTATUS
                </button>

            @endif

            <!-- Boton de whatsapp -->
            @if($user_sesion->hasAccess("boton_ws"))

                <a target="_blank" href="https://api.whatsapp.com/send?phone=57{{ $candidato_req->telefono_movil}}&text=Hola!%20{{$candidato_req->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." class="btn  btn-sm  btn-success aplicar_oferta" @if($boton) disabled @endif>
                    <span class="fa fa-whatsapp fa-lg" aria-hidden="true"></span>
                </a>

            @endif

            <!-- Dropdown información -->
            <div class="btn-group">
                <button type="button" class="btn btn-info">INFORMACIÓN</button>
                
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>

                <ul class="dropdown-menu" role="menu">
                
                    <!-- HV PDF -->
                    @if($user_sesion->hasAccess("admin.hv_pdf"))

                        <a id="hoja_vida" style=" color:#FF0000;  width: 100%;text-decoration:none;color:white;" type="button" class="btn  btn-info btn-sm" href="{{route("admin.hv_pdf",["user_id"=>$candidato_req->user_id])}}" target="_blank">
                            HV PDF
                        </a>

                    @endif

                    <!-- VER FIRMA -->
                    @if(\App\Models\FirmaContratos::firmaContrato($candidato_req->user_id, $req_id) != "")

                        <a style=" color:#FF0000;  width: 100%;text-decoration:none;color:white;" type="button" class="btn  btn-info btn-sm" href="{{ \App\Models\FirmaContratos::firmaContrato($candidato_req->user_id, $req_id) }}" target="_blank">
                            VER FIRMA
                        </a>

                    @endif
        
                    {{-- INFORME DE SELECCION Y BOTON MOSTRAR CONTACTOS --}}
                    @if($user_sesion->hasAccess("admin.hv_pdf"))

                        @if(route('home') == "http://poderhumano.t3rsc.co")
                            
                            <a type="button" style="width: 100%; text-decoration: none; color: white;" class="btn btn-info btn-sm" href="{{route("admin.informe_seleccion",["user_id"=>$candidato_req->req_candidato_id])}}" target="_blank">
                                INFORME SELECCIÓN
                            </a>

                            <li>
                                @if($candidato_req->datos_basicos_activo == 1)

                                    <button type="button" style="width: 100%;"  class="btn btn-sm btn-danger" data-datos ="{{$candidato_req->datos_basicos_id}}" id="datos_contacto_no_mostrar"  >
                                        NO MOSTRAR DATOS CONTACTO
                                    </button>

                                @else

                                    <button type="button" style="width: 100%;" data-datos ="{{$candidato_req->datos_basicos_id}}" class="btn btn-sm btn-info" id="datos_contacto_mostrar">
                                            MOSTRAR DATOS CONTACTO
                                    </button>

                                @endif
                            </li>
     
                        @else
   
                            <a type="button" style="width: 100%;text-decoration:none;color:white" class="btn btn-sm btn-info" href="{{route("admin.informe_seleccion",["user_id"=>$candidato_req->req_candidato_id])}}" target="_blank">
                                INFORME SELECCIÓN
                            </a>

                        @endif
                    @endif
        
                    {{-- VIDEO PERFIL --}}
                    @if($user_sesion->hasAccess("boton_video_perfil"))

                        @if($candidato_req->video != null )
                            <a type="button" data-candidato_id ="{{$candidato_req->user_id}}" style="width: 100%;text-decoration: none; color: white;" class="btn btn-sm btn-info video_perfil"  target="_blank">
                                VIDEO PERFIL
                            </a>
                        @endif

                    @endif

                    @if($candidato_req->getObservaciones() != null )

                        <a type="button" data-req_can_id = "{{$candidato_req->req_candidato_id}}" style="width: 100%;text-decoration: none; color: white;" class="btn btn-sm btn-info btn_observaciones"  target="_blank">
                            OBSERVACIONES
                        </a>

                    @endif

                    @if(route('home') == "http://localhost:8000" || route('home') == "http://demo.t3rsc.co" || route('home') == "https://demo.t3rsc.co")

                        <button style="width: 100%" type="button" class="btn btn-info btn-sm btn_citar_to_cliente" data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                            CITAR PARA CLIENTE
                        </button>

                    @endif

                </ul>
            </div>
            
            <!-- Dropdown proceso -->
            <div class="btn-group">

                <button type="button" class="btn btn-warning">PROCESO</button>

                <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" @if($boton) disabled @endif>
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>

                <ul class="dropdown-menu" role="menu">

                    @if ($valida_botones !== null)

                        @foreach ($valida_botones as $validar)

                            <!-- Boton validación documental -->
                            @if($validar->valor == "validacion")
                
                                @if($user_sesion->hasAccess("admin.enviar_documento_view"))

                                    @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")
                                        
                                        <li>
                                            <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_DOCUMENTOS","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-info btn-sm btn_documento " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                                ESTUDIO DE SEGURIDAD
                                            </button>
                                        </li>

                                    @else
                                        
                                        <li>
                                            <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_DOCUMENTOS","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-info btn-sm btn_documento " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                                VALIDACIÓN DOCUMENTAL
                                                </button>
                                        </li>

                                    @endif

                                @endif
                            
                            @endif

                            <!-- Boton referenciar -->
                            @if($validar->valor == "referenciacion")
                
                                @if($user_sesion->hasAccess("admin.enviar_referenciacion_view"))
                                    
                                    <li>
                                        <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_REFERENCIACION","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm btn-info btn_referenciacion " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                            REFERENCIAR
                                        </button>
                                    </li>

                                @endif
            
                            @endif

                            <!-- Boton pruebas -->
                            @if($validar->valor == "pruebas_psicotecnicas")
                
                                @if($user_sesion->hasAccess("admin.enviar_pruebas_view"))

                                    <li>
                                        <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_PRUEBAS","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm  btn-info btn_pruebas" data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                            PRUEBAS
                                        </button>
                                    </li>

                                @endif
                            
                            @endif

                            <!-- Boton entrevista -->
                            @if($validar->valor == "entrevista" || $validar->valor == "sinficha")
                
                                @if($user_sesion->hasAccess("admin.enviar_entrevista_view"))
                                    
                                    <li>
                                        <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_ENTREVISTA","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-info btn-sm btn_entrevista " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}" data-route="{{route('home')}}">
                                            ENTREVISTA
                                        </button>
                                    </li>

                                @endif

                            @endif

                            <!-- Boton entrevista virtual -->
                            @if($entrevista_virtual->count() != 0)

                                <li>
                                    <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_ENTREVISTA_VIRTUAL","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-info btn-sm btn_video_entrevista" data-cliente="{{$cliente_id}}" data-user_id="{{$candidato_req->user_id}}" data-req_id="{{$req_id}}" data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}" data-candidato="{{$candidato_req->candidato_id}}">
                                        ENTREVISTA VIRTUAL
                                    </button>
                                </li>

                            @endif

                        @endforeach
                    
                    @else

                        <!-- Boton validación documental -->
                        @if($user_sesion->hasAccess("admin.enviar_documento_view"))

                            @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")
                                
                                <li>
                                    <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_DOCUMENTOS","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-info btn-sm btn_documento " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                        ESTUDIO DE SEGURIDAD
                                    </button>
                                </li>

                            @else
                                
                                <li>
                                    <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_DOCUMENTOS","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-info btn-sm btn_documento " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                        VALIDACIÓN DOCUMENTAL
                                    </button>
                                </li>

                            @endif

                        @endif

                        <!-- Boton referenciar -->
                        @if($user_sesion->hasAccess("admin.enviar_referenciacion_view"))
                            
                            <li>
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_REFERENCIACION","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm btn-info btn_referenciacion " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                    REFERENCIAR
                                </button>
                            </li>

                        @endif

                        <!-- Boton pruebas -->
                        @if($user_sesion->hasAccess("admin.enviar_pruebas_view"))
                            
                            <li>
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_PRUEBAS","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm  btn-info btn_pruebas" data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                    PRUEBAS
                                </button>
                            </li>

                        @endif

                        <!-- Boton entrevista -->
                        @if($user_sesion->hasAccess("admin.enviar_entrevista_view"))
                            <li>
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_ENTREVISTA","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-info btn-sm btn_entrevista " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}" data-route="{{route('home')}}">
                                    ENTREVISTA
                                </button>
                            </li>
                        @endif

                    @endif

                    <!-- Boton entrevista virtual -->
                    @if($entrevista_virtual->count() != 0)
                        
                        <li>
                            <button style="width: 100%" {!! ( (funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,
                                ["ENVIO_ENTREVISTA_VIRTUAL","ENVIO_CONTRATACION"]) ) ? "disabled='disabled'" : "" ) !!}  type="button"
                                class="btn btn-info btn-sm btn_video_entrevista" data-cliente="{{$cliente_id}}" data-req_id="{{$req_id}}" data-user_id="{{$candidato_req->user_id}}" data-cliente="{{$cliente_id}}"
                                data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                ENTREVISTA VIRTUAL
                            </button>
                        </li>

                    @endif

                    <!-- Boton prueba idioma -->
                    @if($prueba_idioma->count() != 0)
                        <li>
                            <button style="width: 100%" {!! ( (funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,
                                ["ENVIO_PRUEBA_IDIOMA","ENVIO_CONTRATACION"]) ) ? "disabled='disabled'" : "" ) !!}  type="button"
                                class="btn btn-info btn-sm btn_prueba_idioma" data-cliente="{{$cliente_id}}" data-req_id="{{$req_id}}" data-user_id="{{$candidato_req->user_id}}" data-cliente="{{$cliente_id}}"
                                data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                PRUEBA IDIOMA
                            </button>
                        </li>
                    
                    @endif

                    <!-- Examenes medicos -->  
                    @if(route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000" || route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")    
                        
                        <li>
                            <button type="button" style="width: 100%" {!! ((FuncionesGlobales::validaBotonProcesos($candidato_req->req_candidato_id,["ENVIO_EXAMENES","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!} class="btn btn-info btn-sm btn-enviar-examenes" data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                EXAMENES MEDICOS
                            </button>
                        </li>

                    @endif

                    @if ( route("home") === "http://soluciones.t3rsc.co" || route("home") === "https://soluciones.t3rsc.co" ||
                          route("home") === "http://tiempos.t3rsc.co" || route("home") === "https://tiempos.t3rsc.co"
                          || route("home") === "http://localhost:8000" ||
                          route("home") === "http://desarrollo.t3rsc.co" || route("home") === "https://desarrollo.t3rsc.co")
                        <li>
                            <button style="width: 100%" type="button" onclick="unafuncion({{$candidato_req->numero_id}}, {{$candidato_req->user_id}}, {{$candidato_req->req_id}}, {{$cliente_id}});" class="btn btn-sm btn-info">
                                CONSULTA DE SEGURIDAD
                            </button>

                        </li>
                    @endif

                </ul>
            
            </div>

            <!-- Nav Verificación -->
            <div class="btn-group">
                <button class="btn btn-success" type="button">VERIFICACIÓN</button>
                
                <button class="btn btn-success dropdown-toggle" data-toggle="dropdown" type="button">
                    <span class="caret">
                    </span>
                    <span class="sr-only">
                        Toggle Dropdown
                    </span>
                </button>

                <ul class="dropdown-menu" role="menu">
    
                    <!-- Boton informe preliminar -->
                    @if($user_sesion->hasAccess("admin.informe_preliminar_formulario"))

                        @if(\App\Models\PreliminarTranversalesCandidato::realizoInformePreliminar($candidato_req->user_id, $req_id) == "")
                            
                            <li>
                                <button style="width: 100%"  class="btn btn-sm btn-info get_informe_preliminar" data-candidato_user="{{$candidato_req->user_id}}" data-cliente="{{$cliente_id}}" data-valida_boton="false" type="button" @if($boton) disabled @endif>
                                    INFORME PRELIMINAR
                                </button>
                            </li>

                        @else
                            
                            <li>
                                <button style="width: 100%" class="btn btn-sm btn-info get_informe_preliminar" data-candidato_user="{{$candidato_req->user_id}}" data-cliente="{{$cliente_id}}" data-valida_boton="true" type="button" @if($boton) disabled @endif>
                                    ACTUALIZA INFORME PRELIMINAR
                                </button>
                            </li>

                        @endif
                    @endif

                    <!-- Boton asistio -->
                    @if(route('home')!= "http://talentum.t3rsc.co")

                        <li>
                            @if($candidato_req->asistio !=1)
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-info btn-sm btn_asistencia " data-req_id="{{$candidato_req->req_id}}" data-candidato_id="{{$candidato_req->candidato_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                    ASISTIÓ
                                </button>
                            @else
                                <button style="width: 100%" type="button" class="btn btn-info btn-sm  " disabled>
                                    ASISTIÓ
                                </button>
                            @endif
                        </li>

                    @endif

                    <!-- Boton enviar a aprobar cliente -->
                    @if($user_sesion->hasAccess("admin.enviar_aprobar_cliente_view"))

                        @if(route("home")=="http://komatsu.t3rsc.co" || route("home")=="https://komatsu.t3rsc.co")
                            
                            <li>
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_APROBAR_CLIENTE","ENVIO_CONTRATACION_CLIENTE","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm btn-info btn_aprobar_cliente " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                    ENVIAR A APROBAR
                                </button>
                            </li>

                        @else

                            <li>
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_APROBAR_CLIENTE","ENVIO_CONTRATACION_CLIENTE","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm btn-info btn_aprobar_cliente " data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                    ENVIAR A APROBAR CLIENTE
                                </button>
                            </li>

                        @endif
                    @endif

                    <!-- Boton contratar -->
                    @if($contra_cliente->count() != 0)

                        @if($user_sesion->hasAccess("admin.enviar_contratar"))
                            
                            <li>
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonestado($candidato_req->req_candidato_id,config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm btn-info btn_contratar" data-cliente="{{$cliente_id}}" data-user_id ="{{ $candidato_req->user_id }}" data-candidato_req="{{$candidato_req->req_candidato_id}}" data-req_id="{{$candidato_req->req_id}}">
                                    CONTRATAR
                                </button>
                            </li>

                        @endif

                    @else

                        @if($user_sesion->hasAccess("admin.enviar_contratar"))
                            
                            <li>
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonestado($candidato_req->req_candidato_id,config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm  btn-info btn_contratar2" data-cliente="{{$cliente_id}}"  data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                    CONTRATAR <!-- Este es -->
                                </button>
                            </li>

                        @endif

                    @endif

                    <!-- Imprimi paquete de contratación -->
                    @if($user_sesion->hasAccess("admin.paquete_contratacion_pdf"))

                        <a style="width: 100%" href="{{route('admin.paquete_contratacion_pdf',['id'=>
                            $candidato_req->req_candidato_id])}}" target="_blank" class="btn btn-sm btn-info" data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                            {{-- IMPRIMIR --}} PAQUETE DE CONTRATACIÓN
                        </a>

                    @endif

                </ul>
            </div>

            <!-- Nav de comunicación -->
            <div class="btn-group">
                <button type="button" class="btn btn-danger">ACCIÓN</button>

                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" @if($boton) disabled @endif>
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>

                <ul class="dropdown-menu" role="menu">
                    
                    <!-- Boton vincular -->
                    @if($user_sesion->hasAccess("admin.vincular"))

                        @if($user_sesion->hasAccess("boton_ws"))
                            <li>
                                <button style="width: 100%" {!! ((funcionesglobales::validabotonprocesos($candidato_req->req_candidato_id,["ENVIO_VALIDACION","ENVIO_CONTRATACION"]))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm btn-info btn_enviar_vincular" data-cliente="{{$cliente_id}}"  data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                    ENVIAR A VINCULAR
                                </button>
                            </li>
                        @endif

                    @endif

                    <!-- Boton rechazar candidato -->
                    @if($user_sesion->hasAccess("admin.rechazar_candidato_view"))
                        
                        <li>
                            <button style="width: 100%" {!! ((funcionesglobales::validabotonestado($candidato_req->req_candidato_id,config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm btn-info btn_rechazar" data-cliente="{{$cliente_id}}" data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                RECHAZAR CANDIDATO
                            </button>
                        </li>

                    @endif

                    <!-- Boton quitar -->
                    @if($user_sesion->hasAccess("admin.quitar_candidato_view"))
                        
                        <li>
                            <button style="width: 100%" {!! ((funcionesglobales::validabotonestado($candidato_req->req_candidato_id,config('conf_aplicacion.C_EN_PROCESO_CONTRATACION')))?"disabled='disabled'":"") !!}  type="button" class="btn btn-sm btn-info btn_quitar"  data-candidato_req="{{$candidato_req->req_candidato_id}}">
                                QUITAR
                            </button>
                        </li>

                    @endif

                    <!-- Boton citar -->
                    @if($user_sesion->hasAccess("admin.proceso_citacion"))
                        
                        <li>
                            <button style="width: 100%" class="btn btn-sm btn-info modal_citacion " data-candidato_req="{{$candidato_req->req_candidato_id}}" data-candidato_user="{{$candidato_req->user_id}}" data-cliente="{{$cliente_id}}" type="button">
                                CITAR
                            </button>
                        </li>

                    @endif
                
                </ul>
            </div>
            
            </div>
        </td>
    </tr>

@endforeach