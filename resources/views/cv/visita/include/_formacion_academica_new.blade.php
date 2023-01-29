<div class="panel panel-default" >
    <div class="panel-heading">
        <h3>Formación académica</h3>
    </div>

    <div class="panel-body">
        <form id="form-6" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">
            
            <div class="" id="nuevo_formacion">
                <div class="old">
                    <div class="row padre">
                        <div class="item col-sm-12 " id="panel_academico">
                            @if(count($estudios) > 0)
                                <?php
                                    $cantidad_laboral = 1;
                                ?> 
                                @foreach($estudios as $es)
                                         {{-- {{ dd($estudios) }} --}}
                                    <div class="row col-md-12 padre_academico">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>
                                                    ¿Estudio actual?
                                                </label>
                                            
                                                {!! Form::select("fa_estudio_actual[]", 
                                                ["0" => "No", "1" => "Sí"],
                                                (($es->estudio_actual == 0) ? "0" : "1"), 
                                                ["class" => "form-control select_estudio_actual | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                "id" => "fa_estudio_actual[]"]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="institucion">Institución: <span class='text-danger sm-text-label'>*</span></label>
                
                                                {!! Form::text("fa_institucion[]", 
                                                    $es->institucion, [
                                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "placeholder" => "Institución",
                                                    "id" => "fa_institucion[]",
                                                    "required" => true
                                                ]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="titulo_obtenido">Titulo obtenido: <span class='text-danger sm-text-label'>*</span></label>
                            
                                                {!! Form::text("fa_titulo_obtenido[]", 
                                                    $es->titulo_obtenido, [
                                                    "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                    "id" => "fa_titulo_obtenido[]", 
                                                    "placeholder" => "Titulo obtenido",
                                                    "required" => true
                                                ]) !!}
                                            </div>
                                        </div>
                                        {{-- {{ dd($es->ciudad_estudio) }} --}}
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Ciudad: <span class='text-danger sm-text-label'>*</span></label>
                                                    {!! Form::select("fa_ciudad[]",
                                                    $ciudades_general,
                                                    $es->ciudad_estudio,
                                                    ["class"=>"form-control js-select2a | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "id"=>"fa_ciudad[]",
                                                    "required"=>true
                                                ]); !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nivel de estudios: <span class='text-danger sm-text-label'>*</span></label>
                                                {!! Form::select("fa_nivel_estudio[]",
                                                $nivelEstudios,
                                                $es->nivel_estudio_id,
                                                ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id"=>"fa_nivel_estudio[]",
                                                "required"=>true]); !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="semestres_cursados">Períodos cursados:</label>
                        
                                                {!! Form::select("fa_semestres_cursados[]", 
                                                    // ["" => "Seleccionar", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15], 
                                                    array('' => 'Seleccionar', 
                                                    '1' => '1', 
                                                    '2' => '2', 
                                                    '3' => '3', 
                                                    '4' => '4',
                                                    '5' => '5',
                                                    '6' => '6', 
                                                    '7' => '7', 
                                                    '8' => '8', 
                                                    '9' => '9',
                                                    '10' => '10',
                                                    '11' => '11', 
                                                    '12' => '12', 
                                                    '13' => '13', 
                                                    '14' => '14',
                                                    '15' => '15',
                                                    ),
                                                    $es->semestres_cursados, 
                                                    ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "id" => "fa_semestres_cursados[]",
                                                    "required" => true
                                                ]) !!}
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="periodicidad">
                                                    Periodicidad:   
                                                </label>
                
                                                {!! Form::select("fa_periodicidad[]", 
                                                $periodicidad, 
                                                $es->periodicidad, 
                                                ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                "id" => "fa_periodicidad[]",
                                                "required" => true]) !!}
                                            </div>
                                        </div>
                            
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="fecha_finalizacion">
                                                    Fecha finalización:
                                                </label>
                                                {{-- {!! Form::text("fa_fecha_finalizacion",
                                                $es->fecha_finalizacion,
                                                ["class"=>"form-control actual_fecha | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                "id"=>"fa_fecha_finalizacion", 
                                                "placeholder"=>"Fecha finalización", 
                                                "readonly" => "readonly",
                                                "required"=>true,
                                                ]) !!} --}}

                                                {!! Form::date("fa_fecha_finalizacion[]", 
                                                    $es->fecha_finalizacion, [
                                                    "max" => date('Y-m-d'),
                                                    "class" => "form-control actual_fecha | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                    "placeholder" => "Fecha finalización",
                                                    "id" => "fa_fecha_finalizacion[]",
                                                    "readonly"=> (($es->estudio_actual == "1")? true : false)
                                                ]) !!}
                                            </div>
                                        </div>                                                                                                                     

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Teléfono institución: <span class='text-danger sm-text-label'></span></label>
                                                <input 
                                                    type="text"
                                                    name="fa_telefono[]"
                                                    class="form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                                                    id="fa_telefono[]"
                                                    maxlength="10"
                                                    placeholder=""
                                                    value= {{ $es->telefono }}
                                                >
                                            </div>
                                        </div>

                                        {{-- @if($current_user->inRole("admin"))
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="Concepto">
                                                        Concepto(Evaluador) <span class='text-danger sm-text-label'>*</span>:   
                                                    </label>
                                                    {!! Form::textarea("fa_concepto[]",  
                                                    $es->concepto, 
                                                    ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                    "id" => "fa_concepto[]",
                                                    "rows"=>"3",
                                                    "required"=>true]) !!}
                                                </div>
                                            </div>
                                        @endif                                --}}

                                        <div class="col-md-12 form-group last-child-academico" style="display: block;text-align:center;">
                                            <button type="button" class="btn btn-success add-academico | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar otro estudio</button>
                                            @if($cantidad_laboral > 1)
                                                <button type="button" class="btn btn-danger rem-academico | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                            @endif
                                        </div> 

                                    </div>
                                    <?php
                                        $cantidad_laboral ++;
                                    ?> 
                                @endforeach  
                            @else
                                <div class="row col-md-12 padre_academico">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>
                                                ¿Estudio actual?
                                            </label>
                                        
                                            {!! Form::select("fa_estudio_actual[]", 
                                            ["0" => "No", "1" => "Sí"],
                                            (($es->estudio_actual == 0) ? "0" : "1"), 
                                            ["class" => "form-control select_estudio_actual | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                            "id" => "fa_estudio_actual[]"]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="institucion">Institución: <span class='text-danger sm-text-label'>*</span></label>
            
                                            {!! Form::text("fa_institucion[]", 
                                                $es->institucion, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "placeholder" => "Institución",
                                                "id" => "fa_institucion[]",
                                                "required" => true
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="titulo_obtenido">Titulo obtenido: <span class='text-danger sm-text-label'>*</span></label>
                        
                                            {!! Form::text("fa_titulo_obtenido[]", 
                                                $es->titulo_obtenido, [
                                                "class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                "id" => "fa_titulo_obtenido[]", 
                                                "placeholder" => "Titulo obtenido",
                                                "required" => true
                                            ]) !!}
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Ciudad: <span class='text-danger sm-text-label'>*</span></label>
                                                {!! Form::select("fa_ciudad[]",
                                                $ciudades_general,
                                                null,
                                                ["class"=>"form-control js-select2a | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id"=>"fa_ciudad[]",
                                                "required"=>true
                                            ]); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Nivel de estudios: <span class='text-danger sm-text-label'>*</span></label>
                                            {!! Form::select("fa_nivel_estudio[]",
                                            $nivelEstudios,
                                            $es->nivel_estudio_id,
                                            ["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                            "id"=>"fa_nivel_estudio[]",
                                            "required"=>true]); !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="semestres_cursados">Períodos cursados:</label>
                    
                                            {!! Form::select("fa_semestres_cursados[]", 
                                                // ["" => "Seleccionar", 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15], 
                                                array('' => 'Seleccionar', 
                                                    '1' => '1', 
                                                    '2' => '2', 
                                                    '3' => '3', 
                                                    '4' => '4',
                                                    '5' => '5',
                                                    '6' => '6', 
                                                    '7' => '7', 
                                                    '8' => '8', 
                                                    '9' => '9',
                                                    '10' => '10',
                                                    '11' => '11', 
                                                    '12' => '12', 
                                                    '13' => '13', 
                                                    '14' => '14',
                                                    '15' => '15',
                                                    ),
                                                $es->semestres_cursados, 
                                                ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "id" => "fa_semestres_cursados[]",
                                                "required" => true
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="periodicidad">
                                                Periodicidad:   
                                            </label>
            
                                            {!! Form::select("fa_periodicidad[]", 
                                            $periodicidad, 
                                            $es->periodicidad, 
                                            ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                            "id" => "fa_periodicidad[]",
                                            "required" => true]) !!}
                                        </div>
                                    </div>
                        
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="fecha_finalizacion">
                                                Fecha finalización:
                                            </label>
                                            {!! Form::date("fa_fecha_finalizacion[]", 
                                                $es->fecha_finalizacion, [
                                                "max" => date('Y-m-d'),
                                                "class" => "form-control actual_fecha | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                                                "placeholder" => "Fecha finalización",
                                                "id" => "fa_fecha_finalizacion[]",
                                                "readonly"=> (($es->estudio_actual == "1")? true : false)
                                            ]) !!}
                                        </div>
                                    </div>                                                                                                                     

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Teléfono institución: <span class='text-danger sm-text-label'></span></label>
                                            <input 
                                                type="text"
                                                name="fa_telefono[]"
                                                class="form-control solo_numeros | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                                                id="fa_telefono[]"
                                                maxlength="10"
                                                placeholder=""
                                                value= {{ $es->telefono }}
                                            >
                                        </div>
                                    </div>

                                    {{-- @if($current_user->inRole("admin"))
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="Concepto">
                                                    Concepto(Evaluador) <span class='text-danger sm-text-label'>*</span>:   
                                                </label>
                                                {!! Form::textarea("fa_concepto[]",  
                                                null, 
                                                ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", 
                                                "id" => "fa_concepto[]",
                                                "rows"=>"3",
                                                "required"=>true]) !!}
                                            </div>
                                        </div>
                                    @endif --}}
              
                                    <div class="col-md-12 form-group last-child-academico" style="display: block;text-align:center;">
                                        <button type="button" class="btn btn-success add-academico | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" title="Agregar"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar otro estudio</button>
                                        @if($cantidad_formacion > 1)
                                            <button type="button" class="btn btn-danger rem-academico | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>
                                        @endif
                                    </div> 

                                </div>
                            @endif
                        
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function() {
        $(".js-select2a").select2({
            dropdownAutoWidth : true,
            closeOnSelect: true
        });
    });

    $(function(){
        var confDatepicker = {
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonImage: "img/gifs/018.gif",
            buttonImageOnly: true,
            autoSize: true,
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            maxDate: '+0d',
            yearRange: "1930:2050"
        };

        //$(".actual_fecha").datepicker(confDatepicker);
    

        //evalua el campo es estudio actual?...
        $('.panel-body').delegate('.select_estudio_actual', 'change', function(){

            var actual_fecha = $(this).parents('.padre_academico').find('.actual_fecha').eq(0); 
            var actual = Number($(this).val().replaceAll('.', '')); //1 si; 2 no
            // var actual_motivo = $(this).parents('.padre_academico').find('.actual_motivo').eq(0);

            // si actual es no = 0; deshabilita fecha fin y motivo del retiro
            if(actual == 0 ){
                    
                actual_fecha.removeAttr("readonly");
                actual_fecha.attr("required","required");

                // actual_motivo.prop('selectedIndex',1);
                // actual_motivo.attr("required","required");
                // actual_motivo.prop('disabled', false);
                
            }
            else{
                actual_fecha.val("");
                actual_fecha.attr("readonly","true");
                actual_fecha.removeAttr("required");

                // actual_motivo.prop('selectedIndex',1);
                // actual_motivo.removeAttr("required");
                // actual_motivo.prop('disabled', true);  
            }
        });

        //clona el primer hijo, le reinicia los inputs y selects
        $(document).on('click', '.add-academico', function (e) {
            $('.js-select2a').select2("destroy");
            var numItems = $('div.last-child-academico').length;
            fila_person = $(this).parents('.old').find('.padre_academico').eq(0).clone(true);
            fila_person.find('input').val('').removeAttr("readonly");
            fila_person.find(':selected').removeAttr('selected')
            //fila_person.find('input.actual_fecha').datepicker(confDatepicker);
            // fila_person.find('.actual_fecha').val('').attr("disabled", false);
            // fila_person.find('.actual_fecha').val('').attr("readonly","true");
            // fila_person.find('.actual_fecha')
            // .removeClass('hasDatepicker')
            // .removeData('datepicker')
            // .unbind()
            // .datepicker({
            //     altFormat: "yy-mm-dd",
            //     dateFormat: "yy-mm-dd",
            //     changeMonth: true,
            //     changeYear: true,
            //     buttonImage: "img/gifs/018.gif",
            //     buttonImageOnly: true,
            //     autoSize: true,
            //     dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            //     monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            //     dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            //     maxDate: '+0d',
            //     yearRange: "1930:2050"
            // });

            fila_person.find('.actual_fecha').attr("required","required");
            fila_person.find('div.last-child-academico').append('<button type="button" class="btn btn-danger rem-academico | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red"><i class="fa fa-minus-circle" aria-hidden="true"></i> Eliminar</button>');
            
            $(this).parents('.old').find('.item').append(fila_person);
            $(".js-select2a").select2({
                dropdownAutoWidth : true,
                closeOnSelect: true
            })
        });

        //eliminar el hijo clickado
        $(document).on('click', '.rem-academico', function (e) {
            $(this).parents(".padre_academico").remove();
        });

    });
</script>