@extends("contratos.layout.master_contratacion")
@section('content')
    <style>
        .table-contract{
            border-collapse:separate; 
            border-spacing: 0 1em;
        }

        .swal2-title{ display: block !important; }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center mt-2" id="stepList" tabindex="1">
                @include('contratos.includes._section_adicionales_steps')
            </div>

            <div class="col-md-12">
                <div class="panel panel-default mt-2">
                    <div class="panel-body">
                        
                        @include($importarContrato)

                    </div>
                </div>
            </div>

            @include('contratos.includes._button_siguiente_paso')

            @include('contratos.includes._button_cancelar_contrato')
        </div>

        @if(!empty($firmaContrato))
            @if(empty($firmaContrato->firma))
            @endif

            {{-- Webcam --}}
            <div class="row" style="background-color: white;" id="webcamBox" hidden>
                <div class="col-md-12 text-center" style="z-index: -1;">
                    <video id="webcam" autoplay playsinline width="640" height="420"></video>
                    <canvas id="canvas" class="d-none" hidden></canvas>
                </div>
            </div>
        @endif
    </div>

    <script>
        $('#nextStep').focus()

        let fotoRoute = "{{ route('contratacion.virtual.foto.store') }}";

        var userId = '{{ $userId }}';
        var reqId = '{{ $ReqId }}';
    </script>
@stop