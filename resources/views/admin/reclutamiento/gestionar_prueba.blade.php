@extends("admin.layout.master")
@section('contenedor')
    <h3>Gestionar Prueba</h3>
    <h5 class="titulo1">Información Candidato</h5>

    <table class="table table-bordered">
        <tr>
            <th>Cédula</th>
            <td>{{ $candidato->numero_id }}</td>

            <th>Nombres</th>
            <td>{{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}</td>
        </tr>
        <tr>
            <th>Teléfono</th>
            <td>{{ $candidato->telefono_fijo }}</td>

            <th>Móvil</th>
            <td>{{ $candidato->telefono_movil }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $candidato->email }}</td>
        </tr>
    </table>

    <table class="table table-bordered tbl_info">
        <tr>
            <th colspan="7">Estado</th>
        </tr>

        <tr>
            <th>Requerimiento</th>
            <th>Usuario Envio</th>
            <th>Fecha Registro</th>
            <th>Proceso</th>
            <th>Estado</th>
            <th>Motivo Rechazo</th>
            <th>Observaciones</th>
            <th>Gestión Req</th>
        </tr>
        
        @foreach($estados_procesos_referenciacion as $ref)
            <tr>
                <td>{{ $candidato->requerimiento_id }}</td>
                <td>{{ $ref->name }}</td>

                <td>{{ $ref->fecha_inicio }}</td>

                <td>{{ $ref->proceso }}</td>
                <td>
                    <?php
                        switch ($ref->apto) {
                            case 1:
                                echo "Apto";
                                break;
                            case 2:
                                echo "No Apto";
                                break;
                            case 3:
                                echo "Pendiente";
                            break;
                        }
                    ?>
                </td>
                <td>{{ $ref->motivo_rechazo_id }}</td>
                <td>{{ $ref->observaciones }}</td>
                <td>
                    <a href="{{ route('admin.gestion_requerimiento', $candidato->requerimiento_id) }}" class="btn btn-sm btn-info">
                        <i class="fa fa-arrow-circle-right"></i> Ir gestión Req
                    </a>
                </td>
            </tr>
        @endforeach
    </table>

    <button type="button" class="btn btn-warning" id="cambiar_estado">Cambiar Estado</button>
    <button type="button" class="btn btn-info" id="nueva_prueba">Nueva Prueba</button>

    @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
    @else
        <a class="btn btn-danger" target="_black" href="{{route("admin.ficha_pdf",["id"=>$candidato->requerimiento_id])}}">
            Ficha PDF
        </a>
    @endif

    @if(route('home') != "http://soluciones.t3rsc.co" || route('home') != "https://soluciones.t3rsc.co")
        <div class="row">
            <h3 class="titulo1">Pruebas Realizadas</h3>
    
            @foreach($pruebas as $prueba)
                <div class="container_referencia">
                    <div class="referencia">
                        <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                            <tr>
                                <th>Prueba</th>
                                <td>{{ $prueba->prueba_desc }}</td>
                                <!-- <th>Puntaje</th>-->
                                <!-- <td>{$prueba->puntaje}}</td>-->
                            </tr>

                            <tr>
                                <th>Archivo</th>
                                
                                @if ($prueba->nombre_archivo === NULL)
                                    <td>Prueba sin archivo</td>
                                @else
                                    <td><a href="{{ url("recursos_pruebas/".$prueba->nombre_archivo)}}" target="_blanck">{{ $prueba->nombre_archivo }}</a></td>
                                @endif

                                <th>Usuario Creación</th>
                                <td>{{ $prueba->name }}</td>
                            </tr>
                            <tr>
                                <th>Fecha creación</th>
                                <td>{{ $prueba->created_at }}</td>
                                <th>Fecha Vencimiento</th>
                                <td>{{ $prueba->fecha_vencimiento }}</td>
                            </tr>
                            <tr>
                                <th>Concepto de prueba</th>
                                <td colspan="1">{!! $prueba->resultado !!}</td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                                <td colspan="1">{!! (($prueba->estado==1)?"Apto":"No apto") !!}</td>

                            </tr>
                        </table>
                    </div>

                    <div class="requerimientos">
                        <div class="btn_procesos">
                            <span style="position: relative;top:-15px;"><strong>¿Usar en este requerimiento?</strong></span>
                            <label class="switchBtn">
                                {!! Form::checkbox("definitiva",0,($prueba->getRequerimientosActivos($candidato->requerimiento_id)!=null)? 1:null,["class"=>"usar","id"=>"switch","data-prueba"=>$prueba->id,"data-req"=>$candidato->requerimiento_id]) !!}
                                <div class="slide"></div>
                            </label>

                            {{--@if($prueba->getRequerimientosActivos($candidato->requerimiento_id)!=null)
                            <a class="btn btn-danger prueba_utilizada" id="" data-prueba="{{$prueba->id}}" data-req="{{$candidato->requerimiento_id}}">No Usar</a> 
                            @else
                            <a class="btn btn-success prueba_utilizada2" id="" data-prueba="{{$prueba->id}}" data-req="{{$candidato->requerimiento_id}}">Usar</a> 
                            @endif--}}
                        </div>

                        <h4 class="titulo1" style="margin: 0">Requerimientos</h4>
                        
                        @foreach($prueba->getRequerimientos() as $req)
                            <div class="badge  badge-over">
                                <span>Req:{{ $req->requerimiento_id }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="row">
            <h3 class="titulo1">Pruebas Realizadas</h3>
    
            @foreach($pruebas as $prueba)
                <div class="container_referencia">
                    <div class="referencia">
                        <table class="table table-bordered tbl_info" style="margin-bottom: 0px">
                            <tr>
                                <th>Prueba</th>
                                <td>{{$prueba->prueba_desc}}</td>
                                <!-- <th>Puntaje</th>-->
                                <!-- <td>{$prueba->puntaje}}</td>-->
                            </tr>
                
                            <tr>
                                <th>Archivo</th>
                                @if ($prueba->nombre_archivo === NULL)
                                    <td>Prueba sin archivo</td>
                                @else
                                    <td><a href="{{url("recursos_pruebas/".$prueba->nombre_archivo)}}" target="_blanck">{{ $prueba->nombre_archivo }}</a></td>
                                @endif
                                <th>Usuario Creación</th>
                                <td>{{ $prueba->name }}</td>
                            </tr>
                            <tr>
                                <th>Fecha creación</th>
                                <td>{{ $prueba->created_at }}</td>
                                <th>Fecha Vencimiento</th>
                                <td>{{ $prueba->fecha_vencimiento }}</td>
                            </tr>
                            <tr>
                                <th>Concepto de prueba</th>
                                <td colspan="1">{!! $prueba->resultado !!}</td>
                            </tr>
                            <tr>
                                <th>Estado</th>
                                <td colspan="1">{!! (($prueba->estado == 1) ? "Apto" : "No apto") !!}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="requerimientos">
                        <div class="btn_procesos">
                            <span style="position: relative;top:-15px;"><strong>¿Usar en este requerimiento?</strong></span>
                            <label class="switchBtn">
                                {!! Form::checkbox("definitiva", 0, ($prueba->getRequerimientosActivos($candidato->requerimiento_id) != null) ? 1 : null, ["class" => "usar", "id" => "switch", "data-prueba" => $prueba->id, "data-req" => $candidato->requerimiento_id]) !!}
                                <div class="slide"></div>
                            </label>
                 
                            {{--@if($prueba->getRequerimientosActivos($candidato->requerimiento_id)!= null)
                            <a class="btn btn-danger prueba_utilizada" id="" data-prueba="{{$prueba->id}}" data-req="{{$candidato->requerimiento_id}}">No Usar</a> 
                            @else
                            <a class="btn btn-success prueba_utilizada2" id="" data-prueba="{{$prueba->id}}" data-req="{{$candidato->requerimiento_id}}">Usar</a> 
                            @endif--}}
                        </div>

                        <h4 class="titulo1" style="margin: 0">Requerimientos</h4>
                        
                        @foreach($prueba->getRequerimientos() as $req)
                            <div class="badge  badge-over">
                                <span>Req:{{ $req->requerimiento_id }}</span>
                            </div>
                        @endforeach
                    </div>      
                </div>
            @endforeach
        </div>
    @endif

    <style>
        .usar + .slide:after {
            position: absolute;
            content: "NO" !important;
        }

        .usar:checked + .slide:after {
            content: "SI"  !important;
        }
    </style>

    <script>
        $(function () {
            var ruta = "{{route('admin.gestion_requerimiento', $candidato->requerimiento_id)}}";

            $(".usar").on("change", function () {
                if(!$(this).prop("checked")){
                    var prueba = $(this).data("prueba");
                    var req = $(this).data("req");
                    //var btn = $(this);
                
                    $.ajax({
                        type: "POST",
                        data: {req_id: req, prueba_id: prueba},
                        url: "{{ route('admin.registra_proceso_entidad') }}",
                        success:function(response){
                            mensaje_success("Esta prueba no se usará para este requerimiento");
                            setTimeout(function(){
                                window.location.href = '{{ route("admin.gestionar_prueba", [$candidato->ref_id]) }}';
                            }, 2000);
                        }
                    });
                }else{
                    var prueba = $(this).data("prueba");
                    var req = $(this).data("req");
                    //var btn = $(this);
                
                    $.ajax({
                        type: "POST",
                        data: {req_id: req, prueba_id: prueba},
                        url: "{{ route('admin.registra_proceso_entidad2') }}",
                        success:function(response){
                            mensaje_success("¡Esta prueba se usará para este requerimiento!");
                            setTimeout(function(){
                                window.location.href = '{{ route("admin.gestionar_prueba",[$candidato->ref_id]) }}'; }, 2000);
                            
                        }
                    });
                }
                
                /*$.ajax({
                    type: "POST",
                    data: "ref_id={{$candidato->ref_id}}&modulo=pruebas",
                    url: "{{route('admin.cambiar_estado_view')}}",
                    success: function (response) {
                        console.log("af");
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");

                    }
                });*/
            });

            $("#cambiar_estado").on("click", function () {
                $.ajax({
                    type: "POST",
                    data: "ref_id={{$candidato->ref_id}}&modulo=pruebas",
                    url: "{{ route('admin.cambiar_estado_view') }}",
                    success: function (response) {
                        console.log("af");
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_estado", function () {
                $.ajax({
                    data: $("#fr_cambio_estado").serialize(),
                    url: "{{ route('admin.guardar_cambio_estado') }}",
                    success: function (response) {
                        if (response.success) {
                            mensaje_success("Estado actualizado.. Espere sera redireccionado");
                            // window.location.href = "{{ route('admin.pruebas')}}";
                            setTimeout(function(){
                                location.href = ruta;
                            }, 3000);
                        } else {
                            $("#modal_peq").find(".modal-content").html(response.view);
                        }
                    }
                });
            });

            $("#nueva_prueba").on("click", function () {
                $.ajax({
                    type: "POST",
                    data: "ref_id={{$candidato->ref_id}}",
                    url: "{{ route('admin.nueva_gestion_pruebas') }}",
                    success: function (response) {
                        $('#modal_peq').modal({ backdrop: 'static', keyboard: false });
                        $("#modal_peq").find(".modal-content").html(response);
                        $("#modal_peq").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_nueva_prueba", function () {
                $(this).prop("disabled", true)
                var formData = new FormData(document.getElementById("fr_nueva_prueba"));

                $.ajax({
                    url: "{{ route('admin.guardar_prueba') }}",
                    type: "post",
                    dataType: "html",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(function (res) {
                    var res = $.parseJSON(res);
                    
                    $("#guardar_nueva_prueba").removeAttr("disabled");
                        if(res.success) {
                            if(res.final == 1){ //prueba definitiva 6gh
                                mensaje_success("¡Prueba guardada con éxito!");
                                setTimeout(function(){
                                    location.href=ruta;
                                }, 3000);
                            }else{
                                window.location.href = '{{ route("admin.gestionar_prueba",[$candidato->ref_id]) }}';
                            }
                        } else {
                            $("#modal_peq").find(".modal-content").html(res.view);
                        }
                });
            });

            $(".prueba_utilizada").on("click", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);
                
                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{ route('admin.registra_proceso_entidad') }}",
                    success:function(response){
                        mensaje_success("Esta prueba no se usará para este requerimiento");
                    window.location.href = '{{ route("admin.gestionar_prueba",[$candidato->ref_id]) }}'
                        
                    }
                });
            });

            $(".prueba_utilizada2").on("click", function () {
                var prueba = $(this).data("prueba");
                var req = $(this).data("req");
                var btn = $(this);
                
                $.ajax({
                    type: "POST",
                    data: {req_id: req, prueba_id: prueba},
                    url: "{{ route('admin.registra_proceso_entidad2') }}",
                    success:function(response){
                        mensaje_success("¡Esta prueba se usará para este requerimiento!");
                        window.location.href = '{{ route("admin.gestionar_prueba",[$candidato->ref_id]) }}'
                    }
                });
            });
        });
    </script>
@stop