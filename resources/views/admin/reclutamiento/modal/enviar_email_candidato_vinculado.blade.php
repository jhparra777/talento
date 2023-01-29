<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
        Enviar Email al Candidato <strong>{{ $datos->nombres }}</strong>
    </h4>
</div>
<div class="modal-body">
    <div class="box box-info">
        <div class="box-header">
            <i class="fa fa-envelope">
            </i>
            <h3 class="box-title">
                Correo Electrónico Rápido
            </h3>
        </div>
        <div class="box-body">
            {!! Form::open(["id"=>"fr_email"]) !!}
                <div class="form-group">
                    {!! Form::email("emailto", $datos->email, ["class"=>"form-control", "disabled"=>"true"]) !!}
                    {!! Form::hidden("email", $datos->email) !!}
                    {!! FOrm::hidden("user_id", $datos->user_id) !!}
                </div>
                <div class="form-group">
                    {!! Form::text("asunto",null, ["class"=>"form-control", "placeholder"=>"Asunto"]) !!}
                </div>
                <div>
                    {!! Form::textarea("mensaje", null , ["class"=>"textarea", "placeholder"=>"Mensaje", "style"=>"width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"]) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button class="btn btn-default pull-left" data-dismiss="modal" type="button">
        Cerrar
    </button>
    <button class="btn btn-primary enviar_email_candidato" type="button">
        Enviar
        <i class="fa fa-arrow-circle-right">
        </i>
    </button>
</div>