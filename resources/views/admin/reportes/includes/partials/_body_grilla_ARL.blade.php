@foreach( $data as $field )
    <tr>
        <td>
            {{$field->tipo_identificacion}}
        </td>

        <td>
            {{$field->numero_id}}
        </td>

        <td>
            {{$field->primer_nombre}}
        </td>
        
        <td>
            {{$field->segundo_nombre}}
        </td>

        <td>
            {{$field->primer_apellido}}
        </td>

        <td>
            {{$field->segundo_apellido}}
        </td>

        <td>
            {{$field->fecha_nacimiento}}
        </td>

        <td>
            {{$field->genero}}
        </td>

        <td>
            {{$field->descripcion_estado_civil}}
        </td>

        <td>
            {{$field->fecha_ingreso_req}}
        </td>

        <td>
            {{$field->descripcion_cargo}}
        </td>

        <td>
            
        </td>

        <td>
            {{$field->tipo_salario}}
        </td>

        <td>
            {{$field->salario}}
        </td>

        <td>
            {{$field->eps}}
        </td>

        <td>
            {{$field->afp}}
        </td>

        <td>
            {{$field->departamento_resi}}
        </td>

        <td>
            {{$field->ciudad_resi}}
        </td>

        <td>
            
        </td>

        <td>
            {{$field->nit}}
        </td>

        <td>
            
        </td>

        <td>
            {{$field->clase_riesgo}}
        </td>

        <td>
            {{$field->direccion}}
        </td>

        <td>
            {{$field->telefono_fijo}}
        </td>

        <td>
            {{$field->telefono_movil}}
        </td>

        <td>
            {{$field->email}}
        </td>

        <td>
            
        </td>
    </tr>
@endforeach
