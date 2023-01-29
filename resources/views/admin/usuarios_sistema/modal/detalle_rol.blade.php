<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Detalle Rol</h4>
</div>
<div class="modal-body">
    {!! Form::model($rol,["route"=>"admin.actualizar_rol","id"=>"frm_usuarios","method"=>"POST","autocomplete"=>"off"]) !!}

    {!! Form::hidden("id") !!}



    <div class="clearfix"></div>
    <div class="">
 
        <div class="col-md-12">
 
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-12">
                    {!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Nombre" ]); !!}
                </div>
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
            </div>
          
        </div>

        <div class="col-md-12">
            <h3>Permisos </h3>
            <div class="checkbox">
                <label>
                    {!! Form::checkbox("seleccionar_todos_admin",null,false,["id"=>"seleccionar_todos_admin"]) !!} Seleccionar todos
                </label>
            </div>

            {!! FuncionesGlobales::getPermisosAdmin(0,$rol->permissions) !!}
        </div>

        <div class="clearfix"></div>




    </div>
    {!! Form::close()    !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>