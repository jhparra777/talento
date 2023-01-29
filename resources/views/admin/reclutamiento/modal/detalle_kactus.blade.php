<div class="modal-header">
 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"> Detalle de dotación : <strong> Por favor ingrese el número de req kactus</strong> </h4>
</div>
 <div class="modal-body">
  {!! Form::open(["id"=>"fr_kactus"]) !!}
  {!! Form::hidden("req",null,["id"=>"req"])!!}

   {!!Form::text("id_kactus",($kactus)?$kactus:"",["class"=>"form-control solo-numero","placeholder"=>"numero Kactus","id"=>"id_kactus" ]);!!}

  {!! Form::close() !!}

  <div class="clearfix"></div>
 </div>
<div class="modal-footer">
  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
  <button type="button" class="btn btn-success" id="confirmar_kactus" >Confirmar</button>
</div>
