@extends("admin.layout.master")
@section("contenedor")

    <div class="col-md-6">
        {!! Form::model(Request::all(),["method"=>"get","route"=>"admin.citacion_reclutamiento"]) !!}
            <div class="form-group col-md-12">
                {!! Form::label('identificacion', 'Número Identificación') !!}
                {!! Form::text('numero_id',null,['class'=>'form-control','id'=>'identificacion','placeholder'=>'Buscar Número Identificación','value'=>old('identificacion')]) !!}
                <p class="text-danger">{!! FuncionesGlobales::getErrorData("numero_id",$errors) !!}</p>
            </div>

            {!! Form::submit("Buscar",["class"=>"btn btn-success "]) !!}
            <a href="{{route("admin.citacion_reclutamiento")}}" type="button" class="btn btn-warning">Limpiar</a>
        {!! Form::close() !!}
    </div>

    <div class="clearfix"></div>
    <!-- Validar si la consulta no trae resultado -->
        @if($datos_cargados->count() == 0)
            <div class="alert alert-warning alert-dismissable">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>No</strong> hay resultados de la busqueda.
            </div>
        @else
            <h3>Datos Cargados sin Gestionar</h3>
            <table class="table table-hover table-striped"> <!--class="table table-bordered">-->
                <thead>
                    <tr>
                        <th>Identificación</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Móvil</th>
                        <th>Fijo</th>
                        <th>Fecha Carga</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($datos_cargados as $datos)
                        <tr>
                            <td>{{ $datos->identificacion }}</td>
                            <td>{{ strtoupper($datos->nombres) }}</td>
                            <td>{{ strtoupper($datos->primer_apellido) }} 
                                {{ strtoupper($datos->segundo_apellido) }}</td>
                            <td>{{ $datos->telefono_movil }}</td>
                            <td>{{ $datos->telefono_fijo }}</td>
                            <td>{{ $datos->created_at }}</td>
                            <td>
                                <a href="{{route("admin.citacion_gestionar",[
                                    "numero_id"=>$datos->identificacion,
                                    "db_carga_id"=>$datos->id,
                                    "nombres"=>$datos->nombres,
                                    "telefono_fijo"=>$datos->telefono_fijo,
                                    "telefono_movil"=>$datos->telefono_movil,
                                    "primer_apellido"=>$datos->primer_apellido,
                                    "segundo_apellido"=>$datos->segundo_apellido,
                                    ])}}" type="button" class="btn btn-success">Gestionar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@stop