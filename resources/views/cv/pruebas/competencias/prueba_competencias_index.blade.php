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
                    Buen día {{ $name_user->nombre_candidato }}, en {{ mb_strtoupper($sitio->nombre) }} estamos muy felices de invitarte a participar en nuestros procesos de selección.
                </p>

                <p>
                    Esta prueba psicotécnica no pretende obtener una calificación en particular, por lo cual no hay respuestas buenas o malas, simplemente queremos conocer tu perfil de competencias proponiéndote situaciones en las cuales puedes seleccionar la opción que tomarías.
                </p>

                <p>
                    A continuación, encontrarás una serie de preguntas, por favor selecciona la opción de respuesta que mejor represente tu forma de actuar, tu posición o preferencia. Ten en cuenta estas recomendaciones:
                </p>

                <ol>
                    <li>Responde pensando únicamente en el contexto de tu trabajo, no en situaciones personales.</li>
                    <li>Deberás ser totalmente sincero, la prueba cuenta con un sistema de validación de respuestas que puede invalidar los resultados.</li>
                    <li>La plataforma te pedirá activar la cámara y el micrófono, esto nos ayudará a tomar fotos mientras realizas la prueba con el objetivo de validar tus respuestas.</li>
                    <li>
                        Deberías disponer de un espacio tranquilo y sin interrupciones para realizar la prueba, es importante que tus respuestas no se vean afectadas por eventos de distracción en tu entorno.
                    </li>
                </ol>

                <p>
                    <b>
                        {{ $name_user->nombres }} te deseamos éxitos en tu proceso de selección.
                    </b>
                </p>
            </div>

            <div class="col-md-12 text-center mb-4">
                <a class="btn btn-lg btn-success" href="{{ route('cv.prueba_competencias') }}">Comenzar prueba</a>
            </div>
        </div>
    </div>
@stop