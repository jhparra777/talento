  <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("req_id",$errors) !!}</p>    
        <div class="col-md-12">
            <h4>Requerimeitos Prioritarios</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th># Req</th>
                        <th>Cliente</th>
                        <th>Ciudad</th>
                        <th>Cargo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if($req_prioritarios->count() == 0)
                    <tr>
                        <td colspan="4">No se encontraron registros</td>
                    </tr>
                    @endif
                    @foreach($req_prioritarios as $req)
                    <tr>
                        <td>{!! Form::radio("req_id",$req->req_id) !!}</td>
                        <td>{{$req->req_id}}</td>
                        <td>{{$req->nombre_cliente}}</td>
                        <td>{{$req->getUbicacion()->ciudad}}</td>
                        <td>{{$req->desc_cargo}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <h4>Requerimientos sugeridos por reclutador</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th># Req</th>
                        <th>Cliente</th>
                        <th>Ciudad</th>
                        <th>Cargo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if($req_reclutadores->count() == 0)
                    <tr>
                        <td colspan="4">No se encontraron registros</td>
                    </tr>
                    @endif
                    @foreach($req_reclutadores as $req)
                    <tr>
                        <td>{!! Form::radio("req_id",$req->req_id) !!}</td>
                        <td>{{$req->req_id}}</td>
                        <td>{{$req->nombre_cliente}}</td>
                        <td>{{$req->getUbicacion()->ciudad}}</td>
                        <td>{{$req->desc_cargo}}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <h4>Requerimientos Sugeridos por enlace</h4>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th></th>
                        <th># Req</th>
                        <th>Cliente</th>
                        <th>Ciudad</th>
                        <th>Cargo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if($req_sueridos->count() == 0)
                    <tr>
                        <td colspan="4">No se encontraron registros</td>
                    </tr>
                    @endif
                    @foreach($req_sueridos as $req)
                    <tr>
                        <td>
                            {!! Form::radio("req_id",$req->req_id) !!}
                        </td>
                        <td>{{$req->req_id}}</td>
                        <td>{{$req->nombre_cliente}}</td>
                        <td>{{$req->getUbicacion()->ciudad}}</td>
                        <td>{{$req->desc_cargo}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>