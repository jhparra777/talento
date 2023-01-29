@extends("admin.layout.master")
@section("contenedor")
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Edición de requerimientos"])

    {!!Form::model(Request::all(), ["route" => "admin.lista_requerimientos", "method" => "GET"]) !!}
        @if(Session::has("mensaje_success"))
            <div class="row">
                <div class="col-md-12" id="mensaje-resultado">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{ Session::get("mensaje_success") }}
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">
                    Número requerimiento:
                </label>

                {!! Form::text("num_req",null,["class"=>"form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 solo-numero", "placeholder" => "Número requerimiento"]); !!}
            
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">
                    Cliente:
                </label>

                {!! Form::select('cliente_id', $clientes, null, ['id'=>'cliente_id', 'class'=>'form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}

            </div>

            @if( $sitio->agencias )
                <div class="col-md-6 form-group">
                    <label for="inputEmail3" class="control-label">Agencia:</label>
                    
                    {!! Form::select("agencia",$agencias , null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
                    
                </div>
            @endif

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Cargo:</label>
                
                {!! Form::select("cargo_id", [], null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "readonly" => "readonly", "id" => "cargo_id" ]); !!}
                
            </div>

            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="control-label">Tipo Proceso:</label>

                {!! Form::select('tipo_proceso_id', $tipoProcesos, null, ['id' => 'tipo_proceso_id','class' => 'form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}
                    
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route("admin.lista_requerimientos")}}">
                    Limpiar
                </a>
            </div>
        </div>

    {!! Form::close() !!}

    <div class="row">
        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tabla table-responsive">
                        <table class="table table-hover table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No. Requerimiento</th>
                                    <th>Cliente</th>
                                    <th>Cargo</th>
                                    <th>Tipo Proceso</th>
                                    <th>No. Vacantes</th>
                                    <th>No. Asociados</th>
                                    <th>No. Contratados</th>
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
                                @forelse($requerimientos as $requerimiento)
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
                                            <td>{{ $requerimiento->nombre_agencia }}</td>
                                        @endif
                                        <td>{{ $requerimiento->estadoRequerimiento()->estado_nombre }}</td>
                                        <td>
                                            <div class="btn-group-vertical">
                                                @if(in_array($requerimiento->ultimoEstadoRequerimiento()->id, [
                                                    config("conf_aplicacion.C_EN_PROCESO_SELECCION"),
                                                    config("conf_aplicacion.C_EN_PROCESO_CONTRATACION"),
                                                    config("conf_aplicacion.C_EVALUACION_DEL_CLIENTE"),
                                                    config("conf_aplicacion.C_RECLUTAMIENTO")
                                                ]))
                                                        
                                                    @if($user_sesion->hasAccess("admin.estados_requerimiento"))
                                                        <button
                                                            class="btn btn-primary estados_requerimiento btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                            data-req="{{ $requerimiento->id }}"
                                                        >
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
                                                    <a
                                                        class="btn btn-primary btn-block | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        href="{{ route("admin.editar_requerimiento",["req_id" => $requerimiento->req_id]) }}"
                                                    >
                                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                                        Editar
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                <tr>
                                    <td class="text-center" colspan="12">No se encontraron registros</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            {!! $requerimientos->appends(Request::all())->render() !!}
        </div>
    </div>

    <script>
        $(function () {

            $('.js-example-basic-single').select2({
                placeholder: 'Selecciona o busca'
            });

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
                            $('#cargo_id').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    }
                });
            });
          
            // $(".solo-numero").keydown(function(event) {
            //     if (event.shiftKey) {
            //         event.preventDefault();
            //     }

            //     if (event.keyCode == 46 || event.keyCode == 8) {

            //     } else {
            //         if (event.keyCode < 95) {
            //             if (event.keyCode < 48 || event.keyCode > 57) {
            //                 event.preventDefault();
            //             }
            //         } else {
            //             if (event.keyCode < 96 || event.keyCode > 105) {
            //                 event.preventDefault();
            //             }
            //         }
            //     }
            // });

            $(".estados_requerimiento").on("click", function () {
                var req_id = $(this).data("req");

                $.ajax({
                    type: "POST",
                    data: {req_id: req_id},
                    url: "{{route('admin.estados_requerimiento')}}",
                    success: function (response) {
                        $("#modalTriSmall").find(".modal-content").html(response);
                        $("#modalTriSmall").modal("show");
                    }
                });
            });

            $(document).on("click", "#terminar_requerimiento", function () {
                var obj = $("#observaciones_terminacion").val();
                var estado = $("#estado_terminacion").val();
                var motivo = $("#motivo_cancelacion").val();
                var req_id = $("#req_id").val();

                $.ajax({
                    type: "POST",
                    data: "req_id=" + req_id + "&observaciones_terminacion=" + obj + "&estado_requerimiento=" + estado + "&motivo_cancelacion=" + motivo,
                    url: "{{ route('admin.terminar_requerimiento') }}",
                    success: function (response) {
                        if (response.success) {
                            $("#modalTriSmall").modal("hide");
                            mensaje_success("Se ha terminado el requerimiento.");
                            window.location.href = '{{ route("admin.lista_requerimientos") }}';
                        }else{
                            $("#modalTriSmall").find(".modal-content").html(response.view);
                            $("#modalTriSmall").modal("show");
                            $("#modalTriSmall").attr("data-spy","scroll");
                        }
                    }
                });
            });

            $("#btn_pri_req").on("click", function (e) {
                var obj = $(this);
                var ids = $("input[type='checkbox']").serialize();
                var req_ids = $("input[name='req_ids[]']").serialize();
                var href = obj.attr("href");
                obj.attr("href", href + "?" + ids + "&" + req_ids);
                return true;
            });
        });
    </script>
@stop