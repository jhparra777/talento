<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">
        <span class="fa fa-briefcase "></span> Detalle Oferta
    </h4>
</div>

<div class="modal-body">
    @if($oferta->count() > 0)
        <div class="alert alert-warning">
            <p>Ya has aplicado a esta oferta.</p>
        </div>
    @else
        <div class="alert alert-success">
            <p>Has aplicado con éxito a esta oferta.</p>
        </div>
    @endif
    
    <div class="row">
        <div class="col-md-12">
            <h3><b>{{ $requerimientos->cargo_req() }}</b></h3>
        </div>
    </div>

    <hr>

    @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")

        {{-- <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label"><b>Localización:</b></label>
            <div class="col-sm-12">
                {{$requerimientos->ciudad_seleccionada}}

            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-3 control-label"><b>Tipo de experiencia :</b></label>
                
                <div class="col-sm-9">
                    {!! $requerimientos->tipo_experiencia !!}
                </div>
            </div>
        --}}

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label"><b>Descripción:</b></label>
            <div class="col-sm-12">
                {!! $requerimientos->descripcion_oferta !!}
            </div>
        </div>
    @else
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label"><b>Localización:</b></label>
            <div class="col-sm-12">

                 @if(route('home') == "http://soluciones.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co" )
                {{$requerimientos->getUbicacion()}}

                @else
                    {{ $requerimientos->ciudad_seleccionada }}
                @endif
            </div>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label"><b>Tipo de experiencia:</b></label>
            <div class="col-sm-9">

                @if(route('home') == "http://soluciones.t3rsc.co" || route('home') == "https://soluciones.t3rsc.co" )
                {{ $requerimientos-> experiencia_req() }}

                @else
                    {!! $requerimientos->tipo_experiencia !!}
                @endif
            </div>
        </div>

        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-12 control-label"><b>Descripción:</b></label>
            <div class="col-sm-12">
                {!! $requerimientos->descripcion_oferta !!}
            </div>
        </div>
    @endif
    
    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>