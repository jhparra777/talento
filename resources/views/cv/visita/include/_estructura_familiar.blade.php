
<div class="panel panel-default" >
            <div class="panel-heading">
                <h3>Estructura familiar</h3>
            </div>
            <div class="panel-body">
                <div class="alert alert-info instrucciones">
                    <p class="titulo">Instrucciones:</p>
                    <p style="text-align: justify;">
                        En este espacio,deberá registrar su núcleo familiar. Para agregar más familiares haga clic en el ícono +
                    </p>
                </div>
                <form id="form-2" data-smk-icon="glyphicon-remove-sign" name="form-2" class="formulario">
                <div class="row" id="nuevo_familiar" >
                    <div class="old">
                            <div class="row padre">
                            <div class="item col-sm-12" style="box-shadow: 3px 3px 5px gray;width: 90%;margin-left: 4%;padding: 1em; margin-top: 1%; ">
                            @if(count($familiares)>0)
                            @foreach($familiares as $fam)

                             <table class="table table-bordered tbl_info_familia">
                                <legend>Familiar</legend>
                                <tbody>

                                    <tr>
                                        <td>Parentesco:</td>
                                        <td>{!! Form::select("parentesco[]",$parentescos,$fam->parentesco_id,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Nombres y apellidos:</td>
                                        <td>{!! Form::text("nombre_familiar[]",$fam->nombres,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Edad:</td>
                                        <td>{!! Form::text("edad_familiar[]",$fam->edad_fam,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Ocupación:</td>
                                        <td>{!! Form::text("ocupacion_familiar[]",$fam->ocupacion_fam,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Estado civil:</td>
                                        <td>{!! Form::select("estado_civil_familiar[]",$estadoCivil,$fam->estado_civil_id,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                    <tr>
                                        <td>Convive con él:</td>
                                        <td>{!! Form::text("convive_con_el[]",$fam->convive_con_el,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                    <tr>
                                        <td>¿Depende económicamente de usted?:</td>
                                        <td>{!! Form::select("depend_econ_familiar[]",["Si"=>"Si","No"=>"No"],$fam->depend_econ_fam,["class"=>"form-control"]); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Número contacto:</td>
                                        <td>{!! Form::text("num_contacto_familiar[]",$fam->numero_contacto_familiar,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>

                                </tbody>
                            </table>
                            @endforeach

                            
                            @else

                                <table class="table table-bordered tbl_info_familia">

                                <tbody>

                                    <tr>
                                        <td>Parentesco:</td>
                                        <td>{!! Form::select("parentesco[]",$parentescos,null,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Nombres y apellidos:</td>
                                        <td>{!! Form::text("nombre_familiar[]",null,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Edad:</td>
                                        <td>{!! Form::text("edad_familiar[]",null,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Ocupación:</td>
                                        <td>{!! Form::text("ocupacion_familiar[]",null,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                     <tr>
                                        <td>Estado civil:</td>
                                        <td>{!! Form::select("estado_civil_familiar[]",$estadoCivil,null,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                    <tr>
                                        <td>Convive con el:</td>
                                        <td>{!! Form::text("convive_con_el[]",null,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>
                                    <tr>
                                        <td>¿Depende económicamente de usted?:</td>
                                        <td>{!! Form::select("depend_econ_familiar[]",["Si"=>"Si","No"=>"No"],"No",["class"=>"form-control"]); !!}</td>
                                    </tr>
                                    <tr>
                                        <td>Número contacto:</td>
                                        <td>{!! Form::text("num_contacto_familiar[]",null,["class"=>"form-control"]); !!}</td>

                                      
                                    </tr>

                                </tbody>
                            </table>
                            @endif
                            </div>
                        </div>
                            <div class="col-md-12 form-group last-child" style="display: block;text-align:center;">
                                <button type="button" class="btn btn-success add-item" title="Agregar otro familiar">+</button>
                                <span class="nota-add">Agregar otro familiar</span>
                            </div>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="row">
                                <div class="col-md-10 col-md-push-1">
                                    <div class="form-group">
                                        <label class="col-sm-12 control-label" for="inputEmail3">
                                            Tipo familia <span>*</span> 
                                        </label>
                                        
                                            {!! Form::select("tipo_familia",$tipo_familia,$candidatos->tipo_familia,["required","class"=>"
                                            form-control","id"=>"tipo_familiar"]) !!}
                                        
                                    </div>
                                    
                                </div>
                            @if($current_user->inRole("admin"))
                                <div class="col-md-10 col-md-push-1">
                                    <div class="form-group">
                                        <label class="col-sm-12  control-label" for="inputEmail3">
                                            Lugar que ocupa dentro del nucleo familiar <span>*</span> 
                                        </label>
                                       
                                            {!! Form::textarea("lugar_ocupa",$candidatos->lugar_ocupa,["required","class"=>"
                                            form-control","id"=>"lugar_ocupa","rows"=>3]) !!}
                                        
                                    
                                    </div>
                                </div>
                            @endif
                            </div>
                            
                        </div>
                
                </div>
            </form>
    </div>
</div>
<style type="text/css">
    .nota-add{
        color: rgb(210,210,210);
    }
</style>