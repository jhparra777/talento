<style type="text/css">
    .confirmacion{ background:#C6FFD5; border:1px solid green; }
    .negacion{ background:#ffcccc; border:1px solid red; }
</style>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>

    <h4 class="modal-title">
        Editar
        {{ (route("home") == "https://gpc.t3rsc.co") ? 'aprobar' : 'contratación' }} :
        
        <strong>
            {{ ($candidato) ? $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido : "" }}
        </strong>
    </h4>
</div>

<div class="modal-body">
    {!! Form::model(Request::all(), ["id" => "fr_informacion_contratacion", "data-smk-icon" => "fa fa-times-circle"]) !!}
        {!! Form::hidden("candidato_req", ($candidato) ? $candidato->req_candidato : '', ["id" => "candidato_req_fr"]) !!}
        {!! Form::hidden("cliente_id", null) !!}
        {!! Form::hidden("user_id", $user_id) !!}
        {!! Form::hidden("req_id", $req_id) !!}

        <h3 style="margin: 0; margin-bottom: 4rem;">
            Editar datos de {{ (route("home") == "https://gpc.t3rsc.co") ? 'aprobar' : 'contratación' }}
        </h3>

        {{-- Fecha ingreso --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Fecha Ingreso *</label>

            <div class="col-sm-8">
                {!! Form::text("fecha_ingreso_contra", ($dato_contrato) ? $dato_contrato->fecha_ingreso : null, [
                    "class" => "form-control",
                    "id" => "fecha_ingreso_contra",
                    "required" => "required",
                    "readonly" => "readonly"
                ]); !!}
            </div>
        </div>

        {{-- Observaciones --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Observaciones *</label>
            
            <div class="col-sm-8">
                {!! Form::textarea("observaciones", $dato_contrato->observaciones, [
                    "class" => "form-control",
                    "rows" =>'2',
                    "id" => "observacion",
                    "required" => "required"
                ]) !!}
            </div>
            
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones", $errors) !!}</p>
        </div>
        
        {{-- Salario --}}
        @if(route("home") == "https://gpc.t3rsc.co")
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Salario</label>
                
                <div class="col-sm-8">
                    {!!Form::text("salario", null, ["class" => "form-control"]);!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("salario", $errors) !!}</p>
            </div>
        @endif

        @if(route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co")
            {{-- Otros devengos --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Otros devengos:</label>
                
                <div class="col-sm-8">
                    <textarea
                        name="otros_devengos"
                        class="form-control"
                        rows="2"
                        @if(route("home") == "https://komatsu.t3rsc.co") readonly="true" @endif
                    >{{ $requerimiento->observaciones }}</textarea>
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("otros_devengos", $errors) !!}</p>
            </div>            
            
            {{-- Lugar contacto --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Lugar contacto:</label>
                
                <div class="col-sm-8">
                    <textarea
                        name="lugar_contacto"
                        class="form-control"
                        rows="2"
                        @if(route("home") == "https://komatsu.t3rsc.co") readonly="true" @endif
                    ></textarea>
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("lugar_contacto", $errors) !!}</p>
            </div>
            
            {{-- Hora de ingreso --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Hora de ingreso:</label>
                
                <div class="col-sm-8">
                    {!! Form::text("hora_ingreso", null, ["class" => "form-control", "id" => "datetimepicker1"]); !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso", $errors) !!}</p>
            </div>
        @endif

        {{-- Hora de ingreso --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Hora de ingreso:</label>

            <div class="col-sm-8">
                {!! Form::time("hora_ingreso", $dato_contrato->hora_ingreso, [
                    "class" => "form-control",
                    "id" => "time-inicio"
                ]); !!}
            </div>
    
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso", $errors) !!}</p>
        </div>

        {{-- Tipo Ingreso --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Tipo Ingreso:</label>

            <div class="col-sm-8">
                <select name="tipo_ingreso" id="tipo_ingreso" class="form-control" onchange="tipoIngresoChange(this)">
                    <option value="">Seleccionar</option>
                    @if($dato_contrato->tipo_ingreso == 1)
                        <option value="1" selected>Nuevo</option>
                        <option value="2" >Reingreso</option>
                    @elseif($dato_contrato->tipo_ingreso == 2)
                        <option value="1">Nuevo</option>
                        <option value="2" selected>Reingreso</option>
                    @endif
                </select>
            </div>

            <p class="error text-danger direction-botones-center">  {!! FuncionesGlobales::getErrorData("auxilio_transporte", $errors) !!} </p>
        </div>

        {{-- Fecha fin ultimo contrato --}}
        <div
            class="col-md-12 form-group"
            id="fecha_fin_ultimo"
            @if($dato_contrato->tipo_ingreso == 1) hidden @endif
        >
            <label for="inputEmail3" class="col-sm-4 control-label">Fecha fin ultimo contrato:</label>

            <div class="col-sm-8">
                {!! Form::text(
                    "fecha_fin_ultimo",
                    $dato_contrato->fecha_ultimo_contrato,
                    ["class" => "form-control", "id" => "fecha_fin_ultimo_field", "readonly" => "readonly"]
                ); !!}
            </div>
        </div>

        {{-- Centro de costos --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Centro de costos *</label>
            
            <div class="col-sm-8">
                {!! Form::select(
                    "centro_costos",
                    $centros_costos,
                    (!empty($requerimiento_contrato_cc->centro_costo_id)) ? $requerimiento_contrato_cc->centro_costo_id : $centro_costo->centro_costo,
                    ["class" => "form-control", "id" => "centro_costos", "required" => "required"]
                ); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("centro_costos", $errors) !!}</p>
        </div>

        {{-- Auxilio de Transporte --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Auxilio de Transporte: </label>

            <div class="col-sm-8">
                <select name="auxilio_transporte" class="form-control">
                    <option
                        value="No se Paga"
                        @if($dato_contrato)
                            @if($dato_contrato->auxilio_transporte == 'No se Paga') selected @endif 
                        @endif
                    >
                        No se paga
                    </option>

                    <option
                        value="Total"
                        @if($dato_contrato)
                            @if($dato_contrato->auxilio_transporte == 'Total') selected @endif
                        @endif
                    >
                        Total
                    </option>

                    <option
                        value="Mitad"
                        @if($dato_contrato)
                            @if($dato_contrato->auxilio_transporte == 'Mitad') selected @endif
                        @endif
                    >
                        Mitad
                    </option>
                </select>
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("auxilio_transporte", $errors) !!}</p>
        </div>

        {{-- EPS --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">EPS:</label>
            
            <div class="col-sm-8">
                {!! Form::select("entidad_eps", $eps, $candidato->entidad_eps, [
                    "class" => "form-control selectcategory",
                    "id" => "entidad_eps"
                ]) !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("eps", $errors) !!}</p>
        </div>

        {{-- Fondo Pensiones --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Fondo Pensiones:</label>

            <div class="col-sm-8">
                {!! Form::select("entidad_afp", $afp, $candidato->entidad_afp, [
                    "class" => "form-control selectcategory",
                    "id" => "entidad_afp"
                ]) !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fondo_pensiones", $errors) !!}</p>
        </div>

        {{-- Caja de Compensaciones --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Caja de Compensaciones:</label>

            <div class="col-sm-8">
                {!! Form::select("caja_compensacion", $caja_compensaciones, $candidato->caja_compensaciones, [
                    "class" => "form-control selectcategory",
                    "id" => "caja_compensacion"
                ]) !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("caja_compensacion", $errors) !!}</p>
        </div>

        {{-- ARL --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> ARL:</label>
            
            <div class="col-sm-8">
                {!!Form::text("arl", 'Colpatria', ["class" => "form-control", "id" => "arl", "readonly" => "readonly"]);!!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("caja_compensacion", $errors) !!}</p>
        </div>

        {{-- Fondo De Cesantías --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Fondo De Cesantías:</label>

            <div class="col-sm-8">
                {!! Form::select("fondo_cesantias", $fondo_cesantias, $candidato->fondo_cesantias, [
                    "class" => "form-control selectcategory",
                    "id" => "fondo_cesantias"
                ]) !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fondo_cesantias", $errors) !!}</p>
        </div>

        {{-- Nombre del Banco --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Nombre del Banco:</label>
            
            <div class="col-sm-8">
                {!!Form::select("nombre_banco", $bancos, $candidato->nombre_banco, [
                    "class" => "form-control selectcategory",
                    "id" => "nombre_banco"
                ])!!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_banco", $errors) !!}</p>
        </div>

        {{-- Tipo Cuenta --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Tipo Cuenta:</label>
            
            <div class="col-sm-8">
                <select name="tipo_cuenta" class="form-control">
                    <option value="Ahorro" @if($candidato->tipo_cuenta == 'Ahorro') selected @endif>Ahorro</option>
                    <option value="Corriente" @if($candidato->tipo_cuenta == 'Corriente') selected @endif>Corriente</option>
                </select>
            </div>
        
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_cuenta", $errors) !!}</p>
        </div>

        {{-- Número Cuenta --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Número Cuenta:</label>

            <div class="col-sm-8">
                <input
                    type="number"
                    name="numero_cuenta"
                    class="form-control solo-numero"
                    value="{{ ($candidato->numero_cuenta != 0) ? $candidato->numero_cuenta : '' }}"
                    id="numero_cuenta"
                >
            </div>
        
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
        </div>

        {{-- Confirmar Cuenta --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">Confirmar Cuenta:</label>

            <div class="col-sm-8">
                <input type="number" name="confirm_numero_cuenta" class="form-control solo-numero" id="confirm_numero_cuenta">
            </div>
        
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
        </div>

        {{-- Fecha Fin Contrato --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Fin Contrato: </label>
            
            <div class="col-sm-8">
                <input
                    type="text"
                    name="fecha_fin_contrato"
                    value="{{ $dato_contrato->fecha_fin_contrato }}"
                    class="form-control"
                    id="fecha_fin_contrato"
                    readonly
                >
            </div>
            
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato", $errors) !!}</p>
        </div>

        {{-- Quién autorizó --}}
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label">¿Quién autorizó contratación? *</label>
            
            <div class="col-sm-8">
                {!! Form::select("user_autorizacion", $usuarios_clientes, $contra_clientes->user_autorizacion, [
                    "class" => "form-control",
                    "id" => "user_autorizacion",
                    "required" => "required"
                ]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
        </div>

        @if(route("home") == "https://humannet.t3rsc.co")
            {{-- ¿Puede trabajar de día --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> ¿Puede trabajar de día?: </label>
                
                <div class="col-sm-8">
                    {!! Form::select("trabajo_dia", ['si' => "Si", 'no' => "No"], null, [
                        "class" => "form-control selectcategory", "id" => "trabajo_dia"
                    ]) !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("trabajo_dia", $errors) !!}</p>
            </div>
            
            {{-- Puede trabajar de noche --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> ¿Puede trabajar de noche?: </label>
                
                <div class="col-sm-8">
                    {!! Form::select("trabajo_noche", ['si' => "Si", 'no' => "No"], null, [
                        "class" => "form-control selectcategory",
                        "id" => "trabajo_noche"
                    ]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("trabajo_noche", $errors) !!}</p>
            </div>
            
            {{-- Puede trabajar fines de semana --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> ¿Puede trabajar fines de semana?:</label>

                <div class="col-sm-8">
                    {!! Form::select("tabajo_fin", ['si' => "Si", 'no' => "No"], null, [
                        "class" => "form-control selectcategory", "id" => "tabajo_fin"
                    ]) !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tabajo_fin", $errors) !!}</p>
            </div>
            
            {{-- Puede trabajar part time --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> ¿Puede trabajar part time?:</label>
                
                <div class="col-sm-8">
                    {!! Form::select("part_time", ['si' => "Si", 'no' => "No"], null, ["class" => "form-control", "id" => "part_time"]); !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("part_time", $errors) !!}</p>
            </div>
        
            {{-- Comentarios --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Comentarios:</label>

                <div class="col-sm-8">
                    {!! Form::textarea("comentarios", null, ["class" => "form-control selectcategory", "id" => "comentarios"]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("comentarios", $errors) !!}</p>
            </div>
            
            {{-- Nombre del Banco --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Nombre del Banco:</label>

                <div class="col-sm-8">
                    {!!Form::select("nombre_banco", $bancos, $candidato->nombre_banco, [
                        "class" => "form-control selectcategory", "id" => "nombre_banco"
                    ])!!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_banco", $errors) !!}</p>
            </div>
            
            {{-- Tipo Cuenta --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Tipo Cuenta:</label>
                
                <div class="col-sm-8">
                    <select name="tipo_cuenta" class="form-control">
                        <option value="Ahorro" @if($candidato->tipo_cuenta == 'Ahorro') selected @endif > Ahorro </option>
                        <option value="Corriente" @if($candidato->tipo_cuenta == 'Corriente') selected @endif > Corriente </option>
                    </select>
                </div>
            
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_cuenta", $errors) !!}</p>
            </div>
            
            {{-- Número Cuenta --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Número Cuenta:</label>

                <div class="col-sm-8">
                    <input
                        type="number"
                        name="numero_cuenta"
                        class="form-control solo-numero"
                        value="{{ ($candidato->numero_cuenta != 0) ? $candidato->numero_cuenta : '' }}"
                        id="numero_cuenta"
                    >
                </div>
            
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
            </div>
            
            {{-- Confirmar Cuenta --}}
            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"> Confirmar Cuenta:</label>

                <div class="col-sm-8">
                    <input type="number" name="confirm_numero_cuenta" class="form-control solo-numero" id="confirm_numero_cuenta">
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
            </div>
        @endif

        @if(!empty($adicionales))
            <div class="col-md-12">
                <label class="mb-2 mt-2">Documentos adicionales variables</label>

                <table class="table">
                    <tr>
                        <th>Descripción</th>
                        <th></th>
                    </tr>

                    @foreach($adicionales as $key => $adicional)
                        @if(preg_match('/{valor_variable}/', $adicional->adicional->contenido_clausula))
                            <tr class="item_adicional">
                                <td>
                                    {{ $adicional->adicional->descripcion }}
                                </td>

                                <td>
                                    <input type="hidden" name="clausulas[]" value="{{ $adicional->adicional_id }}">

                                    <input 
                                        type="text" 
                                        name="valor_adicional[]" 
                                        class="form-control valor_adicional" 
                                        placeholder="Valor variable"
                                        value="{{ $adicional->valor }}"
                                        maxlength="100"
                                        autocomplete="off" 

                                        data-toggle="tooltip"
                                        data-placement="top"
                                        data-container="body"
                                        title="Debes definir el valor variable para este documento adicional."
                                    >

                                    @if(!preg_match('/{valor_variable}/', $adicional->adicional->contenido_clausula))
                                        <input type="hidden" name="valor_adicional[]" value="0">
                                    @endif
                                </td>
                            </tr>
                        @else
                        @endif
                    @endforeach
                </table>
            </div>
        @endif
    {!! Form::close()!!}

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-success" id="confirmar_informacion_contratacion">Actualizar</button>
</div>

<script>
    function tipoIngresoChange(obj) {
        if(obj.value == "1"){
            document.querySelector('#fecha_fin_ultimo').setAttribute('hidden', true)
        }else{
            document.querySelector('#fecha_fin_ultimo').removeAttribute('hidden')
        }
    }

    $(function () {
        const confDatepicker2 = {
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonImage: "img/gifs/018.gif",
            buttonImageOnly: true,
            autoSize: true,
            dayNames: [
                "Domingo",
                "Lunes",
                "Martes",
                "Miercoles",
                "Jueves",
                "Viernes",
                "Sabado"
            ],
            monthNamesShort: [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            yearRange: "1930:2050",
            minDate:new Date()
        }

        $("#fecha_fin_contrato, #fecha_inicio_contrato, #fecha_ingreso_contra, #fecha_fin_ultimo_field").datepicker(confDatepicker2);

        jQuery(document).on('change', '#fecha_inicio_contrato', (event) => {
            const element = event.target;

            jQuery('#fecha_fin_contrato').datepicker('option', 'minDate', element.value);
        })

        //Validar la cuenta de banco
        const pass1 = $('[name=numero_cuenta]')
        const pass2 = $('[name=confirm_numero_cuenta]')
        const confirmacion = "Las cuentas si coinciden"

        //var longitud = "La contraseña debe estar formada entre 6-10 carácteres (ambos inclusive)";
        var negacion = "No coinciden las cuentas"
        var vacio = "La contraseña no puede estar vacía"

        //oculto por defecto el elemento span
        var span = $('<span></span>').insertAfter(pass2)
        span.hide()

        //función que comprueba las dos contraseñas
        function coincidePassword(){
            var valor1 = pass1.val()
            var valor2 = pass2.val()
            
            //muestra el span
            span.show().removeClass()

            //condiciones dentro de la función
            if(valor1 != valor2){
                span.text(negacion).addClass('negacion')
                document.querySelector('#confirmar_informacion_contratacion').disabled = true
            }

            if(valor1.length == 0 || valor1 == "") {
                span.text(vacio).addClass('negacion')
                document.querySelector('#confirmar_informacion_contratacion').disabled = true
            }

            if(valor1.length != 0 && valor1 == valor2) {
                span.text(confirmacion).removeClass("negacion").addClass('confirmacion')
                document.querySelector('#confirmar_informacion_contratacion').disabled = false
            }
        }

        //ejecuta la función al soltar la tecla
        pass2.keyup(function(){
            coincidePassword();
        })
    })
</script>