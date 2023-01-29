@extends("admin.layout.master")
@section("contenedor")
    <h3>Requerimientos</h3>

    {!! Form::model(Request::all(),["route"=>"admin.mis_requerimiento","method"=>"GET"]) !!}
        @if(Session::has("mensaje_success"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                {{Session::get("mensaje_success")}}
            </div>
        @endif

        @if(route("home")!="http://komatsu.t3rsc.co" && route("home")!="https://komatsu.t3rsc.co")
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Clientes:</label>
                <div class="col-sm-10">
                    {!! Form::select('cliente_id', $clientes, null, ['id'=>'cliente_id','class'=>'form-control js-select-2-basic']) !!}
                </div>
            </div>
        @endif

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">@if(route('home')=="https://gpc.t3rsc.co") Nombre del Proceso @else Num Req @endif:</label>
            <div class="col-sm-10">
                {!!Form::text("numero_req",null,["class"=>"form-control solo-numero"]) !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Fecha Inicio:</label>
            <div class="col-sm-10">
                {!! Form::text("fecha_inicio",null,["class"=>"form-control","placeholder"=>"DD-MM-AAAA","id"=>"fecha_inicio"]) !!}
            </div>
        </div>
        
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Fecha Fin:</label>
            <div class="col-sm-10">
                {!! Form::text("fecha_fin",null,["class"=>"form-control","placeholder"=>"DD-MM-AAAA","id"=>"fecha_fin"]) !!}
            </div>
        </div>
                
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Estado req:</label>
            <div class="col-sm-10">
                {!! Form::select("estado_id",$estados_requerimiento,null,["class"=>"form-control"]); !!}
            </div>
        </div>

        <div class="col-md-6 form-group">
          <label class="col-sm-2 control-label" for="inputEmail3">Ciudad</label>
            
            <div class="col-sm-10">
             {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
             {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
             {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
             {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control","id"=>"ciudad_autocomplete","placeholder"=>"Digita cuidad"]) !!}
            </div>
        </div>

        <div class="col-md-6  form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Tipo Proceso:</label>
                <div class="col-sm-10">
                    {!! Form::select('tipo_proceso_id', $tipoProcesos, null, ['id' => 'tipo_proceso_id','class' => 'form-control js-select-2-basic']) !!}
                </div>
                    
        </div>

        <div class="col-md-12 form-group">
            {!! Form::submit("Buscar",["class"=>"btn btn-success"]) !!}
            <a class="btn btn-danger" href="{{route("admin.mis_requerimiento")}}">Cancelar</a>
        </div>
    {!! Form::close() !!}
    
    <br>
 
    <div class="clearfix"></div>

    @if(route("home") != "http://komatsu.t3rsc.co" && route("home") != "https://komatsu.t3rsc.co")
        <div class="tabla table-responsive">
            <table class="table table-bordered table-hover ">
                <thead>
                    <tr>
                        <th>@if(route('home') == "https://gpc.t3rsc.co") Nombre del Proceso @else Num Req @endif</th>
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
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @if($requerimientos->count() == 0)
                     <tr>
                      <td colspan="5">No se encontraron registros</td>
                     </tr>
                    @endif

                    @foreach($requerimientos as $requerimiento)
                        <tr>
                            <td>{{$requerimiento->req_id}}</td>
                            <td>{{$requerimiento->num_negocio}}</td>
                            <td>{{$requerimiento->nombre_cliente}}</td>
                            <td>{{$requerimiento->ciudad}}</td>
                            <td>{{$requerimiento->cargo}}</td>
                            <td>{{$requerimiento->tipo_proceso_desc}}</td>
                            <td>{{$requerimiento->num_vacantes}}</td>
                            <td>{{$requerimiento->created_at}}</td>
                            <td>{{$requerimiento->fecha_ingreso}}</td>
                            <td><?php
                              $m = 'Carbon\Carbon';
                                
                                $date1 = date('Y-m-d',strtotime($requerimiento->created_at));
                                $date2 = date('Y-m-d',strtotime($requerimiento->fecha_ingreso));
                                    //$diff = $fecha1->diff($fecha2);
                                $g = $m::parse($date1)->diffInWeekdays($date2);
                             ?>
                             {{$g}} </td>
                            
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
                                @if(!empty($requerimiento->estadoRequerimiento()))
                                 @if($requerimiento->estadoRequerimiento()->estado_id !=22 and $requerimiento->estadoRequerimiento()->estado_id != 2 and $requerimiento->estadoRequerimiento()->estado_id != 3 and $requerimiento->estadoRequerimiento()->estado_id != 1 and $requerimiento->estadoRequerimiento()->estado_id != 16 and $requerimiento->estadoRequerimiento()->estado_id != 19 )

                                    @if($requerimiento->candidatosAprobar()->count() > 0)
                                     <button class="btn btn-info aprobar_candidatos" data-req='{{$requerimiento->req_id}}' >Aprobar Candidatos</button>
                                    @endif
                                 @endif
                                @endif
                                
                                <a class="btn btn-warning" href="{{route("admin.detalle_requerimiento1",["req_id"=>$requerimiento->req_id])}}">Detalle Requisición</a>
                                
                                @if(route('home') != 'https://gpc.t3rsc.co')
                                  <button class="btn btn-success clonar_requerimiento" data-req='{{$requerimiento->req_id}}'>Copiar Requisición</button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <table class="table table-bordered table-hover ">
            <thead>
                <tr>
                    <th> @if(route('home') == "https://gpc.t3rsc.co") Nombre del Proceso @else Num Req @endif </th>
                    <th>Cargo</th>
                    <th>Área</th>
                    <th>Sub-área</th>
                    <th>Sede</th>
                    <th>Vacantes</th>
                    <th>Centro beneficio</th>
                    <th>Centro Costo</th>
                    <th>Fecha Creación</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                @if($requerimientos->count() == 0)
                    <tr> <td colspan="5">No se encontraron registros</td> </tr>
                @endif

                @foreach($requerimientos as $requerimiento)
                    <tr>
                        <td>{{$requerimiento->req_id}}</td>
                        <td>{{$requerimiento->cargo}}</td>
                        <td>{{$requerimiento->solicitud->area->descripcion}}</td>
                        
                        @if(isset($requerimiento->solicitud->subarea))
                            <td>{{$requerimiento->solicitud->subarea->descripcion}}</td>
                        @endif
                        
                        <td>{{$requerimiento->solicitud->sede->descripcion}}</td>
                        <td>{{$requerimiento->num_vacantes}}</td>
                        
                        @if(isset($requerimiento->solicitud->centrobeneficio))
                            <td>{{$requerimiento->solicitud->centrobeneficio->descripcion}}</td>
                        @endif

                        @if(isset($requerimiento->solicitud->centrocosto))
                            <td>{{$requerimiento->solicitud->centrocosto->descripcion}}</td>
                        @endif

                        <td>{{$requerimiento->created_at}}</td>
                        <td>
                            @if($requerimiento->candidatosAprobar()->count() > 0)
                                <button class="btn btn-info aprobar_candidatos"  data-req='{{$requerimiento->req_id}}' >Aprobar Candidatos</button>
                            @endif

                            <a class="btn btn-warning" href="{{route("admin.detalle_requerimiento1",["req_id"=>$requerimiento->req_id])}}">Detalle Requisición</a>

                            <button class="btn btn-success clonar_requerimiento" data-req='{{$requerimiento->req_id}}'>Copiar Requisición</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div>
        {!! $requerimientos->appends(Request::all())->render() !!}
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
                placeholder: 'Selecciona o busca un cliente'
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

            $(".aprobar_candidatos").on("click", function () {
                
                var data_req = $(this).data("req");
                $.ajax({
                    type: "POST",
                    data: {req_id: data_req},
                    url: "{{ route('req.candidatos_aprobar_cliente_view') }} ",
                    success: function (response) {
                      $("#modal_gr").find(".modal-content").html(response);
                      $("#modal_gr").modal("show");
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
                            $("#modal_gr").find(".modal-content").html(response);
                            $("#modal_gr").modal("show");
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
        });
    </script>
@stop