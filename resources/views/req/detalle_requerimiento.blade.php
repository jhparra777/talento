@extends("req.layout.master")
@section("contenedor")

@if(route("home") == "https://gpc.t3rsc.co" || route("home") == "http://localhost:8000")
    <h4 class="titulo1">INFORMACIÓN GENERAL DE LA SOLICITUD</h4>

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
                @if($requerimiento->sitio_trabajo!=null)
                    {{$requerimiento->getUbicacion()}}
                @else
                    {{$requerimiento->getUbicacion()}}
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        @if($requerimiento->documento)
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Documento</label>
                <div class="col-sm-8">
                    <a href="{{route('home')}}/documentos_solicitud/{{ $requerimiento->documento }}" target="_black">
                        Ver documentos
                    </a>
                </div>
            </div>
        @endif
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
    </div>

    <h4 class="titulo1">ESPECIFICACIONES DEL REQUERIMIENTO</h4>    
    
    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Cargo Cliente</label>

            <div class="col-sm-8">
                {{strtoupper($requerimiento->getCargoEspecifico()->descripcion)}}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"></label>

            <div class="col-sm-8"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Jornada Laboral</label>

            <div class="col-sm-8">
                {{$requerimiento->jornada()->descripcion}}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">No. Horas Laborales</label>
            
            <div class="col-sm-8">
                {{$requerimiento->jornada()->procentaje_horas}}
            </div>
        </div>
    </div>

    <div class="row">
        {{--@if(!empty($requerimiento->getTipoSalario()->descripcion))
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Tipo Salario</label>
                <div class="col-sm-8">
                    {{$requerimiento->getTipoSalario()->descripcion}}
                </div>
            </div>
        @endif--}}

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Salario</label>
            <div class="col-sm-8">
                {{number_format($requerimiento->salario)}}
            </div>
        </div>
    </div>

    <div class="row">
        @if(!empty($requerimiento->getTipoContrato()->descripcion))
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Tipo Contrato</label>
                <div class="col-sm-8">
                    {{$requerimiento->getTipoContrato()->descripcion}}
                </div>
            </div>
        @endif

        @if(!empty($requerimiento->getMotivoRequerimiento()->descripcion))
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Motivo Requerimiento</label>
                <div class="col-sm-8">
                    {{$requerimiento->getMotivoRequerimiento()->descripcion}}
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Número de Personal</label>
            <div class="col-sm-8">
                {{$requerimiento->num_vacantes}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label">Observaciones</label>
            <div class="col-sm-12">
                {{$requerimiento->observaciones}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label">Conocimientos especificos</label>
            <div class="col-sm-12">
                {{$requerimiento->conocimientos_especificos}}
            </div>
        </div>
    </div>

    <h4 class="titulo1">ESTUDIOS</h4>
        
    <div class="row">
        @if(!empty($requerimiento->getNivelEstudio()->descripcion))
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Nivel Estudio</label>
                <div class="col-sm-8">
                    {{$requerimiento->getNivelEstudio()->descripcion}}
                </div>
            </div>
        @endif

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Funciones a Realizar</label>
            <div class="col-sm-8">
                {{$requerimiento->funciones}}
            </div>
        </div>
    </div>

    <div class="row">
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

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Género</label>
            <div class="col-sm-8">
                @if($requerimiento->getDescripcionGenero() != "")
                    {{$requerimiento->getDescripcionGenero()->descripcion}}
                @endif
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Fecha Ingreso</label>
            <div class="col-sm-8">
                {{$requerimiento->fecha_ingreso}}
            </div>
        </div>
    </div>

    <h4 class="titulo1">IDIOMA</h4>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Idioma</label>
            <div class="col-sm-8">
                {{$requerimiento->descripcion_idioma()}}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Nivel idioma</label>
            <div class="col-sm-8">
                {{$requerimiento->descripcion_nivel_idioma()}}
            </div>
        </div>
    </div>

    <h4 class="titulo1">CANDIDATOS POSTULADOS</h4>

    <div class="container" id="postulados">
        <div class="row">
            <div class="col-md-12 form-group">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Télefono</th>
                            <th>Móvil</th>
                            <th>E-mail</th>
                        </tr>
                    </thead>

                    @foreach ($candidatos_postulados as $count => $candidatos)
                        <tbody>
                            <tr>
                                <td>{{ ++$count }}</td>
                                <td>{{ $candidatos -> nombres }}</td>
                                <td>{{ $candidatos -> cedula }}</td>
                                <td>{{ $candidatos -> telefono }}</td>
                                <td>{{ $candidatos -> celular }}</td>
                                <td>{{ $candidatos -> email }}</td>
                            </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@else
  
  <h3>{{$cliente->nombre}}</h3>

  <h4 class="titulo1">INFORMACIÓN GENERAL DE LA SOLICITUD</h4>
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

      @if($requerimiento->documento)
        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label">Documento</label>
          <div class="col-sm-8">
           <a href="{{route('home')}}/documentos_solicitud/{{$requerimiento->documento}}" target="_black">
            Ver documentos</a>
          </div>
        </div>
      @endif

    </div>
    <h4 class="titulo1">NEGOCIO</h4>

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
    
    @if(count($atributos_textbox)>0)
    <h4 class="titulo1">ATRIBUTOS FLEXIBLES</h4>
     <div class="row">
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


    <h4 class="titulo1">ESPECIFICACIONES DEL REQUERIMIENTO</h4>
    <div class="row">
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
    <div class="row">
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Clase de riesgo</label>
        <div class="col-sm-8">
          {{$requerimiento->getCentroTrabajo()->nombre_ctra}}
        </div>
      </div>
    </div>

    <div class="row">
    
    @if(route("home") == "https://vym.t3rsc.co" || route("home") == "https://listos.t3rsc.co")
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">CenCos Producción</label>
        <div class="col-sm-8">
          <!--$centro_costo->descripcion}}-->
        </div>
      </div>
    @endif

    @if(!empty($requerimiento->jornada()))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Jornada Laboral</label>
        <div class="col-sm-8">
          {{$requerimiento->jornada()->descripcion}}
        </div>
      </div>
    @endif

      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Liquidación</label>
        <div class="col-sm-8">
         {{($requerimiento->tipo_liquidacion)?$requerimiento->getTipoLiquidacion()->descripcion:"" }}
        </div>
      </div>

      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">No. Horas Laborales</label>
        <div class="col-sm-8">
         {{$requerimiento->jornada()->procentaje_horas}}
       </div>
     </div>
    </div>
    <div class="row">

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
    </div>
    
    <div class="row">
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

    </div>
    
    <div class="row">
     @if(!empty($requerimiento->getTipoContrato()))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Contrato</label>
        <div class="col-sm-8">
          {{$requerimiento->getTipoContrato()->descripcion}}
        </div>
      </div>
     @endif

     @if(!empty($requerimiento->getMotivoRequerimiento()))
      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-4 control-label">Motivo Requerimiento</label>
        <div class="col-sm-8">
          {{$requerimiento->getMotivoRequerimiento()->descripcion}}
        </div>
      </div>
     @endif

    </div>
    <div class="row">
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

      <div class="col-md-6 form-group">
      <label for="inputEmail3" class="col-sm-4 control-label">Funciones a Realizar</label>
        <div class="col-sm-8">
        {{$requerimiento->funciones}}
        </div>
     </div>
    </div>
    <h4 class="titulo1">ESTUDIOS</h4>
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
      
    </div>
    <div class="row">
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
    <div class="row">
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
    </div>
    <div class="row">
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
    <h4 class="titulo1">SOPORTE SOLICITUD DE REQUISICION DEL CLIENTE</h4>
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
    <h4 class="titulo1">CANDIDATOS POSTULADOS</h4>
    <div class="container" id="postulados">
      <div class="row">
        <div class="col-md-12 form-group">
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Cédula</th>
                <th>Móvil</th>
                <th>E-mail</th>
              </tr>
            </thead>
            @foreach ($candidatos_postulados as $count => $candidatos)
            <tbody>
              <tr>
                <td>{{ ++$count }}</td>
                <td>{{ $candidatos->nombres }}</td>
                <td>{{ $candidatos->cedula }}</td>
                <td>{{ $candidatos->celular }}</td>
                <td>{{ $candidatos->email }}</td>
              </tr>
            </tbody>
            @endforeach
          </table>
        </div>
      </div>
    </div>
    <br/>
@endif
<a class="btn btn-danger" href="{{route("req.mis_requerimiento")}}" onclick="">Volver listado</a>
@stop