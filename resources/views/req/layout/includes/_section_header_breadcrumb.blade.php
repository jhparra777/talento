<section class="mb-2">
    <div class="row | tri-bg-white" style="padding: 15px; box-shadow: 1px 0 5px rgba(0, 0, 0, 0.1);">
        <div class="col-md-6 col-sm-6">
            <h3 class="header-title mt-0 mb-0 tri-fs-20 tri-txt-gray" style="line-height: 30px;">{!! $page_header !!}</h3>
        </div>

        <div class="col-md-6 col-sm-6 text-right">
            <ol class="breadcrumb | tri-breadcrumb tri-fs-12" style="line-height: 24px;">
                <li><a href="{{ route('req_index') }}">Inicio</a></li>

                {!! FuncionesGlobales::migaPan(); !!}
            </ol>
        </div>

        @if (isset($more_info))
            <div class="col-md-12">
                <span id="span-more-info">
                    {!! $more_info !!}
                </span>
            </div>
        @endif
    </div>
</section>

<style>
    @media (max-width: 1500px) {
        /*.header-title { font-size: 14px !important; }*/
    }
</style>