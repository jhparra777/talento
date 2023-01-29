<div class="modal-header">
    <button aria-label="Close" class="close" data-dismiss="modal" type="button">
        <span aria-hidden="true">
            ×
        </span>
    </button>
    <h4 class="modal-title">
       Candidatos otras fuentes
    </h4>
</div>
<div class="modal-body" id="print">
    <div class="row">
        <div class="col-md-12">
            <h3>
                <strong>
                    Candidatos otras fuentes
                </strong>
            </h3>
        </div>

        <table class="table table-striped">
            <tr>
                <th>Cédula</th>
                <td>{{$candidato->numero_id}}</td>
                
            </tr>
             <tr>
                <th>Nombres</th>
                <td>{{$candidato->nombres}}</td>
                
            </tr>
              <tr>
                <th>Primer apellido</th>
                <td> {{$candidato->primer_apellido}}</td>
                
            </tr>
            <tr>
                <th>Primer apellido</th>
                <td> {{$candidato->fecha_nacimiento}}</td>
                
            </tr>
             <tr>
                <th>Teléfono</th>
                <td> {{$candidato->telefono_movil}}</td>
                
            </tr>
             <tr>
                <th>Email</th>
                <td> {{$candidato->email}}</td>
                
            </tr>
             <tr>
                <th>Estado civil</th>
                <td> {{$candidato->estado_civil}}</td>
                
            </tr>
             <tr>
                <th>Estudios</th>
                <td> {{$candidato->estudios}}</td>
                
            </tr>
             <tr>
                <th>Idiomas</th>
                <td> {{$candidato->idiomas}}</td>
                
            </tr>
             <tr>
                <th>Empresa</th>
                <td> {{$candidato->empresa}}</td>
                
            </tr>
             <tr>
                <th>Cargo:</th>
                <td> {{$candidato->cargo}}</td>
                
            </tr>
               <tr>
                <th>Motivación cambio</th>
                <td> {{$candidato->motivo}}</td>
                
            </tr>
             <tr>
                <th>Trayectoria</th>
                <td> {{$candidato->trayectoria}}</td>
                
            </tr>
            <tr>
                <th>Le reporta a:</th>
                <td> {{$candidato->reporta}}</td>
                
            </tr>
            <tr>
                <th>Le reportan:</th>
                <td> {{$candidato->reportan}}</td>
                
            </tr>
            <tr>
                <th>Salario:</th>
                <td> {{$candidato->salario}}</td>
                
            </tr>
            <tr>
                <th>Beneficios:</th>
                <td> {{$candidato->beneficios}}</td>
                
            </tr>
             <tr>
                <th>Aspiración:</th>
                <td> {{$candidato->aspiracion}}</td>
                
            </tr>
        </table>
        
    

      
        
        
</div>
 
<div class="modal-footer">
    <button class="btn btn-default" data-dismiss="modal" type="button">
        <i class="fa fa-close">
        </i>
        Cerrar
    </button>
   
</div>
