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
              
              <thead>
                <tr>
                    @foreach( $headersr as $key => $value )
                    <th class="active" >
                        {{$value}}
                    </th>
                    @endforeach
                </tr> 
              </thead>
              <tbody>
              @foreach( $data as $field )
                <tr>
                    <td>
                        {{$field->nombre_vacante}}
                    </td>
                    <td>
                      @if($field->tipo_experiencia_id == 3)
                        1
                      @elseif($field->tipo_experiencia_id == 4)
                        2
                      @elseif($field->tipo_experiencia_id == 5)
                        3
                      @else
                        0
                      @endif
                    </td>
                    <td>
                      {{$field->nivel_de_estudio}}
                    </td>
                    <td>
                      {{$field->cargo_generico}}
                    </td>
                    <td>
                      ${{number_format($field->salario, 0, ',', '.')}}
                    </td>
                    <td>
                      {!!$field->descripcion_oferta!!}
                    </td>
                    <td>
                      {{$field->funciones}}
                    </td>
                    <td>
                      {{date("Y-m-d", strtotime($field->fecha_tentativa_cierre_req))}}
                    </td>
                    <td>
                      {{$field->num_vacantes}}
                    </td>
                    <td>
                      {{$field->observaciones}}
                    </td>
                    <td>
                      {{$field->cliente}}
                    </td>
                    <td>
                      Gestión Humana
                    </td>
                    <td>
                      Si
                    </td>
                    <td>
                      {{$field->tipo_contrato}}
                    </td>
                    <td>
                      {{$field->nombre_ciudad}}
                    </td>
                    <td>
                      {{$field->tipo_jornada}}
                    </td>
                </tr>
              @endforeach
              </tbody>
            </table>
        </div>
        {{--MOver a indicadores--}}      
        <div>
         @if(method_exists($data, 'appends'))
          {!! $data->appends(Request::all())->render() !!}
         @endif
        </div>
    </div>
</div>

