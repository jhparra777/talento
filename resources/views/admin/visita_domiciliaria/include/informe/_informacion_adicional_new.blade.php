<section class="secciones-titulos-2 center">
    <h2 style="color: #6F3795;">INFORMACIÓN ADICIONAL</h2>
    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
</section>

<section class="center">
    {{-- Subtitulo info_demandas --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Posee actualmente demandas de alimentos y/o embargos? {{ (!empty($visita->info_demandas)? 'Sí' : '' ) }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ (!empty($visita->info_demandas)? $visita->info_demandas : 'No' ) }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- Subtitulo info_antecedentes --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Algún miembro de su familia presenta antecedentes penales? {{ (!empty($visita->info_antecedentes)? 'Sí' : '' ) }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ (!empty($visita->info_antecedentes)? $visita->info_antecedentes : 'No' ) }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- Subtitulo info_sustancias --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Ha consumido sustancias psicoactivas? {{ (!empty($visita->info_sustancias)? 'Sí' : '' ) }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ (!empty($visita->info_sustancias)? $visita->info_sustancias : 'No' ) }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- Subtitulo info_ilicitas --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Ha sabido de actividades ilícitas en su entorno social o laboral? {{ (!empty($visita->info_ilicitas)? 'Sí' : '' ) }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ (!empty($visita->info_ilicitas)? $visita->info_ilicitas : 'No' ) }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- subtitulo Concepto(Admin) --}}
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Concepto del evaluador:  </p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>

    <div class="m-auto" style="width: 95%;">
        <p class="text-justify color-sec">

            {{ $visita->info_concepto }}
        
        </p>
    </div>

</section>

{{-- En caso de campos diferentes --}}
@if (count($info_adic_diferentes) > 0)
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
                    @foreach ($info_adic_diferentes as $dif)
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