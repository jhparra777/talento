<div>
    @if(isset($isPDF))
        <div style="text-align: justify; padding-bottom: 3em; line-height: 2em;">
            @if(isset(FuncionesGlobales::sitio()->logo))
                <img class="center fixedwidth"
                    align="center"
                    border="0"
                    src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}"
                    alt="Image"
                    title="Image"
                    style="clear: both; border: 0; height: auto; float: left;" width="150"
                >
            @else
                <img class="center fixedwidth"
                    align="center"
                    border="0"
                    src="{{ url("img/logo.png")}}"
                    alt="Image"
                    title="Image"
                    style="clear: both; border: 0; height: auto; float: left;" width="150"
                >
            @endif
        </div>
    @endif

    <br>

    <div>
        <h2 style="font-weight: bold;text-align: center;">ACTA DE COMPROMISO</h2>
    </div>

    <br><br>

    <div>
        <p style="text-align: justify; padding-bottom: 3em; line-height: 2em;">
            Yo, {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}, identificado(a) con {{ucwords(mb_strtolower($candidato->dec_tipo_doc))}} número {{ $candidato->numero_id }} @if(!empty($lugarexpedicion))de {{ $lugarexpedicion->value }} @endif, me comprometo a seguir las recomendaciones médicas generadas en el examen médico ocupacional, cumpliendo así el artículo 2.2.4.6.10, numeral 1, del Decreto 1072 de 2015, que establece como responsabilidad de los trabajadores "Procurar el cuidado integral de su salud".
        </p>

        <p style="text-align: center; padding-bottom: 1em; line-height: 2em; font-style: italic;">
            Señor(a) trabajador(a) agradecemos dar cumplimiento a las siguientes recomendaciones y/o restricciones generadas por el medico laboral en su certificado médico ocupacional de ingreso:
        </p>

        <p style="text-align: justify; padding-bottom: 3em; line-height: 2em; font-weight: 600;">
            @if (isset($recomendaciones))
                {!! $recomendaciones !!}
            @endif
        </p>

        <p>
            Se firma en {{ucwords(mb_strtolower($requerimiento->ciudad_req()))}} a los ({{date('d')}}) días del mes de <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime("%B del año %Y") ?> </p>
        </p>
    </div>

    <br><br>

    <div style="">
        <table class="tabla" width="80%" style="border: none !important;">
            <tr>
                <td width="40%">
                    <p>Por la parte receptora:</p><br>
                    <p>
                        @if(isset($firma)) <img src="{{$firma}}" width="220" style="margin:0;"> @endif 
                        <br> ________________________________
                    </p>
                    <p> {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }} </p>
                    <p>{{ucwords(mb_strtolower($candidato->dec_tipo_doc))}}:{{$candidato->numero_id}}</p>
                </td>
            </tr>
        </table>
    </div>
</div>