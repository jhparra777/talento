@extends("admin.layout.master")
@section("contenedor")
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Requerimientos"])
        @if(Session::has("mensaje_success"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                {{Session::get("mensaje_success")}}
            </div>
        @endif

    {!! Form::model(Request::all(),["route"=>"admin.mis_requerimiento","method"=>"GET"]) !!}
        <div class="row">
            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">
                    Cliente:
                </label>

                {!! Form::select('cliente_id', $clientes, null, ['id'=>'cliente_id', 'class'=>'form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}

            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">
                    Número requerimiento:
                </label>

                {!! Form::text("numero_req",null,["class"=>"form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300 solo-numero", "placeholder" => "Número requerimiento"]); !!}
            
            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Fechas:</label>
           
                {!! Form::text("rango_fecha",null,
                [
                    "class"=>"form-control range | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300",
                    "id"=>"rango_fecha"
                ]); !!}
          
            </div>

            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Estado requerimiento:</label>
                
                {!! Form::select("estado_id",$estados_requerimiento,null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300"]); !!}

            </div>

            <div class="col-md-6 form-group">
                <label class="control-label" for="inputEmail3">Ciudad:</label>
                
                {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
                {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","id"=>"ciudad_autocomplete","placeholder"=>"Digita cuidad"]) !!}

            </div>

            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="control-label">Tipo Proceso:</label>

                {!! Form::select('tipo_proceso_id', $tipoProcesos, null, ['id' => 'tipo_proceso_id','class' => 'form-control js-select-2-basic | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300']) !!}
                        
            </div>

            <div class="col-md-12 text-right">
                <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                    Buscar <i aria-hidden="true" class="fa fa-search"></i>
                </button>

                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{route("admin.mis_requerimiento")}}">
                    Limpiar
                </a>
            </div>
        </div>
    {!! Form::close() !!}
    
    <div class="row">
        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tabla table-responsive">
                        <table class="table table-hover table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Num Req</th>
                                    <th>Num Negocio</th>
                                    <th>Cliente</th>
                                    <th>Ciudad</th>
                                    <th>Cargo</th>
                                    <th>Tipo Proceso</th>
                                    <th># Vacantes</th>
                                    <th>Fecha radicación</th>
                                    <th>Fecha Límite</th>
                                    <th>Dias gestión</th>
                                    <th>Estado</th>
                                    <th>Vacantes Pendientes</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requerimientos as $requerimiento)
                                    <tr>
                                        <td>{{$requerimiento->id}}</td>
                                        <td>{{$requerimiento->num_negocio}}</td>
                                        <td>{{$requerimiento->nombre_cliente}}</td>
                                        <td>{{$requerimiento->ciudad}}</td>
                                        <td>{{$requerimiento->cargo}}</td>
                                        <td>{{$requerimiento->tipo_proceso_desc}}</td>
                                        <td>{{$requerimiento->num_vacantes}}</td>
                                        <td>{{$requerimiento->created_at}}</td>
                                        <td>{{$requerimiento->fecha_ingreso}}</td>
                                        <td>
                                            <?php
                                            $m = 'Carbon\Carbon';
                                                
                                                $date1 = date('Y-m-d',strtotime($requerimiento->created_at));
                                                $date2 = date('Y-m-d',strtotime($requerimiento->fecha_ingreso));
                                                    //$diff = $fecha1->diff($fecha2);
                                                $g = $m::parse($date1)->diffInWeekdays($date2);
                                            ?>
                                            {{$g}}
                                        </td>
                                        <td>
                                            @if(!empty($requerimiento->estadoRequerimiento()))
                                                {{$requerimiento->estadoRequerimiento()->estado_nombre}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($sitio))
                                    
                                                @if($sitio->asistente_contratacion == 1 && $requerimiento->firma_cargo == 1)
                                                    {{ $requerimiento->vacantes_reales_asistente }}
                                                @else
                                                    {{ $requerimiento->vacantes_reales }}
                                                @endif

                                            @else
                                                {{ $requerimiento->vacantes_reales }}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical">
                                                @if(!empty($requerimiento->estadoRequerimiento()))
                                                @if($requerimiento->estadoRequerimiento()->estado_id !=22 and $requerimiento->estadoRequerimiento()->estado_id != 2 and $requerimiento->estadoRequerimiento()->estado_id != 3 and $requerimiento->estadoRequerimiento()->estado_id != 1 and $requerimiento->estadoRequerimiento()->estado_id != 16 and $requerimiento->estadoRequerimiento()->estado_id != 19 )

                                                    @if($requerimiento->candidatosAprobar()->count() > 0)
                                                    <button class="btn btn-primary aprobar_candidatos | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-req='{{$requerimiento->id}}' >Aprobar Candidatos</button>
                                                    @endif
                                                @endif
                                                @endif
                                                
                                                <a class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" href="{{route("admin.detalle_requerimiento1",["req_id"=>$requerimiento->id])}}">Detalle Requisición</a>
                                                
                                                <button class="btn btn-primary clonar_requerimiento | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" data-req='{{$requerimiento->id}}'>Copiar Requisición</button>
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
    </div>

    <div class="row">
        <div class="col-md-12">
            {!! $requerimientos->appends(Request::all())->render() !!}
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

            $('.js-select-2-basic-city').select2({
                placeholder: 'Selecciona o busca una ciudad'
            });

            $('.js-select-2-basic').select2({
                placeholder: 'Selecciona o busca un proceso'
            });

            $('.js-example-basic-single').select2({
                placeholder: 'Selecciona o busca un cliente'
            });

            $(document).on('click', '.add-person', function (e) {

                fila_person = $(this).parents('#postulados').find('.row').eq(0).clone();
                fila_person.find('select').val();
                fila_person.find('input').val();
                fila_person.find('div.last-child').append('<button type="button" class="btn btn-danger rem-person | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red">-</button>');

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

            $(".aprobar_candidatos").on("click", function () {
                
                var data_req = $(this).data("req");
                $.ajax({
                    type: "POST",
                    data: {req_id: data_req},
                    url: "{{ route('req.candidatos_aprobar_cliente_view') }} ",
                    success: function (response) {
                      $("#modalTriLarge").find(".modal-content").html(response);
                      $("#modalTriLarge").modal("show");
                    },
                    error: function (){
                        console.log("fallo");
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

            {{--$(document).on("click", ".candidato_no_aprobado", function () {
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

            });--}}

            $(document).on("click", "#confirmar_rechazo", function() {
                   
                $.ajax({
                    type: "POST",
                    data: $("#fr_rechazar").serialize(),
                    url: "{{ route('admin.rechazar_candidato_cliente') }}",
                    success: function(response) {
                     if(response.success) {
                        $("#modal_peq").modal("hide");
                            
                        mensaje_success("Se ha rechazado el candidato.");

                        window.location.href = '{{route("admin.mis_requerimiento")}}';
                     }
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
                            $("#modalTriLarge").find(".modal-content").html(response);
                            $("#modalTriLarge").modal("show");
                        },
                        error: function (){
                            console.log("fallo");
                        }
                    });

            });

            $(".clonar_requerimiento").on("click", function () {
                
               var data_req = $(this).data("req");

                $.ajax({
                    type: "POST",
                    data: { req_id: data_req },
                    url: "{{route('admin.clonar_requerimiento_view')}}",
                    success: function (response) {

                        $("#modalTriLarge").find(".modal-content").html(response);
                        $("#modalTriLarge").modal("show");

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
        });
    </script>
@stop