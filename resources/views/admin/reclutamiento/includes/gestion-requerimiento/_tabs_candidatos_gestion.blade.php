<div class="col-md-12">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist" style="border-bottom: none;">
        <li role="presentation" class="active">
            <a class="tri-txt-d-gray" href="#tabCandidatosVinculados" aria-controls="tabCandidatosVinculados" role="tab" data-toggle="tab" style="border-radius: 1rem 1rem 0 0;">
                <b><i class="fas fa-users tri-fs-14"></i> Candidatos vinculados</b>
            </a>
        </li>

        <li role="presentation">
            <a class="tri-txt-d-gray" href="#tabCandidatosOtrasFuentes" aria-controls="tabCandidatosOtrasFuentes" role="tab" data-toggle="tab" style="border-radius: 1rem 1rem 0 0;">
                <b><i class="fas fa-user-plus tri-fs-14" aria-hidden="true"></i> Candidatos otras fuentes</b>
            </a>
        </li>

        <li role="presentation">
            <a class="tri-txt-d-gray" href="#tabCandidatosPreperfilados" aria-controls="tabCandidatosPreperfilados" role="tab" data-toggle="tab" style="border-radius: 1rem 1rem 0 0;">
                <b><i class="fas fa-user tri-fs-14" aria-hidden="true"></i> Candidatos preperfilados</b>
            </a>
        </li>

        <li role="presentation">
            <a class="tri-txt-d-gray" href="#tabCandidatosAplicaron" aria-controls="tabCandidatosAplicaron" role="tab" data-toggle="tab" style="border-radius: 1rem 1rem 0 0;">
                <b><i class="fas fa-user tri-fs-14" aria-hidden="true"></i> Candidatos aplicaron</b>
            </a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        {{-- Candidatos vínculados al requerimiento --}}
        <div role="tabpanel" class="tab-pane active" id="tabCandidatosVinculados">
            @include('admin.reclutamiento.includes.gestion-requerimiento._section_candidatos_vinculados_gestion')
        </div>

        <div role="tabpanel" class="tab-pane" id="tabCandidatosOtrasFuentes">
            @include('admin.reclutamiento.includes.gestion-requerimiento._section_candidatos_otras_fuentes_gestion')
        </div>

        <div role="tabpanel" class="tab-pane" id="tabCandidatosPreperfilados">
            @include('admin.reclutamiento.includes.gestion-requerimiento._section_candidatos_preperfilados_gestion')
        </div>

        <div role="tabpanel" class="tab-pane" id="tabCandidatosAplicaron">
            @include('admin.reclutamiento.includes.gestion-requerimiento._section_candidatos_aplicaron_gestion')
        </div>
    </div>
</div>