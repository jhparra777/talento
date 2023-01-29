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
                    @if($current_user->inRole('admin'))
                        <li>* No es obligatorio la carga de todas las imágenes</li>
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
                        <label for="banner">Foto de perfil

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
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_evaluado" type="file" id="foto_evaluado" onchange="validateSize(this)">
                                </span>
                            </label>
                            <input class="form-control" id="FOTO_EVALUADO_CAPTURA" readonly="readonly" name="foto_evaluado_captura" type="text" value="">
                        </div>
                    </div>

                    <div class="form-group col-xs-6 col-sm-6">
                        <label for="banner">Foto familiar
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
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_evaluado_nucleo" type="file" id="foto_evaluado_nucleo" onchange="validateSize(this)">
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
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_sala" type="file" id="banner" onchange="validateSize(this)">
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
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_comedor" type="file" id="banner" onchange="validateSize(this)">
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
                                    Cargar <input accept=".jpg,.png,.jpeg,.gif" class="hidden" name="foto_fachada" type="file" id="foto_fachada" onchange="validateSize(this)">
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

    function validateSize(input) {
        const fileSize = input.files[0].size / 1024 / 1024; // in MiB
        if (fileSize > 1) {
            $.smkAlert({
                    text: 'El tamaño máximo para cada imagen es de 1.5 MB',
                    type: 'danger',
                    time: 5
                });
            $(input).val(''); //for clearing with Jquery
        }
    }
</script>




