@if(route('home')=="https://komatsu.t3rsc.co")
        <div class="col-md-6">
              @if(isset($cargo_generico_id))
              {!! Form::hidden("cargo_generico_id",$cargo_generico_id,["id"=>"cargo_generico_id"]); !!} 
              @endif
              {!! Form::hidden('ctra_x_clt_codigo',$ctra_x_clt_codigo,["id"=>"ctra_x_clt_codigo"]); !!}
              {!! Form::hidden("ctra_x_clt_codigo",$centro_trabajo->id,["class"=>"form-control","id"=>"ctra_x_clt_codigo"]); !!}
        </div>
        <div class="col-md-6">       
                {!! Form::hidden("centro_costo_produccion",1)!!} 
        </div>


    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Jornada Laboral <span>*</span></label>
            <div class="col-sm-8">
                {!! Form::select("tipo_jornadas_id",$tipo_jornada,["class"=>"form-control","id"=>"tipo_jornadas_id"]); !!}
            </div>
        </div>

        @if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co")
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Tipo Contrato<span>*</span></label>
                <div class="col-sm-8">
                    {!! Form::select("tipo_contrato_id",$tipo_contrato,"",["class"=>"form-control","id"=>"tipo_contrato_id","required"]); !!}
                </div>
            </div>
        @else
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Tipo Contrato <span>*</span></label>
                <div class="col-sm-8">
                    {!! Form::select("tipo_contrato_id",$tipo_contrato,$negocio->tipo_contrato_id,["class"=>"form-control","id"=>"tipo_contrato_id"]); !!}
                </div>
            </div>
        @endif
      
        <div class="col-md-6 form-group">
            <div class="col-sm-8">
                {!! Form::hidden("tipo_liquidacion",$tipo_liquidacion->id,["class"=>"form-control","id"=>"tipo_liquidacion"]); !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <div class="col-sm-8">
                {!! Form::hidden("tipo_salario",$tipo_salario->id,["class"=>"form-control","id"=>"tipo_salario"]); !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <div class="col-sm-8">
                {!! Form::hidden("tipo_nomina",$tipo_nomina->id,["class"=>"form-control","id"=>"tipo_nomina"]); !!}
            </div>
        </div>
        
        <div class="col-md-6 form-group">
            <div class="col-sm-8">
                {!! Form::hidden("concepto_pago_id",$concepto_pago->id,["class"=>"form-control","id"=>"concepto_pago_id"]); !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group has-success">
            <div class="col-sm-8">
                {!! Form::hidden("salario",$salario,["required","class"=>"form-control solo-numero","id"=>"salario","placeholder"=>"Salario","data-min"=>$salario_min,"data-max"=>$salario_max]); !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Motivo Requerimiento <span>*</span></label>
            <div class="col-sm-8">
                {!! Form::select("motivo_requerimiento_id",$motivo_requerimiento, $motivo_requerimiento_id,["class"=>"form-control","id"=>"motivo_requerimiento_id","required"]); !!}
            </div>
        </div>

        @if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co")
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Número Vacantes <span>*</span></label>
                <div class="col-sm-8">
                    <!-- $ficha_numero_vacante Remplace 1   -->
                    {!! Form::text("num_vacantes",null,["class"=>"form-control","id"=>"num_vacantes","required"]); !!}
                </div>
            </div>
        @else
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Número Vacantes</label>
                <div class="col-sm-8">
                    <!-- $ficha_numero_vacante Remplace 1   -->
                    {!! Form::text("num_vacantes",1,["class"=>"form-control","id"=>"num_vacantes"]); !!}
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Justificación <span>*</span></label>
            <div class="col-sm-10">
                {!! Form::textarea("justificacion",$observaciones,["class"=>"form-control","id"=>"justificacion","rows"=>"3"]); !!}
            </div>
        </div>
    </div>

        <div class="row">
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Funciones a Realizar <span>*</span></label>
                <div class="col-sm-12">
                    {{-- {!! Form::textarea("funciones",$ficha_funciones_realizar,["class"=>"form-control","id"=>"funciones","rows"=>"3"]); !!} --}}
                    {!! Form::textarea("funciones",null,["class"=>"form-control","id"=>"funciones","rows"=>"3","required"]); !!}
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Adicionales/Observaciones <span></span></label>
            <div class="col-sm-10">
                {!! Form::textarea("observaciones",$observaciones,["class"=>"form-control","id"=>"observaciones1","rows"=>"3"]); !!}
            </div>
        </div>
    </div>

    <div class="no_contra">
        <h4 class="box-header with-border">ESTUDIOS</h4>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Nivel Estudio <span>*</span></label>
                
                <div class="col-sm-8">
                  {!! Form::select("nivel_estudio",$nivel_estudio,null,["class"=>"form-control","id"=>"nivel_estudio"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Tiempo de Experiencia <span>*</span></label>
                <div class="col-sm-8">
                    {!! Form::select("tipo_experiencia_id",$tipo_experiencia,null,["class"=>"form-control","id"=>"tipo_experiencia_id","required"]); !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Edad Mínima <span>*</span></label>
                <div class="col-sm-8">
                    {!! Form::select("_minima_minima",$edad_minima,$ficha_edad_minima,["class"=>"form-control","id"=>"edad_minima"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Edad Máxima <span>*</span></label>
                <div class="col-sm-8">
                    {!! Form::select("edad_maxima",$edad_maxima,$ficha_edad_maxima,["class"=>"form-control","id"=>"edad_maxima"]); !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Género <span>*</span></label>
                <div class="col-sm-8">
                    {!! Form::select("genero_id",$generos,null,["class"=>"form-control","id"=>"genero_id"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
              <label for="inputEmail3" class="col-sm-4 control-label">Estado Civil <span>*</span></label>
               <div class="col-sm-8">
                {!! Form::select("estado_civil",$estados_civiles,null,["class"=>"form-control","id"=>"estado_civil"]); !!}
               </div>
            </div>
        </div>
    </div>
@elseif(route("home") == "https://gpc.t3rsc.co")

    <div class="row">
        <div class="col-md-6 form-group">
            <label for="tipo_jornadas_id" class="col-sm-4 control-label">Horario de Trabajo <span>*</span></label>

            <div class="col-sm-8">
                {!! Form::select("tipo_jornadas_id", $tipo_jornada, null, ["class" => "form-control", "id" => "tipo_jornadas_id", "required"]); !!}
            </div>
        </div>

        {{--<div class="col-md-6 form-group">
            <label for="tipo_salario" class="col-sm-4 control-label">Tipo Salario <span>*</span></label>

            <div class="col-sm-8">
                {!! Form::select("tipo_salario", $tipo_salario, null, ["class" => "form-control", "id" => "tipo_salario", "required"]); !!}
            </div>
        </div>--}}

        <div class="col-md-6 form-group has-success">
          <label for="salario" class="col-sm-4 control-label">Salario (USD) Minimo <span>*</span></label>

            <div class="col-sm-8">
             {!! Form::text("salario", $salario, [ "required", "class" => "form-control solo-numero", "id" => "salario", "placeholder" => "Salario" ]);!!}
            </div>
        </div>
       
        <div class="col-md-6 form-group has-success">
         <label for="inputEmail3" class="col-sm-4 control-label">Salario (USD) Maximo <span></span></label>
          <div class="col-sm-8">
           {!! Form::text("salario_max", null, [ "required","class" => "form-control solo-numero","id" => "salario","placeholder" => "","data-min" => $salario_min, "data-max" => $salario_max ]);!!}
          </div>
        </div>

        <div class="col-md-6 form-group has-success">
         <label for="inputEmail3" class="col-sm-4 control-label">Salario (USD) Variable <span></span></label>
          <div class="col-sm-8">
           {!! Form::text("salario_variable", null, [ "required","class" => "form-control solo-numero","id" => "salario","placeholder" => "","data-min" => $salario_min, "data-max" => $salario_max ]);!!}
          </div>
        </div>

    </div>

    <div class="row">
      <div class="col-md-6 form-group">
       <label for="tipo_contrato_id" class="col-sm-4 control-label">Tipo Contrato <span>*</span></label>
        
        <div class="col-sm-8">
         {!! Form::select("tipo_contrato_id", $tipo_contrato, null, ["class"=>"form-control","id"=>"tipo_contrato_id","required"]); !!}
        </div>
      </div>

        <div class="col-md-6 form-group">
         <label for="motivo_requerimiento_id" class="col-sm-4 control-label">Motivo Requerimiento <span>*</span></label>
            <div class="col-sm-8">
             {!! Form::select("motivo_requerimiento_id", $motivo_requerimiento, $motivo_requerimiento_id, [ "class" => "form-control", "id" => "motivo_requerimiento_id", "required" ]); !!}
            </div>
        </div>
    </div>

    <div class="row">
     <div class="col-md-6 form-group">
      <label for="num_vacantes" class="col-sm-4 control-label">Número de vacantes <span>*</span></label>
        <div class="col-sm-8">
         {!! Form::number("num_vacantes","",["class"=>"form-control","id"=>"num_vacantes","required"]); !!}
        </div>
     </div>
    </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <div class="col-sm-10">
                {!! Form::hidden("justificacion", $observaciones, ["class" => "form-control", "id" => "observacioness", "rows" => "3"]); !!}
            </div>
        </div>
    </div>
    
        <div class="row">
            <div class="col-md-12 form-group">
             <label for="funciones" class="col-sm-2 control-label">Funciones a Realizar <span>*</span></label>
                <div class="col-sm-12">
                 {!! Form::textarea("funciones",$ficha_funciones_realizar,["class"=>"form-control","id"=>"funciones","rows"=>"3","required"]); !!}
                </div>
            </div>
        </div>

    <div class="row">
        <div class="col-md-12 form-group">
            <label for="observaciones" class="col-sm-3 control-label">Observaciones</label>
            
            <div class="col-sm-12">
                {!! Form::textarea("observaciones", $observaciones, ["class" => "form-control", "id" => "observaciones", "rows" => "3", "cols" => "10"]); !!}
            </div>
        </div>

        <div class="col-md-12 form-group">
            <label for="conocimientos_especificos" class="col-sm-3 control-label">Conocimientos específicos</label>
            
            <div class="col-sm-12">
                {!! Form::textarea("conocimientos_especificos", null, ["class" => "form-control", "id" => "conocimientos_especificos", "rows" => "3", "cols" => "10"]); !!}
            </div>
        </div>
    </div>

    <div class="no_contra">
        <h4 class="box-header with-border">ESTUDIOS</h4>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="nivel_estudio" class="col-sm-4 control-label">Nivel Estudio <span>*</span></label>

                <div class="col-sm-8">
                    {!! Form::select("nivel_estudio", $nivel_estudio, null, ["class" => "form-control", "id" => "nivel_estudio"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label for="tipo_experiencia_id" class="col-sm-4 control-label">Tiempo de Experiencia <span>*</span></label>

                <div class="col-sm-8">
                    {!! Form::select("tipo_experiencia_id", $tipo_experiencia, null, ["class" => "form-control","id"=>"tipo_experiencia_id"]); !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
             <label for="edad_minima" class="col-sm-4 control-label">Edad Mínima <span>*</span></label>

                <div class="col-sm-8">
                 {!! Form::select("edad_minima", $edad_minima, null, ["class" => "form-control", "id" => "edad_minima"]); !!}
                </div>
            </div>
     
            <div class="col-md-6 form-group">
                <label for="edad_maxima" class="col-sm-4 control-label">Edad Máxima <span>*</span></label>

                <div class="col-sm-8">
                    {!! Form::select("edad_maxima", $edad_maxima, null, ["class" => "form-control", "id" => "edad_maxima"]); !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Género <span>*</span></label>

                <div class="col-sm-8">
                    {!! Form::select("genero_id", $generos, null, ["class" => "form-control", "id" => "genero_id"]); !!}
                </div>
            </div>

        </div>
    </div>
   
    <div>
        <h4 class="box-header with-border">IDIOMAS</h4>

        <div class="row">
            <div class="col-md-6 form-group">
                <label for="idioma" class="col-sm-4 control-label">Idiomas</label>

                <div class="col-sm-8">
                    {!! Form::hidden("id_idioma",null,["class"=>"form-control","id"=>"id_idioma"]) !!}
                    {!! Form::text("idioma", null, ["class" => "form-control", "id" => "idioma_autocomplete", 'placeholder' => 'Digite idioma']); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label for="nivel_idioma" class="col-sm-4 control-label">Nivel</label>

                <div class="col-sm-8">
                    {!! Form::select("nivel_idioma", $niveles, null, ["class" => "form-control", "id" => "nivel_idioma"]); !!}
                </div>
            </div>
        </div>
    </div>
@else
    
    <div class="col-md-6" hidden>
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
        @if(strlen($archivo)>0)
            <label for="inputEmail3" class="col-sm-4 control-label">Archivo perfil <span></span></label>
            <a href='{{route("view_document_url", encrypt("recursos_Perfiles/"."|".$archivo))}}' target="_blank" class="btn btn-info">
                <i class="fa fa-eye"></i> 
                        Archivo perfil de cargo
                  </a>
        @endif

        {!! Form::hidden("centro_costo_produccion",1) !!}      
    </div>
    
    <div class="col-md-6">
        <div class="form-group @error('tipo_jornadas_id') has-feedback has-error smk-select @enderror">
            <label for="inputEmail3" class="control-label">Jornada Laboral: <span class='text-danger sm-text-label'>*</span></label>
            {!! Form::select("tipo_jornadas_id",$tipo_jornada,$ficha_jornada_laboral,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_jornadas_id","required"]); !!}

            @error('tipo_jornadas_id')
                <span class="help-block smk-error-msg">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="col-md-6" hidden>
        <div class="form-group @error('tipo_liquidacion') has-feedback has-error smk-select @enderror">
            <label for="inputEmail3" class="control-label">Tipo Liquidación: <span class='text-danger sm-text-label'>*</span></label>
            {!! Form::select("tipo_liquidacion",$tipo_liquidacion,1,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_liquidacion","required"]); !!}

            @error('tipo_liquidacion')
                <span class="help-block smk-error-msg">{{ $message }}</span>
            @enderror
        </div>
    </div>


    <div class="col-md-6">
        <div class="form-group @error('tipo_salario') has-feedback has-error smk-select @enderror">
            <label for="inputEmail3" class="control-label">Tipo Salario: <span class='text-danger sm-text-label'>*</span></label>
            {!! Form::select("tipo_salario",$tipo_salario,$tipo_salario_id,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_salario","required"]); !!}

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
            {!!Form::select("tipo_contrato_id",$tipo_contrato,$ficha_tipo_contrato,["required", "class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"tipo_contrato_id"]);!!}

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

</div>
@endif

<script>
    function calculo_fecha_segun_cargo(){
            var vacantes=$("#num_vacantes").val();
            var motivo=$("#motivo_requerimiento_id").val();
            var ciudad=$("#ciudad_id").val();
            var cargo=$("#cargo_especifico_id").val();
            var departamento=$("#departamento_id").val();

            if(vacantes!="" && motivo!="" && ciudad!="" && cargo!=""){
                $.ajax({
                    type: "POST",
                    data: {
                        "ciudad_id":ciudad,
                        "motivo":motivo,
                        "cargo_especifico_id":cargo,
                        "vacantes":vacantes,
                        "departamento_id":departamento
                    },
                    url: "{{ route('req.ajaxgetfechaSegunCargo') }}",
                    success: function(response) {
                        $("#fecha_ingreso").val(response);
                    }
                });
            }
            else{
            }
        }
        
    @if(route("home") == "https://vym.t3rsc.co" || route("home") == "http://localhost:8000")
        $("#frm_crearReq").delegate('#motivo_requerimiento_id', 'change', function(){
            calculo_fecha_segun_cargo();
        });

        $("#frm_crearReq").delegate('#num_vacantes', 'change', function(){
            calculo_fecha_segun_cargo();
        });
    @endif

    @if (route('home') == 'https://gpc.t3rsc.co' || route('home') == 'http://localhost:8000')
        const number = document.querySelector('#salario');

        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }

        number.addEventListener('keyup', (e) => {
            const element = e.target;
            const value = element.value;
            element.value = formatNumber(value);
        });
    @endif

    $(function(){
        $('#idioma_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocompletar_idiomas") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#id_idioma").val(suggestion.id);
                $("#idioma_autocomplete").val(suggestion.value);
            }
        });

        $('#sitio_trabajo_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                console.log(suggestion);
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });

        $('#salario').on('change invalid', function() {
            var campotexto = $(this).get(0);

            campotexto.setCustomValidity('');

            if (!campotexto.validity.valid) {
                campotexto.setCustomValidity('El campo salario es obligatorio');  
            }
        });

        $(".solo-numero").keydown(function(event) {
            if(event.shiftKey){
                event.preventDefault();
            }
            
            if (event.keyCode == 46 || event.keyCode == 8){
            }
            else{
                if (event.keyCode < 95) {
                    if(event.keyCode < 48 || event.keyCode > 57) {
                     event.preventDefault();
                    }
                } 
                else {
                    if(event.keyCode < 96 || event.keyCode > 105) {
                      event.preventDefault();
                    }
                }
            }
        });


        $("#edad_maxima").blur(function(event) {

            let edad_maxima = parseInt($(this).val());
            let edad_minima = parseInt($("#edad_minima").val());

            if (edad_maxima < edad_minima) {
                $(this).val("");
                mensaje_danger("La edad máxima no puede ser menor que la edad mínima")
            }
        });

        $("#edad_minima").blur(function(event) {

            let edad_minima = parseInt($(this).val());
            let edad_maxima = parseInt($("#edad_maxima").val());

            if (edad_minima > edad_maxima && edad_maxima != "") {
                $(this).val("");
                mensaje_danger("La edad mínima no puede ser mayor que la edad máxima")
            }
        });
    });
</script>
