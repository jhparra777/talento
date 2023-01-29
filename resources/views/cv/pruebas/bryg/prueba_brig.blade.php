{{-- Notese el orden y tabulación de las etiquetas, hace entendible la lectura de la vista y facilita la modificación en caso de ser necesario. --}}
@extends("cv.layouts.master_out")
@section('content')
    <style>
        .panel-info {
            border-color: #a3a2f5;
        }

        .panel-info > .panel-heading {
            color: white;
            background-color: #2E2D66;
            border-color: #2E2D66;
        }

        .btn-primary {
            color: #fff;
            background-color: #2E2D66;
            border-color: #2E2D66;
        }

        .btn-primary:hover {
            background-color: #201f4a;
        }

        .btn-primary:focus {
            background-color: #201f4a;
        }

        .btn-primary.disabled {
            background-color: #5a58b0;
            border-color: #5a58b0;
        }

        .btn-primary.disabled:focus {
            background-color: #5a58b0;
            border-color: #5a58b0;
        }

        .question-page-numbers > li{
            font-weight: 700;
            margin: 0.2rem;
        }

        .question-page-numbers > li > a:hover{
            color: white;
            background-color: #E4E42A;
        }

        .question-page-numbers > li > a.active{
            color: white;
            background-color: #E4E42A;
        }

        .swal2-popup {
            font-size: 1.6rem !important;
        }
    </style>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="Prueba" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="60">
                </a>
            </div>

            <div class="collapse navbar-collapse">
                <p class="navbar-text navbar-right">{{ $user->name }}</p>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            {{-- Id del usuario y del requerimiento --}}
            <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
            <input type="hidden" name="requerimientoId" id="requerimientoId" value="{{ $requerimientoId }}">

            {{-- Incluye vista con todas la preguntas a listar paginadas --}}
            <div class="col-md-12" id="content-box">
                @include('cv.pruebas.bryg.paginacion_contenido')
            </div>

            <div class="col-md-12 mt-2 mb-4 text-center" id="buttonBox" hidden>
                <button class="btn btn-success btn-lg" id="saveTest">Finalizar prueba</button>
            </div>
    
            <div class="col-md-12 text-center mb-4" id="load" hidden>
                <img src="{{ asset('img/preloader_ee.gif') }}" width="30">
                <p>Cargando siguientes preguntas</p>
            </div>
        </div>

        {{-- Webcam --}}
        @include('cv.pruebas.digitacion.includes._section_webcam')
    </div>

    @if(Session::has("reloadPage"))
        {{ Session::put('reloadPage', 'yes') }}

        <script>
            //location.reload()
        </script>
    @endif

    <script>
        let redir = "{{ route('dashboard') }}";
        let ids = {{ json_encode($ids) }};
    </script>

    <script src="{{ asset('js/cv/bryg/prueba-bryg-webcam.js') }}"></script>
    <script src="{{ asset('js/cv/bryg/prueba-bryg.js') }}"></script>

    {{-- Paginga Js --}}
    <script src="{{ asset('js/cv/paginator-js/ps-paginga.jquery.js') }}"></script>

    {{-- swal --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        initWebcam()

        $(".question-paginate").paginga({
            itemsPerPage: 5,
            itemsContainer: '.question-items',
            pageNumbers: '.question-page-numbers'
        })

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 4000
        })

        const validateAnswers = () => {
            let panels = document.querySelectorAll('.rating-control')
            let activePage = document.querySelector('.active').dataset.page
            let itemsPerPage = 5
            let itemsInput = 4
            let loops = itemsPerPage * activePage * itemsInput

            let answerChecked = 0

            for (var i = 0; i < loops; i++) {
                let rbName = panels[i].firstElementChild.name

                const rbs = document.querySelectorAll(`input[name="${rbName}"]`)

                for (const rb of rbs) {
                    if (rb.checked) {
                        answerChecked++
                    }
                }
            }

            if (answerChecked === loops) {
                return false
            }
            return true
        }

        const showAlert = () => {
            Toast.fire({
                icon: 'error',
                title: 'Parece que has olvidado responder una o más preguntas, verifica antes de continuar'
            });
        }
    </script>
@stop