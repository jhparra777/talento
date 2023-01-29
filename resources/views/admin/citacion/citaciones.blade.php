@extends("admin.layout.master")
@section('contenedor')

    {!! Form::model(Request::all(),["id"=>"admin.citaciones","method"=>"GET"]) !!}
        
        <div class="row">
            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label">Requerimiento:</label>

                <div class="col-sm-8">
                    {!! Form::text("req_id",null,["class"=>"form-control","placeholder"=>""]); !!}
                </div>
            </div>

            <div class="col-md-6  form-group">
                <label for="inputEmail3" class="col-sm-4 control-label"># Cédula Psicologo:</label>

                <div class="col-sm-8">
                    {!! Form::text("cedula_psico",null,["class"=>"form-control","placeholder"=>"# Cédula"]); !!}
                </div> 
            </div>
        </div>

        <br>

        <button class="btn btn-info" >Buscar</button>
        <a class="btn btn-warning" href="{{route("admin.citaciones")}}" >Limpiar</a>
        <a class="btn btn-danger" href="{{route("admin.lista_candidatos")}}" >Volver</a>

    {!! Form::close() !!}

    <br><br>

    <div class="col-md-12 col-lg-12">
    
        <div class="row">
            <div class="box">
                
                <div class="box-header with-border">

                    <h3 class="box-title">
                        Citaciones
                    </h3>

                    <br><br>
     
                </div>

                <div class="box-body table-responsive no-padding">

                    <table class="table table-bordered" id="tbl_preguntas" >
                    
                        <thead>
                            <tr>
                                <td style="text-align: center;">N° Cita</td>
                                <td style="text-align: center;">Nombre Psicologo</td>
                                <td style="text-align: center;">N° Cédula Psico</td>
                                <td style="text-align: center;">Nombre Candidato</td>
                                <td style="text-align: center;">Fecha Cita</td>
                                <td style="text-align: center;">Motivo Cita</td>
                                <td style="text-align: center;">Requerimiento</td>
                                <td style="text-align: center;">Cargo</td>
                                <td style="text-align: center;">Estado</td>
                                <td style="text-align: center;">Observaciones</td>
                                <td style="text-align: center;">Accion</td>
                            </tr>
                        </thead>
                        
                        <tbody>                
                            
                            <tbody>
            
                                @if($citaciones->count() == 0)
                                    <tr>
                                        <td colspan="4"> No se encontraron registros</td>
                                    </tr>
                                @endif

                                @foreach($citaciones as $cita)
                                    <tr>
                                        <td style="text-align: center;" >
                                            {{$cita->id}}
                                        </td>

                                        <td style="text-align: center;">{{$cita->nombres_psicologo}}</td>
                                        <td style="text-align: center;">{{$cita->numero_id}}</td>
                                        <td style="text-align: center;">{{$cita->nombre_candidato}}</td>
                                        <td style="text-align: center;">{{$cita->fecha_cita}}</td>
                                        <td style="text-align: center;">{{$cita->motivo_cita}}</td>
                                        <td style="text-align: center;">{{$cita->req_id}}</td>
                                        <td style="text-align: center;">{{$cita->cargo}}</td>
                                        <td style="text-align: center;">{{(($cita->estado_cita==1)?"Activa":"Inactiva")}}</td>
                                        <td style="text-align: center;">{{$cita->observaciones}}</td>
                
                                        <td style="text-align: center;">

                                            @if($user_sesion->hasAccess("editar_citaciones"))

                                                <a class="btn  btn-block btn-info editar_cita" data-cita_id = "{{$cita->id}}" data-motivo_id = "{{$cita->motivo_id}}" data-psicologo_id = "{{$cita->psicologo_id}}" data-candidato_id = "{{$cita->candidato_id}}" id="gestionar_cita">Editar</a>

                                            @else
                                            
                                            @endif
                        
                                            @if($cita->estado_cita ==1)
                                                <a class="btn  btn-block btn-danger inactivar_cita" data-cita_id = "{{$cita->id}}" id="gestionar_cita" >Inactivar</a>
                                            @else
                                                <a class="btn  btn-block btn-success activar_cita" id="gestionar_cita" data-cita_id = "{{$cita->id}}" >Activar</a>
                                            @endif
                                        
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>

                        </tbody>

                    </table>
                   
                </div>
            </div>
        </div>

    </div>

    {!! $citaciones->appends(Request::all())->render() !!}

    <script>
    
        $(document).on("click",".inactivar_cita", function () {
            var cita_id = $(this).data("cita_id");
            var btn = $(this);
               
            $.ajax({
                type: "POST",
                data: {cita_id: cita_id},
                url: "{{ route('admin.inactivar_cita') }}",
                success: function (response) {
                    var prueba = $(this).data("prueba");
                    var req = $(this).data("req");
                    mensaje_success("Cita Inactiva!!");
                    location.reload();
                }
            });
        });

        $(document).on("click",".editar_cita", function () {
            var cita_id = $(this).data("cita_id");
            var motivo_id = $(this).data("motivo_id");
            var psicologo_id = $(this).data("psicologo_id");
            var candidato_id = $(this).data("candidato_id");
            var btn = $(this);
               
            $.ajax({
                type: "POST",
                 data:"cita_id="+ cita_id+ "&candidato_id="+ candidato_id+ "&motivo_id="+ motivo_id+ "&psicologo_id="+ psicologo_id,
                url: "{{ route('admin.editar_cita') }}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $(document).on("click", "#actualizar_cita", function () {
            $(this).prop("disabled", false)
            $.ajax({
                type: "POST",
                data: $("#fr_act_cita").serialize(),
                url: "{{ route('admin.actualizar_cita') }}",
                success: function (response) {
                    mensaje_success("Cita actualizada con éxito!!");
                    location.reload();
                },
                error: function (response) {
                    $.each(response.responseJSON, function(index, val){
                        $('radio[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                        $('textarea[name='+index+']').after('<span style ="color:red;" class="text">'+val+'</span>');
                        $('select[name='+index+']').after('<span  style ="color:red;" class="text">'+val+'</span>');
                    });

                    $("#modal_peq").find(".modal-content").html(response.view);
                }

            });
        });;

        $(document).on("click",".activar_cita", function () {
            var cita_id = $(this).data("cita_id");
            var btn = $(this);
               
            $.ajax({
                type: "POST",
                data: {cita_id: cita_id},
                url: "{{ route('admin.activar_cita') }}",
                success: function (response) {
                    var prueba = $(this).data("prueba");
                    var req = $(this).data("req");
                    mensaje_success("Cita activa!!");
                    location.reload();
                }
            });
        });

    </script>
@stop