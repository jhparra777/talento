<section class="secciones-titulos-2 center">
    <h2 style="color: #6F3795;">INFORMACIÓN ECONÓMICA</h2>
    <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
</section>

<section class="center">
    {{-- Subtitulo ingreso --}}
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Ingresos</p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>

    {{-- tabla sub-seccion ingreso --}}
    <table class="table table-striped" style="width: 60%; margin: 0 auto;" >
        <thead>
            <tr>
                <th>Nombre de quien aporta</th>
                <th>Ingreso personal</th>
                <th>Valor aporte</th>
            </tr>     
        </thead>
        <tbody>
            @if(count($ingresos) > 0)
                @foreach($ingresos as $ing)
                    <tr>
                        <td>{{ $ing->ing_egr_nombre }}</td>
                        <td>{{ $ing->ing_egr_ingreso }} COP</td>
                        <td>{{ $ing->ing_egr_aporte }} COP</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    <th>{{ $visita->total_ingresos }} COP</th>
                    <th>{{ $visita->ing_egr_aportes_total }} COP</th>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Subtitulo egresos --}}
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Egresos</p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>

    {{-- tabla sub-seccion egreso --}}
    <table class="table table-striped" style="width: 60%; margin: 0 auto;">
        <thead>
            <tr>
                <th>Motivo</th>
                <th>Valor</th>
            </tr>     
        </thead>
        <tbody>
            <tr>
                <td>Servicios públicos</td>
                <td>{{ $visita->ing_egr_servicios}} COP</td>
            </tr>

            <tr>
                <td>Alimentación</td>
                <td>{{ $visita->ing_egr_alimentacion}} COP</td>
            </tr>

            <tr>
                <td>Jardín</td>
                <td>{{ $visita->ing_egr_jardin}} COP</td>
            </tr>

            <tr>
                <td>Universidad</td>
                <td>{{ $visita->ing_egr_universidad}} COP</td>
            </tr>

            <tr>
                <td>Otros</td>
                <td>{{ $visita->ing_egr_otros}} COP</td>
            </tr>

            <tr>
                <th>Total</th>
                <th>{{ $visita->total_egresos }} COP</th>
            </tr>
        </tbody>
    </table>

    {{-- Subtitulo centrales de riesgo --}}
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Reporte centrales de riesgo</p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>
    @if(count($reportes) > 0)
        {{-- tabla sub-seccion centrales de riesgo --}}
        <table class="table table-striped" style="width: 60%; margin: 0 auto;">
            <thead>
                <tr>
                    <th>Entidad</th>
                    <th>¿Hace cuanto está reportado?</th>
                    <th>¿Cuál es el valor reportado?</th>
                </tr>     
            </thead>
            <tbody>
                @foreach($reportes as $re)
                    <tr>
                        <td>{{ $bancos[$re->banco]}}</td>
                        <td>{{ $re->hace_cuanto_reportado }}</td>
                        <td>{{ $re->valor_reportado }} COP</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="ml-1">
            <p>No posee</p>
        </div>
    @endif

    {{-- Subtitulo creditos --}}
    <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Reporte de crédito</p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>
    @if(count($creditos) > 0)
        {{-- tabla sub-seccion creditos --}}
        <table class="table table-striped" style="width: 60%; margin: 0 auto;" >
            <thead>
                <tr>
                    <th>Entidad</th>
                    <th>¿Hace cuánto tiene el crédito?</th>
                    <th>¿Cuál es el valor adeudado?</th>
                </tr>     
            </thead>
            <tbody>
                @foreach($creditos as $cre)
                    <tr>
                        <td>{{ $bancos[$cre->banco] }}</td>
                        <td>{{ $cre->hace_cuanto_reportado_credito }}</td>
                        <td>{{ $cre->valor_reportado_credito }} COP</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="ml-1">
            <p>No posee</p>
        </div>
    @endif

    {{-- subtitulo Concepto(Admin) --}}
    {{-- <div class="ml-1">
        <p class="color fw-700" style="font-size: 12pt;">Concepto del evaluador:  </p>
        <hr align="left" class="divider-25" style="margin-top: -.6rem;">
    </div>

    <div class="m-auto" style="width: 95%;">
        <p class="text-justify color-sec">

            {{ $visita->ing_egr_concepto }}
           
        </p>
    </div> --}}
