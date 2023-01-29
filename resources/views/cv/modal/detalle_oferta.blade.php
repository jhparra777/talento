{!! Form::open(["id"=>"fr_oferta_modal"]) !!}
{!! Form::hidden("id",$detalle_oferta->id) !!}
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Oferta</h4>
</div>
<div class="modal-body">
    
    @if($ofertaAplicada->count() > 0    )
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Ya!</strong> aplicaste para esta oferta.
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Cod. Oferta</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->id}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Empresa</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->empresa()->nombre}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Ciudad</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->getUbicacion()->ciudad}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Cargo</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->cargo()->descripcion}}</div>
    </div>

    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Fecha Publicación</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->created_at}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Años experiencia</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->tipo_experiencia()->descripcion}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Jornada </div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->jornada()->descripcion}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Cantidad Vacantes</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->num_vacantes}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Descripción</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->descripcion_oferta}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Salario</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">
            @if($detalle_oferta->mostrar_salario == 1)
            {{number_format($detalle_oferta->salario)}}
            @else
            A convenir
            @endif

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger-t3" data-dismiss="modal">Cerrar</button>
    @if($ofertaAplicada->count() == 0    )
    <button type="button" class="btn btn-primario" id="aplica_oferta_modal">Aplicar</button>
    @endif
</div>
{!! Form::close() !!}