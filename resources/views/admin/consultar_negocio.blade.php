@extends("admin.layout.master")
@section("contenedor")

    <h3 class="page-header">
        Lista de negocios clientes
    </h3>

    {!! Form::model(Request::all(), ["route" => "admin.consultar_negocio", "method" => "GET"]) !!}

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

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Cliente:
            </label>

            <div class="col-sm-10">
                {!! Form::select('cliente_id', $clientes, null, ['id'=>'cliente_id','class'=>'form-control js-example-basic-single']) !!}
            </div>

            <div class="col-sm-10">
                <!--
                {!! Form::hidden("cliente_id",null,["id"=>"cliente_id"]) !!}
                {!! Form::text("nombre_cliente",null,["class"=>"form-control","id"=>"autocomplete_cliente","placeholder"=>"Digita nombre cliente"]) !!}
                -->

                <!-- Form::select("cliente_id",$clientes,null,["class"=>"form-control" ]); !!}-->
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label class="col-sm-2 control-label" for="inputEmail3">
                Numero Negocio:
            </label>

            <div class="col-sm-10">
                {!! Form::text("num_negocio",null,["class"=>"form-control","placeholder"=>"" ]); !!}
            </div>
        </div>

        <div class="clearfix"></div>

        <button class="btn btn-success" type="submit">
            Buscar
            <i aria-hidden="true" class="fa fa-search"></i>
        </button>

        <a class="btn btn-danger" href="{{route('admin.consultar_negocio')}}" type="reset">
            Cancelar
            <i aria-hidden="true" class="fa fa-times-circle-o"></i>
        </a>

    {!! Form::close() !!}

    <br>

    <div class="clearfix"></div>

    <div class="tabla table-responsive">
        <table class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th style="width: 20px;">
                        Acción
                    </th>
                    <th>
                        Nombre Cliente
                    </th>
                    <th>
                        # Negocio
                    </th>
                  
                    @if($sitio->agencias)
                        <th>
                            Agencia
                        </th>
                    @endif
                    <th>
                        Jornada Laboral
                    </th>
                    <th>
                        Clase Riesgo
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
                        <td>
                            <a class="btn btn-warning" href="{{route('admin.nuevo_requerimiento',['cliente_id'=>$negocio->cliente_id,'negocio_id'=>$negocio->id])}}">
                                Nueva Requisición
                                <i aria-hidden="true" class="fa fa-plus-circle">
                                </i>
                            </a>
                        </td>

                        <td>
                            @if(!empty($negocio->getCliente()))
                                {{$negocio->getCliente()->nombre}}
                            @endif
                        </td>
                        <td>
                            {{$negocio->num_negocio}}
                        </td>
                        @if($sitio->agencias)
                            <td>
                                {{$negocio->localidad}}
                            </td>
                        @endif
                        <td>
                            {{$negocio->getTipoJornada()}}
                        </td>
                        <td>
                            {{$negocio->tipo_negocio}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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