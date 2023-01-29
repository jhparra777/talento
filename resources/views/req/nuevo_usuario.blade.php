@extends("req.layout.master")
@section("contenedor")

{{-- Header --}}
@include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Crear usuario"])

<style>
    .ancla-permisos-usuario {
        font-weight: bold;
    }

    .ancla-permisos-usuario:hover, .ancla-permisos-usuario:active, .ancla-permisos-usuario:focus {
        outline: none;
        text-decoration: none;
        color: white;
    }
</style>

    {!! Form::open(["route"=>"req.guardar_user","id"=>"frm_usuarios","method"=>"POST","autocomplete"=>"off"]) !!}
        <div class="row">
            @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    {{Session::get("mensaje_success")}}
                </div>
            </div>
            @endif
        
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body pb-5">
                        <div class="col-md-12 mb-1">
                            <h4>Información básica</h4>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Primer nombre: *</label>
                            {{-- {!! Form::text("primer_nombre", $usuario->getDatosBasicos()->primer_nombre, ["class" =>
                            "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Primer
                            nombre" ]); !!} --}}
                            {!! Form::text("primer_nombre",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                            tri-transition-300","placeholder"=>"Primer Nombre" ]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("primer_nombre",$errors) !!}</p>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Segundo Nombre:</label>
                            {!! Form::text("segundo_nombre",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                            tri-transition-300","placeholder"=>"Segundo Nombre" ]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("segundo_nombre",$errors) !!}</p>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Primer Apellido:*</label>
                            {!! Form::text("primer_apellido",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                            tri-transition-300","placeholder"=>"Primer Apellido" ]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Segundo Apellido:</label>
                            {!! Form::text("segundo_apellido",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                            tri-transition-300","placeholder"=>"Segundo Apellido" ]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Nick:</label>
                            {!! Form::text("username",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                            tri-transition-300","placeholder"=>"Nick" ]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("username",$errors) !!}</p>
                        </div>
        
        
                        <div class="col-md-12 form-group">
                            <label>Número de @if( route("home") == "https://gpc.t3rsc.co")CI @else CC @endif:</label>
                            {!! Form::text("numero_id",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                            tri-transition-300","placeholder"=>"Número Documento" ]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("numero_id",$errors) !!}</p>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Email:*</label>
                            {!! Form::text("email",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                            tri-transition-300","placeholder"=>"Email Personal", "required" => "required"]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("email",$errors) !!}</p>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Correo Corporativo:</label>
                            {!! Form::text("correo_corporativo",null,["class"=>"form-control | tri-br-1 tri-fs-12
                            tri-input--focus tri-transition-300","placeholder"=>"Email Corporativo" ]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("correo_corporativo",$errors) !!}</p>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Contraseña</label>
                            {!! Form::password("password",["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                            tri-transition-300","placeholder"=>"CONTRASEÑA USUARIO"]); !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("password",$errors) !!}</p>
                        </div>
        
                        <div class="col-md-12 form-group">
                            <label>Ciudad de trabajo:<span class='text-danger sm-text-label'>*</span></label>
                            {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id"]) !!}
                            {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id"]) !!}
                            {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id"]) !!}
        
                            {!! Form::text("ciudad_autocomplete",null,["class"=>"form-control | tri-br-1 tri-fs-12
                            tri-input--focus tri-transition-300","id"=>"ciudad_autocomplete","placheholder"=>"Digita cuidad"])
                            !!}
                            <p class="error text-danger direction-botones-center">{!!
                                FuncionesGlobales::getErrorData("pais_id",$errors) !!}</p>
                        </div>
        
                    </div>
                </div>
            </div>
            {{-- Permisos requisición --}}
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>Permisos Requisición</h4>
        
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox("seleccionar_todos", null, false, ["id" => "seleccionar_todos"]) !!}
                                Seleccionar todos
                            </label>
                        </div>
                        <div class="tri-overflow">
                            <ol class="lista-permisos">
                                @foreach($permisos as $permiso)
                                    <li>
                                        {!!
                                        Form::checkbox("permiso[]",$permiso->slug,null,["class"=>"padre","data-id"=>$permiso->id])
                                        !!} {{$permiso->descripcion}}
                                        <?php
                                                    $menu_nivel2 = $permiso->menu_hijo1();
                                                ?>
                                        @if($menu_nivel2->count() > 0)
                                        <ol>
                                            @foreach($permiso->menu_hijo1() as $nivel_2)
                                                <li>
                                                    {!!
                                                    Form::checkbox("permiso[]",$nivel_2->slug,null,["class"=>"padre".$nivel_2->padre_id])
                                                    !!} {{$nivel_2->descripcion}}
                                                </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Clientes --}}
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h4>Clientes</h4>
        
                        <div class="checkbox">
                            <label>
                                {!! Form::checkbox("seleccionar_todosc", null, false, ["id" => "seleccionar_todosc"]) !!}
                                Seleccionar todos
                            </label>
                        </div>
                        <div class="tri-overflow">
                            <ol>
                                @foreach($clientes as $cliente)
                                 <li>{!! Form::checkbox("clientes[]",$cliente->id)  !!} {{$cliente->nombre}}</li>
                                @endforeach
                               </ol>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Botones acción --}}
            <div class="col-md-12 text-right">
                <a class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" href="{{ route("req.usuarios") }}">Volver</a>
                {!! FuncionesGlobales::valida_boton_req("req.guardar_user","Guardar","submit","btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green") !!}
                {{-- <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green">Actualizar</button> --}}
            </div>
        </div>
    {!! Form::close() !!}

{{-- 
<div class="clearfix"></div>
<div class="col-md-8 col-md-offset-2">
    {!! Form::open(["route"=>"req.guardar_user","id"=>"frm_usuarios","method"=>"POST","autocomplete"=>"off"]) !!}
    @if(Session::has("mensaje_success"))
    <div class="col-md-12" id="mensaje-resultado">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get("mensaje_success")}}
        </div>
    </div>
    @endif
    <div class="col-md-12 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Nombre:</label>
        <div class="col-sm-10">
         {!! Form::text("name",null,["class"=>"form-control","placeholder"=>"Nombre" ]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("name",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Nick:</label>
        <div class="col-sm-10">
          {!! Form::text("username",null,["class"=>"form-control","placeholder"=>"Correo" ]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("username",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Numero de documento:</label>
        <div class="col-sm-10">
          {!! Form::text("numero_id",null,["class"=>"form-control","placeholder"=>"Correo" ]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("username",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Email:</label>
        <div class="col-sm-10">
          {!! Form::text("email",null,["class"=>"form-control","placeholder"=>"Correo" ]); !!}
        </div>
           <p class="error text-danger direction-botones-center">
           {!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
    </div>
     <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">Correo Corporativo:</label>
            <div class="col-sm-10">
             {!! Form::text("correo_corporativo",null,["class"=>"form-control","placeholder"=>"Correo" ]); !!}
            </div>
            <p class="error text-danger direction-botones-center">
             {!! FuncionesGlobales::getErrorData("correo_corporativo",$errors) !!}</p>
        </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Contraseña:</label>
        <div class="col-sm-10">
         {!! Form::password("password",["class"=>"form-control","placeholder"=>"" ]); !!}
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("password",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <div class="form-group">
          <label for="ciudad_id" class="col-md-2 control-label">Ciudad de trabajo:<span class='text-danger sm-text-label'>*</span></label>
            <div class="col-md-10">
             {!! Form::hidden("pais_id",null,["class"=>"form-control","id"=>"pais_id_u"]) !!}
             {!! Form::hidden("ciudad_id",null,["class"=>"form-control","id"=>"ciudad_id_u"]) !!}
             {!! Form::hidden("departamento_id",null,["class"=>"form-control","id"=>"departamento_id_u"]) !!}
             {!! Form::text("ciudad_autocomplete_u",null,["class"=>"form-control","id"=>"ciudad_autocomplete_u","placheholder"=>"Digita cuidad"]) !!}
            </div>
        </div>
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("pais_id_u",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
      <label for="inputEmail3" class="col-sm-2 control-label">Cliente:</label>
        <div class="col-sm-10">
          <ol>
           @foreach($clientes as $cliente)
            <li>{!! Form::checkbox("clientes[]",$cliente->id)  !!} {{$cliente->nombre}}</li>
           @endforeach
          </ol>
        </div>
    </div>
    <div class="clearfix"></div>

    <h3>Permisos</h3>
    <div class="checkbox">
        <label>
         {!! Form::checkbox("seleccionar_todos",null,false,["id"=>"seleccionar_todos"]) !!} Seleccionar todos
        </label>
    </div>

    <ol>
        @foreach($permisos as $permiso)
        <li>
            {!! Form::checkbox("permiso[]",$permiso->id,false,["class"=>"padre","data-id"=>$permiso->id]) !!} {{$permiso->descripcion}}
            
            @if($menu_nivel2->count() > 0)
            <ol>
                @foreach($permiso->menu_hijo1() as $nivel_2)
                <li>
                    {!! Form::checkbox("permiso[]",$nivel_2->id,false,["class"=>"padre".$nivel_2->padre_id]) !!} {{$nivel_2->descripcion}}

                </li>
                @endforeach
            </ol>
            @endif
        </li>
        @endforeach
    </ol>
    {!! FuncionesGlobales::valida_boton_req("req.guardar_user","Guardar","submit","btn btn-success") !!}

    {!! Form::close() !!} 
</div> --}}
<script>
    $(function () {
        $("#seleccionar_todosc").on("change", function () {
            var obj = $(this);
            $("input[name='clientes[]']").prop("checked", obj.prop("checked"));
        });

        $("#seleccionar_todos").on("change", function () {
            var obj = $(this);
            $("input[name='permiso[]']").prop("checked", obj.prop("checked"));
        });
        $(".padre").on("change", function () {
            var obj = $(this);

            $(".padre" + obj.data("id") + "").prop("checked", obj.prop("checked"));
        });
        $('#ciudad_autocomplete').autocomplete({
                serviceUrl: '{{ route("autocomplete_cuidades") }}',
                autoSelectFirst: true,
                onSelect: function (suggestion) {
                    $("#pais_id").val(suggestion.cod_pais);
                    $("#departamento_id").val(suggestion.cod_departamento);
                    $("#ciudad_id").val(suggestion.cod_ciudad);
                }
            });

        // $('#ciudad_autocomplete_u').autocomplete({
        //     serviceUrl: '{{ route("autocomplete_cuidades") }}',
        //     autoSelectFirst: true,
        //     onSelect: function (suggestion) {
        //         $("#pais_id_u").val(suggestion.cod_pais);
        //         $("#departamento_id_u").val(suggestion.cod_departamento);
        //         $("#ciudad_id_u").val(suggestion.cod_ciudad);
        //     }
        // });
    })
</script>
@stop()