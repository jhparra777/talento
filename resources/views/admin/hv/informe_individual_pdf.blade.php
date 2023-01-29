<!DOCTYPE html>
<html>
<head>
	<title>
		Informe individual
	</title>

<style type="text/css">
	
	table th, table td{
		text-align: center;
	}
	h3{
		text-decoration: underline;
	}
	.fondo{
		background: rgb(210,210,210);
	}
	table.datosbasicos th,table.datosbasicos th{
		text-align: left;
	}
  .datos{
    margin-bottom: 100px;
  }
  .encabezado{
    margin-bottom: 50px;
  }
  .centrado{
    text-align: center;
  }
  
  .encabezado div{
     width: 50%;
    display: inline-block;
   
  }
  .encabezado div:first-child{
    text-align: left;
  }

  .encabezado div:nth-child(2) img{
    float: right;
  }
</style>
</head>
<body>
  <div class="encabezado row">
       <div class="col-sm-4">
        <p><strong>Cliente:</strong>{{$requerimiento->cliente}}</p>
         <p><strong>Cargo:</strong>{{$requerimiento->cargo}}</p>
          <p><strong>Fecha:</strong>{{$fecha}}</p>
       </div>
       <div class="col-sm-4 col-sm-offset-4">
          @if(isset(FuncionesGlobales::sitio()->logo))
                        @if(FuncionesGlobales::sitio()->logo != "")
                          <img alt="Logo T3RS" class="" height="auto" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" width="150">
                        @else
                          <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                        @endif

                      @else

                        <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
          @endif
       </div>

    
  </div>

	 @if($requerimientoCompetencias->count()>0)
	 <h1 class="fondo" class="centrado" style="text-align: center;">Informe individual</h1>
<div style="text-align: center;" class="datos">
  <img src="{{ url('recursos_datosbasicos/'.$datos_basicos->foto)}}" height="115" width="115" style="margin: auto;" />


  <br>

   <table class="datosbasicos" style="margin: auto;">
    <tr>
      <th>Nombres y Apellidos:</th>
      <td>{{$datos_basicos->nombres}} {{$datos_basicos->primer_apellido}} {{$datos_basicos->segundo_apellido}}</td>
    </tr>
    <tr>
      <th>Edad:</th>
      <td>
      {{$edad}}
    </td>
    </tr>
    <tr>
      <th>Estado Civil:</th>
      <td>{{$datos_basicos->estado_civil}}</td>
    </tr>
    <tr>
      <th>Ciudad:</th>
      <td> @if ($datos_basicos->ciudad_residencia != '')
                          {{ \App\Models\Ciudad::GetCiudad($datos_basicos->pais_residencia, $datos_basicos->departamento_residencia, $datos_basicos->ciudad_residencia) }}
          @else
          No especifica
           @endif

      </td>
    </tr>
   </table>
</div>
	 

	

	<h2 class="fondo">Desempeño en el proceso</h2>

	<h3>Entrevista BEI:</h3>
    <p>
        La entrevista por incidentes críticos es una entrevista que permite medir e identificar las competencias del entrevistado tanto en concurrencia cuanto en solidez y consistencia.
    </p>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 <table class="table table-stripped table-bordered informe_inidivual" style="margin: auto;">
                      <tr style="background: rgb(210,210,210);">
                          <th class="text-center" style="">Competencia</th>
                          <th class="text-center">Nivel Esperado</th>
                           <th class="text-center">Nivel Alcanzado</th>
                      </tr>
                         @foreach($entrevista_bei as $a)
                           <tr>
                               <td class="text-center">{{$a->competencia}}</td>
                               <td class="text-center">{{$a->ideal}}</td>
                               <td class="text-center">{{$a->puntuacion}}</td>
                           </tr>
                          
                            
                        @endforeach

                 </table>

            </div>
        </div>
       
@if($evaluacion>0)
    <h3>Evaluación Psicotécnica:</h3>
    <p>
        La evaluación de copetencias por psicometría permite homologar los criterios de evaluación, valorar las competencias sobresalientes y realizar un diagnóstico de áreas de oportunidad.
    </p>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 <table class="table table-stripped table-bordered" style="margin: auto;">
                      <tr style="background: rgb(210,210,210);">
                          <th class="text-center">Competencia</th>
                           <th class="text-center">Nivel Esperado</th>
                           <th class="text-center">Nivel Alcanzado</th>
                      </tr>
                         @foreach($requerimientoCompetencias as $req)
                         <tr>
                             <td class="text-center">{{$req->competencia}}</td>
                             <td class="text-center">{{$req->ideal}}</td>
                              <td class="text-center">{{$req->evaluacion_psico}}</td>

                         </tr>
                          
                            
                        @endforeach

                 </table>

            </div>
        </div>

@endif
@if($assessment>0)
    <h3>Assessment Center:</h3>
    <p>
       El taller Assessment Center permite evidenciar competencias que poseen los candidatos en situaciones concretas, que pueden relacioarse con su futuro desempeño.

       Se ha consolidado la puntuación otorgada por los observadores para el candidato, obteniendo los siguientes resultados.
    </p>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 <table class="table table-stripped table-bordered" style="margin: auto;">
                      <tr style="background: rgb(210,210,210);">
                          <th class="text-center">Competencia</th>
                          <th class="text-center">Nivel Esperado</th>
                           <th class="text-center">Nivel Alcanzado</th>
                      </tr>
                         @foreach($requerimientoCompetencias as $req)
                         <tr>
                             <td class="text-center">{{$req->competencia}}</td>
                             <td class="text-center">{{$req->ideal}}</td>
                              <td class="text-center">{{$req->assessment_center}}</td>

                         </tr>
                          
                            
                        @endforeach

                 </table>

            </div>
        </div>

@endif
@if($referencias>0)
        <h3>Referencias Laborales:</h3>
    <p>
      Las referencias laborales indagan sobre el desempeño del candidato en sus anteriores empresas, haciendo énfasis en las competencias evidenciadas durante su permanencia en las mismas.
    </p>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 <table class="table table-stripped table-bordered" style="margin: auto;">
                      <tr style="background: rgb(210,210,210);">
                          <th class="text-center">Competencia</th>
                           <th class="text-center">Nivel Esperado</th>
                           <th class="text-center">Nivel Alcanzado</th>
                      </tr>
                         @foreach($requerimientoCompetencias as $req)
                         <tr>
                             <td class="text-center">{{$req->competencia}}</td>
                             <td class="text-center">{{$req->ideal}}</td>
                            <td class="text-center">{{$req->referencias}}</td>

                         </tr>
                          
                            
                        @endforeach

                 </table>

            </div>
        </div>

 

@endif

 <h2 class="fondo">Observaciones y recomendaciones</h2>

     <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
            
             <p>{{$requerimientoCompetencias[0]->observaciones}}</p>
          </div>

    </div>

      @else

      		<h2>No se ha realizado Assessment</h2>

      @endif
           

</body>
</html>