<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Enviar a contratación  : <strong>{{$candidato->nombres." ".$candidato->primer_apellido." ".$candidato->segundo_apellido}}</strong> </h4>
</div>
<div class="modal-body">
{!! Form::model(Request::all(),["id"=>"fr_contratar_req"]) !!}
{!! Form::hidden("candidato_req",$candidato->req_candidato,["id"=>"candidato_req_fr"]) !!}
{!! Form::hidden("cliente_id",null) !!}
 
  {{$mensaje}}

  <br>
  <br>
  @if($proceso != null && $proceso->apto == "")
{{--    {!! Form::hidden("aprobar_cliente","true") !!}
  <div class="col-md-12 form-group">
      <label for="inputEmail3" class="col-sm-4 control-label"> Seleccione el usuario quien aprobo este cliente </label>
      <div class="col-sm-8">

        {!!Form::select ("usuario_terminacion",$usuarios_clientes,null,["class"=>"form-control"]);!!}
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("usuario_terminacion",$errors) !!}</p>
  </div>--}}
  @endif

  <h3>Datos de contratación</h3>
   {{-- {{ dd($contra_clientes) }} --}}
   
   @if($contra_clientes != null)
  <div class="col-md-12 form-group">
    <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Ingreso* </label>
     <div class="col-sm-8">
      {!! Form::text ("fecha_inicio_contrato",$contra_clientes->fecha_ingreso_contra,["class"=>"form-control","id"=>"fecha_inicio_contrato"]); !!}
     </div>
     <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_ingreso_contra",$errors) !!}</p>
  </div>

  <div class="col-md-12 form-group">
    <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Retiro* </label>
     <div class="col-sm-8">
      {!! Form::text ("fecha_fin_contrato",$contra_clientes->fecha_fin_contrato,["class"=>"form-control","id"=>"fecha_fin_contrato"]); !!}
     </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato",$errors) !!}</p>
  </div>
  
   <div class="col-md-12 form-group">
      <label for="inputEmail3" class="col-sm-4 control-label"> Centro de costos* </label>
      <div class="col-sm-8">
       {!! Form::select("centro_costos", $centros_costos, (!empty($contra_clientes->centro_costos)) ? $contra_clientes->centro_costos : $requerimiento->centro_costo_id, ["class" => "form-control","id" => "centro_costos"]); !!}
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
  </div>

  <div class="col-md-12 form-group">
   <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones* </label>
    <div class="col-sm-8">
     {!! Form::textarea("observaciones",$contra_clientes->observaciones,["class"=>"form-control","rows"=>'2']); !!}
    </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
  </div>
  
  <div class="col-md-12 form-group">
      @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co")
          <label for="inputEmail3" class="col-sm-4 control-label">Quién autorizó * </label>
      @else
        <label for="inputEmail3" class="col-sm-4 control-label">Quién autorizó por parte del cliente* </label>
      @endif
      <div class="col-sm-8">
       {!! Form::select ("user_autorizacion",$usuarios_clientes,$contra_clientes->user_autorizacion,["class"=>"form-control"]); !!}
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion",$errors) !!}</p>
  </div>
@else

<div class="col-md-12 form-group">
  <label for="inputEmail3" class="col-sm-4 control-label"> Fecha Ingreso* </label>
   <div class="col-sm-8">
    {!! Form::text("fecha_inicio_contrato",null,["class"=>"form-control","id"=>"fecha_inicio_contrato"]); !!}
    </div>
   <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_inicio_contrato",$errors) !!}</p>
