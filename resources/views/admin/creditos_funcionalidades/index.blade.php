@extends("admin.layout.master")
@section("contenedor")

    <h3>Creditos Funcionalidades Avanzadas</h3>

    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get("mensaje_success") }}
            </div>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th></th>
                <th>Funcionalidad</th>
                <th>Creditos</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($empresaFuncionalidades as $funcionalidad)
            <tr>
                <td></td>
                <td>{{ $funcionalidad->descripcionFuncion }}</td>
                <td>{{ $funcionalidad->limite }}</td>
                <td>
                    <a href="{{ route('admin.ver_creditos_funcionalidades',['tipo_id' => $funcionalidad->tipo_funcionalidad, 'control_id' => $funcionalidad->id, 'limite' => $funcionalidad->limite]) }}" class="btn btn-warning">Gestionar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

@stop