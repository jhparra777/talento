{{-- se verifica si es visita periodica = 1 para mostrar seccion --}}
@if ($visita->clase_visita_id == 1)
    <section class="secciones-titulos-2 center">
        <h2 style="color: #6F3795;">VISITA PERIÓDICA</h2>
        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
    </section>

    <section class="center">
        {{-- Subtitulo vp_trabaja --}}
        @if(!empty($visita->vp_trabaja))
            <ul>
                <li>
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">¿Hace cuánto tiempo trabaja en la empresa?</p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <ul>
                        <li>
                            <div class="m-auto" style="width: 95%;">
                                <p class="text-justify color-sec">
                        
                                    {{ $visita->vp_trabaja }}
                                
                                </p>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        @endif

        {{-- Subtitulo vp_desempeño --}}
        @if(!empty($visita->vp_desempeño))
            <ul>
                <li>
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">¿Cómo cree que es su desempeño laboral en la empresa? </p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <ul>
                        <li>
                            <div class="m-auto" style="width: 95%;">
                                <p class="text-justify color-sec">
                        
                                    {{ $visita->vp_desempeño }}
                                
                                </p>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        @endif

        {{-- Subtitulo vp_fraude --}}
        <ul>
            <li>
                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">¿Alguna vez le han propuesto hacer algún fraude  en la compañia? {{ (!empty($visita->vp_fraude)? 'Sí' : '' ) }}</p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>
                <ul>
                    <li>
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                    
                                {{ (!empty($visita->vp_fraude)? $visita->vp_fraude : 'No' ) }}
                            
                            </p>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>

        {{-- Subtitulo vp_llamado --}}
        <ul>
            <li>
                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">¿Ha tenido algún llamado de atención en la empresa? {{ (!empty($visita->vp_llamado)? 'Sí' : '' ) }}</p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>
                <ul>
                    <li>
                        <div class="m-auto" style="width: 95%;">
                            <p class="text-justify color-sec">
                    
                                {{ (!empty($visita->vp_llamado)? $visita->vp_llamado : 'No' ) }}
                            
                            </p>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>

    </section> 

    {{-- En caso de campos diferentes --}}
    @if (count($visita_periodica_diferentes) > 0)
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
                        @foreach ($visita_periodica_diferentes as $dif)
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
@endif


<br>