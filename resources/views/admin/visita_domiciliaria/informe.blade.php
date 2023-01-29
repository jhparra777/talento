<!DOCTYPE html>
<html>
    <head>
       
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        
        <title> Informe visita - T3RS </title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        
        <style type="text/css">
          body{
            font-size: .8em;
            font-family: Helvetica, sans-serif;
          }

         .encabezado div{
         	width: 48%;
         	height: 100px;
         	float: left;
         	outline: 1px solid black;
        	text-align:center;

         }
         .img-main,{
          width: 60%;
         }
         .img-person{
          width: 100%;
         }
         .imagen-central{

         	width: 30%;
         	margin: 4em auto;
         	/*outline: 1px solid gray;*/
         	height: 200px;
         }
         section h4,h5{
         	text-align: center;
            font-weight: bold;
            background: #aca9a9;
            padding: .5em;
         }
         h5{
            
            background: #f5f5f5;
         }
         td,th{
            border: 1px solid gray;
            border-collapse: collapse;
         }
         td{
            word-break: break-all;
         }
         table{
            width: 100%;
            border:1px solid gray;
            border-collapse: collapse;
            text-align: center;
         }
         
         table.tributaria{
            width: 30%;
            float: left;
         }
         .clearfix{
            clear: both;
         }
         th{
            background: #f5f5f5;
         }
         .registro-fotografico .fila div{
            width: 48%;
            float: left;
            outline: 1px solid gray;
            height: 200px;
            margin: 2px;
         }
        </style>

    </head>
    <body>

    	<header class="encabezado">
    		<div>
    			<h2>VISITA DOMICILIARIA {{$visita->cliente}}</h2>
    		</div>
    		<div>

    			@include("admin.visita_domiciliaria.include.informe.img._img_main")


    		</div>
    	</header>
    	<div>
    		<p><strong>FECHA:</strong> {{$visita->visita_candidato->fecha_gestion_admin}}</p>
    	</div>
    	<div class="imagen-central">
    		@include("admin.visita_domiciliaria.include.informe.img._img_person")
    	</div>

    	<div id="main">
    		@if($visita->gestionado_admin)
	  			<section id="formulario-visita">

	  				@include('admin.visita_domiciliaria.include.informe._datos_basicos')
	    			@include('admin.visita_domiciliaria.include.informe._estructura_familiar')
	    			@include('admin.visita_domiciliaria.include.informe._aspecto_vivienda')
	    			@include('admin.visita_domiciliaria.include.informe._ingresos_egresos')
                    @include('admin.visita_domiciliaria.include.informe._bienes_inmuebles')
                    @include('admin.visita_domiciliaria.include.informe._informacion_tributaria')
                    @include('admin.visita_domiciliaria.include.informe._estado_salud')
                    @include('admin.visita_domiciliaria.include.informe._aspectos_familiares')
                    @include('admin.visita_domiciliaria.include.informe._recreacion')
                    @include('admin.visita_domiciliaria.include.informe._referencia_vecinal')
                    @include('admin.visita_domiciliaria.include.informe._observaciones_generales')
                    @include('admin.visita_domiciliaria.include.informe._registro_fotografico')
	  			</section>
                <section id="verificaciones">

                    @if(count($estudios_verificados))
                        <h4>
                            VERIFICACIÓNES ACADÉMICAS 
                        </h4>
                        <?php
                            $contador2=1;
                        ?>
                        @foreach($estudios_verificados as $estudio)
                            <h5>Estudio {{$contador2}}</h5>
                           <table>
                               <tr>
                                   <th>
                                       NOMBRE DE LA INSTITUCION
                                   </th>
                                   <td>
                                       {{$estudio->estudio->institucion}}
                                   </td>
                                   <th>
                                       TITULO OBTENIDO
                                   </th>
                                   <td>
                                       {{$estudio->estudio->titulo_obtenido}}
                                   </td>
                               </tr>
                               
                               <tr>
                                   <th>
                                       FECHA DE TITULO
                                   </th>
                                   <td>
                                       {{$estudio->estudio->fecha_finalizacion}}
                                   </td>
                                   <th>
                                       NUMERO DE ACTA
                                   </th>
                                   <td>
                                       {{$estudio->numero_acta}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       No. FOLIO
                                   </th>
                                   <td>
                                       {{$estudio->numero_folio}}
                                   </td>
                                   <th>
                                       CIUDAD
                                   </th>
                                   <td>
                                       {{$exp->tipo_contrato}}
                                   </td>
                               </tr>
                                <tr>
                                   <th>
                                       No. REGISTRO
                                   </th>
                                   <td>
                                       {{$estudio->numero_registro}}
                                   </td>
                                   <th>
                                       QUIEN CONFIRMA LA VERIFICACIÓN
                                   </th>
                                   <td>
                                       {{$estudio->nombre_referenciante}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       CARGO
                                   </th>
                                   <td>
                                       {{$estudio->cargo_referenciante}}
                                   </td>
                                   <th>
                                       
                                   </th>
                                   <td>
                                       
                                   </td>
                               </tr>
                               
                               <tr>
                                   <th colspan="1">
                                       OBSERVACIONES
                                   </th>
                                   <td colspan="3">
                                       {{$estudio->observaciones}}
                                   </td>
                                   
                               </tr>
                           </table>

                           <?php
                                $contador2++;
                           ?>
                        @endforeach
                    @endif

                    @if(count($experiencias_verificadas))

                        <h4>
                            VERIFICACIÓN DE REFERENCIAS LABORALES 
                        </h4>
                        <?php
                            $contador=1;
                        ?>
                        @foreach($experiencias_verificadas as $exp)
                            <h5>Experiencia {{$contador}}</h5>
                           <table>
                               <tr>
                                   <th>
                                       NOMBRE DE LA EMPRESA
                                   </th>
                                   <td>
                                       {{$exp->experiencia->nombre_empresa}}
                                   </td>
                                   <th>
                                       TELÉFONOS
                                   </th>
                                   <td>
                                       {{$exp->experiencia->telefono_temporal}}
                                   </td>
                               </tr>
                               
                               <tr>
                                   <th>
                                       NOMBRE DE JEFE INMEDIATO
                                   </th>
                                   <td>
                                       {{$exp->experiencia->nombres_jefe}}
                                   </td>
                                   <th>
                                       CARGO DESEMPEÑADO
                                   </th>
                                   <td>
                                       {{$exp->experiencia->cargo_jefe}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       DIRECCIÓN DE LA EMPRESA
                                   </th>
                                   <td>
                                       {{$exp->direccion_empresa}}
                                   </td>
                                   <th>
                                       TIPO DE CONTRATO
                                   </th>
                                   <td>
                                       {{$exp->tipo_contrato}}
                                   </td>
                               </tr>
                                <tr>
                                   <th>
                                       QUIÉN CONFIRMA LA VERIFICACIÓN
                                   </th>
                                   <td>
                                       {{$exp->nombre_referenciante}}
                                   </td>
                                   <th>
                                       CARGO
                                   </th>
                                   <td>
                                       {{$exp->cargo_referenciante}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       MOTIVO DE RETIRO
                                   </th>
                                   <td>
                                       {{$exp->direccion_empresa}}
                                   </td>
                                   <th>
                                       LABORA ACTUALMENTE
                                   </th>
                                   <td>
                                       {{$exp->tipo_contrato}}
                                   </td>
                               </tr>
                               <tr>
                                   <th>
                                       FECHA_INGRESO
                                   </th>
                                   <td>
                                       {{$exp->fecha_inicio}}
                                   </td>
                                   <th>
                                       FECHA_RETIRO
                                   </th>
                                   <td>
                                       {{$exp->fecha_retiro}}
                                   </td>
                               </tr>
                               <tr>
                                   <th colspan="1">
                                       OBSERVACIONES
                                   </th>
                                   <td colspan="3">
                                       {{$exp->fecha_inicio}}
                                   </td>
                                   
                               </tr>
                           </table>

                           <?php
                                $contador++;
                           ?>
                        @endforeach

                    @endif



                    


                </section>


  			@endif

        @if(count($vetting)>0)
              <section id="vetting">
                <p>Aqui va el vetting</p>
              </section>
        @endif
    		
    	</div>
    	
    </body>
    </html>