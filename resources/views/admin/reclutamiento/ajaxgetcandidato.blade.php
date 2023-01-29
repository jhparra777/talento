<div class="row">
    <p class="mensajes" style="text-align: center;color: red;"> @if($candidato==null) Nuevo candidato @endif</p>

    {!! Form::hidden("candidato",$candidato_id) !!}

    <div class="col-md-12 form-group">
        <label for="nombres" class="col-sm-2 control-label">Primer nombre:<span style="color:red;">*</span> </label>

        <div class="col-sm-10">
            {!! Form::text("primer_nombre",(!empty($candidato->primer_nombre))?$candidato->primer_nombre:"",["class"=>"form-control editable","id"=>"primer_nombre", "required"=>"required"]); !!}
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        <label for="nombres" class="col-sm-2 control-label">Segundo nombre:<span style="color:red;"></span> </label>

        <div class="col-sm-10">
            {!! Form::text("segundo_nombre",(!empty($candidato->segundo_nombre))?$candidato->segundo_nombre:"",["class"=>"form-control editable","id"=>"segundo_nombre"]); !!}
        </div>

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        <label for="primer_apellido" class="col-sm-2 control-label">Primer apellido: <span style="color:red;"> * </span> </label>
        
        <div class="col-sm-10">
            {!! Form::text("primer_apellido",(!empty($candidato->primer_apellido))?$candidato->primer_apellido:"",["class"=>"form-control editable","id"=>"primer_apellido", "required"=>"required"]); !!}
        </div>
          
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        <label for="segundo_apellido" class="col-sm-2 control-label">Segundo apellido:</label>
        
        <div class="col-sm-10">
            {!! Form::text("segundo_apellido",(!empty($candidato->segundo_apellido))?$candidato->segundo_apellido:"",["class"=>"form-control","id"=>"segundo_apellido"]); !!}
        </div>
        
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        <label for="celular" class="col-sm-2 control-label">Celular <span style="color:red;"> * </span> </label>
        
        <div class="col-sm-10">
            {!! Form::number("celular",(!empty($candidato->telefono_movil))?$candidato->telefono_movil:"",["class"=>"form-control numerico editable","id"=>"celular", "required"=>"required"]); !!}
        </div>
        
        <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("celular",$errors)!!} </p>
    </div>

    <div class="col-md-12 form-group">
        <label for="email" class="col-sm-2 control-label">Email <span style="color:red;"> * </span> </label>
    
        <div class="col-sm-10">
            {!! Form::email("email",(!empty($candidato->email))?$candidato->email:"",["class"=>"form-control editable","id"=>"email", "required"=>"required", (!empty($candidato->email))?'readonly=true':'']); !!}
        </div>
        
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
    </div>
    @if($candidato==null)
    <div class="col-md-12 form-group">
        <label for="tipo_fuente_id" class="col-sm-2 control-label">Fuente <span style="color:red;"> * </span></label>

        <div class="col-sm-10">
            {!! Form::select("tipo_fuente_id",$fuentes,null,["class"=>"form-control editable","id"=>"tipo_fuente_id", "required"=>"required"]); !!}
        </div>           
	    
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_fuente_id",$errors) !!}</p>
	</div>
    @else
        {!! Form::hidden("tipo_fuente_id", (!empty($candidato->tipo_fuentes_id)) ? $candidato->tipo_fuentes_id : "0", ["class" => "form-control hidden", "id" => "tipo_fuente_id"]); !!}
    @endif
</div>

<script>
	class CampoNumerico {
        constructor(selector){
            this.nodo = document.querySelector(selector);
            this.valor = '';
            this.empezarAEscucharEventos();
        }
  
        empezarAEscucharEventos() {
            this.nodo.addEventListener('keydown', function(evento) {
                const teclaPresionada = evento.key;
                const teclaPresionadaEsUnNumero =
                Number.isInteger(parseInt(teclaPresionada));

                const sePresionoUnaTeclaNoAdmitida = 
                    teclaPresionada != 'ArrowDown'  &&
                    teclaPresionada != 'ArrowUp'  &&
                    teclaPresionada != 'ArrowLeft' &&
                    teclaPresionada != 'ArrowRight' &&
                    teclaPresionada != 'Backspace' &&
                    teclaPresionada != 'Delete' &&
                    teclaPresionada != 'Enter' &&
                    !teclaPresionadaEsUnNumero;
                
                const comienzaPorCero =
                    this.nodo.value.length === 0 &&
                    teclaPresionada == 0;

                if (sePresionoUnaTeclaNoAdmitida || comienzaPorCero) {
                    evento.preventDefault(); 
                } else if (teclaPresionadaEsUnNumero) {
                    this.valor += String(teclaPresionada);
                }
            }.bind(this));

            this.nodo.addEventListener('input', function(evento) {
                const cumpleFormatoEsperado = new RegExp(/^[0-9]+/).test(this.nodo.value);

                if (!cumpleFormatoEsperado) {
                    this.nodo.value = this.valor;
                } else {
                    this.valor = this.nodo.value;
                }
            }.bind(this));
        }
    }

    new CampoNumerico('.numerico');

    $(function(){
        $("#fecha_nacimiento").datepicker(confDatepicker);

        $('#fr_otra_fuente #cedula').attr('readonly', true);
    })
</script>