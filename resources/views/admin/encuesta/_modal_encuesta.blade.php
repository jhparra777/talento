<style>
    .vertical-align {
    display: table-cell;
    vertical-align: middle;
    height: 5vh;
    }
    .button-link {
    text-decoration: none;
    }
 
    .btns {
        background-color: #f3f0ed;
        z-index: 0;
        height: 35px;
        float: none;
        margin: 0 auto;
        width: 570px;
        max-width: 100%;
        border-radius: 40px;
        display: block;
        box-shadow: 0 2px 4px -1px rgba(25, 25, 25, 0.2);
    }
    .btn{
        /* width: 99px; */
    }

    .input {
        display: none;
    }
    input:checked + .btn {
        color: rgb(255, 255, 255);
        text-shadow: none;
        /* box-shadow: inset 0 10px 50px rgba(25,25,25,.09); */
        box-shadow: inset 0 10px 50px rgba(100,52,132);
        border-radius: 40px;
        width:99px;
    }

    .label{
        color: rgb(26, 2, 2);
    }

    .label :hover{
        background-color: rgb(25,25,25,.09);
        border-radius: 40px;
    }
    
    /* se recoloco el msj de error */
    .has-feedback .smk-error-msg {
        position: inherit;
    }

    .smk-checkbox .smk-error-msg, .smk-radio .smk-error-msg {
    margin-top: 1px;
    }

    img{
        margin-right: 10px;
    }
    
    .modal-header{
        padding: 15px 15px 0px;
    }
    .modal-title{
        margin-top: 10px;
    }
</style>

<div class="modal fade" data-backdrop="false" data-keyboard="false" id="modal_encuesta">
    <div class="modal-dialog modal-md">
        <div class="modal-content | tri-br-1">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div class="col-md-6 form-group">
                    <h4 class="modal-title"><b>Ayúdanos a mejorar</b></h4>
                </div>
                <img align="right" src="https://i.postimg.cc/WbByvsg1/logo-cargado.png" alt="logo TRI" width="40" class="img" alt="T3RS" width="90">
                
            </div>

            <div class="modal-body">
                <div class="row">
                    {!! Form::model(Request::all(), ["id" => "frm_encuesta", "data-smk-icon" => "glyphicon glyphicon-remove"]) !!}
                    {{-- {!! Form::open(["id" => "frm_encuesta", "data-smk-icon" => "fa fa-times-circle", "method" => "POST"]) !!} --}}

                    <div class="col-md-12 form-group">
                        <label class="control-label" for="inputEmail3">
                            ¿Qué tan satisfecho estás con la facilidad de uso de este software?
                        </label>
                        <div class="vertical-align">
                            <div class="btns">
                                <label class="label">
                                    {!! Form::radio("satisfecho",1,false,['id'=>'rs1','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Nada</span>
                                </label>
                                <label class="label">
                                    {!! Form::radio("satisfecho",2,false,['id'=>'rs2','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Poco</span>
                                </label>
                                <label class="label">
                                    {!! Form::radio("satisfecho",3,false,['id'=>'rs3','id'=>'rs3','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Algo</span>
                                </label>
                                <label class="label">
                                    {!! Form::radio("satisfecho",4,false,['id'=>'rs4','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Bastante</span>
                                </label>
                                <label class="label">
                                    {!! Form::radio("satisfecho",5,false,['id'=>'rs5','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Totalmente</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="control-label" for="inputEmail3">
                            ¿Tienes algunas ideas sobre cómo mejorar este software?
                        </label>
                        {!! Form::text("ideas", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Danos tu opinión", "id" => "ideas" ,'required'=>'required']); !!}
                    </div>

                    <div class="col-md-12 form-group">
                        <label class="control-label" for="inputEmail3">
                            ¿Qué tan probable es que le recomiendes este software a otra persona?
                        </label>
                        <div class="vertical-align">
                            <div class="btns" id="recomienda">
                                <label class="label">
                                    {!! Form::radio("recomendar",1,false,['id'=>'rc1','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Nada</span>
                                </label>
                                <label class="label">
                                    {!! Form::radio("recomendar",2,false,['id'=>'rc2','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Poco</span>
                                </label>
                                <label class="label">
                                    {!! Form::radio("recomendar",3,false,['id'=>'rc3','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Tal vez</span>
                                </label>
                                <label class="label">
                                    {!! Form::radio("recomendar",4,false,['id'=>'rc4','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Bastante</span>
                                </label>
                                <label class="label">
                                    {!! Form::radio("recomendar",5,false,['id'=>'rc5','required'=>'required', 'class'=> 'input']) !!} 
                                    <span class="btn first" style="width: 99px;">Totalmente</span>
                                </label>
                            </div>
                        </div>
                    </div>
        
                    <div class="col-md-12" id="cmp_recomienda" hidden>
                        <label class="control-label col-md-12"  for="inputEmail3">
                            ¿ A quién lo recomendarías?
                        </label>
                        <div class="col-md-6 form-group">
                            {!! Form::text("nombre", null, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Nombre", "id" => "nombre" ]); !!}
                        </div>
                        <div class="col-md-6 form-group">
                            <input 
                            type="tel"
                            name="telefono"
                            value= "null"
                            class="form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" 
                            id="telefono"
                            maxlength="10"
                            placeholder="Teléfono celular"
                            >
                            {{-- {!! Form::text("telefono", null, ["class" => "form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "placeholder" => "Teléfono celular", "id" => "telefono" ]); !!} --}}
                        </div>
                    </div>  
                        
                    
                    
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default | tri-px-2 tri-br-2 tri-border--none tri-transition-200" data-dismiss="modal">Cerrar</button>
                <button class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-300 tri-green" type="submit" id="btn_guardar">
                    Guardar
                </button>
    
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // se limpian checks
        $('#frm_encuesta').smkClear();

        $('#recomienda').change(function(){

            var radioValue = $("input[name='recomendar']:checked").val();
            if(radioValue){
                // alert("Your are a -> " + radioValue);
                if (radioValue >= 3) {
                    $('#cmp_recomienda').removeAttr("hidden");
                    $('#nombre').attr("required", true);
                    $('#telefono').attr("required", true);
                }else{
                    $('#cmp_recomienda').attr("hidden", true);
                    $('#nombre').attr("required", false);
                    $('#telefono').attr("required", false);
                }
            }
        });
    });

    //se valida para enviar
    $('#btn_guardar').on("click", function(){
        event.preventDefault()
        if ($('#frm_encuesta').smkValidate()) {
            $('#btn_guardar').hide();
            let formData = new FormData(document.getElementById("frm_encuesta"));
            console.log(formData)
            $.ajax({
                type: "POST",
                data: formData,
                url: "{{ route('admin.guardar_encuesta') }}",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $.smkAlert({
                        text: 'Guardando los datos de la encuesta.',
                        type: 'info'
                    });
                },
                error: function(){
                    $.smkAlert({
                        text: 'Ha ocurrido un error guardando los datos. Verifique e intente nuevamente.',
                        type: 'danger'
                    });
                    $('#btn_guardar').show();
                },
                success: function(response){
                    if(response.success) {
                        $.smkAlert({
                            text: 'Datos guardados correctamente!',
                            type: 'success'
                        });
                        $("#modal_encuesta").modal("hide");
                        $('#frm_encuesta').smkClear();
                        // setTimeout(() => {
                        //     location.reload(true);
                        // }, 2000)
                    } else {
                        $.smkAlert({
                            text: response.mensaje,
                            type: 'danger'
                        });
                        $('#btn_guardar').show();
                    }
                }
            });
        }
    });
</script>