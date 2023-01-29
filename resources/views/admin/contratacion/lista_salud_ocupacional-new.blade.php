@extends("admin.layout.master")
@section('contenedor')
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Candidatos salud ocupacional"])
    
    {!! Form::model(Request::all(),["id"=>"admin.salud_ocupacional","method"=>"GET"]) !!}
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="codigo" class="control-label">Número de Requerimiento:</label>

                {!! Form::text("codigo",null,["class"=>"form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Número de requerimiento", "id" => "codigo"]); !!}
            </div>

            <div class="col-md-6  form-group">
                <label for="cedula" class="control-label">Número de Cédula:</label>

                {!! Form::text("cedula",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Número de cédula", "id" => "cedula"]); !!}
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route('admin.salud_ocupacional') }}">
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
                    <table class="table-responsive table table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th>Requerimiento</th>
                                <th>Cargo</th>
                                <th>Cédula</th>
                                <th>Nombres y apellidos</th>
                                <th>Número de orden</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($candidatos as $candidato)
                                <tr>
                                    <td>{{ $candidato->requerimiento }}</td>
                                    <td>{{ $candidato->cargo }}</td>
                                    <td>{{ $candidato->numero_id }}</td>
                                    <td>{{ $candidato->candidato .' '. $candidato->primer_apellido .' '. $candidato->segundo_apellido }}</td>
                                    <td># {{ $candidato->orden }}</td>
                                    <td>
                                        <a class="btn btn-default btn-sm | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple"  href="{{ route('admin.gestion_salud_ocupacional', ['orden' => $candidato->orden]) }}">
                                            Gestionar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function(){
            var table = $('#data-table').DataTable({
                "responsive": true,
                "paginate": true,
                "lengthChange": true,
                "deferRender":true,
                "filter": true,
                "sort": true,
                "info": true,
                "order": [[ 1, "desc" ]],
                "lengthMenu": [[10,20, 25, -1], [10,20, 25, "All"]],
                "autoWidth": true,
                "language": {
                    "url": '{{ url("js/Spain.json") }}'
                }
            });
        });
    </script>
@stop