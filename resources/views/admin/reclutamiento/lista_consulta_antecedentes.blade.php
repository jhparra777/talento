@extends("admin.layout.master")
@section("contenedor")

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Candidatos Consulta de Antecedentes Estudio Virtual de Seguridad"])
    <style type="text/css">
        th,td{
            text-align: center;
        }
    </style>

    {!! Form::model(Request::all(), ["route"=>"admin.lista_consulta_antecedentes_evs","id" => "lista_consulta_antecedentes_evs", "method" => "GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="codigo" class="control-label">Número de Requerimiento:</label>

                {!! Form::text("codigo",null,["class"=>"form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Número Requerimiento", "id" => "codigo"]); !!}
            </div>

            <div class="col-md-6  form-group">
                <label for="cedula" class="control-label">Número de Cédula:</label>

                {!! Form::text("cedula",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Número Cédula", "id" => "cedula"]); !!}
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label for="ciudad_trabajo" class="control-label">Ciudad: <span></span></label>

                {!!Form::select("ciudad_trabajo",$ciudad_trabajo,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"ciudad_trabajo"]) !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route("admin.lista_consulta_antecedentes_evs") }}">
                    Limpiar
                </a>
            </div>
        </div>
    {!! Form::close() !!}
    <br>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table-responsive table table-bordered" id="data-table-antecedentes">
                        <thead>
                            <tr >
                                <th>Requerimiento</th>
                                <th>Ubicación</th>
                                <th>Cargo</th>
                                <th>Cédula</th>
                                <th>Nombres y Apellidos</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @if($candidatos->count() == 0)
                                <tr>
                                    <td colspan="6"> No se encontraron registros</td>
                                </tr>
                            @endif

                            @foreach($candidatos as $candidato)
                                <tr>
                                    <td>{{ $candidato->requerimiento_id }}</td>
                                    <td>{{ $candidato->getUbicacionReq() }}</td>
                                    <td>{{ $candidato->desc_cargo }}</td>
                                    <td>{{ $candidato->numero_id }}</td>
                                    <td>{{ $candidato->nombres .' '. $candidato->primer_apellido .' '. $candidato->segundo_apellido }}</td>

                                    <td>
                                        @if(in_array($user_sesion->id, $ids_usuarios_gestionan))
                                            @if (isset($tusdatosData) && $tusdatosData->status != 'invalido')
                                                -
                                            @else
                                                <a
                                                    class="btn btn-warning | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple"
                                                    role="button"
                                                    onclick="enviarTusDatos({{ $candidato->user_id }}, {{ $candidato->requerimiento_id }}, '{{ route('admin.tusdatos_enviar_evs') }}')"
                                                >
                                                    CONSULTA DE ANTECEDENTES
                                                </a>
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="showing" style="text-align: center;">
                {!! $candidatos->appends(Request::all())->render()!!}
            </div>                    
        </div>
    </div>

<script type="text/javascript">
    $(function(){
        var table = $('#data-table-antecedentes').DataTable({
            "responsive": true,
            "paginate": false,
            "lengthChange": false,
            "deferRender":true,
            "filter": true,
            "sort": true,
            "info": true,
            //"lengthMenu": [[10,20, 25, -1], [10,20, 25, "All"]],
            "autoWidth": true,
            "language": {
                "url": '{{ url("js/Spain.json") }}'
            }
        });
    });

    //Tusdatos.co
    function enviarTusDatos(user_id, req_id, route) {
        $.ajax({
            type: "POST",
            url: route,
            data: {
                user_id: user_id,
                req_id: req_id
            },
            success: function(response) {
                if (response.limite) {
                    $.smkAlert({text: 'Se ha llegado al límite de consultas establecido.', type: 'danger', permanent: true})
                }else {
                    if (response.success) {
                        //Insertar modal devuelto en el div
                        document.querySelector('#modalAjaxBox').innerHTML = response.view
                        $('#consultarTusDatosModal').modal('show')
                    }else {
                        $.smkAlert({
                            text: 'La/el candidata/o debe tener un <b>tipo de documento</b> y <b>fecha de expedición</b> definido antes de consultar.',
                            type: 'danger'
                        });
                    }
                }
            }
        })
    }

    function consultarTusDatos(user_id, req_id, route, tipoDoc, fechaExp) {
        if ($('#formTusdatos').smkValidate()) {
            $.ajax({
                type: "POST",
                data: {
                    user_id : user_id,
                    req_id : req_id,
                    tipo_documento: tipoDoc,
                    fecha_expedicion: fechaExp
                },
                url: "{{ route('admin.tusdatos_launch_evs') }}",
                beforeSend: function() {
                    $.smkAlert({text: 'Consultando ...', type: 'info'})
                },
                success: function(response) {
                    if(response.success == true) {
                        $.smkAlert({text: 'La consulta está en proceso. Puede tardar unos minutos hasta que la consulta termine.', type: 'success', permanent: true})

                        document.getElementById('enviarTusdatos').setAttribute('disabled', 'disabled');

                        setTimeout(() => {
                            $('#consultarTusDatosModal').modal('hide')
                        }, 1000);

                        setTimeout(() => {
                            location.reload()
                        }, 2000);
                    }else {
                        if (response.error) {
                            $.smkAlert({text: response.msg, type: 'danger', permanent: true})

                            setTimeout(() => {
                                $('#consultarTusDatosModal').modal('hide')
                            }, 1000);
                        }else {
                            $.smkAlert({text: 'Ha ocurrido un error, intenta nuevamente.', type: 'danger'})
                        }
                    }
                }
            })
        }
    }
    //
</script>
@stop