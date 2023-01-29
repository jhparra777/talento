{{-- Notese el orden y tabulación de las etiquetas, hace entendible la lectura de la vista y facilita la modificación en caso de ser necesario. --}}
<div class="question-paginate">
    <div class="question-items">
        @foreach ($brig_questions as $question)
            <div class="panel panel-info mt-2">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ $question->descripcion }}
                        <i 
                            class="text-right fa fa-question-circle" 
                            data-toggle="tooltip" 
                            data-placement="right" 
                            title="No debes contestar con el mismo número de estrellas a dos opciones de respuesta en la misma pregunta, por ejemplo, si la opción de respuesta uno tiene 4 estrellas las demás opciones de respuesta no pueden tener 4 estrellas."
                        ></i>
                    </h3>
                </div>

                <ul class="list-group">
                    {{-- Buscar las opciones de respuesta de cada pregunta --}}
                    @foreach ($question->getAnswerOptions as $option)
                        <li class="list-group-item">
                            <form id="rating_form_{{ $option->brig_preg_id }}_{{ $option->letra }}">
                                <div class="d-inline-block">
                                    <i class="fas fa-minus icon-minus"></i>
                                    <div class="rating-control">
                                        {{-- Básico --}}
                                        <input
                                            type="radio"
                                            class="rating_class_{{ $option->brig_preg_id }}"
                                            name="rating_{{ $option->brig_preg_id }}_{{ $option->letra }}"
                                            id="rating_id_{{ $option->brig_preg_id }}_{{ $option->letra }}_4"
                                            data-pregunta="{{ $option->brig_preg_id }}"
                                            value="4"
                                            autocomplete="off"
                                            required

                                            {{-- Preguntas AUMENTED --}}
                                            @if ($question->id == 31 || $question->id == 32 || $question->id == 33 || $question->id == 34 ||
                                                $question->id == 35 || $question->id == 36 || $question->id == 37 || $question->id == 38)
                                                @if ($option->letra == 'A')
                                                    onclick="toA(this)"
                                                @elseif($option->letra == 'B')
                                                    onclick="toP(this)"
                                                @elseif($option->letra == 'C')
                                                    onclick="toD(this)"
                                                @elseif($option->letra == 'D')
                                                    onclick="toR(this)"
                                                @endif
                                            {{-- Preguntas --}}
                                            @else
                                                @if ($option->letra == 'A')
                                                    onclick="toRadical(this)"
                                                @elseif($option->letra == 'B')
                                                    onclick="toGenuino(this)"
                                                @elseif($option->letra == 'C')
                                                    onclick="toGarante(this)"
                                                @elseif($option->letra == 'D')
                                                    onclick="toBasico(this)"
                                                @endif
                                            @endif
                                        >
                                        <label 
                                            for="rating_id_{{ $option->brig_preg_id }}_{{ $option->letra }}_4" 
                                            data-start="rating_class_{{ $option->brig_preg_id }}" 
                                            data-value="4"
                                            title=""
                                        >4</label>

                                        {{-- Garante --}}
                                        <input
                                            type="radio"
                                            class="rating_class_{{ $option->brig_preg_id }}"
                                            name="rating_{{ $option->brig_preg_id }}_{{ $option->letra }}"
                                            id="rating_id_{{ $option->brig_preg_id }}_{{ $option->letra }}_3"
                                            data-pregunta="{{ $option->brig_preg_id }}"
                                            value="3"
                                            autocomplete="off"
                                            required

                                            {{-- Preguntas AUMENTED --}}
                                            @if ($question->id == 31 || $question->id == 32 || $question->id == 33 || $question->id == 34 ||
                                                $question->id == 35 || $question->id == 36 || $question->id == 37 || $question->id == 38)
                                                @if ($option->letra == 'A')
                                                    onclick="toA(this)"
                                                @elseif($option->letra == 'B')
                                                    onclick="toP(this)"
                                                @elseif($option->letra == 'C')
                                                    onclick="toD(this)"
                                                @elseif($option->letra == 'D')
                                                    onclick="toR(this)"
                                                @endif
                                            {{-- Preguntas --}}
                                            @else
                                                @if ($option->letra == 'A')
                                                    onclick="toRadical(this)"
                                                @elseif($option->letra == 'B')
                                                    onclick="toGenuino(this)"
                                                @elseif($option->letra == 'C')
                                                    onclick="toGarante(this)"
                                                @elseif($option->letra == 'D')
                                                    onclick="toBasico(this)"
                                                @endif
                                            @endif
                                        >
                                        <label 
                                            for="rating_id_{{ $option->brig_preg_id }}_{{ $option->letra }}_3" 
                                            data-start="rating_class_{{ $option->brig_preg_id }}" 
                                            data-value="3"
                                            title=""
                                        >3</label>

                                        {{-- Genuino --}}
                                        <input
                                            type="radio"
                                            class="rating_class_{{ $option->brig_preg_id }}"
                                            name="rating_{{ $option->brig_preg_id }}_{{ $option->letra }}"
                                            id="rating_id_{{ $option->brig_preg_id }}_{{ $option->letra }}_2"
                                            data-pregunta="{{ $option->brig_preg_id }}"
                                            value="2"
                                            autocomplete="off"
                                            required

                                            {{-- Preguntas AUMENTED --}}
                                            @if ($question->id == 31 || $question->id == 32 || $question->id == 33 || $question->id == 34 ||
                                                $question->id == 35 || $question->id == 36 || $question->id == 37 || $question->id == 38)
                                                @if ($option->letra == 'A')
                                                    onclick="toA(this)"
                                                @elseif($option->letra == 'B')
                                                    onclick="toP(this)"
                                                @elseif($option->letra == 'C')
                                                    onclick="toD(this)"
                                                @elseif($option->letra == 'D')
                                                    onclick="toR(this)"
                                                @endif
                                            {{-- Preguntas --}}
                                            @else
                                                @if ($option->letra == 'A')
                                                    onclick="toRadical(this)"
                                                @elseif($option->letra == 'B')
                                                    onclick="toGenuino(this)"
                                                @elseif($option->letra == 'C')
                                                    onclick="toGarante(this)"
                                                @elseif($option->letra == 'D')
                                                    onclick="toBasico(this)"
                                                @endif
                                            @endif
                                        >
                                        <label 
                                            for="rating_id_{{ $option->brig_preg_id }}_{{ $option->letra }}_2" 
                                            data-start="rating_class_{{ $option->brig_preg_id }}" 
                                            data-value="2"
                                            title=""
                                        >2</label>

                                        {{-- Radical --}}
                                        <input
                                            type="radio"
                                            class="rating_class_{{ $option->brig_preg_id }}"
                                            name="rating_{{ $option->brig_preg_id }}_{{ $option->letra }}"
                                            id="rating_id_{{ $option->brig_preg_id }}_{{ $option->letra }}_1"
                                            data-pregunta="{{ $option->brig_preg_id }}"
                                            value="1"
                                            autocomplete="off"
                                            required

                                            {{-- Preguntas AUMENTED --}}
                                            @if ($question->id == 31 || $question->id == 32 || $question->id == 33 || $question->id == 34 ||
                                                $question->id == 35 || $question->id == 36 || $question->id == 37 || $question->id == 38)
                                                @if ($option->letra == 'A')
                                                    onclick="toA(this)"
                                                @elseif($option->letra == 'B')
                                                    onclick="toP(this)"
                                                @elseif($option->letra == 'C')
                                                    onclick="toD(this)"
                                                @elseif($option->letra == 'D')
                                                    onclick="toR(this)"
                                                @endif
                                            {{-- Preguntas --}}
                                            @else
                                                @if ($option->letra == 'A')
                                                    onclick="toRadical(this)"
                                                @elseif($option->letra == 'B')
                                                    onclick="toGenuino(this)"
                                                @elseif($option->letra == 'C')
                                                    onclick="toGarante(this)"
                                                @elseif($option->letra == 'D')
                                                    onclick="toBasico(this)"
                                                @endif
                                            @endif
                                        >
                                        <label 
                                            for="rating_id_{{ $option->brig_preg_id }}_{{ $option->letra }}_1" 
                                            data-start="rating_class_{{ $option->brig_preg_id }}" 
                                            data-value="1"
                                            title=""
                                        >1</label>
                                    </div>
                                    <i class="fas fa-plus icon-plus"></i>
                                </div>

                                <p class="question-desc">{{ $option->descripcion }}</p>

                                {{-- Botón que resetea las estrellas --}}
                                <input type="reset" value="resetear" id="rating_{{ $option->brig_preg_id }}_{{ $option->letra }}" hidden>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
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