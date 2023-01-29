@extends("admin.layout.master")
@section("contenedor")
    @if(route('home') == "http://temporizar.t3rsc.co" || route('home') == "https://temporizar.t3rsc.co")
        <div class="col-md-12">
            <h3>Indicadores de requerimientos  tipo proceso Reclutamiento , Selección y Contratación(Totales)</h3>
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $num_req_a_r_t }}</h3>
                            <p>Requerimientos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            @if($numero_vacantes_r_t === null)
                                <h3>0<sup style="font-size: 20px"></sup></h3>
                                <p>Vacantes Solicitadas</p>
                            @else
                                <h3>{{ $numero_vacantes_r_t}}<sup style="font-size: 20px"></sup></h3>
                                <p>Vacantes Solicitadas</p>
                            @endif
                        </div>
                        
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            @if($numero_vac_r_t === null)
                                <h3>0<sup style="font-size: 20px"></sup></h3>
                                <p>Vacantes vencidos hoy</p>
                            @else
                                <h3>{{ $numero_vac_r_t}}<sup style="font-size: 20px"></sup></h3>
                                <p>Vacantes vencidos hoy</p>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $num_can_con_r_t }}</h3>
                            <p>Candidatos a contratar</p>
                        </div>
                        
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <h3>Indicadores de requerimientos tipo proceso Reclutamiento , Selección y Contratación(Abiertos)</h3>

            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $num_req_a_r }}</h3>
                            <p>Requerimientos Abiertos</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            @if($numero_vacantes_r ===null)
                             <h3>0<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes Solicitadas</p>
                            @else
                            <h3>{{ $numero_vacantes_r}}<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes Solicitadas</p>
                            @endif
                            
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                        @if($numero_vac_r ===null)
                             <h3>0<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes vencidos hoy</p>
                            @else
                            <h3>{{ $numero_vac_r}}<sup style="font-size: 20px"></sup></h3>
                            <p>Vacantes vencidos hoy</p>
                            @endif
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $num_can_con_r }}</h3>
                            <p>Candidatos a contratar</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <h3>Indicadores de requerimientos tipo proceso  Contratación</h3>
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $num_req_a_s }}</h3>
                            <p>Requerimientos Abiertos</p>
                        </div>

                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            @if($numero_vacantes_s ===null)
                                <h3>0<sup style="font-size: 20px"></sup></h3>
                                <p>Vacantes Solicitadas</p>
                            @else
                                <h3>{{ $numero_vacantes_s}}<sup style="font-size: 20px"></sup></h3>
                                <p>Vacantes Solicitadas</p>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            @if($numero_vac_s ===null)
                                <h3>0<sup style="font-size: 20px"></sup></h3>
                                <p>Vacantes vencidos hoy</p>
                            @else
                                <h3>{{ $numero_vac_s}}<sup style="font-size: 20px"></sup></h3>
                                <p>Vacantes vencidos hoy</p>
                            @endif
                        </div>

                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $num_can_con_s }}</h3>
                            <p>Candidatos a contratar</p>
                        </div>

                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else 
        <div class="col-md-12">
            <div class="row">
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h3>{{ $num_req_a }}</h3>
                            <p>Requerimientos Abiertos</p>
                        </div>

                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-green">
                        <div class="inner">
                            @if($numero_vacantes ===null)
                                <h3>0<sup style="font-size: 20px"></sup></h3>
                            @else
                                <h3>{{ $numero_vacantes}}<sup style="font-size: 20px"></sup></h3>
                            @endif

                            <p>Vacantes Solicitadas</p>
                        </div>

                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            @if($numero_vac ===null)
                                <h3>0<sup style="font-size: 20px"></sup></h3>
                            @else
                                <h3>{{ $numero_vac }}</h3>
                            @endif
                            
                            <p>Vacantes vencidos hoy</p>
                        </div>

                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h3>{{ $num_can_con }}</h3>                      
                            <p>Candidatos a contratar</p>
                        </div>

                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    @endif

    @if(route('home')!="http://komatsu.t3rsc.co" && route('home')!="https://komatsu.t3rsc.co")
        <br><br>
        <div class="container">
            <div class="row">
                <div class=" col-md-6">
                    @if(isset($report_name4))
                        <div id="perf_div1"></div>
                        {!! \Lava::render('ComboChart', $report_name4, 'perf_div1') !!}
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    {{-- Este modal se puede usar para dar información en la plataforma --}}
    {{--
    <div class="modal" id="modal_information">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert-info">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><span class="fa fa-info-circle"></span> Aviso informativo</h4>
                </div>

                <div class="modal-body">
                    <div class="text-center">
                        <img src="https://t3rsc.co/tri-videos/Covid-19-T3RS.jpg" width="500">
                    </div>

                    <div style="margin-left: 3rem; margin-top: 1rem;">
                        <p style="font-size: 1.5rem;">
                            Para conocer como funcionan, puedes hacer clic en los siguientes enlaces:
                        </p>

                        <p style="font-size: 1.5rem;">
                            <b><a href="https://t3rsc.co/tri-videos/entrevista_virtual.mp4" target="_blank" title="">VER VIDEO ENTREVISTA</a></b>
                            <br>
                            <b><a href="https://t3rsc.co/tri-videos/video_perfil.mp4" target="_blank" title="">VER VIDEO PERFIL</a></b>
                        </p>

                        <p style="font-size: 1.5rem;">
                            Allí encontrarás un video explicativo.
                        </p>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Aceptar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('#modal_information').modal('show')
        });
    </script>
    --}}
@stop