@extends("admin.layout.master")
@section('contenedor')
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



 {!! Form::model(Request::all(),["id"=>"fr_enviar_llamada_mensaje"]) !!}
<h1>
    Llamada y mensaje  
</h1>
<p>
    <h4>
        Con este componente podrás construir la estructura para mandar una llamada y un mensaje.
    </h4>
</p>
<div class="alert alert-warning alert-dismissible" role="alert">
    
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
@if(Session::has("mensaje_success"))
<div class="col-md-12" id="mensaje-resultado">
    <div class="alert alert-success alert-dismissible" role="alert">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">
                ×
            </span>
        </button>
        {{Session::get("mensaje_success")}}
    </div>
</div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-primary">
                @if(session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @endif
                <div class="panel-heading">
                    <h2 class="panel-title" style="text-align: center;">
                        Llamada y mensaje
                    </h2>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <div class="form-group">
                            <label>
                                Número destino
                            </label>
                            {!!Form::text('celular', null, ['class'=>'form-control', 'id'=>'correo','placeholder'=>'Escriba el número  del destinatario']) !!}
                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("correo",$errors) !!}
                            </p>
                        </div>
                        <div class="form-group">
                            <label>
                                 Nombres 
                            </label>
                            {!!Form::text('nombres', null, ['class'=>'form-control', 'id'=>'correo','placeholder'=>'Escriba los nombres  del destinatario']) !!}
                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("correo",$errors) !!}
                            </p>
                        </div>
                        <div class="form-group">
                            <label>
                                 Número de cédula
                            </label>
                           {!! Form::text('numero_id', null, ['class'=>'form-control', 'id'=>'numero_id','placeholder'=>'Escriba el numero de cédula del destinatario']) !!}
                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("número_id",$errors) !!}
                            </p>
                        </div>
                        <div class="form-group">
                            <label>
                               <label>Caracteres restantes: <span></span></label>
                            </label>
                            {!!Form::textarea('mensaje', null, [ 'maxlength'=>'100',  'class'=>'form-control', 'id'=>'message','placeholder'=>'Escriba en un máximo de 100 caracteres lo que desea para el mensaje']) !!}
                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("mensaje",$errors) !!}
                            </p>
                        </div>
                        <!-- Change this to a button or input when using this as a form -->

                        <button type="button" class="btn btn-success btn-block" id="enviar_llamada" >Enviar llamada virtual</button>
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

      $(function () {

var inputs = "input[maxlength], textarea[maxlength]";
    $(document).on('keyup', "[maxlength]", function (e) {
        var este = $(this),
            maxlength = este.attr('maxlength'),
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
            espan.html(remainingCharacters);
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


           $(document).on("click", "#enviar_llamada", function() {
           
            $.ajax({
                type: "POST",
                data: $("#fr_enviar_llamada_mensaje").serialize() + "&enviar=1",
                url: "{{ route('admin.enviar_llamada_mensaje') }}",
                success: function(response) {
                       
                         mensaje_success("Se ha enviado la llamada con éxito");
                         //location.reload();
                }
            });
        });



      });



    

</script>
@stop
