@extends("req.layout.master")
@section("contenedor")

    {{-- Header --}}
    @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Negocios clientes"])

    <div class="row">
        @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                    <span aria-hidden="true">
                        ×
                    </span>
                </button>
                {{Session::get("mensaje_success")}}
            </div>
        </div>
        @endif
    

    {!! Form::model(Request::all(),["route"=>"req.consultar_negocio","method"=>"GET", "class" => "mb-2"]) !!}
    
        <div class="col-md-6 form-group">
            <label class=" control-label" for="inputEmail3">Cliente:</label>
                {{-- {!! Form::hidden("cliente_id",null,["id"=>"cliente_id"]) !!}
                {!! Form::text("nombre_cliente",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder","id"=>"autocomplete_cliente","placeholder"=>"Digita nombre cliente"]) !!} --}}
                <!-- Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}-->

                {!! Form::select('cliente_id', $clientes, null, ['id'=>'cliente_id', 'class'=>'form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}

                <!--
                    {!! Form::hidden("cliente_id",null,["id"=>"cliente_id"]) !!}
                    {!! Form::text("nombre_cliente",null,["class"=>"form-control","id"=>"autocomplete_cliente","placeholder"=>"Digita nombre cliente"]) !!}
                -->
        </div>
        <div class="col-md-6 form-group">
            <label class="control-label" for="inputEmail3">Número Negocio:</label>
            {!! Form::text("num_negocio",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Número negocio"]); !!}
        </div>
        <div class="col-md-12 text-right">
            <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" type="submit">
                Buscar
                <i aria-hidden="true" class="fa fa-search">
                </i>
            </button>
            <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route('req.consultar_negocio')}}" type="reset">
                Limpiar
            </a>
        </div>
    
    {!! Form::close() !!}



    <!--
    <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
            Sociedad:
        </label>
        <div class="col-sm-10">
            Form::select("sociedad_id",$sociedades,null,["class"=>"form-control"]); !!}
        </div>
    </div>
    -->
    <!--
    <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
            Localidad/ Agencia:
        </label>
        <div class="col-sm-10">
            Form::select("agencia_id",$localidades,null,["class"=>"form-control"]); !!}
        </div>
    </div>
    -->
    <!--
    <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
            Tipo Negocio:
        </label>
        <div class="col-sm-10">
            Form::select("tipo_negocio_id",$tipos_negocios,null,["class"=>"form-control"]); !!}
        </div>
    </div>
    -->
    <!--
    <div class="col-md-6 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Línea Servicio:</label>
        <div class="col-sm-10">
            Form::select("linea_servicio_id",$linea_servicios,null,["class"=>"form-control"]); !!}
        </div>
    </div>
    -->
    <!--
    <div class="col-md-6 form-group">
        <label class="col-sm-2 control-label" for="inputEmail3">
            Unidad Negocio:
        </label>
        <div class="col-sm-10">
            Form::select("unidad_negocio_id",$unidad_negocios,null,["class"=>"form-control"]); !!}
        </div>
    </div>
    -->
    <br>
 <div class="col-md-12 mt-2">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="tabla table-responsive">
                    <table class="table table-hover table-striped text-center">
                        <thead>
                            <tr>
                                {{-- <th style="width: 20px;">
                                    Acción
                                </th> --}}
                                @if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co" ||
                                route("home")=="http://localhost:8000")
                                @else
                                <th>
                                    Nombre Cliente
                                </th>
                                <th>
                                    # Negocio
                                </th>
                                @endif
                                {{-- @if(route("home")!="https://gpc.t3rsc.co")
                                <th>
                                    Agencia
                                </th>
                                @endif --}}
                                {{-- <th>
                                    Jornada Laboral
                                </th>
                                <th>
                                    Clase Riesgo
                                </th> --}}
                                <th>
                                    Acción
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($negocios->count() == 0)
                            <tr>
                                <td colspan="5">
                                    No se encontraron registros.
                                </td>
                            </tr>
                            @endif
                            @foreach($negocios as $negocio)
                            <tr>
                                @if(route("home")=="http://tiempos.t3rsc.co" || route("home")=="https://tiempos.t3rsc.co" ||
                                route("home")=="http://localhost:8000")
    
                                @else
                                <td>
                                    {{$negocio->getCliente()->nombre}}
                                </td>
                                <td>
                                    {{$negocio->num_negocio}}
                                </td>
                                @endif
                                {{-- @if(route("home")!="https://gpc.t3rsc.co")
                                <td>
                                    {{$negocio->localidad}}
                                </td>
                                @endif --}}
                                {{-- <td>
                                    {{$negocio->getTipoJornada()}}
                                </td>
                                <td>
                                    {{$negocio->tipo_negocio}}
                                </td> --}}
                                <td>
                                    <a class="btn btn-default | tri-br-2 tri-txt-gray tri-bg-white tri-bd-gray tri-transition-200 tri-hover-out-gray"
                                        href="{{route('req.nuevo_requerimiento',['cliente_id'=>$negocio->cliente_id,'negocio_id'=>$negocio->id])}}">
                                        Nueva Requisición
                                        <i aria-hidden="true" class="fa fa-plus-circle">
                                        </i>
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
    <div class="col-sm-12 text-right" >
        <a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{route("req_index")}}">Volver</a>
    </div>
    </div>     

    <script type="text/javascript">
        $(function () {
            $('.js-example-basic-single').select2({
                placeholder: 'Selecciona o busca un cliente'
            });
            //Autocomplete Cliente
            // $('#autocomplete_cliente').autocomplete({
            //     serviceUrl: '{{ route("autocomplete_cliente") }}',
            //     autoSelectFirst: true,
            //     onSelect: function (suggestion) {
            //         $("#cliente_id").val(suggestion.id);
            //     }
            // });

        });

    </script>

@stop