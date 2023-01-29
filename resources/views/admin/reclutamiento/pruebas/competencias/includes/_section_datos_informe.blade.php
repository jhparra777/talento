<div class="col-md-12">
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Detalles informe
                    </a>
                </h4>
            </div>

            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="col-md-6 text-center">
                        {{-- Ajuste al perfil --}}
                        <div class="col-md-12 text-center">
                            <p style="font-size: 2rem;">Ajuste del <br> candidato al perfil</p>

                            <div class="m-auto" style="border-radius: 100%;
                                background-color: #6F3795;
                                width: 90px;
                                height: 90px;
                                color: white;
                                display: flex;
                                justify-content: center;
                                align-items: center;">
                                <p style="font-size: 4rem; margin-top: .8rem;">
                                    <b>{{ round($candidato_competencia->ajuste_global) }}%</b>
                                </p>
                            </div>
                        </div>

                        {{-- Desfase --}}
                        <div class="col-md-12 text-center mt-2">
                        <!--<p style="font-size: 2rem;">Factor de desfase</p>
                            

                            <p style="font-size: 2.5rem; margin-left: 2.5rem;">
                                <b>{{ round($candidato_competencia->factor_desfase_global) }}%</b>
                                
                                @if($candidato_competencia->factor_desfase_global < 0)
                                    <img style="margin-left: -1.5rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="80">
                                @else
                                    <img style="margin-left: -1.5rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="80">
                                @endif
                            </p> -->
                        </div>
                    </div> 

                    {{-- Imagen circular --}}
                    <div class="col-md-6 text-center">
                        @if($candidato_competencia->ajuste_global < 25)
                            <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-01.png" width="400">

                        @elseif($candidato_competencia->ajuste_global >= 25 && $candidato_competencia->ajuste_global <= 50)
                            <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-00.png" width="400">

                        @elseif($candidato_competencia->ajuste_global >= 50 && $candidato_competencia->ajuste_global <= 75)

                            @if($candidato_competencia->ajuste_global > 50 && $candidato_competencia->ajuste_global < 55)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-02.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 55 && $candidato_competencia->ajuste_global < 58)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-03.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 58 && $candidato_competencia->ajuste_global < 64)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-04.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 64 && $candidato_competencia->ajuste_global < 68)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-05.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 68 && $candidato_competencia->ajuste_global < 72)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-06.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 72 && $candidato_competencia->ajuste_global < 75)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-07.png" width="400">
                            @endif

                        @elseif($candidato_competencia->ajuste_global >= 75 && $candidato_competencia->ajuste_global <= 100)

                            @if($candidato_competencia->ajuste_global > 75 && $candidato_competencia->ajuste_global < 78)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-08.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 78 && $candidato_competencia->ajuste_global < 80)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-09.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 80 && $candidato_competencia->ajuste_global < 84)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-10.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 84 && $candidato_competencia->ajuste_global < 94)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-11.png" width="400">

                            @elseif($candidato_competencia->ajuste_global > 94 && $candidato_competencia->ajuste_global <= 100)
                                <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencia-barra-circular-12.png" width="400">
                            @endif
                        @endif
                    </div>

                    {{-- Referencia --}}
                    <div class="col-md-12 text-center">
                        <img src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-referencia-puntaje.png" width="400" style="margin-bottom: -6rem; margin-top: -5rem;">
                    </div>

                    {{-- Competencias sobresalientes y base --}}
                    <div class="col-md-6">
                        <h3 style="color: #6F3795;">COMPETENCIAS <br> SOBRESALIENTES</h3>
                        <hr align="left" class="divider-90">
                    </div>

                    <div class="col-md-6">
                        <h3 style="color: #6F3795;">COMPETENCIAS <br> BASE</h3>
                        <hr align="left" class="divider-90">
                    </div>

                    {{-- sobresaliente --}}
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <p class="color fw-700" style="font-size: 14pt;">{{ $sobresalientesDesc[$sobresalienteA[0]] }}</p>
                        </div>

                        <div class="col-md-10 mb-1">
                            <p class="text-justify">
                                {{ $sobresalientesDefinicion[$sobresalienteA[0]] }}
                            </p>
                        </div>

                        <div class="col-md-12 mb-1" style="display: flex;">
                            @if($sobresalienteA[0] > 0 && $sobresalienteA[0] <= 24)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-1.png') }}" width="170">

                            @elseif($sobresalienteA[0] >= 25 && $sobresalienteA[0] <= 50)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-2.png') }}" width="170">

                            @elseif($sobresalienteA[0] > 50 && $sobresalienteA[0] <= 75)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-3.png') }}" width="170">

                            @elseif($sobresalienteA[0] > 75 && $sobresalienteA[0] <= 100)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-4.png') }}" width="170">
                            @else
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-1.png') }}" width="170">
                            @endif

                            <p class="color-sec" style="margin-top: 1rem; margin-left: .6rem;">
                                <b>
                                    {{ substr($sobresalienteA[0], 0, 2) }}%
                                </b>
                            </p>
                        </div>
                    </div>

                    {{-- base --}}
                    <div class="col-md-6">
                        <div class="col-md-12">
                            <p class="color fw-700" style="font-size: 14pt;">{{ $sobresalientesDesc[$desarrollarA[0]] }}</p>
                        </div>

                        <div class="col-md-8 mb-1">
                            <p class="text-justify">
                                {{ $sobresalientesDefinicion[$desarrollarA[0]] }}
                            </p>
                        </div>

                        <div class="col-md-12 mb-1" style="display: flex;">
                            @if($desarrollarA[0] > 0 && $desarrollarA[0] <= 24)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-1.png') }}" width="170">

                            @elseif($desarrollarA[0] >= 25 && $desarrollarA[0] <= 50)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-2.png') }}" width="170">

                            @elseif($desarrollarA[0] > 50 && $desarrollarA[0] <= 75)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-3.png') }}" width="170">

                            @elseif($desarrollarA[0] > 75 && $desarrollarA[0] <= 100)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-4.png') }}" width="170">
                            @else
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-1.png') }}" width="170">
                            @endif

                            <p class="color-sec" style="margin-top: 1rem; margin-left: .6rem;">
                                <b>
                                    {{ substr($desarrollarA[0], 0, 2) }}%
                                </b>
                            </p>
                        </div>
                    </div>

                    {{-- sobresaliente --}}
                    <div class="col-md-6 mb-2">
                        <div class="col-md-12">
                            <p class="color fw-700" style="font-size: 14pt;">{{ $sobresalientesDesc[$sobresalienteB[0]] }}</p>
                        </div>

                        <div class="col-md-10 mb-1">
                            <p class="text-justify">
                                {{ $sobresalientesDefinicion[$sobresalienteB[0]] }}
                            </p>
                        </div>

                        <div class="col-md-12 mb-1" style="display: flex;">
                            @if($sobresalienteB[0] > 0 && $sobresalienteB[0] <= 24)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-1.png') }}" width="170">

                            @elseif($sobresalienteB[0] >= 25 && $sobresalienteB[0] <= 50)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-2.png') }}" width="170">

                            @elseif($sobresalienteB[0] > 50 && $sobresalienteB[0] <= 75)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-3.png') }}" width="170">

                            @elseif($sobresalienteB[0] > 75 && $sobresalienteB[0] <= 100)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-4.png') }}" width="170">
                            @else
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-1.png') }}" width="170">
                            @endif

                            <p class="color-sec" style="margin-top: 1rem; margin-left: .6rem;">
                                <b>
                                    {{ substr($sobresalienteB[0], 0, 2) }}%
                                </b>
                            </p>
                        </div>
                    </div>

                    {{-- base --}}
                    <div class="col-md-6 mb-2">
                        <div class="col-md-12">
                            <p class="color fw-700" style="font-size: 14pt;">{{ $sobresalientesDesc[$desarrollarB[0]] }}</p>
                        </div>

                        <div class="col-md-10 mb-1">
                            <p class="text-justify">
                                {{ $sobresalientesDefinicion[$desarrollarB[0]] }}
                            </p>
                        </div>

                        <div class="col-md-12 mb-1" style="display: flex;">
                            @if($desarrollarB[0] > 0 && $desarrollarB[0] <= 24)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-1.png') }}" width="170">

                            @elseif($desarrollarB[0] >= 25 && $desarrollarB[0] <= 50)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-2.png') }}" width="170">

                            @elseif($desarrollarB[0] > 50 && $desarrollarB[0] <= 75)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-3.png') }}" width="170">

                            @elseif($desarrollarB[0] > 75 && $desarrollarB[0] <= 100)
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-4.png') }}" width="170">
                            @else
                                <img src="{{ asset('assets/admin/tests/ps-skills/competencias-graf-turned-1.png') }}" width="170">
                            @endif

                            <p class="color-sec" style="margin-top: 1rem; margin-left: .6rem;">
                                <b>
                                    {{ substr($desarrollarB[0], 0, 2) }}%
                                </b>
                            </p>
                        </div>
                    </div>

                    {{-- Todas competencias --}}
                    <div class="col-md-12">
                        <h3 style="color: #6F3795;">DESCRIPCIÓN DE COMPETENCIAS</h3>
                        <hr align="left" class="divider-90">
                    </div>

                    @foreach ($totales_prueba as $key => $total)
                        <div class="col-md-12">
                            <p class="color fw-700" style="font-size: 12pt;">{{ $total->descripcion }}</p>
                            <hr align="left" class="divider-20" style="margin-top: -.6rem;">

                            {{-- Definición --}}
                            <div class="col-md-12 color-sec">
                                <p class="text-justify">
                                    {{ $total->definicion }}
                                </p>
                            </div>

                            {{-- Gráficas --}}
                            <div class="col-md-2 col-md-offset-1 text-center">
                                <p class="tri-fs-16">
                                    @if($configuracionPrueba[$key]['competencia_id'] == $total->competencia_id)
                                        <strong>{{ $configuracionPrueba[$key]['nivel_esperado'] }}</strong>
                                    @endif
                                </p>

                                @if($configuracionPrueba[$key]['nivel_esperado'] >= 0 && $configuracionPrueba[$key]['nivel_esperado'] <= 50)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-ideal-1.png') }}" width="26">

                                @elseif($configuracionPrueba[$key]['nivel_esperado'] > 50 && $configuracionPrueba[$key]['nivel_esperado'] <= 75)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-ideal-2.png') }}" width="26">

                                @elseif($configuracionPrueba[$key]['nivel_esperado'] > 75 && $configuracionPrueba[$key]['nivel_esperado'] <= 100)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-ideal-3.png') }}" width="26">
                                @endif

                                <p>
                                    <strong>Ideal</strong>
                                </p>
                            </div>

                            <div class="col-md-2 text-center">
                                <p class="tri-fs-16">
                                    <strong>{{ round($total->ajuste_perfil) }}</strong>
                                </p>

                                @if($total->ajuste_perfil >= 0 && $total->ajuste_perfil <= 50)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-obtenido-1.png') }}" width="26">

                                @elseif($total->ajuste_perfil > 50 && $total->ajuste_perfil <= 75)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-obtenido-2.png') }}" width="26">

                                @elseif($total->ajuste_perfil > 75 && $total->ajuste_perfil <= 100)
                                    <img src="{{ asset('assets/admin/tests/ps-skills/competencia-obtenido-3.png') }}" width="26">
                                @endif

                                <p>
                                    <strong>Obtenido</strong>
                                </p>
                            </div>

                            {{-- Ajuste al perfil --}}
                            <div class="col-md-3 col-md-offset-1 text-center" hidden>
                                <div class="col-md-12 text-center">
                                    <p style="font-size: 1.5rem;">Ajuste del <br> candidato al perfil</p>

                                    <div class="m-auto" style="border-radius: 100%;
                                        background-color: #6F3795;
                                        width: 60px;
                                        height: 60px;
                                        color: white;
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;">
                                        <p style="font-size: 4rem; margin-top: .8rem;">
                                            <b>{{ round($total->ajuste_perfil) }}</b>
                                        </p>
                                    </div>
                                </div>

                                {{-- Desfase --}}
                                <div class="col-md-12 text-center mt-1">
                                   <!-- <p style="font-size: 1.5rem;">Factor de desfase</p>

                                    <p style="font-size: 2rem; margin-left: 2.5rem; margin-top: -1rem;">
                                        @if (round($total->desfase) > 10)
                                            <b>10%</b>
                                        @elseif(round($total->desfase) < -10)
                                            <b>-10%</b>
                                        @else
                                            <b>{{ round($total->desfase) }}%</b>
                                        @endif

                                        @if($total->desfase < 0)
                                            <img style="margin-left: -1.5rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="60">
                                        @else
                                            <img style="margin-left: -1.5rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="60">
                                        @endif
                                    </p> -->
                                </div>
                            </div>

                            {{-- Ajuste al perfil básico --}}
                            <div class="col-md-3 text-center">
                                <?php
                                    $ajuste_basico = round($total->ajuste_perfil) * 100;
                                    $total_basico = $ajuste_basico / $configuracionPrueba[$key]['nivel_esperado'];

                                    $factor_aprobacion = $total->ajuste_perfil - $configuracionPrueba[$key]['nivel_esperado'];
                                ?>

                                <div class="col-md-12 text-center">
                                    <p style="font-size: 1.5rem;">Ajuste del <br> candidato al perfil básico</p>

                                    <div class="m-auto" style="border-radius: 100%;
                                        background-color: #6F3795;
                                        width: 60px;
                                        height: 60px;
                                        color: white;
                                        display: flex;
                                        justify-content: center;
                                        align-items: center;">
                                        <p style="font-size: 3.5rem; margin-top: .8rem;">
                                            @if (floor($total_basico) > 100)
                                                <strong>100</strong>
                                            @else
                                                <strong>
                                                    {{ floor($total_basico) }}
                                                </strong>
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Desfase --}}
                                <div class="col-md-12 text-center mt-1">
                                    <p style="font-size: 1.5rem;">Factor de aprobación</p>

                                    <p style="font-size: 2rem; margin-left: 2.5rem; margin-top: -1rem;">
                                        @if (round($factor_aprobacion) >= 10)
                                            <b>> 10%</b>
                                        @elseif(round($factor_aprobacion) <= -10)
                                            <b>< -10%</b>
                                        @else
                                            <b>
                                                {{ round($factor_aprobacion) }}%
                                            </b>
                                        @endif

                                        @if($factor_aprobacion < 0)
                                            <img style="margin-left: -1.5rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-negativo.png" width="60">
                                        @else
                                            <img style="margin-left: -1.5rem;" src="https://img-t3rsc.s3.amazonaws.com/t3rs-pruebas/competencias-positivo.png" width="60">
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Insights 
                    <div class="col-md-12">
                        <h3 style="color: #6F3795;">INSIGHTS</h3>
                        <hr align="left" class="divider-90">
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>