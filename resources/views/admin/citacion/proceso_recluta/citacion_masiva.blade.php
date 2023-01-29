@extends("admin.layout.master")
@section("contenedor")
    
    <!-- Mostrar los mensaje de error del cargue de la base de datos excel -->
    @if(Session::has("errores_global") && count(Session::get("errores_global")) > 0)
        <div class="col-md-12" id="mensaje-resultado">
            <div class="divScroll">
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                @foreach(Session::get("errores_global") as $key => $value)
                <p>EL registro de la linea numero {{++$key}} tiene los siguientes errores</p>
                <ul>
                    @foreach($value as $key2 => $value2)
                    <li>{{$value2}}</li>
                    @endforeach
                </ul>
                @endforeach
            </div>
            </div>
        </div>
    @endif

    <!-- Mostrar el mensaje del total de registro que se cargaron a la base de datos. -->
    @if(Session::has("mensaje_success"))
        <div class="col-md-12" id="mensaje-resultado">
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                {!! Session::get("mensaje_success") !!}
            </div>
        </div>
    @endif

    <div class="col-md-12">
        <h3>Carga Masiva</h3>
    </div>

    @if($user->hasAccess("admin.cargar_bd"))
        {!! Form::model(Request::all(),["method"=>"post","route"=>"admin.carga_citacion_virtual","files"=>true]) !!}
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('motivo', 'Motivo') !!}
                    {!! Form::select("motivo",$motivo_carga_db,null,["class"=>"form-control","id"=>"motivo"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("motivo",$errors) !!}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('nombre_carga', 'Nombre Carga') !!}
                    {!! Form::text("nombre_carga",null,["class"=>"form-control","id"=>"nombre_carga"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("nombre_carga",$errors) !!}</p>
                </div>
            </div>

 <div class="col-md-6">
    <label><b>Mensaje -</b></label>
                            <label>
                               <label>Caracteres restantes: <span></span></label>
                            </label>
                            {!!Form::textarea('mensaje', null, [ 'maxlength'=>'100', 'rows' => '2' ,'class'=>'form-control', 'id'=>'message','placeholder'=>'Escriba las indicaciones de la citacion para el candidato. Ejemplo : lugar, hora, dirección y empresa de donde será la citacion']) !!}
                            <p class="error text-danger direction-botones-center">
                                {!! FuncionesGlobales::getErrorData("mensaje",$errors) !!}
                            </p>
                        </div>




    

            <div class="col-md-6">
               {{--  <div class="form-group col-md-12">
                    {!! Form::label('archivo', 'Archivo Plano Excel') !!}
                    {!! Form::file('archivo',["class"=>"form-control-file"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("archivo",$errors) !!}</p>
                </div>
                {!! Form::submit("Cargar archivo",["class"=>"btn btn-success "]) !!}
                 <a type="button" class="btn btn-info" href="{{asset("plantilla_carga_masiva_n.xlsx")}}" download="PlantillaCargaMasiva">
                          Descargar Plantilla
                </a>  --}}
            </div>
             <div class="col-md-6">
                <div class="form-group col-md-12">
                    {!! Form::label('archivo', 'Archivo Plano Excel') !!}
                    {!! Form::file('archivo',["class"=>"form-control-file"]) !!}
                    <p class="text-danger">{!! FuncionesGlobales::getErrorData("archivo",$errors) !!}</p>
                </div>
                {!! Form::submit("Cargar archivo",["class"=>"btn btn-success "]) !!}
                 <a type="button" class="btn btn-info" href="{{asset("plantilla_carga_masiva_n.xlsx")}}" download="PlantillaCargaMasiva">
                          Descargar Plantilla
                </a> 
            </div>
        {!! Form::close() !!}
    @endif
{!! Form::close() !!}

<style >
  textarea {
  box-sizing: border-box;
  font: 12px arial;
    height: 100px;
    margin: 5px 0 15px 0;
  padding: 5px 2px;
    width: 100%;  
}
.borderojo {
    outline: none;
    border: 1px solid #f00;
}
.bordegris { border: 1px solid #d4d4d; }
#req{
    width: 300px !important;
}
.chosen-container .chosen-container-single{
    width: 300px !important;
}



</style>

<script >
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

    $(".chosen1").chosen();
</script>

@stop