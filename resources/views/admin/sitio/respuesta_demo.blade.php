
<!-- Inicio contenido principal -->
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
          <div class="alert alert-success" role="alert">
                                           Respuesta del candidato
                                          </div>    
   <br>
 <div class="clearfix"></div> 
    <div class="form-alt">
                    <div class="row">
                       <div class="col-right-item-container">
                        <div class="container-fluid">
                            <div class="col-sm-12">
                                <div id="submit_listing_box">
                                    <h3>
                                        

                                    </h3>
                                    <div class="form-alt">
                                        <div class="row">
                                           <div class="form-group col-md-12">
                                         
                            
                            <div>
                                                   <video height="400px" controls>
    <source src="{{asset("recursos_videoPrueba/"."$respuesta->video_entrevista_prueba?".date('His'))}}" type="video/webm">
   
</video>
                        
                                
                               
                            </div>
                            <br>
                               {{--  <div class="form-group col-md-6 col-sm-12 col-xs-12">
                            <label>
                                Video Perfil
                                <span>
                                </span>
                            </label>
                            {!! Form::file("video-blob",["class"=>"form-control", "id"=>"video-blob" ,"name"=>"video-blob" ]) !!}
                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("video-blob",$errors) !!}
                            </p>
                        </div> --}}
            
                        </div>
                                        </div>
                                    </div>
                                </div>
                                            <div style="text-align: center;" class="col-sm-12">
           

                                    {{-- <h1 id="numero">45</h1> --}}
                                 
                                

                                {{--  @if($user->video_perfil ==true)
                                        <a  href="{{asset("recursos_videoperfil/"."$user->video_perfil?".date('His'))}}" class="btn btn-warning" target="_black" >
                                        Video Perfil
                                    </a>
                                @endif --}}
             
        </div>
                            </div>
                        </div>
                    </div>
                    </div>

                </div>

    <div class="clearfix"></div>

    <br><br>
  
   
       

    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
    

</div>


