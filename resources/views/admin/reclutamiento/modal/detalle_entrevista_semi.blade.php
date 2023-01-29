<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Detalle entrevista semiestructurada</h4>
</div>

<style>
    #campo_valor, #campo_reporte, #campo_empresa_trabajo{ display: none; }
</style>

<div class="modal-body">
    
    @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") 

        {{--SI ES KOMATSU--}}
        {!! Form::model(Request::all(),["id"=>"fr_entrevista_semi"]) !!}
            {!! Form::hidden("ref_id") !!}
            {!! Form::hidden("tentativo",0) !!}
            {!! Form::hidden("personas_a_cargo",0) !!}
            {!! Form::hidden("apto",0) !!}
            {!! Form::hidden("continua",0) !!}
            {!! Form::hidden("req_id") !!}
            {!! Form::hidden("id",$entrevista->id,["id"=>"id_entrevista"]) !!}

            <hr>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <label for="inputEmail3" class="col-sm-4 control-label"> Candidato</label>
                        <div class="col-sm-8">
                            {!! Form::text("candidato",$proceso->nombres,["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("candidato",$errors) !!}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="inputEmail3" class="col-sm-4 control-label"> Cargo aspirado</label>
                        <div class="col-sm-8">
                            {!! Form::text("cargo_aspirado",$proceso->cargo_aspirado,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_aspirado",$errors) !!}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inputEmail3" class="col-sm-4 control-label"> Entrevistador</label>
                        <div class="col-sm-8">
                            {!! Form::text("entrevistador",$entrevistador->name,["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="inputEmail3" class="col-sm-4 control-label"> Cargo Entrevistador</label>
                        <div class="col-sm-8">
                            {!! Form::text("cargo_entrevistador",NULL,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_entrevistador",$errors) !!}</p>
                    </div>
                </div>
                
                <br>

                <div class="row"></div>
            </div>

            <h3><p style="text-align: center;">INFORMACION PERSONAL/GENERAL</p></h3>
            
            <hr>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        {!! Form::textarea("info_general",$entrevista->info_general,["class"=>"form-control","id"=>"textarea","rows"=>"5"]); !!}
                    </div>
                </div>
            </div>

            <h3><p style="text-align: center;">INFORMACION LABORAL</p></h3>

            <?php $item=0; ?>
   
            <div class="container-fluid">
                @if($experiencias->count()>0)
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($experiencias as $experiencia)
                                {!! Form::hidden("exp_id[]",$experiencia->id) !!}
                                
                                <h4>Empresa {{++$item}}</h4>
                                
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> Empresa</label>
                                        <div class="col-sm-7">
                                         {!! Form::text("empresa",$experiencia->nombre_empresa,["class"=>"form-control","id"=>"empresa","readonly"=>"readonly"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> Cargo</label>
                                        <div class="col-sm-7">
                                            {!! Form::text("cargo_desem[]",$experiencia->desc_cargo,["class"=>"form-control","id"=>"cargo_desem","readonly"=>"readonly"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_desem",$errors) !!}</p>
                                    </div>

                                    <div class="col-md-4">
                                        <?php
                                          
                                            $fecha1 = $experiencia->fecha_inicio;
                                            $fecha_i = new DateTime($fecha1);
                                          
                                            $fecha2 = $experiencia->fecha_final;
                                            $fecha_f = new DateTime($fecha2);
                                            $fecha_hoy = $fecha_i->diff($fecha_f);
                                            //dd($fecha_hoy);

                                        ?>

                                        <label for="inputEmail3" class="col-sm-5 control-label">Duración</label>

                                        <div class="col-sm-7">
                                            @if($experiencia->fecha_final != "0000-00-00")
                                                @if ($fecha_hoy->y <= 0)
                                                    {!! Form::text("duracion[]",$fecha_hoy->m." Meses",["class"=>"form-control","id"=>"duracion","readonly"=>"readonly"]); !!}
                                                @else
                                                    {!! Form::text("duracion[]",$fecha_hoy->y. " Años ".$fecha_hoy->m." Meses",["class"=>"form-control","id"=>"duracion","readonly"=>"readonly"]); !!}
                                                @endif
                                            @else                        
                                                {!! Form::text("duracion[]",$trabajo,["class"=>"form-control","id"=>"duracion","readonly"=>"readonly"]); !!}
                                            @endif
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                    </div>
                                </div>
                                
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-sm-12">
                                            {!! Form::textarea("dedicacion_empresa[]",$experiencia->dedicacion_empresa,["class"=>"form-control","id"=>"fortalezas","rows"=>"3","placeholder"=>"A que se dedica la empresa"]); !!}
                                        </div>                
                                    </div>
                                </div>

                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-4 control-label">#Empleados</label>
                                        
                                        <div class="col-sm-7">
                                            {!! Form::text("num_empleados[]",$experiencia->cantidad_empleados,["class"=>"form-control","id"=>"cargo_desem"]); !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("num_empleados",$errors) !!}</p>
                                    </div>
              
                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-5 control-label">A quién le reportaba (nombre y cargo)</label>
                                        <div class="col-sm-7">
                                            {!! Form::text("jefe",$experiencia->nombres_jefe,["class"=>"form-control","id"=>"cliente"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("jefe",$errors) !!}</p>
                                    </div>
                                </div>
                                
                                <br><br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="trabajo-empresa-temporal" class="col-md-4 control-label">Personas a su cargo?</label>
                                            <div class="col-md-8">
                                                {!! Form::checkbox("personas_a_cargo[]",1,$experiencia->personas_a_cargo,["class"=>"checkbox-preferencias si_no" ]) !!}
                                            </div>
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Cuantos</label>
                                        <div class="col-sm-7">
                                            {!! Form::text("cant_a_cargo[]",$experiencia->cant_a_cargo,["class"=>"form-control","id"=>"cargo_desem"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                    </div>
                                </div>
                                
                                <br><br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-sm-12">
                                            {!! Form::textarea("responsabilidades[]",null,["class"=>"form-control","id"=>"fortalezas","rows"=>"3","placeholder"=>"Responsabilidades principales (se puede profundizar en las relacionadas con el cargo aspirado):"]); !!}
                                        </div>
                                    </div>
                                </div>
                                
                                <br>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-sm-12">
                                            {!! Form::textarea("logros[]",null,["class"=>"form-control","id"=>"fortalezas","rows"=>"3","placeholder"=>"Logros relevantes (se puede profundizar en el \"como\" se llegó a la consecución de ese logro para evidenciar competencias requeridas):"]); !!}
                                        </div>
                                    </div>
                                </div>
                                
                                <br>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-sm-12">
                                            {!! Form::textarea("motivo_retiro[]",$experiencia->desc_motivo.' '.$experiencia->motivo_retiro_txt,["class"=>"form-control","id"=>"fortalezas","rows"=>"3","placeholder"=>"Motivo retiro"]); !!}
                                        </div>                
                                    </div>
                                </div>
                                
                                <br><br><br>
                            @endforeach
                        </div>
                    </div>
                @else
                    <p style="text-align: center;">No tiene informacion Laboral</p>
                @endif
            </div>

            <div class="container-fluid">
                <h3><p style="text-align: center;">FORTALEZAS FRENTE AL CARGO</p></h3>
                
                <hr>

                <div class="row">
                 <div class="col-md-12">
                   <div class="col-sm-12">
                    {!! Form::textarea("fortalezas",$entrevista->fortalezas,["class"=>"form-control","id"=>"fortalezas","rows"=>"3"]); !!}
                   </div>
                 </div>
                </div>

                <div class="row">
                    <h3><p style="text-align: center;">OPORTUNIDADES DE MEJORA FRENTE AL CARGO</p></h3>
                    
                    <hr>
        
                    <div class="col-sm-12">
                     {!! Form::textarea("opor_mejora",$entrevista->opor_mejora,["class"=>"form-control","id"=>"opor_mejora","rows"=>"3"]); !!}
                    </div>
                  <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("especificaciones_cargo",$errors) !!}</p>
                </div>
     
                <div class="row">
                    <div class="col-md-12">
                      <h3><p style="text-align: center;">OTRAS HABILIDADES/CONOCIMIENTO</p></h3>
                        <hr>
                        <div class="col-sm-6">
                         <div class="form-group">
                          <label for="trabajo-empresa-temporal" class="col-md-2 control-label">Idioma1</label>
                           <div class="col-md-7">
                            {!! Form::text("idioma_1",$entrevista->idioma_1,["class"=>"form-control","id"=>"idioma_1"]); !!}
                           </div>
                          </div>

                            <br>
                            
                            <div class="form-group">
                                <label for="trabajo-empresa-temporal" class="col-md-2 control-label">Nivel</label>
                                <div class="col-md-7">
                                    {!! Form::text("nivel_1",$entrevista->nivel_1,["class"=>"form-control","id"=>"nivel_1"]); !!}
                                </div>
                            </div>
                        </div>

                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("otros_trabajos",$errors) !!}</p>
                        
                        <div class="col-sm-6">
                          <div class="form-group">
                             <label for="trabajo-empresa-temporal" class="col-md-2 control-label">Idioma2</label>
                                <div class="col-md-7">
                                 {!! Form::text("idioma_2",$entrevista->idioma_2,["class"=>"form-control","id"=>"idioma_2"]); !!}
                                </div>
                            </div>

                            <br>

                            <div class="form-group">
                                <label for="trabajo-empresa-temporal" class="col-md-2 control-label">Nivel</label>
                                <div class="col-md-7">
                                    {!! Form::text("nivel_2",$entrevista->nivel_2,["class"=>"form-control","id"=>"nivel2"]); !!}
                                </div>
                            </div>
                        </div>

                        <br><br><br><br><br>

                        <div class="row">
                            <div class="col-sm-12">
                                 <div class="form-group">
                                     {!! Form::textarea("herramientas",$entrevista->herramientas,["class"=>"form-control","id"=>"textarea","rows"=>"3","placeholder"=>"Herramientas informaticas/softwares"]); !!}
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::textarea("otras_herramientas",$entrevista->otras_herramientas,["class"=>"form-control","id"=>"textarea","rows"=>"3","placeholder"=>"Otras habilidades/herramientas/conocimiento requeridos:"]); !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <h3><p style="text-align: center;">EXPECTATIVAS</p></h3>
                    
                    <hr>
       
                    <div class="col-sm-12">
                        {!! Form::textarea("motivacion",$entrevista->motivacion,["class"=>"form-control","id"=>"textarea","rows"=>"3","placeholder"=>"Motivación para participar en el proceso (por qué decidió participar?):"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("expectativas",$errors) !!}</p>
                    <div class="col-sm-12">
                        {!! Form::textarea("expectativas",$entrevista->expectativas,["class"=>"form-control","id"=>"textarea","rows"=>"3","placeholder"=>"Expectativas para la reubicación laboral (qué espera de la compañía y del cargo?)"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("expectativas",$errors) !!}</p>
                </div>

                <div class="row">
                    <h3><p style="text-align: center;">OBSERVACIONES ADICIONALES</p></h3>
                    
                    <hr>

                    <div class="col-sm-12">
                      {!! Form::textarea("conflicto",$entrevista->conflicto,["class"=>"form-control","id"=>"conflicto_txt","rows"=>"5","placeholder"=>"Conflicto de intereses.(tiene el candidato algún tipo de relación de parentesco -civil, afinidad o consanguinidad- con algún empleado o contratista, proveedor, cliente de la compañía; participación en la propiedad o gestión de un tercero)"]); !!}
                        
                    </div>
                    
                    <br>

                    <div class="col-sm-12">
                         {!! Form::textarea("conflicto_entrevistador",$entrevista->conflicto_entrevistador,["class"=>"form-control","id"=>"conflicto_txt_entrevistador","rows"=>"5","placeholder"=>"Tiene el entrevistador algún tipo de relación de parentesco -civil, afinidad o consanguinidad-, conoce o ha trabajado con el candidato entrevistado"]); !!}
                        
                    </div>
                    
                    <div class="col-sm-12">
                        {!! Form::textarea("comentarios_entrevistado",$entrevista->comentarios_entrevistado,["class"=>"form-control","id"=>"textarea","rows"=>"3","placeholder"=>"Comentarios adicionales del entrevistado:"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("comentarios_entrevistado",$errors) !!}</p>
                    
                    <br><br><br>

                    <div class="col-sm-12">
                        {!! Form::textarea("comentarios_entrevistador",$entrevista->comentarios_entrevistador,["class"=>"form-control","id"=>"textarea","rows"=>"3","placeholder"=>"Comentarios adicionales del entrevistador:"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("comentarios_entrevistador",$errors) !!}</p>
                </div>
            </div>
            
            {{-- Aqui  iba la informacion laboral--}}       
            <br/><br/><br>

            <div class="clearfix"></div>

            <div class="col-md-12">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="trabajo-empresa-temporal" class="col-md-4 control-label">Apto:</label>
                        <div class="col-md-8">
                            <label class="switchBtn">
                                {!! Form::checkbox("apto",1,$entrevista->apto,["class"=>"checkbox-preferencias","id"=>"switch"]) !!}
                                <div class="slide"></div>
                            </label>
                        </div>
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="trabajo-empresa-temporal" class="col-md-4 control-label">Continua proceso</label>
                        <div class="col-md-8">
                            <label class="switchBtn">
                                {!!Form::checkbox("continua",1,$entrevista->continua,["class"=>"checkbox-preferencias si_no" ])!!}
                                <div class="slide"></div>
                            </label>
                        </div>
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
                </div>
                   
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="trabajo-empresa-temporal" class="col-md-4 control-label">Tentativo:</label>
                        <div class="col-md-8">
                            <label class="switchBtn">
                                {!! Form::checkbox("tentativo",1,$entrevista->tentativo,["class"=>"checkbox-preferencias si_no","id"=>"switch"]) !!}
                                <div class="slide"></div>
                            </label>
                        </div>
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
                </div>
            </div>
            
            <br>
            
            <div class="form-group">
                <label for="textarea" class="col-sm-4 control-label"> Justificacion</label>
                <div class="col-sm-12">
                    {!! Form::textarea("justificacion",$entrevista->justificacion,["class"=>"form-control","id"=>"justificacion","rows"=>"3"]); !!}
                </div>
            </div>
   

            <div class="clearfix"></div>
        {!! Form::close() !!}

    @elseif(route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" || route('home') == "http://localhost:8000" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co")

        {!! Form::model($todo,["id"=>"fr_entrevista_semi"]) !!}
            
            {!! Form::hidden("ref_id") !!}
            {!! Form::hidden("id", $todo[0]->id,["id"=>"id_entrevista"]) !!}
            {!! Form::hidden("candidato_id", $todo[0]->candidato_id) !!}

            <!-- Información vacante -->
            <div class="container-fluid">
                <div class="row">

                    <?php $fechaHoy = date('Y-m-d'); ?>

                    <!-- Fecha dil / Nombre entre -->
                    <div class="row">
                    
                        <div class="col-md-6">
                            <label for="cargo" class="col-sm-12 control-label">Fecha de diligenciamiento</label>
                            <div class="col-sm-10">
                                {!! Form::text("fecha_diligenciamiento",$fechaHoy,["class"=>"form-control","id"=>"fecha_diligenciamiento","readonly"=>"readonly"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="cargo" class="col-sm-12 control-label">Nombre del entrevistador</label>
                            <div class="col-sm-10">
                                {!! Form::text("nombre_entrevistador", $entrevistador,["class"=>"form-control","id"=>"nombre_entrevistador","readonly"=>"readonly"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                    </div>

                    <br>

                    <!-- Cargo apli / Empresa-CLiente -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Cargo al que aplica</label>
                            <div class="col-sm-10">
                                {!! Form::text("cargo",$todo[1]->descripcion,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Empresa Usuaria</label>
                            <div class="col-sm-10">
                                {!! Form::text("cliente",$todo[1]->nombre,["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                </div>

            </div>

            <h3><p style="text-align: center;">Datos generales del candidato</p></h3>
            
            <hr>

            <!-- Datos Candidato -->
            <div class="container-fluid">
    
                <div class="row">

                    <!-- Nombre / Doc. Id -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="nombre_candidato" class="col-sm-12 control-label"> Nombre</label>
                            <div class="col-sm-10">
                                {!! Form::text("nombre_candidato",$todo[1]->nombres." ".$todo[1]->primer_apellido." ".$todo[1]->segundo_apellido ,["class"=>"form-control","id"=>"nombre_candidato"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Documento de identidad</label>
                            <div class="col-sm-10">
                                {!! Form::number("numero_id",$todo[1]->numero_id,["class"=>"form-control","id"=>"numero_id"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Edad / F. Nac -->
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label"> Edad</label>
                            <div class="col-sm-10">
                                {!! Form::number("edad",$todo[1]->edad,["class"=>"form-control","id"=>"edad","readonly"=>"readonly"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label"> Fecha de Nacimiento</label>
                            <div class="col-sm-10">
                                {!! Form::date("fecha_nacimiento",$todo[1]->fecha_nacimiento,["class"=>"form-control","id"=>"fecha_nacimiento"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                       
                    </div>
                    
                    <br>

                    <!-- ciudad nacimiento - ciudad residencia -->
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Ciudad Nacimiento</label>
                            
                            <div class="col-sm-10">
                                {!! Form::text("ciudad_nacimiento_txt",$ciudadNacimiento, ["class"=>"form-control","id"=>"ciudad_nacimiento_txt"]); !!}

                                <input type="hidden" name="pais_nacimiento" id="pais_nacimiento" value="{{ $todo[1]->pais_nacimiento }}">
                                <input type="hidden" name="departamento_nacimiento" id="departamento_nacimiento" value="{{ $todo[1]->departamento_nacimiento }}">
                                <input type="hidden" name="ciudad_nacimiento" id="ciudad_nacimiento" value="{{ $todo[1]->ciudad_nacimiento }}">
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Ciudad Residencia</label>
                            <div class="col-sm-10">
                                {!! Form::text("ciudad_residencia_txt",$ciudadResidencia, ["class"=>"form-control","id"=>"ciudad_residencia_txt"]); !!}

                                <input type="hidden" name="pais_residencia" id="pais_residencia" value="{{ $todo[1]->pais_residencia }}">
                                <input type="hidden" name="departamento_residencia" id="departamento_residencia" value="{{ $todo[1]->departamento_residencia }}">
                                <input type="hidden" name="ciudad_residencia" id="ciudad_residencia" value="{{ $todo[1]->ciudad_residencia }}">
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                       
                    </div>

                    <br>

                    <!-- dirección - localidad -->
                    <div class="row">
                        
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Dirección</label>
                            <div class="col-sm-10">
                                {!! Form::text("direccion",$todo[1]->direccion,["class"=>"form-control","id"=>"direccion"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="localidad" class="col-sm-12 control-label">Localidad</label>
                            <div class="col-sm-10">
                                {!! Form::text("localidad",$todo[1]->localidad,["class"=>"form-control","id"=>"localidad"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("localidad",$errors) !!}</p>
                        </div>

                    </div>
                    
                    <br>

                    <!-- barrio - celular -->
                    <div class="row">

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Barrio</label>
                            <div class="col-sm-10">
                                {!! Form::text("barrio",$todo[1]->barrio,["class"=>"form-control","id"=>"barrio"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Celular</label>
                            <div class="col-sm-10">
                                {!! Form::number("telefono_movil",$todo[1]->telefono_movil,["class"=>"form-control","id"=>"telefono_movil"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                    </div>

                    <br>

                    <!-- telefono - email -->
                    <div class="row">

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Teléfono</label>
                            <div class="col-sm-10">
                                {!! Form::number("telefono_fijo",$todo[1]->telefono_fijo,["class"=>"form-control","id"=>"telefono_fijo"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Email</label>
                            <div class="col-sm-10">
                                {!! Form::email("email",$todo[1]->email,["class"=>"form-control","id"=>"email"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                    </div>

                </div>

            </div>
    
            <hr>

            <h3><p style="text-align: center;">Información familiar</p></h3>

            <hr>

            <!-- Datos familiares -->
            <div class="container-fluid">
                <div class="row" id="nuevo_familiar">
                    
                    <div class="col-sm-10">
                        <h4>- Grupo familiar</h4>
                        <br>
                    </div>

                    <div class="grupos_fams">

                        <!-- Tip. Doc / Documento -->
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <label for="tipo_documento" class="col-sm-12 control-label">Tipo Documento</label>
                                <div class="col-sm-10">
                                    {!! Form::select("tipo_documento[]",$tipos_documentos, null,["class"=>"form-control","id"=>"tipo_documento"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_documento",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="documento_identidad" class="col-sm-12 control-label"># Documento</label>
                                <div class="col-sm-10">
                                    {!! Form::number("documento_identidad[]",null,["class"=>"form-control","id"=>"documento_identidad"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("documento_identidad",$errors) !!}</p>
                            </div>
                        </div> --}}

                        <br>

                        <!-- Nombres / Primer Ape. -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombres_familiar" class="col-sm-12 control-label">Nombres</label>
                                <div class="col-sm-10">
                                    {!! Form::text("nombres_familiar[]",null,["class"=>"form-control","id"=>"nombres_familiar"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="primer_apellido_familiar" class="col-sm-12 control-label">Primer Apellido</label>
                                <div class="col-sm-10">
                                    {!! Form::text("primer_apellido_familiar[]",null,["class"=>"form-control","id"=>"primer_apellido_familiar"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido_familiar",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- Segundo Ape. / Parentesco -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="segundo_apellido_familiar" class="col-sm-12 control-label">Segundo Apellido</label>
                                <div class="col-sm-10">
                                    {!! Form::text("segundo_apellido_familiar[]",null,["class"=>"form-control","id"=>"segundo_apellido_familiar"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="parentesco_id" class="col-sm-12 control-label">Parentesco</label>
                                <div class="col-sm-10">
                                    {!! Form::select("parentesco_id[]",$parentesco, null,["class"=>"form-control","id"=>"parentesco_id"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("parentesco_id",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- Fech Nac / Gene -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fecha_nacimiento_familiar" class="col-sm-12 control-label">Fecha Nacimiento</label>
                                <div class="col-sm-10">
                                    {!! Form::date("fecha_nacimiento_familiar[]",null,["class"=>"form-control","id"=>"fecha_nacimiento_familiar"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_nacimiento_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="genero" class="col-sm-12 control-label">Género</label>
                                <div class="col-sm-10">
                                    {!! Form::select("genero[]",$genero, null,["class"=>"form-control","id"=>"genero"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("genero",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- Convive -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="telefono_familiar" class="col-sm-12 control-label">Celular / Teléfono</label>
                                <div class="col-sm-10">
                                    {!! Form::number("telefono_familiar[]",null,["class"=>"form-control","id"=>"telefono_familiar"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="convive" class="col-sm-12 control-label">Convive</label>
                                <div class="col-sm-10">
                                    {!! Form::select("convive[]",[""=>"Seleccionar","1"=>"Si","0"=>"No"],null,["class"=>"form-control","id"=>"convive"
                                    ]) !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("convive",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10 boton_aqui">
                                <button type="button" class="btn btn-success pull-right add-person" title="Agregar grupo">+</button>
                            </div>
                        </div>
                    </div>

                </div>
                
                <br>

                <!-- Lista familiares -->
                <div class="row">
                    <table class="table table-bordered tbl_info">
                        <tr>
                            {{-- <th>Documento</th> --}}
                            <th>Nombre de Familiar</th>
                            <th>Teléfono</th>
                            <th colspan="2">Convive</th>
                        </tr>

                        @if (count($familiares) <= 0)
                            <tr>
                                <td>No registra grupo familiar</td>
                            </tr>
                        @else
                            @foreach($familiares as $familiar)
                                <tr>
                                    {{-- <td>{{ $familiar->documento_identidad }}</td> --}}
                                    <td>{{ $familiar->nombres}} {{$familiar->primer_apellido}} {{$familiar->segundo_apellido}}</td>
                                    <td>{{ $familiar->celular_contacto }}</td>
                                    <td>
                                        @if ($familiar->convive == 1)
                                            Si
                                        @elseif($familiar->convive == 0)
                                            No
                                        @elseif($familiar->convive == null)
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    
                    </table>

                    <!-- Observaciones entrevistador -->
                    <div class="row">
                        
                        <div class="col-md-12">
                            <label for="cargo" class="col-sm-12 control-label">Observaciones del entrevistador (grupo familiar)</label>
                            <div class="col-sm-12">
                                {!! Form::textarea("observacion_familiar", $todo[0]->observacion_familiar,["class"=>"form-control","id"=>"observacion_familiar",
                                    "rows"=>2]); !!}
                            </div>  
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                        
                    </div>
                </div>

            </div>

            <hr>

            <h3><p style="text-align: center;">Información  de educación e información adicional</p></h3>

            <hr>

            <!-- Información de Estudio y Otros -->
            <div class="container-fluid">
                
                <div class="row">

                    <!-- Tabla estudios culminados -->
                    <div class="col-sm-12">
                        <table class="table table-bordered tbl_info">
                            <tr>
                                <th></th>
                                <th>Culminado</th>
                                <th>Año Culminación</th>
                            </tr>

                            <tr>
                                <td>Primaria</td>
                                @if(count($primaria) >= 1)
                                    @if ($primaria->fecha_finalizacion != null)
                                        <td>
                                            <select name="primaria_culminado" id="primaria_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1" selected>Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_primaria", $primaria->fecha_finalizacion,["class"=>"form-control","id"=>"fecha_culminacion_primaria"]); !!}
                                        </td>
                                    @else
                                        <td>
                                            <select name="primaria_culminado" id="primaria_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Si</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_primaria", null,["class"=>"form-control","id"=>"fecha_culminacion_primaria"]); !!}
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        {!! Form::select("primaria_culminado", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null,["class"=>"form-control","id"=>"primaria_culminado"]); !!}
                                    </td>
                                    <td>
                                        {!! Form::date("fecha_culminacion_primaria", null,["class"=>"form-control","id"=>"fecha_culminacion_primaria"]); !!}
                                    </td>
                                @endif
                            </tr>

                            <tr>
                                <td>Secundaria</td>
                                @if(count($secundaria) >= 1)
                                    @if ($secundaria->fecha_finalizacion != null)
                                        <td>
                                            <select name="secundaria_culminado" id="secundaria_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1" selected>Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_sec", $secundaria->fecha_finalizacion,["class"=>"form-control","id"=>"fecha_culminacion_sec"]); !!}
                                        </td>
                                    @else
                                        <td>
                                            <select name="secundaria_culminado" id="secundaria_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Si</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_sec", null,["class"=>"form-control","id"=>"fecha_culminacion_sec"]); !!}
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        {!! Form::select("secundaria_culminado", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null,["class"=>"form-control","id"=>"secundaria_culminado"]); !!}
                                    </td>
                                    <td>
                                        {!! Form::date("fecha_culminacion_sec", null,["class"=>"form-control","id"=>"fecha_culminacion_sec"]); !!}
                                    </td>
                                @endif
                            </tr>

                            <tr>
                                <td>Técnico</td>
                                @if(count($tecnico) >= 1)
                                    @if ($tecnico->fecha_finalizacion != null)
                                        <td>
                                            <select name="tecnico_culminado" id="tecnico_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1" selected>Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_tecnico", $tecnico->fecha_finalizacion,["class"=>"form-control","id"=>"fecha_culminacion_tecnico"]); !!}
                                        </td>
                                    @else
                                        <td>
                                            <select name="tecnico_culminado" id="tecnico_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Si</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_tecnico", null,["class"=>"form-control","id"=>"fecha_culminacion_tecnico"]); !!}
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        {!! Form::select("tecnico_culminado", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null,["class"=>"form-control","id"=>"tecnico_culminado"]); !!}
                                    </td>
                                    <td>
                                        {!! Form::date("fecha_culminacion_tecnico", null,["class"=>"form-control","id"=>"fecha_culminacion_tecnico"]); !!}
                                    </td>
                                @endif
                            </tr>

                            <tr>
                                <td>Tecnólogo</td>
                                @if(count($tecnologo) >= 1)
                                    @if ($tecnologo->fecha_finalizacion != null)
                                        <td>
                                            <select name="tecnol_culminado" id="tecnol_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1" selected>Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_tecnol", $tecnologo->fecha_finalizacion,["class"=>"form-control","id"=>"fecha_culminacion_tecnol"]); !!}
                                        </td>
                                    @else
                                        <td>
                                            <select name="tecnol_culminado" id="tecnol_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Si</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_tecnol", null,["class"=>"form-control","id"=>"fecha_culminacion_tecnol"]); !!}
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        {!! Form::select("tecnol_culminado", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null,["class"=>"form-control","id"=>"tecnol_culminado"]); !!}
                                    </td>
                                    <td>
                                        {!! Form::date("fecha_culminacion_tecnol", null,["class"=>"form-control","id"=>"fecha_culminacion_tecnol"]); !!}
                                    </td>
                                @endif
                            </tr>

                            <tr>
                                <td>Universitario</td>
                                @if(count($universidad) >= 1)
                                    @if ($universidad->fecha_finalizacion != null)
                                        <td>
                                            <select name="univ_culminado" id="univ_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1" selected>Si</option>
                                                <option value="0">No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_univ", $universidad->fecha_finalizacion,["class"=>"form-control","id"=>"fecha_culminacion_univ"]); !!}
                                        </td>
                                    @else
                                        <td>
                                            <select name="univ_culminado" id="univ_culminado" class="form-control">
                                                <option value="">Seleccionar</option>
                                                <option value="1">Si</option>
                                                <option value="0" selected>No</option>
                                            </select>
                                        </td>
                                        <td>
                                            {!! Form::date("fecha_culminacion_univ", null,["class"=>"form-control","id"=>"fecha_culminacion_univ"]); !!}
                                        </td>
                                    @endif
                                @else
                                    <td>
                                        {!! Form::select("univ_culminado", ["" => "Seleccionar", "1" => "Si", "0" => "No"], null,["class"=>"form-control","id"=>"univ_culminado"]); !!}
                                    </td>
                                    <td>
                                        {!! Form::date("fecha_culminacion_univ", null,["class"=>"form-control","id"=>"fecha_culminacion_univ"]); !!}
                                    </td>
                                @endif
                            </tr>
                            
                        </table>
                    </div>
                    <!-- / Tabla estudios culminados -->

                    <!-- Ultimo niv. / Titulo obt. -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Último nivel académico</label>
                            <div class="col-sm-10">
                                @if ($estudioReciente == '')
                                    {!! Form::text("ultimo_nivel_acad", null,["class"=>"form-control","id"=>"ultimo_nivel_acad","readonly"=>"readonly"]); !!}
                                @else
                                    {!! Form::text("ultimo_nivel_acad", $estudioReciente->desc_nivel,["class"=>"form-control","id"=>"ultimo_nivel_acad","readonly"=>"readonly"]); !!}
                                @endif
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Titulo obtenido</label>
                            <div class="col-sm-10">
                                @if ($estudioReciente == '')
                                    {!! Form::text("titulo_obtenido", null,["class"=>"form-control","id"=>"titulo_obtenido","readonly"=>"readonly"]); !!}
                                @else
                                    {!! Form::text("titulo_obtenido", $estudioReciente->titulo_obtenido,["class"=>"form-control","id"=>"titulo_obtenido","readonly"=>"readonly"]); !!}
                                @endif
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Estado civ. / No. hijos. -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Estado civil</label>
                            <div class="col-sm-10">
                                {{-- {!! Form::text("estado_civil", $estadoCivil,["class"=>"form-control","id"=>"estado_civil","readonly"=>"readonly"]); !!} --}}

                                {!! Form::select("estado_civil",$estadoCivilSelect,$todo[1]->estado_civil,["class"=>"form-control" ,"id"=>"estado_civil"]) !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">No. Hijos</label>
                            <div class="col-sm-4">
                                {!! Form::number("numero_hijos", $todo[1]->numero_hijos,["class"=>"form-control","id"=>"numero_hijos"]); !!}
                            </div>

                            <div class="col-sm-6">
                                {!! Form::textarea("observacion_hijos", $todo[0]->observacion_hijos,[
                                    "class"=>"form-control",
                                    "id"=>"observacion_hijos",
                                    "rows"=>1,
                                    "placeholder"=>"Observaciones hijos."]); !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Sit mil / Num lib -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="militar_situacion" class="col-sm-12 control-label">Situación militar ?</label>

                            <div class="col-sm-4">
                                @if($todo[1]->numero_libreta != '')
                                    <select name="militar_situacion" class="form-control" id="militar_situacion">
                                        <option value="">Seleccionar</option>
                                        <option value="1" selected>Si</option>
                                        <option value="0">No</option>
                                    </select>
                                @else
                                    <select name="militar_situacion" class="form-control" id="militar_situacion">
                                        <option value="">Seleccionar</option>
                                        <option value="1">Si</option>
                                        <option value="0" selected>No</option>
                                    </select>
                                @endif
                            </div>

                            <div class="col-sm-6">
                                {!! Form::textarea("observacion_libreta", $todo[0]->observacion_libreta,[
                                    "class"=>"form-control",
                                    "id"=>"observacion_libreta",
                                    "rows"=>1,
                                    "placeholder"=>"Observaciones libreta."]); !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("militar_situacion",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_libreta" class="col-sm-12 control-label">Número de Libreta</label>
                            <div class="col-sm-10">
                                {!! Form::number("numero_libreta",$todo[1]->numero_libreta,["class"=>"form-control","id"=>"numero_libreta"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_libreta",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Clase lib. / Cuenta veh. -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="clase_libreta" class="col-sm-12 control-label">Clase libreta</label>

                            <div class="col-sm-10">
                                {!! Form::select("clase_libreta",$claseLibreta,$todo[1]->clase_libreta,["class"=>"form-control","id"=>"clase_libreta"]) !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Cuenta con vehículo automotor</label>

                            <div class="col-sm-10">
                                {!! Form::select("tiene_vehiculo",[""=>"Seleccionar","1"=>"Si","0"=>"No"],$todo[1]->tiene_vehiculo,[
                                    "class"=>"form-control",
                                    "id"=>"tiene_vehiculo"
                                ]) !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Tip veh. / Tiene lic. -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Tipo de vehículo</label>
                            <div class="col-sm-10">
                                {!! Form::select("tipo_vehiculo",$tipoVehiculo,$todo[1]->tipo_vehiculo,["id"=>"tipo_vehiculo","class"=>"form-control"]) !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Tiene licencía</label>
                            <div class="col-sm-10">
                                @if($todo[1]->numero_licencia != '' && $todo[1]->categoria_licencia != '')
                                    Si <input type="radio" name="tiene_licencia" value="1" checked>
                                    No <input type="radio" name="tiene_licencia" value="0">
                                @elseif($todo[1]->numero_licencia == '' && $todo[1]->categoria_licencia == '')
                                    Si <input type="radio" name="tiene_licencia" value="1">
                                    No <input type="radio" name="tiene_licencia" value="0" checked>
                                @else
                                    Si <input type="radio" name="tiene_licencia" value="1">
                                    No <input type="radio" name="tiene_licencia" value="0">
                                @endif
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Num lic. / Cat lic. -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Número de licencía</label>
                            <div class="col-sm-10">
                                {!! Form::number("numero_licencia",$todo[1]->numero_licencia,["class"=>"form-control","id"=>"numero_licencia"]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Categoría de licencía</label>
                            <div class="col-sm-10">
                                {!! Form::select("categoria_licencia",$categoriaLicencias,$todo[1]->categoria_licencia,["class"=>"form-control selectcategory","id"=>"categoria_licencia"])  !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Talla cam. / Talla pan. -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Talla de camisa</label>
                            <div class="col-sm-10">
                                {!! Form::select("talla_camisa",$talla_camisa, $todo[1]->talla_camisa,["class"=>"form-control", "id"=>"talla_zapatos"]) !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Talla de pantalón</label>
                            <div class="col-sm-10">
                                {!! Form::select("talla_pantalon",$talla_pantalon,$todo[1]->talla_pantalon,["class"=>"form-control", "id"=>"talla_zapatos"]) !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Talla Zap. / EPS -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Talla de zapatos</label>
                            <div class="col-sm-10">
                                {!! Form::select("talla_zapatos",$talla_zapatos,$todo[1]->talla_zapatos,["class"=>"form-control", "id"=>"talla_zapatos"]) !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Entidad promotora de salud EPS</label>
                            <div class="col-sm-10">
                                {!! Form::select("entidad_eps",$entidadesEps,$todo[1]->entidad_eps,["class"=>"form-control","id"=>"entidad_eps"]) !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- AFP / Asp. Salarial -->
                    <div class="row">
                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Fondo de pensión AFP</label>
                            <div class="col-sm-10">
                                {!! Form::select("entidad_afp",$entidadesAfp,$todo[1]->entidad_afp,["class"=>"form-control","id"=>"entidad_afp"]) !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                        <div class="col-md-6">
                            <label for="inputEmail3" class="col-sm-12 control-label">Aspiración salarial del candidato</label>
                            <div class="col-sm-10">
                                {!! Form::select("aspiracion_salarial",$aspiracionSalarial,$todo[1]->entidad_eps,["class"=>"form-control" ,"id"=>"aspiracion_salarial"]) !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                    </div>

                    <br>

                    <!-- Observaciones entrevistador -->
                    <div class="row">
                        
                        <div class="col-md-12">
                            <label for="observacion_estudios" class="col-sm-12 control-label">Observaciones del entrevistador (estudios)</label>
                            <div class="col-sm-12">
                                {!! Form::textarea("observacion_estudios", $todo[0]->observacion_estudios,["class"=>"form-control","id"=>"observacion_estudios",
                                    "rows"=>2]); !!}
                            </div>
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>
                        
                    </div>

                </div>

            </div>

            <br>

            <h3><p style="text-align: center;">Experiencia laboral ( iniciar con la experiencia más reciente a la más antigua)</p></h3>

            <hr>

            <!-- Experiencias laborales -->
            <div class="container-fluid">
                <div class="row" id="nueva_experiencia">
                    
                    <div class="col-sm-10">
                        <h4>- Experiencia</h4>
                        <br>
                    </div>

                    <div class="grupos_expe">

                        <!-- Nombre emp / Tel emp -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre_empresa" class="col-sm-12 control-label">Nombre empresa</label>
                                <div class="col-sm-10">
                                    {!! Form::text("nombre_empresa[]",null,["class"=>"form-control","id"=>"nombre_empresa"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_empresa",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="telefono_temporal" class="col-sm-12 control-label">Teléfono empresa</label>
                                <div class="col-sm-10">
                                    {!! Form::number("telefono_temporal[]",null,["class"=>"form-control","id"=>"telefono_temporal"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_temporal",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- City / Cargo desem. -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="ciudad_experiencia_txt" class="col-sm-12 control-label">Ciudad</label>
                                <div class="col-sm-10">
                                    {!! Form::text("ciudad_experiencia_txt[]",null,["class"=>"form-control","id"=>"ciudad_experiencia_txt"]); !!}

                                    <input type="hidden" name="pais_experiencia" id="pais_experiencia" value="">
                                    <input type="hidden" name="departamento_experiencia" id="departamento_experiencia" value="">
                                    <input type="hidden" name="ciudad_experiencia" id="ciudad_experiencia" value="">
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ciudad_experiencia_txt",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="cargo_especifico" class="col-sm-12 control-label">Cargo desempeñado</label>
                                <div class="col-sm-10">
                                    {!! Form::text("cargo_especifico[]",null,["class"=>"form-control","id"=>"cargo_especifico"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_especifico",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- Niv cargo. / Cargo sim. -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nivel_cargo" class="col-sm-12 control-label">Nivel cargo</label>
                                <div class="col-sm-10">
                                    {!! Form::select("nivel_cargo",[""=>"Seleccionar","Operativo"=>"Operativo","Directivo"=>"Directivo","Asesor"=>"Asesor","Profesional"=>"Profesional","Técnico"=>"Técnico","Asistencial"=>"Asistencial"],null,["class"=>"form-control", "id"=>"nivel_cargo"]) !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nivel_cargo",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="cargo_desempenado" class="col-sm-12 control-label">Cargo similar</label>
                                <div class="col-sm-10">
                                    {!! Form::select("cargo_desempenado[]",$cargoGenerico,null,["class"=>"form-control","id"=>"cargo_desempenado"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_desempenado",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- Nom jefe / Cargo jef -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombres_jefe" class="col-sm-12 control-label">Nombres jefe</label>
                                <div class="col-sm-10">
                                    {!! Form::text("nombres_jefe[]",null,["class"=>"form-control","id"=>"nombres_jefe"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres_jefe",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="cargo_jefe" class="col-sm-12 control-label">Cargo jefe</label>
                                <div class="col-sm-10">
                                    {!! Form::text("cargo_jefe[]", null,["class"=>"form-control","id"=>"cargo_jefe"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_jefe",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- Tel jefe / Fecha inicio -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="movil_jefe" class="col-sm-12 control-label">Teléfono movil jefe</label>
                                <div class="col-sm-10">
                                    {!! Form::number("movil_jefe[]",null,["class"=>"form-control","id"=>"movil_jefe"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("movil_jefe",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_inicio_exp" class="col-sm-12 control-label">Fecha inicio</label>
                                <div class="col-sm-10">
                                    {!! Form::date("fecha_inicio_exp[]", null,["class"=>"form-control","id"=>"fecha_inicio_exp"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- Trab actual / Fecha final -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="empleo_actual" class="col-sm-12 control-label">Trabajo actual</label>
                                <div class="col-sm-10">
                                    Si <input type="radio" name="empleo_actual[]" id="empleo_actual" value="1">
                                    No <input type="radio" name="empleo_actual[]" id="empleo_actual" value="0">
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("empleo_actual",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="fecha_final_exp" class="col-sm-12 control-label">Fecha terminación</label>
                                <div class="col-sm-10">
                                    {!! Form::date("fecha_final_exp[]", null,["class"=>"form-control","id"=>"fecha_final_exp"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_final_exp",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <!-- Salario / Mot ret -->
                        <div class="row">
                            <div class="col-md-6">
                                <label for="salario_devengado" class="col-sm-12 control-label">Salario devengado</label>
                                <div class="col-sm-10">
                                    {!! Form::select("salario_devengado[]",$aspiracionSalarial,null,["class"=>"form-control","id"=>"salario_devengado"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("salario_devengado",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="motivo_retiro" class="col-sm-12 control-label">Motivo retiro</label>
                                <div class="col-sm-10">
                                    {!! Form::select("motivo_retiro[]",$motivoRetiro,null,["class"=>"form-control","id"=>"motivo_retiro"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_retiro",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10 boton_aqui_exp">
                                <button type="button" class="btn btn-success pull-right add-expe" title="Agregar grupo">+</button>
                            </div>
                        </div>
                    </div>

                </div>

                <br>

                <div class="row">

                    <table class="table table-bordered tbl_info">
                        @if (count($experiencias) <= 0)
                            <tr>
                                <td>No registra experiencias.</td>
                            </tr>
                        @else
                            @foreach ($experiencias as $experiencia)
                                <tr>
                                    <th>Empresa</th>
                                    <th>Teléfono empresa</th>
                                    <th>Nombre Jefe</th>
                                    <th>Teléfono movil</th>
                                    <th>Cargo</th>
                                    <th>Fecha ingreso</th>
                                    <th>Fecha salida</th>
                                </tr>

                                <tr>
                                    <td>{{ $experiencia->nombre_empresa }}</td>
                                    <td>{{ $experiencia->telefono_temporal }}</td>
                                    <td>{{ $experiencia->nombres_jefe }}</td>
                                    <td>{{ $experiencia->movil_jefe }}</td>                                    
                                    <td>{{ $experiencia->cargo_especifico }}</td>
                                    <td>{{ $experiencia->fecha_inicio }}</td>
                                    <td>{{ $experiencia->fecha_final }}</td>
                                </tr>

                                <tr>
                                    <th colspan="2">Salario</th>
                                    <th>M. Retiro</th>
                                    <th colspan="4">F. Principales</th>
                                </tr>

                                <tr>
                                    <td colspan="2">{{ $experiencia->salario_cand }}</td>
                                    <td>{{ $experiencia->motivo_retiro_cand }}</td>
                                    <td colspan="4">
                                        @if ($experiencia->funciones_logros != '')
                                            {{ $experiencia->funciones_logros }}
                                        @else
                                            <i>El candidato no ingreso datos.</i>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="10">
                                        <div class="col-sm-12" style="padding-right: 0; padding-left: 0;">
                                            {!! Form::textarea("observacion_experiencia_one[]", $experiencia->observacion_experiencia,[
                                                "class" => "form-control",
                                                "id" => "observacion_experiencia_one",
                                                "placeholder" => "Observación de experiencia",
                                                "rows" => 2]); !!}
                                            {!! Form::hidden("id_experiencia[]", $experiencia->id,["class" => "form-control","id" => "id_experiencia",]) !!}
                                        </div>

                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observacion_experiencia_one",$errors) !!}</p>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </table>

                    <!-- Observaciones entrevistador -->
                    <div class="row">
                        
                        <div class="col-md-12">
                            <label for="cargo" class="col-sm-12 control-label">Observaciones del entrevistador (Experiencias)</label>
                            <div class="col-sm-12">
                                {!! Form::textarea("observacion_experiencia", $todo[0]->observacion_experiencia,["class"=>"form-control","id"=>"observacion_experiencia",
                                    "rows"=>2]); !!}
                            </div>  
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                        </div>

                    </div>
                </div>

            </div>

            <h3><p style="text-align: center;">Preguntas de validación</p></h3>

            <hr>

            <!-- Preguntas -->
            <div class="container-fluid">
                <div class="row">
                    <div class="row">

                        <!-- Pregunta #1 -->
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="cargo" class="col-sm-12 control-label">¿ Cuál ha sido su mayor logro ?</label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("pregunta_validacion_1", $todo[0]->pregunta_validacion_1,["class"=>"form-control","id"=>"pregunta_validacion_1","rows"=>1]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                            
                        </div>

                        <br>

                        <!-- Pregunta #2 -->
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="cargo" class="col-sm-12 control-label">¿ Qué lo motiva a trabajar ?</label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("pregunta_validacion_2", $todo[0]->pregunta_validacion_2,["class"=>"form-control","id"=>"pregunta_validacion_2","rows"=>1]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                            
                        </div>

                        <br>

                        <!-- Pregunta #3 -->
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="cargo" class="col-sm-12 control-label">¿ Cuáles son sus metas ?</label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("pregunta_validacion_3", $todo[0]->pregunta_validacion_3,["class"=>"form-control","id"=>"pregunta_validacion_3","rows"=>1]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                            
                        </div>

                        <br>

                        <!-- Pregunta #4 -->
                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="cargo" class="col-sm-12 control-label">¿ Qué actividades hace en su tiempo libre ?</label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("pregunta_validacion_4", $todo[0]->pregunta_validacion_4,["class"=>"form-control","id"=>"pregunta_validacion_4","rows"=>1]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                            
                        </div>

                        <br>

                        <!-- Pregunta #5 - 6 -->
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <label for="cargo" class="control-label">¿ Tiene tatuajes ?</label>

                                    @if($todo[0]->pregunta_validacion_5 == 1)
                                        Si <input type="radio" name="pregunta_validacion_5" value="1" checked>
                                        No <input type="radio" name="pregunta_validacion_5" value="0">
                                    @elseif($todo[0]->pregunta_validacion_5 !== null && $todo[0]->pregunta_validacion_5 == 0)
                                        Si <input type="radio" name="pregunta_validacion_5" value="1">
                                        No <input type="radio" name="pregunta_validacion_5" value="0" checked>
                                    @elseif($todo[0]->pregunta_validacion_5 == null)
                                        Si <input type="radio" name="pregunta_validacion_5" value="1">
                                        No <input type="radio" name="pregunta_validacion_5" value="0">
                                    @endif
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <label for="cargo" class="control-label">¿ Tiene o necesita gafas ?</label>

                                    @if ($todo[0]->pregunta_validacion_6 == 1)
                                        Si <input type="radio" name="pregunta_validacion_6" value="1" checked>
                                        No <input type="radio" name="pregunta_validacion_6" value="0">
                                    @elseif($todo[0]->pregunta_validacion_6 !== null && $todo[0]->pregunta_validacion_6 == 0)
                                        Si <input type="radio" name="pregunta_validacion_6" value="1">
                                        No <input type="radio" name="pregunta_validacion_6" value="0" checked>
                                    @elseif($todo[0]->pregunta_validacion_6 == null)
                                        Si <input type="radio" name="pregunta_validacion_6" value="1">
                                        No <input type="radio" name="pregunta_validacion_6" value="0">
                                    @endif
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                            
                        </div>

                        <br>

                        <!-- Pregunta #7 - 8 -->
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <label for="cargo" class="control-label">¿ Disponibilidad para viajar ?</label>

                                    @if ($todo[0]->pregunta_validacion_7 == 1)
                                        Si <input type="radio" name="pregunta_validacion_7" value="1" checked>
                                        No <input type="radio" name="pregunta_validacion_7" value="0">
                                    @elseif($todo[0]->pregunta_validacion_7 !== null && $todo[0]->pregunta_validacion_7 == 0)
                                        Si <input type="radio" name="pregunta_validacion_7" value="1">
                                        No <input type="radio" name="pregunta_validacion_7" value="0" checked>
                                    @elseif($todo[0]->pregunta_validacion_7 == null)
                                        Si <input type="radio" name="pregunta_validacion_7" value="1">
                                        No <input type="radio" name="pregunta_validacion_7" value="0">
                                    @endif
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <label for="pregunta_validacion_8" class="control-label">¿ Multas o comparendos ?</label>

                                    @if ($todo[0]->pregunta_validacion_8 == 1)
                                        Si <input type="radio" name="pregunta_validacion_8" value="1" checked>
                                        No <input type="radio" name="pregunta_validacion_8" value="0">
                                    @elseif($todo[0]->pregunta_validacion_8 !== null && $todo[0]->pregunta_validacion_8 == 0)
                                        Si <input type="radio" name="pregunta_validacion_8" value="1">
                                        No <input type="radio" name="pregunta_validacion_8" value="0" checked>
                                    @elseif($todo[0]->pregunta_validacion_8 == null)
                                        Si <input type="radio" name="pregunta_validacion_8" value="1">
                                        No <input type="radio" name="pregunta_validacion_8" value="0">
                                    @endif
                                </div>
                                
                                <br><br>

                                @if ($todo[0]->pregunta_validacion_8 == 1)
                                    <label for="valor_multa" class="col-sm-8 control-label" id="campo_valor" style="display: block;">
                                        Valor
                                        {!! Form::number("valor_multa",$todo[0]->valor_multa,["class"=>"form-control","id"=>"valor_multa"]); !!}
                                    </label>
                                @elseif($todo[0]->pregunta_validacion_8 == 0)
                                    <label for="valor_multa" class="col-sm-8 control-label" id="campo_valor">
                                        Valor
                                        {!! Form::number("valor_multa",null,["class"=>"form-control","id"=>"valor_multa"]); !!}
                                    </label>
                                @endif
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                            
                        </div>

                        <!-- Pregunta #9 - 10 -->
                        <div class="row">
                            
                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <label for="pregunta_validacion_9" class="control-label">¿ Reportes en datacredito o centrales de riesgo ?</label>

                                    @if ($todo[0]->pregunta_validacion_9 == 1)
                                        Si <input type="radio" name="pregunta_validacion_9" value="1" checked>
                                        No <input type="radio" name="pregunta_validacion_9" value="0">
                                    @elseif($todo[0]->pregunta_validacion_9 !== null && $todo[0]->pregunta_validacion_9 == 0)
                                        Si <input type="radio" name="pregunta_validacion_9" value="1">
                                        No <input type="radio" name="pregunta_validacion_9" value="0" checked>
                                    @elseif($todo[0]->pregunta_validacion_9 == null)
                                        Si <input type="radio" name="pregunta_validacion_9" value="1">
                                        No <input type="radio" name="pregunta_validacion_9" value="0">
                                    @endif
                                </div>

                                <br><br>

                                @if ($todo[0]->pregunta_validacion_9 == 1)
                                    <label for="valor_reporte" class="col-sm-8 control-label" id="campo_reporte" style="display: block;">
                                        Valor
                                        {!! Form::number("valor_reporte",$todo[0]->valor_reporte,["class"=>"form-control","id"=>"valor_reporte"]); !!}
                                    </label>
                                @elseif($todo[0]->pregunta_validacion_9 == 0)
                                    <label for="valor_multa" class="col-sm-8 control-label" id="campo_reporte">
                                        Valor
                                        {!! Form::number("valor_multa",null,["class"=>"form-control","id"=>"valor_multa"]); !!}
                                    </label>
                                @endif
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <div class="col-sm-12">
                                    <label for="pregunta_validacion_10" class="control-label">¿ Ya trabajó en Nases ?</label>

                                    @if ($todo[0]->pregunta_validacion_10 == 1)
                                        Si <input type="radio" name="pregunta_validacion_10" value="1" checked>
                                        No <input type="radio" name="pregunta_validacion_10" value="0">
                                    @elseif($todo[0]->pregunta_validacion_10 !== null && $todo[0]->pregunta_validacion_10 == 0)
                                        Si <input type="radio" name="pregunta_validacion_10" value="1">
                                        No <input type="radio" name="pregunta_validacion_10" value="0" checked>
                                    @elseif($todo[0]->pregunta_validacion_10 == null)
                                        Si <input type="radio" name="pregunta_validacion_10" value="1">
                                        No <input type="radio" name="pregunta_validacion_10" value="0">
                                    @endif
                                </div>
                                
                                <br><br>

                                @if ($todo[0]->pregunta_validacion_10 == 1)
                                    <label for="empresa_trabajo" class="col-sm-8 control-label" id="campo_empresa_trabajo" style="display: block;">
                                        ¿ Para qué empresa ?
                                        {!! Form::text("empresa_trabajo",$todo[0]->empresa_trabajo,["class"=>"form-control","id"=>"empresa_trabajo"]); !!}
                                    </label>
                                @elseif($todo[0]->pregunta_validacion_10 == 0)
                                    <label for="empresa_trabajo" class="col-sm-8 control-label" id="campo_empresa_trabajo">
                                        ¿ Para qué empresa ?
                                        {!! Form::text("empresa_trabajo",null,["class"=>"form-control","id"=>"empresa_trabajo"]); !!}
                                    </label>
                                @endif
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                            
                        </div>

                        <br>

                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-10">
                                <p style="text-align: center;">
                                    Manifiesto que autorizo libre, expresa y conscientemente, a <strong>NASES</strong> para que administre, maneje y haga uso de mis datos personales que proporciono desde el inicio del proceso de selección como candidato para los fines relacionados, bajo los criterios establecidos en la Ley 1581 de 2012, el Decreto Reglamentario 1377 de 2013 y demás normas que regulen el tema. La anterior manifestación no afecta mis derechos relacionados en la Ley 1581 de 2012, ya que como titular de la información personal, he decidido dar autorización expresa para el uso de mis datos personales.
                                </p>
                            </div>
                            <div class="col-md-1"></div>

                            <div class="col-sm-12" style="text-align: center;">
                                @if ($todo[0]->autorizacion == 1)
                                    Si <input type="radio" name="autorizacion" value="1" checked>
                                    No <input type="radio" name="autorizacion" value="0">
                                @elseif($todo[0]->autorizacion == 0)
                                    Si <input type="radio" name="autorizacion" value="1">
                                    No <input type="radio" name="autorizacion" value="0" checked>
                                @endif
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            
                            <div class="col-md-12">
                                <label for="cargo" class="col-sm-12 control-label">Observaciones del entrevistador</label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("observacion_preguntas", $todo[0]->observacion_preguntas,["class"=>"form-control","id"=>"observacion_preguntas",
                                        "rows"=>2]); !!}
                                </div>  
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>

            <h3><p style="text-align: center;">Concepto final (espacio esclusivo del entrevistador)</p></h3>

            <hr>            

            <!-- Preguntas de apto -->
            <div class="container-fluid">
                <div class="row">

                    <table class="table table-bordered tbl_info">
                        <tr>
                            <th>Requerimiento</th>
                            <th colspan="2">Si / No</th>
                        </tr>

                        <tr>
                            <td>
                                <p>¿ El candidato posee las competencias para ejercer el cargo ?</p>
                            </td>
                            @if ($todo[0]->concepto_final_preg_1 == 1)
                                <td>
                                    Si <input type="radio" name="concepto_final_preg_1" value="1" checked>
                                </td>
                                <td>
                                    No <input type="radio" name="concepto_final_preg_1" value="0">
                                </td>
                            @elseif($todo[0]->concepto_final_preg_1 == 0)
                                <td>
                                    Si <input type="radio" name="concepto_final_preg_1" value="1">
                                </td>
                                <td>
                                    No <input type="radio" name="concepto_final_preg_1" value="0" checked>
                                </td>
                            @endif
                        </tr>

                        <tr>
                            <td>
                                <p>¿ El candidato cuenta con la experiencia necesaria ?</p>
                            </td>
                            @if ($todo[0]->concepto_final_preg_2 == 1)
                                <td>
                                    Si <input type="radio" name="concepto_final_preg_2" value="1" checked>
                                </td>
                                <td>
                                    No <input type="radio" name="concepto_final_preg_2" value="0">
                                </td>
                            @elseif($todo[0]->concepto_final_preg_2 == 0)
                                <td>
                                    Si <input type="radio" name="concepto_final_preg_2" value="1">
                                </td>
                                <td>
                                    No <input type="radio" name="concepto_final_preg_2" value="0" checked>
                                </td>
                            @endif
                        </tr>

                        <tr>
                            <td>
                                <p>¿ El candidato cuenta con algún tipo de reporte o restricción que le impida ejercer el cargo ?</p>
                            </td>
                            @if ($todo[0]->concepto_final_preg_3 == 1)
                                <td>
                                    Si <input type="radio" name="concepto_final_preg_3" value="1" checked>
                                </td>
                                <td>
                                    No <input type="radio" name="concepto_final_preg_3" value="0">
                                </td>
                            @elseif($todo[0]->concepto_final_preg_3 == 0)
                                <td>
                                    Si <input type="radio" name="concepto_final_preg_3" value="1">
                                </td>
                                <td>
                                    No <input type="radio" name="concepto_final_preg_3" value="0" checked>
                                </td>
                            @endif
                        </tr>
                    
                    </table>

                    <div class="row">

                        <div class="row">
                            <div class="col-md-12">
                                <label for="concepto_final" class="col-sm-12 control-label">Concepto</label>
                                <div class="col-sm-12">
                                    {!! Form::textarea("concepto_final", $todo[0]->concepto_final,["class"=>"form-control","id"=>"concepto_final",
                                        "rows"=>2]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("concepto_final",$errors) !!}</p>
                            </div>
                        </div>

                        <br>

                        <div class="col-sm-12">
                            <label for="apto" class="control-label">¿ El candidato es apto para el cargo ?</label>

                            @if ($todo[0]->apto == 1)
                                Si <input type="radio" name="apto" value="1" checked>
                                No <input type="radio" name="apto" value="0">
                            @elseif($todo[0]->apto == 0)
                                Si <input type="radio" name="apto" value="1">
                                No <input type="radio" name="apto" value="0" checked>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        {!! Form::close() !!}

    @else

        {{--NO ES KOMATSU--}}
        {!! Form::model($entrevista,["id"=>"fr_entrevista_semi"]) !!}
            
            {!! Form::hidden("ref_id") !!}
            {!! Form::hidden("id",$entrevista->id,["id"=>"id_entrevista"]) !!}
            {!! Form::hidden("candidato_id") !!}
            
            <h3><p style="text-align: center;">Información del  cliente</p></h3>

            <hr>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
            
                        <label for="inputEmail3" class="col-sm-2 control-label"> Cliente</label>
                        <div class="col-sm-10">
                            {!! Form::text("cliente",$proceso->nombre,["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                    </div>

                    <div class="col-md-6">
                        <label for="inputEmail3" class="col-sm-4 control-label"> N° Req</label>
                        <div class="col-sm-3">
                            {!! Form::text("reff_id",$proceso->requerimiento_id,["class"=>"form-control","id"=>"reff_id","readonly"=>"readonly"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                    </div>
                </div>
                
                <br>

                <div class="row">
                    <div class="col-md-6">
                        <label for="inputEmail3" class="col-sm-2 control-label"> Cargo</label>
                        <div class="col-sm-10">
                            {!! Form::text("cargo",$proceso->descripcion,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                    </div>

                    <div class="col-md-6"></div>
                </div>
            </div>


            <h3><p style="text-align: center;">Información del  candidato</p></h3>
            
            <hr>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputEmail3" class="col-sm-4 control-label"> Cédula</label>
                                <div class="col-sm-5">
                                    {!! Form::text("numero_id",$proceso->numero_id,["class"=>"form-control","id"=>"numero_id","readonly"=>"readonly"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="inputEmail3" class="col-sm-3 control-label">N° Celular</label>
                                <div class="col-sm-4">
                                    {!! Form::text("telefono",$proceso->telefono_movil,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                        </div>
                        
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputEmail3" class="col-sm-4 control-label"> Fecha de Nacimiento</label>
                                <div class="col-sm-5">
                                    {!! Form::text("fecha_nacimiento",$proceso->fecha_nacimiento,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>

                            <div class="col-md-6">
                                <label for="inputEmail3" class="col-sm-3 control-label"> Edad</label>
                                <div class="col-sm-3">
                                  {!! Form::text("edad",$proceso->edad,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                        </div>
                        
                        <br>

                        <div class="row">
                            <div class="col-md-6">
                                <label for="inputEmail3" class="col-sm-4 control-label">Dirección</label>
                                <div class="col-sm-5">
                                    {!! Form::text("edad",$proceso->direccion,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                
                            <div class="col-md-6">
                                <label for="inputEmail3" class="col-sm-3 control-label"> Nombres y apellidos</label>
                                <div class="col-sm-7">
                                    {!! Form::text("cliente",$proceso->nombres." ".$proceso->primer_apellido ,["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                                </div>
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                            </div>
                        </div>
                        
                        <br>
            
                        @if($estudios->count()>0)
                            <div class="row">
                                <div class="col-md-12">
                                    <h3><p style="text-align: center;">Información Académica</p></h3>
                                    
                                    <hr>

                                    @foreach($estudios as $estudio)
                                        
                                        <br><br>
                                        
                                        <div class="col-md-6">
                                            <label for="inputEmail3" class="col-sm-4 control-label">Institucion</label>
                                            <div class="col-sm-8">
                                                {!! Form::text("institucion",$estudio->institucion,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                            </div>
                                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                        </div>

                                        <div class="col-md-6">
                                            <label for="inputEmail3" class="col-sm-3 control-label">Titulo Obtenido</label>
                                            <div class="col-sm-9">
                                                {!! Form::text("titulo",$estudio->titulo_obtenido,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                            </div>
                                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                        </div>

                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($experiencias->count()>0)
                <h3><p style="text-align: center;">Información Laboral</p></h3>
   
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            @foreach($experiencias as $experiencia)
                                <hr>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> Empresa</label>
                                        <div class="col-sm-7">
                                            {!! Form::text("empresa",$experiencia->nombre_empresa,["class"=>"form-control","id"=>"empresa","readonly"=>"readonly"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-3 control-label"> Fecha ingreso</label>
                                        <div class="col-sm-7">
                                            {!! Form::text("cliente",$experiencia->fecha_inicio ,["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                    </div>
                                </div>
                                
                                <br>

                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> Fecha retiro</label>
                                        <div class="col-sm-7">
                                            {!! Form::text("fecha_reriro",$experiencia->fecha_final,["class"=>"form-control","id"=>"fecha_reriro","readonly"=>"readonly"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <?php
                                          
                                          $fecha1 = $experiencia->fecha_inicio;
                                          $fecha_i = new DateTime($fecha1);
                                          
                                          $fecha2 = $experiencia->fecha_final;
                                          $fecha_f = new DateTime($fecha2);
                                          $fecha_hoy = $fecha_i->diff($fecha_f);

                                        ?>

                                        <label for="inputEmail3" class="col-sm-3 control-label"> Tiempo total</label>
                                        
                                        <div class="col-sm-7">
                                            @if($experiencia->fecha_final != "0000-00-00")
                                                @if ($fecha_hoy->y <= 0)
                                                    {!! Form::text("cliente",$fecha_hoy->m." Meses",["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                                                @else
                                                    {!! Form::text("cliente",$fecha_hoy->y. " Años ".$fecha_hoy->m." Meses",["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                                                @endif
                                        </div>
                                            @else
                                                {!! Form::text("cliente",$trabajo,["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                                            @endif
                                    </div>
                                </div>
                                
                                <br>
            
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-4 control-label"> Cargo desempeñado</label>
                                        <div class="col-sm-7">
                                            {!! Form::text("cargo_desem",$experiencia->desc_cargo,["class"=>"form-control","id"=>"cargo_desem","readonly"=>"readonly"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="inputEmail3" class="col-sm-3 control-label"> Motivo Retiro</label>
                                        <div class="col-sm-7">
                                            {!! Form::text("cliente",$experiencia->desc_motivo ,["class"=>"form-control","id"=>"cliente","readonly"=>"readonly"]); !!}
                                        </div>
                                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                    </div>               
                                </div>
                                
                                <br>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            @if($familiares->count()>0)
                <br>
                
                <h3><p style="text-align: center;">Información y dinámica familiar</p></h3>
                    
                <hr>

                <h4><p style="text-align: left;">Esposo(a) o Compañero(a)</p></h4>
    
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                        
                            @foreach($familiares as $familia)
                                <br><br>
                                <div class="col-md-6">
                                    <label for="inputEmail3" class="col-sm-4 control-label">Nombres y apellidos </label>
                                    <div class="col-sm-8">
                                        {!! Form::text("estado_civil",$familia->nombres." ".$familia->primer_apellido." ".$familia->segundo_apellido,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                    </div>
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                </div>

                                <div class="col-md-6">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Ocupación</label>
                                    <div class="col-sm-9">
                                        {!! Form::text("titulo",$familia->profesion,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                    </div>
                                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                </div>
                            @endforeach

                            <br><br>

                            @if($hijos->count()>0)
                                <br>
                                
                                <h4><p style="text-align: left;">Hijo(a)</p></h4>
                                
                                <hr>
                                
                                @foreach($hijos as $hijo)
                                    <div class="container-fluid">
                                        <div class="row">
                                            <br>
                                            <div class="col-md-6">
                                               <label for="inputEmail3" class="col-sm-4 control-label">Nombre</label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("estado_civil",$hijo->nombres." ".$hijo->primer_apellido,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                                </div>
                                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                            </div>

                                            <div class="col-md-6">
                                                <label for="inputEmail3" class="col-sm-3 control-label"> Edad</label>
                                                <div class="col-sm-3">
                                                    {!! Form::text("edad",$hijo->edad,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                                </div>
                                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                            </div>

                                            <hr>

                                            <div class="col-md-6">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Escolaridad </label>
                                                <div class="col-sm-8">
                                                    {!! Form::text("escolaridad",$hijo->escolaridad,["class"=>"form-control","id"=>"cargo","readonly"=>"readonly"]); !!}
                                                </div>
                                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            
            <br>

            <h3 style="text-align:center;" >Evaluación APA</h3>
                
            <table class="table table-bordered tbl_info">
                <thead>
                    <tr>
                        <th>Nombre Evaluación</th>
                        <th style="width:40%; text-align: center;">Descripción</th>
                        <th>Sin Evaluar</th>
                        <th style="width:30px">Inferior requerido</th>
                        <th style="width:10px">Acorde requerido</th>
                        <th style="width:10px">Superior requerido</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>PRESENTACIÓN PERSONAL </td>
                        <td width="50">Vestimenta, aseo y apariencia personal</td>
                        <td width="10">{!!  Form::radio("competencia[1]",1,true) !!}</td>
                        <td>{!!  Form::radio("competencia[1]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[1]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[1]",4) !!}</td>
                    </tr>
                    <tr>
                        <tr>
                            <td>DESENVOLVIMIENTO</td>
                        </tr>
                        <td>COMPORTAMIENTO VERBAL</td>
                        <td width="20">Vocabulario empleado, fluidéz verbal, hilación y coherencias en las ideas.</td>
                        <td width="10">{!!  Form::radio("competencia[2]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[2]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[2]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[2]",4) !!}</td>
                    </tr>
                    <tr>
                        <td>COMPORTAMIENTO NO VERBAL</td>
                        <td>Contacto visual, gestos, movimientos de las manos y disposición corporal.</td>
                        <td width="10">{!!  Form::radio("competencia[3]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[3]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[3]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[3]",4) !!}</td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    <tr>
                        <td>AUTOESTIMA</td>
                        <td>Auto-estima, auto concepto, auto eficacia y auto imagen.</td>
                        <td width="10">{!!  Form::radio("competencia[4]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[4]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[4]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[4]",4) !!}</td>
                    </tr>
                    <tr>
                        <td>PROYECCIÓN</td>
                        <td>Establecimiento de sus metas personales, laborales, académicas, compartamientos proactivos.</td>
                        <td width="10">{!!  Form::radio("competencia[5]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[5]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[5]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[5]",4) !!}</td>
                    </tr>
                    <tr>
                        <td>HABILIDAD DE AFRONTAMIENTO</td>
                        <td>Capacidad para adaptarse a nuevas situaciones, empleo de fortalezas, académicas,  comportamientos proactivos para resolución de conflictos y facilidad en la toma de decisiones.</td>
                        <td width="10">{!!  Form::radio("competencia[6]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[6]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[6]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[6]",4) !!}</td>
                    </tr>
                    <tr>
                        <td>HABILIDADES SOCIALES</td>
                        <td>Empatía, amabilidad, iniciativa y facilidad  en la interacción.</td>
                        <td width="10">{!!  Form::radio("competencia[7]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[7]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[7]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[7]",4) !!}</td>
                    </tr>
                    <tr>
                        <td>MOTIVACIÓN</td>
                        <td>Interés por el cargo, interés en la organización  y dinamismo.</td>
                        <td width="10">{!!  Form::radio("competencia[8]",1) !!}</td>
                        <td>{!!  Form::radio("competencia[8]",2) !!}</td>
                        <td>{!!  Form::radio("competencia[8]",3) !!}</td>
                        <td>{!!  Form::radio("competencia[8]",4) !!}</td>
                    </tr>
                    
                    @foreach($competencias as $competencia )
                        <tr>
                            <td>{{$competencia->nombre}}</td>
                            <td width="10">{!!  Form::radio("competencia[".$competencia->competencia_entrevista_id."]",1) !!}</td>
                            <td width="10">{!!  Form::radio("competencia[".$competencia->competencia_entrevista_id."]",2) !!}</td>
                            <td>{!!  Form::radio("competencia[".$competencia->competencia_entrevista_id."]",3) !!}</td>
                            <td>{!!  Form::radio("competencia[".$competencia->competencia_entrevista_id."]",4) !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h3><p style="text-align: center;">Información estado de salud</p></h3>
                
            <hr>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">

                        <label for="inputEmail3" class="col-sm-4 control-label"> ¿Ha tenido alguna enfermedad?</label>

                        <div class="col-sm-12">
                            {!! Form::textarea("enfermedades",$entrevista->enfermedades,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_salud",$errors) !!}</p></div>
                        </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                    
                    <label for="inputEmail3" class="col-sm-4 control-label">¿Le han practicado  alguna cirugía?</label>
                    <div class="col-sm-12">
                        {!! Form::textarea("cirugias",$entrevista->cirugia,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_salud",$errors) !!}</p></div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-12">
                    
                    <label for="inputEmail3" class="col-sm-4 control-label"> ¿ Posee alergias, fobias o consume algún medicamento u otros?</label>
                    <div class="col-sm-12">
                        {!! Form::textarea("alergias",$entrevista->alergias,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                         <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_salud",$errors) !!}</p></div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <h3>Información Sociocultural</h3>
                        
                        <br>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="trabajo-empresa-temporal" class="col-md-6 control-label">¿Realiza alguna actividad o pertenece a algún grupo social , deportivo o cultural?</label>
                                <div class="col-md-6">
                                    {!! Form::checkbox("grupo_social",1,$entrevista->grupo_social,["class"=>"checkbox-preferencias si_no"]) !!}

                                </div>
                            </div>
                            
                        </div>

                        <div class="col-md-6">       
                            <label for="inputEmail3" class="col-sm-2 control-label"> ¿Cúal?</label>
                            <div class="col-sm-8">
                                {!! Form::text("descrip_social",$entrevista->descrip_social,["class"=>"form-control"]); !!}
                                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_salud",$errors) !!}</p></div>
                        </div>
                    </div>
                </div>
            </div>
   
            <br><br>

            <h3><p style="text-align: center;">Especificaciones para el cargo</p></h3>
            
            <hr>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                    
                    <label for="inputEmail3" class="col-sm-4 control-label"> Fortalezas</label>
                    <div class="col-sm-12">
                        {!! Form::textarea("fortalezas",$entrevista->fortalezas,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("especificaciones_cargo",$errors) !!}</p></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    
                    <label for="inputEmail3" class="col-sm-4 control-label"> Oportunidades de mejora</label>
                    <div class="col-sm-12">
                        {!! Form::textarea("opor_mejora",$entrevista->opor_mejora,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("especificaciones_cargo",$errors) !!}</p></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    
                    <label for="inputEmail3" class="col-sm-4 control-label"> Proyectos y/o expectativas</label>
                    <div class="col-sm-12">
                        {!! Form::textarea("proyectos",$entrevista->proyectos,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("especificaciones_cargo",$errors) !!}</p></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    
                    <label for="inputEmail3" class="col-sm-4 control-label"> Valores y/o compromisos</label>
                    <div class="col-sm-12">
                        {!! Form::textarea("valores",$entrevista->valores,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("especificaciones_cargo",$errors) !!}</p></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                    
                    <label for="inputEmail3" class="col-sm-4 control-label"> ¿Por qué el candidato es idóneo para el cargo?</label>
                    <div class="col-sm-12">
                        {!! Form::textarea("candidato_idoneo",$entrevista->candidato_idoneo,["class"=>"form-control","id"=>"textarea","rows"=>"1"]); !!}
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("especificaciones_cargo",$errors) !!}</p></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3><p style="text-align: center;">Otros trabajos</p></h3>
                        <hr>
                        <div class="col-sm-12">
                            {!! Form::textarea("otros_trabajos",$entrevista->otros_trabajos,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("especificaciones_cargo",$errors) !!}</p></div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h3><p style="text-align: center;">Concepto de la entrevista</p></h3>
                        <hr>
                        <div class="col-sm-12">
                            {!! Form::textarea("concepto_entre",$entrevista->concepto_entre,["class"=>"form-control","id"=>"textarea","rows"=>"3"]); !!}
                        </div>
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("especificaciones_cargo",$errors) !!}</p></div>
                </div>
            </div>

            <br>

            <div class="clearfix"></div>

            <div class="col-md-12">

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="trabajo-empresa-temporal" class="col-md-2 control-label">Apto:</label>
                        <div class="col-md-7">
                            {!! Form::checkbox("apto",1,$entrevista->apto,["class"=>"checkbox-preferencias" ]) !!}
                        </div>
                    </div>

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="trabajo-empresa-temporal" class="col-md-4 control-label">Aplazado:</label>
                        <div class="col-md-7">
                            {!! Form::checkbox("aplazado",1,$entrevista->aplazado,["class"=>"checkbox-preferencias si_no" ]) !!}
                        </div>
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                      <label for="trabajo-empresa-temporal" class="col-md-4 control-label">Pendiente:</label>
                        <div class="col-md-7">
                         {!! Form::checkbox("pendiente",1,$entrevista->pendiente,["class"=>"checkbox-preferencias si_no" ]) !!}
                        </div>
                    </div>
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
                </div>
             
            </div>
   
            <div class="clearfix"></div>
        {!! Form::close() !!}

    @endif
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success actualizar_entrevista">Actualizar</button>
</div>

<script>
    $(function(){

        @if (route('home') == "https://demo.t3rsc.co" || route('home') == "http://demo.t3rsc.co" || route('home') == "http://localhost:8000" || route('home') == "https://nases.t3rsc.co" || route('home') == "http://nases.t3rsc.co")
            
            $('input[type=radio][name=pregunta_validacion_8]').change(function() {
                if (this.value == 1) {
                    $('#campo_valor').show('slow');
                }
                else if (this.value == 0) {
                    $('#campo_valor').hide('slow');
                    document.getElementById('campo_valor').value = '';
                }
            });

            $('input[type=radio][name=pregunta_validacion_9]').change(function() {
                if (this.value == 1) {
                    $('#campo_reporte').show('slow');
                }
                else if (this.value == 0) {
                    $('#campo_reporte').hide('slow');
                    document.getElementById('campo_reporte').value = '';
                }
            });

            $('input[type=radio][name=pregunta_validacion_10]').change(function() {
                if (this.value == 1) {
                    $('#campo_empresa_trabajo').show('slow');
                }
                else if (this.value == 0) {
                    $('#campo_empresa_trabajo').hide('slow');
                    document.getElementById('campo_empresa_trabajo').value = '';
                }
            });

            $('#ciudad_nacimiento_txt').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_nacimiento").val(suggestion.cod_pais);
                    $("#departamento_nacimiento").val(suggestion.cod_departamento);
                    $("#ciudad_nacimiento").val(suggestion.cod_ciudad);
                }
            });

            $('#ciudad_residencia_txt').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_residencia").val(suggestion.cod_pais);
                    $("#departamento_residencia").val(suggestion.cod_departamento);
                    $("#ciudad_residencia").val(suggestion.cod_ciudad);
                }
            });

            $('#ciudad_experiencia_txt').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_experiencia").val(suggestion.cod_pais);
                    $("#ciudad_experiencia").val(suggestion.cod_departamento);
                    $("#departamento_experiencia").val(suggestion.cod_ciudad);
                }
            });

            $(document).on('click', '.add-person', function (e) {
                fila_person = $(this).parents('#nuevo_familiar').find('.grupos_fams').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('.boton_aqui').append('<button type="button" class="btn btn-danger pull-right rem-person" title="Remover grupo">-</button>');

                $('#nuevo_familiar').append(fila_person);
            });

            $(document).on('click', '.rem-person', function (e) {
                $(this).parents('.grupos_fams').remove();
            });

            $(document).on('click', '.add-expe', function (e) {
                fila_person = $(this).parents('#nueva_experiencia').find('.grupos_expe').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('.boton_aqui_exp').append('<button type="button" class="btn btn-danger pull-right rem-expe" title="Remover grupo">-</button>');

                $('#nueva_experiencia').append(fila_person);
            });

            $(document).on('click', '.rem-expe', function (e) {
                $(this).parents('.grupos_expe').remove();
            });    
        @endif

        //  $('.checkbox-preferencias').bootstrapSwitch();
        $(".actualizar_entrevista").on("click", function () {
            
            id = $("#id_entrevista").val();
            if(id){
                $.ajax({
                  type: "POST",
                  data: $("#fr_entrevista_semi").serialize(),
                  url: "{{ route('admin.actualizar_entrevista_semi') }}",
                    success: function (response) {
                        mensaje_success("Entrevista actualizada");
                        location.reload();
                    }
                });
            }else{
                mensaje_danger("Problemas al actualizar la entrevista, intentar nuevamente.");
            }
            
        });
    });
</script>