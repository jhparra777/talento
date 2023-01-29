@extends("admin.layout.master")
@section('contenedor')

    @if(route("home")=="http://temporizar.t3rsc.co" || route("home")=="https://temporizar.t3rsc.co" || route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000")

        <style>
            .check_candi_req{
                visibility: hidden;
            }
        </style>

        {!! Form::model(Request::all(),["id"=>"admin.lista_candidatos","method"=>"GET"]) !!}
            
            <div class="row">
                <div class="col-md-6  form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Nombre Carga :</label>
                    <div class="col-sm-8">
                        {!! Form::text("nombre_carga",null,["class"=>"form-control","placeholder"=>"Nombre Carga"]); !!}
                    </div>  
                </div>

                <div class="col-md-6  form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label"># Cédula :</label>
                    <div class="col-sm-8">
                        {!! Form::text("cedula_candidato",null,["class"=>"form-control","placeholder"=>"# Cédula"]); !!}
                    </div> 
                </div>

                <div class="col-md-6 form-group">
                    <label class="col-sm-4 control-label" for="inputEmail3">
                       Fecha Carga Inicial
                    </label>
                    <div class="col-sm-8">
                        {!! Form::text("fecha_carga_ini",null,["class"=>"form-control","placeholder"=>"Fecha inicial","id"=>"fecha_carga_ini" ]); !!}
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_carga_ini",$errors) !!}</p>
                    </div>
                </div>

                <div class="col-md-6 form-group">
                    <label class="col-sm-4  control-label" for="inputEmail3">
                       Fecha Carga final
                    </label>
                    <div class="col-sm-8">
                        {!! Form::text("fecha_carga_fin",null,["class"=>"form-control","placeholder"=>"Fecha final","id"=>"fecha_carga_fin" ]); !!}
                        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_carga_fin",$errors) !!}</p>
                    </div>
                </div>
                <div class="col-md-6 form-group">
                    <label for="inputEmail3" class="col-sm-2 control-label">Usuario carga</label>
                    
                    <div class="col-sm-10">
                        {!! Form::select('usuario_carga',$usuarios_reclutadores, null, ['id'=>'usuario_carga','class'=>'form-control js-select-2-basic']) !!}
                </div>
            </div>


            
            </div>
            
            <br>

            <button class="btn btn-success" >Buscar</button>
            
            <a class="btn btn-warning" href="{{route("admin.lista_candidatos")}}" >Limpiar</a>
            <a class="btn btn-info"  href="{{route("admin.citaciones")}}" >Lista Citas</a>

            <button class="btn btn-warning btn_citacion_masivo" type="button">Citación Masiva</button>

        {!! Form::close() !!}

        <br><br>

        <div class="col-md-12 col-lg-12">
            <div class="row">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Candidatos
                        </h3>
                        
                        <br><br>
                    </div>

                    <div class="box-body table-responsive no-padding">

                        <table class="table table-bordered" id="tbl_preguntas">
                            <thead>
                                <tr>
                                    <td>{!! Form::checkbox("seleccionar_todos_candidatos",null,false,["id"=>"seleccionar_todos_candidatos"]) !!}</td>
                                    <td>N°</td>
                                    <td style="text-align: center;">Lote</td>
                                    <td style="text-align: center;">Nombres</td>
                                    <td style="text-align: center;">Apellidos</td>
                                    <td style="text-align: center;">N° Cédula</td>
                                    <td style="text-align: center;">Telefono Móvil</td>
                                    <td style="text-align: center;">Email</td>
                                    <td style="text-align: center;">Nombre Carga</td>
                                    <td style="text-align: center;">Req. Id</td>
                                    <td style="text-align: center;">Fecha creación Carga</td>
                                    {{-- <td style="text-align: center;">Citado?</td> --}}
                                    <td style="text-align: center;">Acciones</td>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <tbody>
                
                                    @if($candidatos->count() == 0)
                                        
                                        <tr>
                                            <td colspan="4"> No se encontraron registros</td>
                                        </tr>

                                    @endif

                                    @foreach($candidatos as $key => $candi)
                                        
                                        <tr>
                                            <td>
                                                <input class="check_candi" name="candidato_cita[]" id="candidato_cita" type="checkbox" value="{{$candi->user_id}}">
                                                <input class="check_candi_req" name="candidato_cita_req[]" type="checkbox" value="{{$candi->req_id}}">
                                            </td>
                                            <td>{{++$key}}</td>
                                            <td style="text-align: center;">{{$candi->lote}} </td>
                                            <td style="text-align: center;">{{$candi->nombres}} </td>
                                            <td style="text-align: center;">{{$candi->primer_apellido}} {{$candi->segundo_apellido}}</td>
                                            <td style="text-align: center;">{{$candi->identificacion}}</td>
                                            <td style="text-align: center;">{{$candi->telefono_movil}}</td>
                                            <td style="text-align: center;">{{$candi->email}}</td>
                                            <td style="text-align: center;">{{$candi->nombre_carga}}</td>
                                            <td style="text-align: center;">{{$candi->req_id}}</td>
                                            <td style="text-align: center;">{{$candi->fecha_creacion}}</td>
                                            <td style="text-align: center;">
                                                <a class="btn btn-success gestionar_cita" id="gestionar_cita"  data-user_id ="{{$candi->user_id}}" data-req_id ="{{$candi->req_id}}" >Gestionar Cita</a>
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

        {!! $candidatos->appends(Request::all())->render() !!}

    @else

        {!! Form::model(Request::all(),["id"=>"admin.lista_candidatos","method"=>"GET"]) !!}
            <div class="row">
                <div class="col-md-6  form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label">Nombre Carga :</label>
                    <div class="col-sm-8">
                        {!! Form::text("nombre_carga",null,["class"=>"form-control","placeholder"=>"Nombre Carga"]); !!}
                    </div>  
                </div>
                <div class="col-md-6  form-group">
                    <label for="inputEmail3" class="col-sm-4 control-label"># Cédula :</label>
                    <div class="col-sm-8">
                        {!! Form::text("cedula_candidato",null,["class"=>"form-control","placeholder"=>"# Cédula"]); !!}
                    </div> 
                </div>
                <div class="col-md-6 form-group">
                <label class="col-sm-4 control-label" for="inputEmail3">
                   Fecha Carga Inicial
                </label>
                <div class="col-sm-8">
                    {!! Form::text("fecha_carga_ini",null,["class"=>"form-control","placeholder"=>"Fecha inicial","id"=>"fecha_carga_ini" ]); !!}
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_carga_ini",$errors) !!}</p>
                </div>
            </div>
            <div class="col-md-6 form-group">
                <label class="col-sm-4  control-label" for="inputEmail3">
                   Fecha Carga final
                </label>
                <div class="col-sm-8">
                    {!! Form::text("fecha_carga_fin",null,["class"=>"form-control","placeholder"=>"Fecha final","id"=>"fecha_carga_fin" ]); !!}
                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_carga_fin",$errors) !!}</p>
                </div>
            </div>
            </div>
            <br>
            <button class="btn btn-success" >Buscar</button>
            <a class="btn btn-warning" href="{{route("admin.lista_candidatos")}}" >Limpiar</a>
            <a class="btn btn-info"  href="{{route("admin.citaciones")}}" >Lista Citas</a>

        {!! Form::close() !!}
        
        <br><br>
        <div class="col-md-12 col-lg-12">
            <div class="row">
                <div class="box">
                        <div class="box-header with-border">
                        <h3 class="box-title">
                            Candidatos
                        </h3>
                        <br><br>
             
                       </div>

                       <div class="box-body table-responsive no-padding">

                            <table class="table table-bordered" id="tbl_preguntas" >
                    <thead>
                        <tr>
                            <td>N°</td>
                        <td style="text-align: center;">Lote</td>
                        <td style="text-align: center;">Nombres</td>
                        <td style="text-align: center;">Apellidos</td>
                        <td style="text-align: center;">N° Cédula</td>
                        <td style="text-align: center;">Telefono Móvil</td>
                        <td style="text-align: center;">Email</td>
                        <td style="text-align: center;">Nombre Carga</td>
                        <td style="text-align: center;">Fecha creación Carga</td>
                        {{-- <td style="text-align: center;">Citado?</td> --}}
                        <td style="text-align: center;">Acciones</td>
                     

                        </tr>
                    </thead>
                    <tbody>
                        
                         <tbody>
                    
                    @if($candidatos->count() == 0)
                    <tr>
                        <td colspan="4"> No se encontraron registros</td>
                    </tr>
                    @endif
                    @foreach($candidatos as $key => $candi)
                    <tr>
                        <td>{{++$key}}</td>
                         <td style="text-align: center;">{{$candi->lote}} </td>
                        <td style="text-align: center;">{{$candi->nombres}} </td>
                        <td style="text-align: center;">{{$candi->primer_apellido}} {{$candi->segundo_apellido}}</td>
                        <td style="text-align: center;">{{$candi->identificacion}}</td>
                        <td style="text-align: center;">{{$candi->telefono_movil}}</td>
                        <td style="text-align: center;">{{$candi->email}}</td>
                        <td style="text-align: center;">{{$candi->nombre_carga}}</td>
                        <td style="text-align: center;">{{$candi->fecha_creacion}}</td>
                        {{-- <td style="text-align: center;">{{(($candi->cita_id !=null)?"SI":"NO") }}</td> --}}
                        
                      
                        <td style="text-align: center;">
                             <a class="btn btn-success gestionar_cita" id="gestionar_cita"  data-user_id ="{{$candi->user_id}}" >Gestionar Cita</a>
                             
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

        {!! $candidatos->appends(Request::all())->render() !!}

    @endif

    <script>

        @if(route("home")=="http://temporizar.t3rsc.co" || route("home")=="https://temporizar.t3rsc.co" || route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000")

            $(function() {

                $("#fecha_carga_ini").datepicker(confDatepicker);
                $("#fecha_carga_fin").datepicker(confDatepicker);

                $("#seleccionar_todos_candidatos").on("change", function () {
                        
                    var obj = $(this);
                    var stat = obj.prop("checked");
                    
                    if(stat){
                        $("input[name='candidato_cita[]']").prop("checked", true);
                        $("input[name='candidato_cita_req[]']").prop("checked", true);
                    }else{
                        $("input[name='candidato_cita[]']").prop("checked", false);
                        $("input[name='candidato_cita_req[]']").prop("checked", false);
                    }
                    
                });

                $('.check_candi').on('change',function(){

                    var obj = $(this);
                    var stat = obj.prop("checked");
                    
                    if(stat){
                        $(this).next("input[name='candidato_cita_req[]']").prop("checked", true);
                    }else{
                        $(this).next("input[name='candidato_cita_req[]']").prop("checked", false);
                    }

                });

                $(".btn_citacion_masivo").on("click", function() {
                   
                    if($("input[name='candidato_cita[]']").serialize() == ''){

                        mensaje_success("Debes seleccionar al menos un candidat@.");

                    }else{

                        var users_ids = $("input[name='candidato_cita[]']").serialize();
                        var reques_ids = $("input[name='candidato_cita_req[]']").serialize();

                        console.log(users_ids);
                        console.log(reques_ids);

                        $.ajax({
                            type: "POST",
                            data: {
                                'users_ids' : users_ids,
                                'reques_ids' : reques_ids
                            },
                            url: "{{route('admin.crear_cita')}}",
                            success: function(response) {
                                $("#modal_gr").find(".modal-content").html(response);
                                $("#modal_gr").modal("show");
                            }
                        });

                    }

                });

            });

            $(".gestionar_cita").on("click", function () {
                var req_can_id = $(this).data("req_id");
                var user_id = $(this).data("user_id");
                var single = 1;

                $.ajax({
                    data:"req_id="+ req_can_id+ "&user_id="+ user_id+ "&single="+ single,
                    url: "{{route('admin.crear_cita')}}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_cita", function () {
                $(this).prop("disabled", false);

                $.ajax({
                    type: "POST",
                    data: $("#fr_cita").serialize(),
                    url: "{{ route('admin.guardar_cita') }}",
                    success: function (response) {
                        if (response.success) {
                            mensaje_success("Cita creada con exito.");
                            //location.reload();
                        }else{
                            var mensaje = response.mensaje;
                            mensaje_danger(mensaje);
                            //location.reload();
                        }
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
            });

        @else

            $("#fecha_carga_ini").datepicker(confDatepicker);
            $("#fecha_carga_fin").datepicker(confDatepicker);

            $(".gestionar_cita").on("click", function () {
                var req_can_id = $(this).data("req_can_id");
                var user_id = $(this).data("user_id");
                $.ajax({
                    data:"req_can_id="+ req_can_id+ "&user_id="+ user_id,
                    url: "{{route('admin.crear_cita')}}",
                    success: function (response) {
                        $("#modal_gr").find(".modal-content").html(response);
                        $("#modal_gr").modal("show");
                    }
                });
            });

            $(document).on("click", "#guardar_cita", function () {
                $(this).prop("disabled", false)
                $.ajax({
                    type: "POST",
                    data: $("#fr_cita").serialize(),
                    url: "{{ route('admin.guardar_cita') }}",
                    success: function (response) {
                         if (response.success) {
                            
                            mensaje_success("Cita creada con exito.");
                            location.reload();
                        } else {
                           var mensaje = response.mensaje;
                            mensaje_danger(mensaje);
                            location.reload();
                        }

                       
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


            });

        @endif            

    </script>
@stop