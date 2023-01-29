@extends("req.layout.master")
@section('contenedor')
    <?php
        $configuracion_sst = $sitioModulo->configuracionEvaluacionSst();
        $consentimiento_config = $sitioModulo->configuracionConsentimientoPermiso();
    ?>

    <style>
        .dropdown-menu{
            left: -80px;
            padding: 0;
        }

        .form-control-feedback{
            display: none !important;
        }

        .smk-error-msg{
            position: unset !important;
            float: right;
            margin-right: 14px !important;
        }
    </style>

@include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Contratados"])
    @if(Session::has("mensaje_success"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            {{ Session::get("mensaje_success") }}
        </div>
    </div>
    @endif

    {!! Form::model(Request::all(), ["route" => "req.mis_contratados", "method" => "GET"]) !!}
    <div class="row"> 
        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label">@if(route('home') == "https://gpc.t3rsc.co") Nombre del Proceso @else Número requerimiento @endif:</label>
            {!! Form::text("num_req", null, ["class" => "form-control solo-numero js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}    
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label">Cédula:</label>
            {!! Form::text("cedula", null, ["class" => "form-control solo-numero js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}      
        </div>

       <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label">Estado:</label>
            {!! Form::select("estado", $estados, null, ["class" => "form-control js-example-basic-single | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" ]); !!}
        </div>
        
        <div class="col-md-12 text-right mb-2">
            <button type="submit" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green">
                Buscar <i class='fa fa-search' aria-hidden='true'></i></button>

            <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-red" href="{{ route("req.mis_contratados") }}">Limpiar</a>
        </div>
    </div>
        {!! Form::close() !!}

    <div class="clearfix"></div>
   
    <div class="row">
        <div class="col-md-12 mt-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="tabla table-responsive">
                        <table class="table table-hover table-striped text-center">
                            <thead>
                                <tr>
                                    {{-- <td>{!!
                                        Form::checkbox("seleccionar_todos_candidatos_vinculados",null,false,["id"=>"seleccionar_todos_candidatos_vinculados"])
                                        !!}</td> --}}
                                    <th>Num Req</th>
                                    <th>Cliente</th>
                                    <th>Cargo</th>
                                    <th>Proceso</th>
                                    <th>Identificación</th>
                                    <th>Nombres</th>
                                    <th>Móvil</th>
                                    <th>Fecha Inicio</th>
                                    <th>Trazabilidad</th>
                                    <th style="text-align: center;" colspan="4">Acción</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                @if($candidatos->count() == 0)
                                <tr>
                                    <td colspan="13">No se encontraron registros</td>
                                </tr>
                                @endif
    
                                @foreach($candidatos as $candidato)
                                <?php
                                    $processes_collect = collect($candidato->procesos);
                                    $processes = $processes_collect->pluck("proceso")->toArray();
                                    $processes_apto = $processes_collect->where('apto', '1')->pluck("proceso")->toArray();
                                ?>
                                <tr @if($candidato->asistira == "0") style="background:rgba(210,0,0,.2)" @endif>
                                    {{-- <td>
                                        {!! Form::hidden("req_id", $candidato->req_id) !!}
                                        <input class="check_candi"
                                            data-candidato_req="{{ $candidato->requerimiento_candidato }}" data-cliente=""
                                            name="req_candidato[]" type="checkbox"
                                            value="{{ $candidato->requerimiento_candidato }}">
                                    </td> --}}
                                    <td>
                                        {{ $candidato->req_id }}
                                    </td>
                                    <td>
                                        {{ $candidato->cliente }}
                                    </td>
                                    <td>
                                        {{ $candidato->cargo }}
                                    </td>
                                    <td>
                                        {{ $candidato->tipo_proceso }}
                                    </td>
                                    <td>
                                        {{ $candidato->numero_id }}
                                    </td>
                                    <td>
                                        {{ mb_strtoupper($candidato->nombres ." ".$candidato->primer_apellido."
                                        ".$candidato->segundo_apellido) }}
                                    </td>
                                    <td>
                                        {{ $candidato->telefono_movil }}
                                    </td>
                                    <td>

                                        {{ $candidato->contratos->last()['fecha_ingreso'] }}
                                    </td>
    
                                    <td>
                                        {{-- Trazabilidad candidato --}}
                                        <?php
                                            //Variables temporales necesarias para la trazabilidad
                                            $candidato_req->candidato_id = $candidato->user_id;
                                            $candidato_req->req_candidato_id = $candidato->req_can_id;
                                            $requermiento->id = $candidato->req_id;
                                        ?>
                                        @include('admin.reclutamiento.includes.gestion-requerimiento._section_trazabilidad_gestion', ["procesos" => $processes_collect, "inactiveAllbtn" => true])
                                        
                                    </td>
    
                                    <td>
                                        <div class="btn-group-vertical" role="group" aria-label="...">
                                            
    
                                            <a class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                href="{{ route('req.gestion_contratacion', [" candidato"=>
                                                $candidato->candidato_id, "req" => $candidato->req_id]) }}"
                                                >
                                                Gestionar
                                            </a>
    
                                            {{-- Ver paquete de contratación --}}
                                            {{-- @if(route('home') != "https://gpc.t3rsc.co" && route('home') !=
                                            "https://asuservicio.t3rsc.co" &&
                                            route('home')!= "https://humannet.t3rsc.co")
                                                @if($user_sesion->hasAccess("admin.paquete_contratacion_pdf"))
                                                    <a class="btn btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple"
                                                        href="{{ route('admin.paquete_contratacion_pdf', ['id' => $candidato->requerimiento_candidato]) }}"
                                                        target="_blank" data-cliente="{{ $candidato->cliente_id }}"
                                                        data-candidato_req="{{ $candidato->requerimiento_candidato }}">
                                                        ORDEN
                                                    </a>
                                                @endif
                                            @endif --}}
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Paginación --}}
    <div class="row">
        <div class="col-md-12">
            {!! $candidatos->appends(Request::all())->render() !!}
        </div>
    </div>

    <script>
        $(function () {
            $(".status").on("click", function(){
                req_can = $(this).data("req_can");
                proceso = $(this).data("proceso_cand");
                candidato = $(this).data("candidato");
                requerimiento = $(this).data("req");
                user_id = $(this).data("user_id");

                $.ajax({
                    type: "POST",
                    data: {
                        "req_can" : req_can,
                        "proceso" : proceso,
                        'candidato' : candidato,
                        'requerimiento' : requerimiento,
                        'user_id' : user_id
                    },
                    url: "{{ route('admin.contratacion.status_contratacion') }}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });
        });
    </script>
@stop