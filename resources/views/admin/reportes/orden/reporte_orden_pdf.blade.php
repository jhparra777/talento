<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Orden PDF</title>

    </head>
    
    <body>
        <div id="wrapper_contenido">
            <table border="1" cellspacing="0" cellpadding="2" style="width: 100%;">
              <tbody>
                <tr>
                  <td>
                    @if(isset(FuncionesGlobales::sitio()->logo) && FuncionesGlobales::sitio()->logo != "")
                      <img style="max-width: 100px;" src="configuracion_sitio/{!! ((FuncionesGlobales::sitio()->logo)) !!}" border="0" />
                    @else
                      <img style="max-width: 100px;" src="{{url("img/logo.png")}}" border="0"/>
                      @endif
                  </td>
                  <td>
                    <div style="text-align:center;">
                    PROCESO CONTRATACIÓN DE PERSONAL<br />
                    SOLICITUD DE CONTRATACIÓN DE PERSONAL<br />
            </div>
                  </td>
              <td>
                 <table border="1" cellpadding="1" style="width:100%;">
                <tr>
               <td>
                  <strong>Código</strong> : 
               </td>
            </tr>
            <tr>
               <td>
                 <strong>Revisión</strong> : 
               </td>
            </tr>
            <tr>
               <td>
                  <strong>Vigencia</strong>
               </td>
            </tr>
            </table>
              </td>
                </tr>
              </tbody>
            </table>

            <p></p>

            <table border="0" cellspacing="0" cellpadding="2" style="width: 100%;">
              <tbody>
                <tr>
                  <td style="font-weight:bold;">Cliente/Sociedad :</td>
                  <td>
                    {{ $requerimiento->negocio_id }} / {{ $requerimiento->nombre }} <br/><b>Negocio :</b> {{ $requerimiento->negocio_id }} <b>Lugar de trabajo :</b> 
                  </td>
                  <td style="font-weight:bold;">Solicitante :</td>
                  <td>
                    {{ strtoupper($requerimiento->nombres) }} {{ strtoupper($requerimiento->primer_apellido) }} {{ strtoupper($requerimiento->segundo_apellido) }}
                  </td>
                  <td style="font-weight:bold;">Area Solicitante :</td>
                  <td ></td>
                </tr>
              </tbody>
            </table>
            <p></p>
            <table border="0" cellspacing="0" cellpadding="2" style="width: 100%">
              <tbody>
                <tr>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Nro.
            Solicitud:</td>
                  <td style="text-align:right;">{{ $requerimiento->id }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Fecha
            Solicitud:</td>
                  <td style="text-align:right;">{{ $requerimiento->fecha_requerimiento }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Fecha
            Inicio:</td>
                  <td style="text-align:right;">{{ $requerimiento->fecha_ingreso }}</td>
                </tr>
                <tr>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Nro.
            Solicitado:</td>
                  <td style="text-align:right;">{{ $requerimiento->num_vacantes }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Cargo
            Solicitado:</td>
                  <td style="text-align:right;">{{ $requerimiento->descrip_cargo }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Proceso de
            Selección:</td>
                  <td style="text-align:right;"> </td>
                </tr>
                <tr>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Salario:</td>
                  <td style="text-align:right;">{{ $requerimiento->salario }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Nivel de
            Estudio:</td>
                  <td style="text-align:right;">{{ $requerimiento->descrip_estudio }}</td>
                  <td
            style="font-weight:bold;background-color:#FAFAFA;">Género:</td>
                  <td style="text-align:right;">{{ $requerimiento->descrip_genero }}</td>
                </tr>
                <tr>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Jornada:</td>
                  <td style="text-align:right;">{{ $requerimiento->descrip_jornada }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Horario
            Trabajo:</td>
                  <td style="text-align:right;">{{ $requerimiento->hora_inicio }} / {{ $requerimiento->hora_fin }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Tipo
            Nómina:</td>
                  <td style="text-align:right;">{{ $requerimiento->descrip_nomina }}</td>
                </tr>
                <tr>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Tipo
            Salario:</td>
                  <td style="text-align:right;">{{ $requerimiento->descrip_salario }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Centro Costo
            Prod.:</td>
                  <td style="text-align:right;">{{ $requerimiento->centro_costo_produccion }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Estado
            Solicitud:</td>
                  <td style="text-align:right;">{{ strtoupper($requerimiento->estadoRequerimiento()->estado_nombre) }}</td>
                </tr>
                <tr>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Fecha
            Cumplimiento:</td>
                  <td style="text-align:right;">{{ $requerimiento->fecha_terminacion }}</td>
                  <td style="font-weight:bold;background-color:#FAFAFA;">Tipo
            Contrato:</td>
                  <td style="text-align:right;" colspan="2">{{ $requerimiento->descrip_contrato }}</td>
                  <!--<td></td>-->
                  <td></td>
                </tr>
              </tbody>
            </table>
            <p></p>
          @if ($examenes != "" || $examenes != null)
            <table border="1" cellspacing="0" cellpadding="2" style="width: 100%">
              <tbody>
                <tr>
                  <th>Tipo de identificación</th>
                  <th>Nro. Identificación</th>
                  <th>Nombre</th>
                  <th>Estado</th>
                  <!--<th>Edad</th>-->
                  <th>Género</th>
              <th>Fecha Ingreso</th>
                </tr>
                  @foreach ($examenes as $examen)
                  <tr>
                    <td> {{ strtoupper($examen->tipo_documento) }} </td>
                    <td> {{ $examen->numero_id }} </td>
                    <td> 
                      {{ strtoupper($examen->nombres) }} {{ strtoupper($examen->primer_apellido) }} {{ strtoupper($examen->segundo_apellido) }} 
                    </td>
                    <td> 
                      @if($valida == 1)
                        {{ strtoupper("Enviado a exámenes medico") }}
                      @else
                        {{ strtoupper("Enviado a contratar") }}
                      @endif
                    </td>
                    <td> {{ strtoupper($examen->genero) }}</td>
                    <td> {{ $examen->fecha_inicio }} </td>
                  </tr>
                  @endforeach
              </tbody>
            </table>
          @else
            <div>No hay candidatos enviados a exámenes
            médicos.</div>
          @endif
            <p></p>
            <table border="0" cellspacing="2" style="width: 100%">
              <tbody>
                <tr>
                  <td>__________________________________</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td>{{ strtoupper($requerimiento->nombres) }} {{ strtoupper($requerimiento->primer_apellido) }} {{ strtoupper($requerimiento->segundo_apellido) }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
        </div>
        <footer>Powered by T3RS</footer>
    </body>
</html>