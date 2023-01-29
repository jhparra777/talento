@extends("admin.layout.master")
@section("contenedor")

<div class="col-md-8 col-md-offset-2">

    {!! Form::model($registro,["id"=>"fr_cargos_especificos","route"=>"admin.cargos_especificos.actualizar","files"=>true,"method"=>"POST"]) !!}
    {!! Form::hidden("id") !!}

    <h3>Editar Cargos Especificos</h3>

    <div class="clearfix"></div>

    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje_success")}}
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Descripcion:</label>
            <div class="col-sm-10">
                {!! Form::text("descripcion",null,["class"=>"form-control","placeholder"=>"descripcion" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("descripcion",$errors) !!}</p>    
        </div>

        <div class="col-md-12 form-group">
            
            @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
            
                <label for="inputEmail3" class="col-sm-2 control-label">Área Laboral:</label>
            
            @else
                
                <label for="inputEmail3" class="col-sm-2 control-label">Cargo Genérico:</label>
            
            @endif

            <div class="col-sm-10">
                {!! Form::select("cargo_generico_id",$cargosGenericos,null,["class"=>"form-control","placeholder"=>"clt_codigo" ]); !!}
            </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_generico_id",$errors) !!}</p>    
        
        </div>

        @if(route('home') == "http://komatsu.t3rsc.co" || route('home') == "https://komatsu.t3rsc.co")
            <!--NOTHING-->
        @else

            <div class="col-md-12 form-group">
                
                <label for="inputEmail3" class="col-sm-2 control-label">Cliente</label>
                
                <div class="col-sm-10">
                    {!! Form::select("clt_codigo",$clientes,null,["class"=>"form-control","placeholder"=>"cargo_generico_id" ]); !!}
                </div>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("cargo_generico_id",$errors) !!}</p>    
            
            </div>

        @endif


         <div class="col-md-12 form-group">
            
            <label> Archivo perfil pdf <span></span> </label>

            {!! Form::file("perfil",["class"=>"form-control-file", "id"=>"perfil" ,"name"=>"perfil" ]) !!}
            
            <p class="error text-danger direction-botones-center">
             {!! FuncionesGlobales::getErrorData("perfil",$errors) !!}
            </p>
         
         </div>
        

    </div>
@if($user_sesion->hasAccess("boton_crear_pregunta"))

    <div class="col-md-12 col-lg-12">
    <div class="row">
        <div class="box">
                <div class="box-header with-border">
                <h3 class="box-title"> PREGUNTAS DEL CARGO </h3>

                 <button style="text-align: left;" type="button"  data-cargo_id="{{$cargo_id}}" class="btn  btn-primary crear_preg" id="crear_preg"> Crear Pregunta</button>
                <br><br>
     
               </div>

               <div class="box-body table-responsive no-padding">

                    <table class="table table-bordered" id="tbl_preguntas" >
            <thead>
                <tr>
                    <th >Descripción</th>
                    <th  >Filtro</th>
                    <th  >Tipo de pregunta</th>
                    <th style="text-align: center;" >Respuestas</th>
                    <th   style="text-align: center;" colspan="2">Acción</th>

                </tr>
            </thead>
            <tbody>
                
                @foreach($preguntas_cargo as $count => $pregu)
                <tr id="tr_{{$pregu->id}}">
                
                    <td >{{$pregu->descripcion}}</td>
                    <td >{{(($pregu->filtro==1)?"Si":"No")}}</td>
                    <td >{{$pregu->descr_tipo_p}}</td>

                    <td style="text-align: center;">

                              @if($pregu->tipo_id ==3)
                                    <p>No tiene respuestas</p>
                               @else
                                @foreach($pregu->respuestas_preg_req() as $count =>$res)
                                         
                                    <div style="text-align: center;" id="respuestas" >
                                          {{ ++$count }}. {{ $res->des }}<br> 
                                    </div> 
                                    
                                @endforeach
                              @endif                       

                    </td>
                    

                    @if($pregu->activo == 1 )
                    <td   style="text-align: center;"colspan="2">
                              <a class="btn btn-warning btn-sm editar_pregunta" target="_black" data-preguntas_req="{{$pregu->id}}">EDITAR PREGUNTA 
                            </a>
                             <a class="btn btn-danger btn-sm btn_inactivar" target="_black" data-preg_id ={{$pregu->id }}{{-- href="{{route("admin.hv_pdf",["user_id"=>$lista->user_id])}}" --}}>INACTIVAR 
                            </a>

                    </td>
                    @else
                    <td style="text-align: center;" colspan="2">
                              <a class="btn btn-warning btn-sm " target="_black" data-preguntas_req="{{$pregu->id}}"{{-- href="{{route("admin.hv_pdf",["user_id"=>$lista->user_id])}}" --}}>EDITAR PREGUNTA
                            </a>
                             <a class="btn btn-success btn-sm btn_activar" target="_black" data-preg_id ={{$pregu->id }}{{-- href="{{route("admin.hv_pdf",["user_id"=>$lista->user_id])}}" --}}>ACTIVAR
                            </a>
                    </td>
                    @endif
                </tr>

                
                @endforeach
                </td>
            </tbody>
        </table>

          </div>         
                </div>

        </div>   
       
    </div>
    @endif
</div>
    <div class="clearfix" ></div>
    @if($registro->archivo_perfil == true)
    <a href="{{url("recursos_Perfiles",["archivo"=>$registro->archivo_perfil])}}" class="btn btn-danger" target="_black" >
    PDF Perfil
</a>
@endif
    {!! FuncionesGlobales::valida_boton_req("admin.cargos_especificos.actualizar","Actualizar","submit","btn btn-success") !!}
    <a href="#" class="btn btn-warning" onclick="window.history.back()">Volver Listado</a>
    {!! Form::close() !!}
</div>

<script>
    $(function () {
        //$("textarea").jqte({button:false});
        $(document).on("click",".editar_pregunta", function () {
            var  preguntas_req = $(this).data("preguntas_req");
            $.ajax({
                data: {pregunta_req_id: preguntas_req},
                url: "{{route('admin.editar_pregunta_req')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

        $(document).on("click", "#actualizar_preg", function() {
           
            $.ajax({
                type: "POST",
                data: $("#fr_editar_preg_ofer").serialize() + "&enviar=1",
                url: "{{ route('admin.actualizar_pregunta_req') }}",
                success: function(response) {
                        $("#modal_peq").find(".modal-content").html(response.view);
                        $("#modal_peq").modal("show");
                        $("#modal_peq").modal("hide");
                         mensaje_success("Se ha actualizado la pregunta con éxito");
                         location.reload();
                }
            });
        });
        $("#detalle_req").on("click", function () {
            var req = $(this).data("req");
            $.ajax({
                data: {id: req},
                url: "{{route('admin.detalle_requerimiento')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

         $(document).on("click",".btn_inactivar", function () {
            var preg_id = $(this).data("preg_id");
            var btn = $(this);
               
            $.ajax({
                type: "POST",
                data: {preg_id: preg_id},
                url: "{{ route('admin.inactivar_pregunta') }}",
                success: function (response) {
                    var prueba = $(this).data("prueba");
                    var req = $(this).data("req");
                    mensaje_success("Pregunta Inactivada!!");
                    location.reload();

                }
            });
        });

           $(document).on("click",".btn_activar", function () {
            var preg_id = $(this).data("preg_id");
            var btn = $(this);
               
            $.ajax({
                type: "POST",
                data: {preg_id: preg_id},
                url: "{{ route('admin.activar_pregunta') }}",
                success: function (response) {
                    var prueba = $(this).data("prueba");
                    var req = $(this).data("req");
                    mensaje_success("Pregunta activada!!");
                    location.reload();
                }
            });
        });
        //$("textarea").jqte({button:false});
        $("#crear_preg").on("click", function () {
            var req_id = $(this).data("req");
            var cargo_id = $(this).data("cargo_id");
            $.ajax({
                data: {req_id: req_id,cargo_id: cargo_id},
                url: "{{route('admin.crear_pregunta_req')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });



        $(document).on("click", "#guardar_preg", function () {
            $(this).prop("disabled", false)
            
            $.ajax({
                type: "POST",
                data: $("#fr_preg").serialize(),
                url: "{{ route('admin.guardar_pregunta_cargo') }}",
                success: function (data) {
                //alert("sisa");
                     $("#modal_gr").modal("hide");
                       mensaje_success("Pregunta creada con éxito!!");
                       location.reload();
                   
                }

            });


        });
/*
        $("#ver_ranking").on("click", function () {
            var req_id = $(this).data("req");
            var cargo_id = $(this).data("cargo_id")
            $.ajax({
                data: {req_id: req_id,cargo_id : cargo_id},
                url: "{{route('admin.ver_ranking')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });

            $("#ver_respuestas").on("click", function () {
            var req_id = $(this).data("req");
            var cargo_id = $(this).data("cargo_id")
            $.ajax({
                data: {req_id: req_id,cargo_id: cargo_id},
                url: "{{route('admin.ver_respuestas')}}",
                success: function (response) {
                    $("#modal_gr").find(".modal-content").html(response);
                    $("#modal_gr").modal("show");
                }
            });
        });*/


      
    });


    
</script>
@stop