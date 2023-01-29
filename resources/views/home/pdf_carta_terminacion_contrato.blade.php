<!DOCTYPE html>
<html>
<head>
	<title>Carta Terminación Contrato</title>
	<style>
    html{
        font-family: 'Arial';
    }

    @page{
        margin: 10mm 30mm;
    }

    body{
        font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
        font-size: 10pt;
        line-height: 1.2;
        color: black;
        background-color: #fff;
    }

    .mt-1{ margin-top: 1rem; }
    .mt-2{ margin-top: 2rem; }
    .mt-3{ margin-top: 3rem; }
    .mt-4{ margin-top: 4rem; }

    .mb-1{ margin-bottom: 1rem; }
    .mb-2{ margin-bottom: 2rem; }
    .mb-3{ margin-bottom: 3rem; }
    .mb-4{ margin-bottom: 4rem; }

    .text-center{ text-align: center;  }
    .text-left{ text-align: left;  }
    .text-right{ text-align: right;  }
    .text-light{ font-weight: lighter; }
    .text-justify{ text-align: justify; }


    .center{ margin: auto; }

    .table{
        border-collapse:separate; 
        /*border-spacing: 6px;*/
    }

    .blue{ color: blue; }

    .bg-image {
    	background-image: url("{{  url('img/pdf-bg.png') }}"); 
		background-repeat: no-repeat; 
		background-attachment: fixed;
  		background-position: center;
    }
</style>
</head>
<body>

<div class="center bg-image" style="width: 100%; font-size: 10pt;">
    @if( isset($sitio->logo) )
        <div class=" text-left">
            <img src="{{ asset('configuracion_sitio/'.$sitio->logo) }}" width="80">
        </div>
    @else
    	<div class=" text-left">
            <img src="{{ asset('configuracion_sitio/logo_cargado.png') }}" width="80">
        </div>
    @endif

    <div class="text-right">
    	<p><b>NIT {{$sitio->nit}}</b></p>
    	<hr>
    </div>
    <div>
    	<br/>
        <p>
            Barranquilla, <?php setlocale(LC_TIME, 'es_ES.UTF-8'); echo strftime("%d de %B de %Y") ?>
        </p>
        <br/>
        <p><b>Señor(a),</b></p>
        <p><b>{{ $candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido }}</b></p>
        <p><b>Ciudad</b></p>
    </div>

    <div>
        <div style="text-align: justify;">
            <div style="text-align: justify;">
                <p>
                    <b>Asunto: Previo aviso a la terminación de su contrato a término fijo. </b>
                </p>
                <p>
                    Cordial saludo, 
                </p>
                <p>
                    Por medio de la presente y en cumplimiento de nuestras obligaciones, le informamos que el próximo <?php echo strftime("%d del mes de %B del año %Y", strtotime($fecha_fin_contrato)) ?> su contrato laboral a término fijo termina.
                </p>
                <p>
                    En los términos establecidos por la legislación laboral, este aviso se hace con 30 días de antelación a la fecha de terminación del mismo, según lo establece el Código Sustantivo de Trabajo 
                </p>

                <p>
                    A la terminación de su contrato se procederá a la liquidación de sus prestaciones sociales  que serán depositadas en la cuenta bancaria registrada y autorizada por Ud
                </p>

                <p>
                    Agradecemos los servicios prestados durante este tiempo. 
            	</p>
            </div>
        </div>
    </div>

	<table class="center table" width="80%">
            <tr>
                <td width="40%">
                    <div style="width: 100%; margin: 4em; margin-left: left;">
                        Atentamente,
                        <br/><br/><br/><br/><br/>
                        <p>________________________________</p>
                        &nbsp;
                        <br/>
                        C.C <br/>
                        Empleador
                        <br>
                    </div>
                </td>
                <td width="20%"></td>
                <td width="40%">
                    <div style="width: 100%; margin: 4em;">
                        Recibido
                        <br/><br/><br/><br/><br/>
                        <p>________________________________</p>
                        {{ $candidato->nombres }} {{$candidato->primer_apellido }} {{ $candidato->segundo_apellido }}
                        <br/>
                        {{ $candidato->cod_tipo}} {{ $candidato->numero_id }}
                        <br/>
                        Trabajador(a)
                    </div>
                </td>
            </tr>
        </table>

</div>

<div class="center" style="width: 100%; opacity: .5; position: fixed; bottom: 50px;">
        <div class="text-center">
            <hr/>
            <span style="float: left;">CARRERA 49C No 74 62</span>
            <span style="float: right;">TEL: 3856338 -3176363811</span>

            <p class="text-center" style="line-height: 0.5;">
                Barranquilla- Atlántico
            </p>
            <p class="text-center" style="line-height: 0.4;">
                www.ayudatemporal.com
            </p>
        </div>      
</div>

</body>
</html>