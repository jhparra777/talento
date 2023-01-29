@extends("req.layout.master")
@section("contenedor")
{{-- Header --}}
@include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Dashboard"])
    <div class="row">
        {{-- Requerimientos Abiertos --}}
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-aqua | tri-small-box tri-shadow-light tri-bl-blue tri-transition-300 tri-bg-white">
                <div class="inner">
                    <h3 class="tri-fs-30 tri-txt-blue">{{ $num_req_a }}</h3>
                    <p class="tri-txt-gray-600 tri-fs-16">Requerimientos Abiertos</p>
                </div>

                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>

        {{-- Vacantes Solicitadas --}}
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-green | tri-small-box tri-shadow-light tri-bl-green tri-transition-300 tri-bg-white">
                <div class="inner">
                    <h3 class="tri-fs-30 tri-txt-green">{{ $numero_vacantes }}<sup style="font-size: 20px"></sup></h3>
                    <p class="tri-txt-gray-600 tri-fs-16">Vacantes Solicitadas</p>
                </div>

                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
            </div>
        </div>

        {{-- Vacantes vencidos hoy --}}
        <div class="col-lg-3 col-xs-6">
            <div class="small-box bg-yellow tri-small-box | tri-small-box tri-shadow-light tri-bl-yellow tri-transition-300 tri-bg-white">
                <div class="inner">
                    <h3 class="tri-fs-30 tri-txt-yellow">{{ $num_vac_ven }}</h3>
                    <p class="tri-txt-gray-600 tri-fs-16">Vacantes vencidos hoy</p>
                </div>

                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
            </div>
        </div>

        {{-- Candidatos a contratar --}}
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

    {{-- cards --}}
    @include('req.includes.index._section_action_card')
@stop