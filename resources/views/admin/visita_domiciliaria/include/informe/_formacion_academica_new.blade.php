@if (count($estudios) > 0)
    <section class="secciones-titulos-2 center">
        <h2 style="color: #6F3795;">INFORMACIÓN ACADÉMICA</h2>
        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
    </section>

    <section class="center">
        <?php
            $cantidad_formacion = 1;
        ?>
        {{-- Subtitulo estudios --}}
        @if(count($estudios) > 0)
            @foreach($estudios as $es)
                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">{{ $es->institucion }}</p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>

                {{-- tabla Seccion estudios --}}
                <table class="table table-striped" style="width: 80%; margin: 0 auto;">
                    <tbody>
                        <tr>
                            <th class="alinea">¿Estudio actual?</th>
                            <td class="alinea">{{ (($es->estudio_actual == 0) ? "No" : "Sí") }}</td>
                            <th class="alinea">Titulo obtenido</th>
                            <td class="alinea">{{ $es->titulo_obtenido  }}</td>
                        </tr>

                        <tr>                  
                            <th class="alinea">Ciudad</th>
                            <td class="alinea">{{ $ciudades_general[$es->ciudad_estudio] }}</td>
                            <th class="alinea">Nivel de estudios</th>
                            <td class="alinea">{{ $nivelEstudio[$es->nivel_estudio_id] }}</td>
                        </tr>

                        <tr>     
                            <th class="alinea">Períodos cursados</th>
                            <td class="alinea">{{ $es->semestres_cursados }}</td>
                            <th class="alinea">Periodicidad</th>
                            <td class="alinea">{{ $periodicidad[$es->periodicidad] }}</td>
                        </tr>

                        <tr> 
                            <th class="alinea">Fecha finalización</th>
                            <td class="alinea">{{ ((!empty($es->fecha_finalizacion))?$es->fecha_finalizacion:"N/A") }}</td>
                            <th class="alinea">Teléfono institución</th>
                            <td class="alinea">{{ ((!empty($es->telefono))?$es->telefono:"N/A")  }}</td>
                        </tr>
                    </tbody>
                </table>

                @if (!empty($es->concepto))
                    <div class="ml-1">
                        <p class="color fw-700" style="font-size: 12pt;">Concepto</p>
                        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                    </div>
                    <div class="m-auto" style="width: 95%;">
                        <p class="text-justify color-sec">
                
                             {{ $es->concepto }}
                        
                        </p>
                    </div>
                @endif

                <?php
                    $cantidad_formacion ++;
                ?> 
            @endforeach
        @endif
    </section>
    
    {{-- En caso de campos diferentes --}}
    @if ($formacion_academica_diferentes == false)
        <section class="center">
            <section class="secciones-titulos-2">
                <p class="color fw-700" style="font-size: 12pt;">Novedades</p>
                {{-- <h2 style="color: #6F3795;">Observaciones</h2> --}}
                <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
            </section>

            <div class="row col-md-12" style="margin:0;">

                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información suministrada por el candidato</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        <?php
                            $formacion_academica = (array)json_decode($visita->visita_candidato->formacion_academica);
                        ?>

                        @foreach ($formacion_academica as $es)
                            <ul>
                                {{-- @if (!empty($es->estudio_actual)) --}}
                                    <li>
                                        estudio actual: {{ (($es->estudio_actual == "0") ? "No" : "Sí") }}
                                    </li>                                    
                                {{-- @endif --}}

                                @if (!empty($es->institucion))
                                    <li>
                                        instituto: {{ $es->institucion }}
                                    </li>                                    
                                @endif

                                @if (!empty($es->titulo_obtenido))
                                    <li>
                                        Titulo obtenido: {{ $es->titulo_obtenido }}
                                    </li>                                    
                                @endif

                                @if (!empty($es->ciudad_estudio))
                                    <li>
                                        Ciudad: {{ $ciudades_general[$es->ciudad_estudio] }}
                                    </li>                                    
                                @endif

                                @if (!empty($es->nivel_estudio_id))
                                    <li>
                                        Nivel de estudios: {{ $nivelEstudio[$es->nivel_estudio_id] }}
                                    </li>                                    
                                @endif

                                @if (!empty($es->semestres_cursados))
                                    <li>
                                        Períodos cursados: {{ $es->semestres_cursados }}
                                    </li>                                    
                                @endif

                                @if (!empty($es->periodicidad))
                                    <li>
                                        Periodicidad: {{ $periodicidad[$es->periodicidad] }}
                                    </li>                                    
                                @endif

                                @if (!empty($es->fecha_finalizacion))
                                    <li>
                                        Fecha finalización: {{ ((!empty($es->fecha_finalizacion))?$es->fecha_finalizacion:"N/A") }}
                                    </li>                                    
                                @endif

                                @if (!empty($es->telefono))
                                    <li>
                                        Teléfono institución: {{ ((!empty($es->telefono))?$es->telefono:"N/A")  }}
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
                        
                            @foreach ($estudios as $es)
                                <ul>
                                    {{-- @if (!empty($es->estudio_actual)) --}}
                                        <li>
                                            estudio actual: {{ (($es->estudio_actual == "0") ? "No" : "Sí") }}
                                        </li>                                    
                                    {{-- @endif --}}

                                    @if (!empty($es->institucion))
                                        <li>
                                            instituto: {{ $es->institucion }}
                                        </li>                                    
                                    @endif

                                    @if (!empty($es->titulo_obtenido))
                                        <li>
                                            Titulo obtenido: {{ $es->titulo_obtenido }}
                                        </li>                                    
                                    @endif

                                    @if (!empty($es->ciudad_estudio))
                                        <li>
                                            Ciudad: {{ $ciudades_general[$es->ciudad_estudio] }}
                                        </li>                                    
                                    @endif

                                    @if (!empty($es->nivel_estudio_id))
                                        <li>
                                            Nivel de estudios: {{ $nivelEstudio[$es->nivel_estudio_id] }}
                                        </li>                                    
                                    @endif

                                    @if (!empty($es->semestres_cursados))
                                        <li>
                                            Períodos cursados: {{ $es->semestres_cursados }}
                                        </li>                                    
                                    @endif

                                    @if (!empty($es->periodicidad))
                                        <li>
                                            Periodicidad: {{ $periodicidad[$es->periodicidad] }}
                                        </li>                                    
                                    @endif

                                    @if (!empty($es->fecha_finalizacion))
                                        <li>
                                            Fecha finalización: {{ ((!empty($es->fecha_finalizacion))?$es->fecha_finalizacion:"N/A") }}
                                        </li>                                    
                                    @endif

                                    @if (!empty($es->telefono))
                                        <li>
                                            Teléfono institución: {{ ((!empty($es->telefono))?$es->telefono:"N/A")  }}
                                        </li>                                    
                                    @endif
                                </ul>
                            @endforeach
                    </section>
                </div>
        
            </div>
        </section>
    @endif
@endif
<br>