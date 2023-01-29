<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Nueva Prueba Idioma</h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_prueba_idioma","data-smk-icon"=>"glyphicon-remove-sign"]) !!}

        {!! Form::hidden("req_id",$req_id) !!}
        <div class="col-md-12" id="mensaje-resultado">
        
            <div class="alert alert-warning alert-dismissible" role="alert">
                <b><p>La prueba de idioma se muestra con dos preguntas cargadas aleatoriamente.</p></b>
            </div>

            <div class="alert alert-warning alert-dismissible" role="alert">
                <p>Se puede crear la prueba de idioma con máximo 3 preguntas, por favor colocar las más importantes para una gestión efectiva </p>
            </div>

        </div>
       
        <h3 style="text-align: center;">Preguntas</h3>
        <br>

        <div class="col-md-12 form-group">
            
            <div id="questionOptions" class="col-sm-12" style="display: none; margin-bottom: 20px; background-color: #f1f1f1; padding: 10px; position: relative;">
                <p style="text-align: right; cursor: pointer;" onclick="$('#questionOptions').hide('slow');" >&times</p>
                <b><h5></h5></b>

                @foreach ($preguntasPre as $pregunta)
                    <input type="radio" name="itemQuestion" id="itemQuestion" value="{{ $pregunta->descripcion }}">{{ $pregunta->descripcion }} <br>
                @endforeach
            </div>

        </div>

        <div class="clearfix"></div>
        
        <div class="col-md-8 form-group">
            <div class="col-sm-10">
                {!! Form::text("descripcion[]",$preguntasPre[$preguntaRand1]['descripcion'],["class"=>"form-control","id"=>"descripcion_1","placeholder"=>"Escriba su pregunta"]); !!}
            </div>

            <div class="col-sm-1">
                <button class="btn btn-sm btn-info" id="changeQuestion" title="Cambiar pregunta" type="button" onclick="ChangeQuestion(1);"><i class="fa fa-random"></i></button>
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
        </div>

        <div class="col-md-4 form-group">
            <div class="col-sm-12">
                {!! Form::select("tiempo[]",[""=>"Tiempo estimado de respuesta","20"=>"20 s.","30"=>"30 s.","40"=>"40 s.","50"=>"50 s.","60"=>"60 s."],null,["class"=>"form-control","id"=>"tiempo","required"=>"true"]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tiempo",$errors) !!}</p>
        </div>

        <div class="col-md-8 form-group">
            <div class="col-sm-10">
                {!! Form::text("descripcion[]",$preguntasPre[$preguntaRand2]['descripcion'],["class"=>"form-control","id"=>"descripcion_2","placeholder"=>"Escriba su pregunta"]); !!}
            </div>

            <div class="col-sm-1">
                <button class="btn btn-sm btn-info" id="changeQuestion" title="Cambiar pregunta" type="button" onclick="ChangeQuestion(2);"><i class="fa fa-random"></i></button>
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
        </div>

        <div class="col-md-4 form-group">
            <div class="col-sm-12">
                {!! Form::select("tiempo[]",[""=>"Tiempo estimado de respuesta","20"=>"20 s.","30"=>"30 s.","40"=>"40 s.","50"=>"50 s.","60"=>"60 s."],null,["class"=>"form-control","id"=>"tiempo","required"=>"true"]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tiempo",$errors) !!}</p>
        </div>

        <div class="col-md-8 form-group">
            <div class="col-sm-10">
                {!! Form::text("descripcion[]",null,["class"=>"form-control","id"=>"descripcion_3","placeholder"=>"Escriba su pregunta"]); !!}
            </div>

            <div class="col-sm-1">
                <button class="btn btn-sm btn-info" id="changeQuestion" title="Cambiar pregunta" type="button" onclick="ChangeQuestion(3);"><i class="fa fa-random"></i></button>
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
        </div>

        <div class="col-md-4 form-group">
            <div class="col-sm-12">
                {!! Form::select("tiempo[]",[""=>"Tiempo estimado de respuesta","20"=>"20 s.","30"=>"30 s.","40"=>"40 s.","50"=>"50 s.","60"=>"60 s."],null,["class"=>"form-control","id"=>"tiempo","required"=>"true"]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tiempo",$errors) !!}</p>
        </div>

        <div class="clearfix"></div>
        <br><br>
        <div class="clearfix"></div>

    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_prueba_idioma" >Guardar</button>
</div>

<script>

    $(function () {
       
        const field = null;

    });    

    function ChangeQuestion(num){

        $("input:radio[name='itemQuestion']").each(function(i) {
            this.checked = false;
        });
        
        $("#questionOptions").hide('slow');
        $('#questionOptions').find('h5').html('Cambiar pregunta # '+num);
        $("#questionOptions").show('slow');

        field = num;

    }

    $("input[name='itemQuestion']").change(function(){
        document.getElementById('descripcion_'+field).value = $(this).val();
    });

    $(document).on("click", ".btn_agregar", function () {

        var selector = $(".container_cargos").last().val();

        var incremento = $("#id_respuesta").val();
        var incremento = parseInt(incremento) + 1;

        $("#id_respuesta").val(incremento);
        var  contador = 0 ;
        var control = $(this).parents(".row").clone();
        control.find('input').val('');
        var padre = $(this).parents(".button_action");
        padre.append("{!! FuncionesGlobales::valida_boton_req('admin.reclutamiento_elimina_cargo','-','boton','btn   btn-danger btn_eliminar') !!}");
        $(this).remove();

        $(".container_cargos .bloque").append(control);
        $("input[name=minimo]").each(function(key,value){
            $(value).attr('value',key);
        });

    });

    $(document).on("click", ".btn_eliminar", function () {
        //VALIDAR SI ES UN REGISTRO EXISTENTE
        var data_id = $(this).data("id");
        var obj = $(this);
        $(this).parents(".row").remove();
            
    });    
</script>