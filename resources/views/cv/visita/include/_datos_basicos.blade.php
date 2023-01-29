            
<div class="panel panel-default">
        <div class="panel-heading">
            <h3>Datos identificación del aspirante</h3>
        </div>
        <div class="panel-body">
                
            <form id="form-1" data-smk-icon="glyphicon-remove-sign" name="form-1" class="formulario">
                {{--<input name="requerimiento_id" type="hidden" value="{{$req_id}}">
                <input name="candidato_id" type="hidden" value="{{$candidatos->user_id}}">--}}

                <input name="id_visita" type="hidden" value="{{$candidatos->id_visita}}">
                @if(isset($edit))
                    
                        <input name="edit" type="hidden" value="{{$edit}}">
                    
                @endif
            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Identificación <span>*</span> 
                        </label>
                        
                            {!! Form::text("numero_id",$candidatos->numero_id,["required","class"=>"form-control solo_numeros","id"=>"numero_id","required"=>true,"readonly"=>true]) !!}
                    
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Primer nombre <span>*</span> 
                        </label>
                        
                            {!! Form::text("primer_nombre",$candidatos->primer_nombre,["required","class"=>"
                            form-control","id"=>"primer_nombre","required"=>true]) !!}
                   
                    </div>
                    
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Segundo nombre <span></span> 
                        </label>
                        
                            {!! Form::text("segundo_nombre",$candidatos->segundo_nombre,["class"=>"
                            form-control","id"=>"segundo_nombre"]) !!}
                        
                    </div>
                    <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Primer apellido <span>*</span> 
                        </label>
                        
                            {!! Form::text("primer_apellido",$candidatos->primer_apellido,["required","class"=>"
                            form-control","id"=>"primer_apellido","required"=>true]) !!}
                        
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class=" form-group">
                    <label class="control-label" for="inputEmail3">
                        Segundo apellido <span></span> 
                    </label>
                    
                        {!! Form::text("segundo_apellido",$candidatos->segundo_apellido,["class"=>"
                        form-control","id"=>"segundo_apellido"]) !!}
                    
                    </div>
                  
                </div>



                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Fecha nacimiento<span>*</span> 
                        </label>
                        
                            {!! Form::text("fecha_nacimiento",$candidatos->fecha_nacimiento,["class"=>"form-control", "id"=>"fecha_nacimiento" , "placeholder"=>"Fecha Nacimiento", "readonly" => "readonly","required"=>true]) !!}
                    
                     </div>
                    
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Fecha expedición de documento<span>*</span> 
                        </label>
                       
                            {!! Form::text("fecha_expedicion",$candidatos->fecha_expedicion,["class"=>"form-control", "id"=>"fecha_expedicion" , "placeholder"=>"Fecha Expedición", "readonly" => "readonly","required"=>true]) !!}
                    
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            País expedición de documento<span>*</span> </label>

                        
                            {!! Form::select("pais_id",$paises,$candidatos->pais_id,["class"=>"form-control","placeholder"=>"","id"=>"pais_id"]) !!}
                        
                        
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Dpto expedición de documento<span>*</span> </label>

                      

                            {!! Form::select("departamento_expedicion_id",$dptos_expedicion,$candidatos->departamento_expedicion_id,["class"=>"form-control","placeholder"=>"","id"=>"departamento_expedicion_id"]) !!}
                        
                        
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Ciudad expedición de documento<span>*</span> </label>

                        
                            
                            {!! Form::select("ciudad_expedicion_id",$ciudades_expedicion,$candidatos->ciudad_expedicion_id,["class"=>"form-control","placeholder"=>"","id"=>"ciudad_expedicion_id","required"=>true]) !!}
                        
                       
                    </div>
                </div>

                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Email<span>*</span> 
                        </label>
                        
                            {!! Form::text("email",$candidatos->email,["class"=>"
                            form-control","id"=>"email","required"=>true]) !!}
                       
                      
                    </div> 
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Estado civil <span>*</span> 
                        </label>
                       
                            {!! Form::select("estado_civil",$estadoCivil,$candidatos->estado_civil,["class"=>"form-control selectcategory" ,"id"=>"estado_civil","required"=>true]) !!}
                        
                       
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            Grupo sanguineo <span>*</span> 
                        </label>
                       
                            {!! Form::select("grupo_sanguineo",[""=>"Seleccionar","A"=>"A","B"=>"B","O"=>"O","AB"=>"AB"],$candidatos->grupo_sanguineo,["class"=>"form-control selectcategory", "id"=>"grupo_sanguineo","required"=>true]) !!}
                       

                        
                    </div>  
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            RH <span>*</span> 
                        </label>
                        
                            {!! Form::select("rh",[""=>"Seleccionar","positivo"=>"Positivo","negativo"=>"Negativo"],$candidatos->rh,["class"=>"form-control selectcategory", "id"=>"rh","required"=>true]) !!}
                       
                      
                    </div>
                 </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            País residencia<span>*</span> </label>

                        
                            {!! Form::select("pais_residencia",$paises,$candidatos->pais_residencia,["class"=>"form-control","placeholder"=>"","id"=>"pais_residencia"]) !!}
                        
                       
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Dpto residencia<span>*</span> </label>

                        

                            {!! Form::select("departamento_residencia",$dptos_residencia,$candidatos->departamento_residencia,["class"=>"form-control","placeholder"=>"","id"=>"departamento_residencia"]) !!}
                        
                       
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Ciudad residencia<span>*</span> </label>

                       
                            
                            {!! Form::select("ciudad_residencia",$ciudades_residencia,$candidatos->ciudad_residencia,["class"=>"form-control","placeholder"=>"","id"=>"ciudad_residencia","required"=>true]) !!}
                        
                       
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Dirección de residencia<span>*</span> 
                        </label>
                       
                            {!! Form::text("direccion",$candidatos->direccion,["class"=>"
                            form-control","id"=>"direccion","required"=>true]) !!}
                        
                       
                    </div>
                </div>

                    
            </div>
                <div class="row">
                    
                     <div class="col-md-6 ">
                        <div class="form-group">
                        <label class="control-label" for="inputEmail3">
                            Barrio <span>*</span> 
                        </label>
                            
                            {!! Form::text("barrio",$candidatos->barrio,["class"=>"
                            form-control","id"=>"barrio","required"=>true]) !!}
                            
                        </div>
                    </div>
                    
                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="inputEmail3">
                                Nivel escolaridad <span>*</span> 
                            </label>
                            
                                {!! Form::select("nivel_escolaridad",$nivelEstudios,null,["class"=>"form-control selectcategory" ,"id"=>"nivel_escolaridad","required"=>true]) !!}
                           
                            
                        </div>  
                    </div>
                     

                    

                </div>
                
                <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="inputEmail3">
                                Teléfono móvil <span>*</span> 
                            </label>
                            
                               {!!Form::text("telefono_movil",$candidatos->telefono_movil,["class"=>"form-control","id"=>"telefono_movil","required"=>true]) !!}
                        </div>
                       
                    </div>  
                 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="inputEmail3">
                                Teléfono fijo <span></span> 
                            </label>
                            
                               {!!Form::text("telefono_fijo",$candidatos->telefono_fijo,["class"=>"form-control","id"=>"telefono_fijo"]) !!}
                           
                       
                        </div>
                    </div>
                </div>

                <div class="row">
                   
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="inputEmail3">
                                ¿Libreta militar?<span></span> 
                            </label>
                            
                                {!! Form::select("tiene_libreta",[""=>"Seleccione","1"=>"Si","2"=>"No"],null,["class"=>"
                                form-control","id"=>"tiene_libreta"]) !!}
                           
                       
                        </div> 
                    </div>
                   <div id="depend-libreta">
                        <div class="col-md-6" >
                            <div class="form-group">
                                <label class="control-label" for="inputEmail3">
                                    No. Libreta militar<span></span> 
                                </label>
                               
                                    {!! Form::text("numero_libreta",$candidatos->numero_libreta,["class"=>"
                                    form-control","id"=>"numero_libreta"]) !!}
                            
                             
                            </div>
                        </div>

                        <div class="col-md-6 depend-libreta">
                            <div class="form-group">
                                <label class="col-sm-12 control-label" for="inputEmail3">
                                    Categoría <span></span> 
                                </label>
                                
                                    {!! Form::select("clase_libreta",$claseLibreta,$candidatos->clase_libreta,["class"=>"form-control selectcategory" ,"id"=>"clase_libreta"]) !!}
                                
                                
                            </div>
                        </div>
                    </div>

                </div>

            @if(!is_null($candidatos->requerimiento_id))
                <div class="row">
                    

                    

                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            Cargo <span></span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("cargo_nombre",$candidatos->cargo,["class"=>"
                            form-control","id"=>"cargo_nombre","disabled"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>

                    <div class="col-md-6 form-group">
                        <label class="col-sm-12 control-label" for="inputEmail3">
                            Cliente <span></span> 
                        </label>
                        <div class="col-sm-12">
                            {!! Form::text("cliente_nombre",$candidatos->cliente,["class"=>"
                            form-control","id"=>"cliente_nombre","disabled"]) !!}
                        </div>
                        <label id="ciudad_id" class="hidden text text-danger"> Este campo es Requerido</label>  
                    </div>

                </div>
            @endif
                

            </form>
        </div>
</div>

<script type="text/javascript">
    var confDatepicker = {
    altFormat: "yy-mm-dd",
    dateFormat: "yy-mm-dd",
    changeMonth: true,
    changeYear: true,
    buttonImage: "img/gifs/018.gif",
    buttonImageOnly: true,
    autoSize: true,
    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
    yearRange: "1930:2050"
};

$(function(){

    var confDatepicker = {
                    altFormat: "yy-mm-dd",
                    dateFormat: "yy-mm-dd",
                    changeMonth: true,
                    changeYear: true,
                    buttonImage: "img/gifs/018.gif",
                    buttonImageOnly: true,
                    autoSize: true,
                    dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
                    monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                    dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                    yearRange: "1930:2050"
                };

                $("#fecha_nacimiento,#fecha_expedicion").datepicker(confDatepicker);

                $("#depend-libreta").hide();
                    $("#tiene_libreta").on("change", function () {
                        if($(this).val()==1){
                           $("#depend-libreta").toggle('slow');
                           $("#numero_libreta,#clase_libreta").attr("required","required");

                            
                        }
                        else{
                            $("#depend-libreta").hide('slow');
                            $("#numero_libreta,#clase_libreta").removeAttr("required");
                        }

                        
                });

                $("#pais_id").change(function(){
                var valor = $(this).val();

                $.ajax({
                    url: "{{ route('cv.selctDptos') }}",
                    type: 'POST',
                    data: {id: valor},
                    success: function(response){
                        var data = response.dptos;
                        $('#departamento_expedicion_id').empty();
                        $('#departamento_expedicion_id').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#departamento_expedicion_id').append("<option value='" + key + "'>" + element + "</option>");
                        });

                        $('#ciudad_expedicion_id').empty();
                        $('#ciudad_expedicion_id').append("<option value=''>Seleccionar</option>");
                    }
                });
            });

            $("#departamento_expedicion_id").change(function(){
                var valor = $(this).val();
                var pais=$("#pais_id").val();

                $.ajax({
                    url: "{{ route('cv.selctCiudades') }}",
                    type: 'POST',
                    data: {
                        id: valor,
                        pais:pais
                    },
                    success: function(response){
                        var data = response.ciudades;
                        $('#ciudad_expedicion_id').empty();
                        $('#ciudad_expedicion_id').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#ciudad_expedicion_id').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    }
                });
            });

            $("#pais_residencia").change(function(){
                var valor = $(this).val();

                $.ajax({
                    url: "{{ route('cv.selctDptos') }}",
                    type: 'POST',
                    data: {id: valor},
                    success: function(response){
                        var data = response.dptos;
                        $('#departamento_residencia').empty();
                        $('#departamento_residencia').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#departamento_residencia').append("<option value='" + key + "'>" + element + "</option>");
                        });

                        $('#ciudad_residencia').empty();
                        $('#ciudad_residencia').append("<option value=''>Seleccionar</option>");
                    }
                });
            });

            $("#departamento_residencia").change(function(){
                var valor = $(this).val();
                var pais=$("#pais_residencia").val();
                $.ajax({
                    url: "{{ route('cv.selctCiudades') }}",
                    type: 'POST',
                    data: {
                        id: valor,
                        pais:pais
                    },
                    success: function(response){
                        var data = response.ciudades;
                        $('#ciudad_residencia').empty();
                        $('#ciudad_residencia').append("<option value=''>Seleccionar</option>");

                        $.each(data, function(key, element) {
                            $('#ciudad_residencia').append("<option value='" + key + "'>" + element + "</option>");
                        });
                    }
                });
            });

})



</script>
