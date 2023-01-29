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
                    @foreach( $headerss as $key => $value )
                    <th class="active">
                        {{ $value }}
                    </th>
                    @endforeach
                </tr>
                @foreach( $data as $field )
                <tr>
                    @if($param==1)
                        <td>
                            {{$field->cliente}}
                        </td>
                         
                        <td>

                           {{(int)$field->vacantes_mes_pasado}}
                        </td>
                        <td>
                            
                             {{(int)$field->vacantes_mes_actual}}
                        </td>
                        <td>
                            {{(int)$field->vacantes_mes_actual+(int)$field->vacantes_mes_pasado   }}
                        </td>
                        <td>
                            {{(int)$field->vacantes_cerradas}}
                        </td>
                        <td>
                            0
                        </td>
                        <td>
                            {{(int)$field->vacantes_canceladas}}
                        </td>
                         <td>
                            {{(int)$field->vacantes_canceladas}}
                        </td>
                        <td>
                            {{(int)$field->vacantes_mes_actual+(int)$field->vacantes_mes_pasado-((int)$field->vacantes_canceladas+(int)$field->vacantes_cerradas)   }}
                        </td>
                        <td>
                            {{(int)$field->vacantes_mes_siguiente}}
                            
                        </td>
                        <td>
                            {{(int)$field->vacantes_cierre_dentro_mes}}
                        </td>
                    @elseif($param==2)
                    <td>
                            {{$field->cliente}}
                        </td>
                         
                        <td>

                           {{(int)$field->vacantes_mes_pasado}}
                        </td>
                        <td>
                            
                             {{(int)$field->vacantes_mes_actual}}
                        </td>
                        <td>
                            {{(int)$field->vacantes_mes_actual+(int)$field->vacantes_mes_pasado   }}
                        </td>
                        <td>
                            {{(int)$field->vacantes_cerradas}}
                        </td>
                        <td>
                            0
                        </td>
                        <td>
                            {{(int)$field->vacantes_canceladas}}
                        </td>
                         <td>
                            {{(int)$field->vacantes_canceladas}}
                        </td>
                        <td>
                            {{(int)$field->vacantes_mes_actual+(int)$field->vacantes_mes_pasado-((int)$field->vacantes_canceladas+(int)$field->vacantes_cerradas)   }}
                        </td>
                        <td>
                            {{(int)$field->vacantes_mes_siguiente}}
                        </td>
                        <td>
                            
                            {{(int)$field->vacantes_cierre_dentro_mes}}
                        </td>

                    @endif
                    
                   
                   
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
