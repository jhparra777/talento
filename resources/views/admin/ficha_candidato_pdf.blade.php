<!DOCTYPE html>
<html lang="es">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title> Ficha Postulacion </title>
    </head>
  
    <style>
        
        body{
          font-size: 12px;
        }
        
        .tabla1,.tabla3,.table4{
           border-collapse: collapse;
           width: 100%;
        }

            .tabla1, .tabla1 th, .tabla1 td,.tabla3 th, .tabla3 td {
                border: 1px solid black;
                padding: 5px 10px;
                margin: 0;
            }

            .table4, .table4 th, .table4 td {
                border: 0px solid black;
                padding: 0;
                margin: 0;
            }

            .tabla2{
                border-collapse: collapse;
                width: 100%;
            }

            .tabla2 td {
                border-right: 1px solid black;    
                padding: 10px;
                margin: 0;
                text-align: center;

            }
            .tabla3 td{
                padding: 5px;
            }

            @page { margin: 50px 50px; }

            .page-break {
                page-break-after: always;
            }

            .imagen{
              height: 150px
            }

            body{
              font-family: Arial, Helvetica, sans-serif;
              font-size: 12px;
            }

            .titulo{
              padding: 10px 0px;
              text-align: center;
              font-size: 12px;
            }

            .tabla3 tr th{
               background-color: #fafafa;
               font-weight: bold;
            }

            span {
                width: 72% !important;
                padding: 5px 0px 5px 0px;
                /*padding-bottom: 9px;*/
                /*border: 1px solid Black;*/
            }

            span .td {
              border: none !important;
              background: White !important;
              padding-left: 10px;
              font-size: 16px;
              margin-bottom: 30px;
              border:none !important;
            }

            span .tr {
                /* display: table-row;*/
                border: 1px solid Black;
                padding: 2px 2px 2px 5px;
                background-color: #f5f5f5;
            }

            span .th {
              text-align: left;
              font-weight: bold;
            }

        </style>

    <body>
        <!-- Validar si el usuario es rol ADMIn para poder ver si el candidato tiene problemas de seguridad -->
        <table class="tabla4" >
            <tr>
                <td style="width: 30%">
                  @if(isset(FuncionesGlobales::sitio()->logo))
                    @if(FuncionesGlobales::sitio()->logo != "")
                     <img style="max-width: 200px" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}">
                    @else
                     <img style="max-width: 200px" src="{{url('img/logo.png')}}" >
                    @endif
                  @else
                     <img style="max-width: 200px" src="{{url('img/logo.png')}}">
                  @endif
                </td>

                <td  style="text-align:center;font-weight: bold;"> <h1 style="size:30px;"> INFORMACIÓN GENERAL DE LA SOLICITUD </h1> </td>
            </tr>
            <tr> <td style="text-align:center; "><label>Fecha: </label> {{$datos_basicos->fecha_contrato}} <td></tr>
        </table>
   
        <table class="tabla1">
            <tr>
              <td>
                <label style="font-weight: bold;"> Apellidos y nombres (completos) :</label>
              </td>
              <td>
                 {{$datos_basicos->nombres.' '.$datos_basicos->primer_apellido.' '.$datos_basicos->segundo_apellido}}
              </td>
            </tr>

            <tr>
              <td>
               <label style="font-weight: bold;"> R.U.T: </label>
              </td>

              <td>
               {{$datos_basicos->numero_id}}
              </td>
            </tr>

            <tr>
             <td>
              <label style="font-weight: bold;"> Domicilio-Referencia del domicilio: </label>
             </td>
             <td> {{$datos_basicos->barrio}} </td>
            </tr>

            <tr>
             <td> <label style="font-weight: bold;"> Comuna </label> </td> 
             <td> {{$datos_basicos->direccion}} </td>
            </tr>

            <tr>
             <td> <label style="font-weight: bold;"> Ciudad </label> </td> 
             <td> {{$datos_basicos->txtLugarResidencia}} </td>
            </tr>

            <tr>
             <td> <label style="font-weight: bold;"> Teléfono CASA </label> </td>
             <td> {{$datos_basicos->telefono_fijo}} </td>
            </tr>

            <tr>
              <td> <label style="font-weight: bold;"> Teléfono CELULAR</label> </td>
              <td>  {{$datos_basicos->telefono_movil}} </td>
            </tr>

            <tr>
             <td> <label style="font-weight: bold;"> Teléfono recados (indique contacto) </label> </td>
             <td> {{$datos_basicos->contacto_externo}} </td>
            </tr>

            <tr>
             <td> <label style="font-weight: bold;"> Fecha Nacimiento </label> </td>
             <td> {{$datos_basicos->fecha_nacimiento}} </td>
            </tr>
            <tr>
             <td> <label style="font-weight: bold;"> Estado Civil </label></td>
             <td> {{$datos_basicos->estado_civil_des}} </td>
            </tr>
     
           @foreach($hijos as $hijo)
            <tr>
             <td> <label style="font-weight: bold;"> Hijo; Edad/Carga: (SI–NO) </label> </td>
             <td> {{$hijo->nombres.' '.$hijo->primer_apellido}} / {{$hijo->edad}} / si </td>
            </tr>
           @endforeach

            <tr>
             <td> <label style="font-weight: bold;"> Dirección e-mail  </label> </td>
             <td> {{$datos_basicos->email}} </td>
            </tr>
            <tr>
             <td> <label style="font-weight: bold;"> Nivel Estudio </label> </td>
             <td> {{$datos_basicos->nivel_estudiado}} </td>
            </tr>

            <tr>
              <td> <label style="font-weight: bold;"> AFP </label> </td>
              <td> {{$datos_basicos->entidades_afp_des}} </td>
            </tr>

            <tr>
              <td> <label style="font-weight: bold;"> ISAPRE o Sistema de Salud  </label> </td>
              <td> {{$datos_basicos->entidades_eps_des}} </td>
            </tr>

            <tr>
             <td> <label style="font-weight: bold;"> Talla zapatos </label> </td>
             <td> {{$datos_basicos->talla_zapatos}} </td>
            </tr>
            <tr>
             <td> <label style="font-weight: bold;"> Talla polera </label> </td>
             <td> {{$datos_basicos->talla_camisa}} </td>
            </tr>

            <tr>
              <td> <label style="font-weight: bold;"> Talla pantalón </label> </td>
              <td> {{$datos_basicos->talla_pantalon}} </td>
            </tr>
            <tr>
              <td> <label style="font-weight: bold;"> Talla falda </label> </td>
              <td> {{$datos_basicos->talla_pantalon}} </td>
            </tr>

          </table>

           <table class="tabla1">

            <tr>
             <td style="text-align:center;font-weight: bold;"><label> ¿Puede trabajar de día? </label><br>
                  {{$datos_basicos->trabajo_dia}} 
             </td>
             <td style="text-align:center;font-weight: bold;"><label> ¿Puede trabajar de noche? </label><br>
                  {{$datos_basicos->trabajo_noche}} 
             </td>
             <td style="text-align:center;font-weight: bold;"><label> ¿Puede trabajar fines de semana? </label><br>
                  {{$datos_basicos->tabajo_fin}} 
             </td>
             <td style="text-align:center;font-weight: bold;"><label> ¿Puede trabajar part time? </label><br>
                  {{$datos_basicos->part_time}}  
              </td>
            </tr>
          </table>

          <table class="tabla1">
            <tr>
             <td colspan="2"><label style="font-weight: bold;">Número de Cuenta</label></td>
             <td colspan="2"> {{$datos_basicos->numero_cuenta}} </td>
            </tr>
            <tr>
             <td colspan="2"> <label style="font-weight: bold;">Tipo de Cuenta</label> </td>
             <td colspan="2"> {{$datos_basicos->tipo_cuenta}} </td>
            </tr>
            <tr>
             <td colspan="2"><label style="text-align:center; font-weight: bold;"> Banco </label></td>
             <td colspan="2"> {{$datos_basicos->nombre_banco_des}} </td>
            </tr>
            <tr> <td colspan="4"> <strong style="text-align:center;"> Certifico que los datos e informaciones aquí escritos son fidedignos a mi realidad actual, por lo tanto
             entiendo que queda bajo mi responsabilidad la actualización de los mismos en el caso de formalizar una relación contractual con Empresas HumanNet. </strong> </td> 
            </tr>

            <tr> 
              <td colspan="4" style="text-align:center; font-weight: bold;"> 
                <strong>___________________________ </strong> <br>
                           Firma del Postulante.
              </td>
            </tr>

             <tr> <td> <strong> Cargo Especifico </strong> : {{$requerimiento->cargo}} </td> 
            </tr>

          </table>
       <br>
    </body>

</html>
