<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Clonar Requerimiento</h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["route" => "admin.guardar_requerimiento_copia" ,"method" => "post"]) !!}

        <div class="col-md-12" id="mensaje-resultado">
        
            <div class="alert alert-warning alert-dismissible" role="alert">
                <b><p>Se creara un requerimiento con los datos del seleccionado.</p></b>
            </div>

        </div>

        <div class="col-md-12">

            <div class="box box-info">
                <div class="box-header with-border">
                    <h4 class="box-header with-border">REQUERIMIENTO A COPIAR</h4>
                </div>

                <div class="box-body">
                    <div class="chart">

                        <h4>
                            Requerimiento  <strong># {{$requerimiento->id}}  {{$requerimiento->getCargoEspecifico()->descripcion}}</strong> 
                        </h4>
                        <br>
                        <h4>{{$cliente->nombre}}</h4>
                        <br>

                        @if(route("home") != "http://komatsu.t3rsc.co" && route("home") != "https://komatsu.t3rsc.co")

                            <h5 class="titulo1">INFORMACIÓN GENERAL DE LA SOLICITUD</h5>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                          
                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Tipo de Solicitud</label>

                                <div class="col-sm-8">
                                 {{(!empty($requerimiento->getTipoProceso()))?$requerimiento->getTipoProceso():''}}
                                </div>
                              </div>

                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Ciudad Trabajo</label>

                                <div class="col-sm-8">
                                    {{$requerimiento->sitio_trabajo}}
                                </div>
                              </div>

                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">

                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Unidad de Negocio</label>

                                <div class="col-sm-8">
                                    {{-- {{$requerimiento->getUnidadNegocio()}} --}}
                                    {{ $nombre }}
                                </div>
                              </div>

                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label"></label>

                                <div class="col-sm-8">
                                </div>
                              </div>

                            </div>

                            <h5 class="titulo1">NEGOCIO</h5>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Producción / Administrativos</label>

                                <div class="col-sm-8">
                                    {{$negocio->getGerencia->descripcion}}
                                </div>
                              </div>

                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Sociedad</label>

                                <div class="col-sm-8">
                                    {{ $nombre }}
                                </div>
                              </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Negocio / Gerencia</label>

                                <div class="col-sm-8">
                                    {{-- {{$negocio->nombre_negocio}} --}}
                                    {{ $nombre }}
                                </div>
                              </div>

                              <div class="col-md-6 form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Tipo / Depto</label>

                                <div class="col-sm-8">
                                </div>
                              </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Centro Costo / Area</label>

                                    <div class="col-sm-8">
                                        @if($centro_costo)
                                            {{$centro_costo->centro_costo}}
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"></label>

                                    <div class="col-sm-8">

                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Nombre Solicitante</label>

                                    <div class="col-sm-8">
                                    @if(!empty($requerimiento->solicitado_nombre()))
                                        {{strtoupper($requerimiento->solicitado_nombre())}}
                                    @endif
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Num. Requi Cliente</label>

                                    <div class="col-sm-8">
                                        {{$requerimiento->num_req_cliente}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Teléfono</label>

                                    <div class="col-sm-8">
                                        {{$requerimiento->telefono_solicitante}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"></label>

                                    <div class="col-sm-8">
                                    </div>
                                </div>
                            </div>

                            <h5 class="titulo1">ATRIBUTOS FLEXIBLES</h5>
                
                            @if(count($atributos_textbox) > 0)

                                <div class="row" style="border: solid 1px #f1f1f1;">
                                    @foreach( $atributos_textbox as $atributo_text )
                                        <div class="col-md-6 form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label">{{$atributo_text->nombre_atributo}}</label>

                                            <div class="col-sm-8">   
                                              {{$atributo_text->valor_atributo}}
                                            </div>
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <label for="inputEmail3" class="col-sm-4 control-label"></label>

                                            <div class="col-sm-8">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                            @endif

                            <h5 class="titulo1">ESPECIFICACIONES DEL REQUERIMIENTO</h5>

                            <br>
                            
                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                
                                    <label for="inputEmail3" class="col-sm-4 control-label">Cargo Cliente</label>

                                    <div class="col-sm-8">
                                        {{strtoupper($requerimiento->getCargoEspecifico()->descripcion)}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"></label>

                                    <div class="col-sm-8">
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Centro de Trabajo</label>

                                    <div class="col-sm-8">
                                        {{ $requerimiento->getCentroTrabajo()->nombre_ctra }}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">CenCos Contable</label>

                                    <div class="col-sm-8">
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">CenCos Producción</label>

                                    <div class="col-sm-8">
                                        <!--$centro_costo->descripcion}}-->
                                    </div>
                                </div>

                                @if(route("home") != "http://komatsu.t3rsc.co" && route("home") != "https://komatsu.t3rsc.co")

                                    <div class="col-md-6 form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Jornada Laboral</label>

                                        <div class="col-sm-8">
                                            {{$requerimiento->jornada()->descripcion}}
                                        </div>
                                    </div>

                                @endif

                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Tipo Liquidación</label>
                                    <div class="col-sm-8">
                                        {{(!empty($requerimiento->getTipoLiquidacion()))?$requerimiento->getTipoLiquidacion()->descripcion:''}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">No. Horas Laborales</label>
                                    <div class="col-sm-8">
                                        {{(!empty($requerimiento->jornada()))?$requerimiento->jornada()->procentaje_horas:''}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Tipo Salario</label>
                                    <div class="col-sm-8">
                                        {{(!empty($requerimiento->getTipoSalario()))?$requerimiento->getTipoSalario()->descripcion:''}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Tipo Nómina</label>
                                    <div class="col-sm-8">
                                        {{(!empty($requerimiento->getTipoNomina()))?$requerimiento->getTipoNomina()->descripcion:''}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Concepto Pago</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->getConceptoPagos()->descripcion}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Salario</label>
                                    <div class="col-sm-8">
                                        {{number_format($requerimiento->salario)}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Tipo Contrato</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->getTipoContrato()->descripcion}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Motivo Requerimiento</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->getMotivoRequerimiento()->descripcion}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Número Vacantes</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->num_vacantes}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Observaciones</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->observaciones}}
                                    </div>
                                </div>
                            </div>

                            <h5 class="titulo1">ESTUDIOS</h5>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Nivel Estudio</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->getNivelEstudio()->descripcion}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Funciones a Realizar</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->funciones}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Edad Mínima</label>
                                    <div class="col-sm-8">
                                     {{$requerimiento->edad_minima}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Edad Máxima</label>
                                    <div class="col-sm-8">
                                     {{$requerimiento->edad_maxima}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Género</label>
                                    <div class="col-sm-8">
                                     {{$requerimiento->genero_id}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Estado Civil</label>

                                    <div class="col-sm-8">
                                      {{$requerimiento->estado_civil}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Ingreso</label>
                                    <div class="col-sm-8">
                                     {{$requerimiento->fecha_ingreso}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Retiro</label>
                                    <div class="col-sm-8">
                                      {{$requerimiento->fecha_retiro}}
                                    </div>
                                </div>
                            </div>

                            <h5 class="titulo1">SOPORTE SOLICITUD DE REQUISICION DEL CLIENTE</h5>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Fecha Recepción Solicitud</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->fecha_recepcion}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Contenido Email Soporte</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->contenido_email_soporte}}
                                    </div>
                                </div>
                            </div>

                        @else

                            <h5 class="titulo1">INFORMACIÓN GENERAL DE LA SOLICITUD</h5>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> Codigo Solicitud</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->id}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Sede</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->sede->descripcion}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Area</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->area->descripcion}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> Subarea</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->subarea->descripcion}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Jefe inmediato</label>
                                    <div class="col-sm-8">
                                        @if($requerimiento->solicitud->jefeInmediato())
                                            {{ $requerimiento->solicitud->jefeInmediato()->nombre }}
                                        @endif
                                    </div>
                                </div>
                              
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> Email jefe inmediato</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->email_jefe_inmediato}}
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Centro beneficio</label>
                                    <div class="col-sm-8">
                                        @if(isset($requerimiento->solicitud->centrobeneficio))
                                            {{$requerimiento->solicitud->centrobeneficio->descripcion}}
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> Centro costo</label>
                                    <div class="col-sm-8">
                                        @if(isset($requerimiento->solicitud->centrocosto))
                                            {{$requerimiento->solicitud->centrocosto->descripcion}}
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Tipo contrato</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->tipoContrato()->descripcion}}
                                    </div>
                                </div>

                                @if($requerimiento->solicitud->tiempo_contrato)
                                
                                    <div class="col-md-6 form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Tiempo Contrato</label>
                                        <div class="col-sm-8">
                                            {{$requerimiento->solicitud->tiempo_contrato}}
                                        </div>
                                    </div>

                                @endif

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> Motivo contrato</label>
                                    <div class="col-sm-8">
                                        @if($requerimiento->solicitud->motivo_requerimiento_id!=20)
                                            @if(!empty($requerimiento->solicitud->motivoRequerimiento()))
                                                {{$requerimiento->solicitud->motivoRequerimiento()->descripcion}}
                                            @endif
                                        @else
                                            <strong>{{$requerimiento->solicitud->motivoRequerimiento()->descripcion}}</strong>:{{$requerimiento->solicitud->desc_motivo}}
                                        @endif
                                    </div>
                                </div>
                              
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Numero vacantes</label>

                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->numero_vacante}}
                                    </div>
                                </div>
                             
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> Documento adjunto</label>
                                    <div class="col-sm-8">
                                        <a href="{{ route('home') }}/documentos_solicitud/{{ $requerimiento->solicitud->documento }}" target="_black">
                                            Ver documentos
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Observaciones</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->observaciones}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label"> Recursos</label>
                                    <div class="col-sm-8">
                                        @if($requerimiento->solicitud->recursosNecesarios)
                                            @foreach($requerimiento->solicitud->recursosNecesarios as $recurso)
                                                {{$recurso->recurso_necesario}},
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="border: solid 1px #f1f1f1;">
                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Salario</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->salario}}
                                    </div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Justificación</label>
                                    <div class="col-sm-8">
                                        {{$requerimiento->solicitud->funciones_realizar}}
                                    </div>
                                </div>
                            </div>

                        @endif

                    </div>
                </div>

            </div>

            <input type="hidden" name="req_id" id="req_id" value="{{ $requerimiento->id }}">

            <div class="alert alert-warning alert-dismissible" role="alert">
                <p>COMPLETA LOS SIGUIENTES CAMPOS PARA EL NUEVO REQUERIMIENTO.</p>

                <b><P>PUEDES CREAR MÁS DE UNO DANDO CLICK EN EL BOTÓN +</P></b>
            </div>

            <div id="postulados">
                <div class="row" style="border-bottom: solid 1px #bfbfbf; padding-top: 1.4rem;">
                    <div class="col-md-4 form-group">
                        <div class="col-md-12 campos_select">
                            <label>Ciudad *</label>
                            {!! Form::select('ciudad_trabajo[]', $ciudadesSelect, null, ['id'=>'ciudad_trabajo','class'=>'form-control js-select-2-basic-city', 'required']) !!}
                        </div>
                    </div>

                    <div class="col-md-3 form-group">
                        <div class="col-sm-12">
                            <label>Salario *</label>
                            <input type="number" class="form-control" placeholder="SALARIO" name="salario[]" required="required">
                        </div>
                    </div>

                    <div class="col-md-3 form-group">
                        <div class="col-sm-12">
                            <label>Vacantes *</label>
                            <input type="number" class="form-control" placeholder="VACANTES" name="num_vacantes[]" required="required">
                        </div>
                    </div>

                    <div class="col-md-2 form-group last-child">
                        <button type="button" class="btn btn-success add-person">+</button>
                    </div>

                    <div class="col-md-4 form-group">
                        <div class="col-sm-12">
                            <label>Fecha Tentativa de ingreso *</label>
                            {!! Form::text("fecha_ingreso[]","$fecha_tentativa",["class"=>"form-control", "placeholder"=>"AAAA-MM-DD", "id"=>"fecha_ingreso", "required" => "required"]); !!}
                        </div>
                    </div>

                    <div class="col-md-3 form-group">
                        <div class="col-sm-12">
                            <label>Fecha Retiro *</label>                            
                            {!! Form::text("fecha_retiro[]","$fecha_r_tentativa",["class"=>"form-control", "placeholder"=>"AAAA-MM-DD", "id"=>"fecha_retiro", "required" => "required"]); !!}
                        </div>
                    </div>

                    <div class="col-md-3 form-group">
                        <div class="col-sm-12">
                            <label>Fecha Rec. Solicitud *</label>
                            {!! Form::text("fecha_recepcion[]","$fecha_hoy",["class"=>"form-control","id"=>"fecha_recepcion","readonly"=>true]); !!}
                        </div>
                    </div>
                </div>
            </div>

            <br>

        </div>

        <div class="col-md-12">
            <div class="pull-right">
                <button type="submit" class="btn btn-success">Clonar Requerimiento</button>
            </div>            
        </div>
        
        <div class="clearfix"></div>

    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>    
</div>

<script>
    $(function () {
        
    });
</script>