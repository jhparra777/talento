<section class="center">
    <table class="table  table-striped" >
        <thead>
            <section class="secciones-titulos-2 text-center">
                <h2 style="color: #6F3795;">DATOS PERSONALES</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            
        </thead>
        <tbody>
            <?php
                $nombre_ad = $visita->primer_nombre . ' ' . $visita->segundo_nombre . ' ' . $visita->primer_apellido .' ' . $visita->segundo_apellido;
            ?>

            <tr>
                <th>Nombres y apellidos</th>
                <td>{{ $nombre_ad }} </td>
                <th>Tipo de documento</th>
                <td>{{ $visita->tipo_documento }}</td>
            </tr>

            <tr>
                <th>Documento de identidad</th>
                <td>{{ $visita->numero_id }} </td>
                <th>Lugar de expedición</th>
                <td>{{ ucwords(mb_strtolower($visita->ciudad_exp_autocomplete)) }} </td>
            </tr>

            <tr>
                <th>Fecha de expedición</th>
                <td>{{date("d-m-Y",strtotime($visita->fecha_expedicion))}} </td>
                <th>Lugar de nacimiento</th>
                <td>{{ ucwords(mb_strtolower($visita->ciudad_nac_autocomplete)) }} </td>
            </tr>

            <tr>
                <th>Fecha de nacimiento</th>
                <td>{{date("d-m-Y",strtotime($visita->fecha_nacimiento))}}</td>
                <th>Lugar de residencia</th>
                <td>{{ ucwords(mb_strtolower($visita->ciudad_res_autocomplete)) }}</td>
            </tr>

            <tr>
                <th>Estado civil</th>
                <td>{{ ucwords(mb_strtolower($visita->estado_civil_persona)) }}</td>
                <th>Edad</th>
                <td>{{\Carbon\Carbon::parse($visita->fecha_nacimiento)->age }} años </td>
            </tr>

            <tr>
                <th>Teléfono movil</th>
                <td>{{ $visita->telefono_movil }} </td>
                <th>Correo electrónico</th>
                <td>{{ ucwords(mb_strtolower($visita->email)) }} </td>
            </tr>

            <tr>
                <th>Nro. libreta militar</th>
                <td>{{ ((!empty($visita->numero_libreta))?$visita->numero_libreta:"N/A") }} </td>
                <th>Cat.Libreta militar</th>
                <td>{{ ((!empty($visita->clase_libreta_desc))?$visita->clase_libreta_desc:"N/A") }}</td>
            </tr>

            <tr>
                <th>Dirección de residencia</th>
                <td>{{ ucwords(mb_strtolower( ((!empty($visita->direccion))?$visita->direccion:"N/A"))) }} </td>
                <th>Barrio</th>
                <td>{{ ucwords(mb_strtolower($visita->barrio)) }} </td>
            </tr>

            <tr>
                <th>Estrato</th>
                <td>{{ ((!empty($visita->datos_estrato))?$visita->datos_estrato:"N/A") }} </td>
                <th>Pasaporte</th>
                <td>{{ ((!empty($visita->pasaporte))?$visita->pasaporte:"N/A") }} </td>
            </tr>

            <tr>
                <th>Visa</th>
                <td>{{ ((!empty($visita->visa))?$visita->visa:"N/A") }} </td>
                <th>Grupo sanguíneo y factor RH</th>
                <td>{{ $visita->grupo_sanguineo }} {{ $visita->rh }} </td>
            </tr>

             {{-- Si tiene licencia --}}
            <tr>
                <th>Nro. licencia de conducción</th>
                <td>{{ ((!empty($visita->nro_licencia))?$visita->nro_licencia:"N/A") }}</td>
                <th>Cat. licencia de conducción</th>
                <td>{{((!empty($visita->cat_licencia))?$visita->cat_licencia:"N/A") }}</td>
            </tr>

            <tr>
                <th>Fondo de pensiones</th>
                <td> {{ ((!empty($visita->afp))?$visita->afp:"N/A") }} </td>
                <th>EPS</th>
                <td>{{ ((!empty($visita->eps))?$visita->eps:"N/A") }}</td>
            </tr>

            <tr>
                <th>Hijos</th>
                <td>{{ ((!empty($visita->hijos))?$visita->hijos:"0") }} </td>
                <th></th>
                <td></td>
            </tr>

        </tbody>
    </table>
</section>

{{-- En caso de campos diferentes --}}
@if (count($db_diferentes) > 0)
    <section class="center">
        <section class="secciones-titulos-2">
            <p class="color fw-700" style="font-size: 12pt;">Novedades</p>
            {{-- <h2 style="color: #6F3795;">Observaciones</h2> --}}
            <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
        </section>

        <section class="">
            <table class="table table-striped novedades" >
                <thead>
                    <tr>
                        <th>Dato</th>
                        <th>Información suministrada por el candidato</th>
                        <th>Información verificada</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($db_diferentes as $dif)
                        <tr> 
                            <td>{{ $dif["campo"] }}</td>
                            <td>{{ $dif["valor_cand"] }}</td>
                            <td>{{ $dif["valor_adm"] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>

@endif
<br>