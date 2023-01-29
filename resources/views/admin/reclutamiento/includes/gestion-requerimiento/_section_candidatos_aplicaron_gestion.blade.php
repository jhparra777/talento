<div class="panel panel-default">
    <div class="panel-body">
        <div class="col-sm-12 col-md-12 mb-1">
            <h4 class="tri-fs-14">CANDIDATOS APLICARON AL REQUERIMIENTO</h4>
        </div>

        <div class="col-md-12 text-right mb-1">
            @if($preguntas_req != 0)
                <button
                    type="button"
                    data-cargo_id="{{ $requermiento->cargo_id }}"
                    data-req="{{ $requermiento->id }}"
                    class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue"
                    id="ver_ranking"
                >
                    <i class="fa fa-users" aria-hidden="true"></i> Ver ranking ajuste de perfil
                </button>

                <button
                    type="button"
                    data-cargo_id="{{ $requermiento->cargo_id }}"
                    data-req="{{ $requermiento->id }}"
                    class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-blue tri-bg-white tri-bd-blue tri-transition-300 tri-hover-out-blue"
                    id="ver_respuestas"
                >
                    <i class="fa fa-question-circle" aria-hidden="true"></i> Ver Respuestas
                </button>
            @endif
        </div>

        <div class="col-md-3 col-md-offset-8 mb-2">
            <input 
                name="filtro" 
                class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                placeholder="Filtrar candidatos" 
                type="text" 
                id="filtro-aplicaron">
        </div>

        <div class="col-md-1 mb-2">
            <a 
                class="btn btn-sm btn-default | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
                id="filtrar-aplicaron" 
                title="Filtrar" 
                data-refresh="0" 
                data-req="{{ $requermiento->id }}" 
                data-toggle="filtrar">
                FILTRAR
            </a>

            <a 
                class="btn btn-sm btn-default | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray" 
                id="filtrar-aplicaron" 
                title="Refrescar" 
                data-refresh="1" 
                data-req="{{ $requermiento->id }}" 
                data-togglele="filtrar">
                <i class="fas fa-redo-alt"></i>
            </a>
        </div>

        <div class="col-md-12 mb-2">
            {!! Form::open(["route" => "admin.agregar_candidato_aplicados", "method" => "post"]) !!}
                <input name="requerimiento_id" type="hidden" value="{{ $requermiento->id }}" id="req_id_section_postulados">

                <table class="table table-hover table-striped tabla_aplicaron text-center">
                    <thead>
                        <th style="width: 5px">
                            {!! Form::checkbox("seleccionar_todos_candidatos_apli", null, false, [
                                "id" => "seleccionar_todos_candidatos_apli"
                            ]) !!}
                        </th>

                        <th style="width: 10px">IDENTIFICACIÓN</th>
                        <th style="width: 30px">NOMBRES</th>
                        <th style="width: 10px">MÓVIL</th>
                        <th style="width: 10px">ESTADO CANDIDATO</th>
                         <th style="width: 10px">FECHA</th>

                        <th style="width: 20px">HOJA DE VIDA /VIDEO PERFIL / WHATSAPP/</th>
                    </thead>

                    <tbody id="incluir_aplicaron"></tbody>
                </table>

                <div id="boton_agregar_aplicados" style="display: none;">
                    @if($user_sesion->hasAccess("admin.agregar_candidato_aplicados"))
                        @if(!in_array($estado_req->estados_req, [
                            config("conf_aplicacion.C_VENTA_PERDIDA"),
                            config("conf_aplicacion.C_ELIMINADO"),
                            config("conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL"),
                            config("conf_aplicacion.C_TERMINADO")
                        ]))
                            <button 
                                type="button"
                                id="add_requerimiento_postulados" 
                                class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-d-yellow tri-bg-white tri-bd-d-yellow tri-transition-300 tri-hover-out-d-yellow" 
                            >
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar candidatos seleccionados
                            </button>
                        @endif
                    @endif
                </div>
            {!! Form::close() !!} 
        </div>
    </div>
</div>