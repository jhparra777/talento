@extends("admin.layout.master")
@section("contenedor")
    
    <div class="col-md-12">
        {!! Form::model(Request::all(),["method"=>"get","route"=>"admin.call_center"]) !!}
        <h3>Filtros</h3>
            <div class="form-group col-md-6">
                {!! Form::label('motivo', 'Motivo') !!}
                {!! Form::select("motivo",$motivos,null,["class"=>"form-control","id"=>"motivo"]) !!}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('enviado_por', 'Enviado Por') !!} 
                {!! Form::select("enviado_por",$enviado_por,null,["class"=>"form-control","id"=>"enviado_por"]) !!}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('identificacion', 'Número Identificación') !!}
                {!! Form::text('numero_id',null,['class'=>'form-control','id'=>'identificacion','placeholder'=>'Buscar Número Identificación','value'=>old('identificacion')]) !!}
            </div>

            <div class="form-group col-md-6">
                {!! Form::label('sede', 'Sede') !!}
                {!! Form::select("sede",$ciudad_trabajo,null,["class"=>"form-control","id"=>"sede"]) !!}
            </div>

            {!! Form::submit("Buscar",["class"=>"btn btn-success "]) !!}
            <a href="{{route("admin.call_center")}}" type="button" class="btn btn-warning">Limpiar</a>
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
                        <th>Motivo</th>
                        <th>Enviado</th>
                        <th>Descripción</th>
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
                            <td>{{ strtoupper($datos->getCitacionMotivo()) }}</td>
                            <td>{{ strtoupper($datos->getCitacionEnvio()) }}</td>
                            <td>{{ strtoupper($datos->observaciones) }}</td>
                            <td>
                                <a href="{{route("admin.citacion_gestionar_call",[
                                    "numero_id"=>$datos->identificacion,
                                    "db_carga_id"=>$datos->id,
                                    "nombres"=>$datos->nombres,
                                    "telefono_fijo"=>$datos->telefono_fijo,
                                    "telefono_movil"=>$datos->telefono_movil,
                                    "primer_apellido"=>$datos->primer_apellido,
                                    "segundo_apellido"=>$datos->segundo_apellido,
                                    "user_id"=>$datos->getCitacionGestionar(),
                                    ])}}" type="button" class="btn btn-success">Gestionar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
@stop