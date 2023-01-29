<section class="secciones-titulos-2 center">
    <h2 style="color: #6F3795;">ESTADO DE SALUD</h2>
    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
</section>

<section class="center">
    {{-- Subtitulo lesiones --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Posee alguna lesión permanente? {{ (!empty($visita->salud_lesiones_permanente)? 'Sí' : '' ) }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                            
                            {{ (!empty($visita->salud_lesiones_permanente)? $visita->salud_lesiones_permanente : 'No' ) }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- Subtitulo psiquiátricos --}}

    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Ha tenido problemas psiquiátricos o psicológicos? {{ (!empty($visita->salud_prob_psiquiatricos)? 'Sí' : '' ) }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">

                            {{ (!empty($visita->salud_prob_psiquiatricos)? $visita->salud_prob_psiquiatricos : 'No' ) }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- Subtitulo tratamiento --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Recibe tratamiento médico y/o medicamentos permanentes? {{ (!empty($visita->salud_tratamiento_perma)? 'Sí' : '' ) }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">

                            {{ (!empty($visita->salud_tratamiento_perma)? $visita->salud_tratamiento_perma : 'No' ) }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- Subtitulo hospitalizado --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Ha estado hospitalizado? {{ (!empty($visita->salud_hospitalizado)? 'Sí' : '' ) }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">

                            {{ (!empty($visita->salud_hospitalizado)? $visita->salud_hospitalizado : 'No' ) }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- subtitulo Concepto(Admin) --}}
    {{-- <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Concepto del evaluador:  </p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>

    <div class="m-auto" style="width: 95%;">
        <p class="text-justify color-sec">

            {{ $visita->salud_concepto }}
        
        </p>
    </div> --}}

</section>

{{-- En caso de campos diferentes --}}
@if (count($salud_diferentes) > 0)
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
                    @foreach ($salud_diferentes as $dif)
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