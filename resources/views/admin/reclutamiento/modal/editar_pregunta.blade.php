
<!-- Inicio contenido principal -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Editar Pregunta</h4>
</div>
<div class="modal-body">
    {!! Form::model(Request::all(),["id"=>"fr_editar_pregunta"]) !!}
    <div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-warning alert-dismissible" role="alert">

        <p>Aquí podrá editar la pregunta seleccionada</p>
        
    </div>
</div>
       
       <h3 style="text-align: center;">Pregunta</h3>
   <br>
 <div class="clearfix"></div> 
    <div class="col-md-12 form-group">
        <div class="col-sm-12">
            {!! Form::text("descripcion",$pregunta_entre->descripcion,["class"=>"form-control","id"=>"descripcion","placeholder"=>"Escriba su pregunta"]); !!}
            {!! Form::hidden("pregu_id",$pregunta_entre->id) !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>
    </div>
   


    

    <div class="clearfix"></div>

    <br><br>
  
   
       

    <div class="clearfix"></div>
    {!! Form::close() !!}
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="actualizar_pregunta" >Guardar</button>

</div>
