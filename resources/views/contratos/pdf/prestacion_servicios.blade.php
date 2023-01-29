<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Firma de contrato</title>

    <style>
        html{
            font-family: 'Arial';
        }

        body{
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            color: black;
            background-color: #fff;
        }

        .text-center{ text-align: center;  }
        .text-left{ text-align: left;  }
        .text-right{ text-align: right;  }
        .text-light{ font-weight: lighter; }

        .m-1{ margin: 1rem; }
        .mt-1{ margin-top: 1rem; }
        .mt-2{ margin-top: 2rem; }
        .mt-3{ margin-top: 3rem; }
        .mt-4{ margin-top: 4rem; }

        .pd-1{ padding: 1rem; }

        .center{ margin: auto; }

        .table{
            border-collapse:separate; 
            /*border-spacing: 6px;*/
        }

        .justify{ text-align: justify; }

        .list{ list-style: none; }

        .space{ line-height: 18px; }

        hr{
            page-break-after: always;
            border: none;
            margin: 0;
            padding: 0;
        }

        footer{
            position: fixed; 
            bottom: -20px; 
            font-size: 7pt;
        }
    </style>
</head>
<body>
    @include('contratos.includes._section_footer_marca_agua')
    <table width="100%" class="mt-1">
        <tr>
            <th width="10%"></th>

            <th class="text-left">
                @if (isset($empresa_contrata))
                    @if ($empresa_contrata != null || $empresa_contrata != '')
                      <img src="{{ asset('configuracion_sitio/'.$empresa_contrata->logo) }}" width="80" >
                    @endif
                @endif
            </th>

            <th class="text-right text-light">
                Fecha: <strong>{{ $fecha }}</strong>
            </th>

            <th width="10%"></th>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <th class="text-center">
                <p>Firma de contrato</p>
                @if (isset($anulado))
                    <h4 style="color:red; margin:0; padding:0; font-size: 24px;">CONTRATO ANULADO</h4>
                @endif
            </th>
        </tr>

        @if($foto != null)
            <tr>
                <td class="text-center">
                    <img src="{{ asset('recursos_datosbasicos/'.$foto) }}" width="80" height="80" style="border-radius: 10px;">
                </td>
            </tr>
        @endif

        <tr>
            <td class="text-center mt-1">
                {{ $candidato->nombres }} {{ $candidato->primer_apellido }} {{ $candidato->segundo_apellido }}
            </td>
        </tr>
    </table>

    <table width="100%">
        <tr>
            <th class="text-center">
                <p>CONTRATO DE PRESTACIÓN DE SERVICIOS ESPECIALIZADOS EN ATRACCIÓN DE TALENTO</p>
            </th>
        </tr>
    </table>

    <table class="center table justify" width="97%">
        <tr class="pd-1">
            <th class="text-left">
                Nombre del contratante:
            </th>
            
            <td width="25%">
                TERCERIZAR S.A.S
            </td>

            <th class="text-left">
                NIT:
            </th>
            
            <td colspan="2">
                800.104.552-3
            </td>
        </tr>

        <tr>
            <th class="text-left" width="25%">
                Representante legal:
            </th>

            <td width="25%">
                Claudia Milena Marulanda
            </td>

            <th class="text-left" width="25%">
                Cédula:
            </th>

            <td colspan="2" width="25%">
                16.789.910
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Domicilio:
            </th>
            
            <td width="25%">
                Calle 21N 8-21
            </td>

            <th class="text-left">
                Ciudad:
            </th>
            
            <td colspan="2">
                Cali – Valle del Cauca
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Teléfono:
            </th>
            
            <td colspan="4">
                6084848
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Nombre y Apellidos del contratista (Especialista en Atracción de Talento):
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
                {{ ucwords(mb_strtolower($candidato->dec_tipo_doc)) }}
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
                    {{ $lugarnacimiento->value }}
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Dirección del contratista:
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
            
            <td width="25%">
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
            <th  class="text-left">
                Número de Cuenta:
            </th>

            <td width="25%">
                @if(isset($req_contrato_candidato))
                    {{ $req_contrato_candidato->numero_cuenta }}
                @endif
            </td>

            <th class="text-left">
                Tipo de cuenta:
            </th>

            <td colspan="2">
                @if( isset($req_contrato_candidato) )
                    {{ $req_contrato_candidato->tipo_cuenta }}
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Banco:
            </th>

            <td colspan="4">
                @if( isset($req_contrato_candidato) )
                    {{ $req_contrato_candidato->banco }}
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Cargo:
            </th>

            <td colspan="4">
                @if(isset($reqcandidato->nombre_cargo_especifico))
                    {{ $reqcandidato->nombre_cargo_especifico }}
                @else
                    {{-- Para previsualización del contrato --}}
                    @if(isset($requerimiento_informacion->nombre_cargo_especifico))
                        {{ $requerimiento_informacion->nombre_cargo_especifico }}
                    @endif
                @endif
            </td>
        </tr>

        <tr>
            <th class="text-left">
                Períodos de pagos:
            </th>

            <td colspan="4">
                Mes Vencido
            </td>
        </tr>
    </table>

    <table class="center table justify mt-2" width="97%">
        <tr>
            <td>
                Entre los suscritos a saber CLAUDIA MILENA MARULANDA BOLIVAR mayor de edad y de esta vecindad, portador de la cédula de ciudadanía No. 16.789.910 en calidad de Representante Legal de la empresa <strong>TERCERIZAR S.A.S</strong>, quien para efectos de este contrato se denominará TERCERIZAR de una parte, y el contratista quien para efectos de este contrato se denominará <strong>Especialista en Atracción de Talento</strong>, por medio del presente documento declaramos haber celebrado contrato de prestación de servicios profesionales que se regirá por las siguientes cláusulas y en lo no dispuesto en ellas por la ley. 
            </td>
        </tr>

        {!! isset($cuerpo_contrato) ? $cuerpo_contrato->cuerpo_contrato : "" !!}

        {{--<tr>
           <td>
                <br/> <br/>
               <strong>Primera.- Objeto.- El  Especialista en Atracción de Talento</strong>, se compromete de manera  autónoma e independiente, con sus propios medios y bajo su riesgo a prestar a TERCERIZAR  sus servicios profesionales relacionados con la  atracción de talento para el cubrimiento de las vacantes requeridas por  TERCERIZAR de conformidad con las especificaciones para cada vacante y con los criterios determinados en la plataforma T3RS.
           </td>
        </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Segunda: —Plazo</strong>. El plazo para la ejecución del presente contrato será el tiempo determinado por  TERCERIZAR para el cubrimiento de las vacantes, pudiendo prorrogarse en la medida en que Especialista de Atracción de Talento , opte por continuar prestando sus servicios independientes para el cubrimiento de vacantes. 
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Tercera. —Honorarios</strong>. Por la prestación del servicio, TERCERIZAR reconocerá al Contratista los honorarios determinados para cada vacante, los cuales han sido aceptados previamente por el contratista en el momento de seleccionar las vacantes a cubrir. Las partes acuerdan que el reconocimiento de los honorarios dependerá de la efectividad obtenida por el contratista en los siguientes términos: Cuando el candidato atraído sea postulado para un proceso de selección y llegue a la etapa de entrevista o cuando el candidato sea seleccionado de conformidad con las condiciones previstas para cada vacante. No obstante, en el evento en que el candidato sea descartado inicialmente, este podrá ser tenido en cuenta para otras vacantes dentro de los 6 meses siguientes y de llegar a la etapa de entrevista y/o contratación (depende de las condiciones de la vacante), se causará el derecho al pago de los honorarios.
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Parágrafo</strong>:  Los honorarios se pagarán a través de transferencia electrónica a la cuenta del banco reportada por el Especialista en atracción de Talento como titular de la cuenta. Será requisito para el pago de los honorarios la presentación de la constancia del pago de aportes a la seguridad social de El(La) Contratista como independiente.  TERCERIZAR aplicará las deducciones tributarias de Ley a que haya lugar tales como RETEFUENTE, RETEICA entre otros.
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Cuarta. - Obligaciones de TERCERIZAR S.A.S</strong> . Este deberá facilitar acceso a la información, permitirá el acceso al aplicativo T3RS para registrar la información de los candidatos, que sea necesaria, de manera oportuna, para la debida ejecución del objeto del contrato, y, estará obligado a cumplir con lo estipulado en las demás cláusulas y condiciones previstas en este documento. 
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Quinta. —Obligaciones de El Especialista en atracción de Talento</strong>. Deberá cumplir en forma eficiente y oportuna aquellas obligaciones que se generen de acuerdo con la naturaleza del servicio y en especial asegurarse de que los servicios de atracción de talento prestados cumplan con los siguientes estándares mínimos:
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
                - Búsqueda del candidato por las diferentes fuentes de reclutamiento.
                <br/>
                - Perfilamiento de la hoja de vida de los candidatos.
                <br/>
                - Llamada para validación de información y verificación de disponibilidad.
                <br/>
                - Revisión de antecedentes, por medio del aplicativo Truora que está integrado en la plataforma.
                <br/> 
                - Ingresar la información de la Hoja de vida en la plataforma.
                <br/>
                - Consultar los comentarios que TERCERIZAR realice frente a la calidad y oportunidad de los servicios prestados.
                <br/>
                - Se prohíbe a El Especialista en atracción de Talento el cobro de comisiones, porcentaje o cuota de ingreso y participación de la totalidad del proceso de selección y contratación a los candidatos que atraiga para las vacantes. En el evento en que se determine por parte de TERCERIZAR que el El Especialista en atracción de Talento incurrió en cualquiera de las conductas mencionadas, el contrato terminará automáticamente y el El Especialista en atracción de Talento se obligará a indemnizar TERCERIZAR por los daños y perjuicios derivados de dichas conductas, sin perjuicio de las acciones legales que TERCERIZAR inicie contra El Especialista en atracción de Talento.
           </td>
       </tr>

       <tr>
           <td>
            <br/><br/>
            <strong>Sexta. - Terminación</strong>. El presente contrato podrá darse por terminado en cualquier momento por cualquiera de las partes sin necesidad de preaviso y sin que la parte que termina el contrato deba indemnizar a la otra parte.
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Séptima.—Independencia de El Especialista en Atracción de Talento</strong>. El Especialista en Atracción de Talento actuará por su propia cuenta, con absoluta autonomía y no estará sometido a subordinación laboral con TERCERIZAR y sus derechos se limitarán, de acuerdo con la naturaleza del contrato, a solicitar el cumplimiento de las obligaciones de TERCERIZAR.
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Octava.— Exclusión de la relación laboral</strong>. Queda claramente entendido que no existirá relación laboral alguna entre TERCERIZAR y <strong>El Especialista en Atracción de Talento</strong>, o el personal que éste utilice en la ejecución del objeto del presente contrato. 
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Novena.—Cesión del contrato</strong>. El(La) Contratista no podrá ceder parcial ni totalmente la ejecución del presente contrato a un tercero salvo previa autorización expresa y escrita de TERCERIZAR.
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Décima .—Domicilio contractual</strong>. Para todos los efectos legales, el domicilio contractual será la ciudad de Bogotá D.C. y las notificaciones serán recibidas por las partes en las siguientes direcciones: Por  TERCERIZAR en: Calle 21N # 8N-21 de Cali; y  El(La) Contratista en la ciudad identificada en la parte superior del contrato. 
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Décima Segunda: Información Confidencial</strong>: incluye, sin limitación alguna, todo el producto del trabajo e información técnica o de negocios relacionada con: (i) los TÉRMINOS Y CONDICIONES del presente Contrato y sus respectivos anexos; (ii) toda información que se refiera a las descripciones, datos, diseños, gráficas e información visual, verbal o escrita, contenida en cualquier formato, productos, procesos y operaciones, métodos, fórmulas, know-how y cualquier otra información de naturaleza técnica, económica, financiera o cualquier otra relacionada con las operaciones, estrategias, políticas y manejo de actividades, programas o sistemas de cómputo, software, códigos fuente o códigos objeto, programas o sistemas de cómputo que revele el CONTRATISTA al CONTRATANTE con motivo de su relación contractual o, de cualquier forma relacionada con ésta. Así mismo, algoritmos, fórmulas, diagramas, planos, procesos, técnicas, diseños, fotografías, registros, compilaciones, información de clientes o interna del CONTRATISTA; (iii) toda aquella información que esté relacionada con programas, inventos, marcas, patentes, nombres comerciales, secretos industriales, y derechos de propiedad intelectual, licencias y cualquiera otra información oral o escrita que revele el CONTRATISTA al CONTRATANTE con relación al Contrato; (iv) toda información revelada por terceros con los cuales el CONTRATISTA tiene acuerdo de confidencialidad u obtenida por el TERCERO (SISDUAN) en escritos u otros materiales, por el acceso d TERCERIZAR a los locales, el equipo o las instalaciones del CONTRATISTA, o por la comunicación oral o el intercambio de comunicaciones escritas con empleados, asesores o agentes del CONTRATISTA o con  TERCERIZAR  y, en general, (v) toda información conocida con ocasión del Contrato.
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               Dentro de la “Información Confidencial” no se incluirá aquello: (i) que sea del dominio público, por una razón diferente del incumplimiento a las obligaciones de confidencialidad aquí pactadas, (ii) que esté en posesión del CONTRATISTA y CONTRATANTE y que la haya recibido legítimamente con anterioridad a la celebración del presente Contrato; ni (iii) que por orden válida de autoridad competente deba revelarse en tal forma que pase al dominio público.
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Décima Tercera : Tratamiento de Datos Personales</strong>:En estricto cumplimiento de la normatividad en protección de datos personales, como lo es la Ley 1581 de 2012,como su Decreto reglamentario 1377 de 2013,  TERCERIZAR  manifiestan que cuentan con políticas de tratamiento de información, así mismo que toda la información es recopilada y mantenida de acuerdo a los requerimientos de dicha normatividad, así mismo, que fueron  informados, y en consecuencia conocen y aceptan cumplir las políticas de protección de datos  cada una de LAS PARTES  y que, en consecuencia tratarán la información entregada, de acuerdo a dichas políticas y a las garantías y libertades reconocidas por la Constitución y la Ley, en materia de Habeas Data.” En caso de querer presentar Consultas para actualizar, rectificar, conocer oponerse o elevar alguna Quejas o Reclamos, el destinatario deberá comunicar al Oficial de Protección de Datos Personales protecciondedatos@tercerizar.com.co, o al teléfono (035) 6084848, Cl.21N NRO. 8N-21 Cali – Valle del Cauca, las incidencias de seguridad de las que tenga conocimiento. Igualmente, deberá informar aquellas incidencias que puedan afectar las bases de datos, soportes o documentos que contengan información personal. Para más información acerca de la Política de Tratamiento de datos personales y sus modificaciones puede consultar en la Página Web: www.tercerizar.com.co
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Décima Cuarta: Uso de marcas, logos, nombre e Insignias de TERCERIZAR</strong>. El Especialista en atracción de talento reconoce que no podrá usar, reproducir, modificar, explotar, publicitar o realizar cualquier otra acción con las marcas, logotipos, nombres e insignias de TERCERIZAR, sus empresas aliadas o clientes sin la previa autorización expresa y por escrito de TERCERIZAR. El Especialista en atracción de talento acepta que el incumplimiento de lo anterior acarreará las sanciones civiles y penales que correspondan e igualmente la inmediata desactivación para el uso de la plataforma.
           </td>
       </tr>

       <tr>
           <td>
               <br/><br/>
               <strong>Décima Quinta: Cláusula compromisoria</strong>. Las partes convienen que en el evento en que surja alguna diferencia entre las mismas, por razón o con ocasión del presente contrato, bien sea por su naturaleza, ejecución o interpretación, será resuelta por un tribunal de arbitramento cuyo domicilio será Bogotá D.C. integrado por tres (3) árbitros designados conforme a la ley. Los arbitramentos que ocurrieren se regirán por lo dispuesto en el Decreto 2279 de 1991, en la Ley 23 de 1991 y en las demás normas que modifiquen o adicionen la materia.
           </td>
       </tr>
       --}}

        <tr>
            <td>
                <p>
                    Para constancia se firma en dos ejemplares del mismo tenor y valor, en la ciudad y fecha que se indican a continuación. BOGOTA, {{ $dias_semana[date('N')] }} {{ date('d') }} de {{ $meses[date('n')] }} del 2020.
                </p>
            </td>
        </tr>
    </table>

    {{-- Contrato firmado --}}
    @if($firmaContrato != null || (isset($mostrar_firma) && $mostrar_firma === 'SI'))
        <table class="center table" width="80%">
            <tr>
                <td width="40%">
                    <div style="width: 100%; margin: 4em;">
                        <img src="{{ asset('contratos/default.jpg') }}" width="180">
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
                        <img src="{{ $firmaContrato->firma }}" width="180">
                        <p>________________________________</p>
                        El trabajador:<br>
                        {{ mb_strtoupper($candidato->nombres) }} {{ mb_strtoupper($candidato->primer_apellido)}} {{ mb_strtoupper($candidato->segundo_apellido)}}
                        <br>
                        {{ ucwords(mb_strtolower($candidato->dec_tipo_doc))}} : {{ $candidato->numero_id }}
                    </div>
                </td>
            </tr>
        </table>
    @endif

    @if(!isset($anulado) || (isset($mostrar_adicionales) && $mostrar_adicionales === 'SI'))
        @if(isset($adicionales))
            @if($adicionales->count() > 0)
                @foreach($adicionales as $ad)
                    <hr>
                    
                    <?php
                        $firma = null;
                        $documento_mostrar = "home.include.adicionales.documento_".$ad->adicional_id;
                        if($ad->firma != null && $ad->firma != ""){
                            $firma=$ad->firma;
                        }
                    ?>
                    
                    @include($documento_mostrar)

                    <?php
                        if(isset($firma)){
                            unset($firma);
                        }
                    ?>
                @endforeach
            @endif
        @endif

        @if(isset($adicional_externo))
            @if($adicional_externo->count() > 0)
                <div style="page-break-after:always;"></div>
                @include("home.include.adicionales.documento_medico_recomendaciones", [
                    "recomendaciones" => $requerimiento_candidato_orden_pdf->especificacion,
                    "firma" => isset($adicional_externo->firma) ? $adicional_externo->firma : null,
                    "lugarexpedicion" => $lugarexpedicion_medica
                ])
            @endif
        @endif

        {{-- cláusulas creadas --}}
        @if(isset($adicionales_creadas))
            @if($adicionales_creadas->count() > 0)
                @foreach($adicionales_creadas as $clausula)
                    <hr>
                    
                    <?php
                        $firma = null;
                        if($clausula->firma != null && $clausula->firma != ""){
                            $firma = $clausula->firma;
                        }

                        $nuevo_cuerpo = App\Jobs\FuncionesGlobales::search_and_replace(
                            $replace, 
                            $clausula->contenido_clausula, 
                            ['adicional_id' => $clausula->adicional_id, 'req_id' => $req_id, 'cargo_id' => $clausula->cargo_id, 'user_id' => $userId]
                        );
                    ?>

                    @include('admin.clausulas.template.layout', ["nuevo_cuerpo" => $nuevo_cuerpo, "empresa_contrata" => $empresa_contrata, "firma" => $firma, 'opcion_firma' => $clausula->opcion_firma]) 
                        
                    <?php
                        if(isset($firma)){
                            unset($firma);
                        }
                    ?>
                @endforeach
            @endif
        @endif

        @if (isset($mostrar_adicionales) && $mostrar_adicionales === 'SI')
            <div style="page-break-after:always;"></div>
            @include("home.confirmacion_manual", array('firma' => '-1'))
        @endif
    @endif

    @if($firmaContrato != null)
        <div style="page-break-after:always;"></div>

        <table class="center table justify" width="80%">
            <tr>
                <td>
                    <p>Información especial del contrato</p>
                    <ul class="list">
                        <li>IP: {{ $firmaContrato->ip }}</li>
                        <li>Fecha y hora de firma: {{ date("Y-m-d H:i:s") }}</li>
                        <li>Token de acceso: {{ $reqcandidato->token_acceso }}</li>
                        {{--<li>{!!QrCode::size(200)->generate("www.t3rsc.com") !!}</li>--}}
                    </ul>
                </td>
            </tr>
        </table>
    @endif

    @if(count($contrato_fotos) > 0)
        <div style="page-break-after:always;"></div>

        <section>
            <p class="text-center">
                <b>
                    Fotos tomadas durante la firma de los documentos
                </b>
            </p>
        </section>

        <section>
			<div class="text-center">
				@foreach($contrato_fotos as $key => $foto)
                    @if (empty($foto->estado))
                        <img 
                            class="m-1" 
                            src="{{ url("recursos_firma_contrato_fotos/contrato_foto_"."$userId"."_"."$req_id"."_"."$firmaContrato->id/$foto->descripcion") }}" 
                            alt="Foto candidato"
                            width="220"
                            style="padding: .25rem; width: 220px; background-color: #fff; border: 1px solid #dee2e6; border-radius: .25rem; max-width: 100%;">
                        <div style="margin-top: -1rem; font-size: 8pt; color: gray;">{{ $foto->created_at }}</div>
                    @else
                        <div class="m-1" style="padding: .25rem; font-size: 8pt; color: rgb(95, 95, 95);">{{ $foto->estado }}</div>
                    @endif

                    <?php
						if ($key === 6) {
							break;
						}
					?>
	            @endforeach
			</div>
		</section>
    @endif
</body>
</html>