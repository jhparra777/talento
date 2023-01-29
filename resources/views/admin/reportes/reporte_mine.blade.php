@extends("admin.layout.master")
@section('contenedor')
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => '<i aria-hidden="true" class="fa fa-file-text-o"></i>'." Reportes Detalle Minería"])

    {!!Form::model(Request::all(), ["route" => "admin.reportes_mineria", "method" => "GET", "accept-charset" => "UTF-8"])!!}
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Filtra por palabra clave (Área,Cargo) :</label>

                <div class="col-sm-9">
                    {!! Form::text("palabra_clave",null,["id"=>"palabra_clave", "class"=>"form-control","placeholder"=>"Escriba cargo, función o perfil" ]); !!}
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("palabra_clave",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3"> Ciudad Residencia </label>

                <div class="col-sm-9">
                    {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                    {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                    {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                    
                    {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"]) !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Edad Inicial:</label>
                <div class="col-sm-9">
                    {!!Form::number("edad_inicial",null,[ "id" => "edad_inicial", "class" => "form-control","placeholder" => "Escriba la edad inicial"]);!!}
                </div>
            </div>
 
            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Edad Final  :</label>      
                
                <div class="col-sm-9">
                    {!! Form::number("edad_final",null,[ "id"=>"edad_final", "class"=>"form-control","placeholder"=>"Escriba la edad final" ]); !!}
                </div>
            </div>
        </div>

        <div class="row">
            @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co" || route("home") == "https://gpc.t3rsc.co")
                <div class="col-md-6 form-group">
                    <label class="col-sm-3 control-label">
                        @if(route("home") == "https://gpc.t3rsc.co") Salario Actual/Ultimo @else Aspiración Salarial @endif <span>*</span>
                    </label>
                    
                    <div class="col-sm-9">
                        @if(route("home") == "https://gpc.t3rsc.co")
                            {!!Form::text("aspiracion_salarial", null, ["class" => "form-control", "id" => "aspiracion_salarial" ]);!!}
                        @else
                            {!!Form::select("aspiracion_salarial", $aspiracionSalarial, null, ["class" => "form-control" ,"id" => "aspiracion_salarial"])!!}
                        @endif
                    </div>

                    <p class="error text-danger direction-botones-center">
                        {!!FuncionesGlobales::getErrorData("aspiracion_salarial",$errors)!!}
                    </p>
                </div>
            @endif

            @if(route("home") == "https://gpc.t3rsc.co")
                <div class="col-md-6 form-group">
                    <label class="col-sm-3 control-label"> Empresa Actual/Ultima </label>
                    <div class="col-sm-9">
                        {!!Form::text("empresa",null,["class"=>"form-control","id"=>"empresa"]);!!}
                    </div>
                    
                    <p class="error text-danger direction-botones-center">
                        {!!FuncionesGlobales::getErrorData("empresa",$errors)!!}
                    </p>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3"> Género: </label>

                <div class="col-sm-9">
                    {!!Form::select("genero_id", $generos, null, ["class" => "form-control", "id" => "genero_id"]);!!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Estado:</label>
                
                <div class="col-sm-9">
                    {!! Form::select("estado",array('' => 'Seleccionar','EN PROCESO CONTRATACION' => 'EN PROCESO CONTRATACION','ACTIVO' => 'ACTIVO','RECLUTAMIENTO'=>'RECLUTAMIENTO','EVALUACION DEL CLIENTE '=>'EVALUACION DEL CLIENTE','EN PROCESO SELECCION '=>'EN PROCESO SELECCION '),null,["class"=>"form-control","id"=>"estado"]); !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3"> Fecha inicial </label>      
                
                <div class="col-sm-9">
                    {!! Form::text("fecha_actualizacion_ini",null,["class"=>"form-control","placeholder"=>"Fecha inicial","id"=>"fecha_actualizacion_ini" ]);!!}
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_actualizacion_ini",$errors) !!}</p>
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Fecha Final</label>
                
                <div class="col-sm-9">
                    {!! Form::text("fecha_actualizacion_fin",null,["class"=>"form-control","placeholder"=>"Fecha final","id"=>"fecha_actualizacion_fin" ]); !!}
                    <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("fecha_actualizacion_fin",$errors) !!} </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Agencia:</label>
                
                <div class="col-sm-9">
                    {!! Form::select("agencia",$agencias,null,["class"=>"form-control","id"=>"agencia"]); !!}
                </div>
            </div>

            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="habeas_data">Habeas data: </label>
                
                <div class="col-sm-9">
                    {!! Form::select("habeas_data", ['' => 'Seleccionar', 1 => 'Aceptado', 0 => 'No aceptado'], null, ["class" => "form-control", "id" => "habeas_data"]); !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="col-sm-3 control-label" for="inputEmail3">Perfil:</label>
                
                <div class="col-sm-9">
                    {!! Form::select("perfil",$perfiles,null,["class"=>"form-control","id"=>"perfil"]); !!}
                </div>
            </div>

        </div>

        <input id="formato" name="formato" type="hidden" value="html"/>
        
        <div class="row">
            <div class="col-md-12">
                <button class="btn btn-success" type="submit">Generar</button>
                <a class="btn btn-success" href="#" id="export_excel_btn" role="button"><i aria-hidden="true" class="fa fa-file-excel-o"></i> Excel </a>
            </div>
        </div>
    {!! Form::close() !!}
    
    <br><br>

    @if(isset($data))
        {!!Form::model(Request::all(),["method" => "POST", "id" => "envio_req"])!!}
            {!! Form::submit("Enviar a requerimiento",["style" => "position:relative; left:-30px; top:-5px;", "class" => "btn btn-primary", "id" => "enviar_req"]) !!}

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-3 control-label">Requerimiento:</label>

                <div class="col-sm-8">
                    {!! Form::select("req_id", $requerimientos, null, ["class" => "form-control chosen1 id_req" ]); !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("req_id", $errors) !!}</p>
                </div>
            </div>

            <div class="clearfix"></div>

            @include('admin.reportes.includes.grilla_detalle_mine')
        {!! Form::close()!!}

        <div class="modal" id="modal_confirme">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert-info">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"><span class="fa fa-check-circle "></span> Confirmación</h4>
                    </div>

                    {!! Form::open(["route"=>"admin.transferir_dato","id"=>"transferir"]) !!}
                        <input type="hidden" name="req_id" id="nuevo_req">

                        <div class="modal-body" id="texto"></div>
                    {!! Form::close() !!}

                    <div class="modal-footer">
                        <!--<button type="submit" id="cofirm_transfer" form="transferir" class="btn btn-warning" >Transferir</button>-->
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        $('#ciudad_autocomplete').autocomplete({
            serviceUrl: '{{ route("autocomplete_cuidades") }}',
            autoSelectFirst: true,
            onSelect: function (suggestion) {
                $("#pais_id").val(suggestion.cod_pais);
                $("#departamento_id").val(suggestion.cod_departamento);
                $("#ciudad_id").val(suggestion.cod_ciudad);
            }
        });

        $(function () {
            $("#fecha_actualizacion_fin").datepicker(confDatepicker);
            $("#fecha_actualizacion_ini").datepicker(confDatepicker);

            $('#export_excel_btn').click(function(e){
                $data_form = $('#filter_form').serialize();
                $palabra_clave = $('#palabra_clave').val();
                $genero_id = $("#genero_id").val();

                $edad_inicial = $("#edad_inicial").val();
                $edad_final = $("#edad_final").val();
                $fecha_actualizacion_ini = $("#fecha_actualizacion_ini").val();
                $fecha_actualizacion_fin = $("#fecha_actualizacion_fin").val();
              
                $departamento_id = $("#departamento_id").val();
                $ciudad_id = $("#ciudad_id").val();
              
                $aspiracion_salarial = $("#aspiracion_salarial").val();
                $perfil = $("#perfil").val();


                $(this).prop("href","{{route('admin.reportes.reportes_detalles_mine_excel')}}?"+$data_form+"&formato=xlsx&palabra_clave="+$palabra_clave+"&genero_id="+$genero_id+"&fecha_actualizacion_ini="+$fecha_actualizacion_ini+"&fecha_actualizacion_fin="+$fecha_actualizacion_fin+"&edad_inicial"+$edad_inicial+"&edad_final="+$edad_final+"&departamento_id="+$departamento_id+"&ciudad_id="+$ciudad_id+"&aspiracion_salarial="+$aspiracion_salarial+"&perfil="+$perfil);
            });

            $('#export_pdf_btn').click(function(e){
                $data_form = $('#filter_form').serialize();
                $fecha_inicio = $("#fecha_inicio").val();
                $fecha_final = $("#fecha_final").val();
                $cliente_id = $("#cliente_id").val();
                $criterio = $("#criterio").val();

                $(this).prop("href","{{ route('admin.reportes.reportes_detalles_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
            });

            $("#envio_req").on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    data: $('#envio_req').serialize(),
                    url: "{{route('admin.enviar_requerimiento')}}",
                    beforeSend: function(){
                        $("#modal_confirme #texto").html('');
                        $.blockUI({
                            message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                            css: {
                                border: "0",
                                background: "transparent"
                            },
                            overlayCSS:  {
                                backgroundColor: "#fff",
                                opacity:         0.6,
                                cursor:          "wait"
                            }
                        });
                    },
                    error: function(){
                        $.unblockUI();
                        swal("ERROR!",'Ha ocurrido un error', "danger");
                    },
                    success: function (response){
                        $.unblockUI();
                        if(response.success){
                            if (response.transferir_directo) {
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            } else if (!response.transferir) {
                                mensaje_success('Se ha agregado al requerimiento exitosamente.')
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            } else {
                                $("#modal_success").modal("hide");
                                $("#modalTriLarge").find(".modal-content").html(response.view);
                                $("#modalTriLarge").modal("show");
                            }
                        } else {
                            $.each(response.errores, function(index, val) {
                                /* iterate through array or object */
                                $("#modal_confirme #texto").append(val);
                            });
                            $("#modal_confirme").modal('show');
                            $(":submit").prop('disabled', false)
                            $(":button").prop('disabled', false)
                            return false;
                        }
                        
                        return false;
                    }
                });
            });

            /*$("#transferir").on("submit", function (e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    data: $('#transferir').serialize(),
                    url: "{{route('admin.transferir_dato')}}",
                    beforeSend: function(){
                        $.blockUI({
                            message: '<img src="https://ecuadortoday.media/wp-content/uploads/2018/05/1car-loading-2.gif">',
                            css: {
                                border: "0",
                                background: "transparent"
                            },
                            overlayCSS:  {
                                backgroundColor: "#fff",
                                opacity:         0.6,
                                cursor:          "wait"
                            }
                        });
                    },
                    error: function(){
                        $.unblockUI();
                        swal("ERROR!",'A ocurrido un error', "danger");
                        $("#modal_confirme .close").click();
                    },
                    success: function (response){
                        if(response.success ==='success'){
                            $.unblockUI();
                            $("#modal_confirme .close").click();
                            swal("Bien!",'Candidato afiliado al requerimiento', "success");

                            location.reload();
                        }
                        
                        return false;
                    }
                });
            });*/

            $(document).on("change","#seleccionar_todos", function () {
                var obj = $(this);
                $("input[name='user_id[]']").prop("checked", obj.prop("checked"));
            });
        })

        $(document).on("click", ".cerrar_modal_transferir", function () {
            $(":submit").prop('disabled', false)
            $(":button").prop('disabled', false)
        });
    </script>
@stop
