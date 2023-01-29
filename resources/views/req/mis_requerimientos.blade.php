@extends("req.layout.master")
@section("contenedor")

    {{-- Header --}}
    @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Requerimientos"])
    <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                {{Session::get("mensaje_success")}}
            </div>
        @endif


        {!! Form::model(Request::all(), ["route" => "req.mis_requerimiento", "method" => "GET"]) !!}
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Cliente:</label>
                {!! Form::select("cliente_id", $clientes, null, ["class" => "form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label">@if(route('home') == "https://gpc.t3rsc.co") Nombre del Proceso @else Número requerimiento @endif:</label>

                {!! Form::text("numero_req", null, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 solo-numero", "placeholder" => "Número requerimiento"]) !!}
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Fecha creación requerimiento:</label>
           
                {!! Form::text("rango_fecha",null,
                [
                    "class"=>"form-control range | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "id"=>"rango_fecha"
                ]); !!}
          
            </div>
            {{-- <div class="col-md-6 form-group">
                <label class="control-label">Fecha Inicio:</label>

                {!! Form::text("fecha_inicio", null, ["class" => "form-control  | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "DD-MM-AAAA", "id" => "fecha_inicio"]) !!}
            </div>
            
            <div class="col-md-6 form-group">
                <label class="control-label">Fecha Fin:</label>

                {!! Form::text("fecha_fin", null, ["class" => "form-control  | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "DD-MM-AAAA", "id" => "fecha_fin"]) !!}
            </div> --}}
                    
            <div class="col-md-6 form-group">
                <label class="control-label">Estado requerimiento:</label>
                {!! Form::select("estado_id", $estados_requerimiento, null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"]); !!}
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label">Ciudad</label>

                {!! Form::hidden("pais_id", null, ["class"=>"form-control", "id"=>"pais_id"]) !!}
                {!! Form::hidden("departamento_id", null, ["class"=>"form-control", "id"=>"departamento_id"]) !!}
                {!! Form::hidden("ciudad_id", null, ["class"=>"form-control", "id"=>"ciudad_id"]) !!}

                {!! Form::text("ciudad_autocomplete", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id" => "ciudad_autocomplete", "placheholder" => "Digita cuidad"]) !!}
            </div>
            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="control-label">Tipo Proceso:</label>

                {!! Form::select('tipo_proceso_id', $tipoProcesos, null, ['id' => 'tipo_proceso_id','class' => 'form-control js-select-2-basic | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}
                        
            </div>

            <div class="col-md-12 text-right mb-2">
                <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                    Buscar <i class='fa fa-search' aria-hidden='true'></i></button>

                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route("req.mis_requerimiento") }}">Limpiar</a>
                {{-- <a class="btn btn-warning" href="{{ route("req_index") }}">Volver</a> --}}
            </div>
        {!! Form::close() !!}
        
            <div class="col-md-12 mt-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="tabla table-responsive">
                            <table class="table table-hover table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>@if(route('home') == "https://gpc.t3rsc.co") Nombre del Proceso @else Requerimiento @endif</th>
                                        {{-- <th>Num Negocio</th> --}}
                                        <th>Cliente</th>
                                        <th>Ciudad</th>
                                        <th>Cargo</th>
                                        <th>Tipo Proceso</th>
                                        <th># Vacantes</th>
                                        <th>Fecha radicación</th>
                                        <th>Fecha Límite</th>
                                        <th>Dias gestión</th>
                                        <th>Estado</th>
                                        <th> Vacantes Pendientes </th>                 
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @forelse($requerimientos as $requerimiento)
                                        <tr>
                                            <td>{{ $requerimiento->req_id }}</td>
                                            {{-- <td>{{ $requerimiento->num_negocio }}</td> --}}
                                            <td>{{ $requerimiento->nombre_cliente }}</td>
                                            <td>{{ $requerimiento->ciudad }}</td>
                                            <td>{{ $requerimiento->cargo }}</td>
                                            <td>{{ $requerimiento->tipo_proceso_desc }}</td>
                                            <td>{{ $requerimiento->num_vacantes }}</td>
                                            <td>{{ $requerimiento->created_at }}</td>
                                            <td>{{ $requerimiento->fecha_ingreso }}</td>
                                            <td>
                                                <?php
                                                    $m = 'Carbon\Carbon';
                    
                                                    $date1 = date('Y-m-d',strtotime($requerimiento->created_at));
                                                    $date2 = date('Y-m-d',strtotime($requerimiento->fecha_ingreso));
                                                    $g = $m::parse($date1)->diffInWeekdays($date2);
                                                ?>
                    
                                                {{ $g }}
                                            </td>
                                            <td>
                                                @if(!empty($requerimiento->estadoRequerimiento()))
                                                    {{ $requerimiento->estadoRequerimiento()->estado_nombre }}
                                                @endif
                                            </td>
                                            <td>{{ $requerimiento->vacantes_reales }}</td>
                                            <td>
                                                <div class="btn-group-vertical" role="group" aria-label="...">
                                                    <button 
                                                        type="button"
                                                        class="btn btn-primary candidato-trazabilidad | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        data-req='{{ $requerimiento->req_id }}'
    
                                                        @if($requerimiento->candidatosAprobar()->count() > 0)
                                                            data-toggle="tooltip"
                                                            data-placement="top"
                                                            data-container="body"
                                                            title="Nuevos(as) candidatos(as) pendientes de aprobación"
                                                        @endif
                                                    >
                                                        Gestionar candidatos
    
                                                        @if($requerimiento->candidatosAprobar()->count() > 0)
                                                            <span 
                                                            class="btn btn-primary candidato-trazabilidad | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                                style="position: absolute; bottom: 18px; right: -6px; top: -7px; background-color: #e84848; min-width: 0; padding: 0px 6px; color: white;"
                                                            >
                                                                {{ $requerimiento->candidatosAprobar()->count() }}
                                                            </span>
                                                        @endif
                                                    </button>
                    
                                                    {{-- @if($requerimiento->candidatosAprobar()->count() > 0)
                                                        <button type= "button" class="btn btn-info aprobar_candidatoss" data-req='{{ $requerimiento->req_id }}'>Aprobar Candidatos</button>
                                                    @endif --}}
                                                
                                                    <button 
                                                        type="button"
                                                        id="observaciones"
                                                        class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        data-req="{{ $requerimiento->req_id }}"
                                                    >
                                                        Observaciones
                                                    </button>
                    
                                                    <a 
                                                        class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" 
                                                        href="{{ route("req.detalle_requerimiento", ["req_id" => $requerimiento->req_id]) }}"
                                                    >
                                                        Detalle requisición
                                                    </a>
                    
                                                    @if(route('home') != 'https://gpc.t3rsc.co')
                                                        <button class="btn btn-primary clonar_requerimiento | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-req='{{ $requerimiento->req_id }}'>Copiar requisición</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="13">No se encontraron registros</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        
    

        {{-- Paginación --}}
        
            <div class="col-md-12">
                {!! $requerimientos->appends(Request::all())->render() !!}
            </div>
        
        
        @if(Session::has("mensaje_no_postulados") && Session::get("mensaje_no_postulados") != null)
            <?php $mensaje = Session::get("mensaje_no_postulados"); ?>
            <script>
                $(function () {
                    mensaje_danger("{!! $mensaje !!}");
                });
            </script>
        @endif
        <div class="col-sm-12 text-right" >
            <a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{route("req_index")}}">Volver</a>
        </div>
    </div> 
    <script>
        $(function () {
            $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });

            $(document).on('click', '.add-person', function (e) {
                fila_person = $(this).parents('#postulados').find('.row').eq(0).clone();
                fila_person.find('select').val();
                fila_person.find('input').val();
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-person">-</button>');

                $('#postulados').append(fila_person);
            });

            $(document).on('click', '.rem-person', function (e) {
                $(this).parents('.row').remove();
            });

            var calendarOption2 = {
                dateFormat: "dd-mm-yy",
                dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
            };

            $("#fecha_inicio").datepicker(confDatepicker);
            $("#fecha_fin").datepicker(confDatepicker);

            $(".aprobar_candidatoss").on("click", function () {
                var data_req = $(this).data("req");
                $.ajax({
                    type: "POST",
                    data: {req_id: data_req},
                    url: " {{ route('req.aprobar_cliente_view_req') }} ",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", ".candidato_aprobado", function () {
                var req_candidato = $(this).data("req_candidato");
                var candidato_id = $(this).data("candidato");
                var btn_obj = $(this);
                var observaciones = $("#texto_"+req_candidato).val();
                $.ajax({
                    type: "POST",
                    data: {req: req_candidato, candidato: candidato_id, estado: 1,"observaciones":observaciones},
                    url: "{{ route('req.cambia_estado_aprobacion_cliente') }}",
                    success: function (response) {
                        alert("Candidato Aprobado!!");
                        btn_obj.parent().parent().remove();
                    }
                });
            });

            $(document).on("click", ".candidato_no_aprobado", function () {

                var data_req = $(this).data("req_candidato");
                $.ajax({
                    type: "POST",
                    data: {req_id: data_req},
                    url: " {{ route('req.candidatos_no_aprobar_cliente_view') }} ",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    },
                    error: function (){
                        console.log("fallo");
                    }
                });

            });

            $(document).on("click", "#confirmar_rechazo", function() {
               
                $.ajax({
                    type: "POST",
                    data: $("#fr_rechazar").serialize(),
                    url: "{{ route('req.rechazar_candidato_cliente') }}",
                    success: function(response) {
                        if (response.success) {
                            $("#modal_peq").modal("hide");
                            mensaje_success("Se ha rechazado el candidato.");
                            window.location.href = '{{route("req.mis_requerimiento")}}';
                        } else {
                        
                        }
                    }
                });
            });

            $(document).on("click", "#observaciones", function() {
                $.ajax({
                    type: "POST",
                    data: {
                        req_id:$(this).data("req"),
                        modulo: "req"
                    },
                    url: "{{ route('req.observaciones_req') }}",  
                    success: function(response) {
                        $('#modal_gr').modal({ backdrop: 'static', keyboard: false });
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_observaciones_gestion", function() {
                $.ajax({
                    type: "POST",
                    data: $("#fr_observaciones_gestion").serialize(),
                    url: "{{ route('req.guardar_observaciones_gestion') }}", 
                    success: function(response) {
                        $("#modal_gr").modal("hide");
                        mensaje_success("Observación realizada");
                        setTimeout(function(){$("#modal_success").modal("hide"); }, 1000);
                    }
                });
            });

            //funcionn mostrar trazabilidad candidatos
            $(document).on("click", ".candidato-trazabilidad", function() {
                var req_id = $(this).data("req");
                // var cliente = $(this).data("cliente");
                // var candidato_id = $(this).data("candidato_id");
                $.ajax({
                    type: "POST",
                    data: "req_id="+ req_id,
                    url: "{{route('req.trazabilidad_candidato')}}",
                    success: function(response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                })
            });

            $(".clonar_requerimiento").on("click", function () {
                var data_req = $(this).data("req");

                $.ajax({
                    type: "POST",
                    data: { req_id: data_req },
                    url: " {{ route('admin.clonar_requerimiento_view') }} ",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");

                        var calendarOption40 = {
                            minDate: 0,
                            dateFormat: "yy-mm-dd",
                            dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                            monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
                            onSelect: function (dateText, obj) {
                                console.log(dateText);
                            }
                        };

                        var calendarOption6 = {
                            dateFormat: "yy-mm-dd",
                            dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                            monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"]
                        };

                        $("#fecha_ingreso").datepicker(calendarOption40);
                            
                        $("#fecha_retiro").datepicker(calendarOption6);

                    },
                    error: function (){
                        console.log("error");
                    }
                });
            });

            {{--
                $(document).on("click", ".candidato_no_aprobado", function () {
                    var req_candidato = $(this).data("req_candidato");
                    var candidato_id = $(this).data("candidato");
                    var btn_obj = $(this);
                    var observaciones = $("#texto_"+req_candidato+"").val();
                    $.ajax({
                        type: "POST",
                        data: {req: req_candidato, candidato: candidato_id, estado: 2,"observaciones":observaciones},
                        url: "{{ route('req.cambia_estado_aprobacion_cliente') }}",
                        success: function (response) {
                            alert("Candidato NO Aprobado!!");
                            btn_obj.parent().parent().remove();
                        }
                    });
                });
            --}}
        });
    </script>
@stop