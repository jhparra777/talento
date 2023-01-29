<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Gestionar referencia</h4>
</div>

<div class="modal-body">
    {!! Form::model($referencia,["id"=>"fr_referencia"]) !!}
    {!! Form::hidden("ref_id") !!}
    {!! Form::hidden("ref_verificada") !!}
    {!! Form::hidden("referencia_personal_id",$referencias_personales->id) !!}
    <h4 class="titulo1">Informacion suministrada por el candidato</h4>
    <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
        <tr>
            <th>Nombres</th>
            <td>{{$referencias_personales->nombres}}</td>
            <th>Primer Apellido</th>
            <td>{{$referencias_personales->primer_apellido}}</td>
        </tr>
        <tr>
            <th>Segundo Apellido</th>
            <td>{{$referencias_personales->segundo_apellido}}</td>
            <th>Tipo relación</th>
            <td>{{$referencias_personales->relacion}}</td>
        </tr>
        <tr>
            <th>Teléfono Móvil</th>
            <td>{{$referencias_personales->telefono_movil}}</td>
            <th>Teléfono Fijo</th>
            <td>{{$referencias_personales->telefono_fijo}}</td>
        </tr>
        <tr>
            <th>Ciudad</th>
            <td>{{$referencias_personales->ciudad_seleccionada}}</td>
            <th>Ocupación</th>
            <td>{{$referencias_personales->fijo_jefe}}</td>
        </tr>

    </table>
    <div class="clearfix"><br></div>
    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Encuestado :</label>
            <div class="col-sm-8">
                {!! Form::text("encuestado",null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Ante dificultades como reacciona? :</label>
            <div class="col-sm-8">
                
                {!! Form::select ("dificultades", config('conf_aplicacion.SELECT_REFERENCIACION.DIFICULTADES'),null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Cuales son sus mejores cualidades? :</label>
            <div class="col-sm-8">
                
                {!! Form::select ("cualidades", config('conf_aplicacion.SELECT_REFERENCIACION.MEJORAS.3'),null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> De que manera manifiesta su desacuerdo? :</label>
            <div class="col-sm-8">
                
                {!! Form::select ("desacuerdo", config('conf_aplicacion.SELECT_REFERENCIACION.DESACUERDO'),null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Que aspectos considera que debe mejorar? :</label>
            <div class="col-sm-8">
                
                {!! Form::select ("debe_mejorar", config('conf_aplicacion.SELECT_REFERENCIACION.MEJORAR'),null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Como describe sus relaciones interpersonales? :</label>
            <div class="col-sm-8">
                
                {!! Form::select ("relaciones_interpersonales", config('conf_aplicacion.SELECT_REFERENCIACION.INTERPERSONALES'),null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
        </div>
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones :</label>
            <div class="col-sm-12">
                
                {!! Form::textarea ("observaciones", null,["class"=>"form-control"]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_referenciante",$errors) !!}</p>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success"  id="guardar_nueva_referencia_personal" >Guardar</button>

</div>