<div class="modal-header">
 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
   <h4 class="modal-title"> Detalle de dotación : <strong> Por favor introduzca la dotación que tendran estos trabajadores </strong> </h4>
</div>
 <div class="modal-body">
  {!! Form::open(["id"=>"fr_dotacion"]) !!}
  {!! Form::hidden("req",null,["id"=>"req"])!!}

   {!!Form::text("detalle_dotacion",($dotacion)?$dotacion:"",["class"=>"form-control","placeholder"=>"detalle dotacion","id"=>"detalle_dotacion" ]);!!}

  {!! Form::close() !!}

  <div class="clearfix"></div>
 </div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="button" class="btn btn-success" id="confirmar_dotacion" >Confirmar</button>
</div>
