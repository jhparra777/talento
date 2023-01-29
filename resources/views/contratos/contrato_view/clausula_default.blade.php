@extends("contratos.layout.master_contratacion")
@section('content')
    <style>
        .table-contract{
            border-collapse:separate; 
            border-spacing: 0 1em;
        }
    </style>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 text-center mt-2" id="stepList" tabindex="1">
                @include('contratos.includes._section_adicionales_steps')
            </div>

            <div class="col-md-12">
                <h2 class="text-center">Documentos adicionales</h2>
            </div>

            <div class="col-md-12">
                <div class="panel panel-default mt-2">
                    <div class="panel-body">
                        @if(!$finAdicionales)
                            {{-- Instrucciones --}}
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              
                                <h3>Instrucciones:</h3>

                                <ol>
                                    <li>Leer muy bien el documento</li>
                                    <li>Ir hasta el final y firmar con el mouse en el espacio indicado</li>
                                </ol>
                            </div>
                        @endif

                        {{-- @include('home.firma-documento-adicional') --}}
                        @include('contratos.clausula_view.clausula_documento')

                    </div>
                </div>
            </div>

            @include('contratos.includes._button_cancelar_contrato')
        </div>

        {{-- Webcam --}}
        @if(!$finAdicionales)
            <div class="row" style="background-color: white;" id="webcamBox" hidden>
                <div class="col-md-12 text-center" style="z-index: -1;">
                    <video id="webcam" autoplay playsinline width="640" height="420"></video>
                    <canvas id="canvas" class="d-none" hidden></canvas>
                </div>
            </div>
        @endif
    </div>

    <script>
        /*$('#stepList').focus()

        setTimeout(() => {
            $('#stepList').focus()
        }, 1500)*/

        let fotoRoute = "{{ route('contratacion.virtual.foto.store') }}";

        var userId = '{{ $userId }}';
        var reqId = '{{ $req_id }}';

        $('html, body').animate({
            scrollTop: $("#stepList").offset().top
        }, 1000);
    </script>
@stop