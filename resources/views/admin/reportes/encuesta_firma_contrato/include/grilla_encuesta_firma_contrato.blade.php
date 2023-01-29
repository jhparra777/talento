@if(method_exists($data, 'total'))
<h4>
    Total de Registros:
    <span>
        {{$data->total()}}
    </span>
</h4>
@endif
<div class="table-responsive">
    <table class="table table-bordered">
        <tr>
            @foreach( $headers as $key => $value )
            <th class="active">
                {{ $value }}
            </th>
            @endforeach
        </tr>

        @foreach( $data as $field )
        	@if ($field->respuestas != null)
	        	<?php
	        		$respuestas = json_decode($field->respuestas, true);
	        	?>
	            <tr>
	                <td>
	                    {{$field->nombres}}
	                </td>
	                <td>
	                    {{$field->primer_apellido}} {{$field->segundo_apellido}}
	                </td>
	                <td>
	                    {{$field->numero_id}}
	                </td>
	                <td>
	                    {{$field->cargo}}
	                </td>
	                <td>
	                    {{$field->cliente}}
	                </td>
	                <td>
	                    {{$field->fecha_firma_contrato}}
	                </td>
	                <td>
	                    {{$field->fecha_respuesta}}
	                </td>
	                @foreach ($columnas_datos as $question)
	                	<?php
	                		$opciones = $question->getOptionActive;
	                		$id_pregunta = "preg_id_$question->id";
	                	?>
	                	<td>
	                		@if($question->tipo == 'archivo' && !isset($formato))
	                            @if ($respuestas["$id_pregunta"] != '' && $respuestas["$id_pregunta"] != null)
	                                <?php
	                                    $url = route('view_document_url', encrypt('recursos_encuesta_sociodemografica/'.'|'.$respuestas["$id_pregunta"]));
	                                ?>
	                                <a href="{{ $url }}" target="_blank"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>
	                            @endif
	                        @elseif($question->tipo == 'archivo' && isset($formato))
	                        	@if ($respuestas["$id_pregunta"] != '' && $respuestas["$id_pregunta"] != null)
	                        		Cargó archivo
	                        	@endif
	                        @else
	                        	@if($question->tipo == 'abierta' || $question->tipo == 'abierta_numerica')
	                        		@if($question->tipo == 'abierta_numerica' && $question->simbolo_numerico != null && $respuestas["$id_pregunta"] != null)
	                        			{{ $question->simbolo_numerico }}
	                        		@endif
	                				{{ $respuestas["$id_pregunta"] }}
	                			@elseif($question->tipo == 'seleccion')
	                				<?php
	                					$resp_descripcion = $opciones->where('id', $respuestas["$id_pregunta"]);
	                				?>
	                				{{ (count($resp_descripcion) > 0 ? $resp_descripcion[0]->descripcion : '') }}
	                			@endif
	                        @endif
	                	</td>
	                @endforeach
	            </tr>
        	@endif
        @endforeach
    </table>
</div>
@if(method_exists($data, 'appends'))
	<div>
    	{!! $data->appends(Request::all())->render() !!}
	</div>
@endif
