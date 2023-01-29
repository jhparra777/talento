<section class="secciones-titulos-2 center">
    <h2 style="color: #6F3795;">INFORMACIÓN LABORAL</h2>
    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
</section>
@if (count($experiencias) > 0)
    <section class="center">
        <?php
            $cantidad_laboral = 1;
        ?>
        {{-- Subtitulo estudios --}}
        @foreach($experiencias as $exp)
            <div class="ml-1">
                <p class="color fw-700" style="font-size: 12pt;">{{ $exp->nombre_empresa }}</p>
                <hr align="left" class="divider-25" style="margin-top: -.6rem;">
            </div>

            {{-- tabla Seccion estudios --}}
            <table class="table table-striped" style="width: 80%; margin: 0 auto;">
                <tbody>
                    <tr>
                        <th class="alinea">¿Trabajo actual?</th>
                        <td class="alinea">{{ (($exp->empleo_actual == "2") ? "No" : "Sí") }}</td>
                        <th class="alinea">Cargo</th>
                        <td class="alinea">{{ $exp->cargo_especifico  }}</td>
                    </tr>

                    <tr>             
                        <th class="alinea">Fecha ingreso</th>
                        <td class="alinea">{{ ((!empty($exp->fecha_inicio))?$exp->fecha_inicio:"N/A") }}</td>
                        <th class="alinea">Fecha retiro</th>
                        <td class="alinea">{{ ((!empty($exp->fecha_final))?$exp->fecha_final:"N/A")  }}</td>
                    </tr>

                    <tr> 
                        <th class="alinea">Motivo del retiro</th>
                        <td class="alinea">{{ ((!empty($exp->motivo_retiro))? $motivoRetiro[$exp->motivo_retiro]:"N/A") }}</td>
                        <th class="alinea">Teléfono empresa</th>
                        <td class="alinea">{{ ((!empty($exp->movil_jefe))?$exp->movil_jefe:"N/A")  }}</td>
                    </tr>
                </tbody>
            </table>

            @if (!empty($exp->concepto))
                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">Concepto</p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>
                <div class="m-auto" style="width: 95%;">
                    <p class="text-justify color-sec">
            
                        {{ $exp->concepto }}
                    
                    </p>
                </div>
            @endif
            <?php
                $cantidad_laboral ++;
            ?> 
        @endforeach    
    </section> 
    <br>
    {{-- subtitulo Concepto(Admin) --}}
    <div class="secciones-titulos-2 center">
        <p class="color fw-700" style="font-size: 12pt;">Concepto del evaluador:  </p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>

    <div class="secciones-titulos-2 center" >
        <p class="text-justify color-sec">

            {{ $visita->acad_lab_concepto }}
           
        </p>
    </div>

    {{-- En caso de campos diferentes --}}
    @if ($formacion_laboral_diferentes == false)
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
                            $formacion_laboral = (array)json_decode($visita->visita_candidato->experiencia_laboral);
                        ?>

                        @foreach ($formacion_laboral as $exp)
                            <ul>
                                @if (!empty($exp->empleo_actual))
                                    <li>
                                        Trabajo actual: {{ (($exp->empleo_actual == "2") ? "No" : "Sí") }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->nombre_empresa))
                                    <li>
                                        Empresa: {{ $exp->nombre_empresa  }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->cargo_especifico))
                                    <li>
                                        cargo: {{ $exp->cargo_especifico  }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->fecha_inicio))
                                    <li>
                                        Fecha ingreso: {{ ((!empty($exp->fecha_inicio))?$exp->fecha_inicio:"N/A") }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->fecha_final))
                                    <li>
                                        Fecha retiro: {{ ((!empty($exp->fecha_final))?$exp->fecha_final:"N/A")  }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->motivo_retiro))
                                    <li>
                                        Motivo del retiro: {{ ((!empty($exp->motivo_retiro))? $motivoRetiro[$exp->motivo_retiro]:"N/A") }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->movil_jefe))
                                    <li>
                                        Teléfono empresa: {{ ((!empty($exp->movil_jefe))?$exp->movil_jefe:"N/A")  }}
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
                        
                        @foreach ($experiencias as $exp)
                            <ul>
                                @if (!empty($exp->empleo_actual))
                                    <li>
                                        Trabajo actual: {{ (($exp->empleo_actual == "2") ? "No" : "Sí") }}
                                    </li>                                    
                                @endif
                                
                                @if (!empty($exp->nombre_empresa))
                                    <li>
                                        Empresa: {{ $exp->nombre_empresa  }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->cargo_especifico))
                                    <li>
                                        cargo: {{ $exp->cargo_especifico  }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->fecha_inicio))
                                    <li>
                                        Fecha ingreso: {{ ((!empty($exp->fecha_inicio))?$exp->fecha_inicio:"N/A") }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->fecha_final))
                                    <li>
                                        Fecha retiro: {{ ((!empty($exp->fecha_final))?$exp->fecha_final:"N/A")  }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->motivo_retiro))
                                    <li>
                                        Motivo del retiro: {{ ((!empty($exp->motivo_retiro))? $motivoRetiro[$exp->motivo_retiro]:"N/A") }}
                                    </li>                                    
                                @endif

                                @if (!empty($exp->movil_jefe))
                                    <li>
                                        Teléfono empresa: {{ ((!empty($exp->movil_jefe))?$exp->movil_jefe:"N/A")  }}
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
            </div>
        </section>
    @endif
@else
    <section class="secciones-titulos-2 center">
        <p>No posee<p>
    </section>
@endif
<br>