@extends("admin.layout.master")
@section("contenedor")

    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Negocios clientes"])

    {{-- <h3 class="page-header">
        Lista de negocios clientes
    </h3> --}}

    <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>

                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif
    </div>

    {!! Form::model(Request::all(), ["route" => "admin.consultar_negocio", "method" => "GET", "class" => "mb-2"]) !!}
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">
                    Cliente:
                </label>

                {!! Form::select('cliente_id', $clientes, null, ['id'=>'cliente_id', 'class'=>'form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}

                <!--
                    {!! Form::hidden("cliente_id",null,["id"=>"cliente_id"]) !!}
                    {!! Form::text("nombre_cliente",null,["class"=>"form-control","id"=>"autocomplete_cliente","placeholder"=>"Digita nombre cliente"]) !!}
                -->

                <!-- Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}-->
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">
                    Número negocio:
                </label>

                {!! Form::text("num_negocio",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Número negocio"]); !!}
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route("admin.consultar_negocio") }}">
                    Limpiar
                </a>
            </div>
        </div>
    {!! Form::close() !!}

    <div class="panel panel-default">
        <div class="panel-body">
            <div class="tabla table-responsive">
                <table class="table table-hover table-striped text-center">
                    <thead>
                        <tr>
                            <th>
                                Nombre Cliente
                            </th>

                            <th>
                                Negocio
                            </th>
                          
                            @if($sitio->agencias)
                                <th>
                                    Agencia
                                </th>
                            @endif

                            <th>
                                Acción
                            </th>
                        </tr>
                    </thead>
        
                    <tbody>
                        @forelse($negocios as $negocio)
                            <tr>        
                                <td>
                                    @if(!empty($negocio->getCliente()))
                                        {{ $negocio->getCliente()->nombre }}
                                    @endif
                                </td>

                                <td>
                                    {{ $negocio->num_negocio }}
                                </td>

                                @if($sitio->agencias)
                                    <td>
                                        {{ $negocio->localidad }}
                                    </td>
                                @endif

                                <td>
                                    <a class="btn btn-default | tri-br-2 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-200 tri-hover-out-gray" href="{{ route('admin.nuevo_requerimiento', ['cliente_id' => $negocio->cliente_id, 'negocio_id' => $negocio->id]) }}">
                                        Nueva requisición <i aria-hidden="true" class="fa fa-plus"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    No se encontraron registros.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function () {

            $('.js-example-basic-single').select2({
                placeholder: 'Selecciona o busca un cliente'
            });

            //Autocomplete Cliente
            /*$('#autocomplete_cliente').autocomplete({
                serviceUrl: '{{ route("autocomplete_cliente") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#cliente_id").val(suggestion.id);
                }
            });*/
        });
    </script>
@stop