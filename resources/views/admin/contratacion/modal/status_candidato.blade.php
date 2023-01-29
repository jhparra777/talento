<style type="">
    
    .info_empresa{
       
    }
    p span{
        text-decoration: underline;
    }
    th{
        background: rgb(240,240,240);
        font-size: .9em;
    }
    .logo{
        position: absolute;
        right: 0;
    }
</style>

<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
       Orden Contratación
    </h4>
</div>
<div class="modal-body" id="print">
{{--
    <div class="row">
        <div class="col-md-12">
            <h3 class="text-center">
               ORDEN DE COMPRA DE SERVICIOS 
            </h3>
        </div>
        <div class="logo">
             @if(isset(FuncionesGlobales::sitio()->logo))
                        @if(FuncionesGlobales::sitio()->logo != "")
                            <img alt="Logo T3RS" class="izquierda" height="auto" src="{{ url('configuracion_sitio')}}/{!! ((FuncionesGlobales::sitio()->logo)) !!}" width="150">
                        @else
                            <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                        @endif
                    @else
                        <img alt="Logo T3RS" class="izquierda" height="auto" src="{{url('img/logo.png')}}" width="150">
                    @endif
        </div>
    </div>

    <div class="info_empresa row" >
        <div class="col-sm-12">
            <p><strong>Bogotá,{{$fecha_hoy}}</strong></p>
           
            <p>Señores</p>

            <h3>TEMPORIZAR SERVICIOS TEMPORALES S.A.S.</h3>
            <p>Ciudad</p>

            <p>Asunto: Orden de Compra de Servicios para colaboración temporal en desarrollo del Contrato Comercial con fecha de inicio <span>{{$req_can->fecha_inicio}}</span></p>
        </div>
        <div class="col-sm-6">
             <p><strong>EMPRESA USUARIA:</strong><span>{{$req_can->cliente}}</span></p>   
            <p><strong>NIT:</strong>{{$req_can->cliente_nit}}</p>
        </div>
        <div class="col-sm-6">  
             <p>E.S.T.: TEMPORIZAR S.A.S.</p>
             <p><strong>NIT:</strong> 830.055.173 – 3</p>
        </div>
                                                                    
        <div class="col-sm-12">
             <h4>CAUSAL QUE LA ORIGINA:  </h4>      
            <P>Candidatos a contratar:</p>
        </div>
       
    </div>
    <div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>FECHA Y HORA INICIO LABOR</th>
                    <th>LUGAR DE INGRESO Y PERSONA DE CONTACTO</th>
                    <th>APELLIDOS Y NOMBRES</th>
                    <th>DOCUMENTO IDENTIDAD</th>
                    <th>CARGO (Servicio)</th>
                    <th>SALARIO BASICO</th>
                    <th>OTROS DEVENGOS </th>
                    <th> CENTRO DE COSTOS </th>
                    <th>CIUDAD</th>
                    <th>TELÉFONO DEL CANDIDATO</th>
                   <th>FACTOR DE RIESGO</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{$req_can->fecha_inicio}}</td>
                    <td></td>
                    <td>{{$req_can->primer_apellido}} {{$req_can->nombres_candidato}}</td>
                    <td>{{$req_can->cedula}}</td>
                    <td>{{$req_can->cargo}}</td>
                    <td>{{$req_can->salario}}</td>
                    <td>{{$req_can->observaciones}}</td>
                    <td>{{$req_can->centro_costo}}</td>
                    <td>{{$req_can->ciudad}}</td>
                    <td>{{$req_can->movil}}</td>
                    <td>{{$req_can->factor}}</td>
                </tr>
            </tbody>
            

        </table>
        <p>Estos funcionarios en misión son enviados a las dependencias de la empresa usuaria en virtud del servicio específico de colaboración que consta en esta orden de compra de servicios, la cual hace parte integral del contrato comercial celebrado entre la empresa usuaria y la EST.</p>
    </div>

    <div>

        <h4>Representante Empresa Usuaria,</h4>
                                            
        <p>Nombre y Cargo:  {{$req_can->user_autorizacion}}                             

    </div>
  
    --}}

</div>

  
<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        <i class="fa fa-close">
        </i>
        Cerrar
    </button>
   
</div>
