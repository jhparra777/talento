
    <div class="col-md-1">
        {!! Form::model(Request::all(), ["route" => ["admin.gestion_documental.download_carpeta"], "id" => "fr_candidatos", "method" => "GET"]) !!}
                {!! Form::hidden("modulo", "seleccion") !!}

                <div id="bloque_candidatos_descargar"></div>
        {!! Form::close() !!}
        <a
            class="btn | tri-circle-btn tri-gray-100 tri-txt-gray-700 hover-bd-gray-400 tri-transition-300"
            
            target="_blank"

            data-toggle="tooltip"
            data-placement="top"
            data-container="body"
            title="Descargar"
            id="descarga_masiva"
        >
            <i class="fa fa-download tri-fs-16"></i>
        </a>
    </div>



