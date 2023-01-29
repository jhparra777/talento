@extends("cv.layouts.master")
@section("menu_candidato")
    @include("cv.includes.menu_candidato")
@endsection

@section('content')
    <style>
        body { font: 12px arial; }
        label { display: block; }

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

    <div class="col-right-item-container">
        <div class="container-fluid">
            {!! Form::model($autoentrevista, ["id" => "fr_datos_basicos","role" => "form","method" => "POST","files" => true]) !!}
                <div class="col-md-12 col-sm-12 col-xs-12">    
                    <div id="submit_listing_box">
                        <h3> Descripción de sus intereses personales </h3>

                        <div class="form-alt">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> ¿Qué lo motiva para un cambio? <span>*</span> </label>
                                    {!! Form::textarea("motivo_cambio",null,["class"=>"form-control" ,"id"=>"motivo_cambio","placeholder"=>"","maxlength"=>"5000"])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("motivo_cambio", $errors)!!} </p>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> Áreas de mayor interés en ámbito laboral <span>*</span> </label>
                                    {!! Form::textarea("areas_interes",null,["class"=>"form-control" ,"id"=>"areas_interes","placeholder"=>"","maxlength"=>"5000"])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("areas_interes", $errors)!!} </p>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> ¿Qué valora en un ambiente laboral? <span></span> </label>
                                    {!! Form::textarea("ambiente_laboral",null,["class"=>"form-control" ,"id"=>"ambiente_laboral","placeholder"=>"","maxlength"=>"5000"])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("ambiente_laboral",$errors)!!} </p>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> Actividades de interés en su tiempo libre (hobbies) <span></span> </label>
                                    {!! Form::textarea("hobbies",null,["class"=>"form-control" ,"id"=>"hobbies","placeholder"=>"","maxlength"=>"5000"])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("hobbies",$errors)!!} </p>   
                                </div>
                            </div>
                  
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> Membresías colegios profesionales, asociaciones, clubes, etc. <span></span> </label>
                                    {!! Form::textarea("membresias",null,["class"=>"form-control" ,"id"=>"membresias","placeholder"=>"","maxlength"=>"5000"])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("membresias",$errors)!!} </p>   
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="submit_listing_box">
                        <h3> Descripción de su perfil profesional </h3>

                        <div class="form-alt">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> Años de experiencia en el cargo de aplicación<span></span> </label>
                                    {!! Form::number("tiempo_experiencia",null,["class"=>"form-control" ,"id"=>"tiempo_experiencia","placeholder"=>""])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("tiempo_experiencia",$errors)!!} </p>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> Conocimientos técnicos de mayor dominio <span>*</span> </label>
                                    {!! Form::text("conoc_tecnico", null, ["class" => "form-control" ,"id" => "conoc_tecnico","placeholder" => "","maxlength" => "5000"])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("conoc_tecnico",$errors)!!} </p>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> Herramientas tecnológicas manejadas <span>*</span> </label>
                                    {!! Form::text("herr_tecnologicas", null, [
                                        "class" => "form-control",
                                        "id" => "herr_tecnologicas",
                                        "placeholder" => "",
                                        "maxlength"=>"5000",
                                        "required"
                                    ])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                        {!! FuncionesGlobales::getErrorData("herr_tecnologicas",$errors) !!}
                                    </p>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> Principales fortalezas que considera tener para el cargo <span></span> </label>
                                    {!! Form::text("fortalezas_cargo",null,["class"=>"form-control" ,"id"=>"fortalezas_cargo","placeholder"=>"","maxlength"=>"5000"])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("fortalezas_cargo",$errors)!!} </p>   
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label> Áreas a reforzar para un mayor dominio del cargo <span></span> </label>
                                    {!! Form::text("areas_reforzar",null,["class"=>"form-control" ,"id"=>"areas_reforzar","placeholder"=>"","maxlength"=>"5000"])!!}
                                    
                                    <p class="error text-danger direction-botones-center">
                                    {!!FuncionesGlobales::getErrorData("areas_reforzar",$errors)!!} </p>   
                                </div>
                            </div>
                        </div>
                    </div>
                
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                
                    <div class="col-md-12 separador"></div>

                    <p class="direction-botones-center set-margin-top">
                        <button class="btn-quote" id="guardar_autoentrevista" type="button">
                            <i class="fa fa-floppy-o"></i>&nbsp;Guardar
                        </button>
                    </p>

                    <div id="mensaje-error" class="alert alert-danger danger" role="alert" style="display: none;">
                        <strong id="error"></strong>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <script>
        $(function () {
            var inputs = "textarea[maxlength]";

            //Guardar Datos Basicos
            $("#guardar_autoentrevista").on("click", function () {
                var formData = new FormData(document.getElementById("fr_datos_basicos"));

                $.ajax({
                    type: "POST",
                    data: formData,
                    url: "{{ route('guardar_autoentrevistas') }}",
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#mensaje-error").hide();
                        $("input").css({"border": "1px solid #ccc"});
                        $("select").css({"border": "1px solid #ccc"});
                        
                        // mensaje_success("Datos Basicos Guardados");
                        swal("Datos Guardados", "tus datos fueron guardados", "info");
                            setTimeout(function(){
                                window.location.href = '{{ route('experiencia') }}';
                            }, 2000);
                        },
                    error:function(data){
                        $(document).ready(function(){
                            $("input").css({"border": "1px solid #ccc"});
                            $("select").css({"border": "1px solid #ccc"});
                            $(".text").remove();
                        });

                        var nombres = $("#nombres").val();

                        $.each(data.responseJSON, function(index, val){
                            document.getElementById(index).style.border = 'solid red';

                            $('input[name='+index+']').after('<span class="text">'+val+'</span>');
                            $('select[name='+index+']').after('<span class="text">'+val+'</span>');
                        });

                        $("#error").html("Upps, olvidaste completar algunos datos, pero no te preocupes! solo ve al principio del formulario y revisa los campos que te resaltamos.");

                        $("#mensaje-error").fadeIn();
                    }
                });
            });
        });
    </script>
@stop