{!! Form::model(Request::all(),["id"=>"fr_nueva_prueba", "files"=>true]) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Prueba Tendencia</h4>
    </div>
    
    <div class="modal-body">
        {!! Form::hidden("candidato_id",$candidato->user_id,["class"=>"form-control","id"=>"candidato_id"]); !!}

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Número Identificación</label>
            
            <div class="col-sm-8">
                {{ $candidato->numero_id }}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_prueba_id",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Tipo Prueba</label>

            <div class="col-sm-8">
                {!! Form::select("tipo_prueba_id",$tipo_pruebas,null,["class"=>"form-control"]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_prueba_id",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Puntaje</label>
            
            <div class="col-sm-8">
                {!! Form::text("puntaje",null,["class"=>"form-control"]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("puntaje",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Concepto de la prueba</label>
            
            <div class="col-sm-12">
                {!! Form::textarea("resultado",null,["class"=>"form-control","id"=>"textarea"]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("resultado",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Archivo</label>
            
            <div class="col-sm-8">
                {!! Form::file("nombre_archivo", ["class" => "form-control", "accept" => ".doc,.docx,.pdf"]); !!}
            </div>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Estado</label>
            
            <div class="col-sm-8">
                {!! Form::select("estado",[""=>"Seleccionar","1"=>"Apto","2"=>"No apto","3"=>"Pendiente"],null,["class"=>"form-control"]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado",$errors) !!}</p>
        </div>
        
        <div class="clearfix"></div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success"  id="guardar_prueba_tendencia" >Guardar</button>
    </div>

    <script>
        $(function () {
            $("textarea").jqte();
        });
    </script>
{!! Form::close() !!}