<div class="modal" id="modal_confirme">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header alert-info">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
        </div>
           {!! Form::open(["route"=>"admin.transferir_dato"]) !!}
              <div class="modal-body" id="texto">
            {!! Form::hidden("req_id","",null,["id"=>"nuevo_req"])!!}

              </div>
            {!! Form::close() !!}
              <div class="modal-footer">
              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->