<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
       Detalle solicitud
    </h4>
</div>
<div class="modal-body" id="print">
    <div class="row">
        <div class="col-md-12">
            <h3>
                <strong>
                    Detalle solicitud
                </strong>
            </h3>
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Código solicitud
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->id }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Sede trabajo
                </strong>
            </div>
            <div class="col-md-6">
                {{ \App\Models\SolicitudSedes::nombreSede($solicitudes->ciudad_id) }}
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Aréa
                </strong>
            </div>
            <div class="col-md-6">
                {{ \App\Models\SolicitudAreaFuncional::nombreAreaFunciones($solicitudes->area_id) }}
            </div>
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Subarea
                </strong>
            </div>
            <div class="col-md-6">
                {{ \App\Models\SolicitudSubArea::nombreSubArea($solicitudes->subarea_id) }}
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Nombre solicitante
                </strong>
            </div>
            <div class="col-md-6">
                {{ \App\Models\DatosBasicos::nombreUsuario($solicitudes->user_id) }}
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Cargo solicitado
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->cargoGenerico()->descripcion }}
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Jefe inmediato
                </strong>
            </div>
            <div class="col-md-6">
             @if($solicitudes->jefeInmediato())
                {{ $solicitudes->jefeInmediato()->nombre }}
             @endif
            </div>
        </div>
        @if(isset($solicitudes->centrocosto))
            <div class="col-md-6">
                <div class="col-md-6">
                    <strong>
                        Centro de costo
                    </strong>
                </div>
                <div class="col-md-6">
                    {{ $solicitudes->centrocosto->descripcion }}
                </div>
            </div>
        @endif
         @if(isset($solicitudes->centrobeneficio))
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Centro beneficio
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->centrobeneficio->descripcion }}
            </div>
        </div>
        @endif
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Email jefe inmediato
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->email_jefe_inmediato }}
            </div>
        </div>
        {{--<div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Clase de riesgo
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->riesgo_id }}
            </div>
        </div>--}}
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Tipo contrato
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->tipoContrato()->descripcion }}
            </div>
        </div>

        @if(!empty($solicitudes->tiempo_contrato))
         <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Tiempo Contrato
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->tiempo_contrato }}
            </div>
         </div>
        @endif

        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Motivo contrato
                </strong>
            </div>
            <div class="col-md-6">
              @if($solicitudes->motivo_requerimiento_id!=20)
                @if(!empty($solicitudes->motivoRequerimiento()))
                {{$solicitudes->motivoRequerimiento()->descripcion}}
                @endif
                @else
                    <strong>{{$solicitudes->motivoRequerimiento()->descripcion}}</strong>:{{$solicitudes->desc_motivo}}
                @endif
                
            </div>
        </div>
        <!-- -->
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Número vacantes
                </strong>
            </div>
            <div class="col-md-6">
                {{ $solicitudes->numero_vacante }}
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="col-md-6">
                <strong>
                    Documento adjunto
                </strong>
            </div>
            <div class="col-md-6">
                <a href="{{ route('home') }}/documentos_solicitud/{{ $solicitudes->documento }}" target="_black">
                    Ver documentos
                </a>
            </div>
        </div>
        <!-- -->
        <div class="col-md-12">
            <div class="col-md-12">
                <strong>
                  Justificación
                </strong>
            </div>
            <div class="col-md-12">
                {{ $solicitudes->funciones_realizar }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <strong>
                    Observaciones
                </strong>
            </div>
            <div class="col-md-12">
                {{ $solicitudes->observaciones }}
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <strong>
                    Recursos necesarios
                </strong>
            </div>
            <div class="col-md-12">
              @if($solicitudes->recursosNecesarios)

               @foreach($solicitudes->recursosNecesarios as $recurso)
               
                {{$recurso->recurso_necesario}},
                
               @endforeach
              @endif
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-12">
                <strong>
                    Salario
                </strong>
            </div>
            <div class="col-md-12">
                {{$solicitudes->salario}}
            </div>
             
        </div>
       
    </div>
    <div class="row">
         <div class="col-md-12">
            <h3>
                <strong>
                    Flujo
                </strong>
            </h3>
        </div>
        <div class="col-sm-12">
            <table class="data-table table-responsive table table-border">
                <thead>
                    <th>Solicitante</th>
                    <th>Jefe</th>
                    <th>Gerente area</th>
                    <th>RRHH</th>
                    <th>Gerente Gral</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ \App\Models\DatosBasicos::nombreUsuario($flujo->user_solicitante) }}</td>
                        <td>{{ \App\Models\DatosBasicos::nombreUsuario($flujo->user_jefe_solicitante) }}</td>
                        <td>{{ \App\Models\DatosBasicos::nombreUsuario($flujo->user_gerente_area) }}</td>
                        <td>{{ \App\Models\DatosBasicos::nombreUsuario($flujo->user_rhh) }}</td>
                         <td>{{ \App\Models\DatosBasicos::nombreUsuario($flujo->user_gg) }}</td>
                    </tr>
                </tbody>

            </table>

        </div>
    </div>
    <div class="row">
       <div class="col-md-12">
            <h3>
                <strong>
                    Trazabilidad solicitud
                </strong>
            </h3>
        </div> 
        <div class="col-md-12">
            <table class="data-table table-responsive table table-border">
                <thead>
                    <th>Usuario</th>
                    <th>Acción</th>
                    <th>Observación</th>
                    <th>Fecha</th>
                </thead>
                <tbody>
                    @foreach($trazabilidad as $traza)
                        <tr>
                            <td>
                                {{ \App\Models\DatosBasicos::nombreUsuario($traza->user_id) }}
                            </td>
                            <td>
                                {{$traza->accion}}
                            </td>
                            <td>
                                {{$traza->observacion}}
                            </td>
                            <td>
                                {{$traza->created_at}}
                            </td>
                        </tr>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
  <a href="#" id="imprimir" class="btn btn-info btn-xs col-md-offset-1"> imprimir </a>
<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        <i class="fa fa-close">
        </i>
        Cerrar
    </button>
   
</div>
<div class="compensar" style="display: none;">
    <h1>
        Valorar
    </h1>
    <span>
        Se realizo la valoración de la solicitud.
    </span>
</div>
