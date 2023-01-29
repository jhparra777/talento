<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="{{csrf_token()}}" name="token">
    {{-- <title>
        @if(isset($sitio->nombre))
                @if($sitio->nombre != "")
                    {{ $sitio->nombre }} - Firma contrato
                @else
                    Desarrollo | Firma contrato
                @endif
        @else
                Desarrollo | Firma-contrato
        @endif
    </title>

     @if($sitio->favicon)
            @if($sitio->favicon != "")
                <link href="{{ url('configuracion_sitio')}}/{{$sitio->favicon }}" rel="shortcut icon">
            @else
                <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
            @endif
    @else
            <link href="{{ url('img/favicon.png') }}" rel="shortcut icon">
    @endif --}}

    {{-- drawingboard CSS --}}
    <link rel="stylesheet" type="text/css" href="{{ asset('js/drawingboard/drawingboard.min.css') }}">

    <script src="https://code.jquery.com/jquery-3.4.1.js" type="text/javascript"></script>

    {{-- drawingboard JS --}}
    <script src="{{ asset('js/drawingboard/drawingboard.min.js') }}" type="text/javascript"></script>

    <style>
        html{
            font-family: 'Arial';
        }

        body{
            /*font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 14px;
            line-height: 1.42857143;
            color: #333;
            background-color: #fff;*/
        }

        /*.btn{
            text-decoration: none;
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
                border-top-color: transparent;
                border-right-color: transparent;
                border-bottom-color: transparent;
                border-left-color: transparent;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

        .btn-success{
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-secondary{
            color: #fff;
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-warning{
            color: #fff;
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-danger{
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-secondary:hover{
            color: #fff;
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-success:hover{
            color: #fff;
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn:not(:disabled):not(.disabled){
            cursor: pointer;
        }

        .btn:focus, .btn:hover{
            text-decoration: none;
        }*/

        .text-center{ text-align: center;  }
        .text-left{ text-align: left;  }
        .text-right{ text-align: right;  }
        .text-light{ font-weight: lighter; }

        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .pd-1{ padding: 1rem; }

        .center{ margin: auto; }

        /*.table{
            border-collapse:separate; 
            border-spacing: 0 1em;
        }*/

        .mb-2{
            margin-bottom: 2rem;
        }

        .justify{ text-align: justify; }

        .list{ list-style: none; }
        /*.space{ line-height: 22px; }*/
    </style>
