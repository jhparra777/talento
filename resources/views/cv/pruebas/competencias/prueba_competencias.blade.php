{{-- Notese el orden y tabulación de las etiquetas, hace entendible la lectura de la vista y facilita la modificación en caso de ser necesario. --}}
@extends("cv.layouts.master_out")
@section('content')
    <style>
       form { /*display: flex; flex-wrap: wrap;*/ }

        label {
            display: flex;
            cursor: pointer;
            font-weight: 500;
            position: relative;
            overflow: hidden;
            margin-bottom: 0.375em;
        }

        label input { position: absolute; left: -9999px; }

        label input:checked + span { background-color: #d6d6e5; }

        label input:checked + span:before { box-shadow: inset 0 0 0 0.4375em #7f8c8d; }

        label span { display: flex; align-items: center; padding: 0.375em 0.75em 0.375em 0.375em; border-radius: 99em; transition: 0.25s ease; }

        label span:hover { background-color: #d6d6e5; }

        label span:before {
            display: flex;
            flex-shrink: 0;
            content: "";
            background-color: #fff;
            width: 1.5em;
            height: 1.5em;
            border-radius: 50%;
            margin-right: 0.375em;
            transition: 0.25s ease;
            box-shadow: inset 0 0 0 0.125em #7f8c8d;
        }

        .container-radios {
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        /**/
        .question-page-numbers > li{
            font-weight: 700;
            margin: 0.2rem;
        }

        .question-page-numbers > li > a:hover{
            color: white;
            background-color: #7f8c8d;
        }

        .question-page-numbers > li > a.active{
            color: white;
            background-color: #bdc3c7;
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
            <div class="question-paginate">
                <form id="frmPruebaCompetencias" class="question-items">
                    {{-- Id del usuario y del requerimiento --}}
                    <input type="hidden" name="userId" id="userId" value="{{ $user->id }}">
                    <input type="hidden" name="requerimientoId" id="requerimientoId" value="{{ $requerimientoId }}">

                    @foreach($totalPreguntas as $pregunta)
                        <div class="panel panel-default" style="border-color: #7f8c8d;">
                            <div class="panel-body">
                                <div class="col-md-12 text-center">
                                    <h4>{{ $pregunta->descripcion }}</h4>
                                </div>

                                <input type="hidden" name="inversas[]" value="{{ ($pregunta->inversa) ? $pregunta->inversa : 0 }}">
                                <input type="hidden" name="preguntas_id[]" value="{{ $pregunta->id }}">
                                <input type="hidden" name="competencias_id[]" value="{{ $pregunta->competencia_id }}">
                                <input type="hidden" name="codigos[]" value="{{ $pregunta->codigo }}">

                                <div class="col-md-12 text-center container-radios">
                                    <label>
                                        <input 
                                            type="radio" 
                                            id="siempreDirecta_{{ $pregunta->codigo }}" 
                                            name="pregunta_{{ $pregunta->codigo }}" 
                                            value="15"
                                            data-siempre="{{ ($pregunta->inversa) ? 0 : 2 }}" 
                                            {{ ($pregunta->inversa) ? 0 : 'data-competencia='.$pregunta->competencia_id }}

                                            onchange="competenciaOpcion(this)">
                                        <span>Siempre</span>
                                    </label>

                                    <label>
                                        <input 
                                            type="radio" 
                                            id="casiSiempreDirecta_{{ $pregunta->codigo }}" 
                                            name="pregunta_{{ $pregunta->codigo }}" 
                                            value="12"
                                            data-casiSiempre="{{ ($pregunta->inversa) ? 0 : 2 }}" 
                                            {{ ($pregunta->inversa) ? 0 : 'data-competencia='.$pregunta->competencia_id }}

                                            onchange="competenciaOpcion(this)">
                                        <span>Casi siempre</span>
                                    </label>

                                    <label>
                                        <input 
                                            type="radio" 
                                            id="algunasVecesDirecta_{{ $pregunta->codigo }}" 
                                            name="pregunta_{{ $pregunta->codigo }}" 
                                            value="9"
                                            data-algunasVeces="1" 
                                            {{ ($pregunta->inversa) ? 0 : 'data-competencia='.$pregunta->competencia_id }}

                                            onchange="competenciaOpcion(this)">
                                        <span>Algunas veces</span>
                                    </label>

                                    <label>
                                        <input 
                                            type="radio" 
                                            id="casiNuncaDirecta_{{ $pregunta->codigo }}" 
                                            name="pregunta_{{ $pregunta->codigo }}" 
                                            value="6"
                                            data-casiNunca="{{ ($pregunta->inversa) ? 2 : 0 }}" 
                                            {{ ($pregunta->inversa) ? 0 : 'data-competencia='.$pregunta->competencia_id }}

                                            onchange="competenciaOpcion(this)">
                                        <span>Casi nunca</span>
                                    </label>

                                    <label>
                                        <input 
                                            type="radio" 
                                            id="nuncaDirecta_{{ $pregunta->codigo }}" 
                                            name="pregunta_{{ $pregunta->codigo }}" 
                                            value="3"
                                            data-nunca="{{ ($pregunta->inversa) ? 2 : 0 }}" 
                                            {{ ($pregunta->inversa) ? 0 : 'data-competencia='.$pregunta->competencia_id }}

                                            onchange="competenciaOpcion(this)">
                                        <span>Nunca</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </form>

                <div class="pager mt-3 mb-3" id="paginationButtonBox">
                    <div class="btn-group btn-group-lg" role="group" aria-label="...">
                        <button type="button" class="previousPage btn btn-default" disabled>
                            <i class="fas fa-chevron-circle-left"></i> Anterior
                        </button>
                        <button type="button" class="nextPage btn btn-default">
                            Siguiente <i class="fas fa-chevron-circle-right"></i>
                        </button>
                    </div>

                    <div class="question-page-numbers mt-1"></div>
                </div>

                <div class="col-md-12 mt-2 mb-4 text-center" id="buttonBox" hidden>
                    <button type="button" class="btn btn-success btn-lg" id="saveTest" data-route="{{ route('cv.prueba_competencias_guardar') }}">Finalizar prueba</button>
                </div>
            </div>
        </div>

        {{-- Webcam --}}
        @include('cv.pruebas.digitacion.includes._section_webcam')
    </div>

    <style>
        .swal2-popup { font-size: 1.6rem !important; }
    </style>

    <script>
        let redir = "{{ route('dashboard') }}";
        let allQuestions = "{{ count($totalPreguntas) }}"
    </script>

    <script src="{{ asset('js/cv/pskills/prueba-ps-webcam.js') }}"></script>
    <script src="{{ asset('js/cv/pskills/prueba-ps.js') }}"></script>

    <script>
        let resultados = [];

        initWebcam()

        //Validar la cantidad de radios para mostrar guardar
        function competenciaOpcion(obj) {
            let allRadios = document.querySelectorAll('input[type="radio"]')
            let radiosChecked = 0

            allRadios.forEach(function(input, index) {
                if (input.checked) {
                    radiosChecked++
                }
            });

            if (radiosChecked === 1) {
                addEventListener("beforeunload", beforeUnloadListener, {capture: true});
            }

            if (parseInt(radiosChecked) === parseInt(allQuestions)) {
                document.querySelector('#buttonBox').removeAttribute('hidden')
                document.querySelector('#paginationButtonBox').setAttribute('hidden', true)
            }
        }
    </script>

    {{-- Paginga Js --}}
    <script src="{{ asset('js/cv/paginator-js/ps-paginga.jquery.js') }}"></script>

    {{-- swal --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        $(".question-paginate").paginga({
            itemsPerPage: 6,
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
            let panels = document.querySelectorAll('.container-radios')
            let activePage = document.querySelector('.active').dataset.page
            let itemsPerPage = 6
            let loops = itemsPerPage * activePage

            let answerChecked = 0

            for (var i = 0; i < loops; i++) {
                let rbName = panels[i].firstElementChild.firstElementChild.name

                const rbs = document.querySelectorAll(`input[name="${rbName}"]`)

                for (const rb of rbs) {
                    if (rb.checked) {
                        answerChecked++
                    }
                }
            }

            if (answerChecked === loops) {
                return false
            }else {
                return true
            }
        }

        const showAlert = () => {
            Toast.fire({
                icon: 'error',
                title: 'Parece que has olvidado responder una o más preguntas, verifica antes de continuar'
            });
        }
    </script>
@stop