<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Detalle entrevista </h4>
</div>
<div class="modal-body">
    {!! Form::model($entrevista,["id"=>"fr_entrevista"]) !!}
        {!! Form::hidden("ref_id") !!}
        {!! Form::hidden("id",null,["id"=>"id_entrevista"]) !!}
        {!! Form::hidden("candidato_id") !!}
        {!! Form::hidden("proceso",$proce) !!}
        <div class="col-md-12 form-group">
            <label for="fuentes_publicidad_id" class="col-sm-4 control-label"> Fuente de Reclutamiento </label>
            <div class="col-sm-12">
                {!! Form::select("fuentes_publicidad_id",$fuentes,null,["class"=>"form-control","id"=>"textarea"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fuentes_publicidad_id",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="aspecto_familiar" class="col-sm-8 control-label"> Aspecto Familiar <span></span></label>
            <div class="col-sm-12">
                {!! Form::textarea("aspecto_familiar",null,[
                  "maxlength" => "4000",
                  "placeholder" => "Máximo 4000 caracteres",
                  "class"=>"form-control",
                  "id"=>"aspecto_familiar",
                  "rows"=>"5"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">
                {!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}
            </p>
        </div>

        <div class="col-md-12 form-group">
            <label for="aspecto_academico" class="col-sm-8 control-label"> Aspectos Académicos <span></span></label>
            <div class="col-sm-12">
                {!! Form::textarea("aspecto_academico",null,[
                  "maxlength" => "4000",
                  "placeholder" => "Máximo 4000 caracteres",
                  "class"=>"form-control",
                  "id"=>"aspecto_academico",
                  "rows"=>"5"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_academico",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="aspectos_experiencia" class="col-sm-8 control-label"> Aspectos Experiencia <span></span></label>
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
            <label for="aspectos_personalidad" class="col-sm-8 control-label"> Aspectos de Personalidad <span></span></label>
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

        <div class="col-md-12 form-group">
            <label for="fortalezas_cargo" class="col-sm-8 control-label"> Fortalezas frente al Cargo <span></span></label>
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
            <label for="oportunidad_cargo" class="col-sm-12 control-label"> Oportunidades de mejora frente al cargo <span></span></label>
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
        {{--}} <div class="col-sm-6 col-lg-6">
            <div class="form-group">
                <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Apto:</label>
                <div class="col-md-7">
                    {!! Form::checkbox("apto",1,null) !!}
                    <!-- ,["class"=>"checkbox-preferencias" ] -->

                </div>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
        </div>  

     {{--    <div class="col-sm-6 col-lg-6">
            <div class="form-group">
                <label for="trabajo-empresa-temporal" class="col-md-5 control-label">¿Asistió?:</label>
                <div class="col-md-7">
                    {!! Form::checkbox("asistio",1,null) !!}

                </div>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
        </div> --}}

        @if(route('home') == "https://gpc.t3rsc.co")
            <div class="col-md-12 form-group">
                <label for="aspecto_salarial" class="col-sm-8 control-label"> Aspecto Salarial <span></span></label>
               
                <div class="col-sm-12">
                  {!! Form::textarea("aspecto_salarial",null,[
                    "maxlength" => "2000",
                    "placeholder" => "Máximo 2000 caracteres",
                    "class"=>"form-control",
                    "id"=>"aspecto_salarial",
                    "rows"=>"5"]); !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_salarial",$errors) !!}</p>
            </div>
        @endif

        <div class="col-md-12 form-group">
            <label for="evaluacion_competencias" class="col-sm-8 control-label"> Evaluación Competencias <span></span></label>
            <div class="col-sm-12">
                {!! Form::textarea("evaluacion_competencias",null,[
                  "maxlength" => "4000",
                  "placeholder" => "Máximo 4000 caracteres",
                  "class"=>"form-control",
                  "id"=>"evaluacion_competencias",
                  "rows"=>"5"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("evaluacion_competencias",$errors) !!}</p>
        </div>
        
        <div class="col-md-12 form-group">
            <label for="concepto_general" class="col-sm-8 control-label"> Concepto General <span></span></label>
            <div class="col-sm-12">
                {!! Form::textarea("concepto_general",null,[
                    "maxlength" => "4000",
                    "placeholder" => "Máximo 4000 caracteres",
                    "class"=>"form-control",
                    "id"=>"concepto_general",
                    "rows"=>"5"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("concepto_general",$errors) !!}</p>
        </div>

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
                <label for="trabajo-empresa-temporal" class="col-md-5 control-label switch">Entrevista Definitiva:</label>
                <div class="col-md-7">
                 <label class="switchBtn">
                  {!! Form::checkbox("definitiva",1,1,["class"=>"checkbox-preferencias si_no","id"=>"switch"]) !!}
                   <div class="slide"></div>
                 </label>
                </div>
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
        </div>
        <div class="clearfix"></div>
    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success actualizar_entrevista">Actualizar</button>
    
</div>
<style>
    label span {
        font-weight: 400;
    }
</style>
<script>
    $(function(){
      //   $('.checkbox-preferencias').bootstrapSwitch();

        $(".actualizar_entrevista").on("click", function () {
            id = $("#id_entrevista").val();
            if(id){
                $.ajax({
                    type: "POST",
                    data: $("#fr_entrevista").serialize(),
                    url: "{{ route('admin.actualizar_entrevista') }}",
                    success: function (response) {
                         mensaje_success("Entrevista actualizada!!");
                         if(response.final==1){
                                window.location.href = '{{ route("admin.entrevistas") }}';
                        }
                        else{
                            location.reload();
                        }
                        
                       
                       
                    }
                });
            }else{
                mensaje_danger("Problemas al actualizar la entrevista, intentar nuevamente.");
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
    });
</script>