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