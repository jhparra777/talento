<div class="panel panel-default" style="border-radius: 0 1rem 1rem 1rem;">
    <div class="panel-body">
        <div class="col-sm-12 col-md-5 mb-2">
            <h4 class="tri-fs-14">CANDIDATOS VINCULADOS AL REQUERIMIENTO</h4>
        </div>

        <div class="col-sm-12 col-md-7 mb-2">
            {{-- Campo para buscar por cédula --}}
            @include('admin.reclutamiento.includes.gestion-requerimiento._input_search_candidates')
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover text-center" id="table_with_users" style="width: 100%;">
                    <thead>
                        <tr>
                            <th data-field="checkes">
                                {!! Form::checkbox("seleccionar_todos_candidatos_vinculados", null, false, [
                                    "id" => "seleccionar_todos_candidatos_vinculados",
                                    'form' => "fr_candidatos"
                                ])!!}
                            </th>

                            <th data-field="numero_id">NUMERO ID</th>

                            <th data-field="nombres">NOMBRES</th>

                            <th data-field="movil">MÓVIL</th>

                            <th data-field="estado" style="width: 8%;">ESTADO</th>

                            <th data-field="hv">%HV</th>

                            <th data-field="trazabilidad" style="width: 200px;">TRAZABILIDAD</th>

                            @if(route("home") == "https://komatsu.t3rsc.co")
                                <th data-field="interno">INTERNO</th>
                            @endif

                            <th data-field="procedimiento">PROCEDIMIENTO</th>
                        </tr>
                    </thead>

                    <tbody id="candidatos-vinculados-list">
                        @foreach($candidatos_req as $candidato_req)
                            <?php $transferido = null;
                                $processes_collect = collect($candidato_req->procesos);
                                $processes = $processes_collect->pluck("proceso")->toArray();
                                $processes_apto = $processes_collect->where('apto', '1')->pluck("proceso")->toArray();
                             ?>
                            @if($candidato_req->estado_candidatos == "TRANSFERIDO" || $candidato_req->estado_candidatos == "BAJA VOLUNTARIA")
                                <?php $transferido = true; ?>
                            @endif

                            <tr
                                @if($candidato_req->important == 1 and $candidato_req->estado_candidatos != "CONTRATACION_CANCELADA")
                                    style="background: #f7fc9b;"
                                @endif

                                @if(!is_null($candidato_req->apto) && $candidato_req->apto == 0)
                                    style="background: #f5ad9d;"
                                @endif

                                @if($candidato_req->estado_candidatos == "TRANSFERIDO" || $candidato_req->estado_candidatos == "BAJA VOLUNTARIA")
                                    class="tri-gray-60"
                                @endif

                                @if($candidato_req->estado_candidatos == "CONTRATACION_CANCELADA")
                                    style="background: rgb(251,199,187);"
                                @endif
                            >
                                {{-- Checkbox --}}
                                <td>
                                    {!! Form::hidden("req_id", $requermiento->id, ['form' => "fr_candidatos"]) !!}

                                    @if($candidato_req->estado_candidatos != "TRANSFERIDO" && $candidato_req->estado_candidatos != "BAJA VOLUNTARIA")
                                        <input 
                                            class="check_candi" 
                                            data-candidato_req="{{ $candidato_req->req_candidato_id }}" 
                                            data-cliente="{{ $cliente->id }}" 
                                            name="req_candidato[]" 
                                            type="checkbox" 
                                            value="{{ $candidato_req->req_candidato_id }}" 
                                            @if($boton) disabled @endif 
                                            form="fr_candidatos"
                                        >
                                    @endif

                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("numero_candidato", $errors) !!}
                                    </p>
                                </td>

                                {{-- Número de documento --}}
                                <td>
                                    <b>{{ $candidato_req->numero_id }}</b>
                                </td>

                                {{-- Nombre completo --}}
                                <td>
                                    {{ mb_strtoupper($candidato_req->nombres ." ".$candidato_req->primer_apellido." ".$candidato_req->segundo_apellido) }}
                                </td>

                                {{-- Número de celular --}}
                                <td>
                                    {{ $candidato_req->telefono_movil }}

                                    {{-- Boton de whatsapp --}}
                                    <div class="mt-1">
                                        @if($user_sesion->hasAccess("boton_ws"))
                                            <a 
                                                class="btn btn-success | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-green" 

                                                @if($boton || isset($transferido))
                                                    href="#"
                                                    disabled
                                                @else
                                                    target="blank" 
                                                    href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!}{{ $candidato_req->telefono_movil}}&text=Hola!%20{{$candidato_req->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección."
                                                @endif

                                                data-toggle="tooltip"
                                                data-placement="top"
                                                data-container="body"
                                                title="Enviar mensaje a tráves de Whatsapp"
                                            >
                                                <i class="fab fa-whatsapp tri-fs-14" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>

                                {{-- Estado del candidato --}}
                                <td>
                                    {{-- @if(route("home") == "https://komatsu.t3rsc.co")
                                        {{ ($candidato_req->estado_candidatos == 'EVALUACION DEL CLIENTE') ? 'ENVIADO COORDINADORA SELECCION' : $candidato_req->estado_candidatos }}
                                    @else
                                        {{ $candidato_req->estado_candidatos }}
                                    @endif --}}

                                    {{-- @if($candidato_req->llamada_id == null)
                                        -
                                    @elseif($candidato_req->llamada_id != null && $candidato_req->asis === null && $candidato_req->modulo_llamada == 1)
                                        <hr style="background-color: #f39c12; height: 5px; margin-top: 1px; margin-bottom: 1px;">
                                    @elseif($candidato_req->llamada_id != null && $candidato_req->asis == 0 && $candidato_req->modulo_llamada == 1)
                                        <hr style="background-color: #dd4b39; height: 5px; margin-top: 1px; margin-bottom: 1px;">
                                    @elseif($candidato_req->llamada_id != null && $candidato_req->asis == 1 && $candidato_req->modulo_llamada == 1)
                                        <hr style="background-color: #51beb1; height: 5px; margin-top: 1px; margin-bottom: 1px;">
                                    @endif --}}

                                    <?php
                                        if($candidato_req->llamada_id == null) {
                                            $estado_vinculado_bg = 'tri-gray-400';
                                            $estado_vinculado_icon = 'fa-minus';

                                        }elseif($candidato_req->llamada_id != null && $candidato_req->asis === null && $candidato_req->modulo_llamada == 1) {
                                            $estado_vinculado_bg = 'tri-d-yellow';
                                            $estado_vinculado_icon = 'fa-minus';

                                        }elseif($candidato_req->llamada_id != null && $candidato_req->asis == 0 && $candidato_req->modulo_llamada == 1) {
                                            $estado_vinculado_bg = 'tri-red';
                                            $estado_vinculado_icon = 'fa-times';

                                        }elseif($candidato_req->llamada_id != null && $candidato_req->asis == 1 && $candidato_req->modulo_llamada == 1) {
                                            $estado_vinculado_bg = 'tri-blue-2';
                                            $estado_vinculado_icon = 'fa-check';
                                        }
                                    ?>

                                    {{-- Chip trazabilidad --}}
                                    <div class="md-chips">
                                        <div class="md-chip">
                                            <div class="md-chip-icon | {{ $estado_vinculado_bg }}">
                                                <i class="fas {{ $estado_vinculado_icon }}" aria-hidden="true"></i>
                                            </div>

                                            {{ route("home") == "https://komatsu.t3rsc.co" ? ($candidato_req->estado_candidatos == 'EVALUACION DEL CLIENTE' ? 'ENVIADO COORDINADORA SELECCION' : $candidato_req->estado_candidatos) : $candidato_req->estado_candidatos }}
                                        </div>
                                    </div>

                                    @if($candidato_req->estado_candidatos == "TRANSFERIDO")
                                        <span>
                                            REQ <i class="fas fa-chevron-right | tri-fs-10 tri-txt-gray-600"></i> <b>{{ $candidato_req->transferido }}</b>
                                        </span>
                                    @endif
                                </td>

                                {{-- Porcentaje HV --}}
                                <td>
                                    <?php $porcentaje = FuncionesGlobales::porcentaje_hv($candidato_req->candidato_id); ?>
                                    @if($porcentaje != null && isset($porcentaje["total"]) )
                                        {{$porcentaje['total'] }}%
                                    @else
                                        5%
                                    @endif
                                </td>

                                {{-- Trazabilidad candidato --}}
                                <td id="trazabilidad-{{ $candidato_req->req_candidato_id }}">
                                    @include('admin.reclutamiento.includes.gestion-requerimiento._section_trazabilidad_gestion', ["procesos" => $candidato_req->procesos])
                                </td>

                                {{-- Interno komatsu --}}
                                @if(route("home") == "https://komatsu.t3rsc.co")
                                    <td>
                                        {{-- boton si es interno --}}
                                        @if($candidato_req->trabaja != 0)
                                            <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>
                                        @endif
                                    </td>
                                @endif

                                {{-- Procedimientos --}}
                                <td>
                                    {{-- @if($candidato_req->estado_candidatos != "TRANSFERIDO") --}}
                                        {{-- Boton de Status --}}
                                        @if($user_sesion->hasAccess("admin.seguimiento_candidato"))
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-primary | tri-br-2 tri-fs-12 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-300 tri-hover-out-gray"
                                                id="mostrarSeguimiento"

                                                data-req_id="{{ $requermiento->id }}"
                                                data-cliente="{{ $cliente->id }}"
                                                data-candidato_id="{{ $candidato_req->candidato_id }}"
                                                data-candidato_req="{{ $candidato_req->req_candidato_id }}"
                                            >
                                                ESTATUS
                                            </button>
                                        @endif
                                        
                                        {{-- INFORMACIÓN --}}
                                        @include('admin.reclutamiento.includes.gestion-requerimiento._button_informacion_vinculado_gestion')

                                        {{-- PROCESO --}}
                                        @include('admin.reclutamiento.includes.gestion-requerimiento._button_proceso_vinculado_gestion')

                                        {{-- VERIFICACIÓN --}}
                                        @include('admin.reclutamiento.includes.gestion-requerimiento._button_verificacion_vinculado_gestion')

                                        {{-- ACCIÓN --}}
                                        @include('admin.reclutamiento.includes.gestion-requerimiento._button_accion_vinculado_gestion')
                                    {{-- @endif --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Este form close cierra el form que esta en el asistente virtual --}}
            {!!Form::close()!!}
        </div>
    </div>
</div>