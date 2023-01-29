<style type="text/css">
    @if($current_user->inRole('admin'))
        .instrucciones{
            background-color: #5bc0de!important;
        }
    @endif
    .instrucciones p{
        font-size: 1.5em;

    }
    .instrucciones ul{
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .instrucciones ul li{
        margin-left: 10px;
    }
    .instrucciones .titulo{

        font-weight: bold;
    }


</style>
<div class="panel panel-default item">
        <div class="panel-heading">
            <h3>Registro fotográfico de la visita</h3>
        </div>
        <div class="panel-body">
            <div class="alert alert-info instrucciones">
                <p class="titulo">Instrucciones:</p>
                <ul>
                    <li>* Los tipos de imágenes permitidos son jpg,jpeg,png</li>
                    <li>* El tamaño máximo para cada imagen es de 1.5 MB</li>
                    <li>* No es obligatorio la carga de todas las imágenes</li>
                    @if($current_user->inRole('admin'))
                        <li>* Si aparece la palabra "ver" indica que el evaluado ha cargado esa imagen. Si usted no carga una nueva imagen, el sistema tomará automáticamente la imagen cargada por el evaluado</li>
                    @endif
                </ul>
            </div>
            
            <br>
            <form id="form-imagenes" data-smk-icon="glyphicon-remove-sign" name="form-8" class="formulario" "files"="true" enctype="multipart/form-data">
                <input type="hidden" name="id-visita-imagenes" value="{{$candidatos->id_visita}}">
                @if(isset($edit))
                    
                    <input name="edit_2" type="hidden" value="{{$edit}}">
                     
                @endif
                <div class="row">
                    <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Foto del evaluado

                            @if($imagenes["foto_evaluado"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{ route("view_document_url", encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_evaluado"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_evaluado" type="file" id="foto_evaluado">
                                </span>
                            </label>
                            <input class="form-control" id="FOTO_EVALUADO_CAPTURA" readonly="readonly" name="foto_evaluado_captura" type="text" value="">
                        </div>
                    </div>
                   
                     <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Foto del evaluado con núcleo familiar
                            @if($imagenes["foto_evaluado_nucleo"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{ route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_evaluado_nucleo"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_evaluado_nucleo" type="file" id="foto_evaluado_nucleo">
                                </span>
                            </label>
                            <input class="form-control" id="foto_evaluado_nucleo_captura" readonly="readonly" name="foto_evaluado_nucleo_captura" type="text" value="">
                        </div>
                    </div>

                     
                     <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Sala
                            @if($imagenes["foto_sala"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{ route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_sala"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_sala" type="file" id="banner">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="sala_captura" type="text" value="">
                        </div>
                    </div>
                     <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Comedor
                            @if($imagenes["foto_comedor"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{ route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_comedor"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_comedor" type="file" id="banner">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>
                     <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Cocina
                            @if($imagenes["foto_cocina"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_cocina"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_cocina" type="file" id="foto_cocina">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>
                     <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Habitación del evaluado
                            @if($imagenes["foto_habitacion"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_habitacion"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_habitacion" type="file" id="foto_habitacion">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>
                    <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Número del apartamento
                            @if($imagenes["foto_nro_apto"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_nro_apto"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_nro_evaluado" type="file" id="foto_nro_evaluado">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>
                    <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Nomenclatura y/o dirección de la vivienda
                            @if($imagenes["foto_direccion"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_direccion"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_direccion" type="file" id="foto_direccion">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>
                     <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Fachada del conjunto
                            @if($imagenes["foto_fachada"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_fachada"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_fachada" type="file" id="foto_fachada">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>
                     <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Alrededores del conjunto
                            @if($imagenes["foto_alrededores"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_alrededores"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_alrededores" type="file" id="foto_alrededores">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>
                    <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Ubicación Whatspapp tiempo real
                            @if($imagenes["foto_ubicacion_wp"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_ubicacion_wp"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_ubicacion_wp" type="file" id="foto_ubicacion_wp">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>

                    <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Ubicación Google Maps
                            @if($imagenes["foto_ubicacion_maps"]!=null)
                                <span>
                                    <a class="" title="Ver" target="_blank" href='{{route("view_document_url",encrypt("recursos_visita_domiciliaria/".$candidatos->id_visita."/img/".$owner_pic."/"."|".$imagenes["foto_ubicacion_maps"]."|"."")) }}' style="color: green !important;">
                                    <i class="fa fa-eye" ></i> Ver </a>
                                </span>
                            @endif
                        </label>
                        <div class="input-group">
                            <label class="input-group-btn">
                                <span class="btn btn-primary btn-file">
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_ubicacion_maps" type="file" id="foto_ubicacion_maps">
                                </span>
                            </label>
                            <input class="form-control" id="banner_captura" readonly="readonly" name="banner_captura" type="text" value="">
                        </div>
                    </div>
                
                    
                   
        
                   
                
                </div>
            </form>
        </div>

</div>

<style>
    /*.lista-imagenes div div{
        border: 1px solid gray;

    }*/

</style>
<script type="text/javascript">
    $(document).on('change','.btn-file :file',function(){
  var input = $(this);
  var numFiles = input.get(0).files ? input.get(0).files.length : 1;
  var label = input.val().replace(/\\/g,'/').replace(/.*\//,'');
  input.trigger('fileselect',[numFiles,label]);
});
$(document).ready(function(){
  $('.btn-file :file').on('fileselect',function(event,numFiles,label){
    var input = $(this).parents('.input-group').find(':text');
    var log = numFiles > 1 ? numFiles + ' files selected' : label;
    if(input.length){ input.val(log); }else{ if (log) alert(log); }
  });
});
</script>


