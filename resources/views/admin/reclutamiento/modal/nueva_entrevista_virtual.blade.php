<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Nueva Entrevista Virtual</h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_entre_virtual"]) !!}
        {!! Form::hidden("req_id",$req_id) !!}
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <p>Se puede crear la entrevista virtual con máximo 3 preguntas, por favor colocar las más importantes para una gestion efectiva </p>
            </div>
        </div>
       
       <h3 style="text-align: center;">Preguntas</h3>
        
        <br>

        <div class="clearfix"></div> 
        
        <div class="col-md-12 form-group">
            <div class="col-sm-12">
                {!! Form::text("descripcion[]", null, [
                    "class" => "form-control",
                    "id" => "descripcion",
                    "placeholder" => "Escriba su pregunta",
                    "maxlength" => "100"
                ]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <div class="col-sm-12">
                {!! Form::text("descripcion[]", null, [
                    "class" => "form-control",
                    "id" => "descripcion",
                    "placeholder" => "Escriba su pregunta",
                    "maxlength" => "100"
                ]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <div class="col-sm-12">
                {!! Form::text("descripcion[]", null, [
                    "class" => "form-control",
                    "id" => "descripcion",
                    "placeholder" => "Escriba su pregunta",
                    "maxlength" => "100"
                ]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion", $errors) !!}</p>
        </div>
            
        <div class="clearfix"></div>

        <br><br>

        <div class="clearfix"></div>
    {!! Form::close() !!}
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="guardar_entrevista_virtual" >Guardar</button>
</div>

<script>
    $(function(){
        $('.ocultar').hide();
        $('.container_cargos').hide();
        $('.sisa').hide();
        $('.radio').hide();

        $('#tipo_id').change(function(){
            if ($('.fantasma').val() == 2) {
                $('.ocultar').show();
                $('.container_cargos').show();
            } else if($('.fantasma').val() == 1) {
                $('.container_cargos').show();
                $('.ocultar').hide();
            } else {
                $('.ocultar').hide();
                $('.container_cargos').hide();
            }
        })
        
        $('.filtro').change(function(){
            if (!$(this).prop('checked')) {
                $('.radio').hide();
                $('.sisa').hide();
            } else {
                $('.radio').show();
                $('.sisa').show();
            }
        })
    })

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

    $(function () {
        $('.checkbox-preferencias').bootstrapSwitch();        
    });    
</script>