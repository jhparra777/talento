{!! Form::open(["id"=>"fr_oferta_modal"]) !!}
{!! Form::hidden("id",$detalle_oferta->id) !!}
<style type="text/css">
    .row{
        margin-bottom: .5em;
    }
</style>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Detalle de la oferta</h4>
</div>
<div class="modal-body">
    
    {{--@if($ofertarespondida->count() > 0    )
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <strong>Ya</strong> asociaste candidatos a esta oferta.
        </div>
    </div>
    @endif--}}
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Vencimiento</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->fecha_cierre_externo}} {{$detalle_oferta->hora_cierre_externo}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">HV $</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->precio_hv}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Cantidad</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->cantidad_hv}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Ciudad</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->getUbicacion()}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Cargo</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->getCargoEspecifico()->descripcion}}</div>
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
    {{--<div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Cantidad Vacantes</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->num_vacantes}}</div>
    </div>--}}
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Funciones</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{{$detalle_oferta->funciones}}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Descripción</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">{!! $detalle_oferta->descripcion_oferta !!}</div>
    </div>
    <div class="row">
        <div class="col-md-3 set-general-font-bold set-fondo-detalle">Salario</div>
        <div class="col-md-7 set-general-font set-fondo-detalle">
                {{number_format($detalle_oferta->salario)}}
           
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger-t3" data-dismiss="modal">Cerrar</button>
    
</div>
{!! Form::close() !!}