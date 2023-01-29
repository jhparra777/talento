@extends("home.layout.master")
@section('content')
    <style>
        .breadcrumb a{
            color: #000;
        }

        .mb-1{ margin-bottom: 1rem; }
        .mb-2{ margin-bottom: 2rem; }
        .mb-3{ margin-bottom: 3rem; }
        .mb-4{ margin-bottom: 4rem; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .black{ color: black; }

        .section{ padding: 30px 0; }
    </style>

    {!! Form::open(["route" => "home.guardar_respuestas_puntaje", "method" => "POST"]) !!}
        {!! Form::hidden("cargo_id", $cargo_id) !!}
        {!! Form::hidden("req_id", $req_id) !!}

        <section id="work" name="work" class="find-job section">
            <div class="container">
                <h3 class="mb-2 black">Preguntas</h3>

                <div class="row">
                    @foreach($preguntas_oferta as $index => $pregunta)

                        {{-- Selección múltiple con múltiple respuesta --}}
                        @if($pregunta->tipo_id == 1)

                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <label class="mb-1 black" style="text-transform: uppercase;">
                                            {{ ++$index }}- {{ ucfirst($pregunta->descripcion) }}
                                        </label>

                                        <div class="form-group">
                                            {!! Form::hidden("pregunta_multiple_id[$pregunta->id]", $pregunta->id) !!}

                                            {{-- Lista respuestas --}}
                                            @foreach($pregunta->respuestas_pregunta() as $count => $respuesta)
                                                <div class="checkbox black">
                                                    <label class="black">
                                                        {{ ++$count }}) 
                                                        {!! Form::checkbox("respuestas_multiple[]", $respuesta->id, null) !!} 
                                                        {{ $respuesta->descripcion }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        {{-- Abierta --}}
                        @elseif($pregunta->tipo_id == 3)

                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <label class="mb-1 black" style="text-transform: uppercase;">
                                            {{ ++$index }}- {{ ucfirst($pregunta->descripcion) }}
                                        </label>

                                        <div class="form-group">
                                            {!! Form::hidden("pregunta_abierta_id[$pregunta->id]", $pregunta->id) !!}
                                            
                                            {!! Form::text("respuesta_pregunta_abierta[$pregunta->id]", null, [
                                                "class" => "form-control",
                                                "id" => "descripcion",
                                                "placeholder" => "Escriba su respuesta",
                                                "required" => "required",
                                                "autocomplete" => "off"
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        {{-- Prueba idioma --}}
                        @elseif($pregunta->tipo_id == 4)
                        {{-- Selección múltiple con única respuesta --}}
                        @else

                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <label class="mb-1 black" style="text-transform: uppercase;">
                                            {{ ++$index }}- {{ ucfirst($pregunta->descripcion) }}
                                        </label>

                                        <div class="form-group">
                                            {!! Form::hidden("pregunta_unica_id[$pregunta->id]", $pregunta->id) !!}

                                            {{-- Lista respuestas --}}
                                            @foreach($pregunta->respuestas_pregunta() as $count => $respuesta)
                                                <div class="checkbox black">
                                                    <label class="black">
                                                        {{ ++$count }}) 
                                                        {!! Form::radio("respuesta_unica[$pregunta->id]", $respuesta->id, null) !!} 
                                                        {{ $respuesta->descripcion }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endif
                    @endforeach
                </div>
            </div>

            <div style="text-align: center;">
                <button class="btn btn-lg btn-success" type="submit" id="guardar_respuestas_puntaje">Guardar Respuestas</button>
            </div>
        </section>
    {!! Form::close() !!}
@stop