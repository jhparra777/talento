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

    {!! Form::open(["route" => "home.guardar_respuestas", "method" => "POST"]) !!}
        <section id="work" name="work" class="find-job section">
            <div class="container">
                <h3 class="mb-2 black">Preguntas</h3>

                <div class="row">
                    {{-- Pregunta filtro --}}
                    @if($pregunta->tipo_id == 2)
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <label class="mb-1 black" style="text-transform: uppercase;">
                                        {{ ucfirst($pregunta->descripcion) }}
                                    </label>

                                    <div class="form-group">
                                        {!! Form::hidden("preg_req_id", $pregunta->id) !!}
                                        {!! Form::hidden("req_id", $req_id) !!}
                                        {!! Form::hidden("cargo_id", $cargo_id) !!}

                                        {{-- Lista respuestas --}}
                                        @foreach($pregunta->respuestas_pregunta() as $index => $respuesta)
                                            <div class="checkbox black">
                                                <label class="black">
                                                    {!! Form::radio("respuesta_filtro[$pregunta->id]", $respuesta->id, null) !!} 
                                                    {{ $respuesta->descripcion }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div style="text-align: center;">
                <button class="btn btn-lg btn-success" type="submit" id="guardar_respuestas" >Guardar Respuestas</button>
            </div>
        </section>
    {!! Form::close() !!}
@stop