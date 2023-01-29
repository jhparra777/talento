<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><strong>Estatus del candidato</strong></h4>
</div>
{{-- NOTA: RECUERDE ESTE MODAL ES EL MISMO SE UTILIZA EN EL ASISTENTE ASI QUE UN CAMBIO AQUI VAYA AL 
    EVENTO DEL ASISTENTE PARA QUE FUNCIONE IGUAL --}}
<div  class="modal-body">
    <div class="row">
        @if ($token_firma != null || $token_firma != '')
            @if ($firma_contrato != null || $firma_contrato != '')
                <div class="col-md-12">
                    <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Código de acceso a la firma: <b>{{ $token_firma->codigo_validacion }}</b>
                    </div>
                </div>
            @endif
        @endif

        <div class="col-md-12">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist" style="border-bottom: none;">
                <li role="presentation" class="active">
                    <a class="tri-txt-d-gray" href="#tabEstadosCandidato" aria-controls="tabEstadosCandidato" role="tab" data-toggle="tab" style="border-radius: 1rem 1rem 0 0;">
                        <b><i class="fas fa-list-alt tri-fs-14"></i> Estados candidato</b>
                    </a>
                </li>

                <li role="presentation">
                    <a class="tri-txt-d-gray" href="#tabTrazabilidadCandidato" aria-controls="tabTrazabilidadCandidato" role="tab" data-toggle="tab" style="border-radius: 1rem 1rem 0 0;">
                        <b><i class="fas fa-list-alt tri-fs-14" aria-hidden="true"></i> Trazabilidad candidato</b>
                    </a>
                </li>

                <li role="presentation">
                    <a class="tri-txt-d-gray" href="#tabObservacionesHv" aria-controls="tabObservacionesHv" role="tab" data-toggle="tab" style="border-radius: 1rem 1rem 0 0;">
                        <b><i class="fas fa-sticky-note tri-fs-14" aria-hidden="true"></i> Observaciones hoja de vida</b>
                    </a>
                </li>
            </ul>
        
            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="tabEstadosCandidato">
                    @include('admin.reclutamiento.includes.seguimiento-candidato._section_estados_candidato')
                </div>

                <div role="tabpanel" class="tab-pane" id="tabTrazabilidadCandidato">
                    @include('admin.reclutamiento.includes.seguimiento-candidato._section_trazabilidad_seguimiento')
                </div>

                <div role="tabpanel" class="tab-pane" id="tabObservacionesHv">
                    @include('admin.reclutamiento.includes.seguimiento-candidato._section_observaciones_hv_seguimiento')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
</div>

<style>
    #mdialTamanio{ width: 80% !important; }
</style>