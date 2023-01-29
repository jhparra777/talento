<div class="container">
    <div class="row">
        @if(method_exists($data, 'total'))
        <h4>
            Total de Registros :
            <span>
                {{$data->total()}}
            </span>
        </h4>
        @endif
        <div class="table-responsive">
          
            <table class="table table-bordered">
              <tr>
                    @foreach( $headers as $key => $value )
                    <th class="active" >
                        {{$value}}
                    </th>
                    @endforeach
              </tr>
               
                    @foreach( $data as $field )
                    <tr>
                        <td>{{$field->orden}}</td>
                        <td>{{$field->fecha_orden}}</td>
                        <td>
                            @if(strlen($field->cedula)>10)
                                {{(string)"\t"."PEP".$field->cedula."\t"}}
                            @else
                                {{$field->cedula}}
                            @endif
                        </td>
                        <td>{{$field->nombres}} {{$field->primer_apellido}}</td>
                        <td>{{$field->cliente}}</td>
                        <td>{{$field->cargo}}</td>
                        <td>{{$field->ciudad}}</td>
                        <td>{{$field->proveedor}}</td>
                        <td></td>
                        <td></td>
                        <td>{{$field->observacion}}</td>
                        @foreach($examenes as $examen)
                            <td style="text-align: center;">
                                @if(in_array($examen->id,$field->examenes_medicos->pluck('examen')->toArray()))
                                    X
                                @endif
                            </td>
                        @endforeach
                    </tr>
                    @endforeach
           
            </table>
        </div>
             
        <div>
         @if(method_exists($data, 'appends'))
          {!! $data->appends(Request::all())->render() !!}
         @endif
        </div>
    </div>
</div>

