<section class="center" >
    <table class="table  table-striped" style="width: 60%; margin: 0 auto;">
        <thead>
            <section class="secciones-titulos-2">
                <h2 style="color: #6F3795;">DESCRIPCIÓN DE LA VIVIENDA</h2>
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>
            
        </thead>
        <tbody>
            <tr>
                <th>Tipo de vivienda</th>
                <td>{{ $visita->tipo_vivienda_descripcion}} </td>
                <th>Tenencia</th>
                <td>{{ $visita->tipo_propiedad_descripcion }}</td>
            </tr>

            <tr>
                <th>Servicios públicos</th>
                <td>{{$visita->viv_serv_pub}} </td>
                <th>Zona</th>
                <td>{{ ucwords(mb_strtolower($visita->sector_vivienda)) }} </td>
            </tr>

            <tr>
                <th>Estrato</th>
                <td>{{ $visita->estrato }} </td>
                <th>¿Tiene hipoteca?</th>
                <td>{{ ucwords(mb_strtolower($visita->viv_hipoteca)) }} </td>
            </tr>

            <tr>
                <th>Valor hipoteca</th>
                <td>{{ ((!empty($visita->viv_valor_hipoteca))?$visita->viv_valor_hipoteca:"N/A")}}</td>
                <th>Tiempo de residencia en la vivienda</th>
                <td>{{ ucwords(mb_strtolower($visita->viv_tmp_resd)) }}</td>
            </tr>

            <tr>
                <th>Vias de acceso</th>
                <td> {{ucwords(mb_strtolower($visita->viv_via_acc)) }} </td>
                <th>Alcantarillado</th>
                <td>{{ $visita->viv_alcantarillado }} </td>
            </tr>

            <tr>
                <th>Presentación externa</th>
                <td>{{ ucwords(mb_strtolower($visita->viv_prs_externa)) }} </td>
                <th>Presentación interna</th>
                <td>{{ ucwords(mb_strtolower($visita->viv_prs_interna)) }} </td>
            </tr>

            <tr>
                <th>Aseo y orden</th>
                <td>{{ ucwords(mb_strtolower($visita->viv_aseo_orden)) }}</td>
                <th>Ambiente del sector</th>
                <td>{{ ucwords(mb_strtolower($visita->viv_amb_sector)) }} </td>
            </tr>

        </tbody>
    </table>
    <br>
    {{-- subtitulo Concepto(Admin) --}}
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Concepto del evaluador:  </p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>

    <div class="m-auto" style="width: 95%;">
        <p class="text-justify color-sec">

            {{ $visita->viv_concepto }}
           
        </p>
    </div>
</section>

{{-- En caso de campos diferentes --}}
@if (count($viv_diferentes) > 0)
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
                    @foreach ($viv_diferentes as $key => $dif)
                        <tr> 
                            @if ($dif["campo"] == "viv_valor_hipoteca")
                                <td>{{ $dif["campo"] }}</td>
                                <td>{{ $dif["valor_cand"] }} COP</td>
                                <td>{{ $dif["valor_adm"] }} COP</td>
                            @else
                                <td>{{ $dif["campo"] }}</td>
                                <td>{{ $dif["valor_cand"] }}</td>
                                <td>{{ $dif["valor_adm"] }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </section>

@endif
<br>