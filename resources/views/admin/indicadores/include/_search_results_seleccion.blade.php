
<div class="col-md-12 col-lg-12 mt-2">
    <div class="row">
        <div class="box">
            <div class="box-header with-border text-center">
                <h3 class="box-title" style="font-weight: bold;">Resultados de la búsqueda </h3>
            </div>

            <br>
            <div class="box-body table-responsive no-padding">
                @if($found)
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Datos del rango seleccionado
                                </div>
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                        <table class="table table-striped">
                                            <caption class="text-center">Datos por agencia</caption>
                                            <thead>
                                                <tr>
                                                    <th>Agencia</th>
                                                    <th>Vacantes solicitadas</th>
                                                    <th>Candidatos contratados</th>
                                                    <th>% Cumplimiento</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($requerimientos_rango as $req)
                                                    <tr class="text-center">
                                                        <td>{{$req->agencia}}</td>
                                                        <td>{{$req->cantidad}}</td>
                                                        <td>{{$req->cant_contratados}}</td>
                                                        <td>
                                                            @if($req->cantidad)
                                                                {{round($req->cant_contratados*100/$req->cantidad,2)}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                    <tr class="text-center">
                                                        <th class="text-center">Total resultado</th>
                                                        <th class="text-center">{{$requerimientos_rango->sum('cantidad')}}</th>
                                                        <th class="text-center">{{$requerimientos_rango->sum('cant_contratados')}}</th>
                                                        <th class="text-center">
                                                            @if($requerimientos_rango->sum('cantidad'))
                                                            {{round($requerimientos_rango->sum('cant_contratados')*100/$requerimientos_rango->sum('cantidad'),2)}}
                                                            @endif
                                                        </th>
                                                    </tr>
                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                
                                                <canvas id="graficoBarCanvas" height="130" hidden></canvas>
                                            </div>
                                        </div>
                                    </div>
                                     
                                </div>
                            </div>
                        </div>
                        
                       
                    </div>
                    <!--<hr>-->


                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">
                            <table class="table table-striped text-center">
                                <caption class="text-center">Totalidad de solicitudes</caption>
                               <tr class="text-center">
                                    <th class="text-center">Solicitadas rango actual</th>
                                    <th class="text-center" colspan="2">{{$requerimientos_rango->sum('cantidad')}}</th>

                                          
                                </tr>
                                <tr class="text-center">
                                    <th class="text-center">Saldo meses anteriores</th>
                                    <th class="text-center" colspan="2">{{$requerimientos_anteriores->sum('cantidad')}}</th>
                                    
                                          
                                </tr>
                                <tr class="text-center">
                                    <th class="text-center">Total</th>
                                    <th class="text-center" colspan="2">{{$requerimientos_rango->sum('cantidad')+ $requerimientos_anteriores->sum('cantidad') }}</th>
                                    
                                          
                                </tr>
                            </table>
                        </div>

                    </div>

                    <!--<hr>-->

                    <div class="row">
                        
                        <div class="col-sm-12">
                             <div class="panel panel-default">
                                <div class="panel-heading">Cumplimiento</div>
                                <div class="panel-body">
                                    <div class="col-sm-6">
                                        <table class="table table-striped text-center">
                                            <caption class="text-center">Contratadas vs vencidas</caption>
                                            <tr class="tex-center">
                                                <th class="text-center">Contratadas post corte</th>
                                                <th class="text-center" colspan="2">{{$requerimientos_anteriores->sum('cant_contratados')}}</th>

                                                      
                                            </tr>
                                            <tr class="text-center">
                                                <th class="text-center">Contratadas rango actual</th>
                                                <th class="text-center" colspan="2">{{$requerimientos_rango->sum('cant_contratados')}}</th>
                                                
                                                      
                                            </tr>
                                            <tr class="text-center">
                                                <th class="text-center">Vencidas</th>
                                                <th class="text-center" colspan="2">{{$requerimientos_rango->sum('cantidad')+ $requerimientos_anteriores->sum('cantidad') -($requerimientos_anteriores->sum('cant_contratados')+ $requerimientos_rango->sum('cant_contratados'))  }}</th>      
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                                
                                                <canvas id="graficoPieCanvas" height="130" hidden></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                @else
                    <div class="jumbotron">
                        <h2 style="color:rgb(200,200,200);text-align: center;">No hay datos en este rango de fechas</h2>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>





