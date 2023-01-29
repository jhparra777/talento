@extends("home.layout.master")
@section('content')

  <section id="counter">
    <div class="container">
      <div class="row">

        <div class="col-md-12">
              <div class="breadcrumb-wrapper">
                  <h2 class="product-title">Preguntas del requerimiento {{ $req_id }}</h2>
                  <ol class="breadcrumb">
                      <li>
                          <a href="{{ route('home') }}">
                              <i class="ti-home"></i> Inicio
                          </a>
                      </li>
                      <li class="current">Preguntas del requerimiento {{ $req_id }}   </li>
                  </ol>
              </div>
          </div>
       
      </div>
    </div>
  </section>

  <section id="work" name="work" class="find-job section">

    <div class="container">
      
      <h2 class="section-title">Preguntas</h2>

      <div class="alert alert-info" role="alert">Estas por comenzar la prueba de idioma, debes grabar un video respondiendo la pregunta que se muestra.</div>
      
      <div class="row">

          <div class="col-md-12">
            <div class="job-list">

              <div style="text-align: center;">

                <?php $cont = 1 ?>
                @foreach ($pregunta as $key => $preguntaItem)

                  @if(\App\Models\Pregunta::respuestas_candidato_static($user_id, $preguntaItem->id) == 0)

                    <button class="btn btn-info mt-1" type="button" onclick="showQuestion({{ $preguntaItem->id }},{{ $req_id }},{{ $cargo_id }});" title="Responder pregunta"
                      style="margin-bottom: 10px;">
                      Pregunta # {{ $cont++ }}
                    </button>

                  @else

                    <button class="btn btn-success mt-1" type="button" style="margin-bottom: 10px;" disabled>
                      Realizada
                    </button>
                    
                  @endif
                @endforeach

              </div>
            </div>
          </div>

      </div>
    </div>

  </section>

  <link rel="stylesheet" type="text/css" media="screen" href="https://lexxus.github.io/jq-timeTo/stylesheets/timeTo.css">
  <script src="{{ asset('js/ga.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/timeto.min.js') }}" type="text/javascript"></script>

  <script>
    function showQuestion(idQuestion,reqId,cargoId){

      $.ajax({
          type: "POST",
          data: { 'preg_id' : idQuestion, 'req_id' : reqId, 'cargo_id' : cargoId, 'preguntaRespCount' : {{ $preguntaRespCount }}, 'preguntaCount' : {{ $preguntaCount }} },
          url: "{{ route('admin.pregunta_modal_idioma') }}",
          success: function(response) {
              $("#modal_gr").find(".modal-content").html(response);
              $("#modal_gr").modal("show");
          }
      })

    }
  </script>

@stop