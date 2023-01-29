@if( isset($sitio) && $sitio->asistente_contratacion == 1 )
    {{-- Fecha ingreso --}}
    <div class="col-md-6 form-group">
        <label for="fecha_ingreso" class="col-sm-12 control-label">Fecha Ingreso <span class="text-danger">*</span></label>
                
        <div class="col-sm-12">
            {!! Form::text("fecha_ingreso_contra", ($dato_contrato ? $dato_contrato->fecha_ingreso : (!empty($requerimiento->fecha_ingreso) ? $requerimiento->fecha_ingreso : null)), [
                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                "id" => "fecha_ingreso_contra",
                "required" => "required",
                "readonly" => "readonly"
            ]);
            !!}
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_ingreso_contra", $errors) !!}</p>
                
    </div>

    <!-- Hora de ingreso -->
    <div class="col-md-6 form-group">
        <label for="hora_ingreso" class="col-sm-12 control-label">Hora de ingreso <span class="text-danger">*</span></label>

        <div class="col-sm-12">
            {!! Form::time("hora_ingreso",($dato_contrato) ? $dato_contrato->hora_entrada : '08:00', [
                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                "id" => "time-inicio",
                "required" => "required"
            ]); !!}
        </div>
        
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso", $errors) !!}</p>
    </div>

    {{-- Observaciones --}}
    <div class="col-md-12 form-group">
        <label for="observaciones" class="col-sm-12 control-label">Observaciones <span class="text-danger">*</span></label>
                
        <div class="col-sm-12">
            {!! Form::textarea("observaciones", ($dato_contrato) ? $dato_contrato->observaciones : '', [
                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                "rows" => '2',
                "id" => "observacion",
                "required" => "required"
                ])
            !!}
        </div>
                
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>

    <!-- Tipo ingreso -->
    <div class="col-md-6 form-group">
        <label for="tipo_ingreso" class="col-sm-12 control-label">Tipo Ingreso <span class="text-danger">*</span></label>

        <div class="col-sm-12">
            <select name="tipo_ingreso" id="tipo_ingreso" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
                <option value="1" @if($dato_contrato) @if($dato_contrato->tipo_ingreso == 1) selected @endif @endif >Nuevo</option>
                <option value="2" @if($dato_contrato) @if($dato_contrato->tipo_ingreso == 2) selected @endif @endif >Reingreso</option>
            </select>
        </div>

        <p class="error text-danger direction-botones-center">  {!! FuncionesGlobales::getErrorData("tipo_ingreso", $errors) !!} </p>
    </div>

    <!-- Fecha último contrato -->
    <div style="display: none;" class="col-md-6 form-group" id="fecha_fin_ultimo">
        <label for="fecha_fin_ultimo" class="col-sm-12 control-label">Fecha fin ultimo contrato</label>
                
        <div class="col-sm-12">
            {!! Form::date("fecha_fin_ultimo", ($dato_contrato) ? date('Y-m-d', strtotime($dato_contrato->fecha_ultimo_contrato)) : null, [
                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                "id" => "fecha_fin_ultimo"
                ]);
            !!}
        </div>
    </div>

    <!-- Centro de costos -->
    <div class="col-md-6 form-group">
        <label for="centro_costos" class="col-sm-12 control-label">Centro de costos <span class="text-danger">*</span></label>

        <div class="col-sm-12">
            @if($dato_contrato)
                {!! Form::select("centro_costos", $centros_costos, (!empty($dato_contrato->centro_costos)) ? $dato_contrato->centro_costos : $centro_costo->centro_costo,
                    [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "required" => "required",
                        "id" => "centro_costos"
                    ]);
                !!}
            @else
                {!! Form::select("centro_costos", $centros_costos, ($contra_clientes != null ? ($contra_clientes->centro_costos != null ? $contra_clientes->centro_costos : $requerimiento->centro_costo_id) : $requerimiento->centro_costo_id),
                    [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "required" => "required",
                        "id" => "centro_costos"
                    ]);
                !!}
            @endif
        </div>
                
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("centro_costos", $errors) !!}</p>
    </div>

    <!-- Auxilio transporte -->
    <div class="col-md-6 form-group">
        <label for="auxilio_transporte" class="col-sm-12 control-label">Auxilio de Transporte</label>
                
        <div class="col-sm-12">
            <select name="auxilio_transporte" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
                <option value="No se Paga" @if($dato_contrato) @if($dato_contrato->auxilio_transporte == 'No se Paga') selected @endif @endif > No se paga </option>
                <option value="Total" @if($dato_contrato) @if($dato_contrato->auxilio_transporte == 'Total') selected @endif @endif > Total </option>
                <option value="Mitad" @if($dato_contrato) @if($dato_contrato->auxilio_transporte == 'Mitad') selected @endif @endif > Mitad </option>
            </select>
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("auxilio_transporte", $errors) !!}</p>
    </div>

    <!-- EPS -->
    <div class="col-md-6 form-group">
        <label for="entidad_eps" class="col-sm-12 control-label">EPS</label>
                
        <div class="col-sm-12">
            {!! Form::select("entidad_eps", $eps, $candidato->entidad_eps, ["class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "entidad_eps"]) !!}
        </div>
                
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("entidad_eps", $errors) !!}</p>
    </div>

    <!-- Fondo pensiones -->
    <div class="col-md-6 form-group">
        <label for="entidad_afp" class="col-sm-12 control-label">Fondo Pensiones</label>

        <div class="col-sm-12">
            {!! Form::select("entidad_afp", $afp, $candidato->entidad_afp, ["class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "entidad_afp"]) !!}
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("entidad_afp", $errors) !!}</p>
    </div>

    <!-- Caja compensación -->
    <div class="col-md-6 form-group">
        <label for="caja_compensacion" class="col-sm-12 control-label">Caja de Compensaciones</label>

        <div class="col-sm-12">
            {!! Form::select("caja_compensacion", $caja_compensaciones, $candidato->caja_compensaciones, [
                "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                "id" => "caja_compensacion"
                ])
            !!}
        </div>
                
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("caja_compensacion", $errors) !!}</p>
    </div>

    <!-- ARL -->
    <div class="col-md-6 form-group">
        <label for="arl" class="col-sm-6 control-label">ARL</label>
                
        <div class="col-sm-12">
            {!! Form::text("arl", 'Colpatria', ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "arl", "readonly" => "readonly"]); !!}
        </div>
                
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("arl", $errors) !!}</p>
    </div>
            
    <!-- Fondo cesantías -->
    <div class="col-md-6 form-group">
        <label for="fondo_cesantias" class="col-sm-12 control-label">Fondo De Cesantias</label>

        <div class="col-sm-12">
            {!! Form::select("fondo_cesantias", $fondo_cesantias, $candidato->fondo_cesantias, [
                    "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "id" => "fondo_cesantias"
                ])
            !!}
        </div>
            
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fondo_cesantias", $errors) !!}</p>
    </div>

    <!-- Nombre del banco -->
    <div class="col-md-6 form-group">
        <label for="nombre_banco" class="col-sm-12 control-label">Nombre del Banco</label>
                
        <div class="col-sm-12">
            {!! Form::select("nombre_banco", $bancos, $candidato->nombre_banco, [
                    "class" => "form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "id"=>"nombre_banco"
                ])
            !!}
        </div>
                
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_banco", $errors) !!}</p>
    </div>

    <!-- Tipo cuenta -->
    <div class="col-md-6 form-group">
        <label for="tipo_cuenta" class="col-sm-12 control-label">Tipo Cuenta</label>
                
        <div class="col-sm-12">
            <select name="tipo_cuenta" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
                <option value="Ahorro" @if($candidato->tipo_cuenta == 'Ahorro') selected @endif > Ahorro </option>
                <option value="Corriente" @if($candidato->tipo_cuenta == 'Corriente') selected @endif > Corriente </option>
            </select>
        </div>
            
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_cuenta", $errors) !!}</p>
    </div>

    <!-- Número cuenta -->
    <div class="col-md-6 form-group">
        <label for="numero_cuenta" class="col-sm-12 control-label">Número Cuenta</label>

        <div class="col-sm-12">
            <input
                type="number"
                name="numero_cuenta"
                class="form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                value="{{ ($candidato->numero_cuenta != 0) ? $candidato->numero_cuenta : '' }}"
                id="numero_cuenta"
            >
        </div>
            
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
    </div>

    <!-- Confirma cuenta -->
    <div class="col-md-6 form-group">
        <label for="confirm_numero_cuenta" class="col-sm-12 control-label">Confirmar Cuenta</label>

        <div class="col-sm-12">
            <input
                type="number"
                name="confirm_numero_cuenta"
                class="form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                id="confirm_numero_cuenta"
            >
        </div>
            
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
    </div>

    <!-- Fecha fin contrato -->
    <?php
        if (!empty($dato_contrato) && $dato_contrato->fecha_ingreso != null) {
            $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($dato_contrato->fecha_ingreso)) . " + 364 day"));
        } elseif(!empty($requerimiento->fecha_ingreso)) {
            $newEndingDate = date("Y-m-d", strtotime(date("Y-m-d", strtotime($requerimiento->fecha_ingreso)) . " + 364 day"));
        }
    ?>
    <div class="col-md-6 form-group">
        <label for="fecha_fin_contrato" class="col-sm-12 control-label">Fecha Fin Contrato</label>
                
        <div class="col-sm-12">
            <input
                type="text"
                name="fecha_fin_contrato"
                value="{{ isset($newEndingDate)?$newEndingDate:$dato_contrato->fecha_fin_contrato }}"
                class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                id="fecha_fin_contrato"
                required
                readonly
            >
        </div>
                
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato", $errors) !!}</p>
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">¿Quién autorizó contratación? <span class="text-danger">*</span></label>

        @if(count($dato_contrato) > 0)
            @if(!is_null($dato_contrato->user_autorizacion) && $dato_contrato->user_autorizacion != '')
                <div class="col-sm-12">
                    {!! Form::select("user_autorizacion", $usuarios_clientes,($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "readonly" => true,
                        "id" => "user_autorizacion"
                        ]);
                    !!}
                </div>
                            
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
            @else
                <div class="col-sm-12">
                    {!! Form::select("user_autorizacion", $usuarios_clientes, ($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "user_autorizacion",
                        "required" => "required"
                    ]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
            @endif
        @else
            <div class="col-sm-12">
                {!! Form::select("user_autorizacion", $usuarios_clientes, ($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "user_autorizacion",
                        "required" => "required"
                    ]);
                !!}
            </div>
                        
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
        @endif
    </div>

    @if(!empty($adicionales))
        <div class="col-md-12">
            <label class="mb-2 mt-2">Documentos adicionales variables</label>

            <table class="table">
                <tr>
                    <th>Descripción</th>
                    <th></th>
                </tr>

                @foreach($adicionales as $key => $adicional)
                    @if(preg_match('/{valor_variable}/', $adicional->adicional->contenido_clausula))
                        <tr class="item_adicional">
                            <td>
                                {{ $adicional->adicional->descripcion }}
                            </td>

                            <td>
                                <input type="hidden" name="clausulas[]" value="{{ $adicional->adicional->id }}">

                                <input 
                                    type="text" 
                                    name="valor_adicional[]" 
                                    class="form-control valor_adicional | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                                    placeholder="Valor variable"
                                    @if( $is_new )
                                    value="{{ ( empty($adicional->variableReq($requerimiento->id)->valor)) ? $adicional->variableCargo()->valor : $adicional->variableReq($requerimiento->id)->valor }}"
                                    @else
                                    value="{{ $adicional->valor }}"
                                    @endif
                                    maxlength="100"
                                    autocomplete="off" 

                                    data-toggle="tooltip"
                                    data-placement="top"
                                    data-container="body"
                                    title="Debes definir el valor variable para este documento adicional."
                                >

                                @if(!preg_match('/{valor_variable}/', $adicional->adicional->contenido_clausula))
                                    <input type="hidden" name="valor_adicional[]" value="0">
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
                    </table>
                </div>
            @endif
@else

    {{-- Fecha ingreso --}}
    <div class="col-md-6 form-group">
        <label for="fecha_ingreso" class="col-sm-12 control-label">Fecha Ingreso <span class="text-danger">*</span></label>
                
        <div class="col-sm-12">
            {!! Form::text("fecha_ingreso_contra", ($dato_contrato ? $dato_contrato->fecha_inicio_contrato : (!empty($requerimiento->fecha_ingreso) ? $requerimiento->fecha_ingreso : null)), [
                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                "id" => "fecha_ingreso_contra",
                "required" => "required"
                ]);
            !!}
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_ingreso_contra", $errors) !!}</p>
                
    </div>

    {{-- Observaciones --}}
    <div class="col-md-6 form-group">
        <label for="observaciones" class="col-sm-12 control-label">Observaciones <span class="text-danger">*</span></label>
                
        <div class="col-sm-12">
            {!! Form::textarea("observaciones", ($dato_contrato) ? $dato_contrato->observaciones : '', [
                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                "rows" => '2',
                "id" => "observacion",
                "required" => "required"
                ])
            !!}
        </div>
                
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
    </div>

    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label">¿Quién autorizó contratación? <span class="text-danger">*</span></label>

        @if(count($dato_contrato) > 0)
            @if(!is_null($dato_contrato->user_autorizacion) && $dato_contrato->user_autorizacion != '')
                <div class="col-sm-12">
                    {!! Form::select("user_autorizacion", $usuarios_clientes,($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "readonly" => true,
                        "id" => "user_autorizacion"
                        ]);
                    !!}
                </div>
                            
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
            @else
                <div class="col-sm-12">
                    {!! Form::select("user_autorizacion", $usuarios_clientes, ($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "user_autorizacion",
                        "required" => "required"
                    ]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
            @endif
        @else
            <div class="col-sm-12">
                {!! Form::select("user_autorizacion", $usuarios_clientes, ($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                        "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                        "id" => "user_autorizacion",
                        "required" => "required"
                    ]);
                !!}
            </div>
                        
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
        @endif
    </div>

@endif