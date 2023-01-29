
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">
    Gestión informe individual. 
    </h4>
    <h4>
         Proceso #:{{$req}}
    </h4>
    <h4>
        Candidato:<strong>{{ strtoupper($datos_basicos->nombres) }} {{ strtoupper($datos_basicos->primer_apellido) }}</strong>
    </h4>
</div>
<div class="modal-body">
    {!! Form::open(["class"=>"form-horizontal", "role"=>"form", "id"=>"fr_individual"]) !!}

        {!! Form::hidden("user_id",$candidato) !!}
        {!! Form::hidden("requerimiento",$req) !!}

        @if($requerimientoCompetencias->count()>0)
       
    <h3>Entrevista BEI:</h3>
    <p>
        La entrevista por incidentes críticos es una entrevista que permite medir e identificar las competencias del entrevistado tanto en concurrencia cuanto en solidez y consistencia.
    </p>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 <table class="table table-stripped table-bordered informe_inidivual">
                      <tr style="background: rgb(210,210,210);">
                          <th class="text-center">Competencia</th>
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
       

    <h3>Evaluación  Psicotécnica:</h3>
    <p>
        La evaluación de competencias por psicometría permite homologar los criterios de evaluación, valorar las competencias sobresalientes y realizar un diagnóstico de áreas de oportunidad.
    </p>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 <table class="table table-stripped table-bordered">
                      <tr style="background: rgb(210,210,210);">
                          <th class="text-center">Competencia</th>
                           <th class="text-center">Nivel Esperado</th>
                           <th class="text-center">Nivel Alcanzado</th>
                      </tr>
                         @foreach($requerimientoCompetencias as $req)
                         <tr>
                             <td class="text-center">{{$req->competencia}}</td>
                             <td class="text-center">{{$req->ideal}}</td>
                              <td class="text-center">{!!Form::text("listado[$req->id_competencia][evaluacion]",$req->evaluacion_psico,["class"=>"form-control"]);!!}</td>

                         </tr>
                          
                            
                        @endforeach

                 </table>

            </div>
        </div>

    <h3>Assessment Center:</h3>
    <p>
       El taller Assessment Center permite evidenciar competencias que poseen los candidatos en situaciones concretas, que pueden relacioarse con su futuro desempeño.

       Se ha consolidado la puntuación otorgada por los observadores para el candidato, obteniendo los siguientes resultados.
    </p>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 <table class="table table-stripped table-bordered">
                      <tr style="background: rgb(210,210,210);">
                          <th class="text-center">Competencia</th>
                          <th class="text-center">Nivel Esperado</th>
                           <th class="text-center">Nivel Alcanzado</th>
                      </tr>
                        @foreach($requerimientoCompetencias as $req)
                         <tr>
                             <td class="text-center">{{$req->competencia}}</td>
                             <td class="text-center">{{$req->ideal}}</td>
                              <td class="text-center">{!!Form::text("listado[$req->id_competencia][assessment_center]",$req->assessment_center,["class"=>"form-control"]);!!}</td>

                         </tr>
                          
                            
                        @endforeach

                 </table>

            </div>
        </div>

        <h3>Referencias Laborales:</h3>
    <p>
      Las referencias laborales indagan sobre el desempeño del candidato en sus anteriores empresas, haciendo énfasis en las competencias evidenciadas durante su permanencia en las mismas.
    </p>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                 <table class="table table-stripped table-bordered">
                      <tr style="background: rgb(210,210,210);">
                          <th class="text-center">Competencia</th>
                           <th class="text-center">Nivel Esperado</th>
                           <th class="text-center">Nivel Alcanzado</th>
                      </tr>
                         @foreach($requerimientoCompetencias as $req)
                         <tr>
                             <td class="text-center">{{$req->competencia}}</td>
                             <td class="text-center">{{$req->ideal}}</td>
                            <td class="text-center">{!!Form::text("listado[$req->id_competencia][referencias]",$req->referencias,["class"=>"form-control"]);!!}</td>

                         </tr>
                          
                            
                        @endforeach

                 </table>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12 form-group">
              <label for="" class="col-sm-1 control-label">Observaciones:</label>
              <div class="col-sm-12">
                  {!! Form::textarea("observaciones",$requerimientoCompetencias[0]->observaciones,["class"=>"form-control","placeholder"=>"Observaciones" ]); !!}
              </div>
              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
          </div>

        </div>
      
        
    {!! Form::close() !!}

    @else
        No hay evaluacion de Assessment

    @endif
   
</div>
<div class="modal-footer">

    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    @if($requerimientoCompetencias->count()>0)
    
   
        <button type="button" class="btn btn-success" id="guardar_informe_individual">Guardar</button>
    @endif
    
</div>