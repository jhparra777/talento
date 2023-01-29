@if(count($arrayEncontrados)>0)
<h2 class="header" style="text-align:center;">  RESULTADOS. </h2>
 @foreach($arrayEncontrados as $key => $tipo_cargo)
  <div class="panel panel-primary">
   <div class="panel-body">
    <div class="col-md-12">
    <h3 class="header-section-form" id="cargos-{{$key}}">{{$tipo_cargo["name"]}}</h3>
     @foreach($tipo_cargo["items"] as $key2 => $cargo)
    
      <div class="checkbox-container-cargos">
       <label> <input {{((in_array($cargo->id,$items_cargos))?"checked":"")}} value="{{$cargo->id}}" type="checkbox" name="cargos[]" class="seleccionar_cargo" data-cargo_name="{{$tipo_cargo["name"]}}" data-cargo_id="{{$key}}" data-item_name="{{$cargo->descripcion}}" data-id="{{$cargo->id}}"> {{$cargo->descripcion}}
       </label>
      </div>
     @endforeach
    </div>
   </div>
  </div>
 @endforeach
@else
 
 <div class="panel panel-primary">
  <div class="panel-body">
   <div class="col-md-12">
     <div class="checkbox-container-cargos">
      <label> No se encontraron coincidencias..   </label>
     </div>
   </div>
  </div>
 </div>

@endif