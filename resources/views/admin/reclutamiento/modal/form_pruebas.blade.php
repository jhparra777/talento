{!! Form::model(Request::all(),["id"=>"fr_nueva_prueba","files"=>true]) !!}
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Nueva prueba</h4>
    </div>

    <div class="modal-body">

        {!! Form::hidden("ref_id") !!}

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Tipo Prueba <span>*</span></label>
            <div class="col-sm-8">
                {!! Form::select("tipo_prueba_id",$tipo_pruebas,null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_prueba_id",$errors) !!}</p>
        </div>

        <!-- <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Puntaje</label>
            <div class="col-sm-8">
                {! Form::text("puntaje",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{! FuncionesGlobales::getErrorData("puntaje",$errors) !!}</p>
            </div>
        -->

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Concepto de la prueba <span>*</span></label>
            <div class="col-sm-12">
                {!! Form::textarea("resultado",null,["class"=>"form-control","id"=>"textarea"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("resultado",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Archivo <span>*</span></label>
            <div class="col-sm-8">
                {!! Form::file("nombre_archivo",["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_archivo",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Estado <span>*</span></label>
            <div class="col-sm-8">
                {!! Form::select("estado",[""=>"Seleccionar","1"=>"Apto","2"=>"No apto","3"=>"Pendiente"],null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado",$errors) !!}</p>
        </div>
         <div class="col-sm-6 col-sm-offset-6" style="background-color: #fdf06a; padding: .5em;">
        <div class="form-group">
            <label for="trabajo-empresa-temporal" class="col-md-5 control-label">Prueba definitiva:</label>
            <div class="col-md-7">
                {!! Form::checkbox("definitiva",1,1,["class"=>"checkbox-preferencias" ]) !!}

            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("apto",$errors) !!}</p>
    </div>


        <div class="clearfix"></div>

    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success"  id="guardar_nueva_prueba" >Guardar</button>
    </div>

    <script>
        $(function () {
            //$("textarea").jqte();
            $("#fecha_vencimiento").datepicker(confDatepicker);
        });
    </script>
    
{!! Form::close() !!}