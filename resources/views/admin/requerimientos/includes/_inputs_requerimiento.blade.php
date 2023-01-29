<h3>{{$cliente->nombre}}</h3>
            <div class="clearfix"></div>

            <h4 class="titulo1">
               INFORMACIÓN GENERAL DE LA SOLICITUD
            </h4>

            <div class="row">
              <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-12 control-label">Tipo de Solicitud</label>
                 <div class="col-sm-12">
                  {!! Form::select("tipo_proceso_id",$tipoProceso,$requermiento->tipo_proceso_id,["class"=>"form-control"]); !!}
                 </div>
              </div>

                <div class="col-md-6 form-group">
                    <label for="inputEmail3" class="col-sm-12 control-label">Ciudad Trabajo</label>
                    <div class="col-sm-12">
                        {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                        {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                        {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                        {!! Form::text("ciudad_autocomplete",$requermiento->getUbicacion(),["placeholder"=>"Seleccione la ciudad","class"=>"form-control","id"=>"ciudad_autocomplete"]) !!}
                    </div>
                </div>
            </div>

            <h4 class="titulo1">
            
                    PERSONALIZACIÓN DE LA SOLICITUD
            </h4>
              
                <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="inputEmail3" class="col-sm-4 control-label">Nombre Solicitante</label>
                       <div class="col-sm-8">
                        {!! Form::text("contacto", ($user->name) ? strtoupper($user->name):'', ["class"=>"form-control"]); !!}
                       </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label"> Confidencial </label>
                        <div class="col-sm-8">
                            {!! Form::select("confidencial",['0'=>"No",'1'=>"Si"], $requermiento->confidencial,[ "class" => "form-control", "id" => "confidencial"]);!!}
                        </div>
                    </div>

                </div>

                    <div class="row">
                      <div class="col-md-6 form-group">
                       <label for="inputEmail3" class="col-sm-4 control-label">Num. Requi Cliente</label>
                        <div class="col-sm-8">
                         {!! Form::text("num_req_cliente",$requermiento->num_req_cliente,["class"=>"form-control", "placeholder" => "# Requi Cliente"]); !!}
                        </div>
                      </div>

                        <div class="col-md-6 form-group">
                            <label for="inputEmail3" class="col-sm-4 control-label">Teléfono</label>
                            <div class="col-sm-8">
                                {!! Form::text("contacto",$requermiento->telefono_solicitante,["class"=>"form-control", "placeholder" => "Teléfono Solicitante"]); !!}
                            </div>
                        </div>
                    </div>
                

            <h4 class="titulo1">ESPECIFICACIONES DEL REQUERIMIENTO</h4>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="cargo_especifico_id" class="col-sm-4 control-label">Cargo Cliente</label>
                        @if ( isset($modulo) && $modulo == 'admin' && $user_sesion->hasAccess('admin.cargos_especificos.nuevo'))
                            <div class="col-sm-8 input-group-bt4">
                                {!! Form::select("cargo_especifico_id",$cargo_especifico,$requermiento->cargo_especifico_id,["class"=>"form-control","id"=>"cargo_especifico_id"]); !!}
                                <span class="input-group-append">
                                    <button class="btn btn-primary" type="button" title="Crear nuevo cargo del cliente" onclick="crearCargo();"><i class="fa fa-plus"></i></button>
                                </span>
                            </div>
                        @else
                            <div class="col-sm-8">
                                {!! Form::select("cargo_especifico_id",$cargo_especifico,$requermiento->cargo_especifico_id,["class"=>"form-control","id"=>"cargo_especifico_id"]); !!}
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                     <label for="inputEmail3" class="col-sm-4 control-label">
                      Adjunto solicitud<span>*</span>
                     </label>
                     <div class="col-sm-8">
                        {!! Form::file("perfil", ["class" => "form-control-file", "id" => "perfil", "name" => "perfil"]) !!}
                    </div>
                     <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("perfil", $errors) !!} </p>
                    </div>
                </div>

                <div class="row">
                  
                  <div class="col-md-6 form-group">
                   <label for="inputEmail3" class="col-sm-4 control-label">Clase de riesgo</label>
                    <div class="col-sm-8">
                     {!! Form::select("ctra_x_clt_codigo",$centro_trabajo,$requermiento->ctra_x_clt_codigo,["class"=>"form-control","id"=>"ctra_x_clt_codigo"]); !!}
                    </div>
                  </div>
                
                 <div class="col-md-6 form-group">
                   <label for="inputEmail3" class="col-sm-4 control-label">Jornada Laboral</label>
                    <div class="col-sm-8">
                     {!! Form::select("tipo_jornadas_id",$tipoJornadas,$requermiento->tipo_jornadas_id,["class"=>"form-control","id"=>"tipo_jornadas_id"]); !!}
                    </div>
                 </div>

                </div>

                <div class="row">

                    <div class="col-md-6 form-group">
                     <label for="inputEmail3" class="col-sm-4 control-label">Tipo Liquidación</label>
                      <div class="col-sm-8">
                       {!! Form::select("tipo_liquidacion",$tipo_liquidacion,null,["class"=>"form-control","id"=>"tipo_liquidacion"]); !!}
                      </div>
                    </div>
            
                   
                    <div class="col-md-6 form-group">
                     <label for="inputEmail3" class="col-sm-4 control-label">Tipo Salario</label>
                      <div class="col-sm-8">
                       {!! Form::select("tipo_salario",$tipo_salario,$requermiento->tipo_salario,["class"=>"form-control","id"=>"tipo_salario"]); !!}
                      </div>
                    </div>
                    
                    <div class="col-md-6 form-group">
                     <label for="inputEmail3" class="col-sm-4 control-label">Tipo Nómina</label>
                      <div class="col-sm-8">
                       {!! Form::select("tipo_nomina",$tipo_nomina,$requermiento->tipo_nomina,["class"=>"form-control","id"=>"tipo_nomina"]); !!}
                      </div>
                    </div>
                
                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Concepto Pago</label>
                        <div class="col-sm-8">
                            {!! Form::select("concepto_pago_id",$concepto_pago_id,$requermiento->concepto_pago_id,["class"=>"form-control","id"=>"concepto_pago_id"]); !!}
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Salario</label>
                        <div class="col-sm-8">
                            {!! Form::text("salario",$requermiento->salario,["class"=>"form-control",'id'=>"salario"]); !!}
                        </div>
                    </div>

                    
                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Tipo Contrato</label>
                        <div class="col-sm-8">              
                            {!! Form::select("tipo_contrato_id",$tipoContrato,$requermiento->tipo_contrato_id,["class"=>"form-control","id"=>"tipo_contrato_id"]); !!}

                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="inputEmail3" class="col-sm-4 control-label">Adicionales Salariales</label>
                        <div class="col-sm-8">
                         {!! Form::text("adicionales_salariales", $requermiento->adicionales_salariales, ["class" => "form-control", "id" => "adicionalesSalariales", "placeholder" => "Adicionales salariales", "data-max" => '255' ]);!!}
                        </div>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Motivo Requerimiento</label>
                        <div class="col-sm-8">

                            {!! Form::select("motivo_requerimiento_id",$motivoRequerimiento,$requermiento->motivo_requerimiento_id,["class"=>"form-control","id"=>"motivo_requerimiento_id"]); !!}

                        </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Número Vacantes</label>
                        <div class="col-sm-8">
                            {!! Form::text("num_vacantes",$requermiento->num_vacantes,["class"=>"form-control","id"=>"num_vacantes"]); !!}

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                      <label for="inputEmail3" class="col-sm-2 control-label">Funciones a Realizar <span>*</span></label>
                        <div class="col-sm-12">
                          {!! Form::textarea("funciones",$requermiento->funciones,["class"=>"form-control","id"=>"funciones","rows"=>"3","required"]); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="inputEmail3" class="col-sm-12 control-label">Adicionales/Observaciones</label>
                        <div class="col-sm-12">
                            {!! Form::textarea("observaciones",$requermiento->observaciones,["rows"=>"3","class"=>"form-control"]); !!}
                        </div>
                    </div>
                </div>

            <h4 class="titulo1">ESTUDIOS</h4>
                <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="inputEmail3" class="col-sm-4 control-label">Nivel Estudio</label>
                        <div class="col-sm-8">
                         {!! Form::select("nivel_estudio",$nivel_estudio,$requermiento->nivel_estudio,["class"=>"form-control","id"=>"nivel_estudio"]); !!}
                        </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Tiempo de Experiencia <span>*</span></label>
                        <div class="col-sm-8">
                            {!! Form::select("tipo_experiencia_id",$tipo_experiencia, $requermiento->tipo_experiencia_id, ["class"=>"form-control","id"=>"tipo_experiencia_id","required"]); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Rango de Edad:</label>
                        <div class="col-sm-4">
                            {!! Form::text("edad_minima", $requermiento->edad_minima, ["class" => "form-control solo-numero", "id" => "edad_minima", "placeholder" => "Edad Mínima", "data-min" => 17, "data-max" => 50 ]);!!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::text("edad_maxima", $requermiento->edad_maxima, ["class" => "form-control solo-numero", "id" => "edad_maxima", "placeholder" => "Edad Máxima", "data-min" => 18, "data-max" => 70 ]);!!}
                        </div>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Género</label>
                        <div class="col-sm-8">
                            {!! Form::select("genero_id",$tipoGenero,$requermiento->genero_id,["class"=>"form-control","id"=>"genero_id"]); !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                   <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Estado Civil <span>*</span></label>
                        <div class="col-sm-8">
                            {!! Form::select("estado_civil",$estados_civiles,$requermiento->estado_civil,["class"=>"form-control","id"=>"estado_civil"]); !!}
                       </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 form-group">
                      <label for="inputEmail3" class="col-sm-4 control-label">Fecha Ingreso</label>
                       <div class="col-sm-8">
                        {!! Form::text("fecha_ingreso",$requermiento->fecha_ingreso,["class"=>"form-control", "id"=>"fecha_ingreso"]); !!}
                       </div>
                    </div>

                    <div class="col-md-6 form-group">
                     <label for="inputEmail3" class="col-sm-4 control-label">Fecha Retiro<span>*</span></label>
                      <div class="col-sm-8">
                       {!! Form::text("fecha_retiro",$requermiento->fecha_retiro, ["class" => "form-control", "placeholder" => "AAAA-MM-DD", "id" => "fecha_retiro"]); !!}
                      </div>
                    </div>
                </div>

                <h4 class="titulo1">SOPORTE SOLICITUD DE REQUISICION DEL CLIENTE</h4>

                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Fecha Recepción Solicitud</label>
                        <div class="col-sm-8">
                            {!! Form::text("fecha_recepcion",$requermiento->fecha_recepcion,["class"=>"form-control"]); !!}
                        </div>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="inputEmail3" class="col-sm-4 control-label">Contenido Email Soporte</label>
                        <div class="col-sm-8">
                            {!! Form::text("contacto",$requermiento->contenido_email_soporte,["class"=>"form-control"]); !!}
                        </div>
                    </div>
                </div>