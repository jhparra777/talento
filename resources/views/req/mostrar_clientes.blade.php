@extends("req.layout.master")
@section("contenedor")
<h3>Clientes</h3>
{!! Form::model(Request::all(),["route"=>"req.mostrar_clientes","method"=>"GET"]) !!}
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
    <div class="col-sm-10">
        {!! Form::text("nombre",null,["class"=>"form-control","placeholder"=>"Nombre" ]); !!}
    </div>
</div>
<!--
<div class="col-md-6 form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Nit:</label>
    <div class="col-sm-10">
        {!! Form::text("nit",null,["class"=>"form-control","placeholder"=>"Email" ]); !!}
    </div>
</div>
-->
<div class="clearfix"></div>
<button class="btn btn-success" type="submit">Buscar</button>
<a class="btn btn-danger" href="{{route("req.mostrar_clientes")}}" type="reset">Cancelar</a>
<a class="btn btn-warning" href="{{route("req_index")}}">Volver</a>

{!! Form::close() !!}
<div class="clearfix">
    <br>
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
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <!--<th>Pagina Web</th>-->
                    <th>Ubicación</th>
                </tr>
            </thead>
            <tbody>
                @if($clientes->count() == 0)
                <tr>
                    <td colspan="5">No se encontraron registros.</td>
                </tr>
                @endif
                @foreach($clientes as $cliente)
                <tr>
                    <td>
                        {!! Form::radio("cliente_id",$cliente->id,((session("cliente_id")==$cliente->id)?true:false),["data-url"=>route("req.datos.empresa",["cliente_id"=>$cliente->id]),"class"=>"seleccionar_item_grilla"]) !!}
                    </td>
                    <td>{{$cliente->nombre}}</td>

                    <td>{{$cliente->direccion}}</td>
                    <td>{{$cliente->telefono}}</td>
                    <!--<td>{{$cliente->pag_web}}</td>-->
                    <td>{{$cliente->getUbicacion()->value}}</td>

                </tr>
                @endforeach

            </tbody>
        </table> 
    </div>

</div>

<script>
    $(function () {
        $(".seleccionar_item_grilla").on("click", function () {
            var obj = $(this);
            var fintabla = $(".table").offset().top + $(".table").height();
            var finMenu = $(".menu_actions ol").offset().top + $(".menu_actions ol").height();
            $(".table tbody tr").css({"background-color": ""});
            var padre = obj.parents("tr");
            padre.css({"background-color": "rgb(255, 209, 35)"});
            var position_menu = $(".menu_actions ol").position().top;
            var height_menu = 0;
            if (finMenu > fintabla) {
                console.log("asd");
                alto_tr = padre.height();
                var height_menu = $(".menu_actions ol").height() - alto_tr - (finMenu - fintabla);
            }
            var total = padre.position().top - position_menu;

            $(".menu_actions ol").css({transition: "margin-top 1s", top: 0, display: "block", "margin-top": total - height_menu});
            $(".menu_actions").addClass("menu_actions_active");

//actualiza link
            $(".menu_actions .editar").attr("href", obj.data("url"));

        });
        $(".cancelar_table").on("click", function () {
            $(".menu_actions").removeClass("menu_actions_active");
        });

    });
</script>


@stop
