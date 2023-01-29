<div class="tabla table-responsive">
  <table class="data-table table-bordered table-hover">
    <thead>
     <tr>
      <th></th>
      <th><div class="checkbox">
		  {!! Form::checkbox("seleccionar_todos",null,false,["id"=>"seleccionar_todos"]) !!} Seleccionar </div></th>
      <th>Nombres</th>
      <th>Apellidos</th>
      <th>Cédula</th>
      <th>Telefono Móvil</th>
      <th>Email</th>
      <th>Fecha Carga</th>
      <th>Nombre Carga</th>
      <th>Requerimiento Asignado</th>
      <th>Estado del Requerimiento</th>
     </tr>
    </thead>
       <tbody>
        @if(empty($carga) || $carga->count() == 0)
         <tr>
          <td colspan="5">No se encontraron registros</td>
         </tr>
        @else

        @foreach($carga as $key => $candidato)
         
         <tr id="">
          <td>{{++$key}}</td>
          <td>
           {!! Form::checkbox("user_id[]",$candidato->user_id,null,["style"=>'text-align: center;']) !!}
            <p class="text-danger">{!! FuncionesGlobales::getErrorData("candidato",$errors) !!}</p>
          </td>
          <td>{{ $candidato->nombres }}</td>
          <td>{{ $candidato->primer_apellido }}</td>
          <td>{{ $candidato->identificacion }}</td>
          <td>{{ $candidato->telefono_movil }}</td>
          <td>{{ $candidato->email }}</td>
          <td>{{ $candidato->created_at }}</td>
          <td>{{ $candidato->nombre_carga }}</td>
          <?php $req = $candidato->getCandidatoReq(); ?>
          <td>{{($req !="")?$req['req_id']:"No Asignado" }}</td>
          <td>{{($req !="")?$req['estado_req']:""}}</td>
         </tr>
        @endforeach
      @endif
        </tbody>
    </table>
</div>