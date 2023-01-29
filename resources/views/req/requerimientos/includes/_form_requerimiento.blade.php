<style>
    .input-group-bt4{
          position: relative;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          -ms-flex-wrap: wrap;
          flex-wrap: wrap;
          -webkit-box-align: stretch;
          -ms-flex-align: stretch;
          align-items: stretch;
    }

    .input-group-bt4 select {
          position: relative;
          -webkit-box-flex: 1;
          -ms-flex: 1 1 auto;
          flex: 1 1 auto;
          width: 1%;
          margin-bottom: 0;
          border-radius: 1rem 0 0 1rem;
    }

    .input-group-append button {
        border-radius: 0 1rem 1rem 0;
    }
</style>
<div class="col-md-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="page-header">
                        <h4 class="tri-fw-600">
                            INFORMACIÓN GENERAL DE LA SOLICITUD
                        </h4>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('tipo_proceso_id') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Tipo de Solicitud: <span class='text-danger sm-text-label'>*</span></label>
                
                    {!! Form::select("tipo_proceso_id",$tipoProceso, isset($new)? $negocio->tipo_proceso_id : old('tipo_proceso_id'), ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "tipo_proceso_id", "required" => "required"]); !!}

                    @error('tipo_proceso_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
            
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Empresa Contrata: <span class='text-danger sm-text-label'>*</span> </label>

                    {!! Form::select("empresa_contrata",$empresa_logo,old('empresa_contrata'),["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "empresa_contrata", "required" => "required"]); !!}

                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('ciudad_id') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Ciudad Trabajo: <span class='text-danger sm-text-label'>*</span></label>
                    <span style="color:red;display: none;" id="error_ciudad_expedicion">Debe seleccionar de la lista</span>

                    {!! Form::hidden("pais_id", isset($new)? $negocio->pais_id : null, ["class" => "form-control", "id" => "pais_id"]) !!}
                    {!! Form::hidden("departamento_id", isset($new)? $negocio->departamento_id : null, ["class" => "form-control", "id" => "departamento_id"]) !!}
                    {!! Form::text("ciudad_id", isset($new)? $negocio->ciudad_id : null, ["style" => "display: none;", "class" => "form-control", "id" => "ciudad_id", "required" => "required"]) !!}
                    {!! Form::text("sitio_trabajo", ( isset($new) && $negocio != null ) ? $negocio->getUbicacion()->value : null, ["placeholder" => "Seleccionar una opción de la lista desplegable", "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "sitio_trabajo_autocomplete", "required" => "required"]); !!}

                    @error('ciudad_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            @if($sitioModulo->estudio_virtual_seguridad == 'enabled' && empty($editar))
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tipo_evs_id" class="control-label">Estudio Virtual de Seguridad: <span class='text-danger sm-text-label'>*</span></label>

                        {!! Form::select("tipo_evs_id",$tipos_evs,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "tipo_evs_id", "required"  =>  "required"]); !!}
                        
                    </div>
                </div>
            @endif

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Jefe Inmediato:</label>

                    {!! Form::text("jefe_inmediato", strtoupper($user->name), ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "jefe inmediato", "id" => "jefe_inmediato"]); !!}
                 
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("jefe_inmediato", $errors) !!}</p>
                </div>
            </div>

            {!!Form::hidden("solicitado_por", $user->id, ["id" => "solicitado_por"]); !!}

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="page-header">
                        <h4 class="tri-fw-600">
                            PERSONALIZACIÓN DE LA SOLICITUD
                        </h4>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('solicitado_por_txt') has-feedback has-error smk-select @enderror">
                    <label for="solicitado_por_txt" class="control-label">Nombre Solicitante: <span class='text-danger sm-text-label'>*</span></label>    
                    {!! Form::text("solicitado_por_txt", strtoupper($user->name), [ "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder" => "Solicitante", "id" => "solicitado_por_txt", "required"  =>  "required" ]);!!}

                    @error('solicitado_por_txt')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Confidencial:</label>
                    {!! Form::select("confidencial",['0'=>"No",'1'=>"Si"], null,[ "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "confidencial"]);!!}         
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="num_req_cliente" class="control-label">Num. Requi Cliente:</label>
                                    
                    {!! Form::text("num_req_cliente", '',["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "# Requi Cliente"]); !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">
                        Teléfono:
                    </label>

                    {!!Form::text("telefono_solicitante", $user->telefono, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Teléfono Solicitante"]);!!}      
                </div>
            </div>

        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="page-header">
                    <h4 class="tri-fw-600">
                        ESPECIFICACIONES DEL REQUERIMIENTO
                    </h4>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('cargo_especifico_id') has-feedback has-error smk-select @enderror">
                    <label for="cargo_especifico_id" class="control-label">Cargo Cliente: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("cargo_especifico_id",$cargo_especifico,null,["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "cargo_especifico_id", "required" => "required"]); !!}

                    @error('cargo_especifico_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">
                        Adjunto solicitud:
                    </label>
                    {!! Form::file("perfil", ["class" => "form-control-file form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "perfil", "name" => "perfil"]) !!}
                    
                    <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("perfil", $errors) !!} </p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('ctra_x_clt_codigo') has-feedback has-error smk-select @enderror">
                <label for="inputEmail3" class="control-label">Clase de Riesgo: <span class='text-danger sm-text-label'>*</span></label>
                
                    {!! Form::hidden("cargo_generico_id",$cargo_generico_id,["id"=>"cargo_generico_id"]); !!} 
                    
                    {!! Form::select("ctra_x_clt_codigo",$centro_trabajo,$ctra_x_clt_codigo,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"ctra_x_clt_codigo","required"]); !!}

                    @error('ctra_x_clt_codigo')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="form-group @error('tipo_jornadas_id') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Jornada Laboral: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("tipo_jornadas_id",$tipo_jornada,isset($new) ? $negocio->tipo_jornada_id :$ficha_jornada_laboral,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_jornadas_id","required"]); !!}

                    @error('tipo_jornadas_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('tipo_liquidacion') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Tipo Liquidación: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("tipo_liquidacion",$tipo_liquidacion,isset($new) ? $negocio->tipo_liquidacion_id : $tipo_liquidacion_id,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_liquidacion","required"]); !!}

                    @error('tipo_liquidacion')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('tipo_salario') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Tipo Salario: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("tipo_salario",$tipo_salario,isset($new) ? $negocio->tipo_salario_id : $tipo_salario_id,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_salario","required"]); !!}

                    @error('tipo_salario')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('tipo_nomina') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Tipo Nómina: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("tipo_nomina",$tipo_nomina,$tipo_nomina_id,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_nomina","required"]); !!}

                    @error('tipo_nomina')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('concepto_pago_id') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Concepto Pago: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("concepto_pago_id",$concepto_pago,$concepto_pago_id,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"concepto_pago_id","required"]); !!}

                    @error('concepto_pago_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('salario') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Salario: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::text("salario", $salario, ["required", "class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "salario", "placeholder" => "Salario", "data-min" => $salario_min, "data-max" => $salario_max ]);!!}

                    @error('salario')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('tipo_contrato_id') has-feedback has-error smk-select @enderror">
                    <label for="tipo_contrato_id" class="control-label">Tipo Contrato: <span class='text-danger sm-text-label'>*</span></label>
                    {!!Form::select("tipo_contrato_id",$tipo_contrato,isset($new) ? $negocio->tipo_contrato_id : $ficha_tipo_contrato,["required", "class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_contrato_id"]);!!}

                    @error('tipo_contrato_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Adicionales Salariales:</label>
                    {!! Form::text("adicionales_salariales", $adicionales_salariales, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "adicionalesSalariales", "placeholder" => "Adicionales salariales", "data-max" => '255' ]);!!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('motivo_requerimiento_id') has-feedback has-error smk-select @enderror">
                    <label for="motivo_requerimiento_id" class="control-label">Motivo Requerimiento: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("motivo_requerimiento_id", $motivo_requerimiento, $motivo_requerimiento_id, [ "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "motivo_requerimiento_id", "required" ]); !!}

                    @error('motivo_requerimiento_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Número Vacantes:</label>
                    {!! Form::text("num_vacantes",$ficha_numero_vacante,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"num_vacantes"]); !!}
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group @error('funciones') has-feedback has-error smk-select @enderror">
                    <label for="funciones" class="control-label">Funciones a Realizar: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::textarea("funciones",$ficha_funciones_realizar,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"funciones","rows"=>"3","required"]); !!}

                    @error('funciones')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label for="inputEmail3" class="control-label">Adicionales/Observaciones:</label>
                
                    {!! Form::textarea("observaciones",$observaciones,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"observaciones","rows"=>"3"]); !!}
                </div>
            </div>

            <div class="col-md-6 fecha_no">
                <div class="form-group @error('fecha_ingreso') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Fecha Tentativa de ingreso: <span class='text-danger sm-text-label'>*</span></label>
                    <input type="text" name="fecha_ingreso" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" id="fecha_ingreso" value="{{isset($fecha_tentativa) ? $fecha_tentativa : $requermiento->fecha_ingreso}}" required="required" >

                    @error('fecha_ingreso')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6 fecha_no">
                <div class="form-group @error('fecha_retiro') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Fecha Retiro: <span class='text-danger sm-text-label'>*</span></label>
                   {!! Form::text("fecha_retiro", $fecha_r_tentativa, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "AAAA-MM-DD", "id" => "fecha_retiro", "required" => "required"]); !!}

                   @error('fecha_retiro')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">

            <div class="col-md-12">
                <div class="page-header">
                    <h4 class="tri-fw-600">
                        ESTUDIOS
                    </h4>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('nivel_estudio') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Nivel Estudio: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("nivel_estudio",$nivel_estudio,$ficha_nivel_estudio,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"nivel_estudio", "required" => "required"]); !!}

                    @error('nivel_estudio')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('tipo_experiencia_id') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Tiempo de Experiencia: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("tipo_experiencia_id",$tipo_experiencia,$tipo_experiencia_id,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_experiencia_id", "required" => "required"]); !!}

                    @error('tipo_experiencia_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group @error('edad_minima') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Rango de Edad: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::text("edad_minima", $ficha_edad_minima, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "edad_minima", "placeholder" => "Edad Mínima", "data-min" => 17, "data-max" => 50, "required" => "required" ]);!!}

                    @error('edad_minima')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror  
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group @error('edad_maxima') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">&nbsp;</label>
                    {!! Form::text("edad_maxima", $ficha_edad_maxima, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "edad_maxima", "placeholder" => "Edad Máxima", "data-min" => 18, "data-max" => 70, "required" => "required" ]);!!}

                    @error('edad_maxima')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror      
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('genero_id') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Género: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("genero_id",$generos,$ficha_genero,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"genero_id", "required" => "required"]); !!}

                    @error('genero_id')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group @error('estado_civil') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Estado Civil: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::select("estado_civil",$estados_civiles,$estado_civil_selected,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"estado_civil", "required" => "required"]); !!}

                    @error('estado_civil')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="col-md-12">
                <div class="page-header">
                    <h4 class="tri-fw-600">
                        SOPORTE SOLICITUD DE REQUISICIÓN DEL CLIENTE
                    </h4>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group @error('fecha_recepcion') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Fecha Recepción Solicitud: <span class='text-danger sm-text-label'>*</span></label>
                    {!! Form::text("fecha_recepcion",$fecha_hoy,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"fecha_recepcion"]); !!}

                    @error('fecha_recepcion')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group @error('contenido_email_soporte') has-feedback has-error smk-select @enderror">
                    <label for="inputEmail3" class="control-label">Contenido Email Soporte: <span class='text-danger sm-text-label'>*</span></label>
                    {!!Form::textarea("contenido_email_soporte", $contenido_email_soporte, [
                            "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                            "id" => "contenido_email_soporte",
                            "required" => "required"
                    ]);!!}

                    @error('contenido_email_soporte')
                        <span class="help-block smk-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

        </div>
    </div>
</div>
@if( isset($new) )
<div class="col-md-12">
    {{-- CAMPOS MULTICIUDAD --}}
    <div class="panel panel-default">
        <div class="panel-body">
            @include('req.requerimientos.includes._collapse_campos_multiciudad')
        </div>
    </div>
</div>

<div id="contratacion-directa" class="col-md-12">
    {{-- DATOS PARA CONTRATACION DIRECTA --}}
    <div class="panel panel-default">
        <div class="panel-body">
            @include('req.requerimientos.includes._form_contratacion_directa')
        </div>
    </div>
</div>

<div class="col-md-12">
    {{-- CAMPOS CANDIDATOS POSTULADOS --}}
    <div class="panel panel-default">
        <div class="panel-body">
            @include('req.requerimientos.includes._collapse_campos_candidatos_postulados')
        </div>
    </div>
</div>
@endif

                           