@if(Session::has("mensaje_success"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{ Session::get("mensaje_success") }}
        </div>
    </div>
@endif

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-3 control-label"># Req:</label>
    <div class="col-sm-9">
        {!! Form::text("num_req", null, ["class" => "form-control solo-numero"]); !!}
    </div>
</div>

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-3 control-label ">Clientes:</label>
                
    <div class="col-sm-9">
        {!! Form::select("cliente_id", $clientes, null, ["class" => "form-control", "id" => "cliente_id" ]); !!}
    </div>
</div>

@if( $sitio->agencias )
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-3 control-label ">Agencia:</label>
                        
        <div class="col-sm-9">
            {!! Form::select("agencia", ["" => "Seleccionar"] + $agencias , null, ["class" => "form-control" ]); !!}
        </div>
    </div>
@endif

<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-3 control-label ">Cargo:</label>
            
    <div class="col-sm-9">
        {!! Form::select("cargo_id", [], null, ["class" => "form-control", "readonly" => "readonly", "id" => "cargo_id" ]); !!}
    </div>
</div>

<div class="col-md-6  form-group">
    <label for="inputEmail3" class="col-sm-3 control-label">Tipo Proceso:</label>
    <div class="col-sm-9">
        {!! Form::select('tipo_proceso_id', $tipoProcesos, null, ['id' => 'tipo_proceso_id','class' => 'form-control js-select-2-basic']) !!}
    </div>
</div>

<div class="clearfix"></div>

{!! Form::submit("Buscar", ["class" => "btn btn-success"]) !!}