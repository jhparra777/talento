<div class="panel panel-default item">
        <div class="panel-heading">
            <h3>Ingresos y egresos económicos del núcleo familiar</h3>
        </div>
        <div class="panel-body">
            
            <form id="form-4" data-smk-icon="glyphicon-remove-sign" name="form-3" class="formulario">
                <div class="row">

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Ingresos mensuales <span></span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("ingresos_mensuales",$candidatos->ingresos_mensuales,["class"=>"form-control selectcategory solo_numeros contable_total_ingreso monto" ,"id"=>"ingresos_mensuales","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">
                                Procedencia <span></span> 
                                </label>
                                
                                    {!! Form::textarea("procedencia_ingresos_candidato",$candidatos->procedencia_ingresos_candidato,["class"=>"form-control selectcategory" ,"id"=>"procedencia_ingresos_candidato","placeholder"=>"En este espacio se debe registrar de dónde provienen estos ingresos (salario básico, arrendamiento, asesorías, ventas por catálogo, trabajo por horas, cuota alimentaria, etc...)","rows"=>3]) !!}
                            </div>
                            
                            
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Ingresos mensuales del cónyugue <span></span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("ingresos_mensuales_conyugue",$candidatos->ingresos_mensuales_conyugue,["class"=>"form-control selectcategory solo_numeros contable_total_ingreso monto" ,"id"=>"ingresos_mensuales_conyugue"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">
                                Procedencia <span></span> 
                                </label>
                                
                                    {!! Form::textarea("procedencia_ingresos_conyugue",$candidatos->procedencia_ingresos_conyugue,["class"=>"form-control selectcategory" ,"id"=>"procedencia_ingresos_conyugue","rows"=>3,"placeholder"=>"En este espacio se debe registrar de dónde provienen estos ingresos (salario básico, arrendamiento, asesorías, ventas por catálogo, trabajo por horas, cuota alimentaria, etc...)"]) !!}
                            </div>
                           
                        </div>

                        <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Otros ingresos <span></span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("otros_ingresos_candidato",$candidatos->otros_ingresos_candidato,["class"=>"form-control selectcategory solo_numeros contable_total_ingreso monto" ,"id"=>"otros_ingresos_candidato"]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">
                                Procedencia <span></span> 
                                </label>
                                
                                    {!! Form::textarea("procedencia_otros_ingresos",$candidatos->procedencia_otros_ingresos,["class"=>"form-control selectcategory" ,"id"=>"procedencia_otros_ingresos","rows"=>3,"placeholder"=>"En este espacio se debe registrar de dónde provienen estos ingresos (salario básico, arrendamiento, asesorías, ventas por catálogo, trabajo por horas, cuota alimentaria, etc...)"]) !!}
                            </div>
 
                        </div>
                        @if($current_user->inRole('admin'))
                        
                            <div class0="row">
                                <div class="col-md-12 form-group">
                                    <label class="col-sm-12 pull-left" for="inputEmail3">
                                        Observaciones <span></span> 
                                    </label>
                                    <div class="col-sm-12">
                                        {!! Form::textarea("observaciones_ingresos",$candidatos->observaciones_ingresos,["class"=>"form-control selectcategory" ,"id"=>"observaciones_ingresos","placeholder"=>"Este espacio sería utilizado por la psicóloga para realizar observaciones en caso de que no tenga ningún ingreso","rows"=>5]) !!}
                                    </div>
                                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                                </div>
                                
                            </div>
                       
                         @endif

                        <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                TOTAL INGRESOS MENSUALES DEL EVALUADO: <span></span> 
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text("total_ingresos",$candidatos->total_ingresos,["class"=>"form-control selectcategory monto total_ingresos" ,"id"=>"total_ingresos","readonly"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h4>Egresos mensuales promedio</h4>
                        </div>
                         <div class="col-md-6 form-group">
                            <label class="col-sm-12 pull-left" for="inputEmail3">
                                Egresos mensuales <span></span> 
                            </label>
                            <div class="col-sm-12">
                                {!! Form::text("egresos_mensuales",$candidatos->egresos_mensuales,["class"=>"form-control selectcategory solo_numeros contable_total_egreso monto" ,"id"=>"egresos_mensuales","required"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">
                                Destino <span></span> 
                                </label>
                                
                                    {!! Form::textarea("procedencia_egresos_candidato",$candidatos->procedencia_egresos_candidato,["class"=>"form-control selectcategory" ,"id"=>"procedencia_egresos_candidato","placeholder"=>"Queremos saber cuanto dinero destina mensualmente para el pago de sus obligaciones como: Arriendo, alimentación, transportes, gasolina, colegios, universidad, vestuario, plan de celular,  pago de servicios, recreaciòn, medicina prepagada y otros gastos que el evaluado pueda tener mensualmente.","rows"=>3]) !!}
                            </div>
                            
                            
                        </div>
                    </div>
                     @if($current_user->inRole('admin'))
                        
                            <div class0="row">
                                <div class="col-md-12 form-group">
                                    <label class="col-sm-12 pull-left" for="inputEmail3">
                                        Observaciones <span></span> 
                                    </label>
                                    <div class="col-sm-12">
                                        {!! Form::textarea("observaciones_egresos",$candidatos->observaciones_egresos,["class"=>"form-control selectcategory" ,"id"=>"observaciones_egresos","placeholder"=>"Este espacio sería utilizado por la psicóloga para realizar observaciones en caso de que no tenga ningún egreso","rows"=>5]) !!}
                                    </div>
                                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                                </div>
                                
                            </div>
                       
                         @endif
                    <div class="row">
                         <div class="col-md-12 form-group">
                            <label class="col-sm-6 pull-left" for="inputEmail3">
                                TOTAL EGRESOS MENSUALES DEL EVALUADO: <span></span> 
                            </label>
                            <div class="col-sm-6">
                                {!! Form::text("total_egresos",$candidatos->total_egresos,["class"=>"form-control selectcategory total_egresos" ,"id"=>"total_egresos","readonly"=>true]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>
                    </div>


            <div class="row">
                        <div class="col-sm-12 text-center">
                            <h4>Información crediticia del evaluado</h4>
                        </div>

            <div class="col-md-12 form-group">
                    <label class="col-sm-6 pull-left" for="inputEmail3">
                                ¿Posee créditos bancarios? <span></span> 
                    </label>
                    <div class="col-sm-6">
                        <label class="switchBtn">
                            {!! Form::checkbox("tiene_creditos_bancarios",1,($candidatos->creditos_bancarios!=null)?1:0,["class"=>"si_no","id"=>"tiene_creditos_bancarios"]) !!}
                            <div class="slide"></div>
                        </label>
                    </div>
                    
            </div>
            
            <div id="section-creditos" class="box box-info collapsed-box col-sm-12">
                <div class="box-header with-border">
                    <h4 class="box-header with-border">Créditos bancarios</h4>

                    
                </div>

                <div class="">
                    <div class="chart">
                        <div class="container" id="creditos-bancarios">
                            <!--aca comienza el foreach -->
                            @if($creditos=json_decode($candidatos->creditos_bancarios))
                            <?php
                                $cantidad_credito=1;
                            ?>
                                @foreach($creditos as $cre)
                                    <div class="row">

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Banco </label>
                                            </div>
                                            <div class="col-sm-12">
                                                {!! Form::select("banco_credito[]",$bancos,$cre->banco,["class"=>"form-control banco_credito selectcategory"]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Tipo de crédito *</label>
                                            </div>
                                             {!! Form::select("tipo_credito[]",$tipos_credito,$cre->tipo_credito,["class"=>"form-control tipo_credito selectcategory"]) !!}
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Total a la fecha *</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam total_credito postular-cand solo_numeros monto" placeholder="Total" name="total_credito[]" value="{{$cre->total}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Cuota mensual *</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam cuota_credito postular-cand solo_numeros contable_total_egreso monto" placeholder="Cuota" name="cuota_credito[]" value="{{$cre->cuota}}">
                                            </div>
                                        </div>

                                

                                        <div class="col-md-2 form-group last-child">
                                            <button type="button" class="btn btn-success add-credito" title="Agregar">+</button>
                                            <span class="nota-add">Agregar otro crédito</span>
                                            @if($cantidad_credito>1)
                                                <button type="button" class="btn btn-danger rem-credito">-</button>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                           <hr/ style="border: 1px solid blue;">
                                       </div>
                                 </div>
                                 <?php
                                    $cantidad_credito++;
                                 ?>
                                @endforeach

                            @else
                            <div class="row">

                                <div class="col-md-2 form-group">
                                    <div class="col-sm-12">
                                        <label>Banco </label>
                                    </div>
                                    <div class="col-sm-12">
                                        {!! Form::select("banco_credito[]",$bancos,null,["class"=>"form-control banco_credito selectcategory"]) !!}
                                    </div>
                                </div>

                                <div class="col-md-2 form-group">
                                    <div class="col-sm-12">
                                        <label>Tipo de crédito *</label>
                                    </div>
                                     {!! Form::select("tipo_credito[]",$tipos_credito,null,["class"=>"form-control tipo_credito selectcategory"]) !!}
                                </div>

                                <div class="col-md-2 form-group">
                                    <div class="col-sm-12">
                                        <label>Total a la fecha *</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control form_cam total_credito postular-cand solo_numeros monto" placeholder="Total" name="total_credito[]">
                                    </div>
                                </div>
                                
                                <div class="col-md-2 form-group">
                                    <div class="col-sm-12">
                                        <label>Cuota mensual *</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control form_cam cuota_credito postular-cand solo_numeros contable_total_egreso monto" placeholder="Cuota" name="cuota_credito[]">
                                    </div>
                                </div>

                        

                                <div class="col-md-2 form-group last-child">
                                    <button type="button" class="btn btn-success add-credito" title="Agregar">+</button>
                                    <span class="nota-add">Agregar otro crédito</span>
                                </div>
                                <div class="col-md-12">
                                   <hr/ style="border: 1px solid blue;">
                               </div>
                            </div>
                            @endif
                            <!--aca termina el foreach -->
                        </div>
                    </div>
                </div>
            </div>
        

            {{-- Tarjetas de credito --}}
            <br>
            <div class="col-md-12 form-group">
                    <label class="col-sm-6 pull-left" for="inputEmail3">
                                ¿Posee tarjetas de crédito? <span></span> 
                    </label>
                    <div class="col-sm-6">
                        <label class="switchBtn">
                            {!! Form::checkbox("tiene_tarjetas_credito",1,($candidatos->tarjetas_credito!=null)?1:0,["class"=>"si_no","id"=>"tiene_tarjetas_credito"]) !!}
                            <div class="slide"></div>
                        </label>
                    </div>
                    
            </div>

            <div id="section-tarjetas" class="box box-info collapsed-box col-sm-12">
                <div class="box-header with-border">
                    <h4 class="box-header with-border">Tarjetas de crédito</h4>

                    
                </div>

                <div class="">
                    <div class="chart">
                        <div class="container" id="tarjetas-credito">
                            @if($tarjetas=json_decode($candidatos->tarjetas_credito))
                                <?php
                                    $cantidad_tarjetas=1;
                                ?>
                                @foreach($tarjetas as $tar)
                                    <div class="row">

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Banco </label>
                                            </div>
                                            <div class="col-sm-12">
                                                {!! Form::select("banco_tarjeta[]",$bancos,$tar->banco,["class"=>"form-control banco_tarjeta selectcategory"]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Tipo  de tarjeta</label>
                                            </div>
                                             {!! Form::select("tipo_tarjeta[]",$tipos_tarjeta,$tar->tipo_tarjeta,["class"=>"form-control tipo_tarjeta selectcategory"]) !!}
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Total a la fecha</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam total_tarjeta postular-cand solo_numeros monto" placeholder="Total" name="total_tarjeta[]" value="{{$tar->total}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Cuota mensual</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam cuota_tarjeta postular-cand contable_total_egreso monto" placeholder="Cuota" name="cuota_tarjeta[]" value="{{$tar->cuota}}">
                                            </div>
                                        </div>

                                

                                        <div class="col-md-2 form-group last-child">
                                            <button type="button" class="btn btn-success add-tarjeta" title="Agregar">+</button>
                                            <span class="nota-add">Agregar otra tarjeta</span>
                                            @if($cantidad_tarjetas>1)
                                                <button type="button" class="btn btn-danger rem-tarjeta">-</button>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                           <hr/ style="border: 1px solid blue;">
                                       </div>
                                    </div>
                                    <?php
                                        $cantidad_tarjetas++;
                                     ?>
                                @endforeach
                            @else
                                <div class="row">

                                    <div class="col-md-2 form-group">
                                        <div class="col-sm-12">
                                            <label>Banco </label>
                                        </div>
                                        <div class="col-sm-12">
                                            {!! Form::select("banco_tarjeta[]",$bancos,null,["class"=>"form-control banco_tarjeta selectcategory"]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <div class="col-sm-12">
                                            <label>Tipo de tarjeta</label>
                                        </div>
                                         {!! Form::select("tipo_tarjeta[]",$tipos_tarjeta,null,["class"=>"form-control tipo_tarjeta selectcategory"]) !!}
                                    </div>

                                    <div class="col-md-2 form-group">
                                        <div class="col-sm-12">
                                            <label>Total a la fecha</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control form_cam total_tarjeta postular-cand solo_numeros monto" placeholder="Total" name="total_tarjeta[]">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2 form-group">
                                        <div class="col-sm-12">
                                            <label>Cuota mensual</label>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control form_cam cuota_tarjeta postular-cand contable_total_egreso monto" placeholder="Cuota" name="cuota_tarjeta[]">
                                        </div>
                                    </div>

                            

                                    <div class="col-md-2 form-group last-child">
                                        <button type="button" class="btn btn-success add-tarjeta" title="Agregar">+</button>
                                        <span class="nota-add">Agregar otra tarjeta</span>
                                    </div>
                                    <div class="col-md-12">
                                       <hr/ style="border: 1px solid blue;">
                                   </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Centrales de riesgo--}}
            <br>

            <div class="col-md-12 form-group">
                    <label class="col-sm-6 pull-left" for="inputEmail3">
                                ¿Posee reportes en centrales de riesgo ? <span></span> 
                    </label>
                    <div class="col-sm-6">
                        <label class="switchBtn">
                            {!! Form::checkbox("tiene_reportes_centrales",1,($candidatos->reportes_central!=null)?1:0,["class"=>"si_no","id"=>"tiene_reportes_centrales"]) !!}
                            <div class="slide"></div>
                        </label>
                    </div>
                    
            </div>

            <div id="section-reportes" class="box box-info collapsed-box col-sm-12">
                <div class="box-header with-border">
                    <h4 class="box-header with-border">Reportes en centrales de riesgo</h4>

                    
                </div>

                <div class="">
                    <div class="chart">
                        <div class="container" id="reportes-centrales">
                            @if($reportes=json_decode($candidatos->reportes_central))
                                @foreach($reportes as $re)
                                    <div class="row">

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Banco </label>
                                            </div>
                                            <div class="col-sm-12">
                                                {!! Form::select("banco_central[]",$bancos,$re->banco,["class"=>"form-control banco_tarjeta selectcategory"]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Tipo  de crédito</label>
                                            </div>
                                             {!! Form::select("tipo_credito_central[]",$tipos_credito,$re->tipo_credito,["class"=>"form-control tipo_credito_central selectcategory"]) !!}
                                        </div>

                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Dias/Mora</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam total_credito postular-cand solo_numeros" placeholder="Total" name="dias_mora_central[]" value="{{$re->dias_mora}}">
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-2 form-group">
                                            <div class="col-sm-12">
                                                <label>Acuerdo de pago</label>
                                            </div>
                                             {!! Form::select("acuerdo_pago_central[]",[1=>"Si","0"=>No],$re->acuerdo_pago,["class"=>"form-control acuerdo_pago selectcategory"]) !!}
                                        </div>

                                

                                        <div class="col-md-2 form-group last-child">
                                            <button type="button" class="btn btn-success add-reporte" title="Agregar">+</button>
                                            <span class="nota-add">Agregar otro reporte</span>
                                        </div>
                                        <div class="col-md-12">
                                           <hr/ style="border: 1px solid blue;">
                                       </div>
                                    </div>
                                @endforeach
                            @else

                            <div class="row">

                                <div class="col-md-2 form-group">
                                    <div class="col-sm-12">
                                        <label>Banco </label>
                                    </div>
                                    <div class="col-sm-12">
                                        {!! Form::select("banco_central[]",$bancos,null,["class"=>"form-control banco_tarjeta selectcategory"]) !!}
                                    </div>
                                </div>

                                <div class="col-md-2 form-group">
                                    <div class="col-sm-12">
                                        <label>Tipo de crédito</label>
                                    </div>
                                     {!! Form::select("tipo_credito_central[]",$tipos_credito,null,["class"=>"form-control tipo_credito_central selectcategory"]) !!}
                                </div>

                                <div class="col-md-2 form-group">
                                    <div class="col-sm-12">
                                        <label>Dias/Mora</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control form_cam total_credito postular-cand solo_numeros" placeholder="Total" name="dias_mora_central[]">
                                    </div>
                                </div>
                                
                                <div class="col-md-2 form-group">
                                    <div class="col-sm-12">
                                        <label>Acuerdo de pago</label>
                                    </div>
                                     {!! Form::select("acuerdo_pago_central[]",[1=>"Si","0"=>No],null,["class"=>"form-control acuerdo_pago selectcategory"]) !!}
                                </div>

                        

                                <div class="col-md-2 form-group last-child">
                                    <button type="button" class="btn btn-success add-reporte" title="Agregar">+</button>
                                    <span class="nota-add">Agregar otro reporte</span>
                                </div>
                                <div class="col-md-12">
                                   <hr/ style="border: 1px solid blue;">
                               </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="col-sm-12 pull-left" for="inputEmail3">
                                    Observaciones reportes negativos<span></span> 
                        </label>
                        <div class="col-sm-12">
                                     {!! Form::textarea("observaciones_reportes_negativos",$candidatos->observaciones_reportes_negativos,["class"=>"form-control selectcategory" ,"id"=>"observaciones_reportes_negativos","placeholder"=>"En este espacio de se deben registrar las observaciones de los reportes negativos (el valor en pesos de la cantidad por la cual se encuentra reportado) también especificar a quien pertenecen los créditos relacionados anteriormente, ya que pueden ser del evaluado a su conyugue.","rows"=>5]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>                
                </div>
            </div>

            <div>
                
            </div>
            
            @if($current_user->inRole('admin'))
                
                    <div class="col-sm-12">
                        <h4>Resumen ingresos y egresos del evaluado</h4>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th>Total ingresos del evaluado</th>
                                <td>$<input type="text" name="total_ingresos_2" class="total_ingresos" readonly="true" value="{{$candidatos->total_ingresos}}"></td>
                                
                            </tr>
                            <tr>
                                <th>Total egresos del evaluado</th>
                                <td>$<input type="text" name="total_egresos_2" class="total_egresos" readonly="true" value="{{$candidatos->total_egresos}}"></td>
                            </tr>
                            <tr>
                                <th>Ingreso neto</th>
                                <td>$<input type="text" name="ingreso_neto" id="ingreso_neto" readonly="true"></td>
                            </tr>
                        </table>
                    </div>
                
            @endif

            </div>
            @if($current_user->inRole('admin'))
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label class="col-sm-12 pull-left" for="inputEmail3">
                                    Observaciones<span></span> 
                        </label>
                        <div class="col-sm-12">
                                     {!! Form::textarea("observaciones_ingresos_egresos",$candidatos->observaciones_ingresos_egresos,["class"=>"form-control selectcategory" ,"id"=>"observaciones_ingresos_egresos","placeholder"=>"","required"=>true,"rows"=>5]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>                
                </div>
            @endif
                    
   

                    
                   
                
                </div>
            </form>
        </div>

</div>

<script type="text/javascript">


        function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
            return n === '' ? n : Number(n).toLocaleString();
        }

        function ingresoNeto(ingresos,egresos){
            var i=Number(String(ingresos).replace(/\D/g, ""));
            var e=Number(String(egresos).replace(/\D/g, ""));
            return Number(i-e).toLocaleString();
        }


    $(function(){

        @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
        @endif
        
        $("#section-creditos").hide();
        if( $("#tiene_creditos_bancarios").prop('checked') ) {
             $("#section-creditos").show();
        }
        $("#tiene_creditos_bancarios").on("change", function () {
            $("#section-creditos").toggle('slow');
        });

        $("#section-tarjetas").hide();
        if( $("#tiene_tarjetas_credito").prop('checked') ) {
             $("#section-tarjetas").show();
        }
        $("#tiene_tarjetas_credito").on("change", function () {
            $("#section-tarjetas").toggle('slow');
        });

        $("#section-reportes").hide();
        if( $("#tiene_reportes_centrales").prop('checked') ) {
             $("#section-reportes").show();
        }
        $("#tiene_reportes_centrales").on("change", function () {
            $("#section-reportes").toggle('slow');
        });
        $('.panel-body').delegate( '.monto', 'keyup', function(){
        
            //const element=$(this);
            const value = $(this).val();
            $(this).val(formatNumber(value));
        });

        $(".contable_total_ingreso").change(function(){
            let suma=0;
            let data=$(".contable_total_ingreso");
            $.each(data, function(key, element) {
                        suma+=Number(String(element.value).replace(/\D/g, ""));
                    });
            $(".total_ingresos").val(Number(suma).toLocaleString());

            @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
            @endif
            
        });
        $('.panel-body').delegate( '.contable_total_egreso', 'change', function(){
        
            let suma=0;
            let data=$(".contable_total_egreso");
            $.each(data, function(key, element) {
                        suma+=Number(String(element.value).replace(/\D/g, ""));
                        
                    });
            $(".total_egresos").val(Number(suma).toLocaleString());

            @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
            @endif
            
        });

        $(document).on('click', '.add-credito', function (e) {

                fila_person = $(this).parents('#creditos-bancarios').find('.row').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-credito">-</button>');

                $('#creditos-bancarios').append(fila_person);
            });

        $(document).on('click', '.rem-credito', function (e) {
            
            $(this).parents('#creditos-bancarios .row').remove();

            let suma=0;
            let data=$(".contable_total_egreso");
            $.each(data, function(key, element) {
                        suma+=Number(String(element.value).replace(/\D/g, ""));
                        
                    });
            $(".total_egresos").val(Number(suma).toLocaleString());

            @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
            @endif
        });

        $(document).on('click', '.add-tarjeta', function (e) {

                fila_person = $(this).parents('#tarjetas-credito').find('.row').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-tarjeta">-</button>');

                $('#tarjetas-credito').append(fila_person);
            });

        $(document).on('click', '.rem-tarjeta', function (e) {
            
            $(this).parents('#tarjetas-credito .row').remove();
            let suma=0;
            let data=$(".contable_total_egreso");
            $.each(data, function(key, element) {
                        suma+=Number(String(element.value).replace(/\D/g, ""));
                        
                    });
            $(".total_egresos").val(Number(suma).toLocaleString());

            @if($current_user->inRole('admin'))
                $("#ingreso_neto").val(ingresoNeto($(".total_ingresos").val(),$(".total_egresos").val()));
            @endif
        });


         $(document).on('click', '.add-reporte', function (e) {

                fila_person = $(this).parents('#reportes-centrales').find('.row').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-reporte">-</button>');

                $('#reportes-centrales').append(fila_person);
            });

        $(document).on('click', '.rem-reporte', function (e) {
            
            $(this).parents('#reportes-centrales .row').remove();
        });

        $("#ingresos_mensuales").change(function(){
            
            if($(this).val()!=0){

                $("#procedencia_ingresos_candidato").attr("required","required");
            }
            else{
                $("#procedencia_ingresos_candidato").removeAttr("required");
            }
        });

        $("#ingresos_mensuales_conyugue").change(function(){
            
            if($(this).val()!=0){

                $("#procedencia_ingresos_conyugue").attr("required","required");
            }
            else{
                $("#procedencia_ingresos_conyugue").removeAttr("required");
            }
        });

        $("#otros_ingresos_candidato").change(function(){
            
            if($(this).val()!=0){

                $("#procedencia_otros_ingresos").attr("required","required");
            }
            else{
                $("#procedencia_otros_ingresos").removeAttr("required");
            }
        });
        
        $("#egresos_mensuales").change(function(){
            
            if($(this).val()!=0){
                
                $("#procedencia_egresos_candidato").attr("required","required");
            }
            else{
                $("#procedencia_egresos_candidato").removeAttr("required");
            }
        });
        


    });
</script>