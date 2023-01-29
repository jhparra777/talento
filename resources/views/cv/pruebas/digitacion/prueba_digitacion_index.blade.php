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
                    Bienvenida(o) <b>{{ $name_user->nombre_candidato }}</b>, para nosotros en {{ mb_strtoupper($sitio->nombre) }} es un placer que estés participando en nuestros procesos de selección!
                </p>

                <p>
                    A continuación encontrarás nuestra <b>prueba de digitación</b>, en la cual tendrás un minuto para escribir el texto que se te va a mostrar en la pantalla.
                </p>

                <p>
                    La prueba tiene en cuenta la velocidad con la que digitas, la exactitud con la que lo haces y el número de pulsaciones sobre las letras que vas a realizar, por lo cual te recomendamos estar en un espacio cómodo, y tener el tiempo libre, sin interrupciones para que puedas alcanzar el mejor desempeño.
                </p>

                <p>
                    Para empezar haz clic en el botón <b>comenzar prueba</b> y comienza a escribir. Cuándo termine el tiempo el aplicativo guardará automáticamente tus respuestas.
                    <br>
                    <b>Por favor no actualices la página mientras realizas la prueba pues se calificará como incompleta.</b>
                </p>

                <p>
                    ¡Muchos éxitos!
                </p>

                <blockquote class="mt-2" style="font-size: 15.5px;">
                    <p>
                        Recuerda que al comenzar debes dar permiso al navegador para usar tu cámara web, esto con el fin de corroborar que en realidad seas la persona que debe completar esta prueba.
                    </p>
                </blockquote>
            </div>

            <div class="col-md-12 text-center mb-4">
                <a class="btn btn-lg btn-success" href="{{ route('cv.prueba_digitacion') }}">Comenzar prueba</a>
            </div>
        </div>
    </div>
@stop