</section>

{{-- En caso de campos diferentes --}}
@if (count($egresos_diferentes) > 0 || $ingresos_diferentes == false || $reporte_central_diferentes == false || $creditos_bancarios_diferentes == false)
    <section class="center">
        <section class="secciones-titulos-2">
            <p class="color fw-700" style="font-size: 12pt;">Novedades</p>
            {{-- <h2 style="color: #6F3795;">Observaciones</h2> --}}
            <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
        </section>

        {{-- Seccion dinamica de ingresos --}}
        @if ($ingresos_diferentes == false)
            <section class="row col-md-12" style="margin:0; margin-bottom: 30px;">

                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">Ingresos:  </p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>

                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información suministrada por el candidato</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        <?php
                            $ingresos_cand = (array)json_decode($visita->visita_candidato->ing_egr_familiar);
                        ?>

                        @foreach ($ingresos_cand as $ing)
                            <ul>
                                @if (!empty($ing->ing_egr_nombre))
                                    <li>
                                        Nombre de quien aporta: {{ $ing->ing_egr_nombre }}
                                    </li>                                    
                                @endif

                                @if (!empty($ing->ing_egr_ingreso))
                                    <li>
                                        Ingreso personal: {{ $ing->ing_egr_ingreso }} COP
                                    </li>                                    
                                @endif

                                @if (!empty($ing->ing_egr_aporte))
                                    <li>
                                        Valor aporte: {{ $ing->ing_egr_aporte }} COP
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                        <ul>
                            <li>
                                Total ingreso: {{ $visita->visita_candidato->total_ingresos }} COP
                            </li>
                            <li>
                                Total aporte: {{ $visita->visita_candidato->ing_egr_aportes_total }} COP
                            </li>
                        </ul>
                    </section>
                </div>
        
                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información verificada</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">
                        
                        @foreach ($ingresos as $ing)
                            <ul>
                                @if (!empty($ing->ing_egr_nombre))
                                    <li>
                                        Nombre de quien aporta: {{ $ing->ing_egr_nombre }}
                                    </li>                                    
                                @endif

                                @if (!empty($ing->ing_egr_ingreso))
                                    <li>
                                        Ingreso personal: {{ $ing->ing_egr_ingreso }} COP
                                    </li>                                    
                                @endif

                                @if (!empty($ing->ing_egr_aporte))
                                    <li>
                                        Valor aporte: {{ $ing->ing_egr_aporte }} COP
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                        <ul>
                            <li>
                                Total ingreso: {{ $visita->total_ingresos }} COP
                            </li>
                            <li>
                                Total aporte: {{ $visita->ing_egr_aportes_total }} COP
                            </li>
                        </ul>
                    </section>
                </div>
        
            </section>
        @endif 
        
        {{-- Seccion campos abiertos en tabla --}}
        @if (count($egresos_diferentes) > 0)
            <section class="">

                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">Egresos:  </p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>

                <table class="table table-striped novedades" >
                    <thead>
                        <tr>
                            <th>Dato</th>
                            <th>Información suministrada por el candidato</th>
                            <th>Información verificada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($egresos_diferentes as $dif)
                            <tr> 
                                <td>{{ $dif["campo"] }}</td>
                                <td>{{ $dif["valor_cand"] }} COP</td>
                                <td>{{ $dif["valor_adm"] }} COP</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
        @endif

        {{-- Seccion campos dinamicos reporte central de riesgo --}}
        @if ($reporte_central_diferentes == false)
            <section class="row col-md-12" style="margin:0; margin-bottom: 30px;">

                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">Reporte central de riesgo:  </p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>

                <div class="col-md-6" style="max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información suministrada por el candidato</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        <?php
                            $reporte_central_cand = (array)json_decode($visita->visita_candidato->reportes_central);
                        ?>

                        @foreach ($reporte_central_cand as $re)
                            <ul>
                                @if (!empty($re->banco))
                                    <li>
                                        Entidad: {{ $bancos[$re->banco]}}
                                    </li>                                    
                                @endif

                                @if (!empty($re->hace_cuanto_reportado))
                                    <li>
                                        ¿Hace cuanto está reportado?: {{ $re->hace_cuanto_reportado }}
                                    </li>                                    
                                @endif

                                @if (!empty($re->valor_reportado))
                                    <li>
                                        ¿Cuál es el valor reportado?: {{ $re->valor_reportado }} COP
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

                        @foreach ($reportes as $re)
                            <ul>
                                @if (!empty($re->banco))
                                    <li>
                                        Entidad: {{ $bancos[$re->banco]}}
                                    </li>                                    
                                @endif

                                @if (!empty($re->hace_cuanto_reportado))
                                    <li>
                                        ¿Hace cuanto está reportado?: {{ $re->hace_cuanto_reportado }}
                                    </li>                                    
                                @endif

                                @if (!empty($re->valor_reportado))
                                    <li>
                                        ¿Cuál es el valor reportado?: {{ $re->valor_reportado }} COP
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
            </section>
        @endif 

        {{-- Seccion campos dinamicos creditos bancarios --}}
        @if ($creditos_bancarios_diferentes == false)
            <section class="row col-md-12" style="margin-bottom: 30px;">

                <div class="ml-1">
                    <p class="color fw-700" style="font-size: 12pt;">Reporte creditos bancarios:  </p>
                    <hr align="left" class="divider-25" style="margin-top: -.6rem;">
                </div>

                <div class="col-md-6" style="margin:0; max-width: 50%;float: left;">
                    <section class="secciones-titulos-2">
                        <p class="color fw-700" style="font-size: 12pt;">Información suministrada por el candidato</p>
                        <hr align="left" class="divider-hd" style="margin-top: -.5rem;">

                        <?php
                            $creditos_bancarios_cand = (array)json_decode($visita->visita_candidato->creditos_bancarios);
                        ?>

                        @foreach ($creditos_bancarios_cand as $cre)
                            <ul>
                                @if (!empty($cre->banco))
                                    <li>
                                        Entidad: {{ $bancos[$cre->banco] }}
                                    </li>                                    
                                @endif

                                @if (!empty($cre->hace_cuanto_reportado_credito))
                                    <li>
                                        ¿Hace cuánto tiene el crédito?: {{ $cre->hace_cuanto_reportado_credito }}
                                    </li>                                    
                                @endif

                                @if (!empty($cre->valor_reportado_credito))
                                    <li>
                                        ¿Cuál es el valor reportado?: {{ $cre->valor_reportado_credito }} COP
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

                        @foreach ($creditos as $cre)
                            <ul>
                                @if (!empty($cre->banco))
                                    <li>
                                        Entidad: {{ $bancos[$cre->banco] }}
                                    </li>                                    
                                @endif

                                @if (!empty($cre->hace_cuanto_reportado_credito))
                                    <li>
                                        ¿Hace cuánto tiene el crédito?: {{ $cre->hace_cuanto_reportado_credito }}
                                    </li>                                    
                                @endif

                                @if (!empty($cre->valor_reportado_credito))
                                    <li>
                                        ¿Cuál es el valor reportado?: {{ $cre->valor_reportado_credito }} COP
                                    </li>                                    
                                @endif
                            </ul>
                        @endforeach
                    </section>
                </div>
        
            </section>
        @endif 
    </section>

@endif
<br>