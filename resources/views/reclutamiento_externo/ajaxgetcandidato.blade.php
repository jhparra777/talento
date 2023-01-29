<div class="row">
    <p class="mensajes" style="text-align: center;color: green;font-weight: bold;"> @if($candidato==null) Nuevo candidato @endif</p>

    {!! Form::hidden("candidato",$candidato) !!}

    {{--<div class="col-md-12 form-group">
        <label for="inputEmail3" class="control-label">Nombres:<span style="color:red;">*</span> </label>

        
            {!! Form::text("nombres",(!empty($candidato->nombres))?$candidato->nombres:"",["class"=>"form-control editable","id"=>"nombres","required"=>true]); !!}
    

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombres",$errors) !!}</p>
    </div>--}}
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="control-label">Primer nombre:<span style="color:red;">*</span> </label>

        
            {!! Form::text("primer_nombre",(!empty($candidato->primer_nombre))?$candidato->primer_nombre:"",["class"=>"form-control editable","id"=>"primer_nombre","required"=>true]); !!}
    

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_nombre",$errors) !!}</p>
    </div>
    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="control-label">Segundo nombre:</label>

        
            {!! Form::text("segundo_nombre",(!empty($candidato->segundo_nombre))?$candidato->segundo_nombre:"",["class"=>"form-control editable","id"=>"segundo_nombre","required"=>true]); !!}
    

        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="control-label">Primer apellido: <span style="color:red;"> * </span> </label>
       
            {!! Form::text("primer_apellido",(!empty($candidato->primer_apellido))?$candidato->primer_apellido:"",["class"=>"form-control editable","id"=>"primer_apellido","required"=>true]); !!}
          
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="control-label">Segundo apellido: <span style="color:red;"></span></label>
        
            {!! Form::text("segundo_apellido",(!empty($candidato->segundo_apellido))?$candidato->segundo_apellido:"",["class"=>"form-control editable","id"=>"segundo_apellido"]); !!}
        
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
    </div>

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="control-label">Celular <span style="color:red;"> * </span> </label>
        
            {!! Form::number("celular",(!empty($candidato->telefono_movil))?$candidato->telefono_movil:"",["class"=>"form-control numerico editable","id"=>"celular","required"=>true]); !!}
        
        <p class="error text-danger direction-botones-center"> {!!FuncionesGlobales::getErrorData("celular",$errors)!!} </p>
    </div>

    <div class="col-md-12 form-group">
        <label for="inputEmail3" class="control-label">Email <span style="color:red;"> * </span> </label>
       
            {!! Form::email("email",(!empty($candidato->email))?$candidato->email:"",["class"=>"form-control editable","id"=>"email","required"=>true]); !!}
        
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email",$errors) !!}</p>
    </div>

    {{--<div class="col-md-12 form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Fuente <span style="color:red;"> * </span></label>

        <div class="col-sm-10">
            {!! Form::select("tipo_fuente_id",$fuentes,null,["class"=>"form-control editable","id"=>"tipo_fuente_id"]); !!}
        </div>           
	    
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_fuente_id",$errors) !!}</p>
	</div>--}}
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
    })
</script>