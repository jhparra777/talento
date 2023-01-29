@if(route("home") == "https://komatsu.t3rsc.co")
    <div class="col-md-12">
        <div class="box box-info collapsed-box | tri-bt-purple">
            <div class="box-header with-border">
                <h3 class="box-title | tri-fs-14">INFORMACIÓN GENERAL DE LA SOLICITUD</h3>

                <div class="box-tools pull-right">
                    <button 
                        type="button"
                        class="btn btn-box-tool" 
                        data-widget="collapse" 

                        data-toggle="tooltip"
                        data-placement="top"
                        data-container="body"
                        title="Despliega para ver la información del requerimiento.">
                        <i class="fas fa-eye" aria-hidden="true"></i> Ver más
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="chart">
                    <table class="table">
                        <tr>
                            <th class="width-perc"> No. Solicitud </th>
                            <td class="width-perc"> {{ $solicitud->id }} </td>
                            <th class="width-perc"> Fecha creación </th>
                            <td class="width-perc"> {{ $solicitud->created_at }} </td>
                        </tr>

                        <tr>
                            <th class="width-perc">
                                Sede
                            </th>
                            <td class="width-perc"> 
                                {{ $solicitud->sede->descripcion }}
                            </td>
                            <th class="width-perc">
                                Motivo contrato
                            </th>
                            <td class="width-perc">
                                @if($solicitud->motivo_requerimiento_id != 20)
                                    @if(!empty($solicitud->motivoRequerimiento()))
                                        {{ $solicitud->motivoRequerimiento()->descripcion }}
                                    @endif
                                @else
                                    {{ $solicitud->desc_motivo }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            @if(isset($solicitud->centrobeneficio))
                                <th class="width-perc">Centro beneficio</th>
                                <td class="width-perc">{{ $solicitud->centrobeneficio->descripcion }}</td>
                            @endif
                            
                            @if(isset($solicitud->centrocosto))
                                <th class="width-perc">Centro costo</th>
                                <td class="width-perc">{{ $solicitud->centrocosto->descripcion }}</td>
                            @endif
                        </tr>

                        @if(isset($requermiento->centro_costo_cliente))
                            <tr>
                                <th class="width-perc">Centro costo cliente</th>
                                <td class="width-perc">
                                    {{ $requermiento->centro_costo_cliente }}
                                </td>

                                <th class="width-perc">Unidad negocio</th>
                                <td class="width-perc">
                                    {{ strtoupper($requermiento->unidad_negocio) }}
                                </td>
                            </tr>

                            <tr>
                                <th class="width-perc">Tipo turno</th>
                                <td class="width-perc">
                                    {{ $requermiento->tipo_turno }}
                                </td>

                                <th class="width-perc"></th>
                                <td class="width-perc">
                                </td>
                            </tr>
                        @endif

                        <tr>
                            <th class="width-perc">Area</th>
                            <td class="width-perc"> {{ $solicitud->area->descripcion }}</td>
                            <th class="width-perc">Sub-area</th>
                            <td class="width-perc"> {{ $solicitud->subarea->descripcion }}</td>
                        </tr>

                        <tr> 
                            <th class="width-perc">Jefe inmediato</th>
                            <td class="width-perc">
                                @if($solicitud->jefeInmediato())
                                    {{ $solicitud->jefeInmediato()->nombre }}
                                @endif
                            </td>
                            <th class="width-perc">Email jefe inmediato</th>
                            <td class="width-perc"> {{ $solicitud->email_jefe_inmediato }}</td>
                        </tr>

                        <tr>
                            <th class="width-perc">Tipo contrato</th>
                            <td class="width-perc">{{ $solicitud->tipoContrato()->descripcion }}</td>

                            @if(!empty($solicitud->tiempo_contrato))
                                <th class="width-perc">Tiempo Contrato</th>
                                <td class="width-perc">{{ $solicitud->tiempo_contrato }}</td>
                            @endif
                        </tr>

                        <tr>
                            <th class="width-perc">Numero vacantes</th>
                            <td class="width-perc">{{ $solicitud->numero_vacante }}</td>
                            <th class="width-perc">Observaciones</th>
                            <td class="width-perc">{{ $solicitud->observaciones }}</td>
                        </tr>

                        <tr>
                            <th class="width-perc">Salario</th>
                            <td class="width-perc">{{ $solicitud->salario }}</td>
                            <th class="width-perc">recursos</th>
                            <td class="width-perc">
                                @if($solicitud->recursosNecesarios)
                                    @foreach($solicitud->recursosNecesarios as $recurso)
                                        {{ $recurso->recurso_necesario }},
                                    @endforeach
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="width-perc"> Estudio Virtual de Seguridad </th>
                            <td class="width-perc"> {{ $requermiento->tipo_evs->descripcion }} </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Documento adjunto</th>
                            <td class="width-perc">
                                <a href="{{ route('home') }}/documentos_solicitud/{{ $solicitud->documento }}" target="_black">Ver documentos</a>
                            </td>
                            <th class="width-perc">Justificación</th>
                            <td class="width-perc">{{ $solicitud->funciones_realizar }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@elseif(route("home") == "https://gpc.t3rsc.co")
    <div class="col-md-12">
        <div class="box box-info collapsed-box | tri-bt-purple">
            <div class="box-header with-border">
                <h3 class="box-title | tri-fs-14">
                    INFORMACIÓN GENERAL DE LA SOLICITUD
                </h3>

                <div class="box-tools pull-right">
                    <button 
                        type="button"
                        class="btn btn-box-tool" 
                        data-widget="collapse" 

                        data-toggle="tooltip"
                        data-placement="top"
                        data-container="body"
                        title="Despliega para ver la información del requerimiento.">
                        <i class="fa fa-eye" aria-hidden="true"></i> Ver más
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="chart">
                    <table class="table">
                        <tr>
                            <th class="width-perc">Nombre del proceso</th>
                            <td class="width-perc">
                                {{ $requermiento->id }}
                            </td>

                            <th class="width-perc">Cliente</th>
                            <td class="width-perc">
                                {{ $cliente->nombre }}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Fecha Ingreso requerimiento</th>
                            <td class="width-perc">
                                {{ $requermiento->created_at }}
                            </td>

                            <th class="width-perc">Ciudad</th>
                            <td class="width-perc">
                                {{ $requermiento->getCiudad() }}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Tipo Requerimiento</th>
                            <td class="width-perc">
                               {{ $requermiento->tipo_proceso_req() }}
                            </td>

                            <th class="width-perc">Contacto</th>
                            <td class="width-perc">
                                {{ strtoupper($cliente->contacto) }}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Cargo genérico</th>
                            <td class="width-perc">
                                {{ strtoupper($requermiento->nombre_cargo) }}
                            </td>

                            <th class="width-perc">Numero de Personal</th>
                            <td class="width-perc">
                                {{ $requermiento->num_vacantes }}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Cargo específico</th>
                            <td class="width-perc">
                                @if($requermiento->getCargoEspecifico()!=null)
                                    {{ $requermiento->getCargoEspecifico()->descripcion }}
                                @endif
                            </td>

                            <th class="width-perc">Estado Requerimiento</th>
                            <td class="width-perc">
                                @if($requermiento->estadoRequerimiento()!=null)
                                    {{ strtoupper($requermiento->estadoRequerimiento()->estado_nombre) }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="width-perc"> Estudio Virtual de Seguridad </th>
                            <td class="width-perc"> {{ $requermiento->tipo_evs->descripcion }} </td>
                        </tr>

                        @if(isset($requermiento->centro_costo_cliente))
                        <tr>
                          <th class="width-perc">Centro costo cliente</th>
                          <td class="width-perc"> {{ $requermiento->centro_costo_cliente }} </td>

                            <th class="width-perc">Unidad negocio</th>
                            <td class="width-perc">
                                {{strtoupper($requermiento->unidad_negocio)}}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Tipo turno</th>
                            <td class="width-perc">
                                {{ $requermiento->tipo_turno }}
                            </td>

                            <th class="width-perc"></th>
                            <td class="width-perc">
                            </td>
                        </tr>
                        @endif
                    </table>

                    <div class="col-md-12 text-center mb-2 | text-white tri-gray" style="border-radius: 1rem 1rem 0rem 0rem;">
                        <h4>ESPECIFICACIONES DEL REQUERIMIENTO</h4>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th class="width-perc">Cargo Cliente</th>
                            <td class="width-perc">
                                @if($requermiento->getCargoEspecifico() != null)
                                    {{ strtoupper($requermiento->getCargoEspecifico()->descripcion) }}
                                @endif
                            </td>

                            <th class="width-perc">Jornada Laboral</th>
                            <td class="width-perc">
                                @if($requermiento->jornada() != null)
                                    {{$requermiento->jornada()->descripcion}}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Tiempo de Trabajo</th>
                            <td class="width-perc">
                                @if($requermiento->jornada() != null)
                                    {{ $requermiento->jornada()->procentaje_horas }}
                                @endif
                            </td>

                            {{--<th class="width-perc">Tipo Salario</th>
                            <td class="width-perc">
                                {{$requermiento->getTipoSalario()->descripcion}}
                            </td>--}}
                        </tr>
                        
                        <tr>
                            <th class="width-perc">Salario</th>
                            <td class="width-perc">
                                {{ number_format($requermiento->salario, 2) }}- {{ $requermiento->salario_max }}
                            </td>

                            <th class="width-perc">Tipo Contrato</th> 
                            <td class="width-perc">
                                @if($requermiento->getTipoContrato() != null)
                                    {{ $requermiento->getTipoContrato()->descripcion }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Motivo Requerimiento</th>
                            <td class="width-perc">
                                {{ $requermiento->getMotivoRequerimiento()->descripcion }}
                            </td>

                            <th class="width-perc">Motivo contrato</th>
                            <td class="width-perc">
                                {{ $requermiento->motivo_contrato }}
                            </td>

                            <th class="width-perc">Número de Personal</th>
                            <td class="width-perc">
                                {{ $requermiento->num_vacantes }}
                            </td>

                            @if(!empty($requermiento->documento))
                                <th class="width-perc"> Documento adjunto </th>
                                <td class="width-perc">
                                    <a href="{{ route('home') }}/documentos_solicitud/{{ $requermiento->documento }}" target="_black">
                                    Ver documentos</a>
                                </td>
                            @endif
                        </tr>

                        <tr>
                            <th class="width-perc">Observaciones</th>
                            <td class="width-perc">
                                {{ strtoupper($requermiento->observaciones) }}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Conocimientos específicos</th>
                            <td class="width-perc">
                                {{ strtoupper($requermiento->conocimientos_especificos) }}
                            </td>
                        </tr>
                    </table>

                    <div class="col-md-12 text-center mb-2 | text-white tri-gray" style="border-radius: 1rem 1rem 0rem 0rem;">
                        <h4>ESTUDIOS</h4>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th class="width-perc">Nivel Estudio</th>
                            <td class="width-perc">
                                {{ $requermiento->getNivelEstudio()->descripcion }}
                            </td>

                            <th class="width-perc">Funciones a Realizar</th>
                            <td class="width-perc">
                                {{ strtoupper($requermiento->funciones) }}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Edad Mínima</th>
                            <td class="width-perc">
                                {{ $requermiento->edad_minima }}
                            </td>

                            <th class="width-perc">Edad Máxima</th>
                            <td class="width-perc">
                                {{ $requermiento->edad_maxima }}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Género</th>
                            <td class="width-perc">
                                @if($requermiento->getDescripcionGenero() != "")
                                    {{ $requermiento->getDescripcionGenero()->descripcion }}
                                @endif
                            </td>

                            <th class="width-perc">Estado Civil</th>
                            <td class="width-perc">
                                @if($requermiento->getDescripcionEstadoCivil() != "")
                                    {{ $requermiento->getDescripcionEstadoCivil()->descripcion }}
                                @endif
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Fecha Ingreso</th>
                            <td class="width-perc">
                                {{ $requermiento->fecha_ingreso }}
                            </td>
                        </tr>

                        <tr>
                            <th class="width-perc">Creado Por</th>
                            <td class="width-perc">{{ $requermiento->solicitante }}</td>
                        </tr>
                    </table>

                    <div class="col-md-12 text-center mb-2 | text-white tri-gray" style="border-radius: 1rem 1rem 0rem 0rem;">
                        <h4>IDIOMA</h4>
                    </div>

                    <table class="table">
                        <tr>
                            <th class="width-perc">Idioma</th>
                            <td class="width-perc">
                                {{ $requermiento->descripcion_idioma() }}
                            </td>

                            <th class="width-perc">Nivel idioma</th>
                            <td class="width-perc">
                                {{ $requermiento->descripcion_nivel_idioma() }}
                            </td>
                        </tr>
                    </table>

                    <div class="col-md-12 text-center mb-2 | text-white tri-gray" style="border-radius: 1rem 1rem 0rem 0rem;">
                        <h4>CANDIDATOS POSTULADOS</h4>
                    </div>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Identificacíon</th>
                                <th>Fijo</th>
                                <th>Móvil</th>
                                <th>E-mail</th>
                            </tr>
                        </thead>

                        @foreach ($candidatos_postulados as $count => $candidatos)
                            <tbody>
                                <tr>
                                    <td class="width-perc">{{ ++$count }}</td>
                                    <td>{{ $candidatos->nombres }}</td>
                                    <td>{{ $candidatos->cedula }}</td>
                                    <td>{{ $candidatos->telefono }}</td>
                                    <td>{{ $candidatos->celular }}</td>
                                    <td>{{ $candidatos->email }}</td>
                                </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="col-md-12">
        <div class="box box-info collapsed-box | tri-bt-purple tri-br-1">
            <div class="box-header with-border">
                <h3 class="box-title | tri-fs-14">
                    INFORMACIÓN GENERAL DE LA SOLICITUD @if(route("home") == "http://tiempos.t3rsc.co" || route("home") == "https://tiempos.t3rsc.co") 
                    <strong> ("NO DEBE CARGAR MAS DE 200 CANDIDATOS") @endif </strong>
                </h3>

                <div class="box-tools pull-right">
                    <button 
                        type="button"
                        class="btn btn-box-tool" 
                        data-widget="collapse" 

                        data-toggle="tooltip"
                        data-placement="top"
                        data-container="body"
                        title="Despliega para ver la información del requerimiento.">
                        <i class="fa fa-eye" aria-hidden="true"></i> Ver más
                    </button>
                </div>
            </div>

            <div class="box-body">
                <div class="chart">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th class="width-perc"> No. Requerimiento </th>
                                    <td class="width-perc"> {{ $requermiento->id }} </td>
                                    
                                    <th class="width-perc"> Cliente </th>
                                    <td class="width-perc"> {{ $cliente->nombre }} </td>
                                </tr>
                                <tr>
                                    <th class="width-perc"> Fecha Ingreso requerimiento </th>
                                    <td class="width-perc"> {{ $requermiento->created_at }} </td>
                                    
                                    <th class="width-perc"> Ciudad </th>
                                    <td class="width-perc"> {{ $requermiento->getCiudad() }} </td>
                                </tr>
                                <tr>
                                    <th class="width-perc"> Tipo Requerimiento </th>
                                    <td class="width-perc"> {{ $requermiento->tipo_proceso_req() }} </td>
                                    
                                    <th class="width-perc"> Contacto </th>
                                    <td class="width-perc"> {{ strtoupper($cliente->contacto) }} </td>
                                </tr>
                                <tr>
                                    <th class="width-perc"> Numero Vacantes </th>
                                    <td class="width-perc"> {{ $requermiento->num_vacantes }} </td>
                                </tr>
                                <tr>
                                    <th class="width-perc"> Cargo específico </th>
                                    <td class="width-perc">
                                        @if($requermiento->getCargoEspecifico() != null)
                                            {{ $requermiento->getCargoEspecifico()->descripcion }}
                                        @endif
                                    </td>
                                    
                                    <th class="width-perc"> Estado Requerimiento </th>
                                    <td class="width-perc">
                                        @if($requermiento->estadoRequerimiento()!=null)
                                            {{ strtoupper($requermiento->estadoRequerimiento()->estado_nombre) }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th class="width-perc"> Estudio Virtual de Seguridad </th>
                                    <td class="width-perc"> {{ $requermiento->tipo_evs->descripcion }} </td>
                                </tr>

                                @if(isset($requermiento->centro_costo_cliente))
                                    <tr>
                                        <th class="width-perc">Unidad negocio</th>
                                        <td class="width-perc"> {{ strtoupper($requermiento->unidad_negocio) }} </td>
                                    </tr>

                                    <tr>
                                        <th class="width-perc">Tipo turno</th>
                                        <td class="width-perc"> {{ $requermiento->tipo_turno }} </td>
                                    </tr>
                                @endif

                                @if(!empty($requermiento->documento))
                                    <th class="width-perc"> Documento adjunto </th>
                                    <td class="width-perc"> 
                                        <a href="{{ route('home') }}/documentos_solicitud/{{$requermiento->documento}}" target="_black"> Ver documentos</a>
                                    </td>
                                @endif
                            </table>
                        </div>
                    </div>

                    {{-- Más Detalle Requerimiento --}}
                    <div class="col-md-12 text-center mb-2 | text-white tri-gray" style="border-radius: 1rem 1rem 0rem 0rem;">
                        <h4>ESPECIFICACIONES DEL REQUERIMIENTO</h4>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th class="width-perc"> Cargo Cliente </th>
                                    <td class="width-perc">
                                        {{ strtoupper($requermiento->getCargoEspecifico()->descripcion) }}
                                    </td>
                                    
                                    {{-- <th class="width-perc"> Clase de riesgo </th>
                                    <td class="width-perc"> {{ $requermiento->getCentroTrabajo()->nombre_ctra }} </td> --}}
                                </tr>
                                
                                <tr>
                                    <th class="width-perc"> Jornada Laboral </th>
                                    <td class="width-perc">
                                        @if($requermiento->jornada()!=null)
                                        {{ $requermiento->jornada()->descripcion }}
                                        @endif
                                    </td>
                                    
                                    {{-- <th class="width-perc"> Tipo Liquidación </th>
                                    <td class="width-perc">
                                        {{ ($requermiento->tipo_liquidacion)?$requermiento->getTipoLiquidacion()->descripcion:"" }}
                                    </td> --}}
                                </tr>

                                <tr>
                                    <th class="width-perc">No. Horas Laborales</th>
                                    <td class="width-perc">
                                        @if($requermiento->jornada()!=null)
                                            {{ $requermiento->jornada()->procentaje_horas }}
                                        @endif
                                    </td>
                                    
                                    <th class="width-perc"> Tipo Salario </th>
                                    <td class="width-perc">
                                        {{ $requermiento->getTipoSalario()->descripcion }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="width-perc">
                                        Tipo Nómina
                                    </th>
                                    <td class="width-perc">
                                        {{ $requermiento->getTipoNomina()->descripcion }}
                                    </td>
                                    
                                    <th class="width-perc">
                                        Concepto Pago
                                    </th>
                                    <td class="width-perc">
                                        {{ $requermiento->getConceptoPagos()->descripcion }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="width-perc"> Salario </th>
                                    <td class="width-perc"> {{ number_format($requermiento->salario) }} </td>
                                    
                                    <th class="width-perc"> Tipo Contrato </th>
                                    <td class="width-perc"> 
                                        @if( $requermiento->getTipoContrato()!=null)
                                            {{ $requermiento->getTipoContrato()->descripcion }}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="width-perc">
                                        Adicionales Salariales
                                    </th>

                                    <td colspan="3" class="width-perc">
                                        {{$requermiento->adicionales_salariales}}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="width-perc">
                                        Motivo Requerimiento
                                    </th>
                                    <td class="width-perc"> 
                                        {{ $requermiento->getMotivoRequerimiento()->descripcion }}
                                    </td>

                                    <th class="width-perc">
                                        Número Vacantes
                                    </th>
                                    <td class="width-perc">
                                        {{ $requermiento->num_vacantes }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="width-perc">
                                        Observaciones
                                    </th>
                                    <td class="width-perc">
                                        {{ strtoupper($requermiento->observaciones) }}
                                    </td>

                                    <th class="width-perc"> Funciones a Realizar </th>
                                    <td class="width-perc"> {{ strtoupper($requermiento->funciones) }} </td>
                                </tr>

                                @if(route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co")
                                    <tr>
                                        <th class="width-perc"> Dotacion </th>
                                        <td> {{ strtoupper($requermiento->detalle_dotacion) }} </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    {{-- Más Detalle Requerimiento --}}
                    <div class="col-md-12 text-center mb-2 | text-white tri-gray" style="border-radius: 1rem 1rem 0rem 0rem;">
                        <h4>ESTUDIOS</h4>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th class="width-perc"> Nivel Estudio </th>
                                    <td class="width-perc"> {{ $requermiento->getNivelEstudio()->descripcion }} </td>
                                    
                                    <th class="width-perc"> Tiempo Experiencia </th>
                                    <td class="width-perc"> {{ $requermiento->experiencia_req() }} </td>
                                </tr>

                                <tr>
                                    <th class="width-perc">Edad Mínima</th>
                                    <td class="width-perc">
                                        {{ $requermiento->edad_minima }}
                                    </td>

                                    <th class="width-perc">
                                        Edad Máxima
                                    </th>
                                    <td class="width-perc">
                                        {{ $requermiento->edad_maxima }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="width-perc">
                                        Género
                                    </th>
                                    <td class="width-perc">
                                        @if($requermiento->getDescripcionGenero() != "")
                                            {{ $requermiento->getDescripcionGenero()->descripcion }}
                                        @endif
                                    </td>

                                    <th class="width-perc">
                                        Estado Civil
                                    </th>
                                    <td class="width-perc">
                                        @if($requermiento->getDescripcionEstadoCivil() != "")
                                            {{ $requermiento->getDescripcionEstadoCivil()->descripcion }}
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th class="width-perc">
                                        Fecha Ingreso
                                    </th>
                                    <td class="width-perc">
                                        {{ $requermiento->fecha_ingreso }}
                                    </td>

                                    <th class="width-perc">
                                        Fecha Retiro
                                    </th>
                                    <td class="width-perc">
                                        {{ $requermiento->fecha_retiro }}
                                    </td>
                                </tr>

                                <tr>
                                    <th class="width-perc">Creado Por</th>
                                    <td class="width-perc">{{ $requermiento->solicitante }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Más Detalle Requerimiento --}}
                    <div class="col-md-12 text-center mb-2 | text-white tri-gray" style="border-radius: 1rem 1rem 0rem 0rem;">
                        <h4>SOPORTE SOLICITUD DE REQUISICION DEL CLIENTE</h4>
                    </div>
                    
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <th class="width-perc">
                                        Fecha Recepción Solicitud
                                    </th>
                                    <td class="width-perc">
                                        {{ $requermiento->fecha_recepcion }}
                                    </td>

                                    <th class="width-perc">
                                        Contenido Email Soporte
                                    </th>
                                    <td class="width-perc">
                                        {{ strtoupper($requermiento->contenido_email_soporte) }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Más Detalle Requerimiento 
            
                    <h5 class="titulo1 ocultar">
                        DATOS ASISTENTE VIRTUAL
                    </h5>--}}

                    <div class="panel panel-default" hidden>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">
                                            LLAMADAS REALIZADAS
                                        </th>

                                        <th style="text-align: center;">
                                            LLAMADAS RESTANTES
                                        </th>   
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;" >
                                            {{ $numero_llamadas }}
                                        </td>

                                        <td style="text-align: center;" >
                                            {{ $llamadas_restantes }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12 text-center mb-2 | text-white tri-gray" style="border-radius: 1rem 1rem 0rem 0rem;">
                        <h4>CANDIDATOS POSTULADOS</h4>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Nombre
                                        </th>
                                        <th>
                                            Identificacíon
                                        </th>
                                        <th>
                                            Móvil
                                        </th>
                                        <th>
                                            E-mail
                                        </th>
                                    </tr>
                                </thead>

                                @foreach ($candidatos_postulados as $count => $candidatos)
                                    <tbody>
                                        <tr>
                                            <td>
                                                {{ ++$count }}
                                            </td>
                                            <td>
                                                {{ $candidatos->nombres }}
                                            </td>
                                            <td>
                                                {{ $candidatos->cedula }}
                                            </td>
                                            <td>
                                                {{ $candidatos->celular }}
                                            </td>
                                            <td>
                                                {{ $candidatos->email }}
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif