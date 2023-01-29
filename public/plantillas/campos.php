<div class="col-md-12 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">{{name_campo}}:</label>
    <div class="col-sm-10">
        {!! Form::text("{{name_campo}}",null,["class"=>"form-control","placeholder"=>"{{name_campo}}" ]); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("{{name_campo}}",$errors) !!}</p>    
</div>