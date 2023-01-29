<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Gestionar referencia</h4>
</div>

<div class="modal-body">
    {!! Form::model($req,["id"=>"fr_referencia"]) !!}
    {!! Form::hidden("ref_verificada") !!}
    {!! Form::hidden("ref_id") !!}
    {!! Form::hidden("experiencia_id",$experiencia->id) !!}
    <h4 class="titulo1">Informacion suministrada por el candidato</h4>
    <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
        <tr>
            <th>Nombre Empresa</th>
            <td>{{$experiencia->nombre_empresa}}</td>
            <th>Teléfono Empresa</th>
            <td>{{$experiencia->telefono_temporal}}</td>
        </tr>
        <tr>
            <th>Ciudad</th>
            <td>{{$experiencia->ciudades}}</td>
            <th>Cargo Desempeñado</th>
            <td>{{$experiencia->desc_cargo}}</td>
        </tr>
        <tr>
            <th>Nombres Jefe</th>
            <td>{{$experiencia->nombres_jefe}}</td>
            <th>Cargo jefe</th>
            <td>{{$experiencia->cargo_jefe}}</td>
        </tr>
        <tr>
            <th>Teléfono móvil Jefe</th>
            <td>{{$experiencia->movil_jefe}}</td>
            <th>Teléfono fijo jefe</th>
            <td>{{$experiencia->fijo_jefe}}</td>
        </tr>
        <tr>
            <th>Trabajo Ingreso</th>
            <td>{{$experiencia->fecha_inicio}}</td>
            <th>Fecha Salida</th>
            <td>{{$experiencia->fecha_final}}</td>
        </tr>
        <tr>
            <th>Salario</th>
            <td>{{$experiencia->salario}}</td>
            <th>Motivo Retiro</th>
            <td>{{$experiencia->desc_motivo}}</td>
        </tr>
        <tr>
            <th>Funciones y logros</th>
            <td colspan="3">{{$experiencia->funciones_logros}}</td>

        </tr>
    </table>
    <h4 class="titulo1">Informacion adicional suministrada por el candidato </h4>
    <div class="row ">



        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Nombre del Referenciante</label>
            <div class="col-sm-8">
                {!! Form::text("nombre_referenciante",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Cargo del Referenciante</label>
            <div class="col-sm-8">
                {!! Form::text("cargo_referenciante",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_referenciante",$errors) !!}</p>
        </div>
        <div class="col-md-4 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Telefono Oficina </label>
            <div class="col-sm-8">
                {!! Form::text("telefono_oficina",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("telefono_oficina",$errors) !!}</p>
        </div>
        <div class="col-md-3 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Ext</label>
            <div class="col-sm-8">
                {!! Form::text("ext",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("ext",$errors) !!}</p>
        </div>
        <div class="col-md-5 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Celular</label>
            <div class="col-sm-8">
                {!! Form::text("celular",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("celular",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones Empresa:</label>
            <div class="col-sm-12">
                {!! Form::textarea("observaciones_empresa",null,["class"=>"form-control","rows"=>"2"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones_empresa",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones Candidato: </label>
            <div class="col-sm-12">
                {!! Form::textarea("observaciones_candidato",null,["class"=>"form-control","rows"=>"2"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones_candidato",$errors) !!}</p>
        </div>
    </div>
    
    <h4 class="titulo1">Tiempo laborado </h4>
    <div class="row">


        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Meses</label>
            <div class="col-sm-8">
                {!! Form::text("meses_laborados",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("meses_laborados",$errors) !!}</p>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Años</label>
            <div class="col-sm-8">
                {!! Form::text("anios_laborados",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("anios_laborados",$errors) !!}</p>
        </div>
    </div>
    <h4 class="titulo1"> Motivo de Retiro </h4>
    <div class="row">

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Motivo de Retiro: </label>
            <div class="col-sm-8">
                {!! Form::select("motivo_retiro_id",$motivo_retiro,null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("motivo_retiro_id",$errors) !!}</p>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones</label>
            <div class="col-sm-12">
                {!! Form::textarea("observaciones",null,["class"=>"form-control","rows"=>2]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
        </div>

    </div>

    <h4 class="titulo1">Evaluacion de Competencias</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Competencia</th>
                <th colspan="4">Deficiente</th>
                <th colspan="3">Aceptable</th>
                <th colspan="3">Adecuado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($competencias as $competencia)
            <tr>
                <td>{{$competencia->nombre}}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",1) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",2) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",3) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",4) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",5) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",6) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",7) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",8) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",9) !!}</td>
                <td>{!! Form::radio("competencia[$competencia->id]",10) !!}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label"> Tuvo personas a cargo: </label>
            <div class="col-sm-6">
                {!! Form::checkbox("personas_cargo","si",null,["class"=>"form-control checkbox-preferencias"]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("personas_cargo",$errors) !!}</p>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Cuantas? </label>
            <div class="col-sm-8">
                {!! Form::text("cuantas_personas",null,["class"=>"form-control "]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cuantas_personas",$errors) !!}</p>
        </div>
    </div>

    <h4 class="titulo1">Concepto Final</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label"> Volveria a contratarlo  </label>
            <div class="col-sm-6">
                {!! Form::checkbox("volver_contratarlo","si",null,["class"=>"form-control checkbox-preferencias"]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("volver_contratarlo",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label"> Por que </label>
            <div class="col-sm-12">
                {!! Form::textarea("porque_obj",null,["class"=>"form-control ","rows"=>2]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("porque_obj",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label"> Aspectos a mejorar </label>
            <div class="col-sm-12">
                {!! Form::textarea("aspectos_mejorar",null,["class"=>"form-control ","rows"=>2]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("aspectos_mejorar",$errors) !!}</p>
        </div>
    </div>
    <h4 class="titulo1">Información de Recursos Humanos</h4>
    <div class="row">
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Cargo desempeñado:  </label>
            <div class="col-sm-8">
                {!! Form::text("cargos2",null,["class"=>"form-control "]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargos2",$errors) !!}</p>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Inicio   </label>
            <div class="col-sm-8">
                {!! Form::text("fecha_inicio",null,["class"=>"form-control ","id"=>"fecha_inicio"]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio",$errors) !!}</p>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Retiro </label>
            <div class="col-sm-8">
                {!! Form::text("fecha_retiro",null,["class"=>"form-control ","id"=>"fecha_retiro"]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_retiro",$errors) !!}</p>
        </div>
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label"> Anotacion en la hoja de vida :   </label>
            <div class="col-sm-6">
                {!! Form::checkbox("anotacion_hv","si",null,["class"=>"form-control checkbox-preferencias"]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("anotacion_hv",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-6 control-label"> Cuales   </label>
            <div class="col-sm-12">
                {!! Form::textarea("cuales_anotacion",null,["class"=>"form-control ","rows"=>2]); !!}

            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cuales_anotacion",$errors) !!}</p>
        </div>
    </div>

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-6 control-label"> Tiene algún vínculo familiar con el candidato?</label>
        <div class="col-sm-6">
            {!! Form::checkbox("vinculo_familiar","si",null,["class"=>"form-control checkbox-preferencias"]); !!}

        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("vinculo_familiar",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-6 control-label"> Cuál: </label>
        <div class="col-sm-12">
            {!! Form::textarea("vinculo_familiar_cual",null,["class"=>"form-control ","rows"=>2]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("vinculo_familiar_cual",$errors) !!}</p>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-6 control-label"> Adecuado: </label>
        <div class="col-sm-12">
            {!! Form::select("adecuado",[""=>"Selecionar","adecuado"=>"Adecuado","no_adecuado"=>"No adecuado","ref_sin_exito"=>"Ref sin exito"],null,["class"=>"form-control "]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("adecuado",$errors) !!}</p>
    </div>
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-6 control-label">    	Estado de la referenciacion </label>
        <div class="col-sm-12">
            {!! Form::select("estado_referencia",[""=>"Selecionar","ref_completa"=>"Ref Completa","ref_sin_exito"=>"Ref sin exito","ref_solo"=>"Ref solo contrato"],null,["class"=>"form-control "]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("estado_referencia",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-6 control-label"> Observaciones generales de la ejecución de la referencia:  </label>
        <div class="col-sm-12">
            {!! Form::textarea("observaciones_referencias",null,["class"=>"form-control ","rows"=>2]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones_referencias",$errors) !!}</p>
    </div>
    <div class="clearfix"></div>
{!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success"  id="guardar_nueva_referencia" >Guardar</button>

</div>
<script>
    $(function(){
         $('.checkbox-preferencias').bootstrapSwitch();
    });
</script>