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



 {!! Form::model(Request::all(),["id"=>"fr_enviar_entrevista_prueba"]) !!}
<h1>
    Video Entrevista
</h1>
<p>
    <h4>
        Con este componente podrás construir la estructura para mandar una solicitud para realizar una video entrevista.
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
                        Video Entrevista
                    </h2>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <div class="form-group">
                            <label>
                                Email Destinario
                            </label>
                            {!!Form::text('correo', null, ['class'=>'form-control', 'id'=>'correo','placeholder'=>'Escriba el correo  del destinatario']) !!}
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
                               <label>Mensaje: <span></span></label>
                            </label>
                            {!!Form::textarea('mensaje', $mensaje, [ 'maxlength'=>'100',  'class'=>'form-control', 'id'=>'message','placeholder'=>'Escriba lo que desea que aparezca como mensaje en el correo']) !!}
                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("mensaje",$errors) !!}
                            </p>
                        </div>
                        <!-- Change this to a button or input when using this as a form -->

                        <button type="button" class="btn btn-success btn-block" id="enviar_entrevista" >Enviar Video entrevista</button>
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



           $("#enviar_entrevista").on("click", function () {

      
            $.ajax({
                type: "POST",
                data: $("#fr_enviar_entrevista_prueba").serialize(),
                url: "{{route('admin.enviar_video_entrevista')}}",
                success: function (data) {
                  $("#mensaje-error").hide();
                  $("input").css({"border": "1px solid #ccc"});
                  $("select").css({"border": "1px solid #ccc"});
                  mensaje_success("Se ha enviado la video entrevista con éxito");
                },
                error:function(data)
                { 
                  $(document).ready(function(){
                    $("input").css({"border": "1px solid #ccc"});
                    $("select").css({"border": "1px solid #ccc"});
                    $(".sisa").remove();
                  });

                  $.each(data.responseJSON, function(index, val){
                    console.log(index);
                    document.getElementById(index).style.border = 'solid red';
                    $('input[name='+index+']').after('<span style = "color : red;" class="sisa">'+val+'</span>');
                    $('select[name='+index+']').after('<span class="text">'+val+'</span>');
                   });

                 
                  $("#mensaje-error").fadeIn();
                }
            });
        });



      });



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

</script>
@stop
