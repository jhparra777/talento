@extends("admin.layout.master")
@section("contenedor")
    <style>
        .dropdown-menu{
            left: -80px;
            padding: 0;
        }

        .btn-group-vertical{
            width: 100%;
        }
    </style>

    @if(route("home") == "https://humannet.t3rsc.co")
        <h3>Lista de Curriculos</h3>
    @else
        <h3>Lista de Hojas De vida</h3>
    @endif

    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ Session::get("mensaje_success") }}
            </div>
        </div>
    @endif

    {!! Form::model(Request::all(), ["id" => "admin.lista_hv_admin", "method" => "GET"]) !!}
        <div class="col-sm-6 col-lg-6 form-group">
            <label class="col-sm-3 control-label" for="inputEmail3">Nombre, email :</label>

            <div class="col-sm-9">
                {!! Form::text("palabra_clave", null, [
                    "id" => "palabra_clave",
                    "class" => "form-control",
                    "placeholder" => "Escriba nombre o email"
                ]); !!}
            </div>
        </div>

        <div class="col-sm-6 col-lg-6 form-group">
            <label for="inputEmail3" class="col-sm-3 control-label">Cédula:</label>
            <div class="col-sm-9">
                {!! Form::text("cedula", null, [
                    "class" => "form-control input-number",
                    "placeholder" => "Número Identificación"
                ]); !!}
            </div>
        </div>

        <div class="col-sm-6 col-lg-6">
            <div class="form-group">
                <label for="ciudad_residencia" class="col-md-3 control-label">
                    Ciudad Residencia:<span class='text-danger sm-text-label'></span>
                </label>
            
                <div class="col-sm-9">
                    {!! Form::hidden("pais_residencia", null, ["id" => "pais_residencia"]) !!}
                    {!! Form::hidden("departamento_residencia", null, ["id" => "departamento_residencia"]) !!}
                    {!! Form::hidden("ciudad_residencia", null, ["id" => "ciudad_residencia"]) !!}

                    {!! Form::text("txt_residencia", null, ["id" => "txt_residencia", "class" => "form-control", "placeholder" => "Ciudad"]) !!}
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-lg-6 form-group">
            <label class="col-sm-3 control-label" for="inputEmail3">Estado:</label>          
            <div class="col-sm-9">
                {!! Form::select("estado", array(
                        '' => 'Seleccionar',
                        'EN PROCESO CONTRATACION' => 'EN PROCESO CONTRATACION',
                        'ACTIVO' => 'ACTIVO',
                        'RECLUTAMIENTO' => 'RECLUTAMIENTO',
                        'EVALUACION DEL CLIENTE' => 'EVALUACION DEL CLIENTE',
                        'EN PROCESO SELECCION' => 'EN PROCESO SELECCION',
                        'INACTIVO' => 'INACTIVO',
                        'BAJA VOLUNTARIA' => 'BAJA VOLUNTARIA'
                        ), null, ["class" => "form-control", "id" => "genero_id"
                ]); !!}
            </div>
        </div>

        <div class="col-md-12 text-right">
            <button class="btn btn-success" >
                <span class="glyphicon glyphicon-search"></span> Buscar
            </button>

            <a class="btn btn-success" href="{{ route("datos_basicos_admin") }}">
                <span class="glyphicon glyphicon-plus-sign"></span>
                @if(route("home") == "https://humannet.t3rsc.co") Nuevo CV @else Nueva HV @endif 
            </a>

            <a class="btn btn-danger" href="{{ route("admin.lista_hv_admin") }}">
                <span class="glyphicon glyphicon-trash"></span> Limpiar
            </a>

            <br><br>
        </div>
    {!! Form::close() !!}

    <div class="col-md-12 col-lg-12">
        <div class="row">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Email</th>
                        <th>Celular</th>
                        <th>Ciudad</th>
                        <th>Estado</th>
                        <th>%HV</th>
                        <th>Fecha Creado</th>
                        <th>Pendiente por completar</th>
                        <th colspan="2">Acción</th>
                    </tr>
                </thead>
                
                <tbody>
                    @if($hojas_de_vida->count() == 0)
                        <tr>
                            <td colspan="13">No se encontraron registros.
                                <a class="btn btn-success" href="{{ route("datos_basicos_admin") }}">
                                    <span class="glyphicon glyphicon-plus-sign"></span> Nueva HV
                                </a>
                            </td>
                        </tr>
                    @endif

                    @foreach($hojas_de_vida as $count => $lista)
                        <?php
                            $dado_baja = false;
                            if ($lista->datosBajaVoluntaria != null || $lista->estado_reclutamiento === config('conf_aplicacion.C_BAJA_VOLUNTARIA')) {
                                $dado_baja = true;
                            }
                        ?>
                        <tr>
                            <td>{{ ++$count }}</td>
                            <td>{{ $lista->numero_id }}</td>
                            <td>{{ $lista->nombres }}</td>
                            <td>{{ $lista->primer_apellido." ".$lista->segundo_apellido }}</td>
                            <td>{{ $lista->email }}</td>
                            <td>{{ $lista->telefono_movil }}</td>
                            <td>{{ $lista->getUbicacion() }}</td>
                            <td>{{ $lista->getEstado() }}</td>
                            <td>
                                <?php $porcentaje = FuncionesGlobales::porcentaje_hv($lista->user_id); ?>
                                {{ $porcentaje["total"] }}%
                            </td>
                            <td>{{ $lista->created_at }}</td>
                            <td>
                                <?php $secciones = secciones_pendientes($lista->user_id); ?>

                                @foreach($secciones as $seccion)

                                    {{$seccion}}
                                    @if($seccion == end($secciones))
                                        .
                                    @else
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td colspan="2">
                                <div class="btn-group-vertical" role="group" aria-label="...">
                                    @if($user_sesion->hasAccess("boton_video_perfil"))
                                        @if($lista->video != null )
                                            <a
                                                type="button"
                                                class="btn btn-primary btn-sm btn-block"
                                                href="{{ asset("recursos_videoperfil/"."$lista->video?".date('His')) }}"
                                                target="_blank"
                                            >
                                                <i class="fa fa-video-camera"></i> VIDEO PERFIL
                                            </a>
                                        @endif
                                    @endif

                                    @if(route("home") == "https://gpc.t3rsc.co")
                                        <a
                                            class="btn btn-primary btn-sm btn-block"
                                            target="_blank"
                                            href="{{ route("hv_pdf_tabla", ["user_id" => $lista->user_id]) }}"
                                        >
                                            <span class="glyphicon glyphicon-eye-open"></span> HOJA DE VIDA
                                        </a>
                                    @elseif(route("home") == "https://humannet.t3rsc.co")
                                        <a
                                            class="btn btn-primary btn-sm btn-block"
                                            target="_blank"
                                            href="{{ route("admin.hv_pdf", ["user_id" => $lista->user_id]) }}"
                                        >
                                            <span class="glyphicon glyphicon-eye-open"></span> CURRÍCULO
                                        </a>
                                    @else
                                        <a
                                            class="btn btn-primary btn-sm btn-block"
                                            target="_blank"
                                            href="{{ route("admin.hv_pdf", ["user_id" => $lista->user_id]) }}"
                                        >
                                            <span class="glyphicon glyphicon-eye-open"></span> HOJA DE VIDA
                                        </a>
                                    @endif

                                    <div class="btn-group">
                                        <button
                                            type="button"
                                            class="btn btn-info btn-sm btn-block dropdown-toggle"
                                            data-toggle="dropdown"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                        >
                                            OPCIONES <span class="caret"></span>
                                        </button>

                                        <ul class="dropdown-menu">
                                            <div class="btn-group-vertical" role="group" aria-label="...">
                                                {{-- <li role="separator" class="divider"></li> --}}

                                                <button
                                                    type="button"
                                                    class="btn btn-warning btn-sm btn-block mostrar_traza"
                                                    data-candidato_id ="{{ $lista->user_id }}"
                                                >
                                                    <span class="glyphicon glyphicon-list"></span> TRAZABILIDAD
                                                </button>

                                                @if(!$dado_baja)
                                                    <a
                                                        class="btn btn-info btn-sm btn-block"
                                                        href="{{ route("admin.actualizar_hv_admin", ["id" => $lista->user_id]) }}"
                                                    >
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                        @if(route("home") == "https://humannet.t3rsc.co")
                                                            Editar CV
                                                        @else
                                                            Editar HV
                                                        @endif
                                                    </a>
                                                @endif

                                                @if($user_sesion->hasAccess("boton_ws") && !$dado_baja)
                                                    <a
                                                        class="btn btn-success btn-sm btn-block"
                                                        target="_blank"
                                                        href="https://api.whatsapp.com/send?phone=57{{ $lista->telefono_movil}}&text=Hola!%20{{$lista->nombres}} %20te%20hablamos%20del%20equipo%20de%20selección%20de%20{{$sitio->nombre}},%20revisamos%20tu%20hoja%20de%20vida%20y%20queremos%20que%20participes%20en%20nuestros%20procesos%20de%20selección."
                                                    >
                                                        <span class="fa fa-whatsapp fa-lg" aria-hidden="true"></span>
                                                    </a>
                                                @endif

                                                @if(!$dado_baja)
                                                <a class='"btn btn-default btn-sm btn-block | text-left tri-bd--none tri-br-0 tri-txt-gray-600 tri-hover-bd--none"' href="{{route('admin.subir_documentos',['user_id'=>$lista->user_id])}}" style="'padding: .5rem 10px;'">VER DOCUMENTO</a>
                                                    
                                                @endif

                                                @if($lista->estado_reclutamiento == config("conf_aplicacion.PROBLEMA_SEGURIDAD") && !$dado_baja)
                                                    {!!
                                                        FuncionesGlobales::valida_boton_req(
                                                            "admin.cambiar_estado",
                                                            "Cambiar Estado",
                                                            "boton",
                                                            "glyphicon glyphicon-sort btn btn-primary btn-sm btn-block inactivar",
                                                            "",
                                                            "$lista->id"
                                                        )
                                                    !!}
                                                @elseif(!$dado_baja)
                                                    {!!
                                                        FuncionesGlobales::valida_boton_req(
                                                            "admin.cambiar_estado",
                                                            "Cambiar Estado",
                                                            "boton",
                                                            "glyphicon glyphicon-sort btn btn-primary btn-sm btn-block inactivar",
                                                            "",
                                                            "$lista->id"
                                                        )
                                                    !!}
                                                @endif

                                                @if(!$dado_baja)
                                                    <button
                                                        type="button"
                                                        class="btn btn-primary btn-sm btn-block btn_observacion"
                                                        data-candidato_id="{{ $lista->user_id }}"
                                                    >
                                                        <span class="glyphicon glyphicon-list"></span> OBSERVACIONES
                                                    </button>
                                                @endif
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(function () {
            $(".btn_observacion").on("click", function(e) {
                var candidato_id = $(this).data("candidato_id");

                $.ajax({
                    type: "POST",
                    data: "candidato_id=" + candidato_id,
                    url: "{{ route('admin.crear_observacion_hv') }}",
                    success: function(response) {
                        //$("#modal_gr").modal("hide");
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_observacion", function(e) {
                e.preventDefault();
                e.stopImmediatePropagation();
        
                $(this).prop("disabled",true);
                var btn_id = $(this).prop("id");
                
                setTimeout(function(){
                    $("#"+btn_id).prop("disabled",false);
                }, 5000);

                $.ajax({
                    type: "POST",
                    data: $("#fr_observacion_hv").serialize(),
                    url: "{{ route('admin.guardar_observacion_hv') }}",
                    success: function(response) {
                        if (response.success) {
                            $("#modal_peq").modal("hide");
                            mensaje_success("Se ha creado la observación con exito.");
                            $("#modal_gr").modal("hide");
                            //window.location.href = '{{ route("req.mis_requerimiento") }}';
                        } else {
                            //mensaje_success("El requerimiento ya se encuentra cerrado");
                            $("#modal_peq").find(".modal-content").html(response.view);
                        }
                    }
                });
            });

            $('#txt_cargo_generico').autocomplete({
                serviceUrl: '{{ route("admin.autocompletar_cargo_generico") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#cargo_generico_id").val(suggestion.id);
                }
            });

            $('#txt_residencia').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_residencia").val(suggestion.cod_pais);
                    $("#departamento_residencia").val(suggestion.cod_departamento);
                    $("#ciudad_residencia").val(suggestion.cod_ciudad);
                }
            });

            //Modal de estados
            $(document).on("click", ".inactivar", function () {
                var data_id = $(this).attr("id");

                if (data_id){
                    $.ajax({
                        type: "POST",
                        data: {hv_id: data_id},
                        url: "{{ route('admin.cambiar_estado') }} ",
                        success: function (response) {
                            $("#modal_peq ").find(".modal-content").html(response);
                            $("#modal_peq ").modal("show");
                        }
                    });
                }else{
                   mensaje_danger("No se cargo la información, favor intentar nuevamente.");
                }
            });

            $(document).on("click", ".mostrar_traza", function() {
                const candidato_id = $(this).data("candidato_id");
                // var cliente = $(this).data("cliente");
                // var candidato_id = $(this).data("candidato_id");

                $.ajax({
                    type: "POST",
                    data: "candidato_id="+ candidato_id,
                    url: "{{ route('admin.trazabilidad_candidato') }}",
                    success: function(response) {
                       $("#modal_gr").find(".modal-content").html(response);
                       $("#modal_gr").modal("show");
                    }
                })
            });

            $(document).on("click", "#guardar_estado", function () {
                $.ajax({
                    type: "POST",
                    data: $("#fr_cambio_estado").serialize(),
                    url: "{{ route('admin.guardar_estado') }}",
                    success: function (response) {
                        if (response.success) {
                            $("#modal_peq ").modal("hide");
                            mensaje_success("Se ha cambiado el estado al usuario.");
                            window.location.href = '{{ route("admin.lista_hv_admin") }}';
                        } else {
                            $("#modal_peq ").find(".modal-content").html(response.view);
                        }
                    }
                });
            });
        });
    </script>
@stop
