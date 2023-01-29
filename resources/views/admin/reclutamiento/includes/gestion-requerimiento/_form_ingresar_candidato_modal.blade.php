<div class="col-md-12 mt-1">
    <div class="panel panel-default">
        <div class="panel-body">
            @if($candidato == null)
                <div class="col-md-12 mb-2">
                    <h4><i class="fas fa-user-plus tri-fs-14"></i> Nuevo candidato</h4>
                </div>
            @endif

            {!! Form::hidden("candidato",$candidato_id) !!}

            <div class="col-md-12 form-group">
                <label for="primer_nombre">Primer nombre *</label>

                <input type="text" name="primer_nombre" id="primer_nombre" class="form-control editable | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" value="{{  (!empty($candidato->primer_nombre)) ? $candidato->primer_nombre : '' }}" required>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_nombre", $errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="segundo_nombre">Segundo nombre</label>

                <input type="text" name="segundo_nombre" id="segundo_nombre" class="form-control editable | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" value="{{ (!empty($candidato->segundo_nombre)) ? $candidato->segundo_nombre : '' }}">

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_nombre", $errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="primer_apellido">Primer apellido *</label>

                <input type="text" name="primer_apellido" id="primer_apellido" class="form-control editable | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" value="{{  (!empty($candidato->primer_apellido)) ? $candidato->primer_apellido : '' }}" required>

                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("primer_apellido", $errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="segundo_apellido">Segundo apellido</label>

                <input type="text" name="segundo_apellido" id="segundo_apellido" class="form-control | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" value="{{  (!empty($candidato->segundo_apellido)) ? $candidato->segundo_apellido : '' }}">
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("segundo_apellido",$errors) !!}</p>
            </div>

            <div class="col-md-12 form-group">
                <label for="celular">Celular *</label>

                <input type="number" name="celular" id="celular" class="form-control solo-numerico editable | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" value="{{  (!empty($candidato->telefono_movil)) ? $candidato->telefono_movil : '' }}" required>

                <p class="error text-danger direction-botones-center"> {!! FuncionesGlobales::getErrorData("celular", $errors) !!} </p>
            </div>

            <div class="col-md-12 form-group">
                <label for="email">Email *</label>

                <input type="email" name="email" id="email" class="form-control editable | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300" value="{{  (!empty($candidato->email)) ? $candidato->email : '' }}" required {{ (!empty($candidato->email)) ? 'readonly' : '' }}>
                
                <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("email", $errors) !!}</p>
            </div>

            @if($candidato == null)
                <div class="col-md-12 form-group">
                    <label for="tipo_fuente_id">Fuente *</label>

                    {!! Form::select("tipo_fuente_id", $fuentes, null, ["class" => "form-control editable | tri-br-1 tri-fs-12 tri-input--focus tri-transition-300", "id"=>"tipo_fuente_id", "required" => "required"]); !!}

                    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_fuente_id", $errors) !!}</p>
                </div>
            @else
                {!! Form::hidden("tipo_fuente_id", (!empty($candidato->tipo_fuentes_id)) ? $candidato->tipo_fuentes_id : "0", ["class" => "form-control hidden", "id" => "tipo_fuente_id"]); !!}
            @endif

        </div>
    </div>
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