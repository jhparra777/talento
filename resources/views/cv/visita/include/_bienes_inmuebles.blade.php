<div class="panel panel-default item">
        <div class="panel-heading">
            <h3>Bienes inmuebles y vehículos del evaluado</h3>
        </div>
        <div class="panel-body">
            
            <form id="form-5" data-smk-icon="glyphicon-remove-sign" name="form-3" class="formulario">
                <div class="row">
                <div class="col-md-12 form-group">
                    <label class="col-sm-6 pull-left" for="inputEmail3">
                                ¿Posee bienes inmuebles? <span></span> 
                    </label>
                    <div class="col-sm-6">
                        <label class="switchBtn">
                            {!! Form::checkbox("tiene_bienes_inmuebles",1,($candidatos->inmuebles!=null)?1:0,["class"=>"si_no","id"=>"tiene_bienes_inmuebles"]) !!}
                            <div class="slide"></div>
                        </label>
                    </div>
                    
                </div>
                    <div id="section-inmuebles" class="box box-info collapsed-box col-sm-12">
                <div class="box-header with-border">
                    <h4 class="box-header with-border">Inmuebles</h4>

                    
                </div>

                

                <div class="" >
                    <div class="chart">
                        <div class="container" id="inmuebles">
                            @if($inmuebles=json_decode($candidatos->inmuebles))
                                <?php
                                    $cantidad_inmuebles=1;
                                ?>
                                @foreach($inmuebles as $in)
                                    <div class="row" style="height: 100px;">

                                        <div class="col-md-3 form-group">
                                            <div class="col-sm-12">
                                                <label>Tipo </label>
                                            </div>
                                            <div class="col-sm-12">
                                                {!! Form::select("tipo_inmueble[]",$tipos_inmuebles,$in->tipo,["class"=>"form-control tipo_inmueble_bienes selectcategory"]) !!}
                                            </div>
                                        </div>

                                       <div class="col-md-3 form-group">
                                            <div class="col-sm-12">
                                                <label>Valor</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam valor_inmueble postular-cand solo_numeros monto" placeholder="Valor" name="valor_inmueble_bienes[]" value="{{$in->valor}}">
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-group porcent">
                                            <div class="col-sm-8">
                                                <label>Participación</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>%</label>
                                            </div>
                                            <div class="col-sm-8">
                                                 {!! Form::select("participacion_inmueble_bienes[]",[1=>"Único",2=>"%",3=>"N/A"],$in->participacion,["class"=>"form-control participacion_inmueble_bienes selectcategory"]) !!}
                                            </div>
                                            <div class="col-sm-4">
                                                {!! Form::text("porcentaje_inmueble[]",$in->porcentaje,["class"=>"form-control selectcategory porcentaje_inmueble","readonly"=>true]) !!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-3 form-group">
                                            <div class="col-sm-12">
                                                <label>Observaciones</label>
                                            </div>
                                            <div class="col-sm-12">
                                                {!! Form::textarea("observaciones_inmuebles[]",$in->observaciones,["class"=>"form-control selectcategory" ,"id"=>"observaciones_inmuebles","rows"=>2,"placeholder"=>"Puede especificar el lugar donde está ubicado y si es su residencia actual"]) !!}
                                                
                                            </div>
                                        </div>

                                

                                        <div class="col-md-12 form-group last-child text-center">
                                            <button type="button" class="btn btn-success add-inmueble" title="Agregar">+</button>
                                            <span class="nota-add">Agregar otro inmueble</span>
                                            @if($cantidad_inmuebles>1)
                                                <button type="button" class="btn btn-danger rem-inmueble">-</button>
                                            @endif

                                        </div>
                                        <div class="col-md-12">
                                           <hr/ style="border: 1px solid blue;">
                                       </div>
                                </div>
                                <?php
                                    $cantidad_inmuebles++;
                                ?>
                                @endforeach
                            @else
                            <div class="row" style="height: 100px;">

                                <div class="col-md-3 form-group">
                                    <div class="col-sm-12">
                                        <label>Tipo </label>
                                    </div>
                                    <div class="col-sm-12">
                                        {!! Form::select("tipo_inmueble[]",$tipos_inmuebles,null,["class"=>"form-control tipo_inmueble_bienes selectcategory"]) !!}
                                    </div>
                                </div>

                               <div class="col-md-3 form-group">
                                    <div class="col-sm-12">
                                        <label>Valor</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control form_cam valor_inmueble postular-cand solo_numeros monto" placeholder="Valor" name="valor_inmueble_bienes[]">
                                    </div>
                                </div>

                                <div class="col-md-3 form-group porcent">
                                    <div class="col-sm-8">
                                        <label>Participación</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>%</label>
                                    </div>
                                    <div class="col-sm-8">
                                         {!! Form::select("participacion_inmueble_bienes[]",[1=>"Único",2=>"%",3=>"N/A"],null,["class"=>"form-control participacion_inmueble_bienes selectcategory"]) !!}
                                    </div>
                                    <div class="col-sm-4">
                                        {!! Form::text("porcentaje_inmueble[]",null,["class"=>"form-control selectcategory porcentaje_inmueble","readonly"=>true]) !!}
                                    </div>
                                </div>
                                
                                <div class="col-md-3 form-group">
                                    <div class="col-sm-12">
                                        <label>Observaciones</label>
                                    </div>
                                    <div class="col-sm-12">
                                        {!! Form::textarea("observaciones_inmuebles[]",null,["class"=>"form-control selectcategory" ,"id"=>"observaciones_inmuebles","rows"=>2,"placeholder"=>"Puede especificar el lugar donde está ubicada y si es su residencia actual"]) !!}
                                        
                                    </div>
                                </div>

                        

                                <div class="col-md-12 form-group last-child text-center">
                                    <button type="button" class="btn btn-success add-inmueble" title="Agregar">+</button>
                                    <span class="nota-add">Agregar otro inmueble</span>
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

            <br>
            {{-- Vehiculos --}}

            <div class="col-md-12 form-group">
                    <label class="col-sm-6 pull-left" for="inputEmail3">
                                ¿Posee vehículos? <span></span> 
                    </label>
                    <div class="col-sm-6">
                        <label class="switchBtn">
                            {!! Form::checkbox("tiene_vehiculos",1,($candidatos->vehiculos!=null)?1:0,["class"=>"si_no","id"=>"tiene_vehiculos"]) !!}
                            <div class="slide"></div>
                        </label>
                    </div>
                    
            </div>
            <div id="section-vehiculos" class="box box-info collapsed-box col-sm-12">
                <div class="box-header with-border">
                    <h4 class="box-header with-border">Vehículos</h4>

                    
                </div>

                <div class="">
                    <div class="chart">
                        <div class="container" id="vehiculos">
                            @if($vehiculos=json_decode($candidatos->vehiculos))
                                <?php
                                    $cantidad_vehiculos=1;
                                ?>
                                @foreach($vehiculos as $ve)
                                    <div class="row">

                                        <div class="col-md-4 form-group">
                                            <div class="col-sm-12">
                                                <label>Tipo </label>
                                            </div>
                                            <div class="col-sm-12">
                                                {!! Form::select("tipo_vehiculo_bienes[]",$tipos_vehiculos,$ve->tipo,["class"=>"form-control tipo_inmueble_bienes selectcategory"]) !!}
                                            </div>
                                        </div>

                                       <div class="col-md-4 form-group">
                                            <div class="col-sm-12">
                                                <label>Valor</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam valor_inmueble postular-cand solo_numeros monto" placeholder="Valor" name="valor_vehiculo_bienes[]" value="{{$ve->valor}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="col-sm-12">
                                                <label>Modelo</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam valor_inmueble postular-cand" placeholder="Modelo" name="modelo_vehiculo_bienes[]" value="{{$ve->modelo}}">
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="col-sm-12">
                                                <label>Placas</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control form_cam valor_inmueble postular-cand" placeholder="Placa" name="placas_vehiculos_bienes[]" value="{{$ve->placas}}">
                                            </div>
                                        </div>

                                        <div class="col-md-4 form-group porcent">
                                            <div class="col-sm-8">
                                                <label>Participación</label>
                                            </div>
                                            <div class="col-sm-4">
                                                <label>%</label>
                                            </div>
                                            <div class="col-sm-6">
                                                 {!! Form::select("participacion_vehiculo_bienes[]",[1=>"Único",2=>"%",3=>"N/A"],$ve->participacion,["class"=>"form-control participacion_vehiculo_bienes selectcategory"]) !!}
                                            </div>
                                            <div class="col-sm-6">
                                                {!! Form::text("porcentaje_vehiculo[]",$ve->porcentaje,["class"=>"form-control selectcategory porcentaje_vehiculo" ,"id"=>"porcentaje_vehiculo","readonly"=>true]) !!}
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 form-group">
                                            <div class="col-sm-12">
                                                <label>Observaciones</label>
                                            </div>
                                            <div class="col-sm-12">
                                                {!! Form::textarea("observaciones_vehiculos[]",$ve->observaciones,["class"=>"form-control selectcategory" ,"id"=>"observaciones_vehiculos","rows"=>"2"]) !!}
                                                
                                            </div>
                                        </div>

                                

                                        <div class="col-md-12 form-group last-child text-center">
                                            <button type="button" class="btn btn-success add-vehiculo" title="Agregar">+</button>
                                            <span class="nota-add">Agregar otro vehículo</span>
                                            @if($cantidad_vehiculos>1)
                                                <button type="button" class="btn btn-danger rem-vehiculo">-</button>
                                            @endif
                                        </div>
                                        <div class="col-md-12">
                                           <hr/ style="border: 1px solid blue;">
                                       </div>
                                    </div>
                                    <?php
                                        $cantidad_vehiculos++;
                                    ?>
                                @endforeach
                            @else

                            <div class="row">

                                <div class="col-md-4 form-group">
                                    <div class="col-sm-12">
                                        <label>Tipo </label>
                                    </div>
                                    <div class="col-sm-12">
                                        {!! Form::select("tipo_vehiculo_bienes[]",$tipos_vehiculos,null,["class"=>"form-control tipo_inmueble_bienes selectcategory"]) !!}
                                    </div>
                                </div>

                               <div class="col-md-4 form-group">
                                    <div class="col-sm-12">
                                        <label>Valor</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control form_cam valor_inmueble postular-cand solo_numeros monto" placeholder="Valor" name="valor_vehiculo_bienes[]">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="col-sm-12">
                                        <label>Modelo</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control form_cam valor_inmueble postular-cand" placeholder="Modelo" name="modelo_vehiculo_bienes[]">
                                    </div>
                                </div>
                                <div class="col-md-4 form-group">
                                    <div class="col-sm-12">
                                        <label>Placas</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control form_cam valor_inmueble postular-cand" placeholder="placas" name="placas_vehiculos_bienes[]">
                                    </div>
                                </div>

                                <div class="col-md-4 form-group porcent">
                                    <div class="col-sm-8">
                                        <label>Participación</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label>%</label>
                                    </div>
                                    <div class="col-sm-6">
                                         {!! Form::select("participacion_vehiculo_bienes[]",[1=>"Único",2=>"%",3=>"N/A"],null,["class"=>"form-control participacion_vehiculo_bienes selectcategory"]) !!}
                                    </div>
                                    <div class="col-sm-6">
                                        {!! Form::text("porcentaje_vehiculo[]",null,["class"=>"form-control porcentaje_vehiculo" ,"id"=>"porcentaje_vehiculo","readonly"=>true]) !!}
                                    </div>
                                </div>
                                
                                <div class="col-md-4 form-group">
                                    <div class="col-sm-12">
                                        <label>Observaciones</label>
                                    </div>
                                    <div class="col-sm-12">
                                        {!! Form::textarea("observaciones_vehiculos[]",null,["class"=>"form-control selectcategory" ,"id"=>"observaciones_vehiculos","rows"=>"2","placeholder"=>"Indicar características adicionales como marca del vehículo"]) !!}
                                        
                                    </div>
                                </div>

                        

                                <div class="col-md-12 form-group last-child text-center">
                                    <button type="button" class="btn btn-success add-vehiculo" title="Agregar">+</button>
                                    <span class="nota-add">Agregar otro vehiculo</span>
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
                </div>
            </form>
        </div>

</div>

<script type="text/javascript">
    $(function(){
        let data=$(".porcentaje_inmueble");
        $.each(data, function(key, element) {
            if(element.value){
                 element.removeAttribute("readonly");
            }
        });

        let data2=$(".porcentaje_vehiculo");
        $.each(data2, function(key, element) {
            if(element.value){
                 element.removeAttribute("readonly");
            }
        });

        $('.panel-body').delegate('.participacion_inmueble_bienes', 'change', function(){

            //var porcentaje = $(this).parents('.row').find('.porcentaje_inmueble').eq(0);
            var porcentaje = $(this).parents('.porcent').find('.porcentaje_inmueble').eq(0);
            //var porcentaje = $(this).siblings('.porcentaje_inmueble');
            if($(this).val()==2){
                
                porcentaje.removeAttr("readonly");
            }
            else{
                porcentaje.val("");
                porcentaje.attr("readonly","true");
            }
            
            
        });

        $('.panel-body').delegate( '.participacion_vehiculo_bienes', 'change', function(){
            var porcentaje2 = $(this).parents('.porcent').find('.porcentaje_vehiculo').eq(0);
           
            if($(this).val()==2){
                
                porcentaje2.removeAttr("readonly");
            }
            else{
                porcentaje2.val("");
                porcentaje2.attr("readonly","true");
            }
            
            
        });

        $("#section-inmuebles").hide();
        if( $("#tiene_bienes_inmuebles").prop('checked') ) {
             $("#section-inmuebles").show();
        }
        $("#tiene_bienes_inmuebles").on("change", function () {
            $("#section-inmuebles").toggle('slow');
        });


        $("#section-vehiculos").hide();
        if( $("#tiene_vehiculos").prop('checked') ) {
             $("#section-vehiculos").show();
        }
        $("#tiene_vehiculos").on("change", function () {
            $("#section-vehiculos").toggle('slow');
        });
       $(document).on('click', '.add-inmueble', function (e) {

                fila_person = $(this).parents('#inmuebles').find('.row').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('textarea').val('');
                fila_person.find('.porcentaje_inmueble').attr("readonly","true");
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-inmueble">-</button>');

                $('#inmuebles').append(fila_person);
            });

        $(document).on('click', '.rem-inmueble', function (e) {
            
            $(this).parents('#inmuebles .row').remove();
        });

        $(document).on('click', '.add-vehiculo', function (e) {

                fila_person = $(this).parents('#vehiculos').find('.row').eq(0).clone();
                fila_person.find('input').val('');
                fila_person.find('textarea').val('');
                fila_person.find('.porcentaje_vehiculo').attr("readonly","true");
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-vehiculo">-</button>');

                $('#vehiculos').append(fila_person);
            });

        $(document).on('click', '.rem-vehiculo', function (e) {
            
            $(this).parents('#vehiculos .row').remove();
        });
    });
</script>