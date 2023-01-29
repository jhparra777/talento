@extends("admin.layout.master")
@section("contenedor")
    {{-- Header --}}
    @include('admin.layout.includes._section_header_breadcrumb', ['page_header' => "Dashboard"])
    <div class="row">
        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-warning alert-dismissible" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>

                    {{ Session::get("mensaje_success") }}
                </div>
            </div>
        @endif
    </div>

    @if(route('home') == "https://temporizar.t3rsc.co")
        <h3>Indicadores de requerimientos  tipo proceso Reclutamiento , Selección y Contratación (Totales)</h3>

        <div class="row pt-2 mb-1">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua tri-small-box tri-transition-300 tri-blue">
                    <div class="inner">
                        <h3 class="tri-fs-30">{{ $num_req_a_r_t }}</h3>
                        <p>Requerimientos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green tri-small-box tri-transition-300 tri-green">
                    <div class="inner">
                        @if($numero_vacantes_r_t === null)
                            <h3 class="tri-fs-30">0<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes Solicitadas</p>
                        @else
                            <h3 class="tri-fs-30">{{ $numero_vacantes_r_t}}<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes Solicitadas</p>
                        @endif
                    </div>
                    
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow tri-small-box tri-transition-300 tri-yellow">
                    <div class="inner">
                        @if($numero_vac_r_t === null)
                            <h3 class="tri-fs-30">0<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes vencidos hoy</p>
                        @else
                            <h3 class="tri-fs-30">{{ $numero_vac_r_t}}<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes vencidos hoy</p>
                        @endif
                    </div>

                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red tri-small-box tri-transition-300 tri-red">
                    <div class="inner">
                        <h3 class="tri-fs-30">{{ $num_can_con_r_t }}</h3>
                        <p>Candidatos a contratar</p>
                    </div>
                    
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
        </div>

        <h3>Indicadores de requerimientos tipo proceso Reclutamiento , Selección y Contratación (Abiertos)</h3>

        <div class="row mb-1">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua tri-small-box tri-transition-300 tri-blue">
                    <div class="inner">
                        <h3 class="tri-fs-30">{{ $num_req_a_r }}</h3>
                        <p>Requerimientos Abiertos</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green tri-small-box tri-transition-300 tri-green">
                    <div class="inner">
                        @if($numero_vacantes_r === null)
                            <h3 class="tri-fs-30">0<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes Solicitadas</p>
                        @else
                            <h3 class="tri-fs-30">{{ $numero_vacantes_r}}<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes Solicitadas</p>
                        @endif
                        
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow tri-small-box tri-transition-300 tri-yellow">
                    <div class="inner">
                        @if($numero_vac_r === null)
                            <h3 class="tri-fs-30">0<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes vencidos hoy</p>
                        @else
                            <h3 class="tri-fs-30">{{ $numero_vac_r}}<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes vencidos hoy</p>
                        @endif
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red tri-small-box tri-transition-300 tri-red">
                    <div class="inner">
                        <h3 class="tri-fs-30">{{ $num_can_con_r }}</h3>
                        <p>Candidatos a contratar</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
        </div>

        <h3>Indicadores de requerimientos tipo proceso Contratación</h3>

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua tri-small-box tri-transition-300 tri-blue">
                    <div class="inner">
                        <h3 class="tri-fs-30">{{ $num_req_a_s }}</h3>
                        <p>Requerimientos Abiertos</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green tri-small-box tri-transition-300 tri-green">
                    <div class="inner">
                        @if($numero_vacantes_s === null)
                            <h3 class="tri-fs-30">0<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes Solicitadas</p>
                        @else
                            <h3 class="tri-fs-30">{{ $numero_vacantes_s}}<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes Solicitadas</p>
                        @endif
                    </div>

                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow tri-small-box tri-transition-300 tri-yellow">
                    <div class="inner">
                        @if($numero_vac_s === null)
                            <h3 class="tri-fs-30">0<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes vencidos hoy</p>
                        @else
                            <h3 class="tri-fs-30">{{ $numero_vac_s}}<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes vencidos hoy</p>
                        @endif
                    </div>

                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red tri-small-box tri-transition-300 tri-red">
                    <div class="inner">
                        <h3 class="tri-fs-30">{{ $num_can_con_s }}</h3>
                        <p>Candidatos a contratar</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
        </div>
    @else 
        <div class="row pt-2">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua | tri-small-box tri-shadow-light tri-bl-blue tri-transition-300 tri-bg-white">
                    <div class="inner">
                        <h3 class="tri-fs-30 tri-txt-blue">{{ $num_req_a }}</h3>
                        <p class="tri-txt-gray-600 tri-fs-16">Requerimientos abiertos</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-eye"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green | tri-small-box tri-shadow-light tri-bl-green tri-transition-300 tri-bg-white">
                    <div class="inner">
                        @if($numero_vacantes === null)
                            <h3 class="tri-fs-30 tri-txt-green">0<sup style="font-size: 20px"></sup></h3>
                        @else
                            <h3 class="tri-fs-30 tri-txt-green">{{ $numero_vacantes}}<sup style="font-size: 20px"></sup></h3>
                        @endif

                        <p class="tri-txt-gray-600 tri-fs-16">Vacantes solicitadas</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow tri-small-box | tri-small-box tri-shadow-light tri-bl-yellow tri-transition-300 tri-bg-white">
                    <div class="inner">
                        @if($numero_vac === null)
                            <h3 class="tri-fs-30 tri-txt-yellow">0<sup style="font-size: 20px"></sup></h3>
                        @else
                            <h3 class="tri-fs-30 tri-txt-yellow">{{ $numero_vac }}</h3>
                        @endif

                        <p class="tri-txt-gray-600 tri-fs-16">Vacantes vencidas hoy</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red | tri-small-box tri-shadow-light tri-bl-red tri-transition-300 tri-bg-white">
                    <div class="inner">
                        <h3 class="tri-fs-30 tri-txt-red">{{ $num_can_con }}</h3>                      
                        <p class="tri-txt-gray-600 tri-fs-16">Candidatos a contratar</p>
                    </div>

                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                </div>
            </div>
        </div> 
    @endif

    {{-- Gráfico --}}
    @if(route('home') != "https://komatsu.t3rsc.co")
        {{-- 
            <div class="container mt-2">
                <div class="row">
                    <div class=" col-md-6">
                        @if(isset($report_name4))
                            <div id="perf_div1"></div>
                            {!! \Lava::render('ComboChart', $report_name4, 'perf_div1') !!}
                        @endif
                    </div>
                </div>
            </div>
         --}}

        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center" id="boxPreloader">
                            <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
                        </div>

                        <canvas id="graficoLinearCanvas" height="140" hidden></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Modal Encuesta --}}
    {{-- @include('admin.encuesta._modal_encuesta') --}}

    <script>
        $(document).ready(function(){
            $.ajax({
                type: "POST",
                url: "{{ route('admin.presenta_encuesta') }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response.success) {
                        if(response.lleno == false) {
                            $("#modal_encuesta").modal("show");
                        }
                    } else {
                        $.smkAlert({
                            text: response.mensaje,
                            type: 'danger'
                        });
                        $('#btn_guardar').show();
                    }
                }
                // success: function(response){
                //     console.log(response)
                //     if(response.lleno == false) {
                //         $("#modal_encuesta").modal("show");
                //     }
                // }
            });
        });
    </script>

    {{-- Creación de objetos para data del gráfico --}}
    <script>
        const candidatosSolicitados = {
            candidatosEnero: {{ $candidatosSolicitados['candidatosEnero'] }},
            candidatosFebrero: {{ $candidatosSolicitados['candidatosFebrero'] }},
            candidatosMarzo: {{ $candidatosSolicitados['candidatosMarzo'] }},
            candidatosAbril: {{ $candidatosSolicitados['candidatosAbril'] }},
            candidatosMayo: {{ $candidatosSolicitados['candidatosMayo'] }},
            candidatosJunio: {{ $candidatosSolicitados['candidatosJunio'] }},
            candidatosJulio: {{ $candidatosSolicitados['candidatosJulio'] }},
            candidatosAgosto: {{ $candidatosSolicitados['candidatosAgosto'] }},
            candidatosSeptiembre: {{ $candidatosSolicitados['candidatosSeptiembre'] }},
            candidatosOctubre: {{ $candidatosSolicitados['candidatosOctubre'] }},
            candidatosNoviembre: {{ $candidatosSolicitados['candidatosNoviembre'] }},
            candidatosDiciembre: {{ $candidatosSolicitados['candidatosDiciembre'] }},
        }

        const candidatosContratados = {
            candidatosEnero: {{ $candidatosContratados['candidatosEnero'] }},
            candidatosFebrero: {{ $candidatosContratados['candidatosFebrero'] }},
            candidatosMarzo: {{ $candidatosContratados['candidatosMarzo'] }},
            candidatosAbril: {{ $candidatosContratados['candidatosAbril'] }},
            candidatosMayo: {{ $candidatosContratados['candidatosMayo'] }},
            candidatosJunio: {{ $candidatosContratados['candidatosJunio'] }},
            candidatosJulio: {{ $candidatosContratados['candidatosJulio'] }},
            candidatosAgosto: {{ $candidatosContratados['candidatosAgosto'] }},
            candidatosSeptiembre: {{ $candidatosContratados['candidatosSeptiembre'] }},
            candidatosOctubre: {{ $candidatosContratados['candidatosOctubre'] }},
            candidatosNoviembre: {{ $candidatosContratados['candidatosNoviembre'] }},
            candidatosDiciembre: {{ $candidatosContratados['candidatosDiciembre'] }},
        }
    </script>

    {{-- Js para la vista actual --}}
    <script src="{{ asset('js/admin/chart-scripts/linear-chart-index.js') }}"></script>
    
@stop