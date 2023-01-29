@extends("admin.layout.master")
@section('contenedor')

{{-- Header --}}
@include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Usuarios"])

<div class="row">
    {{-- <div class="col-md-12 mb-2">
        <h3>Lista Usuarios</h3>
    </div> --}}

    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible | tri-br-1 tri-green tri-border--none" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{ Session::get("mensaje_success") }}
            </div>
        </div>
    @endif

    {!! Form::model(Request::all(), ["id" => "admin.usuarios_sistema", "method" => "GET", "id" => "listaForm"]) !!}
        <div class="col-md-12 form-group">
            <label for="email">Buscar:</label>
            {!! Form::text("email", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Nombre, correo ó cédula"]); !!}
        </div>

        <div class="col-md-6 form-group">
            <label for="estado">Estado:</label>

            <select name="estado" id="estado" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300">
                <option value="">Seleccionar</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div class="col-md-6 form-group">
            <div class="col-md-4">
                <label class="tri-toggle" for="admin">
                    <p>Módulo Administración</p>

                    <input
                        type="checkbox"
                        class="tri-toggle__input"
                        name="admin"
                        id="admin"
                        value="admin"

                        {{ Request::has('admin') ? 'checked' : '' }}
                    >
                    <div class="tri-toggle__fill"></div>
                </label>
            </div>

            <div class="col-md-4">
                <label class="tri-toggle" for="req">
                    <p>Módulo Requisición</p>
    
                    <input
                        type="checkbox"
                        class="tri-toggle__input"
                        name="req"
                        id="req"
                        value="req"

                        {{ Request::has('req') ? 'checked' : '' }}
                    >
                    <div class="tri-toggle__fill"></div>
                </label>
            </div>

            <div class="col-md-4">
                <label class="tri-toggle" for="hv">
                    <p>Módulo Hoja de Vida</p>
    
                    <input
                        type="checkbox"
                        class="tri-toggle__input"
                        name="hv"
                        id="hv"
                        value="hv"

                        {{ Request::has('hv') ? 'checked' : '' }}
                    >
                    <div class="tri-toggle__fill"></div>
                </label>
            </div>
        </div>

        {{-- 
        <!-- Modulo administrador -->
        <div class="col-md-3 form-group">
            <label for="inputEmail3">Módulo administrador</label>

            <div class="btn-group | tri-display--block" data-toggle="buttons">
                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_admin") == 1) ? "active" : "") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_admin", 1, null, ["autocomplete" => "off"]) !!} SI
                </label>

                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_admin") == 2) ? "active" : "") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_admin", 2, true, ["autocomplete" => "off"]) !!}  N/A
                </label>

                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_admin") == 3) ? "active" : "") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_admin", 3, null, ["autocomplete" => "off"]) !!} NO
                </label>
            </div>
        </div>

        <!-- Módulo requisiciones -->
        <div class="col-md-3 form-group">
            <label for="inputEmail3">Módulo requisiciones</label>

            <div class="btn-group | tri-display--block" data-toggle="buttons">
                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_req") == 1) ? "active" : "") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_req", 1, null, ["autocomplete" => "off"]) !!} SI
                </label>

                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_req")==2)?"active":"") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_req", 2, true, ["autocomplete" => "off"]) !!}  N/A
                </label>

                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_req") == 3) ? "active" : "") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_req", 3, null, ["autocomplete" => "off"]) !!} NO
                </label>
            </div>
        </div>

        <!-- Módulo hoja de vida -->
        <div class="col-md-3 form-group">
            <label for="inputEmail3">Módulo hoja de vida</label>

            <div class="btn-group | tri-display--block" data-toggle="buttons">
                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_hv") == 1) ? "active" : "") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_hv", 1, null, ["autocomplete" => "off"]) !!} SI
                </label>

                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_hv") == 2) ? "active" : "") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_hv", 2, true, ["autocomplete" => "off"]) !!}  N/A
                </label>

                <label class="btn btn-primary btn-sm {{ ((Request::get("mod_hv")==3)?"active":"") }} | tri-blue tri-border--none">
                    {!! Form::radio("mod_hv", 3, null, ["autocomplete" => "off"]) !!} NO
                </label>
            </div>
        </div>
        

        <!-- Todos los usuarios -->
        <div class="col-md-3 form-group">
            <!-- <label for="inputEmail3">Todos los usuarios:</label> <br> {!! Form::checkbox("todos", 1, null, ["class" => "form-control checkbox-preferencias", "placeholder" => "Nombre"]); !!} -->

            <div id="toggle">
                <label class="tri-display--block">Todos los usuarios</label>

                <label class="tri-toggle" for="tri-toggle">
                    <input
                        type="checkbox"
                        class="tri-toggle__input"
                        name="todos"
                        id="tri-toggle"
                        value="1"
                    >
                    <div class="tri-toggle__fill"></div>
                </label>
            </div>
        </div>
         --}}

        <div class="col-md-12 text-right">
            <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green">
                Buscar <i class="fa fa-search" aria-hidden="true"></i>
            </button>

            <a class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green" href="{{ route('admin.nuevo_usuario_sistema') }}" target="_blank">
                Nuevo usuario <i class="fas fa-plus"></i>
            </a>

            <a href="#" role="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green" id="exportarExcel">
                Excel <i class="fas fa-file-excel"></i>
            </a>

            <a class="btn btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-red" href="{{ route("admin.usuarios_sistema") }}">Limpiar</a>
        </div>
    {!! Form::close() !!}

    <div class="col-md-12 mt-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive ">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Módulos</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>
                                        @if($usuario->inRole("admin"))
                                            <span class="badge"> Administración</span>
                                        @endif

                                        @if($usuario->inRole("req"))
                                            <span class="badge">Requisición</span>
                                        @endif

                                        @if($usuario->inRole("hv"))
                                            <span class="badge">Hoja de vida</span>
                                        @endif
                                    </td>
                                    <td>{{ $usuario->estado }} {{-- $usuario->activo?'Activo':'Inactivo' --}}</td>

                                    <td class="text-center">
                                        <a class="btn btn-default | tri-br-2 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-200 tri-hover-out-purple"  href="{{ route('admin.editar_user_sistema', ['user_id' => $usuario->id]) }}">
                                            Editar usuario <i class="fa fa-pen" aria-hidden="true"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-center">
                                    <td colspan="5">No se encontraron registros</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 text-right">
        {!!  $usuarios->appends(Request::all())->render() !!}
    </div>
</div>

<script>
    document.querySelector('#exportarExcel').addEventListener('click', (e) => {
        let form = $('#listaForm').serialize()

        e.target.setAttribute('href', `{{ route('admin.reportes.lista_usuarios_sistema') }}?${form}&formato=xlsx`);
    })
</script>
@stop