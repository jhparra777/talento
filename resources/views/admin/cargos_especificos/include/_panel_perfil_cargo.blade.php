<div class="col-md-12">
    <h4>Perfil del cargo</h4>
    <div id="accordion-perfil">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <a data-toggle="collapse" data-target="#collapsePerfil" aria-expanded="true" aria-controls="collapsePerfil" style="cursor: pointer;">
                    <h3 class="panel-title text-white">
                        Perfil del cargo
                    </h3>
                </a>
            </div>

            <div id="collapsePerfil" class="collapse" aria-labelledby="headingPerfil" data-parent="#accordion-perfil">
                <div class="panel-body py-0">
                    <div class="row pt-2">
                        <div class="col-md-6 form-group">
                            <label for="perfil" class="col-sm-4 control-label">Archivo perfil PDF
                                @if(strlen($archivo)>0)
                                    <span>
                                        <a href='{{route("view_document_url", encrypt("recursos_Perfiles/"."|".$archivo))}}' target="_blank" class="btn btn-info">
                                            <i class="fa fa-eye"></i> 
                                            Archivo de perfil
                                        </a>
                                    </span>
                                @endif
                            </label>
                            <div class="col-sm-8">
                                <input type="file" class="form-control" id="perfil" name="perfil" accept=".pdf, .doc, .docx">
                            </div>
                            <p class="error text-danger direction-botones-center" style="{{ ($errors->has('perfil') ? '' : 'display: none;') }}">
                                {!! FuncionesGlobales::getErrorData("perfil",$errors) !!}
                            </p>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_tipo_cargo" class="col-sm-4 control-label">Tipo <br> cargo</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_tipo_cargo" name="prfl_tipo_cargo">
                                    <option value="">Seleccione</option>
                                    @foreach($tipos_cargos_perfil as $tipo_cp)
                                        @if($registro->prfl_tipo_cargo == $tipo_cp->id)
                                            <option value="{{ $tipo_cp->id }}" selected="selected">{{ $tipo_cp->descripcion }}</option>
                                        @else
                                            <option value="{{ $tipo_cp->id }}">{{ $tipo_cp->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_nivel_cargo" class="col-sm-4 control-label">Nivel cargo</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_nivel_cargo" name="prfl_nivel_cargo">
                                    <option value="">Seleccione</option>
                                    @foreach($tipos_nivel_cargo as $tipo_nc)
                                        @if($registro->prfl_nivel_cargo == $tipo_nc->id)
                                            <option value="{{ $tipo_nc->id }}" selected="selected">{{ $tipo_nc->descripcion }}</option>
                                        @else
                                            <option value="{{ $tipo_nc->id }}">{{ $tipo_nc->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_clase_riesgo" class="col-sm-4 control-label">Clase de riesgo</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_clase_riesgo" name="prfl_clase_riesgo">
                                    <option value="">Seleccione</option>
                                    @foreach($centros_trabajo as $centro_trabajo)
                                        @if($registro->prfl_clase_riesgo == $centro_trabajo->id)
                                            <option value="{{ $centro_trabajo->id }}" selected="selected">{{ $centro_trabajo->nombre_ctra }}</option>
                                        @else
                                            <option value="{{ $centro_trabajo->id }}">{{ $centro_trabajo->nombre_ctra }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_jornada_laboral" class="col-sm-4 control-label">Jornada laboral</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_jornada_laboral" name="prfl_jornada_laboral">
                                    <option value="">Seleccione</option>
                                    @foreach($tipo_jornada as $tipo_j)
                                        @if($registro->prfl_jornada_laboral == $tipo_j->id)
                                            <option value="{{ $tipo_j->id }}" selected="selected">{{ $tipo_j->descripcion }}</option>
                                        @else
                                            <option value="{{ $tipo_j->id }}">{{ $tipo_j->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_tipo_liquidacion" class="col-sm-4 control-label">Tipo liquidación</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_tipo_liquidacion" name="prfl_tipo_liquidacion">
                                    <option value="">Seleccione</option>
                                    @foreach($tipo_liquidacion as $tipo_l)
                                        @if($registro->prfl_tipo_liquidacion == $tipo_l->id)
                                            <option value="{{ $tipo_l->id }}" selected="selected">{{ $tipo_l->descripcion }}</option>
                                        @else
                                            <option value="{{ $tipo_l->id }}">{{ $tipo_l->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_tipo_salario" class="col-sm-4 control-label">Tipo salario</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_tipo_salario" name="prfl_tipo_salario">
                                    <option value="">Seleccione</option>
                                    @foreach($tipo_salario as $tipo_s)
                                        @if($registro->prfl_tipo_salario == $tipo_s->id)
                                            <option value="{{ $tipo_s->id }}" selected="selected">{{ $tipo_s->descripcion }}</option>
                                        @else
                                            <option value="{{ $tipo_s->id }}">{{ $tipo_s->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_salario" class="col-sm-4 control-label">Salario</label>
                            <div class="col-sm-8">
                                <?php
                                    $salario = '';
                                    if(!is_null($registro->prfl_salario) && $registro->prfl_salario > 0) {
                                        $salario = $registro->prfl_salario;
                                    }
                                ?>
                                <input type="text" class="form-control solo-numero" id="prfl_salario" name="prfl_salario" value="{{ $salario }}">
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_tipo_nomina" class="col-sm-4 control-label">Tipo nómina</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_tipo_nomina" name="prfl_tipo_nomina">
                                    <option value="">Seleccione</option>
                                    @foreach($tipo_nomina as $tipo_n)
                                        @if($registro->prfl_tipo_nomina == $tipo_n->id)
                                            <option value="{{ $tipo_n->id }}" selected="selected">{{ $tipo_n->descripcion }}</option>
                                        @else
                                            <option value="{{ $tipo_n->id }}">{{ $tipo_n->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_tipo_contrato" class="col-sm-4 control-label">Tipo Contrato</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_tipo_contrato" name="prfl_tipo_contrato">
                                    <option value="">Seleccione</option>
                                    @foreach($tipo_contrato as $tipo_c)
                                        @if($registro->prfl_tipo_contrato == $tipo_c->id)
                                            <option value="{{ $tipo_c->id }}" selected="selected">{{ $tipo_c->descripcion }}</option>
                                        @else
                                            <option value="{{ $tipo_c->id }}">{{ $tipo_c->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_concepto_pago" class="col-sm-4 control-label">Concepto de pago</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_concepto_pago" name="prfl_concepto_pago">
                                    <option value="">Seleccione</option>
                                    @foreach($conceptos_pago as $concepto)
                                        @if($registro->prfl_concepto_pago == $concepto->id)
                                            <option value="{{ $concepto->id }}" selected="selected">{{ $concepto->descripcion }}</option>
                                        @else
                                            <option value="{{ $concepto->id }}">{{ $concepto->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <?php
                            $prfl_adicional_salarial = '';
                            $prfl_funciones = '';
                            $prfl_perfil_oculto = '';
                            if(!is_null($registro->prfl_adicionales_salariales)) {
                                $prfl_adicional_salarial = $registro->prfl_adicionales_salariales;
                            }
                            if(!is_null($registro->prfl_funciones)) {
                                $prfl_funciones = $registro->prfl_funciones;
                            }
                            if(!is_null($registro->prfl_perfil_oculto)) {
                                $prfl_perfil_oculto = $registro->prfl_perfil_oculto;
                            }
                        ?>

                        <div class="col-md-6 form-group">
                            <label for="prfl_adicionales_salariales" class="col-sm-4 control-label">Adicionales salariales</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="prfl_adicionales_salariales" name="prfl_adicionales_salariales" value="{{ $prfl_adicional_salarial }}">
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="prfl_funciones" class="col-sm-4 control-label">Funciones</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="prfl_funciones" name="prfl_funciones">{{ $prfl_funciones }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="prfl_perfil_oculto" class="col-sm-4 control-label">Perfil Oculto</label>
                            <div class="col-sm-12">
                                <textarea class="form-control" id="prfl_perfil_oculto" name="prfl_perfil_oculto">{{ $prfl_perfil_oculto }}</textarea>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_nivel_estudio" class="col-sm-4 control-label">Nivel de estudio</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_nivel_estudio" name="prfl_nivel_estudio">
                                    <option value="">Seleccione</option>
                                    @foreach($niveles_estudio as $nivel_e)
                                        @if($registro->prfl_nivel_estudio == $nivel_e->id)
                                            <option value="{{ $nivel_e->id }}" selected="selected">{{ $nivel_e->descripcion }}</option>
                                        @else
                                            <option value="{{ $nivel_e->id }}">{{ $nivel_e->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_tiempo_experiencia" class="col-sm-4 control-label">Tiempo de experiencia</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_tiempo_experiencia" name="prfl_tiempo_experiencia">
                                    <option value="">Seleccione</option>
                                    @foreach($tiempo_experiencia as $tiempo)
                                        @if($registro->prfl_tiempo_experiencia == $tiempo->id)
                                            <option value="{{ $tiempo->id }}" selected="selected">{{ $tiempo->descripcion }}</option>
                                        @else
                                            <option value="{{ $tiempo->id }}">{{ $tiempo->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <?php
                            $prfl_edad_minima = '';
                            $prfl_edad_maxima = '';
                            if($registro->prfl_edad_minima > 0) {
                                $prfl_edad_minima = $registro->prfl_edad_minima;
                            }
                            if($registro->prfl_edad_maxima > 0) {
                                $prfl_edad_maxima = $registro->prfl_edad_maxima;
                            }
                        ?>

                        <div class="col-md-6 form-group">
                            <label for="prfl_edad_minima" class="col-sm-4 control-label">Rango de Edad</label>
                            <div class="col-sm-4">
                                <input class="form-control solo-numero" id="prfl_edad_minima" name="prfl_edad_minima" placeholder="Edad Mínima" data-min="17" data-max="50" value="{{ $prfl_edad_minima }}">
                            </div>
                            <div class="col-sm-4">
                                <input class="form-control solo-numero" id="prfl_edad_maxima" name="prfl_edad_maxima" placeholder="Edad Máxima" data-min="18" data-max="70" value="{{ $prfl_edad_maxima }}">
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_genero" class="col-sm-4 control-label">Género</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_genero" name="prfl_genero">
                                    <option value="">Seleccione</option>
                                    @foreach($generos as $genero)
                                        @if($registro->prfl_genero == $genero->id)
                                            <option value="{{ $genero->id }}" selected="selected">{{ $genero->descripcion }}</option>
                                        @else
                                            <option value="{{ $genero->id }}">{{ $genero->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="prfl_estado_civil" class="col-sm-4 control-label">Estado civil</label>
                            <div class="col-sm-8">
                                <select class="form-control" id="prfl_estado_civil" name="prfl_estado_civil">
                                    <option value="">Seleccione</option>
                                    @foreach($estados_civiles as $estado_civil)
                                        @if($registro->prfl_estado_civil == $estado_civil->id)
                                            <option value="{{ $estado_civil->id }}" selected="selected">{{ $estado_civil->descripcion }}</option>
                                        @else
                                            <option value="{{ $estado_civil->id }}">{{ $estado_civil->descripcion }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>