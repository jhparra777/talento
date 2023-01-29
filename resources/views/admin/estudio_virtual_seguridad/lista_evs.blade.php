@extends("admin.layout.master")
@section('contenedor')
    
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Estudios virtuales de seguridad"])

    {!! Form::model(Request::all(), ["id" => "fr_evs", "method" => "GET"]) !!}
        <div class="row">
            
            <div class="col-md-6">
                <div class="form-group">
                    <label for="num_req" class="control-label">
                            Número de requerimiento:
                    </label>
                    
                    {!! Form::text("num_req", null, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "num_req", "placeholder" => ""]); !!}
               </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="cedula" class="control-label">Número de cédula:</label>
                   
                    {!! Form::text("cedula", null, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "cedula", "placeholder" => "Número de Cédula"]); !!}
                </div> 
            </div>
        </div>
        <div class="col-md-12 text-right">
            <button class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" >Buscar</button>
            <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route('admin.lista_estudio_virtual_seguridad')}}" >Limpiar</a>
        </div>
    {!! Form::close() !!}

    <br>
    <br>
    <br>
    <br>
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped text-center data-table" style="text-align: center;">
                    <thead>
                        <tr>
                            <th>Requerimiento</th>
                            <th>Nombres y apellidos</th>
                            <th>Número de documento</th>
                            <th>Tipo estudio virtual de seguridad</th>
                            <th>Fecha solicitud</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidatos as $candidato)
                            <tr>
                                <td>{{ $candidato->requerimiento_id }}</td>
                                <td>{{ $candidato->primer_nombre }} {{ $candidato->segundo_nombre }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido}}</td>
                                <td>{{ $candidato->numero_id }}</td>
                                <td>{{ $candidato->evs_descripcion }}</td>
                                <td>{{ $candidato->fecha_creacion }}</td>
                                <td>
                                    <a
                                        type="button"
                                        class="btn btn-sm btn-warning | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple"
                                        href='{{route("admin.gestionar_estudio_virtual_seguridad", ["id_evs"=>$candidato->id_evs])}}'
                                        
                                    >
                                        Gestionar
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"> No se encontraron registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {!! $candidatos->appends(Request::all())->render() !!}

    <script>
    $(function(){
        @if($candidatos->count() != 0)

            $('.data-table').DataTable({
              "responsive": true,
              "columnDefs": [
                  { responsivePriority: 1, targets: 0 },
                  { responsivePriority: 2, targets: -1 }
              ],
              "paginate": true,
              "lengthChange": true,
              "filter": true,
              "sort": true,
              "info": true,
              "autoWidth": true,
              "order": [[ 1, "desc" ]],
              "language": {
                  "url": '{{ url("js/Spain.json") }}'
              }
          });
        @endif
    });
</script>
@stop
