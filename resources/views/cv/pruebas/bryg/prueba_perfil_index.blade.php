{{-- Notese el orden y tabulación de las etiquetas, hace entendible la lectura de la vista y facilita la modificación en caso de ser necesario. --}}
@extends("cv.layouts.master_out")
@section('content')
    <style>
        .text-justify{ text-align: justify; }

        .mt-0{ margin-top: 0; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .mb-0{ margin-bottom: 0; }
        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }
    </style>

    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">
                    <img alt="Prueba" src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="60">
                </a>
            </div>

            <div class="collapse navbar-collapse">
                <p class="navbar-text navbar-right">Hola, {{ $user->name }}</p>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-md-12 text-justify">
                <div class="page-header title-bryg">
                    <h3>Instrucciones para realizar la prueba <small class="text-danger"><b class="title-helper">LEE ATENTAMENTE</b></small></h3>
                </div>

                <p>
                    Hola <b>{{ $name_user->nombre_candidato }}</b>, te damos la bienvenida a la realización de una de las pruebas psicotécnicas que el equipo de selección de <b>{{ $sitio->nombre }}</b> ha preparado para ti.
                </p>

                <p>
                    A continuación te vamos a hacer una serie de preguntas, las cuales nos servirán para identificar características de tu personalidad, por lo cual no hay respuestas buenas o malas, simplemente queremos conocerte un poco más. Las instrucciones son las siguientes:
                </p>

                <p>
                    <span><b>1.</b></span> Vas a encontrar unas afirmaciones, deberás identificarte en cada afirmación aunque parezca que no tienen mucho que ver contigo.
                </p>

                <p>
                    <span><b>2.</b></span> Debes responder a todos los enunciados, dejar de responder puede hacer que los resultados no sean óptimos.
                </p>

                <p>
                    <span><b>3.</b></span> Cada enunciado esta acompañado de cuatro opciones de respuesta, debes elegir colocando <b>4 estrellas a lo que más te representa</b> y <b>1 estrella lo que menos</b>.
                </p>

                <p>
                    <span><b>4.</b></span> No hay respuestas correctas o incorrectas, recuerda que todos somos distintos.
                </p>

                <p>
                    <span><b>5.</b></span> La mejor forma de que esta prueba te represente es que no pienses mucho las respuestas, generalmente nuestra personalidad emerge eligiendo rápidamente las opciones.
                </p>

                <p>
                    <span><b>6.</b></span> En general nosotros no somos de una u otra manera siempre, así que elige la respuesta que más te identifique.
                </p>

                <p>
                    <span><b>7.</b></span> Puede que algunos enunciados no tengan que ver contigo directamente, por ejemplo "Cuando estudié mi segunda carrera profesional" Pues puede que no tengas ninguna carrera profesional, no la hayas terminado o solo tengas una, en estos casos responde como si fuera tu caso, como si estuvieras en esa situación y la entendieras perfectamente.
                </p>

                <p>
                    <span><b>8.</b></span>
                    <b>
                        No debes contestar con el mismo número de estrellas a dos opciones de respuesta en la misma pregunta, por ejemplo, si la opción de respuesta uno tiene 4 estrellas las demás opciones de respuesta no pueden tener 4 estrellas.
                    </b>
                </p>

                <blockquote class="mt-2" style="font-size: 15.5px;">
                    <p>
                        Contestar la prueba te tomará alrededor de 10 minutos, por lo cual te sugerimos que estés concentrado respondiéndola para no afectar los resultados. A continuación encontrarás la pregunta de ejemplo y posteriormente las preguntas correspondientes al desarrollo del test. Muchos éxitos!
                    </p>
                </blockquote>
            </div>

            <div class="col-md-12">
                <div class="page-header title-bryg">
                    <h4>Ejemplo <br class="jump-line" hidden> <small><b>Esta pregunta es la representación de como debes responder la prueba.</b></small></h4>
                </div>
                
                <p class="text-warning"><b>Responde como si te encantarán los helados de limón pero odiaras los de vainilla</b></p>

                <div class="panel panel-warning mt-2">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            El sabor de helado que más disfruto es
                            <i 
                                class="text-right fa fa-question-circle"
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="No debes contestar con el mismo número de estrellas a dos opciones de respuesta en la misma pregunta, por ejemplo, si la opción de respuesta uno tiene 4 estrellas las demás opciones de respuesta no pueden tener 4 estrellas."
                            ></i>
                        </h3>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="fas fa-minus icon-minus"></i>
                            <div class="rating-control">
                                {{-- Básico --}}
                                <input
                                    type="radio"
                                    name="rating"
                                    id="rating_id_4"
                                    value="4"
                                    required
                                    checked
                                >
                                <label for="rating_id_4" title="4">4</label>
        
                                {{-- Garante --}}
                                <input
                                    type="radio"
                                    name="rating"
                                    id="rating_id_3"
                                    value="3"
                                    required
                                >
                                <label for="rating_id_3" title="3">3</label>
        
                                {{-- Genuino --}}
                                <input
                                    type="radio"
                                    name="rating"
                                    id="rating_id_2"
                                    value="2"
                                    required
                                >
                                <label for="rating_id_2" title="2">2</label>
        
                                {{-- Radical --}}
                                <input
                                    type="radio"
                                    name="rating"
                                    id="rating_id_1"
                                    value="1"
                                    required
                                >
                                <label for="rating_id_1" title="1">1</label>
                            </div>
                            <i class="fas fa-plus icon-plus"></i>
        
                            <p class="question-desc">Limón</p>
                        </li>

                        <li class="list-group-item">
                            <i class="fas fa-minus icon-minus"></i>
                            <div class="rating-control">
                                {{-- Básico --}}
                                <input
                                    type="radio"
                                    name="rating_2"
                                    id="rating_4_id_4"
                                    value="4"
                                    required
                                >
                                <label for="rating_4_id_4" title="4">4</label>
        
                                {{-- Garante --}}
                                <input
                                    type="radio"
                                    name="rating_2"
                                    id="rating_3_id_3"
                                    value="3"
                                    required
                                    checked
                                >
                                <label for="rating_3_id_3" title="3">3</label>
        
                                {{-- Genuino --}}
                                <input
                                    type="radio"
                                    name="rating_2"
                                    id="rating_2_id_2"
                                    value="2"
                                    required
                                >
                                <label for="rating_2_id_2" title="2">2</label>
        
                                {{-- Radical --}}
                                <input
                                    type="radio"
                                    name="rating_2"
                                    id="rating_1_id_1"
                                    value="1"
                                    required
                                >
                                <label for="rating_1_id_1" title="1">1</label>
                            </div>
                            <i class="fas fa-plus icon-plus"></i>
        
                            <p class="question-desc">Chocolate</p>
                        </li>

                        <li class="list-group-item">
                            <i class="fas fa-minus icon-minus"></i>
                            <div class="rating-control">
                                {{-- Básico --}}
                                <input
                                    type="radio"
                                    name="rating_3"
                                    id="rating_3_id_4"
                                    value="4"
                                    required
                                >
                                <label for="rating_3_id_4" title="4">4</label>
        
                                {{-- Garante --}}
                                <input
                                    type="radio"
                                    name="rating_3"
                                    id="rating_9_id_3"
                                    value="3"
                                    required
                                >
                                <label for="rating_9_id_3" title="3">3</label>
        
                                {{-- Genuino --}}
                                <input
                                    type="radio"
                                    name="rating_3"
                                    id="rating_3_id_2"
                                    value="2"
                                    required
                                >
                                <label for="rating_3_id_2" title="2">2</label>
        
                                {{-- Radical --}}
                                <input
                                    type="radio"
                                    name="rating_3"
                                    id="rating_11_id_1"
                                    value="1"
                                    required
                                    checked
                                >
                                <label for="rating_11_id_1" title="1">1</label>
                            </div>
                            <i class="fas fa-plus icon-plus"></i>
        
                            <p class="question-desc">Vainilla</p>
                        </li>

                        <li class="list-group-item">
                            <i class="fas fa-minus icon-minus"></i>
                            <div class="rating-control">
                                {{-- Básico --}}
                                <input
                                    type="radio"
                                    name="rating_4"
                                    id="rating_20_id_4"
                                    value="4"
                                    required
                                >
                                <label for="rating_20_id_4" title="4">4</label>
        
                                {{-- Garante --}}
                                <input
                                    type="radio"
                                    name="rating_4"
                                    id="rating_40_id_3"
                                    value="3"
                                    required
                                >
                                <label for="rating_40_id_3" title="3">3</label>
        
                                {{-- Genuino --}}
                                <input
                                    type="radio"
                                    name="rating_4"
                                    id="rating_50_id_2"
                                    value="2"
                                    required
                                    checked
                                >
                                <label for="rating_50_id_2" title="2">2</label>
        
                                {{-- Radical --}}
                                <input
                                    type="radio"
                                    name="rating_4"
                                    id="rating_60_id_1"
                                    value="1"
                                    required
                                >
                                <label for="rating_60_id_1" title="1">1</label>
                            </div>
                            <i class="fas fa-plus icon-plus"></i>
        
                            <p class="question-desc">Mora</p>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="col-md-12 text-center mb-4">
                <a class="btn btn-lg btn-success" href="{{ route('cv.prueba_perfilamiento') }}">Comenzar prueba</a>
            </div>
        </div>
    </div>
@stop