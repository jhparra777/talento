<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title">Citar para cliente (NOTIFICAR USUARIO)</h4>
</div>

<div class="modal-body">
    
    <style>
        body { font: 12px arial; }

        label { display: block; }

        input {
            box-sizing: border-box;
            margin: 5px 0 15px 0;
            padding: 5px;
            width: 100%;
        }

        textarea {
            box-sizing: border-box;
            font: 12px arial;
            height: 200px;
            margin: 5px 0 15px 0;
            padding: 5px 2px;
            width: 100%;  
        }

        .borderojo {
            outline: none;
            border: 1px solid #f00;
        }

        .bordegris { border: 1px solid #d4d4d; }
    </style>

    {!! Form::open(["id"=>"fr_enviar_mensaje_cita","route"=>"post_llamada_virtual","method"=>"POST"]) !!}
        <input type="hidden" name="tipo_cita" id="tipo_cita" value="without">
        <h1>Llamada Virtual</h1>
        
        <p>
            <h4>
                Con este componente podrás construir la estructura de una cita programada para el candidato.
            </h4>
        </p>

        <div class="alert alert-warning alert-dismissible" role="alert">
            NOTA: ESCRIBIR LOS NÚMEROS DE LAS DIRECCIONES EN LETRAS
        </div>
        
        <br/>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($mensaje_limite))
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ $mensaje_limite }}
            </div>
        @endif

        @if(Session::has("mensaje_success"))
            <div class="col-md-12" id="mensaje-resultado">
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">×</span>
                    </button>

                    {{Session::get("mensaje_success")}}
                </div>
            </div>
        @endif

        <?php $txt = 100; ?>

        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-2">
                    <div id="panel_mensaje" class="panel panel-default">
                
                        @if(session()->has('message'))
                            <div class="alert alert-success">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        <div class="panel-heading">
                            <h2 class="panel-title" style="text-align: center;">LLamada Virtual</h2>
                        </div>

                        <div class="panel-body">
                            <fieldset>
                                {!!Form::hidden('req_id',$reqId) !!}
                      
                                <div class="form-group">
                                    <input type="hidden" name="mensaje_enviar" id="mensaje_enviar" value="">

                                    {!!Form::hidden('numeros', $telInd, ['class'=>'form-control', 'id'=>'number','placeholder'=>'Copie o escriba el número.']) !!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("numero",$errors) !!}
                                    </p>
                                </div>
                    
                                <div class="form-group">
                                    <label>
                                        <label>Caracteres usados: <span></span></label>
                                    </label>

                                    {!!Form::textarea('mensaje', $datos, ['class'=>'form-control', 'maxlength' => 390,'id'=>'message', 'placeholder'=>'Escriba las indicaciones de la entrevista para el candidato. Ejemplo : lugar, hora, dirección y empresa de donde será la entrevista']) !!}
                        
                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("mensaje",$errors) !!}
                                    </p>
                                </div>

                                <p id="msgSend" data-toggle="tooltip" data-placement="top" title="Si superas el limite de caracteres del mensaje serán enviados más de uno para completar."></p>

                                <!-- Change this to a button or input when using this as a form -->
                                <button class="btn btn-success btn-block" id="submitBtn" type="submit">
                                    Enviar Llamada Virtual y Correo
                                </button>

                                <input class="btn btn-success btn-block" id="submitBtn" type="submit" name="solo_correo" value="Enviar Correo Electrónico">
                                </input>

                                <a class="btn btn-warning btn-block" href="#" onclick="window.history.back()">
                                    Volver
                                </a>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <script>
        $(document).on('keyup', "#message", function (e) {

            var este = $(this),

            maxlength = 100,
          
            maxlengthint = parseInt(maxlength),
          
            textoActual = este.val(),
          
            currentCharacters = este.val().length;
          
            remainingCharacters = maxlengthint - currentCharacters,
          
            espan = este.prev('label').find('span');

            // Detectamos si es IE9 y si hemos llegado al final, convertir el -1 en 0 - bug ie9 porq. no coge directamente el atributo 'maxlength' de HTML5

            if (document.addEventListener && !window.requestAnimationFrame) {
                if (remainingCharacters <= -1) {
                    remainingCharacters = 0;            
                }
            }
          
            espan.html(currentCharacters);
          
            var valorAct = $(this).val();
            var msgSend = 0;

            if(valorAct.length >= 1 && valorAct.length <= 130){
                msgSend = 1;
            }
            else{
                if(valorAct.length >= 131 && valorAct.length <= 230){
                    msgSend = 2;
                }
                else{
                    if(valorAct.length >= 231 && valorAct.length <= 330){
                        msgSend = 3;
                    }else{
                        if(valorAct.length >= 331 && valorAct.length <= 430){
                            msgSend = 4;
                        }else{
                            if(valorAct.length = ''){
                            msgSend = 0;
                            }
                        }
                    }
                }
            }

            $('#msgSend').html('Los mensajes a enviar son : '+ msgSend);

            $('#mensaje_enviar').val(msgSend);

            if (!!maxlength) {
    
                var texto = este.val(); 
            
                if (texto.length >= maxlength) {
                    este.removeClass().addClass("borderojo");
                    este.val(text.substring(0, maxlength));
                    e.preventDefault();
                }
                else if (texto.length < maxlength) {
                    este.removeClass().addClass("bordegris");
                }

            }
        });
    </script>

    <div class="clearfix"></div>
</div>

<div class="modal-footer">
    {{-- <button type="button" class="btn btn-success" id="enviar_cita_to_cand" >Notificar Candidato</button> --}}
    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
</div>