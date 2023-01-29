@if($user_sesion->hasAccess("llamada_virtual"))
        <div class="col-md-1">
            {!! Form::model(Request::all(), ["route" => ["llamada_virtual"], "id" => "fr_candidatos", "method" => "GET", "style" => "float: left; margin-right: 5px;"]) !!}
            <div id="bloque_candidatos_llamar"></div>

            <button 
                type="button" 
                id="llamada_virtual"
                class="btn | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300"

                data-toggle="tooltip"
                data-placement="top"
                data-container="body"
                title="Asistente virtual"
                >
                <i class="fa fa-phone tri-fs-16"></i> {{-- Asistente virtual --}}
            </button>
            {!! Form::hidden("modulo", "contratacion") !!}
            {!! Form::close() !!}
        </div>
@endif