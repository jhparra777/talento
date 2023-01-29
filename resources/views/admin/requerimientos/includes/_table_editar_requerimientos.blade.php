<div class="clearfix"></div>

<div class="tabla table-responsive">
    <table class="table table-bordered table-hover ">
        <thead>
            <tr> 
                <th># Req</th>
                <th>Cliente</th>
                <th>Cargo</th>
                <th>Tipo Proceso</th>
                <th># Vacantes</th>
                <th># Asociados</th>
                <th># Contratados</th>
                <th>Fecha Ingreso</th>
                <th>Fecha Cancelación</th>
                @if( $sitio->agencias )
                    <th>Agencia</th>
                @endif
                <th>Estado</th>
                <th>Acción/observaciones</th>
            </tr>
        </thead>

        <tbody>
            @if($requerimientos->count() == 0)
                <tr>
                    <td colspan="13">No se encontraron registros</td>
                </tr>
            @endif
                    
            @foreach($requerimientos as $requerimiento)
                <tr>
                    <td>{{ $requerimiento->id }}</td>
                    <td>{{ $requerimiento->nombre_cliente }}</td>
                    <td>{{ $requerimiento->cargo }}</td>
                    <td>{{ $requerimiento->tipo_proceso_desc }}</td>
                    <td>{{ $requerimiento->num_vacantes }}</td>
                    <td>{{ \App\Models\Requerimiento::countVacantesAsociados($requerimiento->id)  }}</td>
                    <td>{{ \App\Models\Requerimiento::countVacantesContratados($requerimiento->id)  }}</td>
                    <td>{{ $requerimiento->fecha_ingreso }}</td>
                    <td>{{ $requerimiento->fecha_retiro }}</td>
                    @if( $sitio->agencias )
                        <td>{{ $requerimiento->getUbicacion() }}</td>
                    @endif
                    <td>{{ $requerimiento->estadoRequerimiento()->estado_nombre }}</td>
                    <td>
                        @if(in_array($requerimiento->ultimoEstadoRequerimiento()->id, [
                            config("conf_aplicacion.C_EN_PROCESO_SELECCION"),
                            config("conf_aplicacion.C_EN_PROCESO_CONTRATACION"),
                            config("conf_aplicacion.C_EVALUACION_DEL_CLIENTE"),
                            config("conf_aplicacion.C_RECLUTAMIENTO")
                        ]))
                                            
                            @if($user_sesion->hasAccess("admin.estados_requerimiento") && (isset($modulo) && $modulo == 'admin'))
                                <button
                                    class="btn btn-danger estados_requerimiento btn-block"
                                    data-req="{{ $requerimiento->id }}">
                                    Estado
                                </button>
                            @endif

                        @elseif($requerimiento->ultimoEstadoRequerimiento()->id == config("conf_aplicacion.C_TERMINADO"))

                        @elseif($requerimiento->ultimoEstadoRequerimiento()->observaciones == "")
                            No tiene observaciones
                        @else
                            {{ str_limit($requerimiento->ultimoEstadoRequerimiento()->observaciones ,100) }}
                        @endif
                                        
                        @if(in_array($requerimiento->ultimoEstadoRequerimiento()->id, [
                            config("conf_aplicacion.C_EN_PROCESO_SELECCION"),
                            config("conf_aplicacion.C_EN_PROCESO_CONTRATACION"),
                            config("conf_aplicacion.C_EVALUACION_DEL_CLIENTE"),
                            config("conf_aplicacion.C_RECLUTAMIENTO")
                        ]))
                            @if( isset($modulo) && $modulo == 'admin' )
                                <a
                                    class="btn btn-warning btn-block"
                                    href="{{ route("admin.editar_requerimiento",["req_id" => $requerimiento->req_id]) }}">
                                    Editar REQ
                                </a>
                            @elseif( isset($modulo) && $modulo == 'req' && $user_sesion->hasAccess("req.editar_requerimiento") )
                                <a
                                    class="btn btn-warning btn-block"
                                    href="{{ route("req.editar_requerimiento",["req_id" => $requerimiento->req_id]) }}">
                                    Editar REQ
                                </a>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    
    <div>
        {!! $requerimientos->appends(Request::all())->render() !!}
    </div>

<script>
    $(function () {
        $("#cliente_id").change(function(){
                var valor = $(this).val();
                $.ajax({
                    url: "{{ route('admin.selectCargoCliente') }}",
                    type: 'POST',
                    data: {id: valor},
                    success: function(response){
                        var data = response.cargos;
                        $('#cargo_id').empty();
                        $('#cargo_id').removeAttr('readonly');
                        $('#cargo_id').append("<option value=''>Seleccionar</option>");
                        
                        $.each(data, function(key, element) {
                            $('#cargo_id').append("<option value='" + element.id + "'>" + element.descripcion + "</option>");
                        });
                    }
                });
        });
          
        $(".solo-numero").keydown(function(event) {
            if (event.shiftKey) {
                event.preventDefault();
            }

            if (event.keyCode == 46 || event.keyCode == 8) {

            } else {
                if (event.keyCode < 95) {
                    if (event.keyCode < 48 || event.keyCode > 57) {
                        event.preventDefault();
                    }
                } else {
                    if (event.keyCode < 96 || event.keyCode > 105) {
                        event.preventDefault();
                    }
                }
            }
        });
    })
</script>