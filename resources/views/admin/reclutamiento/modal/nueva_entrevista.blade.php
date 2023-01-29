<!-- Inicio contenido principal -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Nueva entrevista @if(route('home') == "https://vym.t3rsc.co" || route('home') == "http://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co" || route('home') == "http://listos.t3rsc.co") (Según criterio establecido por selección) @endif</h4>
</div>
<div class="modal-body">
  {!! Form::model(Request::all(),["id"=>"fr_entrevista"]) !!}
    {!! Form::hidden("ref_id") !!}
    {!! Form::hidden("proceso_can_req",$proceso_can_req) !!}
    
    <div class="col-md-12 form-group">
      <label for="fuentes_publicidad_id" class="col-sm-8 control-label"> Fuente de Reclutamiento <span></span></label>
      <div class="col-sm-12">
       {!! Form::select("fuentes_publicidad_id",$fuentes,null,["class"=>"form-control","id"=>"fuentes_publicidad_id"]); !!}
        <span style ="color:red; display: none;" class="text error" id="error-fuentes_publicidad_id"></span>
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fuentes_publicidad_id",$errors) !!}</p>
    </div>
    
    <div class="col-md-12 form-group">
      <label for="aspecto_familiar" class="col-sm-8 control-label"> @if(route('home') != "https://temporizar.t3rsc.co") Aspecto Familiar @else Validación personal @endif <span></span></label>
      
      <div class="col-sm-12">
        @if(route('home') == "http://localhost:8000" || route('home') == "https://temporizar.t3rsc.co")
          <?php $view = " \r &#x25b6 Estado Civil \n 
          \r &#x25b6 Número de Hijos: \n
          \r &#x25b6 Número de personas a cargo \n" ; ?>
         
          <textarea name="aspecto_familiar" class="form-control" rows="5" maxlength="2000">{!!$view!!}</textarea>
        @else
          {!! Form::textarea("aspecto_familiar",null,[
              "maxlength" => "4000",
              "placeholder" => "Máximo 4000 caracteres",
              "class"=>"form-control",
              "id"=>"aspecto_familiar",
              "rows"=>"5"]); !!}
        @endif
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
    </div>
       
    <div class="col-md-12 form-group">
      <label for="aspecto_academico" class="col-sm-8 control-label"> @if(route('home') == "https://temporizar.t3rsc.co") Validación Organizacional @else Aspectos Académicos @endif <span></span></label>
      <div class="col-sm-12">
        @if(route('home') == "http://localhost:8000" || route('home') == "https://temporizar.t3rsc.co")
          <?php $view = " \r Si, posterior a la evaluación del candidato podemos inferir que si se ajusta al perfil solicitado. \n 
            \r &#x25b6 Motivo de retiro: \n
            \r &#x25b6 Nombre de la empresa: \n
            \r &#x25b6 Cargo desempeñado: \n
            \r &#x25b6 Cumple con los Estudios requeridos en el perfil? \n
            \r &#x25b6 Cumple con la edad requerida en el perfil? \n
            \r &#x25b6 Se ajusta a la oferta económica de la vacante? \n" ; ?>

          <textarea name="aspecto_academico" class="form-control" rows="5" maxlength="2000">{!!$view!!}</textarea>
        @else
          {!! Form::textarea("aspecto_academico",null,[
              "maxlength" => "4000",
              "placeholder" => "Máximo 4000 caracteres",
              "class"=>"form-control",
              "id"=>"aspecto_academico",
              "rows"=>"5"]); !!}
        @endif
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_academico",$errors) !!}</p>
    </div>
    
    @if(route('home') != "https://temporizar.t3rsc.co") 
      <div class="col-md-12 form-group">
        <label for="aspectos_experiencia" class="col-sm-8 control-label">
        @if(route('home') == "https://vym.t3rsc.co" || route('home') == "http://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co" || route('home') == "http://listos.t3rsc.co") Aspecto Laboral @else
           Aspectos Experiencia
          @endif <span></span></label>
        <div class="col-sm-12">
          {!! Form::textarea("aspectos_experiencia",null,[
              "maxlength" => "4000",
              "placeholder" => "Máximo 4000 caracteres",
              "class"=>"form-control",
              "id"=>"aspectos_experiencia",
              "rows"=>"5"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspectos_experiencia",$errors) !!}</p>
      </div>
     
      <div class="col-md-12 form-group">
        <label for="aspectos_personalidad" class="col-sm-12 control-label">
        @if(route('home') == "https://vym.t3rsc.co" || route('home') == "http://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co" || route('home') == "http://listos.t3rsc.co") Rasgos Personales (Fortalezas, Aspectos a mejorar, proyectos o metas) @else
          
          Aspectos de Personalidad @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") , Fortalezas y Oportunidades de mejoras Frente al Cargo @elseif(route('home') == "https://gpc.t3rsc.co") / Competencias @endif @endif <span></span></label>
           
        <div class="col-sm-12">
          {!! Form::textarea("aspectos_personalidad",null,[
              "maxlength" => "4000",
              "placeholder" => "Máximo 4000 caracteres",
              "class"=>"form-control",
              "id"=>"aspectos_personalidad",
              "rows"=>"5"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspectos_personalidad",$errors) !!}</p>
      </div>
    
      @if(route('home') != "https://vym.t3rsc.co" && route('home') != "http://vym.t3rsc.co" && route('home') != "https://listos.t3rsc.co" && route('home') != "http://listos.t3rsc.co")

        <div class="col-md-12 form-group">
          <label for="inputEmail3" class="col-sm-12 control-label"> @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") Conflicto de intereses (tiene el candidato algún tipo de relación de parentesco -civil, afinidad o consanguinidad- con algún empleado o contratista, proveedor, cliente de la compañía; participación en la propiedad o gestión de un tercero) @else Fortalezas frente al Cargo @endif <span></span></label>
          <div class="col-sm-12">
            {!! Form::textarea("fortalezas_cargo",null,[
              "maxlength" => "4000",
              "placeholder" => "Máximo 4000 caracteres",
              "class"=>"form-control",
              "id"=>"fortalezas_cargo",
              "rows"=>"5"]); !!}
          </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fortalezas_cargo",$errors) !!}</p>
        </div>
      
        <div class="col-md-12 form-group">
          <label for="oportunidad_cargo" class="col-sm-12 control-label"> @if(route('home') == "https://komatsu.t3rsc.co" || route('home') == "http://komatsu.t3rsc.co") Conflicto Entrevistador (Tiene el entrevistador algún tipo de relación de parentesco -civil, afinidad o consanguinidad-, conoce o ha trabajado con el candidato entrevistado)  @else Oportunidades de mejora frente al cargo @endif <span></span></label>
          <div class="col-sm-12">
            {!! Form::textarea("oportunidad_cargo",null,[
              "maxlength" => "4000",
              "placeholder" => "Máximo 4000 caracteres",
              "class"=>"form-control",
              "id"=>"oportunidad_cargo",
              "rows"=>"5"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("oportunidad_cargo",$errors) !!}</p>
        </div>
      @endif
    @endif

    @if(route('home') == "https://gpc.t3rsc.co")
      <div class="col-md-12 form-group">
        <label for="aspecto_salarial" class="col-sm-8 control-label"> Aspecto Salarial <span></span></label>
       
        <div class="col-sm-12">
          {!! Form::textarea("aspecto_salarial",null,[
            "maxlength" => "4000",
            "placeholder" => "Máximo 4000 caracteres",
            "class"=>"form-control",
            "id"=>"aspecto_salarial",
            "rows"=>"5"]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_salarial",$errors) !!}</p>
      </div>
    @endif

    <div class="col-md-12 form-group">
      <label for="evaluacion_competencias" class="col-md-8 control-label"> Evaluación Competencias <span></span></label>
      <div class="col-md-12">
        {!! Form::textarea("evaluacion_competencias",null,[
          "maxlength" => "4000",
          "placeholder" => "Máximo 4000 caracteres",
          "class"=>"form-control",
          "id"=>"evaluacion_competencias",
          "rows"=>"5"]); !!}
      </div>
    </div>

    <div class="col-md-12 form-group">
      <label for="concepto_general" class="col-sm-12 control-label"> Concepto General @if(route('home') == "https://vym.t3rsc.co" || route('home') == "http://vym.t3rsc.co" || route('home') == "https://listos.t3rsc.co" || route('home') == "http://listos.t3rsc.co") (Según los lineamientos del área) @endif <span>*</span></label>
      <div class="col-sm-12">
          {!! Form::textarea("concepto_general",(route('home') == 'https://temporizar.t3rsc.co')?"De acuerdo a las validaciones realizadas se evidencia que":null,[
            "maxlength" => "4000",
            "placeholder" => "Máximo 4000 caracteres",
            "class"=>"form-control",
            "id"=>"concepto_general",
            "rows"=>"5"]); !!}
          <span style ="color:red; display: none;" class="text error" id="error-concepto_general"></span>
      </div>
       <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("concepto_general",$errors) !!}</p>
    </div>
    <br>
    <div class="clearfix"></div>

    <div class="col-sm-6 col-lg-6">
      <div class="form-group">
        <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Apto:</label>
        <div class="col-md-7">
          <label class="switchBtn">
            {!! Form::checkbox("apto",1,1,["class"=>"checkbox-preferencias","id"=>"switch"]) !!}
            <div class="slide"></div>
          </label>
        </div>
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
    </div>

    <div class="col-sm-6 col-lg-6" style="background-color: #fdf06a; padding: .5em;">
      <div class="form-group">
        <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Entrevista Definitiva:</label>
        <div class="col-md-7">
          <label class="switchBtn">
            {!! Form::checkbox("definitiva",1,1,["class"=>"checkbox-preferencias definitiva","id"=>"switch"]) !!}
            <div class="slide"></div>
          </label>
        </div>
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
    </div>

    {{--   <div class="col-sm-6 col-lg-6">
      <div class="form-group">
        <label for="trabajo-empresa-temporal" class="col-md-5 control-label">¿Asistió?:</label>
        <div class="col-md-7">
          {!! Form::checkbox("asistio",1,null,["class"=>"checkbox-preferencias" ]) !!}
        </div>
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
    </div> --}}

    <div class="clearfix"></div>
  {!! Form::close() !!}
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="button" class="btn btn-success" id="guardar_entrevista" >Guardar</button>
</div>

<style>
  label span {
    font-weight: 400;
  }

  .definitiva + .slide:after {
    position: absolute;
    content: "NO" !important;
  }

  .definitiva:checked + .slide:after {
    content: "SI"  !important;
  }
</style>

<script>
  //Ocultar textarea evaluacion competencias
  $(function(){
    $('.ocultar').hide();

    $('.fantasma').change(function(){
      if(!$(this).prop('checked')){
        $('.ocultar').hide();
      }else{
        $('.ocultar').show();
      }
    });

    $('.motivo').hide();

    $('.estado_ref').change(function(){
        //alert("entro");
        //alert($('.estado_ref').val());
      if($('.estado_ref').val() == 2){
        $('.motivo').show();
      }else{
       $('.motivo').hide();
      }
    });

    $(document).on('keyup', "[maxlength]", function (e) {
      var este = $(this),
      maxlength = este.attr('maxlength'),
      maxlengthint = parseInt(maxlength),
      textoActual = este.val(),
      currentCharacters = este.val().length;
      remainingCharacters = maxlengthint - currentCharacters,
      espan = este.parent().prev('label').find('span');

      // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5
      if (document.addEventListener && !window.requestAnimationFrame) {
        if (remainingCharacters <= -1) {
          remainingCharacters = 0;            
        }
      }

      espan.html('('+remainingCharacters+' caracteres restantes.)');

      //console.log(remainingCharacters);

      if (!!maxlength) {
        var texto = este.val(); 
        if (texto.length >= maxlength) {
          este.addClass("borderojo");
          este.val(text.substring(0, maxlength));
          e.preventDefault();
        } else if (texto.length < maxlength) {
          este.addClass("bordegris");
        }
      }
    });
  })
</script>