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
                <th>Usados</th>
                <th>Restantes</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>{{ $datosCount }}</td>
                <td>{{ $restantes }}</td>
            </tr>
        </tbody>
    </table>

    <a class="btn btn-warning" href="{{ route('admin.lista_creditos_funcionalidades') }}" title="Volver">Volver</a>

@stop