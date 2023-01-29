<section class="secciones-titulos-2 center">
    <h2 style="color: #6F3795;">GRUPO FAMILIAR</h2>
    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
</section>

<section class="center">
    <table class="table table-striped" >
        <thead>
            <tr>
                <th>Nombres y apellidos</th>
                <th>Parentesco</th>
                <th>¿Reside con esa persona?</th>
                <th>Estado civil</th>
                <th>Profesión</th>
                <th>Edad</th>
                <th>Telefóno</th>
            </tr>
            
        </thead>
        <tbody>
            @if(count($familiares) > 0)
                @foreach($familiares as $fam)
                    <tr>
                        <td>{{ $fam->nombres }}</td>
                        <td>{{ $parentescos[$fam->parentesco_id] }}</td>
                        <td>{{ $fam->convive_con_el }}</td>
                        <td>{{ $estadoCivil[$fam->estado_civil_id] }}</td>
                        <td>{{ $fam->profesion_id }}</td>
                        <td>{{ $fam->edad_fam }} años</td>
                        <td>{{ $fam->numero_contacto_familiar }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{-- subtitulo ¿Cómo es la relación con su familia? --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">¿Cómo es la relación con su familia?</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ $visita->fam_relacion }}
                           
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- subtitulo Enfermedades en la familia --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">Enfermedades en la familia: </p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ $visita->fam_enfermedades }}
                           
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- subtitulo Actividades en el tiempo libre --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">Actividades en el tiempo libre: </p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ $visita->fam_act_tmp_lbre }}
                        
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- subtitulo Situaciones difíciles en la familia --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">Situaciones difíciles en la familia:  </p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ $visita->fam_situaciones_dificiles }}
                           
                        </p>
                    </div>
                </li>
            </ul>
        </li>
    </ul>

    {{-- subtitulo Proyectos a mediano y largo plazo --}}
    <ul>
        <li>
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">Proyectos a mediano y largo plazo:  </p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>
            <ul>
                <li>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                            {{ $visita->metas_corto_plazo }}
                           
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

            {{ $visita->fam_concepto }}
           
        </p>
    </div> --}}
</section>

{{-- En caso de campos diferentes --}}
@if (count($fam_diferentes) > 0 || $familiares_diferentes== false)
    <section class="center">
        <section class="secciones-titulos-2">
            <p class="color fw-700" style="font-size: 12pt;">Novedades</p>
            {{-- <h2 style="color: #6F3795;">Observaciones</h2> --}}
            <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
        </section>

        @if ($familiares_diferentes == false)
            <div class="row col-md-12" style="margin:0;">

                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información suministrada por el candidato</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        <?php
                            $familiares_ = (array)json_decode($visita->visita_candidato->familiares);
                        ?>

                        @foreach ($familiares_ as $fam)
                            <ul>
                                @if (!empty($fam->nombres))
                                    <li>
                                        Nombres: {{ $fam->nombres }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->parentesco_id))
                                    <li>
                                        Parentesco: {{ $parentescos[$fam->parentesco_id] }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->convive_con_el))
                                    <li>
                                        Conviven: {{ $fam->convive_con_el }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->estado_civil_id))
                                    <li>
                                        Estado civil: {{ $estadoCivil[$fam->estado_civil_id] }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->profesion_id))
                                    <li>
                                        Profesión: {{ $fam->profesion_id }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->edad_fam))
                                    <li>
                                        Edad: {{ $fam->edad_fam }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->numero_contacto_familiar))
                                    <li>
                                        Telefóno: {{ $fam->numero_contacto_familiar }}
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información verificada</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
                        
                        @foreach ($familiares as $fam)
                            <ul>
                                @if (!empty($fam->nombres))
                                    <li>
                                        Nombres: {{ $fam->nombres }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->parentesco_id))
                                    <li>
                                        Parentesco: {{ $parentescos[$fam->parentesco_id] }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->convive_con_el))
                                    <li>
                                        Conviven: {{ $fam->convive_con_el }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->estado_civil_id))
                                    <li>
                                        Estado civil: {{ $estadoCivil[$fam->estado_civil_id] }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->profesion_id))
                                    <li>
                                        Profesión: {{ $fam->profesion_id }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->edad_fam))
                                    <li>
                                        Edad: {{ $fam->edad_fam }}
                                    </li>                                    
                                @endif

                                @if (!empty($fam->numero_contacto_familiar))
                                    <li>
                                        Telefóno: {{ $fam->numero_contacto_familiar }}
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
            </div>
        @endif 
        
        {{-- Seccion de diferencias de campos abiertos --}}
        @if (count($fam_diferentes) > 0)
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
                        @foreach ($fam_diferentes as $dif)
                            <tr> 
                                <td>{{ $dif["campo"] }}</td>
                                <td>{{ $dif["valor_cand"] }}</td>
                                <td>{{ $dif["valor_adm"] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endif

    </section>

@endif
<br>