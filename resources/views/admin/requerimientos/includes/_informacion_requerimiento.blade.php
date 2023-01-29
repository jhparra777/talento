<h4>
    Requerimiento  <strong># {{$requerimiento->id}}  {{$requerimiento->getCargoEspecifico()->descripcion}}</strong> 
</h4>

<h4>{{$cliente->nombre}}</h4>

<div class="row">
    <div class="col-12">
        <h5 class="titulo1">INFORMACIÓN GENERAL DE LA SOLICITUD</h5>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo de Solicitud</label>
        <div class="col-sm-8">
          {{$requerimiento->getTipoProceso()}}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Ciudad Trabajo</label>
        <div class="col-sm-8">
          {{$requerimiento->getUbicacion()}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Unidad de Negocio</label>
        <div class="col-sm-8">
          {{-- {{$requerimiento->getUnidadNegocio()}} --}}
          {{$nombre}}
        </div>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Estudio Virtual de Seguridad</label>
        <div class="col-sm-8">
          {{$requerimiento->tipo_evs->descripcion}}
        </div>
    </div>
</div>
@if($requerimiento->documento)
    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Documento</label>
            <div class="col-sm-8">
                <a href="{{route('home')}}/documentos_solicitud/{{$requerimiento->documento}}" target="_black">
                Ver documentos</a>
            </div>
        </div>
    </div>
@endif

<div class="row">
    <div class="col-12">
        <h5 class="titulo1">NEGOCIO</h5>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
       <label for="inputEmail3" class="col-sm-4 control-label">Centro Costo / Area</label>
         <div class="col-sm-8">
           @if($centro_costo)
           {{$centro_costo->centro_costo}}
           @endif
         </div>
    </div>
</div>
        
<div class="row">
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

<div class="row">
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

<div class="row">
    <div class="col-12">
        <h5 class="titulo1">ESPECIFICACIONES DEL REQUERIMIENTO</h5>
    </div>
</div>

<div class="row">
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Cargo Cliente</label>
        <div class="col-sm-8">
          {{strtoupper($requerimiento->getCargoEspecifico()->descripcion)}}
        </div>
    </div>

    {{-- <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Clase de riesgo</label>
        <div class="col-sm-8">
          {{$requerimiento->getCentroTrabajo()->nombre_ctra}}
        </div>
    </div> --}}
</div>

<div class="row">
    @if(!empty($requerimiento->jornada()))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Jornada Laboral</label>
        <div class="col-sm-8">
          {{$requerimiento->jornada()->descripcion}}
        </div>
      </div>
    @endif

    {{-- <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Liquidación</label>
        <div class="col-sm-8">
         {{($requerimiento->tipo_liquidacion)?$requerimiento->getTipoLiquidacion()->descripcion:"" }}
        </div>
    </div> --}}

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">No. Horas Laborales</label>
        <div class="col-sm-8">
         {{$requerimiento->jornada()->procentaje_horas}}
       </div>
    </div>

    @if(!empty($requerimiento->getTipoSalario()))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Salario</label>
         <div class="col-sm-8">
          {{$requerimiento->getTipoSalario()->descripcion}}
         </div>
      </div>
    @endif

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Nómina</label>
        <div class="col-sm-8">
         {{($requerimiento->tipo_nomina)?$requerimiento->getTipoNomina()->descripcion:''}}
       </div>
    </div>

    @if(!empty($requerimiento->getConceptoPagos()->descripcion))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Concepto Pago</label>
        <div class="col-sm-8">
         {{$requerimiento->getConceptoPagos()->descripcion}}
       </div>
      </div>
    @endif
     
    <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-4 control-label">Salario</label>
      <div class="col-sm-8">
        {{number_format($requerimiento->salario, 2)}}
      </div>
    </div>

    @if(!empty($requerimiento->getTipoContrato()))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Contrato</label>
        <div class="col-sm-8">
          {{$requerimiento->getTipoContrato()->descripcion}}
        </div>
      </div>
    @endif

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Adicionales salariales</label>
        <div class="col-sm-8">
          {{$requerimiento->adicionales_salariales}}
        </div>
    </div>

    @if(!empty($requerimiento->getMotivoRequerimiento()))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Motivo Requerimiento</label>
        <div class="col-sm-8">
          {{$requerimiento->getMotivoRequerimiento()->descripcion}}
        </div>
      </div>
    @endif

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Número Vacantes</label>
        <div class="col-sm-8">
          {{$requerimiento->num_vacantes}}
        </div>
    </div>
      
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">Observaciones</label>
        <div class="col-sm-12">
          {{$requerimiento->observaciones}}
        </div>
    </div>

    <div class="col-md-12 form-group">
      <label for="inputEmail3" class="col-sm-12 control-label">Funciones a Realizar</label>
        <div class="col-sm-12">
        {{$requerimiento->funciones}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <h5 class="titulo1">ESTUDIOS</h5>
    </div>
</div>

<div class="row">
    @if(!empty($requerimiento->getNivelEstudio()))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Nivel Estudio</label>
        <div class="col-sm-8">
          {{$requerimiento->getNivelEstudio()->descripcion}}
        </div>
      </div>
    @endif
    
    <div class="col-md-6 form-group">
       <label for="inputEmail3" class="col-sm-4 control-label"> Tiempo Experiencia</label>
        <div class="col-sm-8">
         {{$requerimiento->experiencia_req()}}
        </div>
    </div>

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

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Género</label>
        <div class="col-sm-8">
            @if($requerimiento->getDescripcionGenero() != "")
             {{$requerimiento->getDescripcionGenero()->descripcion}}
            @endif
        </div>
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Estado Civil</label>
        <div class="col-sm-8">
          @if($requerimiento->getDescripcionEstadoCivil() != "")
           {{$requerimiento->getDescripcionEstadoCivil()->descripcion}}
          @endif
        </div>
    </div>

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

<div class="row">
    <div class="col-12">
        <h5 class="titulo1">SOPORTE SOLICITUD DE REQUISICION DEL CLIENTE</h5>
    </div>
</div>

<div class="row">
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