</div>

  <div class="col-md-12 form-group">
   <label for="inputEmail3" class="col-sm-4 control-label"> @if(route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000" || route("home")=="http://desarrollo.t3rsc.co" || route("home")=="https://desarrollo.t3rsc.co") Fecha Fin Contrato @else Fecha Retiro @endif * </label>
    <div class="col-sm-8">
     {!! Form::text ("fecha_fin_contrato",null,["class"=>"form-control","id"=>"fecha_fin_contrato"]); !!}
    </div>
   <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fecha_fin_contrato",$errors) !!}</p>
  </div>

   @if(route("home") == "http://demo.t3rsc.co" || route("home") == "https://demo.t3rsc.co" || route("home") == "http://temporizar.t3rsc.co" || route("home") == "https://temporizar.t3rsc.co")
       
          <div class="col-md-12 form-group">
           <label for="inputEmail3" class="col-sm-4 control-label"> Otros devengos:</label>
            <div class="col-sm-8">
             <textarea name="otros_devengos" class="form-control" rows="2" @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") readonly="true" @endif > {{$requerimiento->observaciones}} </textarea>
            </div>
           <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("otros_devengos",$errors) !!}</p>
          </div>            

          <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Lugar contacto:</label>
             <div class="col-sm-8">
              <textarea name="lugar_contacto" class="form-control" rows="2" @if(route("home") == "http://komatsu.t3rsc.co" || route("home") == "https://komatsu.t3rsc.co") readonly="true" @endif > </textarea>
              </div>
              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("lugar_contacto",$errors) !!}</p>
          </div>
          
          <div class="col-md-12 form-group">
           <label for="inputEmail3" class="col-sm-4 control-label"> hora de ingreso:</label>
            <div class="col-sm-8">
             {!! Form::text("hora_ingreso",null,["class"=>"form-control","id"=>"time-inicio"]); !!}
            </div>
           <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso",$errors) !!}</p>
          </div>

  @endif

  @if(route("home")=="http://demo.t3rsc.co" || route("home")=="https://demo.t3rsc.co" || route("home")=="http://localhost:8000" || route("home")=="http://desarrollo.t3rsc.co" || route("home")=="https://desarrollo.t3rsc.co" || route("home")=="https://pruebaslistos.t3rsc.co" || route("home")=="https://listos.t3rsc.co" || route("home")=="https://vym.t3rsc.co")

         <div class="col-md-12 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label"> hora de ingreso:</label>
           <div class="col-sm-8">
            {!! Form::time("hora_ingreso",null,["class"=>"form-control","id"=>"time-inicio"]);!!}
           </div>
          <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("hora_ingreso",$errors) !!}</p>
         </div>
       
         <div class="col-md-12 form-group">
          <label for="inputEmail3" class="col-sm-4 control-label"> Tipo Ingreso:</label>
             
            <div class="col-sm-8">
              <select name="tipo_ingreso" id="tipo_ingreso" class="form-control">
               <option value="1"> Nuevo </option>
               <option value="2"> Reingreso </option>
              </select>
            </div>

          <p class="error text-danger direction-botones-center">  {!! FuncionesGlobales::getErrorData("auxilio_transporte",$errors) !!} </p>
         </div>

          <div style="display: none;" class="col-md-12 form-group" id="fecha_fin_ultimo">
           <label for="inputEmail3" class="col-sm-4 control-label">Fecha fin ultimo contrato:</label>
            <div class="col-sm-8">
             <input type="date" name="fecha_fin_ultimo" value="" class="form-control" >
            </div>
          </div>
      
          <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Auxilio de Transporte: </label>
              <div class="col-sm-8">

                <select name="auxilio_transporte" class="form-control">
                  <option value="No se Paga"> No se paga </option>
                  <option value="Total"> Total </option>
                  <option value="Mitad"> Mitad </option>
                </select>

              </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("auxilio_transporte",$errors) !!}</p>
          </div>

          <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> EPS: </label>

              <div class="col-sm-8">
               {!! Form::select("entidad_eps",$eps,$candidato->entidad_eps,["class"=>"form-control selectcategory","id"=>"entidad_eps"]) !!}
              </div>

              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("eps",$errors) !!}</p>
          </div>

          <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Fondo Pensiones: </label>

              <div class="col-sm-8">
               {!! Form::select("entidad_afp",$afp,$candidato->entidad_afp,["class"=>"form-control selectcategory","id"=>"entidad_afp"]) !!}
              </div>

              <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fondo_pensiones",$errors) !!}</p>
          </div>

          <div class="col-md-12 form-group">

            <label for="inputEmail3" class="col-sm-4 control-label"> Caja de Compensaciones:</label>

              <div class="col-sm-8">

               {!! Form::select("caja_compensacion",$caja_compensaciones,$candidato->caja_compensaciones,["class"=>"form-control selectcategory","id"=>"caja_compensacion"]) !!}
              </div>

             <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("caja_compensacion",$errors) !!}</p>
          </div>

          <div class="col-md-12 form-group">
             <label for="inputEmail3" class="col-sm-4 control-label"> ARL:</label>
              <div class="col-sm-8">
               {!!Form::text("arl",'Colpatria',["class"=>"form-control","id"=>"arl","readonly"=>"readonly"]);!!}
              </div>

            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("caja_compensacion",$errors) !!}</p>
          </div>
          
          <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Fondo De Cesantias:</label>

              <div class="col-sm-8">
               {!! Form::select("fondo_cesantias",$fondo_cesantias,$candidato->fondo_cesantias,["class"=>"form-control selectcategory","id"=>"fondo_cesantias"]) !!}
              </div>
              
             <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("fondo_cesantias",$errors) !!}</p>

          </div>

          <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Nombre del Banco:</label>
              <div class="col-sm-8">
               {!!Form::select("nombre_banco",$bancos,$candidato->nombre_banco,["class"=>"form-control selectcategory","id"=>"nombre_banco"])!!}
              </div>
            
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("nombre_banco",$errors) !!}</p>
          </div>

          <div class="col-md-12 form-group">
             <label for="inputEmail3" class="col-sm-4 control-label"> Tipo Cuenta:</label>
              <div class="col-sm-8">
                <select name="tipo_cuenta" class="form-control">
                 <option value="Ahorro"> Ahorro </option>
                 <option value="Corriente"> Corriente </option>
                </select>
              </div>
              
            <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("tipo_cuenta",$errors) !!}</p>
          </div>

          <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Numero Cuenta:</label>

              <div class="col-sm-8">
               <input type="number" name="numero_cuenta" class="form-control solo-numero" id="numero_cuenta" value="{{$candidato->numero_cuenta}}">
              </div>
              
               <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta",$errors) !!}</p>
          </div>

          <div class="col-md-12 form-group">
            <label for="inputEmail3" class="col-sm-4 control-label"> Confirmar Cuenta:</label>

             <div class="col-sm-8">
              <input type="number" name="confirm_numero_cuenta" class="form-control solo-numero" id="confirm_numero_cuenta">
             </div>
              
             <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("numero_cuenta",$errors) !!}</p>
          </div>
                    
      @endif

  <div class="col-md-12 form-group">
    <label for="inputEmail3" class="col-sm-4 control-label"> Centro de costos* </label>
      <div class="col-sm-8">
        {!! Form::select("centro_costos", $centros_costos, $requerimiento->centro_costo_id, ["class" => "form-control","id" => "centro_costos"]); !!}
      </div>
    <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
  </div>
 
  <div class="col-md-12 form-group">
   <label for="inputEmail3" class="col-sm-4 control-label"> Observaciones* </label>
    <div class="col-sm-8">
      {!! Form::textarea("observaciones",null,["class"=>"form-control","rows"=>'2']);!!}
    </div>
   <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("observaciones",$errors) !!}</p>
  </div>
  <div class="col-md-12 form-group">
      <label for="inputEmail3" class="col-sm-4 control-label">Quién autorizó por parte del cliente* </label>
      <div class="col-sm-8">

          {!! Form::select ("user_autorizacion",$usuarios_clientes,$user_id,["class"=>"form-control"]); !!}
      </div>
      <p class="error text-danger direction-botones-center">{!! FuncionesGlobales::getErrorData("user_autorizacion",$errors) !!}</p>
  </div>
@endif

{!! Form::close() !!}

<div class="clearfix"></div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
<button type="button" class="btn btn-success" id="confirmar_contratacion" >Confirmar</button>
</div>
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
<script type="text/javascript">

</script>
