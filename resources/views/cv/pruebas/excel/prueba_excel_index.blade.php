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
                    Hola <b>{{ $name_user->nombre_candidato }}</b>, te damos la bienvenida a la realización de la prueba de {{ $nombre_prueba }} que el equipo de selección de <b>{{ $sitio->nombre }}</b> ha preparado para ti.
                </p>

                <p>
                    A continuación te vamos a hacer una serie de preguntas, las cuales nos servirán para medir tu conocimiento de Excel. Las instrucciones son las siguientes:
                </p>

                <p>
                    <span><b>1.</b></span> Vas a encontrar {{ $total_preguntas }} preguntas de múltiples opciones, con respuesta única.
                </p>

                <p>
                    <span><b>2.</b></span> Debes responder a todos los enunciados, en el menor tiempo posible.
                </p>

                <p>
                    <span><b>3.</b></span> Cada enunciado esta acompañado de múltiples opciones de respuesta, debes seleccionar la que creas correcta.
                </p>

                <p>
                    <span><b>4.</b></span> Se solicitará permiso para acceder a tu cámara, ya que te tomaremos fotos mientras respondes la prueba para mantener el registro de quien respondió la misma.
                </p>

                <blockquote class="mt-2" style="font-size: 15.5px;">
                    <p>
                        Contestar la prueba te tomará alrededor de 10 minutos, por lo cual te sugerimos que estés concentrado respondiéndola para no afectar los resultados. A continuación encontrarás la pregunta de ejemplo y posteriormente las preguntas correspondientes. Muchos éxitos!
                    </p>
                </blockquote>
            </div>

            <div class="col-md-12">
                <div class="page-header title-bryg">
                    <h4>Ejemplo <br class="jump-line" hidden> <small><b>Esta pregunta es la representación de como debes responder la prueba.</b></small></h4>
                </div>

                <div class="panel panel-warning mt-2">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Una hoja de cálculo en Excel tiene la extensión:
                            <i 
                                class="text-right fa fa-question-circle"
                                data-toggle="tooltip" 
                                data-placement="right" 
                                title="Debes seleccionar la opción que consideres correcta."
                            ></i>
                        </h3>
                    </div>

                    <ol class="list-group">
                        <li class="list-group-item">
                            <label><input type="radio" name="prueba"> exc </label>
                        </li>
                        <li class="list-group-item">
                            <label><input type="radio" name="prueba"> xls </label>
                        </li>
                        <li class="list-group-item">
                            <label><input type="radio" name="prueba"> doc </label>
                        </li>
                        <li class="list-group-item">
                            <label><input type="radio" name="prueba"> pdf </label>
                        </li>
                    </ol>
                </div>
            </div>
            
            <div class="col-md-12 text-center mb-4">
                <a class="btn btn-lg btn-success" href="{{ $ruta_comienzo }}">Comenzar prueba</a>
            </div>
        </div>
    </div>
@stop