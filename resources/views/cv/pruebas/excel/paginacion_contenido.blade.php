{{-- Notese el orden y tabulación de las etiquetas, hace entendible la lectura de la vista y facilita la modificación en caso de ser necesario. --}}
<div class="question-paginate">
    <div class="question-items">
        @foreach ($excel_questions as $question)
            <div class="panel panel-info mt-2">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ $question->descripcion }}
                        <i 
                            class="text-right fa fa-info-circle" 
                            data-toggle="tooltip" 
                            data-placement="right" 
                            title="Debes seleccionar la opción que consideres correcta."
                        ></i>
                    </h3>
                </div>

                <ol class="list-group" type="a">
                    {{-- Buscar las opciones de respuesta de cada pregunta --}}
                    @foreach ($question->getOpciones as $opcion)
                        <li class="list-group-item">
                            <label><input type="radio" name="preg_id_{{ $opcion->id_pregunta }}" value="{{ $opcion->id }}"> {!! $opcion->descripcion !!} </label>
                        </li>
                    @endforeach
                </ol>
            </div>
        @endforeach
    </div>

    <div class="col-md-12 mt-2 mb-1 text-center" id="buttonBox" hidden>
        <button class="btn btn-success btn-lg" type="button" id="saveTest">Finalizar prueba</button>
    </div>

    <div class="pager mt-3 mb-3" id="paginationButtonBox">
        <div class="btn-group btn-group-lg" role="group" aria-label="...">
            <button type="button" class="previousPage btn btn-primary">
                <i class="fas fa-chevron-circle-left"></i> Anterior
            </button>
            <button type="button" class="nextPage btn btn-default btn-primary">
                Siguiente <i class="fas fa-chevron-circle-right"></i>
            </button>
        </div>

        <div class="question-page-numbers mt-1"></div>
    </div>
</div>