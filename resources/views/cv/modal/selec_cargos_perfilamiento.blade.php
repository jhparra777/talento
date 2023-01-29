@if(count($arrayEncontrados)>0)
  <option value=""> Seleccione... </option>
 @foreach($arrayEncontrados as $key => $tipo_cargo)
  
  @foreach($tipo_cargo["items"] as $key2 => $cargo)  
    <option value="{{$cargo->id}}" data-cargo_name="{{$tipo_cargo["name"]}}" data-cargo_id="{{$key}}" data-item_name="{{$cargo->descripcion}}" data-id="{{$cargo->id}}"> {{$cargo->descripcion}} </option>
  @endforeach
 @endforeach
 
@else
 
  <option value=""> No se encontrron cargos </option>

@endif