</head>
<body>

    <table width="100%" class="mt-4">
        <tr>
            <th width="10%"></th>

            <th class="text-left">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                        <img src="{{ asset('configuracion_sitio/'.$empresa_contrata->logo) }}" width="100" >
                    @endif
                @endif
            </th>

            <th class="text-right text-light">
                Fecha: <strong>{{$fecha}}</strong>
            </th>

            <th width="10%"></th>
        </tr>
    </table>

    <table width="100%" class="mt-4">
        <tr>
            <th class="text-center">
                <p>Firma de contrato</p>
            </th>
        </tr>

        <tr>
            <td class="text-center mt-1">
                {{$candidato->nombres}} {{$candidato->primer_apellido}} {{$candidato->segundo_apellido}}
            </td>
        </tr>
    </table>

    <table class="mt-4 mb-2" width="100%">
        <tr>
            <th class="text-center">
                <p>CONTRATO DE TRABAJO A TÉRMINO INDEFINIDO</p>
            </th>
        </tr>
    </table>

    <table class="center table-contract justify" width="95%">
        <tr class="pd-1">
            <th class="text-left">
                Nombre del Empleador:
            </th>
            
            <td>
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                        {{ $empresa_contrata->nombre_empresa }}
                    @endif
                @endif
            </td>

            <th class="text-left">
                NIT del Empleador:
            </th>
            
            <td colspan="2">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                        {{ $empresa_contrata->nit }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Domicilio del Empleador:
            </th>
            
            <td>
                {{ $reqcandidato->agencia_direccion }}
            </td>

            <th class="text-left">
                Ciudad:
            </th>
            
            <td colspan="2">
                {{ $reqcandidato->nombre_ciudad }}
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Teléfono:
            </th>
            
            <td colspan="4">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                        {{ $empresa_contrata->telefono }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Nombre y Apellidos del trabajador:
            </th>
            
            <td colspan="4">
                {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Identificación:
            </th>

            <td colspan="4">
              {{ ucwords(mb_strtolower($candidato->dec_tipo_doc))}}
                {{ $candidato->numero_id }}
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Lugar y Fecha de Nacimiento:
            </th>
            
            <td colspan="4">
                {{ $candidato->fecha_nacimiento }}

                @if($lugarnacimiento != null)
                  {{$lugarnacimiento->value }}
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Dirección del Trabajador:
            </th>
            
            <td>
                {{ $candidato->direccion }}
            </td>

            <th class="text-left">
                Correo electrónico de notificaciones: 
            </th>

            <td colspan="2">
                {{ $candidato->email }}
            </td>

        </tr>

        <tr>
            <th class="text-left">
                Ciudad:
            </th>
            
            <td>
                @if($lugarresidencia != null)
                    {{ $lugarresidencia->value }}
                @endif
            </td>

            <th class="text-left">
                Teléfono:
            </th>
            
            <td colspan="2">
                {{ $candidato->telefono_movil }}
            </td>           
        </tr>

        <tr>
            <th class="text-left">
                Afiliación:
            </th>
            
            <td colspan="4">
                <b>ARL:</b>AXA COLPATRIA  <b>AFP:</b> {{ $candidato->entidades_afp_des }} <b>EPS:</b> {{ $candidato->entidades_eps_des }}
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Cargo:
            </th>

            <td colspan="4">
                {{ $reqcandidato->nombre_cargo_especifico }}
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Fecha de inicio:
            </th>

            <td colspan="4">
                {{ $fechasContrato->fecha_ingreso }}
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Salario Básico:
            </th>

            <td>
                $ {{ number_format($reqcandidato->salario) }}
            </td>

            <th class="text-left">
                Tipo Salario:
            </th>
            
            <td colspan="2">
                {{ $reqcandidato->descripcion_tipo_salario }}
            </td>
        </tr>

        <tr>
            <th class="text-left">Adicionales:</th>

            <td colspan="4">{{ $reqcandidato->adicionales_salariales }}</td>
        </tr>

        <tr>
            <th class="text-left">
                 Períodos de pagos:
            </th>

            <td colspan="4">
                {{ $reqcandidato->descripcion_tipo_liquidacion }}
            </td>
        </tr>
    </table>

    <table class="center table-contract justify mt-2" width="95%">

        {!! isset($cuerpo_contrato) ? $cuerpo_contrato->cuerpo_contrato : "" !!}

        {{--
            <tr>
                <td>
                    Entre El Empleador y El Trabajador, de las condiciones ya dichas, identificados como aparece al pie de sus firmas, se ha celebrado el presente contrato individual de trabajo, regido además por las siguientes cláusulas:
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    <strong>PRIMERA.-OBLIGACIONES</strong>: El Empleador contrata los servicios personales del Trabajador y éste se obliga:
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    a) A poner al servicio del Empleador toda su capacidad normal de trabajo, en forma exclusiva en el desempeño de las funciones propias del oficio mencionado y en las labores anexas y complementarias del mismo, de conformidad con las órdenes e instrucciones que le imparta el Empleador o sus representantes
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    b) Cumplir con sus obligaciones de manera cuidadosa y diligente en el lugar tiempo y necesidades del servicio.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    c) Observar rigurosamente la disciplina interna establecida por el empleador y las persona autorizadas por este.
                </td>
            </tr>

            <tr>
                <td> 
                    <br/><br/>
                    d) A no prestar directa ni indirectamente servicios laborales a otros Empleadores, ni a trabajar por cuenta propia en el mismo oficio, durante la vigencia de este contrato, so pena de recibir sanciones disciplinarias y legales que la norma laboral faculta al empleador.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    e) Informar al empleador oportunamente y por escrito, el cambio de su domicilio que será el lugar donde recibirá las notificaciones de que habla la Ley 789 de 2.002. Por tal razón cualquier información o notificación será remitida a la dirección señalada en el encabezado de este contrato y se entenderá recibido por el trabajador mientras que tal dirección no haya sido modificada e informada al empleador.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    f) Laborar la jornada ordinaria, en los turnos y dentro de las horas señaladas por el empleador, o sus representantes, pudiendo hacer éstos los ajustes o cambios de horarios cuando lo estimen conveniente. Por acuerdo expreso o tácito de las partes, podrán repartirse las horas de la jornada ordinaria, en la forma prevista en el artículo 164 del C.S.T., teniendo en cuenta que los tiempos de descanso entre las secciones de la jornada, no se computan dentro de la misma, según el artículo 167 ibidem. Cualquier hora extra o trabajo adicional deberá ser autorizado por el empleador.

                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    g) Cuidar permanentemente los intereses del empleador. 
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    h) Programar diariamente su trabajo y asistir puntualmente a las reuniones que efectúe el empleador a las cuales hubiere sido citado. 
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    i). -Observar completa armonía y comprensión con sus superiores y compañeros de trabajo, en sus relaciones personales y en la ejecución de su labor. 
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    j) Actuar permanentemente con espíritu de lealtad, colaboración y disciplina con el empleador.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    k) A presentar dentro de las 48 horas siguiente ante el empleador, la justificación de su ausencia al puesto de trabajo causado por la incapacidad médica, certificada por el medico adscrito a la EPS o ARL donde se encuentre afiliado.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    l) Velar por el cuidado de las instalaciones de del empleador, así como también los equipos, muebles, enseres y demás elementos entregados para el cumplimiento de sus funciones, con el fin de evitar daños y extravíos.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    m).- Cumplir con los planes de trabajo que se indique por parte del empleador, bien sea por escrito o por recomendaciones verbales.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    n) Utilizar los elementos de protección personal que le sean entregados para el desarrollo de sus funciones y en cumplimiento de las normas de Seguridad y Salud en el Trabajo. 
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    ñ) Cumplir con el Reglamento Interno de Trabajo del empleador
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    o) Reportar de manera inmediata al empleador la ocurrencia de accidente de trabajo.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    p) Las demás funciones que se le indiquen oportunamente. Parágrafo: Se considera hecho grave para el Trabajador el haber tenido conocimiento o participación, por acción, omisión, negligencia o complicidad, en comportamiento o hechos delictivos o en contra de la moral, que perjudiquen los intereses del empleador, sus funcionarios, clientes o allegados, o el hecho de tener conocimiento de ellos y no informar oportunamente al empleador, a sus representantes o dar informaciones falsas o extemporáneas sobre los mismos. El trabajador manifiesta expresamente como condición esencial para la firma de este contrato, que no ha tenido vínculos directos ni indirectos con actividades tales como el terrorismo, la subversión, el tráfico de estupefacientes o la delincuencia común y es justa causa suficiente para dar por terminado éste contrato en forma unilateral por parte del empleador, el hecho de que el trabajador no haya suministrado información verídica al respecto, como también información exacta en la hoja de datos personales o en la solicitud de empleo, diligenciadas previamente a la firma del contrato, documentos que hacen parte integral del mismo.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    <strong>SEGUNDA.- DURACIÓN.-. DURACIÓN.</strong> - Vencido el periodo de prueba, el término de duración del presente contrato será indefinido, mientras subsistan las causas que le dieron origen y la materia del trabajo.
                </td>
            </tr> 

            <tr>
                <td>
                    <br/><br/>
                    <strong>TERCERA. - PERÍODO DE PRUEBA</strong> Los primeros (2) dos meses del presente contrato se consideran como período de prueba y, por consiguiente, El Empleador podrá terminar el contrato unilateralmente, en cualquier momento durante dicho período, sin necesidad de preaviso y su efecto no podrá producir derecho a indemnización.
                </td>
            </tr> 

            <tr>
                <td>
                    <br/><br/>
                    <strong>INCORPORACIÓN DE DISPOSICIONES.</strong> - Las partes declaran que en el presente contrato se entienden incorporadas, en lo pertinente, las disposiciones legales que regulan las relaciones entre la empresa y sus trabajadores, en especial, las del contrato de trabajo para el oficio que se suscribe y las obligaciones consignadas en los reglamentos de trabajo y de higiene y seguridad industrial del empleador, disposiciones que manifiesta conocer y se compromete a acatar. 
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    <strong>QUINTA. - REMUNERACIÓN.</strong> - El Empleador pagará al Trabajador por la prestación de sus servicios bajo la modalidad arriba citada, la cual será pagadera en las oportunidades que se indican en el encabezamiento de este contrato. Dentro de este pago se encuentra incluida la remuneración de los descansos dominicales y festivos de que tratan los capítulos I y II del título VII del Código Sustantivo del Trabajo. Se aclara y se conviene que en los casos en los que El Trabajador llegare a devengar comisiones o cualquiera otra modalidad de salario variable, el 82.5% de dichos ingresos, constituye remuneración ordinaria, y el 17.5% restante está destinado a remunerar el descanso en los días dominicales y festivos de que tratan los capítulos I y II del título VII del Código Sustantivo del Trabajo.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                    <strong>SEXTA.- NO CONSTITUYE SALARIO</strong>.- En atención a lo ordenado por el artículo 128 del Código Sustantivo del Trabajo, modificado por el artículo 15 de la Ley 50 de 1990, las partes en el presente contrato convienen de manera expresa que no constituyen salario las sumas en dinero o en especie que ocasionalmente y por mera liberalidad recibe o llegue a recibir en el futuro adicional a su salario ordinario, el trabajador del empleador como propinas, primas, bonificaciones o gratificaciones ocasionales, participación de utilidades, y lo que recibe en dinero o en especie no para su beneficio como ayudas o auxilios habituales u ocasionales, tales como alimentación, o vestuario, bonificaciones ocasionales o cualquier otra que reciba, durante la vigencia del contrato de trabajo, ni aquellos que se hacen, no para enriquecer su patrimonio, sino para desempeñar a cabalidad sus funciones, como gastos de representación, medios de transporte, elementos de trabajo y otros semejantes. Tampoco constituyen salario las prestaciones sociales de que tratan los títulos VIII y IX del Código Sustantivo del Trabajo, ni los beneficios o auxilios habituales u ocasionales acordados convencional o contractualmente u otorgados en forma extralegal por el empleador, tales como la alimentación, habitación o vestuario, las primas extralegales, de vacaciones, de servicios o de navidad. Igualmente, y conforme lo ordena el artículo 17 de la Ley 344 de 1.996 los pagos aquí señalados, que no constituyen salario no hacen parte de la base para liquidar los aportes con destino al Servicio Nacional de Aprendizaje, SENA, Instituto Colombiano de Bienestar Familiar, ICBF, Escuela Superior de Administración Pública, ESAP, régimen del subsidio familiar y contribuciones a la seguridad social establecidas por la Ley 100 de 1993. Parágrafo: Soportado en el artículo 30 de la Ley 1393 de 2010 y para los efectos relacionados con los artículos 18 y 204 de la ley 100 de 1993, Sentencia C- 521 de 1995, de la Corte Constitucional en y los artículos 15 y 16 de la Ley 50 de 1990, El Empleador y el trabajador podrán convenir el pago de una suma de dinero que no supere el (40%) del total de la remuneración, el cual no constituirá salario pues no se encamina a enriquecer el patrimonio del trabajador.
                </td>
            </tr>

            <tr>
                <td>
                    <br/><br/>
                        <strong>SÉPTIMA. TRABAJO SUPLEMENTARIO</strong>: -Todo trabajo suplementario o en horas extras y todo trabajo en día domingo o festivo en los que legalmente debe concederse descanso, se remunerará conforme a la ley, así como los correspondientes recargos nocturnos. Para el reconocimiento y pago del trabajo suplementario, dominical o festivo El Empleador o sus representantes deben autorizarlo previamente por escrito. Cuando la necesidad de este trabajo se presente de manera imprevista o inaplazable, deberá ejecutarse y darse cuenta de él por escrito, a la mayor brevedad, al Empleador o a sus representantes. El Empleador, en consecuencia, no reconocerá ningún trabajo suplementario o en días de descanso legalmente obligatorio que no haya sido autorizado previamente o avisado inmediatamente, como queda dicho.
                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>OCTAVA. - JORNADA</strong>: El Trabajador se obliga a laborar la jornada ordinaria en los turnos y dentro de las horas señaladas por El Empleador, pudiendo hacer estos ajustes o cambios de horario cuando lo estime conveniente. Conforme a lo indicado en el artículo 60 del C.S.T modificado por el art. 1 de la Ley 1846 de 2017, el trabajo ordinario será el que se realiza entre las 6 Horas (6 A.M.) y las 21 horas (9 P.M.) y el trabajo nocturno es el comprendido entre las 21 Horas (9 P.M.) y las 6 Horas (6 A.M.). 

                        <br/>
                        <strong>PARÁGRAFO PRIMERO:</strong> Conforme lo indicado por la ley laboral, el empleador y el trabajador podrán acordar temporal o indefinidamente la organización de turnos de trabajo sucesivos que permitan operar a la empresa o secciones de la misma sin solución de continuidad durante todos los días de la semana, siempre y cuando el respectivo turno no exceda de 6 horas al día y 36 a la semana. 

                        <br/>
                        <strong>PARÁGRAFO SEGUNDO:</strong> El empleador y el trabajador, podrán acordar que la jornada semanal de cuarenta y ocho (48) horas se realice mediante jornadas diarias flexibles de trabajo, distribuidas en máximo 6 días a la semana con un día de descanso obligatorio, que podrá coincidir con el domingo. En este, el número de horas de trabajo diario podrá repartirse de manera variable durante la respectiva semana y podrá ser de mínimo cuatro (4) horas continuas y hasta diez (10) horas diarias sin lugar a ningún recargo por trabajo suplementario, cuando el número de horas de trabajo no exceda el promedio de cuarenta y ocho (48) horas semanales dentro de la jornada ordinaria de 6 A.M. a 9 P.M.

                    </td>
                </tr>

                        NOVENA- JUSTA CAUSA.- Son justas causas para dar por terminado unilateralmente este contrato por cualquiera de las partes, las enumeradas en el artículo 7º del Decreto 2351 de 1965; y, además, por parte del Empleador, el incumplimiento de las obligaciones señaladas en la cláusula primera de este contrato, al igual que las faltas que para el efecto se califiquen como graves en el Reglamento Interno de Trabajo y el espacio reservado para cláusulas adicionales en el presente contrato. 

                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        DÉCIMA. TRASLADO DE LUGAR.- -.El empleador podrá determinar que el trabajo se preste en lugar distinto del inicialmente contratado, siempre que tal traslado no desmejore las condiciones laborales o de remuneración del Trabajador, o impliquen perjuicios para él. Los gastos que se originen con el traslado serán cubiertos por El Empleador de conformidad con el numeral 8º del artículo 57 del Código Sustantivo del Trabajo. El Trabajador se obliga a aceptar los cambios de oficio que decida El Empleador dentro de su poder subordinante, siempre que se respeten las condiciones laborales del Trabajador y no se le causen perjuicios. Todo ello sin que se afecte el honor, la dignidad y los derechos mínimos del Trabajador, de conformidad con el artículo 23 del Código Sustantivo del Trabajo, modificado por el artículo 1º de la Ley 50 de 1990. 

                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DÉCIMA PRIMERO. BUENA FE CONTRACTUAL</strong>: Este contrato ha sido redactado estrictamente de acuerdo con la ley y la jurisprudencia y será interpretado de buena fe y en consonancia con el Código Sustantivo del Trabajo, cuyo objeto, definido en su artículo 1º, es lograr la justicia en las relaciones entre Empleadores y Trabajadores dentro de un espíritu de coordinación económica y equilibrio social. 

                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DUODÉCIMA. CONFIDENCIALIDAD</strong>.-. En desarrollo de la labor contratada el TRABAJADOR tendrá acceso de manera directa e indirecta a información de propiedad exclusiva de El Empleador y/o de sus clientes, información que goza de protección especial, atendiendo el grado de confidencialidad de la misma, es por ello que se consagran como obligaciones especiales del trabajador las siguientes: 
                        <br/>
                        1. Toda información otorgada es de propiedad exclusiva de El Empleador. En consecuencia, El Trabajador no utilizará esta información para su propio uso o el de terceros sin autorización. 

                        <br/>2. El Trabajador se obliga a no copiar, editar, transformar, extraer, revelar, divulgar, exhibir, mostrar, comunicar, utilizar y/o emplear para sí, o para otra persona natural o jurídica, la información que le ha sido entregada con ocasión de las labores contratadas o aquella a la que haya tenido acceso por cualquier causa, que sea de propiedad de El Empleador y/o cualquiera de sus clientes. 
                        <br/>
                        3. El Trabajador se obliga en consecuencia a mantenerla reservada y privada y a proteger dicha información para evitar su divulgación no autorizada, ejerciendo sobre ésta, el máximo grado de diligencia y cuidado, faltando a esta obligación por acción o por omisión. 
                        <br/>
                        4. El Trabajador se obliga a responder por todos los documentos, claves de acceso, mercancías, herramientas, software y hardware que le ha sido entregado para el ejercicio de su labor, y en general con la información confidencial que maneje en el desempeño del cargo. 
                        <br/>
                        5. El Trabajador se hace responsable por los perjuicios que pudieren causarse a la empresa o a sus clientes, en virtud del no cumplimiento de estas obligaciones.
                        <br/>
                        6. Todo ello en virtud y armonía de las obligaciones del trabajador previstas en el Código Sustantivo y en el Reglamento Interno de Trabajo. 
                        <br/>
                        7. Cualquier violación a lo pactado dentro de la presente clausula, de confidencialidad, ya por acción o por omisión, será considerada como falta grave, según lo estipulado en el Numeral 6 del artículo 62 CST, y será justa causa de terminación del contrato laboral. 
                        <br/>
                        8. El trabajador manifiesta conocer las políticas internas que se establecen dentro de la empresa alusivas a lo consagrado en la Ley 1266 de 2008, ley estatutaria 1581 de 2012 y decreto reglamentario 1377 de 2013 que contienen la normas sobre protección y manejo de datos personales. 
                        <br/>
                        9. Las obligaciones de confidencialidad previstas en la presente cláusula estarán vigentes en el entretanto lo esté, el contrato laboral y se extenderá, por cinco (5) años más, que se cuentan a partir de la fecha de su terminación. 
                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DÉCIMA TERCERA-. PROTECCIÓN DE DATOS</strong>: Con el fin de dar un adecuado tratamiento de sus datos personales y teniendo como soporte el Decreto 1377 de 2013, reglamentario de la Ley 1581 de 2012 y demás normas que lo modifiquen, actualicen o deroguen, el trabajador  autoriza a el empleador  como responsable de sus datos personales y de mi núcleo familiar correspondiente a los menores de edad en los términos del Art (2.2.2.25.2.9) del Decreto 1074 de 2015, también aquellos datos sensibles obtenidos o que llegue  a obtener en el futuro como son los exámenes médicos, resultados diagnósticos, pruebas de laboratorio y datos de la salud, también datos como fotografías, videograbaciones y audios, incluyendo datos biométricos, suministrados con la firma del presente contrato o los que suministre a futuro con el fin de validar la identidad de El Trabajador. El trabajador autoriza a el empleador no solo a consultar, recolectar y almacenar, sino también a transferir, usar, circular, suprimir, compartir, actualizar y transmitir, de acuerdo con el Procedimiento para el tratamiento de datos personales que declara conocer. Las finalidades de esta autorización comprenden la facultad del empleador para el desempeño en las funciones del Sistema de Gestión de Seguridad y Salud en el Trabajo, evaluar la situación de ingreso y egreso del personal, aptitud, prevención, control y seguimiento a la salud, suministrar la información a terceros con los cuales el empleador  tenga relación contractual y que sea necesario entregársela para el cumplimiento del objeto contratado, realizar campañas promocionales de la entidad, realizar actividades de capacitación, evidenciar actividades y eventos, carnetización, control y auditoria de diferentes actividades, publicación en redes sociales, medir niveles de satisfacción, realizar encuestas, enviar invitaciones a eventos, realizar actualización de datos, ofrecimiento de productos y servicios, comunicar noticias del empleador y sus empresas aliadas, mantener comunicación permanente con ocasión de la relación laboral y/o comercial, comunicar información relacionada con productos para la adquisición de nuestros bienes y servicios, solicitud de documentación e información a trabajadores,  solicitud de documentación o información y las demás actividades propias de la prestación del servicio. El trabajador autoriza mediante la imposición de la huella dactilar en el captor biométrico, explícita e inequívoca a el empleador para el tratamiento de sus datos personales (biográficos y biométricos) dentro de las finalidades aquí contempladas. Las videograbaciones serán utilizadas para monitorear y proteger los activos de la compañía y disuadir la comisión de delitos. El trabajador declara que ha sido informado que como titular, tiene los siguientes derechos: Conocer, actualizar y corregir sus datos Personales, ejercer este derecho, entre otros, en relación con la información, parcial, inexacta, incompleta, dividida, información engañosa o cuyo tratamiento sea prohibido o no autorizado, requerir prueba del consentimiento otorgado para la recolección y el tratamiento de sus datos personales, ser informado por el empleador del uso que se le han dado a sus datos personales, presentar quejas ante la superintendencia de Industria y Comercio en el caso en que haya una violación por parte del empleador, revocar la autorización y/o solicitar la supresión de datos personales a menos que exista un deber legal contractual que haga imperativo conservar la información otorgada para el tratamiento de mis sus datos personales, sobre el concepto de datos sensibles del Art (6) de la Ley 1581 de 2012 y su tratamiento especial, solicitar ser eliminado de su base de datos ya acceder en forma gratuita a los datos proporcionados que hayan sido objeto de tratamiento El trabajador autoriza a el empleador  para adelantar el tratamiento de sus datos personales se extiende durante la totalidad del tiempo en el que pueda llegar consolidarse un vínculo o este persista por cualquier circunstancia con el empleador con posterioridad al finiquito de este, siempre que tal tratamiento se encuentre relacionado con las finalidades para las cuales los datos personales fueron inicialmente suministrado. En ese sentido el trabajador declara conocer que los datos personales objeto de tratamiento, serán utilizados específicamente para las finalidades derivadas de las relaciones legales, contractuales, comerciales y/o de cualquier otra que surja. El trabajador autoriza para que se realicen las consultas necesarias en diferentes listas restrictivas como las de la autoridad o privada competente para certificar la información de antecedentes que sea requerida por parte del empleador, como que consulten y entreguen a el empleador .la información referente a procesos judiciales que cursen o hayan cursado en su contra. El trabajador declara que se le ha informado sobre los diferentes mecanismos de comunicación, con el fin de ejercer los derechos anteriormente descritos, que puede conocer la Política de Tratamiento de Datos Personales y realizar consultas o reclamos relacionados con sus datos personales, a través de los siguientes canales de información: Página web: i) www.listos.com.co, Teléfono: (0572) 6084848 iii) Correo electrónico: protecciondedatos@listos.com.co, iv) Correspondencia:  Cl.21N Nro. 8N-21 Cali – Valle del Cauca.
                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DÉCIMA CUARTA DEDUCCIONES Y COMPENSACIONES</strong>. Cuando por causa emanada directa o indirectamente de la relación contractual existan obligaciones de tipo económico a cargo del(la) trabajador(a) y a favor del Empleador, éste procederá a efectuar las deducciones y/o compensaciones a que hubiere lugar, de los salarios , prestaciones sociales y cualquier otro devengo causado en favor del trabajador, en cualquier tiempo y más concretamente, a la terminación del presente contrato, así lo autoriza desde ahora el(la) trabajador(a), entendiendo expresamente las partes que la presente cláusula cumple las condiciones de orden escrita previa, aplicable para cada caso ( Sentencia 39980 del 13 de Febrero de 2013 CSJ sala Laboral). 

                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DÉCIMA QUINTA AUTORIZACIÓN CONSIGNACIÓN DE SALARIO POR TRANSFERENCIA ELECTRÓNICA</strong>: El trabajador manifiesta expresamente que autoriza al empleador para que consigne a la cuenta bancaria suministrada por el trabajador los valores por todo concepto generados en virtud de la relación laboral. Parágrafo: El empleador deberá enviar el comprobante de pago a la dirección física y/o electrónica reportada por el trabajador. 

                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DÉCIMA SEXTA DERECHOS DE AUTOR Y USO DE DERECHOS DE IMAGEN</strong>: Las invenciones o descubrimientos realizados por el trabajador contratado para investigar pertenecen al empleador, de conformidad con el artículo 539 del Código de Comercio, así como el artículo 20 y concordantes de la Ley 23 de 1982 sobre derechos de autor. En cualquier otro caso el invento pertenece al trabajador, salvo cuando éste no haya sido contratado para investigar y realice la invención mediante datos o medios conocidos o utilizados en razón de la labor desempeñada, evento en el cual el trabajador, tendrá derecho a una compensación que se fijará de acuerdo con el monto del salario, la importancia del invento o descubrimiento, el beneficio que reporte al empleador u otros factores similares. Parágrafo primero: Mediante el presente contrato El Trabajador Autoriza al empleador para que haga el uso y tratamiento de sus derechos de imagen y lo autoriza expresamente para incluirlos sobre fotografías, procedimientos análogos a la fotografía; producciones audiovisuales (Videos), así como de los derechos de autor; los derechos conexos y en general todos aquellos derechos de propiedad intelectual que tengan que ver con el derecho de imagen. Parágrafo segundo- Alcance de la autorización. La presente autorización de uso se otorga para ser utilizada en formato o soporte material en ediciones impresas, y se extiende a la utilización en medio electrónico, óptico, magnético, en redes (Intranet e Internet), mensajes de datos o similares y en general para cualquier medio o soporte conocido o por conocer en el futuro. La publicación podrá efectuarse de manera directa o a través de un tercero que se designe para tal fin. Parágrafo Tercero - Territorio y exclusividad. - Los derechos aquí autorizados se dan sin limitación geográfica o territorial alguna. 

                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DÉCIMA SÉPTIMA: NOTIFICACIONES</strong>. El trabajador autoriza al empleador para que este realice envío de notificaciones y citaciones al correo electrónico registrado en este contrato y/o a los correos que por cualquier medio el trabajador reporte como dirección de notificaciones, incluidos los trámites relacionados con procesos y sanciones disciplinarias, convocatoria a reuniones y todas las comunicaciones referidas a la ejecución y terminación del contrato de trabajo. 

                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DÉCIMA OCTAVA: FORMALIDAD</strong>: El presente contrato reemplaza en su integridad y deja sin efecto alguno cualquiera otro contrato verbal o escrito celebrado entre las partes con anterioridad. Las modificaciones que se acuerden al presente contrato se anotarán a continuación de su texto. 

                    </td>
                </tr>

                <tr>
                    <td>
                        <br/><br/>
                        <strong>DÉCIMA NOVENA: LECTURA Y COMPRENSIÓN DEL CONTRATO</strong>: El trabajador al firmar el presente contrato certifica que ha leído y comprendido en su totalidad las cláusulas aquí consignadas.
                    </td>
                </tr>
            --}}
        <tr>
            <td>
                <p>
                    Para constancia se firma en dos ejemplares del mismo tenor y valor, en la ciudad y fecha que se indican a continuación. BOGOTA, {{ $dias_semana[date('N')] }} {{ date('d') }} de {{ $meses[date('n')] }} del 2020.</p>
            </td>
        </tr>
    </table>

    {{-- Contrato firmado --}}
    @if($firmaContrato != null || $firmaContrato != '')
        @if($firmaContrato->firma != null || $firmaContrato->firma != '')
            <table class="center table-contract" width="80%">
                <tr>
                    <td width="40%">
                        <div style="width: 100%; margin: 4em;">
                            <img src="{{ asset('contratos/default.jpg') }}" width="200" {{--style="width: 60%;"--}}>
                            <p>________________________________</p>
                            El empleador: <br>
                            James Ceron Palza <br>
                            Jefe nacional de Archivo.
                            <br>
                        </div>
                    </td>
                    <td width="30%"></td>
                    <td width="40%">
                        <div style="width: 100%; margin: 4em;">
                            <img src="{{ $firmaContrato->firma }}" width="200" {{--style="width: 60%;"--}}>
                            <p>________________________________</p>
                            El trabajador:<br>
                            {{ mb_strtoupper($candidato->nombres) }} {{ mb_strtoupper($candidato->primer_apellido)}} {{ mb_strtoupper($candidato->segundo_apellido)}}
                            <br>
                            {{ucwords(mb_strtolower($candidato->dec_tipo_doc))}}: {{ $candidato->numero_id }}
                        </div>
                    </td>
                </tr>
            </table>
        @endif
    @endif

    {{-- Tablero de firmar contrato --}}
    @if(count($firmaContrato) <= 0)
        <table class="center table-contract" width="80%" bgcolor="#f1f1f1">
            <tr>
                <td width="30%"></td>
                <td>
                    <div>
                        <div>
                            <div id="firmBoard" style="width: 400px; height: 160px; margin: 1rem;"></div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="center table-contract" width="80%" bgcolor="#f1f1f1">
            <tr>
                <td class="text-center">
                    <button type="button" class="btn btn-success guardarFirma" disabled>Firmar</button>
                    <p>Por favor dibuja tu firma en el panel blanco, no podemos guardar el contrato sin tu firma.</p>
                </td>
            </tr>
        </table>
    @elseif($firmaContrato->firma == null || $firmaContrato->firma == '')
        <table class="center table-contract" width="80%" bgcolor="#f1f1f1">
            <tr>
                <td width="30%"></td>
                <td>
                    <div>
                        <div>
                            <div id="firmBoard" style="width: 400px; height: 160px; margin: 1rem;"></div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>

        <table class="center table-contract" width="80%" bgcolor="#f1f1f1">
            <tr>
                <td class="text-center">
                    <button type="button" class="btn btn-success guardarFirma" disabled>Firmar</button>
                    <p>Por favor dibuja tu firma en el panel blanco, no podemos guardar el contrato sin tu firma.</p>
                </td>
            </tr>
        </table>
    @endif

    {{-- Siguiente paso despues de haber firmado 
    @if($firmaContrato != null || $firmaContrato != '')
        @if($firmaContrato->firma != null || $firmaContrato->firma != '')
            @if($firmaContrato->video == null)
                <table class="center table" width="80%" bgcolor="#f1f1f1">
                    <tr>
                        <td class="text-center">
                            <a
                                type="button"
                                class="btn btn-warning pull-right"
                                href="{{ route('home.confirmar-documentos-adicionales', [$userIdHash, $firmaContratoHash]) }}"
                                style="color: white;"
                            >
                                Siguiente paso 
                            </a>
                        </td>
                    </tr>
                </table>
            @endif
        @endif
    @endif --}}

    {{-- <div class="text-center mt-4 mb-2">
        <button type="button" class="btn btn-danger" id="btnCancelarContrato">Cancelar contratación</button>
    </div> --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        $(function (){
            //Define the swal toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            var firmBoard = new DrawingBoard.Board('firmBoard', {
                controls: [
                    { DrawingMode: { filler: false, eraser: false,  } },
                    { Navigation: { forward: false, back: false } }
                    //'Download'
                ],
                size: 2,
                webStorage: 'session',
                enlargeYourContainer: true
            });

            //listen draw event
            firmBoard.ev.bind('board:stopDrawing', getStopDraw);
            firmBoard.ev.bind('board:reset', getResetDraw);

            function getStopDraw() {
                $(".guardarFirma").attr("disabled", false);
            }

            function getResetDraw() {
                $(".guardarFirma").attr("disabled", true);
            }

            $(".guardarFirma").on("click", function() {
                $('.drawing-board-canvas').attr('id', 'canvas');

                var firmBefore = document.getElementById('canvas');
                var firmShow = firmBefore.toDataURL();

                Swal.fire({
                    imageUrl: firmShow,
                    imageWidth: 200,
                    imageHeight: 100,
                    title: '¿Tu firma es correcta?',
                    text: "Asegurate de que tu firma sea correcta y legible.",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, firmar',
                    cancelButtonText: 'Revisar'
                }).then((result) => {
                    if (result.value) {
                        $('.drawing-board-canvas').attr('id', 'canvas');

                        var canvas1 = document.getElementById('canvas');
                        var canvas = canvas1.toDataURL();
                
                        user_id = '{{$user_id}}';
                        req_id = '{{$req_id}}';
                        estado = 1;

                        var token = ('_token','{{ csrf_token() }}');
                        
                        $.ajax({
                            type: 'POST',
                            data: {
                                user_id : user_id,
                                estado : estado,
                                req_id : req_id,
                                _token : token,
                                firma : canvas
                            },
                            url: "{{ route('home.guardar-firma') }}",
                            beforeSend: function(response) {
                                Toast.fire({
                                    icon: 'info',
                                    title: 'Validando y guardando ...'
                                });
                            },
                            success: function(response) {
                                if(response.success == true){
                                    /*Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Contrato firmado.',
                                        showConfirmButton: false
                                    });*/

                                    takePicture(webcam)

                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: `¡Contrato firmado! <br>
                                                <p style="font-size: 2rem;">Por favor haz clic en el botón <i>"siguiente paso"</i> para continuar con la firma de los documentos adicionales.</p>`,
                                        showConfirmButton: false
                                    });

                                    setTimeout(function() {
                                        localStorage.setItem('reloadTab', false)
                                        localStorage.setItem('nextStep', true)
                                        location.reload();
                                    }, 5000);
                                }

                                if(response.success == false){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'info',
                                        title: 'Ya se encuentra creada la firma.',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        });
                    }
                });
            });

            //Cancelar contrato
            const $btnCancelarContrato = document.querySelector('#btnCancelarContrato');
            var tokenvalue = $('meta[name="token"]').attr('content');

            let dashboardRedir = '{{ route('dashboard') }}';
            let routeCancel = '{{ route('cancelar_contratacion_candidato') }}';
            let contratoId  = '{{ $firmaContrato->id }}';
            let userId  = '{{ $userId }}';
            let reqId  = '{{ $ReqId }}';

            const ToastNoTime = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timerProgressBar: true
            });

            const cancelContract = () => {
                Swal.fire({
                    title: '¿Estas seguro/a?',
                    text: "Esta acción es irreversible.",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, cancelar',
                    cancelButtonText: 'No, continuar'
                }).then((result) => {
                    if (result.value) {
                        //$('#observeModal').modal('show');
                        Swal.fire({
                            title: 'Cancelación de contrato',
                            input: 'textarea',
                            inputPlaceholder: 'Describe la razón por la que quieres cancelar el contrato',
                            inputAttributes: {
                                'aria-label': 'Describe la razón por la que quieres cancelar el contrato'
                            },
                            inputValidator: (field) => {
                                if (!field) {
                                    return 'Debes completar el campo'
                                }
                            },
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Enviar y cancelar',
                            cancelButtonText: 'Cancelar'
                        }).then((cancelation) => {
                            $.ajax({
                                type: 'POST',
                                data: {
                                    _token : tokenvalue,
                                    user_id : userId,
                                    req_id : reqId,
                                    contrato_id : contratoId,
                                    observacion : cancelation.value
                                },
                                url: routeCancel,
                                beforeSend: function() {
                                    ToastNoTime.fire({
                                        icon: 'info',
                                        title: 'Validando y guardando ...'
                                    });
                                },
                                success: function(response) {
                                    if(response.success == true){
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Contrato cancelado.',
                                            showConfirmButton: false
                                        });

                                        setTimeout(() => {
                                            localStorage.setItem('reloadTab', false)
                                            window.location.href = dashboardRedir
                                        }, 1000)
                                    }
                                }
                            });
                        })
                    }
                });
            }

            $btnCancelarContrato.addEventListener('click', () => {
                cancelContract()
            });
        });
    </script>
</body>
</html>