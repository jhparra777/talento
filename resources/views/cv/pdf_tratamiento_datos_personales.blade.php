<!DOCTYPE html>
<html>
<head>
    <title>{!! $politica->titulo !!}</title>
</head>
<body>
    <div class="modal-header">
                    <h4 class="modal-title">
                        {!! strip_tags($politica->titulo) !!}
                    </h4>
                </div>
                <div class="modal-body" style="height:400px;overflow:auto;">
                    <div id="texto" style="padding:10px;text-align:justify;margin:10px;font-family:arial;">
                    
                    {!! $politica->texto !!}
                    
                    @if( isset($candidato) )
                        
                        <br/><br/>

                        <p>
                            ACEPTADA POR: {{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}
                        </p>

                        <p>
                            FECHA: 
                            @if( isset($candidato->fecha_acepto_politica) )
                            
                            {{  $candidato->fecha_acepto_politica }}

                            {{ $candidato->hora_acepto_politica }}

                            @else

                            {{ $candidato->fecha_registro }}

                            @endif
                        </p>
                        
                        <p>
                            IP:  {{ isset($candidato->ip_acepto_politica) ? $candidato->ip_acepto_politica : $candidato->ip_registro }}
                        </p>
                    
                    @endif
                    </div>

                </div>

</body>
</html>