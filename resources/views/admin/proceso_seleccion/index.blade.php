@extends("admin.layout.master_full")
@section("contenedor")
@if(Session::has("mensaje_error"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {!! Session::get("mensaje_error") !!}
    </div>
</div>
@endif
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {!! Session::get("mensaje_success") !!}
    </div>
</div>
@endif
<div class="row digiturno_imagen">

    <div class="col-md-4 col-md-offset-4 digiturno">
        @if(Session::has("mensaje_error"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {{Session::get("mensaje_error")}}
            </div>
        </div>
        @endif
        <h4>Numero de candidatos a atender</h4>
        <div class="cantidad">{{$turnos->count()}}</div>
        <a class="btn-3 btn btn-block" href="{{ route("admin.proceso_seleccion_gestion",["turno_id"=>$turnos->get(0)])  }}" >Siguiente</a>
    </div>

</div>

<script>
    $(function () {
        
        function cargar_turnos() {
            $.ajax({
                type: "POST",
                url: "{{route('admin.refrescar_turno')}}",
                success: function (response) {
                    $(".digiturno").html(response);
                }

            });
        }
        setInterval(cargar_turnos,10000);
    });
</script>
@stop