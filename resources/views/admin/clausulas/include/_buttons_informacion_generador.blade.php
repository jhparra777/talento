<div class="col-md-2 mt-3">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Información a usar
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="list-group">
                    <button
                        type="button" class="list-group-item" id="flag_nombre_completo"
                        data-flag="{nombre_completo}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Nombre completo del candidato">Nombre completo</button>
                    <button
                        type="button" class="list-group-item" id="flag_nombres"
                        data-flag="{nombres}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Nombre del candidato">Nombres</button>
                    <button
                        type="button" class="list-group-item" id="flag_primer_apellido"
                        data-flag="{primer_apellido}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Primer apellido del candidato">Primer apellido</button>
                    <button
                        type="button" class="list-group-item" id="flag_segundo_apellido"
                        data-flag="{segundo_apellido}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Segundo apellido del candidato">Segundo apellido</button>
                    <button
                        type="button" class="list-group-item" id="flag_cedula"
                        data-flag="{cedula}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Cédula del candidato">Cédula</button>
                    <button
                        type="button" class="list-group-item" id="flag_direccion"
                        data-flag="{direccion}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Dirección del candidato">Dirección</button>
                    <button
                        type="button" class="list-group-item" id="flag_celular"
                        data-flag="{celular}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Celular del candidato">Celular</button>
                    <button
                        type="button" class="list-group-item" id="flag_firma"
                        data-flag="{fecha_firma}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Día que firma el candidato">Fecha firma</button>
                    <button
                        type="button" class="list-group-item" id="flag_fecha_ingreso"
                        data-flag="{fecha_ingreso}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Fecha de ingreso">Fecha ingreso</button>
                    <button
                        type="button" class="list-group-item" id="flag_cargo_ejerce"
                        data-flag="{cargo_ejerce}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Cargo a ejercer">Cargo a ejercer</button>
                    <button
                        type="button" class="list-group-item" id="flag_empresa_usuaria"
                        data-flag="{empresa_usuaria}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Empresa usuaria">Empresa usuaria</button>
                    <button
                        type="button" class="list-group-item" id="flag_tipo_documento"
                        data-flag="{tipo_documento}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Tipo de Documento">Tipo documento</button>
                    <button
                        type="button" class="list-group-item" id="flag_ciudad_oferta"
                        data-flag="{ciudad_oferta}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Ciudad de Oferta (Requerimiento)">Ciudad oferta</button>
                    <button
                        type="button" class="list-group-item" id="flag_ciudad_contrato"
                        data-flag="{ciudad_contrato}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Ciudad firma contrato">Ciudad firma contrato</button>
                    <button
                        type="button" class="list-group-item" id="flag_empresa_contrata"
                        data-flag="{empresa_contrata}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Empresa que gestiona">Empresa gestiona / Sociedad</button>
                    <button
                        type="button" class="list-group-item" id="flag_salario"
                        data-flag="{salario_asignado}"
                        onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                        data-toggle="tooltip" data-placement="top" title="Salario asignado">Salario asignado</button>
                </div>
            </div>
        </div>

        @if (FuncionesGlobales::sitioModuloStatic()->generador_variable == 'enabled')
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Información variable
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="list-group">
                        <button
                            type="button" class="list-group-item" id="flag_valor_variable"
                            data-flag="{valor_variable}"
                            onclick="document.querySelector('#contenido_clausula').focus(); addFlag(this)"
                            data-toggle="tooltip" data-placement="top" title="Valor rodamiento">Valor variable</button>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>