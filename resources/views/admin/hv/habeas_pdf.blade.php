<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <title>
            HABEAS - T3RS
        </title>
        <style type="text/css">
          @page { margin: 50px 70px; }
            .page-break {
                page-break-after: always;
            }

            table {
                border-collapse: collapse;
                width: 100%;
                padding: 0;
                margin: 0;
            }

             .table1 {
            border-collapse: collapse;
            width: 100%;
            padding: 0;
            margin: 0;

        }

        .table1, th, td {
            border: 1px solid #cacaca;

            padding: 5px;
        }

            #g-tr{
                margin-bottom: 90px;
                padding-bottom: 90px;
            }

            body {
                font-family: 'Bank Gothic', Bank, serif;
                font-size: 16px;
                background-color: #FFFFFF;
            }
            hr.style2 {
                border: 0;
                height: 1px;
                background: #377cfc;
                background-image: -webkit-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -moz-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -ms-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                background-image: -o-linear-gradient(left, #9bc1d1, #377cfc, #9bc1d1);
                width: 50%;
                color: #377cfc;

            }
            hr.style3 {
                border-top: 3px double;
                color: #377cfc;
                width: 50%;
            }

            h2,.blue {
                color: #377cfc;
            }
             .colum1 tr td:nth-child(1),.colum1 tr th{
            background-color: #fafafa;
            font-weight: bold;
        }
            .titulo-center {
                text-align: center;
            }

            footer{
                position: fixed;
                bottom: 0;
            }


            /* Justificar parrafo */
            p{
                text-align: justify;
            }


            /* Pruebas */
            td{
                border: solid 0px;
            }
            .subtitulo {
                padding-left: 50px;
            }

            .parrafo {
                padding-left: 65px
            }
        </style>
    </head>
    <body>
        <!-- Validar si el usuario es rol ADMIn para poder ver si el candidato tiene problemas de seguridad -->
    
        <table width="100%">
            <!-- FL-1 -->
            <tr id="g-tr">
                <!-- Col-3 -->
                <td colspan="3" width="30%">
                    @if(isset(FuncionesGlobales::sitio()->logo))
                        @if(FuncionesGlobales::sitio()->logo != "")
                            <img alt="Logo T3RS" class="izquierda" height="auto" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" width="150">
                        @else
                            <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                        @endif
                    @else
                        <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                    @endif
                </td>{{-- http://poderhumano.t3rsc.co --}}

            </tr>
        </table>
                
            <!-- FL-2 -->
       

            <!-- FL-3 -->
       <br><br>
                    <h4 style="text-align: center;" >
                       <strong>AUTORIZACIÓN USO DE DATOS PERSONALES Y ACEPTACIÓN DE CONDICIONES LABORALES</strong>  
                    </h4>
                   
                        
                            
                            
                                <p>
                                    Yo , <strong>{{$datos_basicos->nombres }} {{$datos_basicos->primer_apellido   }} {{$datos_basicos->segundo_apellido }}</strong>, identificado (a) con cédula de
ciudadanía N° <strong>{{$datos_basicos->numero_id  }}</strong>, expedida en la ciudad de <strong>{{$datos_basicos->ciudad_expedicion  }}</strong>  Por medio del presente documento confirmo que estoy participando como candidato en un
proceso de selección para la empresa <strong>{{ $reqcandidato->cliente_nombre }}</strong>, para el cargo de <strong>{{$reqcandidato->cargo_req  }}</strong> , en una jornada laboral de <strong>{{$reqcandidato->horario  }}</strong> , con una asignación salarial de <strong>${!!number_format($reqcandidato->salario,null,null,".")!!}</strong>.  

                               </p>
                                   Entre las funciones principales que realizaría para la labor asignada, comprenden: {{$reqcandidato->funcion_laboral }}
                                <p>
                                </p>
                                Así mismo, confirmo que mantendré disposición activa para las diferentes etapas del proceso y
asistiré a las entrevistas programadas con la presentación personal adecuada para tal fin.
                                <p> 
                                   
                               Certifico mi conocimiento sobre los documentos requisito para la contratación, y me comprometo
a irlos recopilando para la firma de contrato, en caso de ser seleccionado.

                                </p>
                                <p>
                                   Conozco y acepto que este proceso solamente es una postulación para participar en un proceso de
selección y que no genera ningún tipo de vínculo con TEMPORIZAR S.A.S. ni con la empresa
usuaria. También conozco y acepto que estas condiciones pueden variar en el avance del proceso
y que en caso de quedar seleccionado las condiciones contractuales definitivas me serán
informadas previo a la firma de mi contrato laboral. 
                                </p>
                                <p>
                                    Adicionalmente, declaro de manera libre, expresa, inequívoca e informada, que AUTORIZO
a <strong>TEMPORIZAR S.A.S.</strong> para que, en los términos del literal a) del artículo 6 de la Ley 1581 de 2012,
realice la recolección, almacenamiento, uso, circulación, supresión, y en general, tratamiento de
mis datos personales, incluyendo datos sensibles, como mis huellas digitales, fotografías, videos y
demás datos que puedan llegar a ser considerados como sensibles de conformidad con la Ley, para
que dicho Tratamiento se realice con el fin de lograr las finalidades relativas a ejecutar el control,
seguimiento, monitoreo, vigilancia y, en general, garantizar la seguridad de sus instalaciones; así
como para documentar las actividades gremiales.
                                </p>
                                <p>
                                  Declaro que se me ha informado de manera clara y comprensible que tengo derecho a conocer,
actualizar y rectificar los datos personales proporcionados, a solicitar prueba de esta autorización,
a solicitar información sobre el uso que se le ha dado a mis datos personales, a presentar quejas
ante la Superintendencia de Industria y Comercio por el uso indebido de mis datos personales, a
revocar esta autorización o solicitar la supresión de los datos personales suministrados y a acceder
de forma gratuita a los mismos.  
                                </p>
                                <p>
                                    Declaro que conozco y acepto el Manual de Tratamiento de Datos Personales de <b>TEMPORIZAR
S.A.S.</b>, y que la información por mí proporcionada es veraz, completa, exacta, actualizada y
verificable. Mediante la firma del presente documento, manifiesto que reconozco y acepto que cualquier consulta o reclamación relacionada con el Tratamiento de mis datos personales podrá
ser elevada verbalmente o por escrito ante <b>TEMPORIZAR S.A.S.</b>, como Responsable del
Tratamiento, al correo de contacto: servicio.cliente@temporizar.com, persona contacto: Leandra
Pardo Porras, Directora de Servicio al Cliente, página web: www.temporizar.com y número
telefónico: 5188436.
                                </p>
                    
            
<p>
               Adicionalmente, autorizo a Temporizar S.A.S. para, realizar cualquier operación que tenga una
finalidad lícita, tales como la recolección, el almacenamiento, el uso, la circulación, supresión,
transferencia y transmisión (el “Tratamiento”) de los datos personales relacionados con el
proceso de selección en el cual estoy participando, el cual incluye, pero no se limita, a los procesos
de aplicación de pruebas psicotécnicas, pruebas técnicas, verificación de mis referencias
personales y laborales, verificación de todos los datos registrados en mi hoja de vida, registro
biométrico de mi documento de identidad, validación de los títulos por estudios y cursos
realizados y que soportan mi hoja de vida. Así mismo autorizo a Temporizar a compartir esta
información de mi hoja de vida y todos los procesos de verificación de la misma, antes
mencionados, con los representantes de las empresas usuarias y proveedores que intervienen el
proceso de selección. Así mismo, en caso de ser contratado, autorizo a Temporizar S.A.S. para,
realizar cualquier operación que tenga una finalidad lícita, tales como la recolección, el
almacenamiento, el uso, la circulación, supresión, transferencia y transmisión (el “Tratamiento”)
de los datos personales relacionados con mi vinculación laboral y con la ejecución, desarrollo y
terminación del contrato de trabajo, cuya finalidad incluye, pero no se limita, a los procesos
verificación de la aptitud física del trabajador para desempeñar en forma eficiente las labores sin
impactar negativamente su salud o la de terceros, las afiliaciones del trabajador y sus
beneficiarios al Sistema general de seguridad social y parafiscales, la remisión del trabajador para
que realice apertura de cuenta de nómina, archivo y procesamiento de nómina, gestión y archivo
de procesos disciplinarios, archivo de documentos soporte de su vinculación contractual y la
remisión o acceso de copia de los mismos a la empresa usuaria donde laborará en misión, reporte
ante autoridades administrativas, laborales, fiscales o judiciales, entre otras, así como el
cumplimiento de obligaciones legales o contractuales del EMPLEADOR con terceros, la debida
ejecución del Contrato de trabajo, el cumplimiento de las políticas internas del EMPLEADOR, la
verificación del cumplimiento de las obligaciones del TRABAJADOR, la administración de sus
sistemas de información y comunicaciones, la generación de copias y archivos de seguridad de la
información en los equipos proporcionados por EL EMPLEADOR.
            </p>
<br>


            <p>
                El presente documento se firma en la ciudad de {{$reqcandidato->ciudad_req}} a los {{$datos_basicos->FechaHoy()->day}} días
del mes de {{mb_strtoupper($datos_basicos->FechaHoy()->localeMonth) }} del año {{$datos_basicos->FechaHoy()->year}}
            </p>
  <br><br>
  <p>
    
   <strong>{{$datos_basicos->nombres }} {{$datos_basicos->primer_apellido   }} {{$datos_basicos->segundo_apellido  }}  {{$datos_basicos->numero_id  }}</strong>

  </p>
  <p>
   Nombre y cédula
  </p>
<br>
<p>
     ____________________________
</p>
   <p>
    Firma  

  </p>
      
        <footer>
            <img alt="Logo T3RS" class="izquierda" height="25" src="{{url('img/t3.png')}}" width="20"> www.t3rsc.co
        </footer>
    </body>
</html>
