{{-- Notese el orden y tabulación de las etiquetas, hace entendible la lectura de la vista y facilita la modificación en caso de ser necesario. --}}
<div class="question-paginate">
    <div class="question-items">
        @foreach ($prueba_questions as $question)
            <div class="panel panel-info mt-2">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ $question->descripcion }}
                        <i 
                            class="text-right fa fa-info-circle" 
                            data-toggle="tooltip" 
                            data-placement="right" 
                            title="Presiona para seleccionar la cantidad de estrellas para dar un valor de 0 a 6 estrellas a cada premisa."
                        ></i>
                    </h3>
                </div>

                <table class="table">
                    <tr>
                        <td width="50%" class="br-2 ancho-celda">{{ $question->premisa_1 }}</td>
                        <td width="50%" class="bl-2 ancho-celda">{{ $question->premisa_2 }}</td>
                    </tr>
                    <tr>
                        <td width="50%" class="br-2 bt-0">
                            <div
                                class="rateYoLeft pull-right"
                                id="star-{{ $question->id }}-premisa_1"
                                data-inverso="star-{{ $question->id }}-premisa_2"
                                data-input="preg_id-{{ $question->id }}-premisa_1"
                                data-inputinverso="preg_id-{{ $question->id }}-premisa_2"
                            ></div>
                            <input type="hidden" name="preg_id-{{ $question->id }}-premisa_1" id="preg_id-{{ $question->id }}-premisa_1">
                        </td>
                        <td width="50%" class="bl-2 bt-0">
                            <div
                                class="rateYoRight"
                                id="star-{{ $question->id }}-premisa_2"
                                data-inverso="star-{{ $question->id }}-premisa_1"
                                data-input="preg_id-{{ $question->id }}-premisa_2"
                                data-inputinverso="preg_id-{{ $question->id }}-premisa_1"
                            ></div>
                            <input type="hidden" name="preg_id-{{ $question->id }}-premisa_2" id="preg_id-{{ $question->id }}-premisa_2">
                        </td>
                    </tr>
                    <tr>
                        <td width="50%" class="br-2 bt-0 pt-0">
                            <span class="small pull-right" id="preg_id-{{ $question->id }}-premisa_1_star"></span>
                        </td>
                        <td width="50%" class="bl-2 bt-0 pt-0">
                            <span class="small" id="preg_id-{{ $question->id }}-premisa_2_star"></span>
                        </td>
                    </tr>
                </table>
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