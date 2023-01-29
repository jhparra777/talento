@extends("req.layout.master")
@section("contenedor")

<style>
    .pagination{ margin: 0 !important; }

    .mb-1{ margin-bottom: 1rem; }
    .mb-2{ margin-bottom: 2rem; }
    .mb-3{ margin-bottom: 3rem; }
    .mb-4{ margin-bottom: 4rem; }
</style>

        {{-- Header --}}
        @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Usuarios"])

        <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alerta!</h4>
                {{Session::get("mensaje_success")}}
            </div>
        @endif
        {{-- <div class="col-md-12">
            <a class="btn btn-warning | tri-br-2 tri-fs-12 tri-txt-green tri-bg-white tri-bd-green tri-transition-300 tri-hover-out-greeny pull-right" href="{{route("req.nuevo_user")}}">Nuevo usuario <i class="fa fa-plus" aria-hidden="true"></i></a>
        </div> --}}
        {!! Form::model(Request::all(),["route"=>"req.usuarios","method"=>"GET"]) !!}      
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Nombre:</label>
                    {!! Form::text("nombre",null,["class"=>"form-control  | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Nombre" ]); !!}
            </div>
            <div class="col-md-6 form-group">
                <label for="inputEmail3" class="control-label">Email:</label>
                    {!! Form::text("email",null,["class"=>"form-control  | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300","placeholder"=>"Email" ]); !!}
            </div>

            <div class="col-md-12 text-right mb-2">
                <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" type="submit">Buscar <i class='fa fa-search' aria-hidden='true'></i></button>
                <a class="btn btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 " href="{{route("req.usuarios")}}" type="reset">Limpiar</a>
            </div>
        {!! Form::close() !!}

            <div class="col-md-12 mt-2">
                <div class="panel panel-default">
                    <div class="panel-body container_grilla">
                        {{-- <h3 class="box-title">Listado de usuarios</h3>
                        <div class="menu_actions">
                            <a href="#" class="btn editar btn-warning | tri-px-2 tri-br-2 tri-border--none tri-transition-300" >Editar</a>
                            <a href="#" class="btn cancelar_table btn-danger | tri-px-2 tri-br-2 tri-border--none tri-transition-300 ">Cancelar</a>
                        </div> --}}
                        <div class="tabla table-responsive">
                            <table class="table table-hover table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Estado</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($usuarios as $usuario)
                                <tr>
                                    {{-- <td>
                                        <input type="radio" name="usuario" data-url="{{route("req.editar_user",["user_id"=>$usuario->id])}}" class="seleccionar_item_grilla" data-id="{{$usuario->id}}">
                                    </td> --}}
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>{{  (($usuario->estado == 1)?"ACTIVO":"INACTIVO")  }}</td>
                                    <td><a href="{{route("req.editar_user",["user_id"=>$usuario->id])}}" class="btn editar btn-primary | tri-br-2 tri-fs-12 tri-txt-purple tri-bg-white tri-bd-purple tri-transition-300 tri-hover-out-purple" >Editar</a></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

        </div>
        <div class="col-sm-12 text-right" >
            <a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{route("req_index")}}">Volver</a>
        </div>
    </div>
{{-- <section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">           
                <div class="box-header">
                    <h3 class="box-title">Listado de usuarios</h3>
                </div>
                <div class="container_grilla">
                    <div class="menu_actions">
                        <ol>
                            <li><a href="#" class="editar" >Editar</a></li>

                            <li class="cancelar_table">Cancelar</li>
                        </ol>
                    </div>
                    <div class="tabla table-responsive">
                        <table class="table table-bordered table-hover ">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usuarios as $usuario)
                                <tr>
                                    <td>
                                        <input type="radio" name="usuario" data-url="{{route("req.editar_user",["user_id"=>$usuario->id])}}" class="seleccionar_item_grilla" data-id="{{$usuario->id}}">
                                    </td>
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>{{  (($usuario->estado == 1)?"ACTIVO":"INACTIVO")  }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>  --}}

{{-- <script>
    $(function () {
        $(".seleccionar_item_grilla").on("click", function () {
            var obj = $(this);
            // var fintabla = $(".table").offset().top + $(".table").height();
            // var finMenu = $(".menu_actions ol").offset().top + $(".menu_actions ol").height();
            // $(".table tbody tr").css({"background-color": ""});
            var padre = obj.parents("tr");
            padre.css({"background-color": "rgb(255, 209, 35)"});
            // var position_menu = $(".menu_actions ol").position().top;
            // var height_menu = 0;
            // if (finMenu > fintabla) {
            //     console.log("asd");
            //     alto_tr = padre.height();
            //     var height_menu = $(".menu_actions ol").height() - alto_tr - (finMenu - fintabla);
            // }
            // var total = padre.position().top - position_menu;

            // $(".menu_actions ol").css({transition: "margin-top 1s", top: 0, display: "block", "margin-top": total - height_menu});
            // $(".menu_actions").addClass("menu_actions_active");

            //actualiza link
            $(".menu_actions .editar").attr("href", obj.data("url"));

        });
        $(".cancelar_table").on("click", function () {
            $(".menu_actions").removeClass("menu_actions_active");
        });

    });
</script> --}}


@stop