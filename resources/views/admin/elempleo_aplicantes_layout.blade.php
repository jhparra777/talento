<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title">CANDIDATOS APLICARON A LA OFERTA</h3>
        <img src="{{ asset('img/ee_logo.png') }}" alt="EE Logo" width="80">
    </div>

    <div class="box-body table-responsive no-padding">
        {!! Form::open(["route" => "admin.agregar_candidato_aplicados_ee", "method" => "post", "id" => "add_ee_candidates"]) !!}
            <input name="requerimiento_id" type="hidden" value="{{ $req_id }}" id="req_id_section_aplicacion_ee">
            
            <table class="table table-bordered table-hover" id="table_with_ee">
                <thead>
                    <tr>
                        <th data-field="checkes" style="width: 5px">
                            {!! Form::checkbox("select_apply_ee", null, false, ["id" => "select_apply_ee"]) !!}
                        </th>
                        <th data-field="identificacion" style="width: 10px">IDENTIFICACIÓN</th>
                        <th data-field="nombres" style="width: 30px">NOMBRES</th>
                        <th data-field="nombres" style="width: 10px">MÓVIL</th>
                        <th data-field="estado_candidato" style="width: 10px">ESTADO CANDIDATO</th>
                        <th data-field="hv_whatsapp" style="width: 20px">HOJA DE VIDA / WHATSAPP</th>
                    </tr>
                </thead>

                @if (count($candidatos_aplicados_ee) <= 0)
                    <tbody>
                        <tr>
                            <td colspan="6">No se encontraron candidatos.</td>
                        </tr>
                    </tbody>
                @endif

                <tbody>
                    @foreach ($candidatos_aplicados_ee as $sape)
                        <tr>
                            <td><input name="apply_candidates_ee[]" type="checkbox" value="{{ $sape['user_id'] }}"></td>
                            <td>{{ $sape->numero_id }}</td>
                            <td>{{ $sape->nombres }} {{ $sape->primer_apellido }}</td>
                            <td>{{ $sape->telefono_movil }}</td>
                            <td>{{ $sape->getEstado() }}</td>
                            <td>
                                <a class="btn btn-info" href="{{ route('admin.hv_pdf', ['id' => $sape['user_id'] ]) }}" target="_blank">
                                    <i class="fa fa-file-pdf-o"></i>
                                </a>

                                <a
                                    class="btn btn-sm btn-success aplicar_oferta"
                                    href="https://api.whatsapp.com/send?phone={!! env('INDICATIVO','57') !!} {{ $sape->telefono_movil }}&text=Hola!%20{{ $sape->nombres }} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{ $sitio->nombre }},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección." target="_blank">
                                    <span aria-hidden="true" class="fa fa-whatsapp fa-lg"></span>
                                </a>
                            </td>
                            {{--<td><button type="button" id="info_ee" onclick="getInfo({{ $perro[$i]->ResumeeId }})">Más Info</button></td>--}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

            @if (count($candidatos_aplicados_ee) > 0)
                @if($user_sesion->hasAccess("admin.agregar_candidato_aplicados_ee"))
                    @if(!in_array($estado_req->estados_req, [
                            config("conf_aplicacion.C_VENTA_PERDIDA"),
                            config("conf_aplicacion.C_ELIMINADO"),
                            config("conf_aplicacion.C_CERRADO_POR_CUMPLIMIENTO_PARCIAL"),
                            config("conf_aplicacion.C_TERMINADO")
                        ]
                    ))
                        <button class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-d-yellow tri-bg-white tri-bd-d-yellow tri-transition-300 tri-hover-out-d-yellow" type="button" id="btn_add_ee_candidates">
                            <i class="fas fa-plus" aria-hidden="true"></i> Agregar candidatos seleccionados
                        </button>
                    @endif
                @endif
            @endif
    </div>
        {!! Form::close() !!}    
</div>