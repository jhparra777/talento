<div class="panel panel-default item">
        <div class="panel-heading">
            <h3>Estado de salud</h3>
        </div>
        <div class="panel-body">
            
            <form id="form-7" data-smk-icon="glyphicon-remove-sign" name="form-3" class="formulario">
                <div class="row">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Frecuencia con la que asiste al médico<span></span> 
                                </label>
                               
                                     {!! Form::select("frecuencia_asistencia_medico",$frecuencia,$candidatos->frecuencia_asistencia_medico,["class"=>"form-control selectcategory" ,"id"=>"frecuencia_asistencia_medico","required"=>true]) !!}
                            
                           
                            </div> 
                        </div>

                        <div id="depend_frecuencia" >
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="inputEmail3">
                                        ¿Por qué esta frecuencia?<span></span> 
                                    </label>
                                    
                                         {!! Form::textarea("por_que_frecuencia",$candidatos->por_que_frecuencia,["class"=>"form-control selectcategory" ,"id"=>"por_que_frecuencia","placeholder"=>"Explique el por qué asiste al médico con la frecuencia seleccionada anteriormente","rows"=>5]) !!}
                                
                                
                                </div>  
                            </div>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Servicios médicos y/o EPS del evaluado<span></span> 
                                </label>
                                
                                     {!! Form::textarea("eps_evaluado",$candidatos->eps_evaluado,["class"=>"form-control selectcategory" ,"id"=>"eps_evaluado","placeholder"=>"Nombre de la EPS en la que cotiza actualmente","required"=>true,"rows"=>5]) !!}
                            
                            
                            </div>  
                        </div>
                        

                         
                        

                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    Intervenciones quirúrgicas y/o hospitalizaciones<span></span> 
                                </label>
                                
                                     {!! Form::textarea("interveciones",$candidatos->interveciones,["class"=>"form-control selectcategory" ,"id"=>"intervenciones","placeholder"=>"Señale si ha tenido alguna intervención quirúrgica ó cirugía y hace cuanto tiempo.","required"=>true,"rows"=>5]) !!}
                            
                            
                            </div>  
                        </div>

                        {{--<div class="col-md-12 form-group">
                            <label class="col-sm-12 control-label" for="inputEmail3">
                                Que enfermedades existen en la familia<span></span> 
                            </label>
                            <div class="col-sm-12">
                                 {!! Form::textarea("enfermedades_familia",$candidatos->enfermedades_familia,["class"=>"form-control selectcategory" ,"id"=>"enfermedades_familia","required"=>true,"rows"=>5]) !!}
                            </div>
                            <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                        </div>--}}
                        <div class="container">
                             <label for="banner">Enfermedades en la familia:</label>
                             <table class="table table-bordered table-striped enfermedades">
                            <thead>
                                <tr>
                                    <th>Enfermedad</th>
                                    <th>Quién la padece</th>
                                </tr>
                               
                               
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Alergias</td>
                                    <td>{!! Form::select("alergias",$parentescos,$enfermedades_familia["alergias"],["class"=>"form-control selectcategory" ,"id"=>"alergias"]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Alzheimer</td>
                                    <td>{!! Form::select("alzheimer",$parentescos,$enfermedades_familia["alzheimer"],["class"=>"form-control selectcategory" ,"id"=>"alzheimer"]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Cancer</td>
                                    <td>{!! Form::select("cancer",$parentescos,$enfermedades_familia["cancer"],["class"=>"form-control selectcategory" ,"id"=>"cancer"]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Diabetes</td>
                                    <td>{!! Form::select("diabetes",$parentescos,$enfermedades_familia["diabetes"],["class"=>"form-control selectcategory" ,"id"=>"diabetes"]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Epilepsia</td>
                                    <td>{!! Form::select("epilepsia",$parentescos,$enfermedades_familia["epilepsia"],["class"=>"form-control selectcategory" ,"id"=>"epilepsia"]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Hipertensión</td>
                                    <td>{!! Form::select("hipertension",$parentescos,$enfermedades_familia["hipertension"],["class"=>"form-control selectcategory" ,"id"=>"hipertension"]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Asma</td>
                                    <td>{!! Form::select("asma",$parentescos,$enfermedades_familia["asma"],["class"=>"form-control selectcategory" ,"id"=>"asma"]) !!}</td>
                                </tr>
                                <tr>
                                    <td>EPOC</td>
                                    <td>{!! Form::select("epoc",$parentescos,$enfermedades_familia["epoc"],["class"=>"form-control selectcategory" ,"id"=>"epoc"]) !!}</td>
                                </tr>
                                <tr>
                                    <td>Otras enfermedades:</td>
                                    <td>{!! Form::textarea("otra_enfermedad_familiar",$candidatos->otra_enfermedad_familiar,["class"=>"form-control" ,"id"=>"otra_efermedad_familiar","rows"=>3,"placeholder"=>"En caso de que haya seleccionado 'otros' en las anteriores enfermedades, por favor especifique quién la padece. Acá tambien puede agregar otras enfermedades presentes en su familia"]) !!}</td>
                                </tr>
                                
                               
                            </tbody>
                        </table>
                        </div>
                       

                        @if($current_user->inRole('admin'))
                            <br>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label" for="inputEmail3">
                                        Observaciones generales<span></span> 
                                    </label>
                                    
                                         {!! Form::textarea("observaciones_estado_salud",$candidatos->observaciones_estado_salud,["class"=>"form-control selectcategory" ,"id"=>"observaciones_estado_salud","placeholder"=>"Este espacio sería de uso exclusivo de la psicóloga, quien registraría alguna observación importante hallada según lo descrito anteriormente por el evaluado.","required"=>true,"rows"=>5]) !!}
                                
                                
                                </div>  
                            </div>
                        @endif

                    
                </div>
                </div>
            </form>
        </div>

</div>
<script type="text/javascript">

     $(function(){
        $("#depend_frecuencia").hide();
 
        if($("#frecuencia_asistencia_medico").val()==1 || $("#frecuencia_asistencia_medico").val()==2 ||$("#frecuencia_asistencia_medico").val()==3){
            $("#depend_frecuencia").toggle('slow');
            $("#por_que_frecuencia").attr("required","required");
        }

        $("#frecuencia_asistencia_medico").on("change", function () {
            if($(this).val()==1 || $(this).val()==2 || $(this).val()==3){
                $("#depend_frecuencia").slideDown();
                $("#por_que_frecuencia").attr("required","true");
            }
            else{
                $("#depend_frecuencia").slideUp();
                $("#por_que_frecuencia").removeAttr("required");
            }
            
         });

    });

            
            


   
</script>

