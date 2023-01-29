<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Nueva Prueba Idioma Virtual</h4>
</div>

<div class="modal-body">

    <div class="alert alert-warning alert-dismissible" role="alert">
        <b><p>Esta prueba se muestra con una pregunta cargada aleatoriamente.</p></b>
        <p>La prueba de idioma es un metodo virtual de saber conocimientos del candidato de acuerdo al idioma.</p>        
    </div>

    {!! Form::model(Request::all(),["id"=>"fr_preg_prueba_idioma"]) !!}

        {!! Form::hidden("ref_id",$req_id) !!}
        {!! Form::hidden("cargo_id",$cargo_id) !!}
       
        <div class="col-md-12 form-group">
            <!---<label for="inputEmail3" class="col-sm-4 control-label"> Tipo de pregunta</label>--->
            
            <input type="hidden" class="form-control fantasma" name="tipo_id" id="tipo_id" value="4" >

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspecto_familiar",$errors) !!}</p>
        </div>

        <h3 style="text-align: center;">Pregunta</h3>

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

        <div class="col-md-12 form-group">
            <div class="col-sm-10">
                {!! Form::text("descripcion",$preguntasPre[$preguntaRand]['descripcion'],["class"=>"form-control","id"=>"descripcion_1","placeholder"=>"Escriba su pregunta"]); !!}
            </div>

            <div class="col-sm-1">
                <button class="btn btn-sm btn-info" id="changeQuestion" title="Cambiar pregunta" type="button" onclick="ChangeQuestion(1);"><i class="fa fa-random"></i></button>
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
        </div>

        <div class="clearfix"></div>

    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_preg_prueba_idioma" >Guardar</button>
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

        padre.append("<button type='button' class='btn btn-danger btn_eliminar'>-</button>");

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