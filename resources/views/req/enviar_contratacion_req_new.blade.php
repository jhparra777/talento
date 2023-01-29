@extends("req.modals._modal_plantilla")

@section("title")
  @if( count($candidato) > 0)
      <h4>
          <strong>
              Envío a contratación
          </strong>
      </h4>
      <h5>
          <strong>Candidato</strong> {{ $candidato->nombres." ".$candidato->primer_apellido}} | <strong>{{$candidato->tipo_id_desc}}</strong> {{$candidato->numero_id }}
      </h5>
  @elseif( count($candi_no_cumplen) > 0 )
      <h4>
          <strong>No se puede enviar a contratar al candidato</strong>
      </h4>
  @endif
@stop

@section("body")
  {!! Form::model(Request::all(),["id"=>"fr_contratar_req"]) !!}
  {!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
  {!! Form::hidden("cliente_id",null) !!}

    @if($contra_clientes != null)
      <div class="col-md-6 form-group">
        <label class="control-label"> Fecha Ingreso* </label>
        {!! Form::text ("fecha_inicio_contrato",$contra_clientes->fecha_ingreso_contra,["class"=>"form-control","id"=>"fecha_inicio_contrato"]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_ingreso_contra",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group">
        <label for="inputEmail3" class="control-label"> Fecha Retiro* </label>
        {!! Form::text ("fecha_fin_contrato",$contra_clientes->fecha_fin_contrato,["class"=>"form-control","id"=>"fecha_fin_contrato"]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato",$errors) !!}</p>
      </div>

      <div class="col-md-12 form-group">
        <label for="inputEmail3" class=" control-label"> Observaciones* </label>
        {!! Form::textarea("observaciones",$contra_clientes->observaciones,["class"=>"form-control","rows"=>'2']); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group">
          <label for="inputEmail3" class="control-label"> Centro de costos* </label>
          {!! Form::select("centro_costos", $centros_costos, (!empty($contra_clientes->centro_costos)) ? $contra_clientes->centro_costos : $requerimiento->centro_costo_id, ["class" => "form-control","id" => "centro_costos"]); !!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
      </div>

      <div class="col-md-6 form-group">
          @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
              <label for="inputEmail3" class="control-label">Quién autorizó * </label>
          @else
            <label for="inputEmail3" class="control-label">Quién autorizó por parte del cliente* </label>
          @endif
          {!! Form::select ("user_autorizacion",$usuarios_clientes,$contra_clientes->user_autorizacion,["class"=>"form-control"]); !!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion",$errors) !!}</p>
      </div>
    @else

      <div class="col-md-6 form-group">
        <label class="control-label"> Fecha Ingreso* </label>
          {!! Form::text("fecha_inicio_contrato",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
          tri-transition-300","id"=>"fecha_inicio_contrato"]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio_contrato",$errors) !!}</p>
      </div>
    
      <div class="col-md-6 form-group">
        <label class="control-label"> @if(route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000" || route("home")=="http://desarrollo.t3rsc.co" || route("home")=="https://desarrollo.t3rsc.co") Fecha Fin Contrato @else Fecha Retiro @endif * </label>
          {!! Form::text ("fecha_fin_contrato",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
          tri-transition-300","id"=>"fecha_fin_contrato"]); !!}
        <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato",$errors) !!}</p>
      </div>

      @if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" || route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co")
          

              <div class="col-md-12 form-group">
              <label for="inputEmail3" class="control-label"> Otros devengos:</label>
                <textarea name="otros_devengos" class="form-control | tri-br-1 tri-fs-12 tri-input--focus
                tri-transition-300" rows="2" @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") readonly="true" @endif > {{$requerimiento->observaciones}} </textarea>
              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("otros_devengos",$errors) !!}</p>
              </div>            

              <div class="col-md-12 form-group">
                <label for="inputEmail3" class="control-label"> Lugar contacto:</label>
                  <textarea name="lugar_contacto" class="form-control | tri-br-1 tri-fs-12 tri-input--focus
                  tri-transition-300" rows="2" @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") readonly="true" @endif > </textarea>
                  <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("lugar_contacto",$errors) !!}</p>
              </div>
              
              <div class="col-md-12 form-group">
              <label for="inputEmail3" class="control-label"> hora de ingreso:</label>
                {!! Form::text("hora_ingreso",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
                tri-transition-300","id"=>"time-inicio"]); !!}
              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso",$errors) !!}</p>
              </div>

      @endif

      {{-- Hecho --}}
      @if(route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000" || route("home")=="http://desarrollo.t3rsc.co" || route("home")=="https://desarrollo.t3rsc.co" || route("home")=="https://pruebaslistos.t3rsc.co" || route("home")=="https://listos.t3rsc.co" || route("home")=="https://vym.t3rsc.co")

        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="control-label"> hora de ingreso:</label>
            {!! Form::time("hora_ingreso",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
            tri-transition-300","id"=>"time-inicio"]);!!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso",$errors) !!}</p>
        </div>
          
        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="control-label"> Tipo Ingreso:</label>
            <select name="tipo_ingreso" id="tipo_ingreso" class="form-control | tri-br-1 tri-fs-12 tri-input--focus
            tri-transition-300">
              <option value="1"> Nuevo </option>
              <option value="2"> Reingreso </option>
            </select>
          <p class="error text-danger direction-botones-center">  {!! FuncionesGlobales::getErrorData("auxilio_transporte",$errors) !!} </p>
        </div>

        <div style="display: none;" class="col-md-6 form-group" id="fecha_fin_ultimo">
          <label for="inputEmail3" class="control-label">Fecha fin ultimo contrato:</label>
          <input type="date" name="fecha_fin_ultimo" value="" class="form-control | tri-br-1 tri-fs-12 tri-input--focus
          tri-transition-300" > 
        </div>
          
        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="control-label"> Auxilio de Transporte: </label>
              <select name="auxilio_transporte" class="form-control | tri-br-1 tri-fs-12 tri-input--focus
              tri-transition-300">
                <option value="No se Paga"> No se paga </option>
                <option value="Total"> Total </option>
                <option value="Mitad"> Mitad </option>
              </select>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("auxilio_transporte",$errors) !!}</p>
        </div>

        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="control-label"> EPS: </label>
          {!! Form::select("entidad_eps",$eps,$candidato->entidad_eps,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus
          tri-transition-300","id"=>"entidad_eps"]) !!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("eps",$errors) !!}</p>
        </div>

        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="control-label"> Fondo Pensiones: </label>
              {!! Form::select("entidad_afp",$afp,$candidato->entidad_afp,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus
              tri-transition-300","id"=>"entidad_afp"]) !!}

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fondo_pensiones",$errors) !!}</p>
        </div>

        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="control-label"> Caja de Compensaciones:</label>
          {!! Form::select("caja_compensacion",$caja_compensaciones,$candidato->caja_compensaciones,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus
          tri-transition-300","id"=>"caja_compensacion"]) !!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("caja_compensacion",$errors) !!}</p>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label"> ARL:</label>
            {!!Form::text("arl",'Colpatria',["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
            tri-transition-300","id"=>"arl","readonly"=>"readonly"]);!!}
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("caja_compensacion",$errors) !!}</p>
        </div>
              
        <div class="col-md-6 form-group">
          <label for="inputEmail3" class=" ontrol-label"> Fondo De Cesantias:</label>
          {!! Form::select("fondo_cesantias",$fondo_cesantias,$candidato->fondo_cesantias,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus
          tri-transition-300","id"=>"fondo_cesantias"]) !!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fondo_cesantias",$errors) !!}</p>
        </div>

        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="control-label"> Nombre del Banco:</label>
            {!!Form::select("nombre_banco",$bancos,$candidato->nombre_banco,["class"=>"form-control selectcategory | tri-br-1 tri-fs-12 tri-input--focus
            tri-transition-300","id"=>"nombre_banco"])!!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_banco",$errors) !!}</p>
        </div>

        <div class="col-md-6 form-group">
            <label for="inputEmail3" class="control-label"> Tipo Cuenta:</label>
              <select name="tipo_cuenta" class="form-control | tri-br-1 tri-fs-12 tri-input--focus
              tri-transition-300">
                <option value="Ahorro"> Ahorro </option>
                <option value="Corriente"> Corriente </option>
              </select>
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_cuenta",$errors) !!}</p>
        </div>

        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label"> Numero Cuenta:</label>
              <input type="number" name="numero_cuenta" class="form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus
              tri-transition-300" id="numero_cuenta" value="{{$candidato->numero_cuenta}}">
              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta",$errors) !!}</p>
        </div>

        <div class="col-md-6 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label"> Confirmar Cuenta:</label>
            <input type="number" name="confirm_numero_cuenta" class="form-control solo-numero | tri-br-1 tri-fs-12 tri-input--focus
            tri-transition-300" id="confirm_numero_cuenta">
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta",$errors) !!}</p>
        </div>
                        
      @endif
    
      
        <div class="col-md-12 form-group">
            <label > Observaciones* </label>
            {!! Form::textarea("observaciones",null,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
            tri-transition-300","rows"=>'2']);!!}
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
        </div>

      <div class="col-md-6 form-group">
        <label class="control-label"> Centro de costos* </label>
          {!! Form::select("centro_costos", $centros_costos, $requerimiento->centro_costo_id, ["class" => "form-control | tri-br-1 tri-fs-12 tri-input--focus
          tri-transition-300","id" => "centro_costos"]); !!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
      </div>
    

      <div class="col-md-6 form-group">
          <label class="control-label">Quién autorizó por parte del cliente* </label>
            {!! Form::select ("user_autorizacion",$usuarios_clientes,$user_id,["class"=>"form-control | tri-br-1 tri-fs-12 tri-input--focus
            tri-transition-300"]); !!}
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion",$errors) !!}</p>
      </div>
    @endif
  
  {!! Form::close() !!}

  <div class="clearfix"></div>
  </div>
@stop

@section("footer")
  <button type="button" class="btn btn-success | tri-px-2 tri-br-2 tri-border--none tri-transition-200 tri-green" id="confirmar_contratacion" >Confirmar</button>
@stop

<script>

$(function () {

  var confDatepicker = {
   altFormat: "yy-mm-dd",
   dateFormat: "yy-mm-dd",
   changeMonth: true,
   changeYear: true,
   buttonImage: "img/gifs/018.gif",
   buttonImageOnly: true,
   autoSize: true,
   dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
   monthNamesShort: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
   dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
   yearRange: "1930:2050",
   minDate:new Date()
  };
    
    $("#fecha_fin_contrato, #fecha_inicio_contrato").datepicker(confDatepicker);

         jQuery(document).on('change', '#fecha_inicio_contrato', (event) => {
        const element = event.target;
        
        jQuery('#fecha_fin_contrato').datepicker('option', 'minDate', element.value);
    });


  });
</script>
