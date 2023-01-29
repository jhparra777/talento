@extends("req.layout.master")
@section('contenedor')
<style>
    .pagination{ margin: 0 !important; }

    .mb-1{ margin-bottom: 1rem; }
    .mb-2{ margin-bottom: 2rem; }
    .mb-3{ margin-bottom: 3rem; }
    .mb-4{ margin-bottom: 4rem; }
</style>

        {{-- Header --}}
        @include('req.layout.includes._section_header_breadcrumb', ['page_header' => "Indicador de Efectividad"])

{{-- <div class="container">
        <div class="row">
        <div class=" col-md-6">
            @if(isset($report_name4))
            <div id="perf_div1">       
            </div>
            {!! \Lava::render('ComboChart', $report_name4, 'perf_div1') !!}
            @endif
        </div>
       
    </div>

 </div> --}}
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
    
    $(function () {
        var confDatepicker = {
            altFormat: "yy-mm-dd",
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            buttonImage: "img/gifs/018.gif",
            buttonImageOnly: true,
            autoSize: true,
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
            yearRange: "1930:2050"
        };
      $("#fecha_inicio, #fecha_final").datepicker(confDatepicker);

      $('#export_excel_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $fecha_inicio = $("#fecha_inicio").val();
          $fecha_final = $("#fecha_final").val();
          $cliente_id = $("#cliente_id").val();
          $criterio = $("#criterio").val();

          $(this).prop("href","{{ route('admin.reportes.reportes_detalles_excel') }}?"+$data_form+"&formato=xlsx&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
      });
      $('#export_pdf_btn').click(function(e){
          $data_form = $('#filter_form').serialize();
          $fecha_inicio = $("#fecha_inicio").val();
          $fecha_final = $("#fecha_final").val();
          $cliente_id = $("#cliente_id").val();
          $criterio = $("#criterio").val();

          $(this).prop("href","{{ route('admin.reportes.reportes_detalles_excel') }}?"+$data_form+"&formato=pdf&fecha_inicio="+$fecha_inicio+"&fecha_final="+$fecha_final+"&cliente_id="+$cliente_id+"&criterio="+$criterio);
      });
    })
</script>
<script src="{{ asset('js/admin/chart-scripts/linear-chart-index.js') }}"></script>
@stop