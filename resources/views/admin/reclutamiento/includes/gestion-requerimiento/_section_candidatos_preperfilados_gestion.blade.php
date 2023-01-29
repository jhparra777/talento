<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-12 col-md-12 mb-1">
            <h4 class="tri-fs-14">CANDIDATOS PREPERFILADOS AL CARGO
        </div>

        <input name="requerimiento_id" type="hidden" value="{{ $requermiento->id }}" id="req_id_section_preperfilados">
        <div class="col-md-3 col-md-offset-8 mb-2">
            <input 
                name="filtro" 
                class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"
                placeholder="Filtrar candidatos" 
                type="text" 
                id="filtro-hv">
        </div>

        <div class="col-md-1 mb-2">
            <a 
                class="btn btn-sm btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
                id="filtrar-hv" 
                title="Filtrar" 
                data-refresh="0" 
                data-req="{{ $requermiento->id }}" 
                data-toggle="filtrar">
                FILTRAR
            </a> 

            <a 
                class="btn btn-sm btn-default | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" 
                id="filtrar-hv" 
                title="Refrescar" 
                data-refresh="1" 
                data-req="{{ $requermiento->id }}" 
                data-toggle="filtrar">
                <i class="fas fa-redo-alt"></i>
            </a>
        </div>

        <div class="col-md-12">            
            <div id="incluir"></div>
        </div>
    </div>
</div>