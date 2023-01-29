<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
        @if(count($candidato) > 0)
            <h5>
                <strong>
                    {{ "¿Enviar a contratación a ".$candidato->nombres." ".$candidato->primer_apellido." Nro. doc. ".$candidato->numero_id."?" }}
                </strong>
            </h5>
        @endif
    </h4>
</div>

<div class="modal-body">
    @if(count($candidato) > 0)
        {!! Form::model(Request::all(),["id" => "fr_contratar", "data-smk-icon" => "fa fa-times-circle"]) !!}
            {!! Form::hidden("candidato_req", $candidato->req_candidato, ["id" => "candidato_req_fr"]) !!}
            {!! Form::hidden("cliente_id",null) !!}

            <h3 style="padding-left: 20px;">Datos de contratación</h3>
        @if( isset($sitio) && $sitio->asistente_contratacion == 1 )
            {{-- Fecha ingreso --}}
            <div class="col-md-12 form-group">
                <label for="fecha_ingreso" class="col-sm-4 control-label">Fecha Ingreso *</label>
                
                <div class="col-sm-8">
                    {!! Form::text("fecha_ingreso_contra", ($dato_contrato) ? $dato_contrato->fecha_inicio_contrato : null, [
                        "class" => "form-control",
                        "id" => "fecha_ingreso_contra",
                        "required" => "required",
                        "readonly" => "readonly"
                        ]);
                    !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_ingreso_contra", $errors) !!}</p>
                
            </div>
            
            {{-- Observaciones --}}
            <div class="col-md-12 form-group">
                <label for="observaciones" class="col-sm-4 control-label">Observaciones *</label>
                
                <div class="col-sm-8">
                    {!! Form::textarea("observaciones", ($dato_contrato) ? $dato_contrato->observaciones : '', [
                        "class" => "form-control",
                        "rows" => '2',
                        "id" => "observacion",
                        "required" => "required"
                        ])
                    !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
            </div>
            
            <!-- Hora de ingreso -->
            <div class="col-md-12 form-group">
                <label for="hora_ingreso" class="col-sm-4 control-label">Hora de ingreso *:</label>

                <div class="col-sm-8">
                    {!! Form::time("hora_ingreso",($dato_contrato) ? $dato_contrato->hora_entrada : '08:00', [
                            "class" => "form-control",
                            "id" => "time-inicio",
                            "required" => "required"
                    ]); !!}
                </div>
        
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso", $errors) !!}</p>
            </div>

            <!-- Tipo ingreso -->
            <div class="col-md-12 form-group">
                <label for="tipo_ingreso" class="col-sm-4 control-label">Tipo Ingreso *:</label>

                <div class="col-sm-8">
                    <select name="tipo_ingreso" id="tipo_ingreso" class="form-control">
                        <option value="1" @if($dato_contrato) @if($dato_contrato->tipo_ingreso == 1) selected @endif @endif >Nuevo</option>
                        <option value="2" @if($dato_contrato) @if($dato_contrato->tipo_ingreso == 2) selected @endif @endif >Reingreso</option>
                    </select>
                </div>

                <p class="error text-danger direction-botones-center">  {!! FuncionesGlobales::getErrorData("tipo_ingreso", $errors) !!} </p>
            </div>

            <!-- Fecha último contrato -->
            <div style="display: none;" class="col-md-12 form-group" id="fecha_fin_ultimo">
                <label for="fecha_fin_ultimo" class="col-sm-4 control-label">Fecha fin ultimo contrato:</label>
                
                <div class="col-sm-8">
                    {!! Form::date("fecha_fin_ultimo", ($dato_contrato) ? date('Y-m-d', strtotime($dato_contrato->fecha_ultimo_contrato)) : null, [
                            "class" => "form-control",
                            "id" => "fecha_fin_ultimo"
                        ]);
                    !!}
                </div>
            </div>

            <!-- Centro de costos -->
            <div class="col-md-12 form-group">
                <label for="centro_costos" class="col-sm-4 control-label">Centro de costos *</label>

                <div class="col-sm-8">
                    @if($dato_contrato)
                        {!! Form::select("centro_costos", $centros_costos, (!empty($dato_contrato->centro_costos)) ? $dato_contrato->centro_costos : $centro_costo->centro_costo,
                        [
                            "class" => "form-control",
                            "required" => "required",
                            "id" => "centro_costos"
                            ]);
                        !!}
                    @else
                        {!! Form::select("centro_costos", $centros_costos, ($contra_clientes != null ? ($contra_clientes->centro_costos != null ? $contra_clientes->centro_costos : $requerimiento->centro_costo_id) : $requerimiento->centro_costo_id),
                        [
                            "class" => "form-control",
                            "required" => "required",
                            "id" => "centro_costos"
                            ]);
                        !!}
                    @endif
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("centro_costos", $errors) !!}</p>
            </div>

            <!-- Auxilio transporte -->
            <div class="col-md-12 form-group">
                <label for="auxilio_transporte" class="col-sm-4 control-label">Auxilio de Transporte:</label>
                
                <div class="col-sm-8">
                    <select name="auxilio_transporte" class="form-control">
                        <option value="No se Paga" @if($dato_contrato) @if($dato_contrato->auxilio_transporte == 'No se Paga') selected @endif @endif > No se paga </option>
                        <option value="Total" @if($dato_contrato) @if($dato_contrato->auxilio_transporte == 'Total') selected @endif @endif > Total </option>
                        <option value="Mitad" @if($dato_contrato) @if($dato_contrato->auxilio_transporte == 'Mitad') selected @endif @endif > Mitad </option>
                    </select>
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("auxilio_transporte", $errors) !!}</p>
            </div>

            <!-- EPS -->
            <div class="col-md-12 form-group">
                <label for="entidad_eps" class="col-sm-4 control-label">EPS:</label>
                
                <div class="col-sm-8">
                    {!! Form::select("entidad_eps", $eps, $candidato->entidad_eps, ["class" => "form-control selectcategory", "id" => "entidad_eps"]) !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("entidad_eps", $errors) !!}</p>
            </div>

            <!-- Fondo pensiones -->
            <div class="col-md-12 form-group">
                <label for="entidad_afp" class="col-sm-4 control-label">Fondo Pensiones:</label>

                <div class="col-sm-8">
                    {!! Form::select("entidad_afp", $afp, $candidato->entidad_afp, ["class" => "form-control selectcategory", "id" => "entidad_afp"]) !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("entidad_afp", $errors) !!}</p>
            </div>

            <!-- Caja compensación -->
            <div class="col-md-12 form-group">
                <label for="caja_compensacion" class="col-sm-4 control-label">Caja de Compensaciones:</label>

                <div class="col-sm-8">
                    {!! Form::select("caja_compensacion", $caja_compensaciones, $candidato->caja_compensaciones, [
                            "class" => "form-control selectcategory",
                            "id" => "caja_compensacion"
                        ])
                    !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("caja_compensacion", $errors) !!}</p>
            </div>

            <!-- ARL -->
            <div class="col-md-12 form-group">
                <label for="arl" class="col-sm-4 control-label">ARL:</label>
                
                <div class="col-sm-8">
                    {!! Form::text("arl", 'Colpatria', ["class" => "form-control", "id" => "arl", "readonly" => "readonly"]); !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("arl", $errors) !!}</p>
            </div>
            
            <!-- Fondo cesantías -->
            <div class="col-md-12 form-group">
                <label for="fondo_cesantias" class="col-sm-4 control-label">Fondo De Cesantias:</label>

                <div class="col-sm-8">
                    {!! Form::select("fondo_cesantias", $fondo_cesantias, $candidato->fondo_cesantias, [
                            "class" => "form-control selectcategory",
                            "id" => "fondo_cesantias"
                        ])
                    !!}
                </div>
            
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fondo_cesantias", $errors) !!}</p>
            </div>

            <!-- Nombre del banco -->
            <div class="col-md-12 form-group">
                <label for="nombre_banco" class="col-sm-4 control-label">Nombre del Banco:</label>
                
                <div class="col-sm-8">
                    {!! Form::select("nombre_banco", $bancos, $candidato->nombre_banco, [
                            "class" => "form-control selectcategory",
                            "id"=>"nombre_banco"
                        ])
                    !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_banco", $errors) !!}</p>
            </div>

            <!-- Tipo cuenta -->
            <div class="col-md-12 form-group">
                <label for="tipo_cuenta" class="col-sm-4 control-label">Tipo Cuenta:</label>
                
                <div class="col-sm-8">
                    <select name="tipo_cuenta" class="form-control">
                        <option value="Ahorro" @if($candidato->tipo_cuenta == 'Ahorro') selected @endif > Ahorro </option>
                        <option value="Corriente" @if($candidato->tipo_cuenta == 'Corriente') selected @endif > Corriente </option>
                    </select>
                </div>
            
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_cuenta", $errors) !!}</p>
            </div>

            <!-- Número cuenta -->
            <div class="col-md-12 form-group">
                <label for="numero_cuenta" class="col-sm-4 control-label">Número Cuenta:</label>

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

            <!-- Confirma cuenta -->
            <div class="col-md-12 form-group">
                <label for="confirm_numero_cuenta" class="col-sm-4 control-label">Confirmar Cuenta:</label>

                <div class="col-sm-8">
                    <input
                        type="number"
                        name="confirm_numero_cuenta"
                        class="form-control solo-numero"
                        id="confirm_numero_cuenta"
                    >
                </div>
            
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta", $errors) !!}</p>
            </div>

            <!-- Fecha fin contrato -->
            <div class="col-md-12 form-group">
                <label for="fecha_fin_contrato" class="col-sm-4 control-label">Fecha Fin Contrato:</label>
                
                <div class="col-sm-8">
                    <input
                        type="text"
                        name="fecha_fin_contrato"
                        value="{{ $newEndingDate }}"
                        class="form-control"
                        id="fecha_fin_contrato"
                        required
                        readonly
                    >
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato", $errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">¿Quién autorizó contratación? *</label>

                    @if(count($dato_contrato) > 0)
                        @if(!is_null($dato_contrato->user_autorizacion) && $dato_contrato->user_autorizacion != '')
                            <div class="col-sm-8">
                                {!! Form::select("user_autorizacion", $usuarios_clientes,($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                                        "class" => "form-control",
                                        "readonly" => true,
                                        "id" => "user_autorizacion"
                                    ]);
                                !!}
                            </div>
                            
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
                        @else
                            <div class="col-sm-8">
                                {!! Form::select("user_autorizacion", $usuarios_clientes, ($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                                        "class" => "form-control",
                                        "id" => "user_autorizacion",
                                        "required" => "required"
                                    ]); !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
                        @endif
                    @else
                        <div class="col-sm-8">
                            {!! Form::select("user_autorizacion", $usuarios_clientes, ($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                                    "class" => "form-control",
                                    "id" => "user_autorizacion",
                                    "required" => "required"
                                ]);
                            !!}
                        </div>
                        
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
                    @endif
            </div>

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
                                        <input type="hidden" name="clausulas[]" value="{{ $adicional->adicional->id }}">

                                        <input 
                                            type="text" 
                                            name="valor_adicional[]" 
                                            class="form-control valor_adicional" 
                                            placeholder="Valor variable"
                                            value="{{ (empty($adicional->variableReq($requerimiento->id)->valor)) ? $adicional->variableCargo()->valor : $adicional->variableReq($requerimiento->id)->valor }}"
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
        @else
            {{-- Fecha ingreso --}}
            <div class="col-md-12 form-group">
                <label for="fecha_ingreso" class="col-sm-4 control-label">Fecha Ingreso *</label>
                
                <div class="col-sm-8">
                    {!! Form::text("fecha_ingreso_contra", ($dato_contrato) ? $dato_contrato->fecha_inicio_contrato : null, [
                        "class" => "form-control",
                        "id" => "fecha_ingreso_contra",
                        "required" => "required"
                        ]);
                    !!}
                </div>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_ingreso_contra", $errors) !!}</p>
                
            </div>
            
            {{-- Observaciones --}}
            <div class="col-md-12 form-group">
                <label for="observaciones" class="col-sm-4 control-label">Observaciones *</label>
                
                <div class="col-sm-8">
                    {!! Form::textarea("observaciones", ($dato_contrato) ? $dato_contrato->observaciones : '', [
                        "class" => "form-control",
                        "rows" => '2',
                        "id" => "observacion",
                        "required" => "required"
                        ])
                    !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">¿Quién autorizó contratación? *</label>

                    @if(count($dato_contrato) > 0)
                        @if(!is_null($dato_contrato->user_autorizacion) && $dato_contrato->user_autorizacion != '')
                            <div class="col-sm-8">
                                {!! Form::select("user_autorizacion", $usuarios_clientes,($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                                        "class" => "form-control",
                                        "readonly" => true,
                                        "id" => "user_autorizacion"
                                    ]);
                                !!}
                            </div>
                            
                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
                        @else
                            <div class="col-sm-8">
                                {!! Form::select("user_autorizacion", $usuarios_clientes, ($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                                        "class" => "form-control",
                                        "id" => "user_autorizacion",
                                        "required" => "required"
                                    ]); !!}
                            </div>

                            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
                        @endif
                    @else
                        <div class="col-sm-8">
                            {!! Form::select("user_autorizacion", $usuarios_clientes, ($dato_contrato) ? $dato_contrato->user_autorizacion : null, [
                                    "class" => "form-control",
                                    "id" => "user_autorizacion",
                                    "required" => "required"
                                ]);
                            !!}
                        </div>
                        
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion", $errors) !!}</p>
                    @endif
            </div>
        @endif
        {!! Form::close()!!}
    @endif

    @if(count($candi_no_cumplen) > 0)
    <div class="row">
        <h4 style="padding-left: 20px;">No se puede enviar a contratar al candidato:</h4>
        <div class="col-md-12">
            <table id="table_users_no_contratados" class="table table-striped">
                <thead>
                    <th>Documento identidad</th>
                    <th>Nombres y apellido</th>
                    <th>Motivo no se envía a contratar</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $candi_no_cumplen->numero_id }}</td>
                        <td>{{ $candi_no_cumplen->nombres ." ". $candi_no_cumplen->primer_apellido }}</td>
                        <td>
                            {{ $candi_no_cumplen->observacion_no_cumple }}
                            @if($candi_no_cumplen->procesos_inconclusos != null)
                                <br>
                                @foreach($candi_no_cumplen->procesos_inconclusos as $proceso)
                                    {{ $proceso->proceso }}
                                    @if($proceso == end($candi_no_cumplen->procesos_inconclusos))
                                        ,
                                    @else
                                        .
                                    @endif
                                @endforeach
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif
    <div class="clearfix"></div>
</div>

<div class="modal-footer">    
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if(count($candidato) > 0)
        <button type="button" class="btn btn-success" id="confirmar_contratacion" >Confirmar</button>
    @endif
</div>

<style type="text/css">
    .confirmacion{background:#C6FFD5;border:1px solid green;}
    .negacion{background:#ffcccc;border:1px solid red}
</style>

<script>
    $(function () {
        var confDatepicker2 = {
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
            yearRange: "1930:2050",
            minDate:new Date()
        };

        $('#table_users_no_contratados').DataTable({
            'stateSave': true,
            "lengthChange": false,
            "responsive": true,
            "paginate": true,
            "autoWidth": true,
            "searching": false,
            "order": [[1,"desc"]],
            "lengthMenu": [[3,10, 25, -1], [3,10, 25, "All"]],
            "language": {
              "url": '{{ url("js/Spain.json") }}'
            }
        });
    
        tipo = $("#tipo_ingreso").val();

        if(tipo == "1"){
            $("#fecha_fin_ultimo").hide();
        }else{
            $("#fecha_fin_ultimo").show();
        }

        $("#fecha_fin_contrato, #fecha_inicio_contratos, #fecha_inicio_contrato, #fecha_ingreso_contra").datepicker(confDatepicker2);

        jQuery(document).on('change', '#fecha_inicio_contrato', (event) => {
            const element = event.target;
        
            jQuery('#fecha_fin_contrato').datepicker('option', 'minDate', element.value);
        });
    });
</script>

<script type="text/javascript">
    $(function(){
        var pass1 = $('[name=numero_cuenta]');
        var pass2 = $('[name=confirm_numero_cuenta]');
        var confirmacion = "Las cuentas si coinciden";
        
        //var longitud = "La contraseña debe estar formada entre 6-10 carácteres (ambos inclusive)";
        var negacion = "No coinciden las cuentas";
        var vacio = "El número de cuenta no puede estar vacío";
        //oculto por defecto el elemento span
        var span = $('<span></span>').insertAfter(pass2);
        span.hide();

        //función que comprueba las dos contraseñas
        function coincidePassword(){
            var valor1 = pass1.val();
            var valor2 = pass2.val();
            
            //muestra el span
            span.show().removeClass();
            
            //condiciones dentro de la función
            if(valor1 != valor2){
                span.text(negacion).addClass('negacion'); 
            }
            
            if(valor1.length==0 || valor1==""){
                span.text(vacio).addClass('negacion');  
            }

            /*if(valor1.length<6 || valor1.length>10){
                span.text(longitud).addClass('negacion');
            }*/

            if(valor1.length!=0 && valor1==valor2){
                span.text(confirmacion).removeClass("negacion").addClass('confirmacion');
            }
        }
        
        //ejecuta la función al soltar la tecla
        pass2.keyup(function(){
            coincidePassword();
        });
    });
</script>