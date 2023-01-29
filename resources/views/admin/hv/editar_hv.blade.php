@extends("admin.layout.master")
@section("contenedor")


<ul class="nav nav-tabs tabs-up" id="friends">
    <li><a href="{{ route("admin.editar_datos_basicos") }}" data-id_hv="{{$user_id}}" data-target="#container_tab" class="media_node active span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Datos Basicos </a></li>
    <li><a href="{{ route("admin.editar_estudios") }}" data-id_hv="{{$user_id}}" data-target="#container_tab" class="media_node span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Estudios</a></li>
    <li><a href="{{ route("admin.editar_experiencias") }}" data-id_hv="{{$user_id}}" data-target="#container_tab" class="media_node span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Experiencia</a></li>
    <li><a href="{{ route("admin.editar_ref_personal") }}" data-id_hv="{{$user_id}}" data-target="#container_tab" class="media_node span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Referencias Personales</a></li>
    <li><a href="{{ route("admin.editar_grupo_familiar") }}" data-id_hv="{{$user_id}}" data-target="#container_tab" class="media_node span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Grupo Familiar</a></li>
    <li><a href="{{ route("admin.editar_perfilamiento") }}" data-id_hv="{{$user_id}}" data-target="#container_tab" class="media_node span" id="contacts_tab" data-toggle="tabajax" rel="tooltip"> Perfilamiento</a></li>

</ul>

<div class="tab-content">
    <div class="tab-pane active" id="container_tab">

    </div>

</div>

<script>
    $(function () {
        $('[data-toggle="tabajax"]').click(function (e) {
            var $this = $(this),
                    loadurl = $this.attr('href'),
                    targ = $this.attr('data-target');
            id_hv = $this.data('id_hv');
            $.ajax({
                type: "GET",
                data: {user_id: id_hv},
                url: loadurl,
                success: function (data) {
                    $(targ).html(data);
                }

            });

            $this.tab('show');
            return false;
        });
    });
</script>
@stop
