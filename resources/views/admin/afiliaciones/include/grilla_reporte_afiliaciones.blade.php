<table class="table table-hover table-striped text-center">
    <thead>
        <tr>
            <th>#</th>
            <th>REQUERIMIENTO</th>
            <th>NOMBRES Y APELLIDOS</th>
            <th>TIPO DOCUMENTO</th>
            <th>IDENTIFICACIÓN</th>
            <th>FECHA DE NACIMIENTO</th>
            <th>CIUDAD</th>
            <th>LOCALIDAD DE RESIDENCIA</th>
            <th>DIRECCIÓN</th>
            <th>CORREO</th>                          
            <th>CELULAR</th>
            
            <th>FONDO DE PENSIÓN</th>
            <th>EPS</th>
            <th>REGIMEN EPS</th>
            <th>TIPO TRAMITE</th>
            <th>CARGO</th>
            <th>SALARIO</th>
            <th>FECHA INGRESO</th>
            <th>FECHA FIRMA CONTRATO</th>
            <th>RIESGO ARL TRABAJADOR</th>
            <th>CAJA DE COMPENSACIÓN</th>
            <th>ESTADO AFILIACIÓN</th>
            <th>ESTADO CONTRATO</th>
        </tr>
    </thead>

    <tbody>
        @forelse($candidatos as $item => $candidato)
            <?php
                //Se suma 1 para que comience en 1; se suman de 12 en 12 a partir de la pagina 2
                $nro_item = $item+1;
            ?>
            <tr>
                <td>
                    {{$nro_item}}
                </td>
                <td>
                    {{$candidato->req_id}}
                </td>
                <td>
                    {{ mb_strtoupper($candidato->nombres ." ".$candidato->primer_apellido." ".$candidato->segundo_apellido) }}
                </td>
                <td>
                    {{ $candidato->tipo_documento }}
                </td>
                <td>
                    {{ $candidato->numero_id }}
                </td>
                <td>
                    {{ $candidato->fecha_nacimiento }}
                </td>
                <td>
                    {{$candidato->nombre_ciudad}}
                </td>
                <td>
                    {{ $candidato->barrio }}
                </td>
                <td>
                    {{ $candidato->direccion }}
                </td>

                <td>
                    {{ $candidato->email }}
                </td>
                <td>
                    {{ $candidato->telefono_movil }}
                </td>
                <td>
                    {{ $candidato->fondo_pension }}
                </td>
                <td>
                    {{ $candidato->eps }}
                </td>
                <td>
                    PENDIENTE
                </td>
                <td>
                    @if($candidato->tipo_ingreso == 1)
                        NUEVO                                  
                    @else
                        RECONTRATO          
                    @endif
                </td>
                <td>
                    {{ $candidato->cargo }}
                </td>
                <td>
                    {{ $candidato->salario }}
                </td>
                <td>
                    {{ $candidato->fecha_ingreso }}
                </td>
                <td>
                    {{ $candidato->fecha_firma }}
                </td>
                <td>
                    {{ $candidato->riesgo_arl }}
                </td>
                <td>
                    {{ $candidato->caja_compensacion }}
                </td>  
                <td>
                    @if ($candidato->estado_afiliado == 0)
                        EN ESPERA
                    @else
                        AFILIADO
                    @endif
                </td>
                <td>
                    {{ ($candidato->estado_contrato == 0 ? 'ANULADO' : 'FIRMADO') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="21">
                    No se encontraron registros.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>