@if ($requermiento->IdJobOfferEE != null || !empty($requermiento->IdJobOfferEE))
    @if ($requermiento->consultaEE == 1)
        <div class="col-md-3 col-md-offset-5" id="btnLoadEE">
            {!! Form::hidden('IdJobOfferEE', $requermiento->IdJobOfferEE, ['id' => 'eeIdOffer']) !!}
            {!! Form::hidden('consultaEE', $requermiento->consultaEE, ['id' => 'consultaEE']) !!}
            {!! Form::hidden('reqId', $requermiento->id, ['id' => 'reqId']) !!}

            <button 
                type="button" 
                class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue" 
                id="loadCandidatesEE" 

                data-toggle="tooltip"
                data-placement="top"
                data-container="body"
                title="Usa esta función para cargar los candidatos que han aplicado a la oferta desde el portal de elempleo.com">
                Listar candidatos ElEmpleo
            </button>
        </div>

        <div class="col-md-12" id="applyBoxEE">
            <div class="loaderElement" id="preLoader">
                <p>
                    <img src="{{ asset("img/preloader_ee.gif") }}" width="40">
                </p>
                <p>Cargando ... no recargues esta página</p>
            </div>
        </div>
    @endif
@endif