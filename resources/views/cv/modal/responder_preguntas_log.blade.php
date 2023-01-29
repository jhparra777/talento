<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">
        <span class="fa fa-briefcase "></span> Detalle Oferta
    </h4>
</div>

<div class="modal-body">
    @if($respuesta_pregunta_candidato->count() > 0)
        <div class="alert alert-success">
            <p> Muchas gracias por responder las preguntas, su aplicación ha sido exitosa.</p>
        </div>
    @else
        <div class="alert alert-success">
            <p>Antes de aplicar a la oferta responde las preguntas.</p>
        </div>
    @endif

    <div class="row">            
        <div class="col-md-12">
            <h3><b>{!! $detalle_oferta->nombre_cargo!!}</b></h3>
        </div>
    </div>

    <hr>

    @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")

    @else
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label"><b>Localizacion:</b></label>

            <div class="col-sm-12">
                {{ $detalle_oferta->ciudad_seleccionada }}
            </div>
        </div>
        
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label"><b>Tipo de experiencia:</b></label>

            <div class="col-sm-9">
                {!! $detalle_oferta->tipo_experiencia !!}
            </div>
        </div>
    @endif

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-12 control-label"><b>Descripcion:</b></label>
        
        <div class="col-sm-12">
            {!! $detalle_oferta->descripcion_oferta !!}
        </div>
    </div>

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    {{-- @if($respuesta_pregunta_candidato->count() > 0)
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @endif --}}
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>