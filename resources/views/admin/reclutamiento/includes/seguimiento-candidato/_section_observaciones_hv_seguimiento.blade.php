<div class="panel panel-default" style="border-radius: 0 1rem 1rem 1rem;">
    <div class="panel-body">
        <div class="col-sm-12 col-md-5 mb-2">
            <h4 class="tri-fs-14">OBSERVACIONES A LA HOJA DE VIDA</h4>
        </div>

        <div class="col-md-12">
            <div class="table-responsive">
                <div class="tabla table-responsive">
                    <table class="table table-hover text-center">
                        <thead>
                            <tr>
                                <th style="text-align: center;">N°</th>
                                <th style="text-align: center;" >Descripción</th>
                                <th style="text-align: center;" >Usuario gestionó</th>
                                <th style="text-align: center;" >Fecha Creación</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($observacion_hv->count() == 0)
                                <tr>
                                    <td colspan="5">No se encontraron registros</td>
                                </tr>
                            @endif
                            
                            @foreach($observacion_hv as $key =>  $observaciones)
                                <tr>
                                    <td style="text-align: center;">{{++$key}}</td>
                                    <td style="text-align: center;">{{$observaciones->observacion}}</td>
                                    <td style="text-align: center;">{{$observaciones->nombre}}</td>
                                    <td style="text-align: center;">{{$observaciones->created_at}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>